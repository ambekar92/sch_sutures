<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/* ------------Reasons DB Operation --------------------- */



if(isset($_POST['getmachine_no'])){

    $eqQ="Select mach_desc from tb_m_machine";
    
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
        $mach_num=$row['mach_desc'];
               
        $getmach_no[]=array($mach_num);

    }
   

  // echo "<pre>"; print_r($getmach_no);  die();
    
    $status['machine_no'] = $getmach_no;
    echo json_encode($status);
    mysqli_close($con);
}
?>



