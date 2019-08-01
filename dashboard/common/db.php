<?php
error_reporting(0);
session_start(); 

	$con = mysqli_connect("localhost","adminqc","qcadmin","sch_sutures_dev");
	//$con = mysqli_connect("52.66.150.197","root","SutureS@Eim$#7","sch_sutures_dev");
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{

	}

$userSession=$_SESSION['schAdminSession'];

?>
