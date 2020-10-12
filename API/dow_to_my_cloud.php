<?php
//文件转存到我的网盘
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['user_id']; //用户名
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$file_name = $_POST['file_name']; //文件名
$file_key = $_POST['file_key']; //文件MD5
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
        //两次验证完成就放行
        //查询文件是否存在
        $res = mysqli_query($conn,"SELECT * FROM files_all WHERE file_name = '$file_name' AND file_key = '$file_key'");
        if(mysqli_num_rows($res) > 0){
            // 此处少了判断文件是否已经存在该用户下
            $r = mysqli_query($conn,"SELECT * FROM user_files WHERE user_id = '$id' AND file_key = '$file_key'");
            if(mysqli_num_rows($r)==0){
                $r = mysqli_fetch_array($res);
            $dow_file_key = $r['file_key'];
            $dow_file_name = $r['file_name'];
            $dow_file_size = $r['file_size'];
            $r = mysqli_query($conn,"INSERT INTO user_files (user_id,file_name,file_key,file_size) VALUES ('$id','$dow_file_name','dow_$file_key','$dow_file_size')");
            if($r){
                echo "转存完成";
            }
            }else{
                echo "文件已存在";
            }

        }else{
            echo "文件不存在或已被删除";
        }
    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}