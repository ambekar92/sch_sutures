<?php 
    require 'db.php';
    require 'commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['userDetails'])){

    $userMail=$_POST['userMail']; 
    $tokenPass=$_POST['token']; 

    //$eqQ="SELECT sc.code as code,su.first_name as first_name,su.last_name as last_name, su.email_id as email_id, su.contact_number as contact_number, su.img_file_name as img_file_name, su.roles_id as roles_id,sr.name as rolename, sr.company_id as company_id, sr.plant_id as plant_id ,sr.screen_access as screen_access, sr.access_rights as access_rights,sc.descp as compName,sc.image_file_name as compImg  from sfs_user su, sfs_roles sr, sfs_company sc where su.roles_id=sr.id and sr.company_id = sc.id and su.email_id='".$userMail."'";

    
    $eqQ="SELECT e.emp_id,e.role_code,e.frst_name,e.designation,p.plnt_code,p.plnt_s_desc,p.plnt_desc, c.comp_code,c.comp_desc  FROM tb_m_employee e, tb_o_plant p,tb_o_company c 
            WHERE e.card_id='".$userMail."' and e.password='".$tokenPass."' 
            and e.plnt_code=p.plnt_code and p.comp_code=c.comp_code";

    $userDetailRes=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
   //echo $eqQ;
    while ($row=mysqli_fetch_array($userDetailRes)){
        $emp_id = $row['emp_id'];
        $role_code = $row['role_code'];
        $frst_name = $row['frst_name'];
        $designation = $row['designation'];
        $plnt_code = $row['plnt_code'];
        $plnt_s_desc = $row['plnt_s_desc'];
        $plnt_desc = $row['plnt_desc'];
        $comp_code = $row['comp_code'];
        $comp_desc = $row['comp_desc'];


        // $q="select ui_tag_id from sfs_screens where id IN(".$screen_access.")";
        // $res=mysqli_query($con,$q) or die('Error:'.mysqli_error($con));
        // while ($row=mysqli_fetch_array($res)){
        //     $screenArr[]=$row['ui_tag_id'];
        // }

        // $screenQ="select ui_tag_id from sfs_screens";
        // $screenRes=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
        // while ($row=mysqli_fetch_array($screenRes)){
        //     $allScreenArr[]=$row['ui_tag_id'];
        // }

            $response=array('emp_id' =>$emp_id, 
                            'role_code' =>$role_code,
                            'frst_name' =>$frst_name,
                            'designation' =>$designation,
                            'plnt_code' =>$plnt_code,
                            'plnt_s_desc' =>$plnt_s_desc,
                            'plnt_desc' =>$plnt_desc,
                            'comp_code' =>$comp_code,
                            'comp_desc' =>$comp_desc
                            );
        
    }
    $status['userDetails'] = $response;
    //$status['screenArr'] = $screenArr;
    //$status['allScreenArr'] = $allScreenArr;
    echo json_encode($status);
    mysqli_close($con);
}

?>