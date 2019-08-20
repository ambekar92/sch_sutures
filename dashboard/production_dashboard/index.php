<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>

<style type="text/css">
  .leftAlign{
    text-align:left;
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

  .removePading{
    padding-right: 0px;
    padding-left: 0px;
  }

  .specialCss{
    font-weight: bold;
    margin-top: 6px;
    padding-left: 3px;
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
addZero:function(num) {
  if (num < 10) {
      num = "0" + num;
  }
  return num;
},
loadTime:function(){
        for(var j=0; j<= 24; j++){
          $("#sth").append('<option value='+tempData.jobcard.addZero(j)+'>'+tempData.jobcard.addZero(j)+'</option>'); 
        }

        for(var k=0; k<= 60; k++){
          $("#stm").append('<option value='+tempData.jobcard.addZero(k)+'>'+tempData.jobcard.addZero(k)+'</option>'); 
        }

        for(var l=0; l<= 24; l++){
          $("#edh").append('<option value='+tempData.jobcard.addZero(l)+'>'+tempData.jobcard.addZero(l)+'</option>'); 
        }

        for(var m=0; m<= 60; m++){
          $("#edm").append('<option value='+tempData.jobcard.addZero(m)+'>'+tempData.jobcard.addZero(m)+'</option>'); 
        }

},
getProductionData:function(){
  
    var url=baseURL+"/sutures_api/Jobcards/readprod_dash_filedata.php";
    // var url="localhost/sutures_api/Jobcards/readprod_dash_filedata.php";
    var date_=$('#userDateSel').val();

    var res = date_.split("/");
    var final_date=res[2]+"-"+res[1]+"-"+res[0]

    var myData = {date:final_date};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:JSON.stringify(myData),
      contentType: 'application/json',
      success: function(obj) {
        //alert();
        
        $("#getTableContent").html('');

        reasonArr=obj.reasons;
        prodData=obj.body;

        for(var i=0; i< reasonArr.length; i++){
          $("#selReason").append('<option value='+reasonArr[i].prod_reas_code+'>'+reasonArr[i].prod_reas_descp+'</option>'); 
        }
     

        var content ='';
        var a=b=c=d=e=f='';
          if(obj.header != ''){
            if(obj.header.last_month_production=="NAN"){a=0;}
            else{  a=obj.header.last_month_production; }

            if(obj.header.last_month_productivity=="NAN"){b=0;}
            else{  b=obj.header.last_month_productivity; }

            if(obj.header.last_month_yield=="NAN" || obj.header.last_month_yield==""){c=0;}
            else{  c=obj.header.last_month_yield; }

            if(obj.header.monthly_production=="NAN"){d=0;}
            else{  d=obj.header.monthly_production; }

            if(obj.header.monthly_productivity=="NAN"){e=0;}
            else{  e=obj.header.monthly_productivity; }

            if(obj.header.monthly_yield=="NAN" || obj.header.monthly_yield==""){f=0;}
            else{  f=obj.header.monthly_yield; }

            $('#last_month_absenttism').html(obj.header.last_month_absenttism);
            $('#last_month_man_hours').html(obj.header.last_month_man_hours);
            $('#last_month_ot').html(obj.header.last_month_ot);
            $('#last_month_production').html(a);
            $('#last_month_productivity').html(b);
            $('#last_month_yield').html(c);
            $('#monthly_absenttism').html(obj.header.monthly_absenttism);
            $('#monthly_man_hours').html(obj.header.monthly_man_hours);
            $('#monthly_ot').html(obj.header.monthly_ot);
            $('#monthly_production').html(d);
            $('#monthly_productivity').html(e);
            $('#monthly_yield').html(f);
            $('#status').html(obj.header.status);
          }else{
            $('#last_month_absenttism').html('');
            $('#last_month_man_hours').html('');
            $('#last_month_ot').html('');
            $('#last_month_production').html('');
            $('#last_month_productivity').html('');
            $('#last_month_yield').html('');
            $('#monthly_absenttism').html('');
            $('#monthly_man_hours').html('');
            $('#monthly_ot').html('');
            $('#monthly_production').html('');
            $('#monthly_productivity').html('');
            $('#monthly_yield').html('');
            $('#status').html('');
          }

        if(obj.body != ''){
          for(var i=0;i<obj.body.length;i++){
            content +="<tr><td>"+ (i+1) +"</td>"+
                      "<td class='processCSS'>"+obj.body[i].process+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].daily_target+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].man_power+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].machine+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].material+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].today_plan+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].planed_man_power+"</td>"+
                      "<td class='rightAlign actualCard'>"+obj.body[i].actual_card_urgent_rb+"</td>"+
                      "<td class='rightAlign actualCard'>"+obj.body[i].actual_card_urgent_ct+"</td>"+
                      "<td class='rightAlign actualCard'>"+obj.body[i].actual_card_regular_rb+"</td>"+
                      "<td class='rightAlign actualCard'>"+obj.body[i].actual_card_regular_ct+"</td>"+
                      "<td class='rightAlign stockCard'>"+obj.body[i].card_stock_urgent_rb+"</td>"+
                      "<td class='rightAlign stockCard'>"+obj.body[i].card_stock_urgent_ct+"</td>"+
                      "<td class='rightAlign stockCard'>"+obj.body[i].card_stock_regular_rb+"</td>"+
                      "<td class='rightAlign stockCard'>"+obj.body[i].card_stock_regular_ct+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].monthly_total_cards+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].planned_cards+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].backlogs+"</td>"+
                      "<td class='rightAlign'>"+obj.body[i].avg_cards+"</td>"+
                      "<td class='rightAlign'>"+tempData.jobcard.getReasonDropdown(obj.body[i].reasons,obj.body[i].date,obj.body[i].work_ctr_code,obj.body[i].process,obj.date[0].date)+"</td>"+
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
},
getReasonDropdown:function(val,date,wc,process,hdate){
  debugger;
  // val = reasons in tb_t_prod_dash_h table
  var holiday = hdate;

  var getSelDate=$('#userDateSel').val();
  var status=$('#status').text();  

  var aa = getDate.split("/");
  var bb = getSelDate.split("/");
  
  var getSelDateNew = aa[2]+'-'+aa[1]+'-'+aa[0];
  var getDateNew = bb[2]+'-'+bb[1]+'-'+bb[0];
  
  const date11 = new Date(getSelDateNew);
  const date22 = new Date(getDateNew);
  const date33 = new Date(holiday);

  if( date22 < date11 ){

    var a = getDate.split("/");
    var b = getSelDate.split("/");

    var DBdate = a[2]+'-'+a[1]+'-'+a[0];
    var SelDate = b[2]+'-'+b[1]+'-'+b[0];;

    const date1 = new Date(DBdate);
    const date2 = new Date(SelDate);
    const diffTime = Math.abs(date2.getTime() - date1.getTime());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    //console.log(diffDays);
    const holidiff = Math.abs(date22.getTime() - date33.getTime());
    const holidiffrnc =  Math.ceil(holidiff / (1000 * 60 * 60 * 24)); 


    //var diff=getDate-getSelDate;

    if(diffDays==1 && status == 'Working'){//date diff equal to 1
      // if(val != 0){
      //  return "<button class='btn btn-warning btn-xs' onclick='tempData.jobcard.openModelWithView(\""+date+"\","+wc+");'><i class='fa fa-eye' style='color:black;'></i> &nbsp;View</button>";
      // }else{
        return "<button class='btn btn-primary btn-xs' onclick='tempData.jobcard.openModel(\""+date+"\","+wc+",\""+process+"\");'>Add Reason</button>";
      // }
    }else{
     
     if(holidiffrnc == 0 && status == 'Working'){
      return "<button class='btn btn-primary btn-xs' onclick='tempData.jobcard.openModel(\""+date+"\","+wc+",\""+process+"\");'>Add Reason</button>";
     }else{
      if(val != 0){

       return "<button class='btn btn-warning btn-xs' onclick='tempData.jobcard.openModelWithView(\""+date+"\","+wc+",\""+process+"\");'><i class='fa fa-eye' style='color:black;'></i> &nbsp;View</button>";
      // return "<button class='btn btn-warning btn-xs' onclick='tempData.jobcard.fetchReasons();'><i class='fa fa-eye' style='color:black;'></i> &nbsp;View</button>";
      
      }else{

        return "-";

      }
     }
    }
    

  }else{

    // if(val != 0){
    //    return "<button class='btn btn-warning btn-xs' onclick='tempData.jobcard.openModelWithView(\""+date+"\","+wc+");'><i class='fa fa-eye' style='color:black;'></i> &nbsp;View</button>";
    // }else{     
     
      return "-"
   // } 
  }

},
openModel:function(date,wc,process){
  $('#titleNameR').html(process);

  $('#selReason').val('');
  $('#selReason').val('').trigger("change");

  $('#sth').val('');
  $('#sth').val('').trigger("change");

  $('#stm').val('');
  $('#stm').val('').trigger("change");

  $('#edh').val('');
  $('#edh').val('').trigger("change");

  $('#edm').val('');
  $('#edm').val('').trigger("change");

  $('#remarks').val('');
  
  $('#seletedDateRec').val(date);
  $('#seletedWcRec').val(wc);
  $('#add_reason').modal('show');
  tempData.jobcard.fetchReasons();
},

