<?php
    session_start();
    include_once "config.php";
    
    $locid = mysqli_real_escape_string($conn, $_GET['loc_id']);
    $sql=  mysqli_query($conn,"DELETE FROM location where  lab_id = {$locid}");
    if($sql){
        $numbersql=mysqli_query($conn,"SELECT max(`lab_id`) as len from `location`");
        $number=mysqli_fetch_assoc($numbersql);
        $numberlen=$number['len']?$number['len']:0;
        $alter=mysqli_query($conn,"ALTER TABLE `location` AUTO_INCREMENT ={$numberlen}");
        echo("Deletion successfully");  
    }else{
        echo("Deletion failure");
    }


?>