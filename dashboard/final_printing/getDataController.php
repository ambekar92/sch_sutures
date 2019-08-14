<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require '../common/db.php';
    //require '../common/commonFunctions.php';
    //require '../common/session.php';

//Insert Data Function
// function mysqli_insert_array($table, $data, $exclude = array()) {
//     $fields = $values = array();
//     if( !is_array($exclude) ) $exclude = array($exclude);
//     foreach( array_keys($data) as $key ) {
//         if( !in_array($key, $exclude) ) {
//             $fields[] = "`$key`";
            
//             if($data[$key] == 'NULL'){
//                 $values[] =$data[$key];
//             }else{
//                 $values[] ="'" .$data[$key]. "'";
//             }
            
//             //$values[] = "'" .$data[$key]. "'";
//         }
//     }
//     $fields = implode(",", $fields);
//     $values = implode(",", $values);
    
//     $sql="INSERT INTO `$table` ($fields) VALUES ($values) ";
//     return $sql;
// }


// //Update Data Function
// function mysqli_update_array($table, $data, $exclude = array(),$cond) {
//     $fields = $values = array();
//     if( !is_array($exclude) ) $exclude = array($exclude);
//     foreach( array_keys($data) as $key ) {
//         if( !in_array($key, $exclude) ) {
            
//             if($data[$key] == 'NULL'){
//                 $dataA[]=$key."=".$data[$key];
//             }else{
//                 $dataA[]=$key."='" .$data[$key]. "'";
//             }
//         }
//     }
//     $dataA = implode(",", $dataA);
    
//     $updateSql = "UPDATE $table SET $dataA where $cond";
//     return $updateSql;
// }    

/* ------------Reasons DB Operation --------------------- */

// $data = json_decode(file_get_contents('php://input'), true);

//Save Reasons
// if(isset($data['saveReason'])){
//     $reasons=implode(",",$data['reasons']);
//     $remarks=$data['remarks'];
//     $seletedDateRec=$data['seletedDateRec'];
//     $seletedWcRec=$data['seletedWcRec'];

//     $getOrderNum ='SELECT prod_reas_descp FROM tb_m_prod_reason where prod_reas_code IN ('.$reasons.')';
//     $resOrderNum=mysqli_query($con,$getOrderNum) or die('Error:'.mysqli_error($con));
//     while ($row=mysqli_fetch_array($resOrderNum)){
//         $prod_reas_descp[]=$row['prod_reas_descp'];
//     }  

//     $table = 'tb_t_prod_dash_h';
//     $dataUpdate=array(           
//         'reasons'=>implode(",",$prod_reas_descp),
//         'remarks'=>$remarks
//     );

//     //print_r( $DataMarge_prod_dash_h);
//     $cond=' date_ ="'.$seletedDateRec.'" and work_ctr_code="'.$seletedWcRec.'"';
//     $update_sql = mysqli_update_array($table,$dataUpdate,"submit",$cond);
//     $result1=mysqli_query($con,$update_sql); 

//     $status['status'] = 1;
//     echo json_encode($status);
//     mysqli_close($con);
// }