openModelWithView:function(date,wc,process,){

  $('#titleNameV').html(process);
  var seletedDateRec=date;
  var seletedWcRec=wc;

  // $('#titleNameV').html(seletedWcRec);

  var url='getDataController.php';
  var myData ={fetchReasons:"fetchReasons",seletedDateRec:seletedDateRec,seletedWcRec:seletedWcRec}
  $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:JSON.stringify(myData),
      contentType: 'application/json',
      success: function(obj) {
        
        var content ='';
  
        $("#viewReasonData").html('');

        if(obj.body !=null){
        for(var i=0;i<obj.body.length;i++){
          content +="<tr>"+
                      "<td class='leftAlign'>"+obj.body[i].reason_code+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].start_time+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].end_time+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].remarks+"</td>"+
                      // "<td class='rightAlign'>"+"<button type='button'>Delete</button>"+"</td>"+
                      "</tr>" ;                
       }      
      }else{
        content +="<tr>"+
                  "<td colspan='5' style='text-align:center;'>No Data</td>"+
                  "</tr>";  
      }
      
      $("#viewReasonData").append(content);


      $('#prod_data').modal('show');


      }
    });
},
saveReason:function(){
  debugger;
  var reasons=$('#selReason').val();
  var remarks=$('#remarks').val();
  var sth=$('#sth').val();
  var stm=$('#stm').val();
  var edh=$('#edh').val();
  var edm=$('#edm').val();
  var seletedDateRec=$('#seletedDateRec').val();
  var seletedWcRec=$('#seletedWcRec').val();
  if(reasons==''){
    $('#msg').html("Please select reason.!");
		return false;
  }else{
    $('#msg').html('');
  }

  if(remarks==''){
    $('#msg').html("Please enter remarks!");
		return false;
  }else{
    $('#msg').html('');
  }

var start_time = sth+':'+stm;
var end_time = edh+':'+edm;
  var url='getDataController.php';
  var myData ={saveReason:"saveReason",reasons:reasons,remarks:remarks,seletedDateRec:seletedDateRec,seletedWcRec:seletedWcRec,start_time:start_time,end_time:end_time}
  $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:JSON.stringify(myData),
      contentType: 'application/json',
      success: function(obj) {
        if(obj.status == 1){
          $('#reasonmsg').html('');
        tempData.jobcard.fetchReasons();
        }else{
          $('#reasonmsg').html("Reason already exists!");
          // alert("Reason Is already selected")
        }
        
       }
    });


},
fetchReasons:function(){
  var seletedDateRec=$('#seletedDateRec').val();
  var seletedWcRec=$('#seletedWcRec').val();

  var url='getDataController.php';
  var myData ={fetchReasons:"fetchReasons",seletedDateRec:seletedDateRec,seletedWcRec:seletedWcRec}
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
        var content ='';
        $("#modaltableData").html('');
        $("#viewReasonData").html('');

        if(obj.body !=null){
        for(var i=0;i<obj.body.length;i++){
          content +="<tr>"+
                      "<td class='leftAlign'>"+obj.body[i].reason_code+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].start_time+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].end_time+"</td>"+
                      "<td class='leftAlign'>"+obj.body[i].remarks+"</td>"+
                      // "<td class='rightAlign'>"+"<button type='button'>Delete</button>"+"</td>"+
                      "</tr>" ;                
       }      
      }else{
        content +="<tr>"+
                  "<td colspan='5' style='text-align:center;'>No Data</td>"+
                  "</tr>";  
      }
      
      $("#modaltableData").append(content);
      $("#viewReasonData").append(content);

      }
    });
},
validateTime:function(){
  debugger;

  var getSelDate=$('#userDateSel').val();
  
  var sth =$('#sth').val();
  var stm =$('#stm').val();

  var edh =$('#edh').val();
  var edm =$('#edm').val();

  startdate = getSelDate + ' '+ sth +':'+stm + ':' + '00';
  enddate =  getSelDate + ' '+ edh +':'+edm + ':' + '00';

  if( startdate < enddate ) {
    $('#endtimemsg').html('');
    tempData.jobcard.saveReason();
  }else {
    $('#endtimemsg').html("Start time is more than end time.!");
    // alert("Start time is more than end time");
  }

 },
 loadData:function(){

  var date_=$('#userDateSel').val();
  var res = date_.split("/");
  var final_date=res[2]+"-"+res[1]+"-"+res[0];

  var url='getDataController.php';
  var myData ={loadData:"loadData",final_date:final_date}

  $.ajax({
      type:"POST",
      url:url,
      async: false,
      cache: false,
      data:JSON.stringify(myData),
      contentType: 'application/json',
      success: function(obj) {
       //alert();
      }
    });

 }

};

