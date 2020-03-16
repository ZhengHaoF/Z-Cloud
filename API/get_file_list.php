<?php
//引入COS初始化文件
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
//查询文件列表
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if (time() - $time < 3600 and time() - $userTime < 5) {
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num > 0) {
        //两次验证完成就放行
        ## getObjectUrl(获取文件 UrL)
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
    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}
