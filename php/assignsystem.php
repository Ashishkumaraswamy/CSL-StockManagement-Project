<?php
	include_once("config.php");
	session_start();
	$assigntype=mysqli_real_escape_string($conn,$_POST['radiovalue']);
	$assignid=mysqli_real_escape_string($conn,$_POST['assignsystem']);
	$location=mysqli_real_escape_string($conn,$_POST['sysloc']);
	if(!empty($assigntype) and !empty($assignid) and !empty($location))
	{
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='{$location}'");
		if($locationsql)
		{
			$locationid=mysqli_fetch_assoc($locationsql);
			$checksyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE system_id=$assignid");
			$system=mysqli_fetch_assoc($checksyssql);
			if(mysqli_num_rows($checksyssql)>0)
			{
				$updatesys=mysqli_query($conn,"UPDATE `system` SET location_id={$locationid['lab_id']} WHERE cpu_id='{$assignid}'");
				$updatemou=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['mouse_id']}'");
				$updatekey=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['keyboard_id']}'");
				$updatemon=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['monitor_id']}'");
				$updatecpu=mysqli_query($conn,"UPDATE cpu SET location={$locationid['lab_id']} WHERE cpu_id='{$system['cpu_id']}'");
				if($updatesys and $updatecpu and $updatemon and $updatekey and $updatemou)
				{
					echo "System ".$assignid." moved to ".$location;
				}
				else
				{
					echo "Update Failure";
				}
			}
			else
			{
				echo "Enter a proper component id";
			}
		}
		else{
			echo "location sql failure";
		}
	}
	else
	{
		echo "All input Fields required";
	}
?>