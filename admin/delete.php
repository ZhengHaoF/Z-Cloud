<?php 
require("../config.php");
$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
$username = $_POST['username'];
$password = $_POST['password'];
$deluser = $_POST['deluser'];
echo("用户".$deluser);
$res = mysqli_query($conn,"SELECT * FROM users WHERE user = '$username' AND pwd = '$password' and users_group ='admin_group'");//查询用户是否存在
if(mysqli_num_rows($res) > 0){
	$num = mysqli_num_rows($res);
	$re = mysqli_query($conn,"DELETE  FROM  users WHERE user = '$deluser'");
	if($re > 0){
		echo("删除成功");
	}else{
		echo("删除失败");
	}
}else{
	echo("连接数据库失败");
}
?>