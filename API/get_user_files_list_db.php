<?php
//查询所有文件列表，使用数据库版
//引入COS初始化文件
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
        ## (获取文件 UrL)
        // 请求成功
        $filesMessage = []; //初始化数组
        $res = mysqli_query($conn, "SELECT * FROM user_files WHERE user_id = '$id'");
        $index = 0;
        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
            $rt = mysqli_fetch_assoc($res);
            $filesMessage[$index]['FilesName'] = $rt['file_name'];
            $filesMessage[$index]['FilesSize'] = $rt['file_size'];
            $filesMessage[$index]['FilesKey'] = $rt['file_key'];
            $index++;
        }
        echo json_encode($filesMessage);
    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}