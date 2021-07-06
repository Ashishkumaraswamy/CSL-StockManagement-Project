<?php
	include_once("config.php");
	session_start();
	
	$id = mysqli_real_escape_string($conn,$_POST['searchname']);
    $output="";
    $output.='  <div class="row">
    <div class="col-sm-offset-2 col-md-9 text-center">
    <br><br><br>';
    $id = strtoupper($id);
    $ids = substr($id, 0,3);

    if(!empty($id)){
        $checksql=mysqli_query($conn,"SELECT * FROM category where category_code like '$ids'");
        if(mysqli_num_rows($checksql)>0){
            
            if($ids != "MAC" and $ids != "CPU" and  $ids != "LAP" and $ids != "SRV"){
                
                $sql = mysqli_query($conn,"SELECT * FROM components where componentid = '{$id}'");
                

                if(mysqli_num_rows($sql)>0)
                {
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
                    <th>System-ID</th>
                    <th>Loaction</th>
                    </tr>';

                    $row = mysqli_fetch_assoc($sql);
                    $sql1 = mysqli_query($conn,"SELECT * FROM purchase where purchaseid = '{$row['purchaseid']}' ");
                    $row1 = mysqli_fetch_assoc($sql1);
                    
                    $sql2 = mysqli_query($conn,"SELECT * FROM location where lab_id = {$row['location']}");
                    $row2 = mysqli_fetch_assoc($sql2);
                    
                    $sql3 = mysqli_query($conn,"SELECT * FROM status where status_id = {$row['status']}");
                    $row3 = mysqli_fetch_assoc($sql3);

                    $sql4 = mysqli_query($conn,"SELECT * FROM `system` where mouse_id = '{$id}' or keyboard_id = '{$id}' or monitor_id = '{$id}'");
                    if(mysqli_num_rows($sql4)>0)
                    {
                        $row4 = mysqli_fetch_assoc($sql4);
                    }
                    else{

                        $row4['system_id']='NA';

                    }
                    
                    $output .='<tr>
                                <td>'.$row['componentid'].'</td>
                                <td>'.$row1['invoice_id'].'</td>
                                <td>'.$row1['purchase_date'].'</td>
                                <td>'.$row['brand'].'</td>
                                <td>'.$row['type'].'</td>
                                <td>'.$row['description'].'</td>
                                <td>'.$row3['status'].'</td>
                                <td>'.$row4['system_id'].'</td>
                                <td>'.$row2['lab_name'].'</td>
                            </tr>';
                    $output .='</table> <br><br><br>';

                    //$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$row['componentid']}','Loaction of the Component - {$row2['lab_name']}.','Searched a Component with ComponentID.')");


                }
                else{

                    echo '<br><br>There is no such component with the component ID exits!!';

                }


                
                
            }
            else{
               
                $sql = mysqli_query($conn,"SELECT * FROM cpu where cpu_id = '{$id}'");
                

                if(mysqli_num_rows($sql)>0)
                {
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
                    <th>System-ID</th>
                    <th>Loaction</th>
                    </tr>';
                    $row = mysqli_fetch_assoc($sql);
                    $sql1 = mysqli_query($conn,"SELECT * FROM purchase where purchaseid = '{$row['purchaseid']}' ");
                    $row1 = mysqli_fetch_assoc($sql1);
                    
                    $sql2 = mysqli_query($conn,"SELECT * FROM location where lab_id = {$row['location']}");
                    $row2 = mysqli_fetch_assoc($sql2);
                    
                    $sql3 = mysqli_query($conn,"SELECT * FROM status where status_id = {$row['status']}");
                    $row3 = mysqli_fetch_assoc($sql3);

                    $sql4 = mysqli_query($conn,"SELECT * FROM `system` where cpu_id = '{$id}'");
                    if(mysqli_num_rows($sql4)>0)
                    {
                        $row4 = mysqli_fetch_assoc($sql4);
                    }
                    else{

                        $row4['system_id']='NA';

                    }
                    
                    $output .='<tr>
                                <td>'.$row['cpu_id'].'</td>
                                <td>'.$row1['invoice_id'].'</td>
                                <td>'.$row1['purchase_date'].'</td>
                                <td>'.$row['RAM'].'</td>
                                <td>'.$row['processor_series'].'</td>
                                <td>'.$row['storage'].'</td>
                                <td>'.$row['description'].'</td>
                                <td>'.$row3['status'].'</td>
                                <td>'.$row4['system_id'].'</td>
                                <td>'.$row2['lab_name'].'</td>
                            </tr>';
                    $output .='</table> <br><br><br>';

                    //$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'{$row['cpu_id']}','Loaction of the system - {$row2['lab_name']}.','Searched a System with SystemID.')");

                }
                else{

                    echo '<br><br>There is no such component with the component ID exits!!';

                }


            }
            

        }else{
            echo '<br>There is no such component with the component ID exits!!';
        }

    }else
	{
		echo "<br>Input Field required!!";
	}

    $output .='</div>';
    echo $output;
	
?>