$(document).ready(function() {
    debugger;
    $("#view_dashboard").parent().addClass('active');
    $("#view_dashboard").parent().parent().closest('.treeview').addClass('active menu-open');

    $('#upload_fg').prop('disabled', true);

    $('#load').hide();
    $('#selReason').select2();

    //var date = new Date();
   // date.setDate(date.getDate());

    var setDateFormat="dd/mm/yyyy";
    $('#userDateSel').datepicker({
        format: setDateFormat,
        autoclose: true
    });

    // Date initialization Jobcard 
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#userDateSel').datepicker('setDate', today);

    getDate = "<?php echo date("d/m/Y"); ?>";
//alert(getDate);
    //$('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
   //  $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
    $('#color').css('background-color','#b2ba62');    

 	
    $('.select2').select2();
    $("#searchJobCardID").hide();
    $("#generateJobCard").hide();
    $('#commonMsg').hide();
      
    tempData.jobcard.loadData();
    tempData.jobcard.getProductionData();
    tempData.jobcard.loadTime();
    
   

    $('#upload_fg_form').on("submit", function(e) {
     // alert();
     $('#load').show();
        e.preventDefault(); //form will not submitted  
        $.ajax({
            url: "file_upload.php",
            method: "POST",
            data: new FormData(this),
            dataType:"json",
            contentType: false, // The content type used when sending data to the server.  
            cache: false, // To unable request pages to be cached  
            processData: false, // To send DOMDocument or non processed data file it is set to false  
            success: function(obj) {
              //alert();
                debugger;
                $('#load').hide();
                if (obj.resp == 0) {
                    $('#showmsg_fg').show();
                    $('#lblError_fg').html(obj.msg);
                } else {
                    $('#success_fg').show();
                    $('#successMsg_fg').html(obj.msg);
                }

               tempData.jobcard.getProductionData();  

                setTimeout(function() {
                    $('#showmsg_fg').hide();
                    $('#success_fg').hide();
                }, 2000);

            }
        })
    });

    

function printData()
{
  var divToPrint=document.getElementById("printTable");
  newWin= window.open("");
  newWin.document.write(divToPrint.outerHTML);
  newWin.print();
  newWin.close();
}

$('#print').on('click',function(){
  printData();
})

});


