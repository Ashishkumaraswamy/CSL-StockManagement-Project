<?php
	include_once('config.php');
	session_start();
	$invoice_id=mysqli_real_escape_string($conn,$_POST['invoice']);
	$compcat=mysqli_real_escape_string($conn,$_POST['compcat']);
	$compcat=strtolower($compcat);
	$compcat= substr($compcat, 0,3);
	$brand=mysqli_real_escape_string($conn,$_POST['brand']);
	$type=mysqli_real_escape_string($conn,$_POST['type']);
	$desc=mysqli_real_escape_string($conn,$_POST['compdesc']);
	$compquant=mysqli_real_escape_string($conn,$_POST['compquant']);
	$purchaseinsert=mysqli_query($conn,"INSERT INTO purchase(invoice_id) VALUES($invoice_id)");
	$purchaseidsql=mysqli_query($conn,"SELECT * FROM purchase ORDER BY purchase_date DESC LIMIT 1");
	$purchaseid=mysqli_fetch_assoc($purchaseidsql);
	$idsql=mysqli_query($conn,"SELECT count(*) as count FROM components WHERE componentid LIKE 'mou%'");
	$id=mysqli_fetch_assoc($idsql);
	$count=(string)($id['count']+1);
	$purchaseid=mysqli_fetch_assoc($purchaseidsql);
	$i=1;
	while($i<=$compquant)
	{
		$compid=$compcat.(string)($count+$i);
		$insertcomp=mysqli_query($conn,"INSERT INTO components VALUES('{$compid}',{$purchaseid['purchaseid']},'{$brand}','{$type}',0,'{$desc}')");
		$i=$i+1;
	}
	echo "Success";
?>