<?php
require "../cos_sdk_config.php";
$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
# 删除 object
## deleteObject
try {
    $result = $cosClient->deleteObjects(array(
        'Bucket' => $bucket,
        'Objects' => array(
            array(
                'Key' => $key,
            )
        ),
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}