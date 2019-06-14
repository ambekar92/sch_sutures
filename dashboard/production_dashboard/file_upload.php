<?php

/*
Header : (Optional)
Key = enctype  
value = multipart/form-data

Filename: fg_file 

*/

require '../common/db.php';

$set_date ='';
$last_month_man_hoursDB ='';
$monthly_man_hoursDB = '';

$user=$_POST['user'];

 $filename=$_FILES["fg_file"]["tmp_name"];

 if($_FILES["fg_file"]["size"] > 0)
 {

  	$file = fopen($filename, "r");
	$count = 0;
	 while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE)
	 {
        // First if Starts 
        if ($count > 0) {

            $selDate= explode(".",$rowData[0]); // dd.mm.yyyy
            $dbDate= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];
            $set_date= $dbDate;

            $check_sql='SELECT * FROM tb_t_prod_dash_h WHERE date_="'.$dbDate.'" and work_ctr_code ="'. $rowData[1].'"
             GROUP BY date_ HAVING ( COUNT(date_) > 0 )'; 		
            $chk_duplicate = mysqli_query($con,$check_sql);

            // Inner if Starts
            if(mysqli_num_rows($chk_duplicate) > 0){

                $date_ = $dbDate;
                $work_ctr_code = $rowData[1];
                $process = $rowData[2];
                $daily_target =$rowData[3];
                $man_power = $rowData[4];
                $today_plan = $rowData[5];
                $planed_man_power = $rowData[6];

                $table = 'tb_t_prod_dash_h';
                $DataMarge=array(      
                    'daily_target'=>$daily_target,
                    'man_power'=>$man_power,
                    'today_plan'=>$today_plan,            
                    'planed_man_power'=>$planed_man_power
                );


                $status = $rowData[7];
                $last_month_man_hours = $rowData[8];
                $last_month_absenttism = $rowData[9];
                $last_month_ot = $rowData[10];
                $monthly_man_hours = $rowData[11];
                $monthly_absenttism = $rowData[12];
                $monthly_ot = $rowData[13];    


                $table_prod_dash_i = 'tb_t_prod_dash_i';
                $DataMarge_prod_dash_i=array(           
                    'status'=>$status,
                    'last_month_man_hours'=>$last_month_man_hours,
                    'last_month_absenttism'=>$last_month_absenttism,
                    'last_month_ot'=>$last_month_ot,
                    'monthly_man_hours'=>$monthly_man_hours,            
                    'monthly_absenttism'=>$monthly_absenttism,
                    'monthly_ot'=>$monthly_ot
                );

                $cond=' date_ ="'.$date_.'" and work_ctr_code ='.$work_ctr_code;
                $cond1=' date_ ="'.$date_.'"';

                $update_sql = mysqli_update_array($table,$DataMarge,"submit",$cond);

                if( $status != ''){

                    $last_month_man_hoursDB = $last_month_man_hours;
                    $monthly_man_hoursDB = $monthly_man_hours;

                    $update_sql1 = mysqli_update_array($table_prod_dash_i,$DataMarge_prod_dash_i,"submit",$cond1);
                    $update_result1 = mysqli_query($con,$update_sql1);
                }

                $update_result = mysqli_query($con,$update_sql);

                $status = 1;
                $res_stat="File Updated Successfully.";

            }else{

                //It will insert a row to our subject table from our csv file
                $date_ = $dbDate;
                $work_ctr_code = $rowData[1];
                $process = $rowData[2];
                $daily_target =$rowData[3];
                $man_power = $rowData[4];
                $today_plan = $rowData[5];
                $planed_man_power = $rowData[6];

                $table = 'tb_t_prod_dash_h';
                $DataMarge=array('date_'=>$date_,           
                    'work_ctr_code'=>$work_ctr_code,
                    'process'=>$process,
                    'daily_target'=>$daily_target,
                    'man_power'=>$man_power,
                    'today_plan'=>$today_plan,            
                    'planed_man_power'=>$planed_man_power
                );

                $status = $rowData[7];
                $last_month_man_hours = $rowData[8];
                $last_month_absenttism = $rowData[9];
                $last_month_ot = $rowData[10];
                $monthly_man_hours = $rowData[11];
                $monthly_absenttism = $rowData[12];
                $monthly_ot = $rowData[13];       

                               
                $table_prod_dash_i = 'tb_t_prod_dash_i';
                $DataMarge_prod_dash_i=array('date_'=>$date_,           
                    'status'=>$status,
                    'last_month_man_hours'=>$last_month_man_hours,
                    'last_month_absenttism'=>$last_month_absenttism,
                    'last_month_ot'=>$last_month_ot,
                    'monthly_man_hours'=>$monthly_man_hours,            
                    'monthly_absenttism'=>$monthly_absenttism,
                    'monthly_ot'=>$monthly_ot
                );

                // Function say generate complete query
                $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); 
                $result=mysqli_query($con,$sqlQuery);

                if( $status != ''){
                    $last_month_man_hoursDB = $last_month_man_hours;
                    $monthly_man_hoursDB = $monthly_man_hours;

                    $sqlQuery1 = mysqli_insert_array($table_prod_dash_i, $DataMarge_prod_dash_i, "submit"); 
                    $result1=mysqli_query($con,$sqlQuery1);    
                }

                    $status = 1;
                    $res_stat="File Successfully Uploaded.";
  	
            }// Inner if ENDS
                
        } // First if ENDS		

        $count++;	

    } // END of while

    fillActualData($GLOBALS['set_date']);
    fillStockData($GLOBALS['set_date']);
    monthlyProduction($GLOBALS['set_date'],$GLOBALS['monthly_man_hoursDB']);
    lastMonthProduction($GLOBALS['set_date'],$GLOBALS['last_month_man_hoursDB']);
    
	fclose($file);

}// File Check if ENDS 
else {
	$status =0;
	$res_stat = "Please Try Again Letter.";
}

    $resp['resp'] = $status;
    $resp['msg'] = $res_stat;
    echo json_encode($resp,true);       


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


