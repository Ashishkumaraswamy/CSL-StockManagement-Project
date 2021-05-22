<?php
	include_once("config.php");
	session_start();
	$invoicecheck=mysqli_real_escape_string($conn,$_POST['invoicecheck']);
	$invoiceid=($invoicecheck=="check")?(mysqli_real_escape_string($conn,$_POST['invoice'])):"none";
	$fromdate=($invoicecheck=="check")?"none":(mysqli_real_escape_string($conn,$_POST['from']));
	$todate=($invoicecheck=="check")?"none":(mysqli_real_escape_string($conn,$_POST['to']));
	if(!empty($invoicecheck) and ! empty($invoiceid) and !empty($fromdate) and !empty($todate))
	{
		if($invoicecheck=="check")
		{
			$invoicesql=mysqli_query($conn,"SELECT * FROM purchase WHERE invoice_id='{$invoiceid}'");
			if(mysqli_num_rows($invoicesql)>0)
			{
				$mousecountsql=mysqli_query($conn,"SELECT count(*) as mousecount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mou%'");
				$monitorcountsql=mysqli_query($conn,"SELECT count(*) as moncount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mon%'");
				$keyboardcountsql=mysqli_query($conn,"SELECT count(*) as keybcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'key%'");
				$cpucountsql=mysqli_query($conn,"SELECT count(*) as cpucount FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE 'cpu%'");
				if($mousecountsql and $monitorcountsql and $keyboardcountsql and $cpucountsql)
				{
					$mousecntfetch=mysqli_fetch_assoc($mousecountsql);
					$moncntfetch=mysqli_fetch_assoc($monitorcountsql);
					$keybcntfetch=mysqli_fetch_assoc($keyboardcountsql);
					$cpucntfetch=mysqli_fetch_assoc($cpucountsql);
					$mousesql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mou%' ORDER BY componentid LIMIT 1");
					$monitorsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mon%' ORDER BY componentid LIMIT 1");
					$keyboardsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'key%' ORDER BY componentid LIMIT 1");
					$cpusql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE 'cpu%' ORDER BY cpu_id LIMIT 1");
					if($mousesql and $monitorsql and $keyboardsql and $cpusql)
					{
						$mousefetch=mysqli_fetch_assoc($mousesql);
						$monitorfetch=mysqli_fetch_assoc($monitorsql);
						$keyboardfetch=mysqli_fetch_assoc($keyboardsql);
						$cpufetch=mysqli_fetch_assoc($cpusql);
						$mousdesc=$mousefetch['brand'].','.$mousefetch['type'].','.$mousefetch['description'];
						$mondesc=$monitorfetch['brand'].','.$monitorfetch['type'].','.$monitorfetch['description'];
						$keybdesc=$keyboardfetch['brand'].','.$keyboardfetch['type'].','.$keyboardfetch['description'];
						$cpudesc=$cpufetch['RAM'].' GB RAM,'.$cpufetch['processor_series'].','.$cpufetch['storage'].' GB Storage';
						$mouseworkcountsql=mysqli_query($conn,"SELECT count(*) as mouseworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mou%' and status=1");
						$keybworkcountsql=mysqli_query($conn,"SELECT count(*) as keybworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'key%' and status=1");
						$monworkcountsql=mysqli_query($conn,"SELECT count(*) as monworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mon%' and status=1");
						$cpuworkcountsql=mysqli_query($conn,"SELECT count(*) as cpuworkcount FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE 'cpu%' AND status=1");
						if($mouseworkcountsql and $monworkcountsql and $keybworkcountsql and $cpuworkcountsql)
						{
							$mouseworkcount=mysqli_fetch_assoc($mouseworkcountsql);
							$monworkcount=mysqli_fetch_assoc($monworkcountsql);
							$keybworkcount=mysqli_fetch_assoc($keybworkcountsql);
							$cpuworkcount=mysqli_fetch_assoc($cpuworkcountsql);
							$mousenotworkcountsql=mysqli_query($conn,"SELECT count(*) as mousenotworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mou%' and status=2");
							$keybnotworkcountsql=mysqli_query($conn,"SELECT count(*) as keybnotworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'key%' and status=2");
							$monnotworkcountsql=mysqli_query($conn,"SELECT count(*) as monnotworkcount FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE 'mon%' and status=2");
							$cpunotworkcountsql=mysqli_query($conn,"SELECT count(*) as cpunotworkcount FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE 'cpu%' AND status=2");
							$mo
						}
						else
						{
							echo '<div class="alert alert-info">
					 	 	<strong>Component workcount SQL error</strong> 
							</div>';
						}
						
					}
					else
					{
						echo '<div class="alert alert-info">
				 	 	<strong>Component SQL error</strong> 
						</div>';
					}
				}
				else{
					echo '<div class="alert alert-info">
			 	 	<strong>SQL error</strong> 
					</div>';
				}

			}
			else
			{
				echo '<div class="alert alert-info">
			 	 	<strong>Invoice ID does not exist</strong> 
					</div>';
			}
		}
		else
		{

		}
	}
	else
	{
		echo '<div class="alert alert-info">
			 	 	<strong>All input fields required</strong> 
					</div>';
	}
?>
