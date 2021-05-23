<?php
	include_once("config.php");
	session_start();
	$assigntype=mysqli_real_escape_string($conn,$_POST['radiovalue']);
	$assignid=mysqli_real_escape_string($conn,$_POST['fromassignsystem']);
	$toassignid=mysqli_real_escape_string($conn,$_POST['toassignsystem']);
	$location=mysqli_real_escape_string($conn,$_POST['sysloc']);

	if(!empty($assigntype) and !empty($assignid) and !empty($location))
	{
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='{$location}'");
		if($locationsql)
		{
			$locationid=mysqli_fetch_assoc($locationsql);
			$i=$assignid;
			while($i<=$toassignid)
			{
				$checksyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE system_id={$i}");
				$system=mysqli_fetch_assoc($checksyssql);
				if(mysqli_num_rows($checksyssql)>0)
				{
					$updatesys=mysqli_query($conn,"UPDATE `system` SET location_id={$locationid['lab_id']} WHERE system_id={$i}");
					$updatemou=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['mouse_id']}'");
					$updatekey=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['keyboard_id']}'");
					$updatemon=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$system['monitor_id']}'");
					$updatecpu=mysqli_query($conn,"UPDATE cpu SET location={$locationid['lab_id']} WHERE cpu_id='{$system['cpu_id']}'");
					if($updatesys and $updatecpu and $updatemon and $updatekey and $updatemou)
					{
						$sql5 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$i}','Loaction assigned is - {$location}','Assign location to System.')");
						$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$system['mouse_id']}','Loaction assigned is - {$location}','Assign location to System - mouse')");
						$sql7 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$system['keyboard_id']}','Loaction assigned is - {$location}','Assign location to System - keyboard')");
						$sql8 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$system['monitor_id']}','Loaction assigned is - {$location}','Assign location to System - monitor')");
						$sql9 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$system['cpu_id']}','Loaction assigned is - {$location}','Assign location to System - CPU')");
						echo "System ".$i." moved to ".$location."\n";
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
				$i++;
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