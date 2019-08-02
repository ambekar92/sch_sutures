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

    $seletedDateRec=$data['seletedDateRec'];
    $seletedWcRec=$data['seletedWcRec'];
    $start_time=$data['start_time'];
    $end_time=$data['end_time'];
    $reasons=$data['reasons'];
    $remarks=$data['remarks'];

    
    $table_up = 'tb_t_prod_dash_h';
    $dataUpdate=array(           
        'reasons'=>1,
        'remarks'=>1
    );
    $cond=' date_ ="'.$seletedDateRec.'" and work_ctr_code="'.$seletedWcRec.'"';
    $update_sql = mysqli_update_array($table_up,$dataUpdate,"submit",$cond);
    $result1=mysqli_query($con,$update_sql); 

    $table_insrt = 'tb_t_reason_entry';
    $datainsert=array(   
        'date_'=> $seletedDateRec,
        'wrk_ctr_code'=> $seletedWcRec,  
        'reason_code'=>$reasons,
        'start_time'=>$start_time,
        'end_time'=>$end_time,
        'remarks'=>$remarks        
    );
    
    $insert_sql = mysqli_insert_array($table_insrt,$datainsert,"submit");
    $result2=mysqli_query($con,$insert_sql); 

    if($result1 &&  $result2 ){
        $status['status'] = 1;
    }else{
        $status['status'] = 0;
    }
    // $status['status'] = 1;
    echo json_encode($status);
    mysqli_close($con);
}


if(isset($data['fetchReasons'])){  // same function use for VIEW reasons

    $seletedDateRec=$data['seletedDateRec'];
    $seletedWcRec=$data['seletedWcRec'];
  
    $show_deatils ="SELECT wrk_ctr_code,prod_reas_descp,start_time,end_time,remarks FROM tb_t_reason_entry
                    join tb_m_prod_reason on tb_t_reason_entry.reason_code = tb_m_prod_reason.prod_reas_code 
                    where date_ = '$seletedDateRec' and wrk_ctr_code = '$seletedWcRec'";
    $resOrderNum=mysqli_query($con,$show_deatils) or die('Error:'.mysqli_error($con));

    while ($row=mysqli_fetch_array($resOrderNum)){
                $reason_desc=$row['prod_reas_descp'];
                $start_time=$row['start_time'];
                $end_time=$row['end_time'];
                $remarks=$row['remarks'];
                $wrk_ctr_code=$row['wrk_ctr_code'];
               
                $show_deatils_table[]=array(
                'wrk_ctr_code' =>$wrk_ctr_code,
                'reason_code' =>$reason_desc,
                'start_time' =>$start_time,
                'end_time' =>$end_time,
                'remarks' =>$remarks,
                );
                
           }  

       $result['body'] = $show_deatils_table;
        //echo   $result;
        echo json_encode($result);
        mysqli_close($con);

        }