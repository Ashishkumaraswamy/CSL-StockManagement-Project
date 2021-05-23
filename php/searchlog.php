<?php
	include_once('config.php');
	session_start();

    $id = mysqli_real_escape_string($conn,$_POST['searchname']);
	$from = mysqli_real_escape_string($conn,$_POST['from']);
    $to = mysqli_real_escape_string($conn,$_POST['to']);


    function defaulttab($qur){
        $hostname= "remotemysql.com";
        $username="bJZvSixLNp";
        $password="stMLQQ7kvK";
        $dbname="bJZvSixLNp";

        $conn=mysqli_connect($hostname, $username, $password, $dbname);
        $sql = mysqli_query($conn,$qur);
        $output="";
        $output.='  <div class="row">
                            <div class="col-sm-offset-1 col-md-10 text-center">';
        if(mysqli_num_rows($sql) > 0){  


            $output.=' 
                    <table class="table table-hover">
                    <caption><center><h4 class="text-center"><b> </b></h4></center></caption>
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

            $output .="<br<br><center><h3>No search results Matched!!</h3></center>";
        }
        $output .='</div></div>';
        echo $output;
    
    }


    if(!empty($id) && !empty($from) && !empty($to)){
        $s = "select * from `log` where id like '{$id}' and DATE(time) BETWEEN '{$from}' AND '{$to}'";
        defaulttab($s);

    }elseif(!empty($id) && !empty($to)){

        echo '<br><br>Enter From date to fetch results !!';

    }elseif(!empty($id) && !empty($from)){

        echo '<br><br>Enter TO date to fetch results!!';

    }elseif(!empty($from) && !empty($to)){

        $s = "select * from `log` where DATE(time) BETWEEN '{$from}' AND '{$to}'";
        defaulttab($s);
    }
    elseif(!empty($id)){

        $s = "select * from log where id like '{$id}'";
        defaulttab($s);

    }elseif(!empty($from)){

        echo '<br><br>Enter TO date to fetch results!!';

    }elseif(!empty($to)){

        echo '<br><br>Enter From date to fetch results !!';

    }
    else{
        
        $s = "select * from log ORDER BY time DESC LIMIT 25;";
        defaulttab($s);
    }


?>