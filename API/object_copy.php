<?php
//对象储存复制对象到指定文件夹
require "./cos_sdk_config.php"; //初始化SDK
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
//$TokenJson = RSA_decode($_POST['Token']);
//$id = $_POST['id']; //用户名
//$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
//$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
//$pwd = $Token['pwd']; //获取密码MD5
//$time = $Token['time'];//获取时间
//$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
//if(time()-$time<3600 and time()-$userTime < 5){
    try {
        $result = $cosClient->copyObject(array(
            'Bucket' => $bucket, //格式：BucketName-APPID
            'Key' => 'test/1.iso', //文件复制后的地址
            'CopySource' => $source_station_domain.'/ZHF/cn_windows_7_enterprise_x86_dvd_x15-70737.iso', //文件原始地址
        )); 
        // 请求成功
        print_r($result);
    } catch (\Exception $e) {
        // 请求失败
        echo($e);
    }
/*}else{
    echo "<script>alert('非法请求')</script>";
    echo time()-$time;
}*/

