<?php
//文件分享码验证
require "../config.php";
$file_code = $_POST['file_code'];
$conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
$res = mysqli_query($conn,"SELECT * FROM files_share WHERE file_code = '$file_code'");
if(mysqli_num_rows($res) != 0){
    //返回文件URL：http://localhost/Z-Cloud/share/s.html?file_code=OKKO
    echo $host."share/s.html?file_code=".$file_code;
}else{
    echo "文件提取码错误";
}
mysqli_close($conn);