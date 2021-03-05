<?php
//PHP用户操作验证模块
//传入
/*
user_name - 用户名
Token - 用户传入的Token
userTime - 用户传入的时间
*/
function user_authentication($user_name,$Token,$userTime){
    require "./RSA_decode.php"; //引入加密PHP
    require "../config.php";
    $TokenJson = RSA_decode($Token);
    $Token_decode = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
    $pwd = $Token_decode['pwd']; //获取密码MD5
    $time = $Token_decode['time'];//获取时间
    $userTime = $userTime; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
    if (time() - $time < 3600 and time() - $userTime < 5) {
        $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
        mysqli_query($conn, "set character set 'utf8'");//读库
        mysqli_query($conn, "set names 'utf8'");//写库
        $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$user_name' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
        $num = mysqli_num_rows($res);
        if ($num > 0) {
            //两次验证完成就放行
            $status_json = json_encode(array("status"=>"200","msg"=>"status OK","time"=> time() - $time));
            return $status_json;
        } else {
            $status_json = json_encode(array("status"=>"404","msg"=>"user does not exist","time"=> time() - $time));
            return $status_json;
        }
    } else {
        $status_json = json_encode(array("status"=>"401","msg"=>"bad request","time"=> time() - $time));
        return $status_json;
    }

}
