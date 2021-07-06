<?php
	include_once("config.php");
	session_start();
	$invoiceid=mysqli_real_escape_string($conn,$_POST['invoice']);
	$output="";
	if(!empty($invoiceid))
	{
		$invoicelistsql=mysqli_query($conn,"SELECT * FROM purchase WHERE invoice_id='{$invoiceid}'");
		if(mysqli_num_rows($invoicelistsql)>0)
		{
			$output .='
				<div class="row">
          		<div class="col-sm-offset-2 col-md-9 text-center">
    			<table class="table table-hover" border="1">
    			<tr>
    				<th>S.No</th>
				  	<th>Invoice ID</th>
				  	<th>Inovice Date</th>
				    <th>Category</th>
				    <th>Product Description</th>
				    <th>ID range</th>
					<th>Location</th>
				    <th>Working</th>
				    <th>Not Working</th>
				    <th>Disposed</th>
				    <th>Total Count</th>
				  </tr>';
				$invoicefetch=mysqli_fetch_assoc($invoicelistsql);
				$itemlistsql=mysqli_query($conn,"SELECT DISTINCT(category) FROM purchase WHERE invoice_id='{$invoicefetch['invoice_id']}'");
				$span=mysqli_num_rows($itemlistsql);
				if($itemlistsql)
				{
					$output.='
							  <tr>
							  <th rowspan="'.($span+1).'">1</th>
							  <th rowspan="'.($span+1).'">'.$invoicefetch['invoice_id'].'</th> 
							  <th rowspan="'.($span+1).'">'.$invoicefetch['purchase_date'].'</th>
							  ';
					while($category=mysqli_fetch_assoc($itemlistsql))
					{
						$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category['category']}'");
						$categoryfetch=mysqli_fetch_assoc($categorysql);
						$category_code=$categoryfetch['category_code'];
						if($category_code=="cpu" or $category_code=="ser" or $category_code=="mac" or $category_code=="lap")
						{
							$category_count_sql=mysqli_query($conn,"SELECT count(*) as categorycnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%'");
							$category_working_sql=mysqli_query($conn,"SELECT count(*) as categoryworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' AND status=1");
							$category_not_working_sql=mysqli_query($conn,"SELECT count(*) as categorynotworkcnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' AND status=2");
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' ORDER BY id LIMIT 1");
							$locationsql=mysqli_query($conn,"SELECT c.location,count(cpu_id) as cnt FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' group by(c.location)");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql and $locationsql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								$locationratio="";
								while($locationfetch=mysqli_fetch_assoc($locationsql))
								{
									$locationidsql=mysqli_query($conn,"SELECT * FROM location where lab_id={$locationfetch['location']}");
									$locationid=mysqli_fetch_assoc($locationidsql);
									$locationratio.=$locationid['lab_name'].':'.$locationfetch['cnt'].'</br>';
								}
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$startcnt=(int)substr($categorydescfetch['cpu_id'],3);
									$endcnt=$startcnt+$categorycnt['categorycnt']-1;
									$endid=$category_code.(string)$endcnt;
									$categorylastsql=mysqli_query($conn,"SELECT * FROM cpu c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.cpu_id LIKE '$category_code%' ORDER BY id DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['RAM'].' GB,'.$categorydescfetch['processor_series'].','.$categorydescfetch['storage'].' GB storage.';
									$output .='
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['cpu_id'].'-'.$categorylast['cpu_id'].'</td>
											<td>'.$locationratio.'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>
										  <tr>';
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
							$categorydesc_sql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' ORDER BY id LIMIT 1");
							$locationsql=mysqli_query($conn,"SELECT c.location,count(componentid) as cnt FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' group by(c.location)");
							if($category_count_sql and $category_working_sql and $category_not_working_sql and $categorydesc_sql and $locationsql)
							{
								$categorycnt=mysqli_fetch_assoc($category_count_sql);
								$category_working=mysqli_fetch_assoc($category_working_sql);
								$category_not_working=mysqli_fetch_assoc($category_not_working_sql);
								$locationratio="";
								while($locationfetch=mysqli_fetch_assoc($locationsql))
								{
									$locationidsql=mysqli_query($conn,"SELECT * FROM location where lab_id={$locationfetch['location']}");
									$locationid=mysqli_fetch_assoc($locationidsql);
									$locationratio.=$locationid['lab_name'].':'.$locationfetch['cnt'].'</br>';
								}
								if(mysqli_num_rows($categorydesc_sql)>0)
								{
									$categorydescfetch=mysqli_fetch_assoc($categorydesc_sql);
									$categorylastsql=mysqli_query($conn,"SELECT * FROM components c INNER JOIN purchase p ON p.purchaseid=c.purchaseid WHERE p.invoice_id='{$invoicefetch['invoice_id']}' AND c.componentid LIKE '$category_code%' ORDER BY id DESC LIMIT 1");
									$categorylast=mysqli_fetch_assoc($categorylastsql);
									$categorydesc=$categorydescfetch['brand'].','.$categorydescfetch['type'].','.$categorydescfetch['description'].'.';
									$output .='
										    <td>'.$category['category'].'</td>
										    <td>'.$categorydesc.'</td>
										    <td>'.$categorydescfetch['componentid'].'-'.$categorylast['componentid'].'</td>
											<td>'.$locationratio.'</td>
										    <td>'.$category_working['categoryworkcnt'].'</td>
										    <td>'.$category_not_working['categorynotworkcnt'].'</td>
										    <td>'.($categorycnt['categorycnt']-$category_not_working['categorynotworkcnt']-$category_working['categoryworkcnt']).'</td>
										     <td>'.$categorycnt['categorycnt'].'</td>
										  </tr>
										  <tr>';
								}
							}
							else{
								echo '<div class="alert alert-info">
						 	 	<strong>CPU SQL Failure</strong> 
								</div>';
							}	
						}
					}
					$output .='</tr></div><br><br><br>';
				}
				else
				{
					echo '<div class="alert alert-info">
			 	 	<strong>Category SQL Failure</strong> 
					</div>';
				}
			
			$output.="</table></div></div></div>";
			echo $output;
		}
		else
		{
			echo "This Invoice ID does not exist.";
		}
	}
	else
	{
		echo "Invoice ID required";
	}
?>