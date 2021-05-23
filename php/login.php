<?php
	session_start();
	include_once("config.php");
	$user_name=mysqli_real_escape_string($conn,$_POST['username']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
	$sql=mysqli_query($conn,"SELECT * FROM users WHERE user_name='{$user_name}'");
	if(!empty($user_name) and !empty($password))
	{
		if(mysqli_num_rows($sql)>0)
		{
			$row=mysqli_fetch_assoc($sql);
			$rolestr=$row['role']==1?"Admin":"Lab User";
				if($password==$row['password'])
				{
					$_SESSION['unique_id']=$row['user_id'];
					$sql=mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'NA','Successful Login','NA')");
					echo "success";
				}
				else
				{
					echo "Invalid Password";
				}
		}
		else{
			echo 'Invalid username';
		}
	}
	else{
		echo "All input fields are required";
	}

?>