function AlertFilesize() {
    var sizeinbytes = document.getElementById('datafile').files[0].size;
    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
    $('#showmsg').hide();

    fSize = sizeinbytes;
    i = 0;
    while (fSize > 900) {
        fSize /= 1024;
        i++;
    }
    //alert((Math.round(fSize*100)/100)+' '+fSExt[i]);
    var size = ((Math.round(fSize * 100) / 100)); //+' '+fSExt[i]);
    //alert(size);
    if (fSExt[i] == 'KB') {
        $('#size').html("<p style='color:green;font-size:14;'><b> File size :" + size + " " + fSExt[i] + "<b></p>");
        $('#upload').prop('disabled', false);
    } else if (size < 3 && fSExt[i] == 'MB') {
        $('#size').html("<p style='color:green;font-size:14;'><b> File size :" + size + " " + fSExt[i] + "<b></p>");
        $('#upload').prop('disabled', false);
    } else {
        $('#size').html("<p style='color:green;font-size:14;'><b>File size : " + size + " " + fSExt[i]);
        $('#upload').prop('disabled', false);
    }

    var allowedFiles = [".csv"];
    var fileUpload = document.getElementById("datafile");
    var lblError = document.getElementById("lblError");
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
    if (!regex.test(fileUpload.value.toLowerCase())) {
        lblError.innerHTML = "Please upload <b>" + allowedFiles.join(', ') + "</b> file only.";
        $('#showmsg').show();
        $('#upload').prop('disabled', true);
        return false;
    } else {
        lblError.innerHTML = "";
        return true;
    }
}

