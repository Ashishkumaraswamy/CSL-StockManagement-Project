<?php
	include_once("config.php");
	session_start();
	$location=mysqli_real_escape_string($conn,$_POST['labcat']);
	$output="";
	if(!empty($location))
	{
		$locationsql=mysqli_query($conn,"SELECT * FROM location WHERE lab_name='{$location}'");
		if($locationsql){
			$location=mysqli_fetch_assoc($locationsql);
			$syslocationsql=mysqli_query($conn,"SELECT count(*) AS labsyscount FROM `system` WHERE location_id={$location['lab_id']}");
			$compcntsql=mysqli_query($conn,"SELECT count(*) AS compcnt FROM components WHERE location={$location['lab_id']}");
			$cpucntsql=mysqli_query($conn,"SELECT count(*) AS cpucnt FROM cpu WHERE location={$location['lab_id']}");
			$cpucnt=mysqli_fetch_assoc($cpucntsql);
			$compcnt=mysqli_fetch_assoc($compcntsql);
			if($syslocationsql)
			{
				$syslocation=mysqli_fetch_assoc($syslocationsql);
				$labsyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE location_id={$location['lab_id']}");
				if(mysqli_num_rows($labsyssql)+$cpucnt['cpucnt']+$compcnt['compcnt']>0)
				{
					 $output.='<div class="row">
			          		<div class="col-md-4">
			          		</div>
			          		<h4>Location:'.$location['lab_name'].'</h4>
			          	   </div>
			          	   <br>
			          	   <div class="row">
			          		<div class="col-md-3">
			          		</div>
			   				<h4>Number of Systems:'.$syslocation['labsyscount'].'</h4>
			          	   </div>
			          	   <br><br>
			    			<div class="col-sm-offset-2 col-md-9 text-center">
			    			<table class="table table-hover" border="1">
							  <tr>
							    <th>System_ID</th>
							    <th>Mouse_ID</th>
							    <th>Monitor_ID</th>
							    <th>Keyboard_ID</th>
							    <th>CPU_ID</th>
							  </tr>';
					while($labsys=mysqli_fetch_assoc($labsyssql))
					{
						$output .='<tr>
						    <td>'.$labsys['system_id'].'</td>
						    <td>'.$labsys['mouse_id'].'</td>
						    <td>'.$labsys['keyboard_id'].'</td>
						    <td>'.$labsys['monitor_id'].'</td>
						    <td>'.$labsys['cpu_id'].'</td>
						  </tr>';
					}
					$output .='</table>';
					$complocationcntsql=mysqli_query($conn,"SELECT count(*) as complocationcnt FROM components WHERE location={$location['lab_id']} AND componentid NOT LIKE 'mou%' AND componentid NOT LIKE 'key%' AND componentid NOT LIKE 'mon%'");
					$cpulocationcntsql=mysqli_query($conn,"SELECT count(*) as cpulocationcnt FROM cpu WHERE location={$location['lab_id']} AND cpu_id NOT LIKE 'cpu%'");
					$complocationcnt=mysqli_fetch_assoc($complocationcntsql);
					$cpulocationcnt=mysqli_fetch_assoc($cpulocationcntsql);
					$othercnt=$cpulocationcnt['cpulocationcnt']+$complocationcnt['complocationcnt'];
					if($othercnt==0)
					{
						$output.='<br><br><div class="row">
			          		<div class="col-md-2">
			          		</div>
			          		<center><h4>No Other Components available</h4></center>
			        </div>';
			        	echo $output;
					}
					else
					{
	    				$output.='<div class="row">
				          		<div class="col-md-4">
				          		</div>
				          		<h4>Other Components</h4>
				        </div>
	    				<div class="col-sm-offset-2 col-md-9 text-center">
				    			<table class="table table-hover">
				    			<tr>
								    <th>Category</th>
								    <th>Component_ID</th>
								    <th>Description</th>
								    <th>Status</th>
								  </tr>';
	    				$catsql=mysqli_query($conn,"SELECT * FROM category WHERE category_code NOT IN ('cpu','mon','mou','key')");
	    				if($catsql)
	    				{
	    					$count=0;
	    					while($cat=mysqli_fetch_assoc($catsql))
	    					{
	    						if($cat['category_code']=='SRV' or $cat['category_code']=='MAC' or $cat['category_code']=='LAP')
	    						{
	    							$category_code=$cat['category_code'];
	    							$catfetchsql=mysqli_query($conn,"SELECT * FROM cpu WHERE cpu_id LIKE '$category_code%' AND location={$location['lab_id']}");
	    							if(mysqli_num_rows($catfetchsql)>0)
	    							{
	    								while($catfetch=mysqli_fetch_assoc($catfetchsql))
	    								{
	    									$desc=$catfetch['RAM']." GB RAM,".$catfetch['processor_series'].",".$catfetch['storage']." GB Storage";
	    									$count=$count+1;
	    									$status=mysqli_query($conn,"SELECT * FROM status WHERE status_id={$catfetch['status']}");
	    									$statusfetch=mysqli_fetch_assoc($status);
	    									$output .='<tr>
										    <td>'.$cat['category'].'</td>
										    <td>'.$catfetch['cpu_id'].'</td>
										    <td>'.$desc.'</td>
										    <td>'.$statusfetch['status'].'</td>
										  </tr>';
	    								}
	    							}
	    						}
	    						else
	    						{
	    							$category_code=$cat['category_code'];
	    							$catfetchsql=mysqli_query($conn,"SELECT * FROM components WHERE componentid LIKE '$category_code%' AND location={$location['lab_id']}");
	    							if(mysqli_num_rows($catfetchsql)>0)
	    							{
	    								while($catfetch=mysqli_fetch_assoc($catfetchsql))
	    								{
	    									$desc=$catfetch['brand'].",".$catfetch['type'].",".$catfetch['description'].".";
	    									$count=$count+1;
	    									$status=mysqli_query($conn,"SELECT * FROM status WHERE status_id={$catfetch['status']}");
	    									$statusfetch=mysqli_fetch_assoc($status);
	    									$output .='<tr>
										    <td>'.$cat['category'].'</td>
										    <td>'.$catfetch['componentid'].'</td>
										    <td>'.$desc.'</td>
										    <td>'.$statusfetch['status'].'</td>
										  </tr>';
	    								}
	    							}
	    						}
	    					}
	    					$output .='</table></div>';
				        echo $output;
	    				}
	    				else
	    				{
	    					echo '<div class="alert alert-info">
				 	 	<strong>Here</strong> 
						</div>';
	    				}
	    				// echo $output;
	    			}
				}
				else
				{
					echo '<div class="alert alert-info">
			 	 	<strong>No systems available in this location</strong> 
					</div>';
				}
			}
			else
			{
				echo '<div class="alert alert-info">
	 	 	<strong>Labsys count sql failure</strong> 
			</div>';
			}
		}
		else{
			echo '<div class="alert alert-info">
	 	 	<strong>Location sql failure</strong> 
			</div>';
		}
	}
	else{
		echo '<div class="alert alert-info">
 	 	<strong>All input fields required</strong> 
		</div>';
	}
?>