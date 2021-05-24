<?php
	include_once('config.php');
	session_start();

	$sql = mysqli_query($conn,"select * from log");
    $output="";
    $output.='  <div class="row">
                        <div class="col-sm-offset-1 col-md-10 text-center">';
	if(mysqli_num_rows($sql) > 0){  


        $output.=' 
                <table class="table table-hover">
                <caption><center><h4 class="text-center"><b>LOG ENTRIES</b></h4></center></caption>
                <tr>
                <th>LOG ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Component ID</th>
                <th>Description</th>
                <th>Purpose</th>
                <th>Time</th>
                </tr>';

                while($row=mysqli_fetch_assoc($sql))
                {
                    $sql1 = mysqli_query($conn,"SELECT * FROM users where user_id = {$row['user_id']}");
                    $row1 = mysqli_fetch_assoc($sql1);

                    $output .='<tr>
                        <td>'.$row['log_id'].'</td>
                        <td>'.$row['user_id'].'</td>
                        <td>'.$row1['user_name'].'</td>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['description'].'</td>
                        <td>'.$row['purpose'].'</td>
                        <td>'.$row['time'].'</td>
                        </tr>';
                }	

                $output .='</table> <br>';


	}else{

		$output .="<br<br><center><h3>Log empty!!</h3></center>";
	}
    $output .='</div></div>';
    echo $output;
?>