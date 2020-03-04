<?php 
error_reporting(0);
session_start();  

if(!isset($_SESSION['schAdminSession'])) {
	//echo "test";
	echo "<script> window.location='../logout.php';</script>";
}else{
	//echo $_SESSION['schAdminSession']."_Not working";
}

?>
<script src="https://docs.smartkarrot.com/frameworks/web/v4/UsageAnalytics.js"></script>


<script type="text/javascript">
$(document).ready(function() {

  setTimeout(function(){ $(".loader").fadeOut("slow"); }, 7);  
  
  var userMail="<?php echo $_SESSION['schAdminSession'] ?>";
  var pass="<?php echo $_SESSION['schAdminRole'] ?>";
  var url="../common/getDataController.php";
  var myData = {userDetails:'userDetails',userMail:userMail,token:pass};
  
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    data:myData,
    success: function(obj) {
        debugger;
        if(obj.userDetails !=null){
 			         	
            $('#comp_code').val(obj.userDetails.comp_code);
         	  //$('#comp_id').val(obj.userDetails.company_id);  
          	$('#compNameDB').html(obj.userDetails.comp_desc);
            $('#sidebarUserName').html(obj.userDetails.frst_name);
          	$('#sidebarUserDes').html(obj.userDetails.designation);

          	// if(obj.userDetails.img_file_name != ''){
          	// 	$('#userImgFileName').html('<img src="../common/img/user_img/'+obj.userDetails.img_file_name+'" class="img-circle" alt="User Image">');
          	// }else{
          		$('#userImgFileName').html('<img src="../common/img/user_img/default.png" class="img-circle" alt="User Image">');
          	// }	

          	// if(obj.userDetails.compImg != ''){
          	// 	$('#compImg').html('<img src="../common/img/comp_logo/'+obj.userDetails.compImg+'"  OnError="this.src=\'../common/img/comp_logo/d/eimsdefault.png\';" class="CustMobileLogo">');
          	// 	$('#compImgMini').html('<img src="../common/img/comp_logo/'+obj.userDetails.compImg+'" OnError="this.src=\'../common/img/comp_logo/d/eimsdefault.png\';" class="cust_logo">');
          	// }else{
          		$('#compImg').html('<img src="../common/img/comp_logo/SUI_6787.png" class="CustMobileLogo">');
          		$('#compImgMini').html('<img src="../common/img/comp_logo/SUI_6787.png" class="cust_logo">');
          	// }

            $('#plant_id').val(obj.userDetails.plnt_code);
            $('#userID').val(obj.userDetails.emp_id);
            $('#userName').val(obj.userDetails.frst_name);
            $('#testIdName').val(obj.userDetails.emp_id+"="+obj.userDetails.frst_name);

          /* Handel Home Page*/
          if(obj.userDetails.role_code=='101'){
            $("#menu_oee").hide();
            $("#menu_dashboard").hide();
            $("#menu_reports").hide();
            $("#menu_rejection").hide();
            $("#menu_rework").hide(); 
            $("#menu_production").hide();
            $("#menu_consumables").hide();
            $("#menu_checklist").hide();
            $("#menu_emp").hide();
            $("#menu_labelprint").show();
          }

// UsageAnalytics.configure("ad9c7590-8210-4c69-970c-e9e5a688278e");
// UsageAnalytics.setUser(obj.userDetails.emp_id, "sutures-eims");

          
// UsageAnalytics.setUserAttribute(UsageAnalytics.UserAttribute.userId, obj.userDetails.emp_id);
// UsageAnalytics.setUserAttribute(UsageAnalytics.UserAttribute.name, obj.userDetails.frst_name);
// UsageAnalytics.setUserAttribute(UsageAnalytics.UserAttribute.designation,obj.userDetails.designation);


        }else{
         
        }
      } 
  });

});
</script>