// $data = json_decode(file_get_contents('php://input'), true);


    if(isset($_POST['updateStatus'])){
       // echo "working";
       $batch=$_POST['batch'];

       $update_status = "UPDATE `tb_t_job_status` SET print_status=1   WHERE `batch_no` LIKE '%".$batch."%'";
       $update_status_con=mysqli_query($con,$update_status) or die('Error:'.mysqli_error($con));

       $update_status1 = "UPDATE `tb_t_job_status` SET print_count=print_count + 1   WHERE `batch_no` LIKE '%".$batch."%'";
       $update_status_con1=mysqli_query($con,$update_status1) or die('Error:'.mysqli_error($con));

    //    while ($row=mysqli_fetch_array($update_status_con)){
    //     $batch_no=$row['batch_no'];
    //     $from_dept=$row['from_dept'];
    //     $from_dept_desc=$row['from_dept_desc'];
    //     $from_mach=$row['from_mach'];

    //     $update_status_details[]=array('batch' =>$batch,
    //     'batch_no' =>$batch_no,
    //     'from_dept' =>$from_dept,
    //     'from_dept_desc' =>$from_dept_desc,
    //     'from_mach' =>$from_mach,
    //     );
    // }  

    if(!$update_status_con){
        $update_status_details=1;
    }else{
        $update_status_details=0;
    }

    $statusUpdate['update_status_details'] = $update_status_details;

    echo json_encode($statusUpdate);
    mysqli_close($con);
    }



    if(isset($_POST['getlastdept'])){

    $wrk_ctr_code=$_POST['wrk_ctr_code'];
        
           $last_dept ="SELECT a.wrk_ctr_code,tb_t_job_card_trans.batch_no,tb_m_jobcard.fg_code,tb_m_fg.series,tb_m_jobcard.cust_name,tb_m_jobcard.Siliconize,tb_m_jobcard.true_pass,tb_m_jobcard.plan,tb_m_jobcard.req_date,if(tb_m_jobcard.urgent = 0,'REGULAR','URGENT')as type,a.qty as ok_qty,ifnull(sum(b.qty),0)as reject_qty,  date_format(tb_t_job_card_trans.updated_at,'%d-%m-%Y %H:%i:%s')as updated_at,tb_t_job_status.print_status,tb_t_job_status.print_count FROM tb_t_job_card_trans
           join tb_m_jobcard on tb_t_job_card_trans.batch_no = tb_m_jobcard.batch_no
           join(SELECT ph.mach_code, ph.batch_no, pi.qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM tb_t_prod_h ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=500 ) a on a.batch_no = tb_t_job_card_trans.batch_no and     tb_t_job_card_trans.present_mach=a.mach_code
           left OUTER join(SELECT ph.mach_code, ph.batch_no, pi.qty, ph.emp_id, ph.created_at,ph.wrk_ctr_code FROM tb_t_prod_h ph JOIN tb_t_prod_i pi ON pi.batch_no=ph.batch_no AND pi.sl_no=ph.sl_no AND ph.qlty_type_code=502 ) b on b.batch_no = tb_t_job_card_trans.batch_no and tb_t_job_card_trans.present_mach=b.mach_code
           join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code
           join tb_t_job_status on tb_t_job_card_trans.batch_no = tb_t_job_status.batch_no
            where present_dept = '$wrk_ctr_code' and tb_t_job_card_trans.status_code = 803 and tb_t_job_card_trans.oper_status = 807 GROUP by batch_no order by tb_t_job_card_trans.updated_at DESC";

            $last_dept_item=mysqli_query($con,$last_dept) or die('Error:'.mysqli_error($con));

            while ($row=mysqli_fetch_array($last_dept_item)){
                $wrk_ctr_code=$row['wrk_ctr_code'];
                $batch_no=$row['batch_no'];
                $fg_code=$row['fg_code'];
                $series=$row['series'];
                $cust_name=$row['cust_name'];
                $plan=$row['plan'];
                $req_date=$row['req_date'];
                $type=$row['type'];
                $ok_qty=$row['ok_qty'];
                $reject_qty=$row['reject_qty'];
                $updated_at=$row['updated_at'];
                $Siliconize=$row['Siliconize'];
                $true_pass=$row['true_pass'];
                $series=$row['series'];
                $print_status=$row['print_status'];
                $print_count=$row['print_count'];

                $last_dept_details[]=array('wrk_ctr_code' =>$wrk_ctr_code,
                'batch_no' =>$batch_no,
                'fg_code' =>$fg_code,
                'series' =>$series,
                'cust_name' =>$cust_name,
                'plan' =>$plan,
                'req_date' =>$req_date,
                'type' =>$type,
                'ok_qty' =>$ok_qty,
                'reject_qty' =>$reject_qty,
                'updated_at' =>$updated_at,
                'Siliconize' =>$Siliconize,
                'true_pass' =>$true_pass,
                'series' =>$series,
                'print_status' =>$print_status,
                'print_count' =>$print_count
                );
            }  

            $status['last_dept_details'] = $last_dept_details;
    
            echo json_encode($status);
            mysqli_close($con);
        }

