<?php
	include_once("config.php");
	session_start();
	$assigntype=mysqli_real_escape_string($conn,$_POST['radiovalue']);
	$assignid=mysqli_real_escape_string($conn,$_POST['assigncomponent']);
	$cat=strtoupper($assignid);
	$cat=substr($cat,0,3);
	$cat=(string)$cat;
	$location=mysqli_real_escape_string($conn,$_POST['comploc']);
	if(!empty($assigntype) and !empty($assignid) and !empty($location))
	{
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='{$location}'");
		if($locationsql)
		{
			$locationid=mysqli_fetch_assoc($locationsql);
			$checkscompql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$assignid}'");
			$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category_code='{$cat}'");
			$checkcpusql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$assignid}'");
			if(mysqli_num_rows($checkcpusql)>0 or mysqli_num_rows($checkscompql)>0)
			{
				if($cat=="CPU" or $cat=="LAP" or $cat=="SRV" or $cat=="MAC")
				{
					$category=mysqli_fetch_assoc($categorysql);
					if($cat=="cpu")
					{
						$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category['category']."_id='{$assignid}'");
						if(mysqli_num_rows($syssql)==0)
						{
							$cpufetch=mysqli_fetch_assoc($checkcpusql);
								if($cpufetch['status']==1)
								{
									$updatecpu=mysqli_query($conn,"UPDATE cpu SET location={$locationid['lab_id']} WHERE cpu_id='{$assignid}'");
									echo $assignid." moved to ".$location;
								}
								else
								{
									echo "Component in not working status.Cannot place this component in the lab";
								}
						}
						else
						{
							$sysfetch=mysqli_fetch_assoc($syssql);
							echo "Component assigned to system ".$sysfetch['system_id']." cannot move this component to lab.";
						}
					}
					else
					{
						$cpufetch=mysqli_fetch_assoc($checkcpusql);
						$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
						$locationfetch=mysqli_fetch_assoc($locationsql);
						if($cpufetch['location']!=$locationfetch['lab_id'])
						{
							if($cpufetch['status']==1)
							{
								$updatecpu=mysqli_query($conn,"UPDATE cpu SET location={$locationid['lab_id']} WHERE cpu_id='{$assignid}'");
								echo $assignid." moved to ".$location;
							}
							else
							{
								echo "Component in not working status.Cannot place this component in the lab";
							}
						}
						else
						{
							echo "Component in dump cannot assign location";
						}
					}
						
				}	
				else
				{
					$category=mysqli_fetch_assoc($categorysql);
					if($cat=="MOU" or $cat=="MNT" or $cat=="KBD")
					{
						$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category['category']."_id='{$assignid}'");
						if(mysqli_num_rows($syssql)==0)
						{
							$compfetch=mysqli_fetch_assoc($checkscompql);
							if ($compfetch['status']==1)
							{
								$updatecpu=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$assignid}'");
								echo $assignid." moved to ".$location;
							}
							else
							{
								echo "Component in not working status.Cannot place this component in the lab";
							}
						}
						else
						{
							$sysfetch=mysqli_fetch_assoc($syssql);
							echo "Component assigned to system ".$sysfetch['system_id']." cannot move this component to lab.";
						}
					}
					else
					{
						$compfetch=mysqli_fetch_assoc($checkscompql);
						$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
						$locationfetch=mysqli_fetch_assoc($locationsql);
						echo $compfetch['location'];
							if($compfetch['location']!=$locationfetch['lab_id'])
							{
								if ($compfetch['status']==1)
								{
									$updatecpu=mysqli_query($conn,"UPDATE components SET location={$locationid['lab_id']} WHERE componentid='{$assignid}'");
									echo $assignid." moved to ".$location;
								}
								else
								{
									echo "Component in not working status.Cannot place this component in the lab";
								}
							}
							else
							{
								echo "Component in dump cannot assign location.";
							}
					}
				}
				
				//$sql5 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$assignid}','Loaction assigned is - {$location}','Assign location to components.')");
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