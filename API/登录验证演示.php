<?php
require "./cos_sdk_config.php";
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    //验证成功
    //操作代码
}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
