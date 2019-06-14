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
 			
        	// for (var i=0; i < obj.allScreenArr.length ; i++) {
        	// 	$('#'+obj.allScreenArr[i]).hide();
        	// }	

        	// for (var i=0; i < obj.screenArr.length ; i++) {
        	// 	$('#'+obj.screenArr[i]).show();
        	// }
         	
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
             //$('#workCenter_id').val(1);
          
          /* Role Configuration */
         	/*$('#adminRole').val(obj.userDetails.rolename);
         	$('#companyName').val(obj.userDetails.company_id);*/

          /* Handel Home Page*/
          // if(obj.userDetails.code=='EIMS'){

          // }else{
            
          // }

        }else{
         
        }
      } 
  });

});
</script>