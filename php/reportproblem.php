<?php
	include_once('config.php');
	session_start();
	$category=mysqli_real_escape_string($conn,$_POST['compcat']);
	$compid=mysqli_real_escape_string($conn,$_POST['compid']);
	$compid=strtoupper($compid);
	$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
	$categoryfetch=mysqli_fetch_assoc($categorysql);
	$compcode=$categoryfetch['category_code'];
	$inpcompcode=substr($compid,0,3);
	$status=mysqli_real_escape_string($conn,$_POST['compstat']);
	$description=mysqli_real_escape_string($conn,$_POST['description']);
	date_default_timezone_set("Asia/Kolkata");
	$date=date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	if(!empty($category) and !empty($compid) and !empty($status) and !empty($description))
	{
		$statsql=mysqli_query($conn,"SELECT * FROM status WHERE status='{$status}'");
		$statusfetch=mysqli_fetch_assoc($statsql);
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
		$locationfetch=mysqli_fetch_assoc($locationsql);
		if($compcode==$inpcompcode)
		{
			if($compcode=="CPU" or $compcode=="SRV" or $compcode=="LAP" or $compcode=="MAC")
			{
				$cpusql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$compid}'");
				$compfetch=mysqli_fetch_assoc($cpusql);
				if(mysqli_num_rows($cpusql)>0)
				{
					if($compfetch['status']!=3)
					{
						if($statusfetch['status_id']==2)
						{
							if($compcode=="CPU")
							{
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);
								if(mysqli_num_rows($syssql)>0)
								{
									echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to store";
								}
								else
								{
									if($statusfetch['status_id']==$compfetch['status'])
									{
										echo $compid." already in not working status and component in store";
									}
									else{

										$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");
										
										$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','status updated to not working.','{$datetime}')");

										echo $compid." status updated to not working.Component already in store.";
									}
								}
							}
							else
							{
								if($statusfetch['status_id']==$compfetch['status'])
									{
										echo $compid." already in not working status and component in store";
									}
									else{

										$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE cpu_id='{$compid}'");

										$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
										
										$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','status updated to not working.','{$datetime}')");

										echo $compid." status updated to not working.Component already in store.";
									}	
							}
						}
						else if($statusfetch['status_id']==1)
						{
							if($statusfetch['status_id']==$compfetch['status'])
							{
								echo $compid." already in working status";
							}
							else
							{
								$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location=1,problem_description='NA' WHERE cpu_id='{$compid}'");
								
								$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','updated to working status.','{$datetime}')");

								echo $compid." updated to working status.Component present in store.";
							}
						}
						else
						{
							if($compcode=="CPU")
							{
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);
								if(mysqli_num_rows($syssql)==1)
								{
									echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to dump";
								}
								else
								{
									$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE cpu_id='{$compid}'");
									$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
									$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component moved to dipsose area','Disposed a Component.','{$datetime}')");
									echo $compid." disposed and component moved to dipsose area.";	
								}
							}
							else
							{
								$updatecomp=mysqli_query($conn,"UPDATE cpu SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE cpu_id='{$compid}'");
								$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
								$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component moved to dipsose area','Disposed a Component.','{$datetime}')");
								echo $compid." disposed and component moved to dipsose area.";	
							}
						}
					}
					else
					{
						echo "Sorry this component seems to be disposed.\n";
					}
				}
				else
				{
					echo "This Component id does not exist.";
				}
			}	
			else
			{
				$compsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid='{$compid}'");
				$compfetch=mysqli_fetch_assoc($compsql);
				if(mysqli_num_rows($compsql)>0)
				{
					if($compfetch['status']!=3)
					{
						if($statusfetch['status_id']==2)
						{
							if($compcode=="MOU" or $compcode=="MNT" or $compcode=="KBD")
							{	
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);
								if(mysqli_num_rows($syssql)==1)
								{
									echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to store";
								}
								else
								{
									if($statusfetch['status_id']==$compfetch['status'])
									{
										echo $compid." already in not working status and component in store";
									}
									else{

										$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
										$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','status updated to not working.','{$datetime}')");
										echo $compid." status updated to not working.Component already in store.";
									}
								}
							}
							else
							{
								if($statusfetch['status_id']==$compfetch['status'])
									{
										echo $compid." already in not working status and component in store";
									}
									else{

										$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
										
										$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','status updated to not working.','{$datetime}')");
										echo $compid." status updated to not working.Component already in store.";
									}
							}
						}
						else if($statusfetch['status_id']==1)
						{
							if($statusfetch['status_id']==$compfetch['status'])
							{
								echo $compid." already in working status";
							}
							else{
								$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location=1,problem_description='NA' WHERE componentid='{$compid}'");
								
								$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component already in store.','updated to working status.','{$datetime}')");

								echo $compid." updated to working status.Component present in store.";
							}
						}
						else
						{
							if($compcode=="MOU" or $compcode=="MNT" or $compcode=="KBD")
							{
								$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
								$sysfetch=mysqli_fetch_assoc($syssql);
								if(mysqli_num_rows($syssql)==1)
								{
									echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to dump";
								}
								else
								{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
									$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
									$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component moved to dipsose area','Disposed a Component.','{$datetime}')");
									echo $compid." disposed and component moved to dipsose area.";	
								}
							}
							else{
								$updatecomp=mysqli_query($conn,"UPDATE components SET status={$statusfetch['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
								$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
								$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose,time) VALUES({$_SESSION['unique_id']},'{$compid}','Component moved to dipsose area','Disposed a Component.','{$datetime}')");
								echo $compid." disposed and component moved to dipsose area.";		
							}
						}
					}
					else
					{
						echo "Sorry this component seems to be disposed.\n";
					}
				}
				else
				{
					echo "This Component id does not exist.";
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