function AlertFilesize_fg() {
    var sizeinbytes = document.getElementById('fg_file').files[0].size;
    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
    $('#showmsg_fg').hide();

    fSize = sizeinbytes;
    i = 0;
    while (fSize > 900) {
        fSize /= 1024;
        i++;
    }
    //alert((Math.round(fSize*100)/100)+' '+fSExt[i]);
    var size = ((Math.round(fSize * 100) / 100)); //+' '+fSExt[i]);
    //alert(fSExt[i]);
    if (fSExt[i] == 'KB') {
        $('#size_fg').html("<p style='color:green;font-size:14;'><b> File size :" + size + " " + fSExt[i] + "<b></p>");
        $('#upload_fg').prop('disabled', false);
    } else if (size < 3 && fSExt[i] == 'MB') {
        $('#size_fg').html("<p style='color:green;font-size:14;'><b> File size :" + size + " " + fSExt[i] + "<b></p>");
        $('#upload_fg').prop('disabled', false);
    } else {
        $('#size_fg').html("<p style='color:green;font-size:14;'><b>File size : " + size + " " + fSExt[i]);
        $('#upload_fg').prop('disabled', false);
    }

    var allowedFiles = [".csv"];
    var fileUpload = document.getElementById("fg_file");
    var lblError = document.getElementById("lblError_fg");
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
    if (!regex.test(fileUpload.value.toLowerCase())) {
        //alert();
        lblError.innerHTML = "Please upload <b>" + allowedFiles.join(', ') + "</b> file only.";
        $('#showmsg_fg').show();
        $('#upload_fg').prop('disabled', true);
        return false;
    } else {
        lblError.innerHTML = "";
        return true;
    }
}





</script>

