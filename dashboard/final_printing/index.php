<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>

<style type="text/css">
  .rightAlign{
    text-align:right;
  }
  .actualCard{
    background-color: #f3dbdb;
    font-weight: bold;
  }
  .stockCard{
    background-color: #fffedb;
    font-weight: bold;
  }

  .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td,.table>thead:first-child>tr:first-child>th{
    border: 1px solid #0000003b;
  }

  .santh >table > thead > tr > th {
    background: #d3e8fb !important;
  }

  .biggerFont>tbody>tr>td {
    padding: 3px !important;
    font-size: 20px;
  }
  

  .processCSS{
    font-weight:600;
  }
 
</style>

<script type="text/javascript">

var baseURL="<?php echo $prodBaseURL; ?>";
var reasonArr="";
var prodData="";
var getDate="";

var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

tempData.jobcard=
{

getProductionData:function(){
  debugger;
    var url=baseURL+"getDataController.php";
    var status="<?php echo $lp_status; ?>";
    var wrk_ctr_code="<?php echo $lp_workcenter; ?>"";
    
    var myData = {getProductionDe:"getJobPoDetails",status:status,wrk_ctr_code:wrk_ctr_code};

    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:JSON.stringify(myData),
      contentType: 'application/json',
      success: function(obj) {
        debugger;
        var content='';
        $("#getTableContent").html('');

        if(obj.body != ''){
          for(var i=0;i<obj.length;i++){
            content +="<tr><td>"+ (i+1) +"</td>"+
                      "<td class='processCSS'>"+obj[i].Batch_no+"</td>"+
                      "<td >"+obj[i].Size+"</td>"+
                      "<td >"+obj[i].Customer+"</td>"+
                      "<td >"+obj[i].Plan+"</td>"+
                      "<td >"+obj[i].req_date+"</td>"+
                      "<td >"+obj[i].req_type+"</td>"+
                      "<td class='rightAlign'>"+obj[i].ok_qty+"</td>"+
                      "<td class='rightAlign'>asd</td>"+
                      "</tr>"
          }          
          $("#getTableContent").append(content);
        }else{
          content +="<tr><td colspan='22' style='text-align:center;'><b>Data Not Available </b></td></tr>";
          $("#getTableContent").html(content);
        }
      }
    });
},
reload:function(){
	location.reload(true);
}

};

$(document).ready(function() {
    debugger;
    $("#final_printing").parent().addClass('active');
    $("#final_printing").parent().parent().closest('.treeview').addClass('active menu-open');

  //$('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  //$('#wc_id').val(<?php echo $_GET['wc_id'];?>);
    $('#color').css('background-color','#b2ba62');    

 	
    tempData.jobcard.getProductionData();

});


</script>

<style type="text/css">

  .tdclass>tbody>tr>td{
    padding: 3px !important;
  }
  .rightCss{
    text-align:right;
    font-weight:bold;
  }
</style>

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
     <!--  <div class="commonPageHead">
        <div class="col-md-12 col-sm-12 col-xs-12 headerTitle text-center">
        <h3 style="margin-top: 2px;font-weight: bold;">HEALTHIUM MEDTECH PVT LTD BANGALORE<h3>
        </div>
      </div> -->

  <div class="panel panel-default">   
  <!-- <div class="panel-heading "> 
   <h4 style="align:center;"> HEALTHIUM MEDTECH PVT LTD BANGALORE </h4>
  </div>    -->
      <div class="panel-body">
       <div class="table-responsive col-md-12 santh">     
   
        <table class="table table-hover table-bordered" id="printTable" border="1">
          <thead>
            <tr>
              <th>Sl. No.</th>
              <th>JobCard</th>
              <th>Size</th>
              <th>Customer</th>
              <th>Plan</th>
              <th>Required Date</th>
              <th>Required Type</th>
              <th>OK Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="getTableContent">
           
          </tbody>
        </table>
      </div>

      </div>
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


<!-- Modal reasonArr --> 
<div id="add_reason" class="modal fade" role="dialog">
  <div class="modal-dialog">

<input type="hidden" id="seletedDateRec">
<input type="hidden" id="seletedWcRec">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Add Reasons</b></h4>
      </div>
      <div class="modal-body">
        <p>Select the Reasons</p>
        <select class="form-control select2"  id="selReason" name="selReason[]"  multiple="multiple" 
        style="width:60%;" data-placeholder="Reasons">
        </select>
      <br><br>
        <p>Remarks</p>
        <textarea class="form-control"  id="remarks" name="remarks" style="width:60%;" 
        placeholder="Remarks"></textarea>

        <br>
        <p id="msg" style="color:red;"></p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success btn-sm" id="saveReason"
       onclick="tempData.jobcard.saveReason();";>Save</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal Production data --> 
<div id="prod_data" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>View Reason</b></h4>
      </div>
      <div class="modal-body">
        <p><b>Reasons</b></p>
        <p><span id="viewReasons"></span></p>
        <br>
        <p><b>Remarks</b></p>
        <p><span id="viewRemarks"></span></p>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


</body>
</html>
