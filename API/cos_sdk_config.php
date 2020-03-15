<?php
//COS SDK初始化
require "../cos-php-sdk-v5/vendor/autoload.php"; //引入腾讯SDK
$secretId = "AKID0ufFWm1ujSI2bGP5EmBSbZM1Wq01KmRz"; //"云 API 密钥 SecretId";
$secretKey = "V2QrCOODpWFtMBuTs680lZKuIUefU7d5"; //"云 API 密钥 SecretKey";
$region = "ap-shanghai"; //设置一个默认的存储桶地域
$bucket = "z-cloud-1253780623"; //存储桶名称 格式：BucketName-APPID
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials' => array(
            'secretId' => $secretId,
            'secretKey' => $secretKey)));