<?php
	include_once('config.php');
	session_start();

    $cat = mysqli_real_escape_string($conn,$_POST['cat']);
	$cat= strtoupper($cat);
	$catcode = mysqli_real_escape_string($conn,$_POST['catcode']);
	$catcode = strtolower($catcode);

	$sql = mysqli_query($conn,"select * from category where category = '{$cat}'");
	if(mysqli_num_rows($sql) > 0){  

		echo "This Category already exist";

	}else{

		$insert_query = mysqli_query($conn, "INSERT INTO category (category, category_code)
                     VALUES ( '{$cat}','{$catcode}' )");
		
		// $sql1 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'NA','Category Name - {$cat} And Category Code - {$catcode}.','New Category Added.')");

		echo "success";
	}
?>