function fillActualData($date){

    //echo $date;
    
    require '../common/db.php';

    $sql="SELECT W.wrk_ctr_desc,W.wrk_ctr_code, ifnull(C.regular_RB,0) as regular_RB ,ifnull(D.regular_CT,0) as regular_CT,ifnull(A.urgent_RB,0)as urgent_RB ,ifnull(B.urgent_CT,0) as urgent_CT FROM tb_o_workcenter  W
    LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )
    group by jct.present_dept) A on A.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,jct.present_dept,jct.updated_at from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 1 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )
    group by jct.present_dept) B on B.present_dept = W.wrk_ctr_code and  B.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )
    group by jct.present_dept) C on C.present_dept = W.wrk_ctr_code
    LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,jct.present_dept from tb_m_jobcard join tb_t_job_card_trans jct on jct.batch_no = tb_m_jobcard.batch_no  and jct.oper_status = '807' and tb_m_jobcard.urgent = 0 and jct.status_code = 803
    join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )
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
    
        // $sql="SELECT W.wrk_ctr_desc,W.wrk_ctr_code, ifnull(C.regular_RB,0) as regular_RB ,ifnull(D.regular_CT,0) as regular_CT,ifnull(A.urgent_RB,0)as urgent_RB ,ifnull(B.urgent_CT,0) as urgent_CT  FROM tb_o_workcenter  W
        // LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 1
        // join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )group by jct.to_dept) A on A.to_dept = W.wrk_ctr_code
        // LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 1
        // join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )group by jct.to_dept) B on B.to_dept = W.wrk_ctr_code
        // LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 0
        // join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )group by jct.to_dept) C on C.to_dept = W.wrk_ctr_code
        // LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 0
        // join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' WHERE (date(jct.updated_at) between  DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."' )group by jct.to_dept) D on D.to_dept = W.wrk_ctr_code
        // group by W.wrk_ctr_code";
        $sql="SELECT W.wrk_ctr_desc,W.wrk_ctr_code, ifnull(C.regular_RB,0) as regular_RB ,ifnull(D.regular_CT,0) as regular_CT,ifnull(A.urgent_RB,0)as urgent_RB ,ifnull(B.urgent_CT,0) as urgent_CT  FROM tb_o_workcenter  W
        LEFT OUTER JOIN(select count(jct.batch_no) as urgent_RB,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 1
        join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' group by jct.to_dept) A on A.to_dept = W.wrk_ctr_code
        LEFT OUTER JOIN(select count(jct.batch_no) as urgent_CT,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 1
        join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' group by jct.to_dept) B on B.to_dept = W.wrk_ctr_code
        LEFT OUTER JOIN(select count(jct.batch_no) as regular_RB,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no  and tb_m_jobcard.urgent = 0
        join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and  tb_m_fg.type = 'RB' group by jct.to_dept) C on C.to_dept = W.wrk_ctr_code
        LEFT OUTER JOIN(select count(jct.batch_no) as regular_CT,ifnull(jct.to_dept,103021)as to_dept from tb_m_jobcard join tb_t_job_status jct on jct.batch_no = tb_m_jobcard.batch_no   and tb_m_jobcard.urgent = 0
        join tb_m_fg on tb_m_jobcard.fg_code = tb_m_fg.fg_code and tb_m_fg.type = 'CT' group by jct.to_dept) D on D.to_dept = W.wrk_ctr_code
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

    //Total Input Qty
    $sql="select SUM(pi.qty) as output_qty,SUM(jb.ord_qty) as input_qty from tb_t_prod_i pi join tb_m_jobcard jb on jb.batch_no = pi.batch_no where pi.qlty_code = 620 and pi.wrk_ctr_code = 103021 and date(pi.updated_at) between DATE_FORMAT('".$date."' ,'%Y-%m-01') AND '".$date."'";

    $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes)){
        $totalInputQty=$row['input_qty']; 
        $totalOkQty=$row['output_qty'];
    }


    //$monthly_production = round((( $totalOkQty / $totalInputQty) * 100), 3);  
    $monthly_production = ($totalOkQty/12);  

    $table_prod_dash_i = 'tb_t_prod_dash_i';
    $DataMarge_prod_dash_i=array(           
        'monthly_production'=>round($monthly_production,3),
        'monthly_yield'=>round((( $totalOkQty / $totalInputQty) * 100), 3) ,
        'monthly_productivity'=>round( (($totalOkQty/12) / $monthly_man_hoursDB), 2)
    );

    $cond=' date_ ="'.$date.'"';
    $update_sql = mysqli_update_array($table_prod_dash_i,$DataMarge_prod_dash_i,"submit",$cond);
    $result1=mysqli_query($con,$update_sql); 

}



