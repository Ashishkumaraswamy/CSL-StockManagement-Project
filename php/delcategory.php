<?php
    session_start();
    include_once "config.php";
    
    $cattid = mysqli_real_escape_string($conn, $_GET['cat_id']);
    $sql=  mysqli_query($conn,"DELETE FROM category where  category_id = {$cattid}");
    if($sql){
        $numbersql=mysqli_query($conn,"SELECT max(`category_id`) as len from `category`");
        $number=mysqli_fetch_assoc($numbersql);
        $numberlen=$number['len']?$number['len']:0;
        $alter=mysqli_query($conn,"ALTER TABLE `category` AUTO_INCREMENT ={$numberlen}");
        echo("Deletion successfully");  
    }else{
        echo("Deletion failure");
    }


?>