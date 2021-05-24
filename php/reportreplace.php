<?php
	include_once('config.php');
	session_start();
	$category=mysqli_real_escape_string($conn,$_POST['compcat1']);
	$compid=mysqli_real_escape_string($conn,$_POST['compid1']);
	$repcompid=mysqli_real_escape_string($conn,$_POST['repcompid']);
	$repcompid=strtolower($repcompid);
	$compid=strtolower($compid);
	$compcode=substr($compid, 0,3);
	$repcompcode=substr($repcompid, 0,3);
	$status=mysqli_real_escape_string($conn,$_POST['compstat1']);
	$description=mysqli_real_escape_string($conn,$_POST['description1']);
	$date=date('Y-m-d');
	if(!empty($category) and !empty($compid) and !empty($status) and !empty($description) and !empty($repcompid))
	{
		$statsql=mysqli_query($conn,"SELECT * FROM status WHERE status='{$status}'");
		$statusfetch=mysqli_fetch_assoc($statsql);
		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
		$catsql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
		$cat=mysqli_fetch_assoc($catsql);
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
		$locationfetch=mysqli_fetch_assoc($locationsql);
		if($cat['category_code']==$compcode and $cat['category_code']==$repcompcode)
		{
			$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
			$sysfetch=mysqli_fetch_assoc($syssql);	
			$repsyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$repcompid}'");
			$repsysfetch=mysqli_fetch_assoc($repsyssql);
			if(mysqli_num_rows($syssql)>0)
			{
				if($compcode=="cpu" or $compcode=="ser" or $compcode=="lap" or $compcode=="mac")
				{
					$compsql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$compid}'");
					$repcompsql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$repcompid}'");
					$compfetch=mysqli_fetch_assoc($compsql);
					$repcompfetch=mysqli_fetch_assoc($repcompsql);
					if(mysqli_num_rows($compsql)>0)
					{
						if(mysqli_num_rows($repcompsql)>0)
						{
							if($repcompfetch['status']!=3)
							{
								if($compfetch['status']!=3)
								{
									if($statusfetch['status_id']==2)
									{
										if($repcompfetch['status']==1)
										{
											if($repcompfetch['location']==1)
											{
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sysfetch['location_id']} WHERE cpu_id='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." set to not working and moved to store.";
											}
											else
											{

												echo $repcompid." assigned to system ".$repsysfetch['system_id'].". Therefore cannot assign this component.";
											}
										}
										else
										{
											echo $repcompid." is in not working status.Cannot use this component to replace";
										}
									}
									else if($statusfetch['status_id']==1)
									{
										if($repcompfetch['location']==1)
											{
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='NA' WHERE cpu_id='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sysfetch['location_id']} WHERE cpu_id='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$repsysfetch['location']},problem_description='NA' WHERE cpu_id='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcom['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sysfetch['location_id']} WHERE cpu_id='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											$updaterepsys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$comp['componentid']} WHERE system_id={$repsysfetch['system_id']}");	
											}
									}
								}
								else
								{
									echo "The component given to replace ".$compid." seems to be disposed enter a proper id";
								}
							}
							else
							{
								echo "The component given to replace ".$repcompid." seems to be disposed enter a proper id";
							}
						}
						else
						{
							echo $repcompid."- does not exist";
						}
					}
					else
					{
						echo $compid."- does not exist";
					}
				}	
				else
				{
					$compsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$compid}'");
					$repcompsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$repcompid}'");
					$compfetch=mysqli_fetch_assoc($compsql);
					$repcompfetch=mysqli_fetch_assoc($repcompsql);
					if(mysqli_num_rows($compsql)>0)
					{
						if(mysqli_num_rows($repcompsql)>0)
						{
							if($repcompfetch['status']!=3)
							{
								if($compfetch['status']!=3)
								{
									if($statusfetch['status_id']==2)
									{
										if($repcompfetch['status']==1)
										{
											if($repcompfetch['location']==1)
											{
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sysfetch['location_id']} WHERE componentid='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." set to not working and moved to store.";
											}
											else
											{

												echo $repcompid." assigned to system ".$repsysfetch['system_id'].". Therefore cannot assign this component.";
											}
										}
										else
										{
											echo $repcompid." is in not working status.Cannot use this component to replace";
										}
									}
									else if($statusfetch['status_id']==1)
									{
										if($repcompfetch['location']==1)
											{
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='NA' WHERE componentid='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sysfetch['location_id']} WHERE componentid='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location={$repsysfetch['location']},problem_description='NA' WHERE componentid='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcom['componentid']} WHERE system_id={$sysfetch['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sysfetch['location_id']} WHERE componentid='{$repcompid}'");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											$updaterepsys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$comp['componentid']} WHERE system_id={$repsysfetch['system_id']}");	
											}
									}
								}
								else
								{
									echo "The component given to replace ".$compid." seems to be disposed enter a proper id";
								}
							}
							else
							{
								echo "The component given to replace ".$repcompid." seems to be disposed enter a proper id";
							}
						}
						else
						{
							echo $repcompid."- does not exist";
						}
					}
					else
					{
						echo $compid."- does not exist";
					}
				}
			}
			else
			{
				echo $compid." not assigned to a system so this component can't be replaced.\nEnter a component id that is assigned to a system";
			}
		}
		else
		{
			echo "Category and code mismatch";
		}
	}
	else
	{
		echo "All input fields required";
	}
?>