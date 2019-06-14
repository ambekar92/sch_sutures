<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/* ------------Reasons DB Operation --------------------- */



if(isset($_POST['getjobcard_no'])){

    $eqQ="select batch_no from tb_m_jobcard order by batch_no DESC";
    
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
        $batch_num=$row['batch_no'];
               
        $getbatch_no[]=array($batch_num);

    }

   //echo "<pre>"; print_r($getbatch_no);  die();
    
    $status['batch_no_de'] = $getbatch_no;
    echo json_encode($status);
    mysqli_close($con);
}
?>



