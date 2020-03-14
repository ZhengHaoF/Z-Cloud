<?php
    //注册验证码验证
	require("../config.php");
	$id = $_GET['id'];
	$user = $_GET['username'];
	$reg_id =  $_COOKIE['reg_id'];	//获取cookie中的ID
	if ($id = $reg_id)
	{
		$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
		$res = mysqli_query($conn,"SELECT * FROM users WHERE `user` = '$user'");
		$num = mysqli_num_rows($res);//用户名没有重复
		if($num > 0){
			$res = mysqli_query($conn,"UPDATE users SET reg_confirm = 'yes' WHERE `user` = '$user'");
			$res = mysqli_query($conn,"SELECT * FROM users WHERE `user` = '$user' AND reg_confirm = 'yes'");
			$num = mysqli_num_rows($res);
			if($num > 0){
			}else{
				echo("验证失败");
			}
		}
	}
