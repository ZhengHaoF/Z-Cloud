<?php
//COS SDK初始化
require "../cos-php-sdk-v5/vendor/autoload.php"; //引入腾讯SDK
$secretId = "AKID0ufFWm1ujSI2bGP5EmBSbZM1Wq01KmRz"; //"云 API 密钥 SecretId";
$secretKey = "V2QrCOODpWFtMBuTs680lZKuIUefU7d5"; //"云 API 密钥 SecretKey";
$region = "ap-shanghai"; //设置一个默认的存储桶地域
$bucket = "z-cloud-1253780623"; //存储桶名称 格式：BucketName-APPID

//其他参数
//如果没有开启CDN加速，那么原站域名和加速域名填一样的
$source_station_domain ="z-cloud-1253780623.cos.ap-shanghai.myqcloud.com"; //cos原站域名
$speed_up_domain = "z-cloud-1253780623.file.myqcloud.com"; //CDN加速域名
//开始初始化
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials' => array(
            'secretId' => $secretId,
            'secretKey' => $secretKey)));