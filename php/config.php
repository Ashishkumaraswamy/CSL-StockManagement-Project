<?php
	$hostname= "remotemysql.com";
	$username="bJZvSixLNp";
	$password="stMLQQ7kvK";
	$dbname="bJZvSixLNp";

	$conn=mysqli_connect($hostname, $username, $password, $dbname);
	if(!$conn)
	{
		echo "Database connection error".mysqli_connect_error();
	}

?>