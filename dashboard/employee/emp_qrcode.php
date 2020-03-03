<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>

<script type="text/javascript" src="../common/js/jquery.qrcode.min.js"></script>

<script type="text/javascript">
var baseURL="<?php echo $prodBaseURL; ?>";

var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
tempData.jobcard=
{
loadAllJobPO:function(){
  debugger;
  var plantId = $('#plant_id').val();
  var customer_code="<?php echo $_GET['code']; ?>";
  var requireDate="<?php echo $_GET['date']; ?>";
  var size_fg="<?php echo $_GET['fg']; ?>";

  var url=baseURL+"/sutures_api/Jobcards/reademployee_details.php";
 // var myData={getJobPoDetails:"getJobPoDetails"};
       $.ajax({
          type:"POST",
          url:url,
          async: false,
          dataType: 'json',
        //  data:myData,
          success: function(obj){           
              var content="";
              $('#qrContent').html('');
            debugger;
            if(obj != null){
              //alert(obj.jobPoDetails.length);
              var k=0;
              var j=0;
              var nextPage='';
              var breakVar='';

      for(var i=0;i<obj.length;i++){
                var elText=null;
                var contentVar="qrcode"+"_"+i;

      j++;
      if(j==8){        
        j=0;
        nextPage='<p class="hidden-md hidden-lg" style="page-break-before: always;"></p>';
        console.log(breakVar);
      }else{
        nextPage=''
      }


      k++;
      if(k==4){        
        k=0;
        breakVar="<div style='margin-top:0%;'>&nbsp;</div>";
        console.log(breakVar);
      }else{
        breakVar="";
      }



//elText=obj.jobPoDetails[i].customer_code+':'+obj.jobPoDetails[i].order_number+':'+obj.jobPoDetails[i].requireDate+':'+obj.jobPoDetails[i].target_qty+':'+obj.jobPoDetails[i].plan+':'+uu+':'+ss+':'+tt;

elText=obj[i].emp_id;

content='<div class="col-md-3 col-xs-3">'+
          '<div class="card">'+
          '<div class="text-center">'+
          '<img src="../common/img/comp_logo/SUI_6787.png" alt="logo" style="width:50%;margin-top:3%;">'+
          '</div>'+
          '<div class="col-md-12 col-xs-12"><hr></div>'+
          '<div class="text-center">'+
          '<h4><b>'+obj[i].frst_name+'</b></h4>'+ 
          '<p>'+obj[i].role_desc+'</p>'+ 
          '<p style="margin-top:-4%;">'+obj[i].emp_id+'</p>'+ 
          '<div class="" id="'+contentVar+'"></div><br><br>'+     
          '</div>'+
          '</div>'+
          '</div>'+breakVar+' '+nextPage;

      $('#qrContent').append(content);

      $('#'+contentVar).qrcode(elText);   

             }
              
            }
          } // ajax success ends
        });   

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

    $("#menuJobCardScreen").parent().addClass('active');
    $("#menuJobCardScreen").parent().parent().closest('.treeview').addClass('active menu-open');

    var setDateFormat="dd/mm/yyyy";
    $('.datepicker-me').datepicker({
        format: setDateFormat,
        autoclose: true
    });

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('.datepicker-me').datepicker('setDate', today);

    $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
    $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
    $('#color').css('background-color','#b2ba62');
 	
  tempData.jobcard.loadAllJobPO();

});

</script>
<style type="text/css">
canvas{
  width: 100px; 
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
  margin-left: 0%;
  font-size: 11px !important;
}
.sizeCss{
  font-size: 12px !important;
  font-weight: 800;  
}
.jobCardMd{
  border: 1px solid black;
  margin-bottom: 0px;
  border-radius: 1px;
  box-shadow: 0px 0px 10px 0px #00000052;
}

hr{
  border-top: 1px solid #6d6161 !important;
}
.card {
  /* Add shadows to create the "card" effect */
  border: 1px solid black;
  transition: 0.3s;
}

/* On mouse-over, add a deeper shadow */
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.container {
  padding: 2px 16px;
}


    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
  
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


    }


</style>
 
        <!-- <input type="hidden" name="comp_id" id="comp_id"/> 
        <input type="hidden" name="plant_id" id="plant_id"/>
        <input type="hidden" name="wc_id" id="wc_id"/>       -->
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

    <div class="panel">   
 
      <div id="qrContent"></div>

     
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
