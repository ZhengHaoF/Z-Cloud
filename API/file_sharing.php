<?php
//文件分享模块 + 网址缩短
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if(time()-$time<3600 and time()-$userTime < 5){
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num>0){
        //两次验证完成就放行
        ## getObjectUrl(获取文件 UrL)
        try {
            $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+50000 minutes');
            // 请求成功
            //echo $signedUrl;
            echo get_short_url(urlencode(str_replace($source_station_domain,$speed_up_domain,$signedUrl))); //原站域名替换成加速域名,并把网址缩短加一个URL编码
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

//网址缩短
function get_short_url($long_url){
    $api_url = "https://api.d5.nz/api/dwz/tcn.php"; //API接口
    $url = $api_url . "?url=" . $long_url;
    echo file_get_contents($url); //get请求
}
