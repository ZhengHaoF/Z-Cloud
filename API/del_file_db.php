<?php
//删除文件数据库版
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$file_name = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$file_key = $_POST['file_key']; //文件MD5
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if (time() - $time < 3600 and time() - $userTime < 5) {
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    mysqli_query($conn, "set character set 'utf8'");//读库
    mysqli_query($conn, "set names 'utf8'");//写库
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num > 0) {
        //验证通过
        //删除用户表中的文件，文件表中引用数-1
        mysqli_query($conn, "DELETE FROM user_files WHERE user_id = '$id' AND file_key = '$file_key'");
        mysqli_query($conn,"UPDATE files_all SET citations_number = citations_number - 1 WHERE file_key = '$file_key'");
        //查询文件表中引用数量
        $res = mysqli_query($conn, "SELECT citations_number FROM files_all WHERE file_key = '$file_key'");
        if (mysqli_fetch_row($res)[0] <= 0) {
            //如果文件引用数为0，就删除文件
            # 删除多个 object
            ## deleteObjects
            try {
                $result = $cosClient->deleteObjects(array(
                    'Bucket' => $bucket,
                    'Objects' => array(
                        array(
                            'Key' => $file_key,
                        )
                    ),
                ));
                // 请求成功
                //print_r($result);
                //删除文件表中的记录
                $res = mysqli_query($conn, "DELETE FROM files_all WHERE file_key = '$file_key'");
                echo "删除完成";
            } catch (\Exception $e) {
                // 请求失败
                echo($e);
            }
        }else{
            echo "删除完成";
        }

    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }


} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}