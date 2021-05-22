<?php
	include_once("config.php");
	session_start();
	
	$id = mysqli_real_escape_string($conn,$_POST['searchname']);
    $output="";
    $output.='  <div class="row">
    <div class="col-sm-offset-2 col-md-9 text-center">
    <br><br><br>';
    $id =strtolower($id);
    $ids = substr($id, 0,3);

    if(!empty($id)){
        $checksql=mysqli_query($conn,"SELECT * FROM category where category_code like '$ids'");
        if(mysqli_num_rows($checksql)>0){
            
            if($ids != "mac" and $ids != "cpu" and  $ids != "lap" and $ids != "ser"){
                $output.='
                    <table class="table table-hover">
                    <caption><center><h4 class="text-center"><b>Search Results...</b></h4></center></caption>
                    <tr>
                    <th>Component ID</th>
                    <th>Invoice ID</th>
                    <th>Purchase Date</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Loaction</th>
                    </tr>';

                $sql = mysqli_query($conn,"SELECT * FROM components where componentid = '{$id}'");
                $row = mysqli_fetch_assoc($sql);
                
                $sql1 = mysqli_query($conn,"SELECT * FROM purchase where purchaseid = '{$row['purchaseid']}' ");
                $row1 = mysqli_fetch_assoc($sql1);
                
                $sql2 = mysqli_query($conn,"SELECT * FROM location where lab_id = {$row['location']}");
                $row2 = mysqli_fetch_assoc($sql2);
                
                $sql3 = mysqli_query($conn,"SELECT * FROM status where status_id = {$row['status']}");
                $row3 = mysqli_fetch_assoc($sql3);
                
                $output .='<tr>
                            <td>'.$row['componentid'].'</td>
                            <td>'.$row1['invoice_id'].'</td>
                            <td>'.$row1['purchase_date'].'</td>
                            <td>'.$row['brand'].'</td>
                            <td>'.$row['type'].'</td>
                            <td>'.$row['description'].'</td>
                            <td>'.$row3['status'].'</td>
                            <td>'.$row2['lab_name'].'</td>
                        </tr>';
                $output .='</table> <br><br><br>';

            }
            else{
                $output.='
                    <table class="table table-hover">
                    <caption><center><h4 class="text-center"><b>Search Results...</b></h4></center></caption>
                    <tr>
                    <th>Component ID</th>
                    <th>Invoice ID</th>
                    <th>Purchase Date</th>
                    <th>RAM</th>
                    <th>Process Series</th>
                    <th>Storage</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Loaction</th>
                    </tr>';

                $sql = mysqli_query($conn,"SELECT * FROM cpu where cpu_id = '{$id}'");
                $row = mysqli_fetch_assoc($sql);
                
                $sql1 = mysqli_query($conn,"SELECT * FROM purchase where purchaseid = '{$row['purchaseid']}' ");
                $row1 = mysqli_fetch_assoc($sql1);
                
                $sql2 = mysqli_query($conn,"SELECT * FROM location where lab_id = {$row['location']}");
                $row2 = mysqli_fetch_assoc($sql2);
                
                $sql3 = mysqli_query($conn,"SELECT * FROM status where status_id = {$row['status']}");
                $row3 = mysqli_fetch_assoc($sql3);
                
                $output .='<tr>
                            <td>'.$row['cpu_id'].'</td>
                            <td>'.$row1['invoice_id'].'</td>
                            <td>'.$row1['purchase_date'].'</td>
                            <td>'.$row['RAM'].'</td>
                            <td>'.$row['processor_series'].'</td>
                            <td>'.$row['storage'].'</td>
                            <td>'.$row['description'].'</td>
                            <td>'.$row3['status'].'</td>
                            <td>'.$row2['lab_name'].'</td>
                        </tr>';
                $output .='</table> <br><br><br>';
            }
        }else{
            echo '<br>There is no such component with the component ID exits!!';
        }

    }else
	{
		echo "<br>Input Field required!!";
	}











    // if($locationsql){
       
        
        
    //     // while($row = mysqli_fetch_array($locationsql)) 
    //     // {
    //     //     if($row['category_code']!= "mac" and $row['category_code']!= "cpu" and $row['category_code']!= "lap" and $row['category_code']!= "ser"){
    //     //         $code = $row['category_code'];
    //     //         $sql = mysqli_query($conn,"SELECT * FROM components where componentid like '$code%' and status = 1");
    //     //         $idsql = mysqli_query($conn,"SELECT count(*) as count FROM components where componentid like '$code%' and status = 1");
    //     //         $lab = mysqli_fetch_assoc($idsql);
    //     //         if(mysqli_num_rows($sql)>0)
    //     //         {
    //     //             $output.='
    //     //                     <table class="table table-hover">
    //     //                     <caption><center><h4 class="text-center"><b>'.$row['category'].' working count : '.$lab['count'].' </b></h4></center></caption>
    //     //                         <tr>
    //     //                         <th>Component ID</th>
    //     //                         <th>Description</th>
    //     //                         <th>Location</th>
    //     //                         </tr>';
    //     //             while($labsys = mysqli_fetch_assoc($sql))
    //     //             {
    //     //                 $c = $labsys['location'];
    //     //                 $loc = mysqli_query($conn,"SELECT * FROM location where lab_id = $c ");
    //     //                 $location = mysqli_fetch_assoc($loc);

    //     //                 $output .='<tr>
    //     //                     <td>'.$labsys['componentid'].'</td>
    //     //                     <td>'.$labsys['brand'].','.$labsys['type'].','.$labsys['description'].'</td>
    //     //                     <td>'.$location['lab_name'].'</td>
    //     //                     </tr>';
    //     //             }

    //     //             $output .='</table> <br><br><br>';
    //     //         }
    //     //         else{
    //     //             // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
    //     //             // <br><br><br>';
    //     //         }

    //     //     }else{
    //     //         $code = $row['category_code'];
                
    //     //         $sql=mysqli_query($conn,"SELECT * FROM cpu where cpu_id like '$code%' and status = 1");
    //     //         $idsql = mysqli_query($conn,"SELECT count(*) as count FROM cpu where cpu_id like '$code%' and status = 1");
    //     //         $lab = mysqli_fetch_assoc($idsql);

                
    //     //         if(mysqli_num_rows($sql)>0)
    //     //         {
                    
    //     //             $output.=' 
    //     //                     <table class="table table-hover">
    //     //                     <caption><center><h4 class="text-center"><b>'.$row['category'].' working count : '.$lab['count'].' </b></h4></center></caption>
    //     //                         <tr>
    //     //                         <th>Component ID</th>
    //     //                         <th>Description</th>
    //     //                         <th>Location</th>
    //     //                         </tr>';
    //     //             while($labsys=mysqli_fetch_assoc($sql))
    //     //             {
    //     //                 $c = $labsys['location'];
    //     //                 $loc = mysqli_query($conn,"SELECT * FROM location where lab_id = $c ");
    //     //                 $location = mysqli_fetch_assoc($loc);

    //     //                 $output .='<tr>
    //     //                     <td>'.$labsys['cpu_id'].'</td>
    //     //                     <td>'.$labsys['RAM'].','.$labsys['processor_series'].','.$labsys['storage'].','.$labsys['description'].'</td>
    //     //                     <td>'.$location['lab_name'].'</td>
    //     //                     </tr>';
    //     //             }	

    //     //             $output .='</table> <br><br><br>';

    //     //         }
    //     //         else{
    //     //             // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
    //     //             // <br><br><br>';
    //     //         }
               
    //     //     }

    //     // }
    // }
    // else{
    //     echo '<div class="alert alert-info">
    //     <strong>Category sql failure</strong> 
    //     </div>';
    // }
    $output .='</div>';
    echo $output;
	
?>