<?php
	include_once('config.php');
	session_start();

    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = mysqli_query($conn," UPDATE users SET password ='{$password}' WHERE user_id = {$_SESSION['unique_id']}");
    if($sql){
        echo "success";
    }
    else
    {
        echo "failure";
    }     


?>