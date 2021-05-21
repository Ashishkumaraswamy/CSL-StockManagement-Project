<?php
	include_once("config.php");
	session_start();
	$assigntype=mysqli_real_escape_string($conn,$_POST['radiovalue']);
	$assignid=mysqli_real_escape_string($conn,$_POST['assassigncomponent']);
	$location=mysqli_real_escape_string($conn,$_POST['comploc']);
	if(!empty($assigntype) and !empty($assignid) and !empty($location))
	{
		echo "Entered if";
	}
	else
	{
		echo "All input Fields required";
	}
?>