<style type="text/css">
  .checkboxCss{
    height: 19px;
    width: 19px;
  }
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

      <button id="print" class="btn btn-xs btn-primary">
        <i class="fa fa-print" style="color:black;font-size:15px;"></i> &nbsp; Print</button>
        <a href="suture_production_sheet.csv" target="_blank" data-toggle="tooltip"
                                    data-placement="bottom">
        <button id="demofile" class="btn btn-xs btn-primary">
        <i class="fa fa-download" style="color:black;font-size:15px;"></i> &nbsp;Template File</button>
        </a>
        <br><br>

         <div class="col-md-4 col-sm-4 col-xs-4" >
        <table class="table table-hover table-bordered tdclass biggerFont">
          <tbody>
            <tr>
              <td>Last Month Production</td><td class="rightCss" id="last_month_production"></td>
            </tr> 
            <tr>
              <td>Last Month Productivity</td><td class="rightCss" id="last_month_productivity"></td>
            </tr>  
            <tr>
              <td>Last Month Yield</td><td class="rightCss" id="last_month_yield"></td>
            </tr>
            <tr>
              <td>Last Month Man Hours</td><td class="rightCss" id="last_month_man_hours"></td>
            </tr>
            <tr>
              <td>Last Month Absenteeism</td><td class="rightCss" id="last_month_absenttism"></td>
            </tr>
            <tr>
              <td>Last Month OT</td><td class="rightCss" id="last_month_ot"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-4">
        <table class="table table-hover table-bordered tdclass biggerFont">
          <tbody>
            <tr>
              <td>Monthly Production</td><td class="rightCss" id="monthly_production"></td>
            </tr> 
            <tr>
              <td>Monthly Productivity</td><td class="rightCss" id="monthly_productivity"></td>
            </tr>  
            <tr>
              <td>Monthly Yield</td><td class="rightCss" id="monthly_yield"></td>
            </tr>
            <tr>
              <td>Monthly Man Hours</td><td class="rightCss" id="monthly_man_hours"></td>
            </tr>
            <tr>
              <td>Monthly Absenteeism </td><td class="rightCss" id="monthly_absenttism"></td>
            </tr>
            <tr>
              <td>Monthly OT</td><td class="rightCss" id="monthly_ot"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-3 col-sm-4 col-xs-4 pull-right">
        <table class="tdclass" border="0">
          <tbody>
            <tr>
              <td><b>Status :</b></td><td id="status"></td>
            </tr>
            <tr>
              <td><b>Date :</b></td>
              <td>
              <div class='col-md-10 input-group date'>
                <input type='text' class="form-control" id='userDateSel' name="userDateSel" 
                        style="cursor: pointer;" readonly="readonly"/>
                  <label class="input-group-addon btn" for="userDateSel">
                      <span class="glyphicon glyphicon-calendar"></span>               
                  </label>
              </div>   
              <button type="button" onclick="tempData.jobcard.getProductionData();" 
              class="btn btn-sm btn-primary pull-right" style="margin-top: -14%;">  
               <i class="fa  fa-refresh"> </i>
             </button>  

              </td>
            </tr>              
           </tbody>
        </table>

        <div class="row">

      <div class=""><br><br>
          <form id="upload_fg_form" method="post" enctype="multipart/form-data">
              <div class="row"  style="float:left;">
                  <div class="col-md-12 col-xs-12">
                      <!-- <label>Upload Your File </label> -->
                      <input type="hidden" name="user" id="user"
                          value="<?php echo $_GET['username']; ?>" />

                      <div class="col-md-10 col-xs-8">
                          <input type="file" class="form-control" name="fg_file" id="fg_file"
                              multiple="" onchange="AlertFilesize_fg();">
                      </div>
                      <div class="col-md-2 col-xs-4">
                          <button type="submit" name="upload_fg" id="upload_fg" value="Upload"
                              style="margin-top:0px;" class="btn btn-primary pull-right"><i
                                  class="fa fa-upload" aria-hidden="true"></i> </button>
                      </div>
                  </div>
              </div>
              <div class="row">
              <i class="fa fa-spinner fa-pulse fa-3x fa-fw" id="load"></i>
                  <div class="col-md-12">
                      <div id="size_fg"></div>
                      <div class="alert alert-danger" id="showmsg_fg" style="display: none;">
                          <strong>Warring !! </strong> <span id="lblError_fg"
                              style="font-size:13px;"></span>
                      </div>

                      <div class="alert alert-success" id="success_fg" style="display: none;">
                          <strong>Success : </strong> <span id="successMsg_fg"
                              style="font-size:13px;"></span>
                      </div>
                  </div>
              </div>
          </form>
      </div>
      </div>

      </div>



      

       <div class="table-responsive col-md-12 santh">     
   
        <table class="table table-hover table-bordered" id="printTable" border="1">
          <thead>
            <tr>
              <th rowspan="3">Sl.No</th>
              <th rowspan="3">Process</th>
              <th rowspan="3">Daily Target</th>
              <th rowspan="3">MAN (Man Power)</th>
              <th rowspan="3">MC (Machine)</th>
              <th rowspan="3">MAT (Material)</th>
              <th rowspan="3">Today Plan</th>
              <th rowspan="3">Planed Man Power</th>
              <th colspan="4" style="text-align: center;">Actual Card Completion</th>
              <th colspan="4" style="text-align: center;">Card Stock</th>
              <th rowspan="3">Monthly Total Cards</th>
              <th rowspan="3">Planned Cards</th>
              <th rowspan="3">Backlogs</th>
              <th rowspan="3">Avg(%)</th>
              <th rowspan="3">Action</th>

              <tr>
                <th colspan="2"  style="text-align: center;">Urgent</th>
                <th colspan="2"  style="text-align: center;">Regular</th>
                 <th colspan="2"  style="text-align: center;">Urgent</th>
                <th colspan="2"  style="text-align: center;">Regular</th>
              </tr>

              <tr>
                <th style="text-align: center;">RB (Round Body)</th>
                <th style="text-align: center;">CT (Cutting)</th>
                <th style="text-align: center;">RB (Round Body)</th>
                <th style="text-align: center;">CT (Cutting)</th>
                 <th style="text-align: center;">RB (Round Body)</th>
                <th style="text-align: center;">CT (Cutting)</th>
                <th style="text-align: center;">RB (Round Body)</th>
                <th style="text-align: center;">CT (Cutting)</th>
              </tr>

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
  <div class="modal-dialog modal-lg">

