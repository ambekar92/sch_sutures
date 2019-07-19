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
  var batch="<?php echo $_GET['batch']; ?>";
  var cardType="<?php echo $_GET['cardType']; ?>";
  var series="<?php echo $_GET['series']; ?>";
  var fgcode="<?php echo $_GET['fgcode']; ?>";
  var content="";

  // alert(ok);
  // alert(batch);
  // alert(cardType);
  // alert(series);
  // alert(fgcode);

  var doz=(ok/12); // Doz
  var num_of_cards= doz/10;    // num of cards



           
if(ok != null){

  $('#qrContent').html("");

for(var i=0;i<num_of_cards;i++){
//  content +="DAA";

content+=  '<div class="col-md-2 col-xs-12 outside">'+
          '<div class="col-md-10 col-xs-10 inside_large" id="qrcode" style="margin-top: 4%;">'+
          '<p class="fgCode">'+fgcode +'</p>'+
          '<p class="truePass">'+ 'TRUEPASS' + '<span>'+'300 S'+'</span></p>'+
          '<p class="qtyDoz">Batch : <b>'+batch+'</b></p>'+
          '<p class="qtyDoz">'+'Qty : 1 DOZ'+'</p>'+
          '</div>'+
          '<div class="col-md-2 col-xs-2  inside_small"><p class="status">'+'APPROVED'+'</p></div>'+
          '</div><p class="hidden-xs hidden-md hidden-lg" style="page-break-before: always"> ';
  }

    $('#qrContent').append(content);
    //$('#'+contentVar).qrcode(elText);               
  }

            
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
/* canvas{
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
} */


/*p{
   font-size: 6px !important;
}*/
/* A4 Landscape*/
@page {
    /*margin-left: 10%;   */
}

@media print {
  .outside{       
        margin-left: 26px;   
        border: 0px solid black;
        margin-bottom: 30px;
        border-radius: 1px;
        box-shadow: 0px 0px 10px 0px #00000052;   
      }

      .outside{
         height: 122px;
         width: 100%;
         padding: 0px;
      }

      .inside_large {
        padding: 0px 0px 0px 10px;
        margin-top: 0px !important;
        margin-right: -30px !important;
      }

      .inside_small {
        padding: 0px;
      }

      .fgCode {
        font-size: 20px;
        font-weight: bold;
      }

      .truePass {
        font-size: 18px;
        font-weight: bold;
      }

      span {
        padding-left: 32px;
        font-size: 14px;
      }

      .batchNo {
        font-size: 16px;
        font-weight: bold;
      }

      .qtyDoz {
        font-weight: bold;
      }

      .status {
        padding-top: 14px;
        writing-mode: vertical-rl;
        text-orientation: upright;
        font-size: 10px;
        font-weight: bold;
      }

      p {
        margin: 5px 0px;
      }
}



    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
     

    }
      /* Extra Small Devices, Phones */ 
    @media only screen and (min-width : 480px) {
  /* .jobCardMd{       
        margin-left: 84px;      
      } */
    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {

    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {

    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
      .outside{       
        margin-left: 27px;  
        border: 1px solid black;
        margin-bottom: 30px;
        border-radius: 1px;
        box-shadow: 0px 0px 10px 0px #00000052;    
      }

      .outside{
         height: 122px;
         width: 15%;
         padding: 0px;
      }

      .inside_large {
        padding: 0px 0px 0px 32px;
        margin-top: 0px !important;
        margin-right: -30px !important;
      }

      .inside_small {
        padding: 0px;
      }

      .fgCode {
        font-size: 20px;
        font-weight: bold;
      }

      .truePass {
        font-size: 18px;
        font-weight: bold;
      }

      span {
        padding-left: 16px;

        font-size: 14px;
      }

      .batchNo {
        font-size: 16px;
        font-weight: bold;
      }

      .qtyDoz {
        font-weight: bold;
      }

      .status {
        /* padding-top: 8px; */
        writing-mode: vertical-rl;
        text-orientation: upright;
        font-size: 12px;
        font-weight: bold;
      }

      p {
        margin: 5px 0px;
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

      <!-- <div class="col-md-2 col-xs-12 outside">
         <div class="col-md-10 col-xs-10 inside_large" id="qrcode" style="margin-top: 4%;">
            <p class="fgCode">DFFJGJ5654</p>
            <p class="truePass">TRUEPASS <span>300 S</span></p>
            <p class="batchNo">BATCH:- 12345</p>
            <p class="qtyDoz">Qty:- 1 DOZ</p>
         </div>
         <div class="col-md-2 col-xs-2  inside_small"><p class="status">APPROVED</p></div>
      </div> 
  

      <div class="col-md-2 outside">
       <div class="" id="qrcode1" style="margin-top: 4%;">xcvxcvxcv</div>
      </div> 


      <div class="col-md-2 outside">
       <div class="" id="qrcode2" style="margin-top: 4%;">asdasd</div>
      </div> 
  

      <div class="col-md-2 outside">
       <div class="" id="qrcode3" style="margin-top: 4%;">asdasd</div>
      </div>  -->
      <!-- <p class="hidden-md hidden-lg" style="page-break-before: always"> -->

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
