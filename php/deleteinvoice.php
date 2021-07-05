<?php
	include_once('config.php');
	session_start();
    $invoice_id=mysqli_real_escape_string($conn,$_POST['invoicenumber']);
    $invoicesql=mysqli_query($conn,"SELECT * FROM invoice WHERE invoice_id='{$invoice_id}'");
    if(mysqli_num_rows($invoicesql))
    {
        $compdelete=mysqli_query($conn,"SELECT *
        FROM `purchase` AS pur 
        INNER JOIN `components` AS comp 
        ON pur.purchaseid = comp.purchaseid
        WHERE pur.invoice_id ='{$invoice_id}'
        ");
        while($compfetch=mysqli_fetch_assoc($compdelete))
        {
            $deleterow=mysqli_query($conn,"DELETE FROM components where componentid='{$compfetch['componentid']}'");
        }
        $compdelete=mysqli_query($conn,"SELECT *
        FROM `purchase` AS pur 
        INNER JOIN `cpu` AS cpu 
        ON pur.purchaseid = cpu.purchaseid
        WHERE pur.invoice_id ='{$invoice_id}'
        ");
        while($compfetch=mysqli_fetch_assoc($compdelete))
        {
            $deleterow=mysqli_query($conn,"DELETE FROM cpu where cpu_id='{$compfetch['cpu_id']}'");
        }
        $deletepuchase=mysqli_query($conn,"DELETE FROM purchase WHERE invoice_id='{$invoice_id}'");
        $purchase=mysqli_query($conn,"SELECT * from purchase");
        $numbersql=mysqli_query($conn,"SELECT max(`system_id`) as len from `system`");
        $number=mysqli_fetch_assoc($numbersql);
        $numberlen=$number['len']?$number['len']:0;
        $alter=mysqli_query($conn,"ALTER TABLE `system` AUTO_INCREMENT ={$numberlen}");
        $numbersql=mysqli_query($conn,"SELECT max(`purchaseid`) as len from `purchase`");
        $number=mysqli_fetch_assoc($numbersql);
        $numberlen=$number['len']?$number['len']:0;
        $alter=mysqli_query($conn,"ALTER TABLE `purchase` AUTO_INCREMENT ={$numberlen}");
        $deleteinvoice=mysqli_query($conn,"DELETE FROM invoice WHERE invoice_id='{$invoice_id}'");
        $numbersql=mysqli_query($conn,"SELECT max(`invoice_id`) as len from `invoice`");
        $number=mysqli_fetch_assoc($numbersql);
        $numberlen=$number['len']?$number['len']:0;
        $alter=mysqli_query($conn,"ALTER TABLE `invoice` AUTO_INCREMENT ={$numberlen}");
        echo "Invoice {$invoice_id} deleted successfully";
    }
    else
    {
        echo "No such invoice id exist";
    }
?>