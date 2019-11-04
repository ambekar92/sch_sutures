<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<?php error_reporting(0); ?>

<script src="treed3.js" charset="utf-8"></script>

<style>
  .node {
    cursor: pointer;
}
.node circle {
    fill: #fff;
    stroke: steelblue;
    stroke-width: 1.5px;
}
.node text {
    font: 10px sans-serif;
}
.link {
    fill: none;
    stroke: #ccc;
    stroke-width: 1.5px;
}

body {
    overflow: hidden;
}

svg {
  width: 100% !important;
}
</style>



  <div class="content-wrapper">
    <!-- Main content -->
<!-- partial:index.partial.html -->

<div id="body"></div>
<!-- partial -->
  <script  src="./script.js"></script>
    <!-- /.content -->
  </div>



