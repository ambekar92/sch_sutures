<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>


<style>
  .content-wrapper {
    position: relative; 
    overflow: hidden; 
  }

  .commonPageHead {
      height: 100%;
      width: 100%;
      overflow-x: auto;
      overflow-y: hidden;
      resize: both;
      position: absolute;
      z-index: 1;
  }

  iframe {
  width: 100%;
  height: 100%;
  border: none;
}

</style>


<script>
$(document).ready(function() {
  var UserID_Name = $('#testIdName').val();
//alert(UserID_Name);
  
  document.getElementById('iframe').src = src="<?php echo $prodBaseURL; ?>/SUTURES-SCH/#/checklists/approve-checklist?"+UserID_Name;
});
</script>

<input type="hidden" name="testIdName" id="testIdName">

  <div class="content-wrapper">
    <!-- Main content -->
      <div class="commonPageHead">
    
        <iframe id="iframe"></iframe>
      </div>       
      <!-- src="<?php  //$prodBaseURL; ?>/SUTURES-SCH/#/checklists/approve-checklist?"  -->
      <!-- /.content -->
  </div>


