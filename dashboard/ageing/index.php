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
      margin-bottom: 100px;
  }

  iframe {
  width: 100%;
  height: 100%;
  border: none;
  overflow-y: scroll !important;

}

</style>

  <div class="content-wrapper">
      <!-- Main content -->
        <div class="commonPageHead">
          <iframe src="<?php echo $prodBaseURL; ?>/SUTURES-SCH/#/reports/ageing-report"></iframe>
        </div>       
        <!-- /.content -->
  </div>




