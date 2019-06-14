<?php 
    require '../common/db.php';
    //require '../common/commonFunctions.php';
    //require '../common/session.php';



//Insert Data Function
function mysqli_insert_array($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            
            if($data[$key] == 'NULL'){
                $values[] =$data[$key];
            }else{
                $values[] ="'" .$data[$key]. "'";
            }
            
            //$values[] = "'" .$data[$key]. "'";
        }
    }
    $fields = implode(",", $fields);
    $values = implode(",", $values);
    
    $sql="INSERT INTO `$table` ($fields) VALUES ($values) ";
    return $sql;
}


//Update Data Function
function mysqli_update_array($table, $data, $exclude = array(),$cond) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            
            if($data[$key] == 'NULL'){
                $dataA[]=$key."=".$data[$key];
            }else{
                $dataA[]=$key."='" .$data[$key]. "'";
            }
        }
    }
    $dataA = implode(",", $dataA);
    
    $updateSql = "UPDATE $table SET $dataA where $cond";
    return $updateSql;
}    

/* ------------Reasons DB Operation --------------------- */

$data = json_decode(file_get_contents('php://input'), true);

//Save Reasons
if(isset($data['saveReason'])){
    $reasons=implode(",",$data['reasons']);
    $remarks=$data['remarks'];
    $seletedDateRec=$data['seletedDateRec'];
    $seletedWcRec=$data['seletedWcRec'];

    $getOrderNum ='SELECT prod_reas_descp FROM tb_m_prod_reason where prod_reas_code IN ('.$reasons.')';
    $resOrderNum=mysqli_query($con,$getOrderNum) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($resOrderNum)){
        $prod_reas_descp[]=$row['prod_reas_descp'];
    }  

    $table = 'tb_t_prod_dash_h';
    $dataUpdate=array(           
        'reasons'=>implode(",",$prod_reas_descp),
        'remarks'=>$remarks
    );

    //print_r( $DataMarge_prod_dash_h);
    $cond=' date_ ="'.$seletedDateRec.'" and work_ctr_code="'.$seletedWcRec.'"';
    $update_sql = mysqli_update_array($table,$dataUpdate,"submit",$cond);
    $result1=mysqli_query($con,$update_sql); 

    $status['status'] = 1;
    echo json_encode($status);
    mysqli_close($con);


}
