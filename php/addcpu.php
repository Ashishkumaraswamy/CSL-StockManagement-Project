<?php
	include_once('config.php');
	session_start();
	$invoice_id=mysqli_real_escape_string($conn,$_POST['invoice']);
	$cat=mysqli_real_escape_string($conn,$_POST['cpucat']);
	$cpucat=strtolower($cat);
	$cpucat= substr($cpucat, 0,3);
	$date=mysqli_real_escape_string($conn,$_POST['date']);
	$ram=mysqli_real_escape_string($conn,$_POST['ram']);
	$procseries=mysqli_real_escape_string($conn,$_POST['procseries']);
	$storage=mysqli_real_escape_string($conn,$_POST['storage']);
	$desc=mysqli_real_escape_string($conn,$_POST['cpudesc']);
	$cpuquant=mysqli_real_escape_string($conn,$_POST['cpuquant']);
	if(!empty($cpucat) and !empty($ram) and !empty($procseries) and !empty($storage) and !empty($desc) and !empty($cpuquant) and !empty($invoice_id) and !empty($date))
	{
		if(is_numeric($storage))
		{
			$invoiceval=mysqli_query($conn,"SELECT * FROM invoice WHERE invoice_id='{$invoice_id}'");
			if(mysqli_num_rows($invoiceval)==0)
			{	
				$purchaseinsert=mysqli_query($conn,"INSERT INTO purchase(invoice_id,purchase_date,category) VALUES('{$invoice_id}','{$date}','{$cat}')");
				if($purchaseinsert)
				{
					$purchaseidsql=mysqli_query($conn,"SELECT * FROM purchase ORDER BY purchaseid DESC LIMIT 1");
					$purchaseid=mysqli_fetch_assoc($purchaseidsql);
					$idsql=mysqli_query($conn,"SELECT count(*) as count FROM cpu WHERE cpu_id LIKE '$cpucat%'");
					$id=mysqli_fetch_assoc($idsql);
					$count=(string)($id['count']);
					$i=1;
					while($i<=$cpuquant)
					{
						$cpuid=$cpucat.(string)($count+$i);
						$id=($count+$i);
						$insertcomp=mysqli_query($conn,"INSERT INTO cpu VALUES('{$cpuid}',{$id},{$purchaseid['purchaseid']},'{$ram}','{$procseries}',{$storage},1,1,'{$desc}','NA')");
						//$sql7 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$cpuid}','Invoice ID - {$invoice_id} ,Purchase ID -{$purchaseid['purchaseid']} and Purchase date - {$date}.','New Components Added.')");
						$i=$i+1;
					}
					echo $cat." added to store. ID of the new items are from ".($count+1)." to ".($count+$i-1);
				}
				else
				{
					echo "Failure";
				}
				
			}
			else
			{
				echo "Invoice Already Exists. Please check your Invoice ID";
			}
		}
		else
		{
			echo "Enter the ram as a number in terms of GB.";
		}
	}
	else
	{
		echo "All Input Fields required";
	}
	
?>