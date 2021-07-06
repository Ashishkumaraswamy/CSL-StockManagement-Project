<?php
	include_once('config.php');
	session_start();
	$category=mysqli_real_escape_string($conn,$_POST['compcat1']);
	$inpcompid=mysqli_real_escape_string($conn,$_POST['compid1']);
	$repcompid=mysqli_real_escape_string($conn,$_POST['repcompid']);
	$repcompid=strtoupper($repcompid);
	$compid=strtoupper($inpcompid);
	$inpcompcode=substr($inpcompid,0,3);
	$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
	$categoryfetch=mysqli_fetch_assoc($categorysql);
	$compcode=$categoryfetch['category_code'];
	$repcompcode=substr($repcompid,0,3);
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
		if($cat['category_code']==$inpcompcode and $cat['category_code']==$repcompcode)
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
						if($compfetch['location']!=1 and $compfetch['location']!=$locationfetch['lab_id'])
						{	
							if($compcode=="cpu")
							{
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);	
								$repsyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$repcompid}'");
								$repsysfetch=mysqli_fetch_assoc($repsyssql);
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
													$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['cpu_id']} WHERE system_id={$sysfetch['system_id']}");
													$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sysfetch['location_id']} WHERE cpu_id='{$repcompid}'");

													$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,set to not working and moved to store.')");


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
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcompfetch['cpu_id']} WHERE system_id={$sysfetch['system_id']}");
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$sysfetch['location_id']} WHERE cpu_id='{$repcompid}'");
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE cpu_id='{$compid}'");
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcompfetch['cpu_id']}' WHERE system_id={$sysfetch['system_id']}");
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$templocation} WHERE cpu_id='{$repcompid}'");
												$updaterepsys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$compfetch['cpu_id']}' WHERE system_id={$repsysfetch['system_id']}");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".Locations of the two components and system swapped.";
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
											}
										}
										else
										{
											if($repcompfetch['location']==1 and $repcompfetch['status']==1)
											{
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$compfetch['location']} WHERE cpu_id='{$repcompid}'");
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcompfetch['cpu_id']}' WHERE system_id={$sysfetch['system_id']}");
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE cpu_id='{$compid}'");
												echo $repcompid." replaced ".$compid.".".$compid." moved to dump.";
											}
											else
											{
												echo $repcompid." is in not in store or not working.Cannot use this component to replace";
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
													$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$compfetch['location']} WHERE cpu_id='{$repcompid}'");
													$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");
													$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$repcompid}','Replaced ID - ".$repcompid.".".$compid." set to not working and moved to store.')");


													echo $compid." replaced by ".$repcompid.".".$compid." set to not working and moved to store.";
												}
												else
												{

													echo $repcompid." assigned to another lab. Therefore cannot assign this component.";
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
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE cpu_id='{$compid}'");
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$templocation} WHERE cpu_id='{$repcompid}'");
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
												echo $compid." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE cpu_id='{$compid}'");
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$templocation} WHERE cpu_id='{$repcompid}'");
												echo $compid." replaced by ".$repcompid.".Locations of the components swapped";
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
												$updaterepsys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$comp['componentid']} WHERE system_id={$repsysfetch['system_id']}");	
											}
										}
										else
										{
											if($repcompfetch['status']==1)
											{
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$compfetch['location']} WHERE cpu_id='{$repcompid}'");	
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE cpu_id='{$compid}'");
												echo $repcompid." replaced ".$compid.".".$compid." moved to dump.";
											}
											else
											{
												echo $repcompid." is in not working status.Cannot use this component to replace";
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
						}
						else
						{
							echo $compid." not available in lab cannot replace a component not present in lab.";
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
						if($compfetch['location']!=1 and $compfetch['location']!=$locationfetch['lab_id'])
						{					
							if($compcode=="mou" or $compcode=="mon" or $compcode=="key")
							{
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);	
								$repsyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$repcompid}'");
								$repsysfetch=mysqli_fetch_assoc($repsyssql);
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
													$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcompfetch['componentid']}' WHERE system_id={$sysfetch['system_id']}");
													$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sysfetch['location_id']} WHERE componentid='{$repcompid}'");

													$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,set to not working and moved to store.')");


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
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcompfetch['componentid']}' WHERE system_id={$sysfetch['system_id']}");
												$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$sysfetch['location_id']} WHERE componentid='{$repcompid}'");
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE componentid='{$compid}'");
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$repcompfetch['componentid']}' WHERE system_id={$sysfetch['system_id']}");
												$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$templocation} WHERE componentid='{$repcompid}'");
												$updaterepsys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`='{$compfetch['componentid']}' WHERE system_id={$repsysfetch['system_id']}");
												echo $compid." assigned to system ".$sysfetch['system_id']." replaced by ".$repcompid.".".$compid." moved to store.";
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
													
											}
										}
										else
										{
											if($repcompfetch['status']==1)
											{
												$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$compfetch['location']} WHERE componentid='{$repcompid}'");
												$updatesys=mysqli_query($conn,"UPDATE `system` SET `".$category."_id`={$repcom['componentid']} WHERE system_id={$sysfetch['system_id']}");
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
												echo $repcompid." replaced ".$compid.".".$compid." moved to dump.";
											}
											else
											{
												echo $repcompid." is in not working status.Cannot use this component to replace";
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
													$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$compfetch['location_id']} WHERE componentid='{$repcompid}'");
													$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
													$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,set to not working and moved to store.')");


													echo $compid." replaced by ".$repcompid.".".$compid." set to not working and moved to store.";
												}
												else
												{

													echo $repcompid." assigned to another lab. Therefore cannot assign this component.";
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
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE componentid='{$compid}'");
												$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$templocation} WHERE componentid='{$repcompid}'");
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$sysfetch['system_id']}','Replaced ID - ".$repcompid.".".$compid." ','Assigned to system to replace,moved to store.')");
												echo $compid." replaced by ".$repcompid.".".$compid." moved to store.";
											}
											else
											{
												$templocation=$compfetch['location'];
												$updatecpu=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$repcompfetch['location']},problem_description='NA' WHERE cpu_id='{$compid}'");
												$updaterepcomp=mysqli_query($conn,"UPDATE cpu SET location={$templocation} WHERE cpu_id='{$repcompid}'");
												echo $compid." replaced by ".$repcompid.".Locations of the components swapped";
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{repcompfetch['componentid']}','Replaced ID - ".$repcompid.".".$compid.", replaced by ".$repcompid.".Locations of the components swapped')");
											}
										}
										else
										{
											if($repcompfetch['status']==1)
											{
												$updaterepcomp=mysqli_query($conn,"UPDATE components SET location={$compfetch['location']} WHERE componentid='{$repcompid}'");	
												$updatecpu=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
												echo $repcompid." replaced ".$compid.".".$compid." moved to dump.";
												$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{repcompfetch['componentid']}','Replaced ID - ".$repcompid.".".$compid.", replaced ".$compid.".".$compid." moved to dump.')");
											}
											else
											{
												echo $repcompid." is in not working status.Cannot use this component to replace";
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
						}
						else
						{
							
							echo $compid." not available in lab cannot replace a component not present in lab.";
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
			echo "Category and code mismatch";
		}
	}
	else
	{
		echo "All input fields required";
	}
?>