<input type="hidden" id="seletedDateRec">
<input type="hidden" id="seletedWcRec">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b><span id="titleNameR"></span></b></h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-3">
          <p>Select the Reasons</p>
          <select class="form-control select2"  id="selReason" name="selReason"  
          style="width:100%; display:inline;" data-placeholder="Reasons" >
          </select>
          <br>
        <p id="reasonmsg" style="color:red;"></p>
        </div>
        <div class="col-md-2">
          <p>Start time</p>
          <div class="row">
            <div class="col-md-5 col-xs-5 removePading">
              <select class="form-control select2 col-xs-2"  id="sth" name="sth"  
              style="width:100%;  display:inline;" data-placeholder="00">
              </select>
            </div>
            <div class="col-md-1 col-xs-1 removePading specialCss">
            :
            </div>
            <div class="col-md-5 col-xs-5 removePading">
              <select class="form-control select2 col-xs-2"  id="stm" name="stm"  
              style="width:100%;  display:inline;" data-placeholder="00">
              </select>
            </div>  
        </div>
        </div> 
        <div class="col-md-2">
          <p>End time</p>
          <div class="row">
            <div class="col-md-5 col-xs-5 removePading">
              <select class="form-control select2 col-xs-2"  id="edh" name="edh"  
              style="width:100%;  display:inline;" data-placeholder="00">
              </select>
            </div>  
            <div class="col-md-1 col-xs-1 removePading specialCss">
            :
            </div>
            <div class="col-md-5 col-xs-5 removePading">
              <select class="form-control select2 col-xs-2"  id="edm" name="edm"  
              style="width:100%;  display:inline;" data-placeholder="00">
              </select>
            </div>  
          </div> 
          <br>
              <p id="endtimemsg" style="color:red;"></p> 
        </div>
        <div class="col-md-3 col-xs-5">
        <p>Remarks</p>
        <textarea class="form-control"  id="remarks" name="remarks" style="width:100%;" 
        placeholder="Remarks"></textarea>
        <br>
        <p id="msg" style="color:red;"></p>
      </div>
      <div class="col-md-2 col-xs-5">
      <br>
      <br>
      <button type="button" class="btn btn-success btn-sm" id="saveReason"
       onclick="tempData.jobcard.validateTime();";>Save</button>
      </div>
      <div class="table-responsive col-md-12 santh">     
   
   <table class="table table-hover table-bordered" id="modaltable" border="1">
     <thead>
       <tr>
         <th rowspan="3">Reason</th>
         <th rowspan="3">Start time</th>
         <th rowspan="3">End time</th>
         <th rowspan="3">Remarks</th>
         <!-- <th rowspan="3">action</th> -->
       </tr>
     </thead>
     <tbody id="modaltableData">
      
     </tbody>
   </table>
 </div>
      </div>
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
        <h4 class="modal-title"><b><span id="titleNameV"></span></b></h4>
      </div>
      <div class="modal-body">


<table class="table table-hover table-bordered" id="modaltable" border="1">
     <thead>
       <tr>
         <th rowspan="3">Reason</th>
         <th rowspan="3">Start time</th>
         <th rowspan="3">End time</th>
         <th rowspan="3">Remarks</th>
         <!-- <th rowspan="3">action</th> -->
       </tr>
     </thead>
     <tbody id="viewReasonData">
      
     </tbody>
   </table>
      
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


</body>
</html>
