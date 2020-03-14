<?php
    //注册用户
	require("../config.php");
	$user = $_POST['username'];
	$pwd = $_POST['password'];
	$email = $_POST['email'];
	$timer = $_POST['timer'];
	if(time() -  $timer <60)
	{
		$pwd = md5($pwd); //加密MD5
		$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
		$res = mysqli_query($conn,"SELECT * FROM users WHERE `user` = '$user'");
		$num = mysqli_num_rows($res);
		if($num==0){
			//新注册用户的reg_confirm是"no"
			$res = mysqli_query($conn,"INSERT INTO users VALUES('$user','$pwd','$email','user_group','no')");
			$res = mysqli_query($conn,"SELECT * FROM users WHERE `user` = '$user'");
			$num = mysqli_num_rows($res);
			if($num==0){
				echo("注册失败");
			}else{
				echo("邮件发送至您的邮箱，请点击邮箱内链接完成注册");
			}
		}else{
			echo("用户名已存在");
		}
	}else{
		echo("连接超时，请刷新后重试");
	}
?>