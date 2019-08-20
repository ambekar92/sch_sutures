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

//print_r($data);
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

if(isset($data['loadData'])){ 

    $final_date=$data['final_date'];

    $sql="select date_,monthly_man_hours from tb_t_prod_dash_i where date_='".$final_date."'";

    $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes)){
        $date_=$row['date_']; 
        $monthly_man_hours=$row['monthly_man_hours'];
    }


    fillActualData($final_date);
    fillStockData($final_date);
    monthlyProduction($final_date,$monthly_man_hours);


}



function fillActualData($date){

    //echo $date;
    
    require '../common/db.php';

    $sql="SELECT W.wrk_ctr_desc,W.wrk_ctr_code, ifnull(C.regular_RB,0) as regular_RB ,ifnull(D.regular_CT,0) as regular_CT,ifnull(A.urgent_RB,0)as urgent_RB ,ifnull(B.urgent_CT,0) as urgent_CT FROM tb_o_workcenter  W
    LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE date(jct.updated_at) = '".$date."' 
    group by jct.present_dept) A on A.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,jct.present_dept,jct.updated_at from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE date(jct.updated_at) =  '".$date."' 
    group by jct.present_dept) B on B.present_dept = W.wrk_ctr_code and  B.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE date(jct.updated_at) =  '".$date."' 
    group by jct.present_dept) C on C.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE date(jct.updated_at) =  '".$date."' 
    group by jct.present_dept) D on D.present_dept = W.wrk_ctr_code
    group by W.wrk_ctr_code";

    $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes)){
        $wrk_ctr_code=$row['wrk_ctr_code'];
        $actual_card_regular_rb=$row['regular_RB'];
        $actual_card_regular_ct=$row['regular_CT'];
        $actual_card_urgent_rb=$row['urgent_RB'];
        $actual_card_urgent_ct=$row['urgent_CT'];

        $table_prod_dash_h = 'tb_t_prod_dash_h';
        $DataMarge_prod_dash_h=array(           
            'actual_card_regular_rb'=>$actual_card_regular_rb,
            'actual_card_regular_ct'=>$actual_card_regular_ct,
            'actual_card_urgent_rb'=>$actual_card_urgent_rb,
            'actual_card_urgent_ct'=>$actual_card_urgent_ct,
        );

        //print_r( $DataMarge_prod_dash_h);
        $cond=' work_ctr_code ="'.$wrk_ctr_code.'" and date_="'.$date.'"';
         $update_sql = mysqli_update_array($table_prod_dash_h,$DataMarge_prod_dash_h,"submit",$cond);
        $result1=mysqli_query($con,$update_sql); 
    }  
}




function fillStockData($date){
    
    require '../common/db.php';
    
    $sql="SELECT W.wrk_ctr_desc,W.wrk_ctr_code, ifnull(C.regular_RB,0) as regular_RB ,ifnull(D.regular_CT,0) as regular_CT,ifnull(A.urgent_RB,0)as urgent_RB ,ifnull(B.urgent_CT,0) as urgent_CT  FROM tb_o_workcenter  W
LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,jct.to_dept  from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 1
join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB'
join tb_t_job_card_trans jc on jc.batch_no = jct.batch_no and jc.present_dept = jct.to_dept
where jc.oper_status is null group by jct.to_dept) A on A.to_dept = W.wrk_ctr_code
LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,jct.to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 1
join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT'
join tb_t_job_card_trans jc on jc.batch_no = jct.batch_no and jc.present_dept = jct.to_dept
where jc.oper_status is null group by jct.to_dept) B on B.to_dept = W.wrk_ctr_code
LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,jct.to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 0
join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB'
join tb_t_job_card_trans jc on jc.batch_no = jct.batch_no and jc.present_dept = jct.to_dept
where jc.oper_status is null group by jct.to_dept) C on C.to_dept = W.wrk_ctr_code
LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,jct.to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 0
join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT'
join tb_t_job_card_trans jc on jc.batch_no = jct.batch_no and jc.present_dept = jct.to_dept
where jc.oper_status is null group by jct.to_dept) D on D.to_dept = W.wrk_ctr_code
group by W.wrk_ctr_code";

        $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($sqlRes)){
            $wrk_ctr_code=$row['wrk_ctr_code'];
            $card_stock_regular_rb=$row['regular_RB'];
            $card_stock_regular_ct=$row['regular_CT'];
            $card_stock_urgent_rb=$row['urgent_RB'];
            $card_stock_urgent_ct=$row['urgent_CT'];
    
            $table_prod_dash_h = 'tb_t_prod_dash_h';
            $DataMarge_prod_dash_h=array(           
                'card_stock_regular_rb'=>$card_stock_regular_rb,
                'card_stock_regular_ct'=>$card_stock_regular_ct,
                'card_stock_urgent_rb'=>$card_stock_urgent_rb,
                'card_stock_urgent_ct'=>$card_stock_urgent_ct,
            );
    
            //print_r( $DataMarge_prod_dash_h);
            $cond=' work_ctr_code ="'.$wrk_ctr_code.'" and date_="'.$date.'"';
            $update_sql = mysqli_update_array($table_prod_dash_h,$DataMarge_prod_dash_h,"submit",$cond);
            $result1=mysqli_query($con,$update_sql); 
    }  
}



function monthlyProduction($date,$monthly_man_hoursDB){

    require '../common/db.php';
    require '../common/env_variables.php';

//echo $pd_work_ctr_code;

    $sql="select SUM(pi.qty) as output_qty,SUM(jb.ord_qty) as input_qty from tb_t_prod_i pi join tb_m_jobcard jb on jb.batch_no = pi.batch_no where pi.qlty_code = 620 and pi.wrk_ctr_code = '".$pd_work_ctr_code."' and date(pi.updated_at) between DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."'";

    $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes)){
        $totalInputQty=$row['input_qty']; 
        $totalOkQty=$row['output_qty'];
    }

    $monthly_production = ($totalOkQty/12);  

    $table_prod_dash_i = 'tb_t_prod_dash_i';
    $DataMarge_prod_dash_i=array(           
        'monthly_production'=>round($monthly_production,3),
        'monthly_yield'=>round((( $totalOkQty / $totalInputQty) * 100), 3) ,
        'monthly_productivity'=>round( (($totalOkQty/12) / $monthly_man_hoursDB), 2)
    );
	
	//print_r($DataMarge_prod_dash_i);

    $cond=' date_ ="'.$date.'"';
    $update_sql = mysqli_update_array($table_prod_dash_i,$DataMarge_prod_dash_i,"submit",$cond);
    $result1=mysqli_query($con,$update_sql); 

}