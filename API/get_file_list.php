<?php
//引入COS初始化文件
require "./cos_sdk_config.php";
//查询文件列表
try {
    $result = $cosClient->listObjects(array(
        'Bucket' => $bucket
    ));
    // 请求成功
    if (isset($result['Contents'])) {
        $index=0;
        $fielsMessage=[]; //初始化数组
        foreach ($result['Contents'] as $rt) {
            $fielsMessage[$index]['FilesName'] = $rt['Key'];
            $fielsMessage[$index]['FilesSize'] = $rt['Size'];
            $fielsMessage[$index]['LastModified'] = $rt['LastModified'];
            $index++;
        }
        echo json_encode($fielsMessage);
    }
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}
