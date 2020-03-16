<?php
//下载文件
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
if(time()-$time<360){
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num>0){
        //两次验证完成就放行
        ## getObjectUrl(获取文件 UrL)
        try {
            $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
            // 请求成功
            echo $signedUrl;
        } catch (\Exception $e) {
            // 请求失败
            print_r($e);
        }
    }else{
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
}else{
    echo "<script>alert('非法请求')</script>";
    echo time()-$time;
}
