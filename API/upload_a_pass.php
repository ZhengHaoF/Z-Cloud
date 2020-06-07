<?php
//秒传文件模块
require "../config.php";
require "file_ground.php";
$o_key = $_POST['o_key']; //操作码
$file_name = $_POST['file_name']; //文件名
$file_key = $_POST['file_key']; //文件MD5
$user_name = $_POST['user_name'];
$conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
mysqli_query($conn, "set character set 'utf8'");//读库
mysqli_query($conn, "set names 'utf8'");//写库
if ($o_key == "select") {
    if (select_db_have_file_key($conn, $file_key) == 0) {
        //文件不存在
        echo "{\"msg\":\"\"}";
    } else {
        //文件存在
        echo "{\"msg\":\"文件存在\"}";
    }
} elseif ($o_key == "add") {
    $file_size = $_POST['file_size'];
    //添加新的文件参数在数据库中或文件引用数+1
    echo add_file_key_in_db($conn, $user_name,$file_name,$file_key,$file_size); //返回结果
}
