<?php
	include_once('config.php');
	session_start();
	$invoice_id=mysqli_real_escape_string($conn,$_POST['invoice']);
	$cat=mysqli_real_escape_string($conn,$_POST['compcat']);
	$date=mysqli_real_escape_string($conn,$_POST['date']);
	$compcat=strtolower($cat);
	$compcat= substr($compcat, 0,3);
	$brand=mysqli_real_escape_string($conn,$_POST['brand']);
	$type=mysqli_real_escape_string($conn,$_POST['type']);
	$desc=mysqli_real_escape_string($conn,$_POST['compdesc']);
	$compquant=mysqli_real_escape_string($conn,$_POST['compquant']);
	if(!empty($compcat) and !empty($brand) and !empty($type) and !empty($desc) and !empty($compquant) and !empty($invoice_id) and !empty($date))
	{
		$invoice_sql=mysqli_query($conn,"SELECT * FROM purchase WHERE invoice_id='{$invoice_id}'");
		if(mysqli_num_rows($invoice_sql)>=0)
		{
			$purchaseinsert=mysqli_query($conn,"INSERT INTO purchase(invoice_id,purchase_date) VALUES('{$invoice_id}','{$date}')");
			if($purchaseinsert)
			{	
				$purchaseidsql=mysqli_query($conn,"SELECT * FROM purchase ORDER BY purchaseid DESC LIMIT 1");
				$purchaseid=mysqli_fetch_assoc($purchaseidsql);
				$idsql=mysqli_query($conn,"SELECT count(*) as count FROM components WHERE componentid LIKE '$compcat%'");
				$id=mysqli_fetch_assoc($idsql);
				$count=(string)($id['count']);
				if($purchaseid)
				{
					$i=1;
					while($i<=$compquant)
					{
						$compid=$compcat.(string)($count+$i);
						$insertcomp=mysqli_query($conn,"INSERT INTO components VALUES('{$compid}',{$purchaseid['purchaseid']},'{$brand}','{$type}',1,1,'{$desc}')");
						$i=$i+1;
					}
					echo $cat." added to store. ID of the new items are from ".($count+1)." to ".($count+$i-1);
				}
				else {
					echo "Failure";
				}
			}
			else
			{
				echo "Failure";
			}
		}
		else{
			echo "Invoice ID already exists.Check your Invoice ID.";
		}
	}
	else
	{
		echo "All Input Fields required";
	}
?>