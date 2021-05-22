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
			if($syslocationsql)
			{
				$syslocation=mysqli_fetch_assoc($syslocationsql);
				$labsyssql=mysqli_query($conn,"SELECT * FROM `system` WHERE location_id={$location['lab_id']}");
				if(mysqli_num_rows($labsyssql)>0)
				{
					 $output.='<div class="row">
			          		<div class="col-md-4">
			          		</div>
			          		<h4>Location:'.$location['lab_name'].'</h4>
			          	   </div>
			          	   <div class="row">
			          		<div class="col-md-4">
			          		</div>
			   				<h4>Number of Systems:'.$syslocation['labsyscount'].'</h4>
			          	   </div>
			          	   <br><br>
			    			<div class="col-sm-offset-2 col-md-9 text-center">
			    			<table class="table table-hover">
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
					$output .='</table>
    				</div>';
    				echo $output;

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