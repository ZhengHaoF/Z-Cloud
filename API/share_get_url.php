<?php
//分享文件时用的下载模块
require "./cos_sdk_config.php";
require "../config.php";
$file_key = $_POST['file_key']; //文件MD5
$file_name = $_POST['file_name']; //文件名
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