<?php
	include_once("config.php");
	session_start();
	$assigntype=mysqli_real_escape_string($conn,$_POST['radiovalue']);
	$assignid=mysqli_real_escape_string($conn,$_POST['assigncomponent']);
	$cat=strtolower($assignid);
	$cat=substr($cat,0,3);
	$cat=(string)$cat;
	echo $cat;
	$location=mysqli_real_escape_string($conn,$_POST['comploc']);
	if(!empty($assigntype) and !empty($assignid) and !empty($location))
	{
		$checkscompql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$assignid}'");
		$checkcpusql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$assignid}'");
		if(mysqli_num_rows($checkcpusql)>0 or mysqli_num_rows($checkscompql)>0)
		{
			if($cat=="cpu" or $cat=="lap" or $cat=="ser" or $cat=="mac")
			{
				
			}	
			else
			{
				echo "Entered component section";
			}
		}
		else
		{
			echo "Enter a proper component id";
		}
	}
	else
	{
		echo "All input Fields required";
	}
?>