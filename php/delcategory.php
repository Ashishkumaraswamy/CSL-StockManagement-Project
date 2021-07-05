<?php
    session_start();
    include_once "config.php";
    
    $cattid = mysqli_real_escape_string($conn, $_GET['cat_id']);
    $sql=  mysqli_query($conn,"DELETE FROM category where  category_id = {$cattid}");
    if($sql){
        echo("Deletion successfully");
    }else{
        echo("Deletion failure");
    }


?>