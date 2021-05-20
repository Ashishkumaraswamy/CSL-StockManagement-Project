<?php
    include_once("config.php");
    session_start();
    $invoice_id=mysqli_real_escape_string($conn,$_POST['invoice_id']);
    $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
    $mousefetchsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoice_id}' AND c.componentid LIKE 'mou%'");
    $keyboardfetchsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoice_id}' AND c.componentid LIKE 'key%'");
    $monitorfetchsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoice_id}' AND c.componentid LIKE 'mon%'");
    $cpufetchsql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoice_id}' AND c.cpu_id LIKE 'cpu%'");
    if($mousefetchsql and $monitorfetchsql and $keyboardfetchsql and $cpufetchsql)
    {
    	$i=0;
    	$output='<br><br>
    			<div class="col-sm-offset-2 col-md-9 text-center">
    			<table class="table table-hover">
				  <tr>
				    <th>System_ID</th>
				    <th>Mouse_ID</th>
				    <th>Monitor_ID</th>
				    <th>Keyboard_ID</th>
				    <th>CPU_ID</th>
				  </tr>';
    	while($i<$quantity)
    	{
    		$mousefetch=mysqli_fetch_assoc($mousefetchsql);
    		$monitorfetch=mysqli_fetch_assoc($monitorfetchsql);
    		$keyboardfetch=mysqli_fetch_assoc($keyboardfetchsql);
    		$cpufetch=mysqli_fetch_assoc($cpufetchsql);
    		$systeminsert=mysqli_query($conn,"INSERT INTO `system`(`mouse_id`, `keyboard_id`, `monitor_id`, `cpu_id`, `location_id`, `status`, `description`) VALUES ('{$mousefetch['componentid']}','{$keyboardfetch['componentid']}','{$monitorfetch['componentid']}','{$cpufetch['cpu_id']}',0,0,'NA')");
    		if($systeminsert)
    		{
    			$systemidsql=mysqli_query($conn,"SELECT * FROM `system` ORDER BY system_id DESC LIMIT 1");
    			$systemid=mysqli_fetch_assoc($systemidsql);
    			$output .='<tr>
						    <td>'.$systemid['system_id'].'</td>
						    <td>'.$mousefetch['componentid'].'</td>
						    <td>'.$monitorfetch['componentid'].'</td>
						    <td>'.$keyboardfetch['componentid'].'</td>
						    <td>'.$cpufetch['cpu_id'].'</td>
						  </tr>';
    		}
    		else{
    			echo "failure";
    		}
    		$i=$i+1;
    	}
    	$output .='</table>
    				</div>';
    	echo $output;
    }
    else{
    	echo "SQL Failure";
    }
?>