<?php
require("../config.php");
global $num;
$user = $_POST[ 'username' ];
$pwd = $_POST[ 'password' ] ;
$pwd = md5($pwd);
$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
$res = mysqli_query( $conn, "SELECT * FROM users WHERE `user` = '$user' AND pwd = '$pwd' AND `users_group` = 'admin_group'" ); //向数据库查询
if($res > 0){
	setcookie("username",$user,time()+3600,"/");
	setcookie("pwd",$pwd,time()+3600,"/");
}
$num = mysqli_num_rows($res);
echo($GLOBALS['num'] > 0);  //返回用户状态
?>