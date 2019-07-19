<?php 
error_reporting(0);
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="../common/img/favicon-32x32.png">

<?php //include('../common/header.php'); ?>
<?php //include('../common/sidebar.php'); ?>
<?php include('../common/commonCSS.php');?>
<?php include('../common/commonJS.php');?>
  
<?php require_once('../common/commonVariables.php'); ?>

<?php error_reporting(0); ?>

<script type="text/javascript" src="../common/js/jquery.qrcode.min.js"></script>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
tempData.jobcard=
{
loadAllJobPO:function(){
  debugger;
  var ok="<?php echo $_GET['ok']; ?>";

  alert(ok);
     
           
if(obj.jobPoDetails != null){

for(var i=0;i<obj.jobPoDetails.length;i++){


content='<div class="col-md-3 col-xs-12 jobCard jobCardMd"><div class="row">'+
'<div class="col-md-4 col-xs-4" style="margin-top: 1%;"><p class="text">'+u+'</p></div>'+
'<div class="col-md-4 col-xs-4" style="margin-top: 1%;"><p class="text1">'+s+'</p></div>'+
'<div class="col-md-4 col-xs-4" style="margin-top: 1%;"><p class="text1">'+t+'</p></div></div>'+
'<div class="row"><div class="col-md-4 col-xs-3" id="'+contentVar+'" style="margin-top: 1%;"></div>'+
'<div class="col-md-8 col-xs-9 sunContent" style="margin-top: 1%;">'+
'<p class="sizeCss">Size: '+obj.jobPoDetails[i].fg_code+'</p>'+
'<p class="sizeCss">B.C. No: '+res[0]+'</p>'+
// '<p class="sizeCss">S.C. No: '+res[2]+' / '+res[1]+'</p>'+ 
'<p class="sizeCss">ST. Qty: '+obj.jobPoDetails[i].ord_qty+'&nbsp;&nbsp;&nbsp;&nbsp; S.C. No: '+res[2]+' / '+res[1]+'</p>'+
'<p class="sizeCss">Customer: '+obj.jobPoDetails[i].cust_name+'</p>'+
'<p class="sizeCss">Req Date: '+tempData.jobcard.getDateFormate(obj.jobPoDetails[i].req_date)+'</p>'+
'<p class="sizeCss">Plan: '+obj.jobPoDetails[i].plan+', '+planType+'</p>'+

      $('#qrContent').append(content);

      $('#'+contentVar).qrcode(elText);   

             }
              
            }
        //   } // ajax success ends
        // });   

  },
reload:function(){
	   location.reload(true);
},
clearForm:function(){
    $('#reason_type_id').val(0).change();  
    $("#fromJobCard").fadeToggle("slow");
    $('#eq_code').prop('readonly', false);
    $('#fromJobCard')[0].reset();
    $("#addJobCard").show();
    $("#updateReason").hide(); 
    $("#reason_code_no").val('');
    $("#record_id").val('');           
},
getDateFormate:function(date){  // DB formate date and time to dd-mm-yyyy
  var dt=date.split(' ');
  var onlyDate=dt[0].split('-');
  return onlyDate[2]+'-'+onlyDate[1]+'-'+onlyDate[0];
},

};

$(document).ready(function() {
    debugger;    
 	
   tempData.jobcard.loadAllJobPO();

});

</script>
<style type="text/css">
canvas{
  width: 85px; 
} 
p{
  margin-left: 3%;
  margin-bottom: 3px;
}
.text{
  font-weight: 900;
  text-transform: uppercase;
  margin-left: 10%;
  font-size: 13px !important;
}
.text1{
  font-weight: 800;
  text-transform: capitalize;
  margin-left: 8%;
  font-size: 11px !important;
}
.sizeCss{
  font-size: 12px !important;
  font-weight: 800;  
}


/*p{
   font-size: 6px !important;
}*/
/* A4 Landscape*/
@page {
    /*margin-left: 10%;   */
}

@media print {
   /*.jobCard{
      width: 100%;      
    }*/

/*    .sunContent>p{
        font-weight: 900; 
    }
    .subtext{
        text-transform: uppercase;
    }

.jobCardMd{
    height: 160px;
  }
*/
}

.jobCardMd{
    border: 0px solid black;
    margin-bottom: 30px;
    border-radius: 1px;
    box-shadow: 0px 0px 10px 0px #00000052;
  }

    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
      .jobCardMd{      
        margin-left: 0px;
      }
      .subtext{
        font-size: 8px;
        margin-left: 10%;
      }
      .sunContent>p{
        font-size: 10px;
      }

      .jobCardMd{
         height: 120px;
      }

    }
      /* Extra Small Devices, Phones */ 
    @media only screen and (min-width : 480px) {

    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {

    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {

    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
      .jobCardMd{       
        margin-left: 84px;      
      }

      .subtext{
        font-size: 10px !important;
        margin-left: 10%;
      }
      .sunContent>p{
        font-size: 12px !important;
      }

      .jobCardMd{
         height: 250px;
      }

    }


</style>
 
        <input type="hidden" name="comp_id" id="comp_id"/> 
        <input type="hidden" name="plant_id" id="plant_id"/>
        <input type="hidden" name="wc_id" id="wc_id"/>      

  <div class="">
    <!-- Main content -->
    <section class="content">
      <div id="qrContent"></div>

      <div class="col-md-4 jobCard jobCardMd">
         <div class="col-md-12" id="qrcode" style="margin-top: 4%;">xsdxcv</div>
      </div> 
      <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode1" style="margin-top: 4%;">xcvxcvxcv</div>
      </div> 

       <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode2" style="margin-top: 4%;"></div>
      </div> 

      <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode3" style="margin-top: 4%;"></div>
      </div> 
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php //include('../common/footer.php'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

</body>
</html>
