<?php
//下载文件
require "../cos_sdk_config.php";
$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
## getObjectUrl(获取文件 UrL)
try {
    $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
    // 请求成功
    echo $signedUrl;
} catch (\Exception $e) {
    // 请求失败
    print_r($e);
}