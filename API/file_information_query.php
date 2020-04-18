<?php
//在数据库中查询文件分享链接
require "../config.php";
$file_code = $_POST['file_code'];
$conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
$res = mysqli_query($conn, "SELECT * FROM files_share WHERE file_code = '$file_code'");
if (mysqli_num_rows($res) != 0) {
    $fetch_row = mysqli_fetch_row($res);
    $file_information_json = "{\"file_name\":";
    $file_information_json = $file_information_json."\"".$fetch_row['1']."\"".",";  //文件名
    $file_information_json = $file_information_json."\"file_url\":\"".$fetch_row['2']."\"".","; //文件URL
    $file_information_json = $file_information_json."\"share_user\":\"".$fetch_row['3']."\"".","; //文件分享用户
    $file_information_json = $file_information_json."\"share_time\":\"".$fetch_row['4']."\""; //文件分享的时间
    $file_information_json = $file_information_json . "}";
    echo $file_information_json;
} else {
    echo "文件提取码错误";
}
mysqli_close($conn);
