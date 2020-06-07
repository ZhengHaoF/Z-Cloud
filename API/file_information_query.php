<?php
//在数据库中查询文件分享链接
require "../config.php";
$file_code = $_POST['file_code'];
$conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
mysqli_query($conn, "set character set 'utf8'");//读库
mysqli_query($conn, "set names 'utf8'");//写库
$res = mysqli_query($conn, "SELECT * FROM files_share WHERE file_code = '$file_code'");
$file_info = mysqli_fetch_assoc($res);
$file_key = $file_info['file_key']; //获取文件MD5
$share_user = $file_info['share_user']; //分享文件的用户名
$share_time = $file_info['share_time']; //分享文件的时间
if (mysqli_num_rows($res) != 0) {
    $res = mysqli_query($conn,"SELECT * FROM files_all WHERE file_key = '$file_key'");
    $fetch_row = mysqli_fetch_assoc($res);
    $file_information_json = "{\"file_name\":";
    $file_information_json = $file_information_json . "\"" . $fetch_row['file_name'] . "\"" . ",";  //文件名
    $file_information_json = $file_information_json . "\"file_key\":\"" . $fetch_row['file_key'] . "\"" . ","; //文件的MD5
    $file_information_json = $file_information_json . "\"share_user\":\"" . $share_user . "\"" . ","; //文件分享用户
    $file_information_json = $file_information_json . "\"share_time\":\"" . $share_time . "\","; //文件分享的时间
    $file_information_json = $file_information_json . "\"file_size\":\"" . $fetch_row['file_size'] . "\""; //文件大小
    $file_information_json = $file_information_json . "}";
    echo $file_information_json;
} else {
    echo "文件提取码错误";
}
mysqli_close($conn);
