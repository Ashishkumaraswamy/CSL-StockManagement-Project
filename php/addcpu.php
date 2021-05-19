<?php
	include_once('config.php');
	session_start();
	$invoice_id=mysqli_real_escape_string($conn,$_POST['invoice']);
	echo $invoice_id;
	$cpucat=mysqli_real_escape_string($conn,$_POST['cpucat']);
	$cpucat=strtolower($cpucat);
	$cpucat= substr($cpucat, 0,3);
	$ram=mysqli_real_escape_string($conn,$_POST['ram']);
	$procseries=mysqli_real_escape_string($conn,$_POST['procseries']);
	$storage=mysqli_real_escape_string($conn,$_POST['storage']);
	$desc=mysqli_real_escape_string($conn,$_POST['cpudesc']);
	$cpuquant=mysqli_real_escape_string($conn,$_POST['cpuquant']);
	$purchaseinsert=mysqli_query($conn,"INSERT INTO purchase(invoice_id) VALUES('{$invoice_id}')");
	if($purchaseinsert)
	{
		echo "Insertion Success";
	}
	else
	{
		echo "Failure";
	}
	$purchaseidsql=mysqli_query($conn,"SELECT * FROM purchase ORDER BY purchase_date DESC LIMIT 1");
	$purchaseid=mysqli_fetch_assoc($purchaseidsql);
	$idsql=mysqli_query($conn,"SELECT count(*) as count FROM cpu WHERE cpu_id LIKE '$cpucat%'");
	$id=mysqli_fetch_assoc($idsql);
	$count=(string)($id['count']);
	if($purchaseid)
	{
		echo "Fine";
	}
	$i=1;
	while($i<=$cpuquant)
	{
		$cpuid=$cpucat.(string)($count+$i);
		$insertcomp=mysqli_query($conn,"INSERT INTO cpu VALUES('{$cpuid}',{$purchaseid['purchaseid']},'{$ram}','{$procseries}',{$storage},0,'{$desc}')");
		$i=$i+1;
	}
	echo "Success";
?>