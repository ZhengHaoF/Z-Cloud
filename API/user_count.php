<?php
//文件数 + 空间使用量
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if (time() - $time < 3600 and time() - $userTime < 5) {
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    mysqli_query($conn, "set character set 'utf8'");//读库
    mysqli_query($conn, "set names 'utf8'");//写库
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num > 0) {
        //两次验证完成就放行
        $res = mysqli_query($conn,"SELECT COUNT(*) FROM user_files WHERE user_id = '$id'");
        $user_files_count_num = mysqli_fetch_row($res)[0]; //文件总数量
       
        $res = mysqli_query($conn,"SELECT SUM(file_size) AS 'user_files_count_size' FROM user_files WHERE user_id = '$id'");//文件总大小
        $user_files_count_size = mysqli_fetch_row($res)[0];

        $user_count_files_num_and_size = json_encode(array('status' => '200' , 'user_files_count_num' => $user_files_count_num,'user_files_count_size' => $user_files_count_size));
        echo($user_count_files_num_and_size);

        mysqli_free_result($res);
    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}
