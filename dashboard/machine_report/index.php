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

  <div class="content-wrapper">
    <!-- Main content -->
      <div class="commonPageHead">  
        <iframe src="<?php echo $prodBaseURL; ?>/SUTURES-SCH/#/reports/machine-jobcards"></iframe>
      </div>       
    <!-- /.content -->
  </div>

  <script>
    $(document).ready(function() {
    var eventParams = {
      "Module" : "Reports", // Standard Event Attribute
    }
    UsageAnalytics.logEvent("Machine Report", eventParams); 
    //UsageAnalytics.logEvent("Generate Jobcard", eventParams);
    });
  </script>



