<?php
	include_once('config.php');
	session_start();
	$category=mysqli_real_escape_string($conn,$_POST['compcat']);
	$compid=mysqli_real_escape_string($conn,$_POST['compid']);
	$compid=strtolower($compid);
	$compcode=substr($compid, 0,3);
	$status=mysqli_real_escape_string($conn,$_POST['compstat']);
	$description=mysqli_real_escape_string($conn,$_POST['description']);
	$date=date('Y-m-d');
	if(!empty($category) and !empty($compid) and !empty($status) and !empty($description))
	{
		$statsql=mysqli_query($conn,"SELECT * FROM status WHERE status='{$status}'");
		$statusfetch=mysqli_fetch_assoc($statsql);
		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
		$catsql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category}'");
		$cat=mysqli_fetch_assoc($catsql);
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='disposed'");
		$locationfetch=mysqli_fetch_assoc($locationsql);
		if($cat['category_code']==$compcode)
		{

			if($compcode=="cpu" or $compcode=="ser" or $compcode=="lap" or $compcode=="mac")
			{
				$cpusql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id='{$compid}'");
				$compfetch=mysqli_fetch_assoc($cpusql);
				if(mysqli_num_rows($cpusql)>0)
				{
					if($compfetch['status']!=3)
					{
						if($statusfetch['status_id']==2)
						{
							$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
							$sysfetch=mysqli_fetch_assoc($syssql);
							if(mysqli_num_rows($syssql)>0)
							{
								echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to store";
							}
							else
							{
								if($statusfetch['status_id']==$comcompfetch['status'])
								{
									echo $compid." already in not working status and component in store";
								}
								else{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
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
								$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='NA' WHERE componentid='{$compid}'");
								
								echo $compid." updated to working status.Component present in store.";
							}
						}
						else
						{
							$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
							$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
							echo $compid." disposed and component moved to dipsose area.";	
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
							$syssql=mysqli_query($conn,"SELECT * FROM `system` WHERE ".$category."_id='{$compid}'");
							$sysfetch=mysqli_fetch_assoc($syssql);
							if(mysqli_num_rows($syssql)==1)
							{
								echo "This component seems to be assigned to system ".$sysfetch['system_id'].".This component must be replaced before moving to store";
							}
							else
							{
								if($statusfetch['status_id']==$comcompfetch['status'])
								{
									echo $compid." already in not working status and component in store";
								}
								else{
									$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='{$description}' WHERE componentid='{$compid}'");
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
								$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location=1,problem_description='NA' WHERE componentid='{$compid}'");
								
								echo $compid." updated to working status.Component present in store.";
							}
						}
						else
						{
							$updatecomp=mysqli_query($conn,"UPDATE components SET status={$status['status_id']},location={$locationfetch['lab_id']},problem_description='{$description}' WHERE componentid='{$compid}'");
							$insertdispose=mysqli_query($conn,"INSERT INTO `disposed`(`component_id`, `disposeddate`) VALUES ('{$compid}','{$date}')");
							echo $compid." disposed and component moved to dipsose area.";	
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