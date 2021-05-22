<?php
	include_once("config.php");
	session_start();
	$category=mysqli_real_escape_string($conn,$_POST['compcat']);
	$category=strtolower($category);
	$compid=mysqli_real_escape_string($conn,$_POST['compid']);
	$compid=strtolower($compid);
	$compcode=substr($compid, 0,3);
	$checked=mysqli_real_escape_string($conn,$_POST['check']);
	$repcompid=($checked=="checked")?mysqli_real_escape_string($conn,$_POST['repcompid']):"none";
	$repcompid=strtolower($repcompid);
	$repcompcode=substr($repcompid, 0,3);
	$status=mysqli_real_escape_string($conn,$_POST['compstat']);
	$description=mysqli_real_escape_string($conn,$_POST['description']);
	$date=date('Y-m-d');
	if(!empty($category) and !empty($compid) and !empty($status) and !empty($description) and !empty($repcompid))
	{
		$statsql=mysqli_query($conn,"SELECT * FROM status WHERE status='{$status}'");
		if($statsql)
			$status=mysqli_fetch_assoc($statsql);
		else
			echo "failure";
		$catsql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
		$cat=mysqli_fetch_assoc($catsql);
		if($cat['category_code']==$compcode)
		{
			if($compcode!="cpu")
			{	
				$compsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$compid}'");
				$repcompsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$repcompid}'");
				if(mysqli_num_rows($compsql)>0 and mysqli_num_rows($compsql)>0)
				{
					$comp=mysqli_fetch_assoc($compsql);
					$repcom=mysqli_fetch_assoc($repcompsql);
					if($comp['location']!=1)
					{
						$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
						if($repcompid!="none")
						{
							if(mysqli_num_rows($syssql)>0)
							{
								$sys=mysqli_fetch_assoc($syssql);
								if($status=="not working")
								{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
									$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcom['componentid']}' WHERE system_id={$sys['system_id']}");
									$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sys['location_id']} WHERE componentid='{$repcompid}'");
									if($updatecomp and $updatesys and $updaterepcomp)
									{
										echo $compid." status updated and moved to store. Also its assigned system ".$sys['system_id']." was replaced with".$repcompid.".";
									}
									else
									{
										echo "update error";
									}
								}
								else if($status=="working")
								{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
									if($updatecomp)
									{
										echo $compid." status updated to Working.";
									}
									else
									{
										echo "update error";
									}
								}
								else
								{
									$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
									$locationfetch=mysqli_fetch_assoc($locationsql);
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
									$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcom['componentid']}' WHERE system_id={$sys['system_id']}");
									$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sys['location_id']} WHERE componentid='{$repcompid}'");
									$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
									if($insertdispose)
									{
										echo $compid." status updated and disposed. Also its assigned system ".$sys['system_id']." was replaced with".$repcompid.".";
									}
									else
									{
										echo "update error Here";
									}
								}
							}
							else
							{
								"No system found";
							}
						}
						else{
							if(mysqli_num_rows($syssql)>0)
							{
								$sys=mysqli_fetch_assoc($syssql);
								if($status=="not working")
								{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
									if($updatecomp)
									{
										echo $compid." status updated and moved to store.";
									}
									else
									{
										echo "update error";
									}
								}
								else if($status=="working")
								{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
									if($updatecomp)
									{
										echo $compid." status updated to working.";
									}
									else
									{
										echo "update error";
									}
								}
								else
								{
									$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
									$locationfetch=mysqli_fetch_assoc($locationsql);
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
									$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
									if($insertdispose)
									{
										echo $compid." status updated and disposed";
									}
									else
									{
										echo "update error Here";
									}
								}
							}
						}
					}
					else
					{
						$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
							if($updatecomp)
							{
								echo "Updated Successfully and item moved to store";
							}
							else{
								echo "Update Failure";
							}
					}
				}
				else
				{
					echo $compid." does not exist";
				}
			}
			else
			{
				$cpusql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$compid}'");
				$repcompsql==mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$repcompid}'");
				if(mysqli_num_rows($cpusql)>0 and mysqli_num_rows($repcompsql)>0)
				{
					$comp=mysqli_fetch_assoc($cpusql);
					$repcompsql=mysqli_fetch_assoc($repcompsql);
					if($comp['location']!=1)
					{
						$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
						if($repcompid!="none")
						{
							if(mysqli_num_rows($syssql)>0)
							{
								$sys=mysqli_fetch_assoc($syssql);
								$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");
								$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcom['componentid']} WHERE system_id={$sys['system_id']}");
								$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sys['location_id']} WHERE cpu_id='{$repcompid}'");
								if($updatecomp and $updatesys and $updaterepcomp)
								{
									echo $compid." status updated and moved to store. Also its assigned system ".$sys['system_id']." was replaced with".$repcompid.".";
								}
								else
								{
									echo "update error";
								}
							}
							else
							{
								"No system found";
							}
						}
						else{
							if(mysqli_num_rows($syssql)>0)
							{
								$sys=mysqli_fetch_assoc($syssql);
								$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");
								if($updatecomp)
								{
									echo $compid." status updated and moved to store.";
								}
								else
								{
									echo "update error";
								}
							}
							else
							{
								"No system found";
							}
						}
					}
					else
					{
						$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']}, location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
							if($updatecomp)
							{
								echo "Updated Successfully and item moved to store";
							}
							else{
								echo "Update Failure";
							}
					}
				}
				else
				{
					echo $compid." does not exist";
				}	
			}
		}
		else
		{
			echo "category and code mismatch";
		}
	}
	else
	{
		echo "All input fields required";
	}
?>