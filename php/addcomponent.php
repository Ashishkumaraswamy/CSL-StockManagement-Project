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
		$invoiceval=mysqli_query($conn,"SELECT * FROM invoice WHERE invoice_id='{$invoice_id}'");
		if(mysqli_num_rows($invoiceval)==0)
		{
			$purchaseinsert=mysqli_query($conn,"INSERT INTO purchase(invoice_id,purchase_date,category) VALUES('{$invoice_id}','{$date}','{$cat}')");
			if($purchaseinsert)
			{	
				$catsql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$cat}'");
				$catfetch=mysqli_fetch_assoc($catsql);
				$purchaseidsql=mysqli_query($conn,"SELECT * FROM purchase ORDER BY purchaseid DESC LIMIT 1");
				$catcode=$catfetch['category_code'];
				$purchaseid=mysqli_fetch_assoc($purchaseidsql);
				$idsql=mysqli_query($conn,"SELECT count(*) as count FROM components WHERE componentid LIKE '$catcode%'");
				$id=mysqli_fetch_assoc($idsql);
				$count=(string)($id['count']);
				if($purchaseid)
				{
					$i=1;
					while($i<=$compquant)
					{
						$compid=$catfetch['category_code'].(string)($count+$i);
						$id=($count+$i);
						$insertcomp=mysqli_query($conn,"INSERT INTO components VALUES('{$compid}',{$id},{$purchaseid['purchaseid']},'{$brand}','{$type}',1,1,'{$desc}','NA')");
						$sql1 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$compid}','Invoice ID - {$invoice_id} ,Purchase ID -{$purchaseid['purchaseid']} and Purchase date - {$date}.','New Components Added.')");
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
		else
		{
			echo "Invoice Already Exists. Please check your Invoice ID";
		}
	}
	else
	{
		echo "All Input Fields required";
	}
?>