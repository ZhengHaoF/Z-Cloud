<?php
//获取文件URL，使用数据库版
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$file_name = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$file_key = $_POST['file_key']; //文件MD5
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if(time()-$time<3600 and time()-$userTime < 5){
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    mysqli_query($conn, "set character set 'utf8'");//读库
    mysqli_query($conn, "set names 'utf8'");//写库
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num>0){
        //两次验证完成就放行
        //复制文件到下载文件夹
        //echo $source_station_domain.'/'.$file_key;
        try {
            $result = $cosClient->copyObject(array(
                'Bucket' => $bucket, //格式：BucketName-APPID
                'Key' => 'download/'.$file_name, //文件复制后的地址
                'CopySource' => $source_station_domain.'/'.$file_key, //文件原始地址
            ));
            // 请求成功
            //print_r($result);
        } catch (\Exception $e) {
            // 请求失败
            echo($e);
        }

        ## getObjectUrl(获取文件 UrL)
        try {
            $signedUrl = $cosClient->getObjectUrl($bucket, "download/".$file_name, '+60 minutes');
            // 请求成功
            //echo $signedUrl;
            echo str_replace($source_station_domain,$speed_up_domain,$signedUrl); //把原站域名替换成加速域名
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
