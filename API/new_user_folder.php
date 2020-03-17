<?php
//为新用户创建用户文件夹
# 上传文件
## putObject(上传接口，最大支持上传5G文件)
function new_user_folder($userName){
    require "./cos_sdk_config.php";
    try {
        $key = $userName . "/";
        $result = $cosClient->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => ''));
        //print_r($result);
        print("新建用户文件夹成功");
    } catch (\Exception $e) {
        echo "$e\n";
    }


}