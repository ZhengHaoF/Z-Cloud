<?php
//文件数 + 空间使用量
require "./cos_sdk_config.php";
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn,"SELECT COUNT(*) FROM user_files WHERE user_id = '$user_name'");
    $user_files_count_num = mysqli_fetch_row($res)[0]; //文件总数量
   
    $res = mysqli_query($conn,"SELECT SUM(file_size) AS 'user_files_count_size' FROM user_files WHERE user_id = '$user_name'");//文件总大小
    $user_files_count_size = mysqli_fetch_row($res)[0];

    $user_count_files_num_and_size = json_encode(array('status' => '200' , 'user_files_count_num' => $user_files_count_num,'user_files_count_size' => $user_files_count_size));
    echo($user_count_files_num_and_size);

    mysqli_free_result($res);
}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