function lastMonthProduction($date,$last_month_man_hoursDB){

    require '../common/db.php';

    //Total Input Qty
    $sql="select SUM(pi.qty) as output_qty,SUM(jb.ord_qty) as input_qty from tb_t_prod_i pi join tb_m_jobcard jb on jb.batch_no = pi.batch_no where pi.qlty_code = 620 and pi.wrk_ctr_code = 103021 and YEAR(pi.updated_at) = YEAR('".$date."' - INTERVAL 1 MONTH) AND MONTH(pi.updated_at) = MONTH('".$date."' - INTERVAL 1 MONTH)";

    $sqlRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes)){
        $totalInputQty=$row['input_qty']; 
        $totalOkQty=$row['output_qty'];
    }

  
    //$last_month_production = round((( $totalOkQty / $totalInputQty) * 100), 2);  
    $last_month_production = ($totalOkQty/12);  

    $table_prod_dash_i = 'tb_t_prod_dash_i';
    $DataMarge_prod_dash_i=array(           
        'last_month_production'=>round($last_month_production,3),
        'last_month_yield'=>round((( $totalOkQty / $totalInputQty) * 100), 3) ,
        'last_month_productivity'=>round( (($totalOkQty/12) / $last_month_man_hoursDB), 2)
    );

    $cond=' date_ ="'.$date.'"';
    $update_sql = mysqli_update_array($table_prod_dash_i,$DataMarge_prod_dash_i,"submit",$cond);
    $result1=mysqli_query($con,$update_sql); 

}





?>