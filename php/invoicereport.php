<?php
	include_once("config.php");
	session_start();
	$invoicecheck=mysqli_real_escape_string($conn,$_POST['invoicecheck']);
	$invoiceid=($invoicecheck=="check")?(mysqli_real_escape_string($conn,$_POST['invoice'])):"none";
	$fromdate=($invoicecheck=="check")?"none":(mysqli_real_escape_string($conn,$_POST['from']));
	$todate=($invoicecheck=="check")?"none":(mysqli_real_escape_string($conn,$_POST['to']));
	$output='<div class="row">
                        <div class="col-sm-offset-2 col-md-9 text-center">';
	if(!empty($invoicecheck) and ! empty($invoiceid) and !empty($fromdate) and !empty($todate))
	{
		if($invoicecheck=="check")
		{
			$invoicesql=mysqli_query($conn,"SELECT * FROM purchase WHERE invoice_id='{$invoiceid}'");
			if(mysqli_num_rows($invoicesql)>0)
			{
				$invoicefetch=mysqli_fetch_assoc($invoicesql);
				$categorysql=mysqli_query($conn,"SELECT * FROM category");
				if($categorysql)
				{
					$output.='
			    			<div class="col-sm-offset-2 col-md-9 text-center">
			    			<center><h4>Invoice ID:'.$invoicefetch['invoice_id'].'</h4></center><br>
			    			<center><h4>Number of Systems:'.$invoicefetch['purchase_date'].'</h4></center>
			    			<table class="table table-hover">
							  <tr>
							    <th>Category</th>
							    <th>Product Description</th>
							    <th>ID range</th>
							    <th>Working</th>
							    <th>Not Working</th>
							    <th>Disposed</th>
							    <th>Total Count</th>
							  </tr>';
					while($category=mysqli_fetch_assoc($categorysql))
					{
						$category_code=$category['category_code'];
						if($category['category_code']=="cpu" or $category['category_code']=="ser" or $category['category_code']=="mac" or $category['category_code']=="lap")
						{
							$category_count_sql=mysqli_query($conn,"SELECT count(*) as categorycnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE '$category_code%'");
							$category_working_sql=mysqli_query($conn,"SELECT count(*) as categoryworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE '$category_code%' AND status=1");
							$category_not_working_sql=mysqli_query($conn,"SELECT count(*) as categorynotworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE '$category_code%' AND status=2");
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE '$category_code%' ORDER BY cpu_id LIMIT 1");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$categorylastsql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.cpu_id LIKE '$category_code%' ORDER BY cpu_id DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['RAM'].' GB,'.$categorydescfetch['processor_series'].','.$categorydescfetch['storage'].' GB storage.';
									$output .='<tr>
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['cpu_id'].'-'.$categorylast['cpu_id'].'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>';
								}
							}
							else{
								echo '<div class="alert alert-info">
						 	 	<strong>CPU SQL Failure</strong> 
								</div>';
							}	
						}
						else
						{
							$category_count_sql=mysqli_query($conn,"SELECT count(*) as categorycnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE '$category_code%'");
							$category_working_sql=mysqli_query($conn,"SELECT count(*) as categoryworkcnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE '$category_code%' AND status=1");
							$category_not_working_sql=mysqli_query($conn,"SELECT count(*) as categorynotworkcnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE '$category_code%' AND status=2");
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE '$category_code%' ORDER BY componentid LIMIT 1");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$categorylastsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoiceid}' AND c.componentid LIKE '$category_code%' ORDER BY componentid DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['brand'].','.$categorydescfetch['type'].','.$categorydescfetch['description'].'.';
									$output .='<tr>
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['componentid'].'-'.$categorylast['componentid'].'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>';
								}
							}
							else{
								echo '<div class="alert alert-info">
						 	 	<strong>CPU SQL Failure</strong> 
								</div>';
							}	
						}
					}
					$output .='</table>
    				</div><br><br><br>';
    				echo $output;
				}
				else
				{
					echo '<div class="alert alert-info">
			 	 	<strong>Category SQL Failure</strong> 
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
			$invoicelistsql=mysqli_query($conn,"SELECT DISTINCT(invoice_id),purchase_date FROM purchase WHERE purchase_date BETWEEN '{$fromdate}' AND '{$todate}'");
			if(mysqli_num_rows($invoicelistsql)>0)
			{	
				while($invoicefetch=mysqli_fetch_assoc($invoicelistsql))
				{
				$categorysql=mysqli_query($conn,"SELECT * FROM category");
				if($categorysql)
				{
					$output.='
			          		<div class="col-sm-offset-2 col-md-9 text-center">
			    			<center><h4>Invoice ID:'.$invoicefetch['invoice_id'].'</h4></center><br>
			    			<center><h4>Number of Systems:'.$invoicefetch['purchase_date'].'</h4></center>
			    			<table class="table table-hover">
							  <tr>
							    <th>Category</th>
							    <th>Product Description</th>
							    <th>ID range</th>
							    <th>Working</th>
							    <th>Not Working</th>
							    <th>Disposed</th>
							    <th>Total Count</th>
							  </tr>';
					while($category=mysqli_fetch_assoc($categorysql))
					{
						$category_code=$category['category_code'];
						if($category['category_code']=="cpu" or $category['category_code']=="ser" or $category['category_code']=="mac" or $category['category_code']=="lap")
						{
							$category_count_sql=mysqli_query($conn,"SELECT count(*) as categorycnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%'");
							$category_working_sql=mysqli_query($conn,"SELECT count(*) as categoryworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' AND status=1");
							$category_not_working_sql=mysqli_query($conn,"SELECT count(*) as categorynotworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' AND status=2");
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' ORDER BY cpu_id LIMIT 1");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$categorylastsql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' ORDER BY cpu_id DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['RAM'].' GB,'.$categorydescfetch['processor_series'].','.$categorydescfetch['storage'].' GB storage.';
									$output .='<tr>
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['cpu_id'].'-'.$categorylast['cpu_id'].'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>';
								}
							}
							else{
								echo '<div class="alert alert-info">
						 	 	<strong>CPU SQL Failure</strong> 
								</div>';
							}	
						}
						else
						{
							$category_count_sql=mysqli_query($conn,"SELECT count(*) as categorycnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%'");
							$category_working_sql=mysqli_query($conn,"SELECT count(*) as categoryworkcnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' AND status=1");
							$category_not_working_sql=mysqli_query($conn,"SELECT count(*) as categorynotworkcnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' AND status=2");
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' ORDER BY componentid LIMIT 1");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$categorylastsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' ORDER BY componentid DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['brand'].','.$categorydescfetch['type'].','.$categorydescfetch['description'].'.';
									$output .='<tr>
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['componentid'].'-'.$categorylast['componentid'].'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>';
								}
							}
							else{
								echo '<div class="alert alert-info">
						 	 	<strong>CPU SQL Failure</strong> 
								</div>';
							}	
						}
					}
					$output .='</table></div><br><br><br>';
				}
				else
				{
					echo '<div class="alert alert-info">
			 	 	<strong>Category SQL Failure</strong> 
					</div>';
				}
				}
				$output.="</div></div>";
				echo $output;
			}

			else
			{
				echo '<div class="alert alert-info">
			 	 	<strong>No purchases within this period.</strong> 
					</div>';
			}
		}
	}
	else
	{
		echo '<div class="alert alert-info">
			 	 	<strong>All input fields required</strong> 
					</div>';
	}
?>
