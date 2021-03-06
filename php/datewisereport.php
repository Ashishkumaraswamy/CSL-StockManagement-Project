<?php
	include_once("config.php");
	session_start();
	$fromdate=mysqli_real_escape_string($conn,$_POST['from']);
	$todate=mysqli_real_escape_string($conn,$_POST['to']);
	$output='<div class="row">
             <div class="col-sm-offset-2 col-md-9 text-center">';
    if(!empty($fromdate) and !empty($todate))
    {
    	$output="";
	$invoicelistsql=mysqli_query($conn,"SELECT DISTINCT(invoice_id),purchase_date FROM purchase WHERE purchase_date BETWEEN '{$fromdate}' AND '{$todate}'");
			if(mysqli_num_rows($invoicelistsql)>0)
			{	
				$output .='<div class="row" style="position:relative;width:90%;>
			          		<div class="col-sm-offset-2 col-md-9 text-center">
			    			<table class="table table-condensed" border="1">
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
				$count=0;
				while($invoicefetch=mysqli_fetch_assoc($invoicelistsql))
				{
				$count=$count+1;
				$itemlistsql=mysqli_query($conn,"SELECT DISTINCT(category) FROM purchase WHERE invoice_id='{$invoicefetch['invoice_id']}'");
				$span=mysqli_num_rows($itemlistsql);
				if($itemlistsql)
				{
					$invoiceDate = $invoicefetch['purchase_date'];
					$invoiceDate = date("d-m-Y", strtotime($invoiceDate));
					$output.='
							  <th rowspan="'.($span+1).'">'.$count.'</th>
							  <th rowspan="'.($span+1).'">'.$invoicefetch['invoice_id'].'</th> 
							  <th rowspan="'.($span+1).'">'.$invoiceDate.'</th>
							  ';
					while($category=mysqli_fetch_assoc($itemlistsql))
					{
						$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category='{$category['category']}'");
						$categoryfetch=mysqli_fetch_assoc($categorysql);
						$category_code=$categoryfetch['category_code'];
						if($category_code=="CPU" or $category_code=="SRV" or $category_code=="MAC" or $category_code=="LAP")
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
					$output .='</tr>';
				}
				else
				{
					echo '<div class="alert alert-info">
			 	 	<strong>Category SQL Failure</strong> 
					</div>';
				}
				}
				$output.="</table></div></div></div><br><br>";
				echo $output;
		}
    }
    else
    {
    	echo "All input fields required";
    }
?>