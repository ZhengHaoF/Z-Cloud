<?php
    //登录验证
	require "../config.php";
	require "../API/RSA_encryption.php"; //引入RSA加密PHP
	$username = $_POST['u'];
	$password = $_POST['p'];
	$password = md5($password); //md5加密
    $Token = RSA_encryption($password,json_encode(time()));
    echo $Token;
				$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
				if (mysqli_connect_errno($conn)) 
				{ 
				    echo "连接 MySQL 失败: " . mysqli_connect_error();
				}else{
					$res = mysqli_query($conn,"select * from users where pwd = '$password' and user = '$username'"); //查询用户是否存在
					$num = mysqli_num_rows($res); //统计个数
					if($num>0){
						setcookie("time",time()+5,time()+3600,"/"); //设置cookie全路径
						setcookie("id",$username,time()+3600,"/"); //设置cookie全路径
						//mysql_close($conn);  //关闭连接
						$group = mysqli_fetch_row($res)[3];//查询用户组
						setcookie("group",md5($group),time()+3600,"/");//储存用户权限cookie,加密
                        setcookie("Token",$Token,time()+3600,"/");
						header("location:../user/index.php");
					}else{
						header("location:ERROR.html");
					}
				} 


?>