<?php
//获取文件URL
require "./cos_sdk_config.php";
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
//私有参数
$file_name = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$file_key = $_POST['file_key']; //文件MD5

$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    //验证成功
    //操作代码
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
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
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
