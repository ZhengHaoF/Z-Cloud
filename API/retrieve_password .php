<?php
//找回密码
    require("../config.php");
    require("./Email/sendEmail.php"); //发送邮件
    //获取用户名
    $email = $_POST['email'];
    $username = $_POST['username'];
    $newpwd = $_POST['newpwd'];  // 加密参数
    $key = mt_rand(1000,9999);
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$username'");
    if ($res > 0) {
        PostEmail($email, "【云盘网页端】您的验证码是：" .$key. "如果不是本人操作，请忽略此邮件");
    }

