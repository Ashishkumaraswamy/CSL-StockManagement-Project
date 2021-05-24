<?php
	include_once("config.php");
	session_start();
	$invoice_id=mysqli_real_escape_string($conn,$_POST['invoice_id']);
	$invoice_insert=mysqli_query($conn,"INSERT INTO invoice(invoice_id) VALUES($invoice_id)");
	if($invoice_insert)
	{
		echo "success";
	}
	else
	{
		echo "failure";
	}
?>