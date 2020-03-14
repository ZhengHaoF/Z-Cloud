<?php
//记录IP
require("../config.php");
$request = $_POST['request'];
$IP = $_POST['IP'];
$ID = $_POST['ID'];
$other = $_POST['other'];
    function  owc($text){
        $file = fopen("../log.txt","a");
        fwrite($file,$text);
        fclose($file);
        echo "文件写入完成";
    }
    if($request == "visit"){
       $text = "IP是 " . $IP . " 的用户访问你的主页 " . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }elseif($request == "loginYes") {
        $text = "IP是 " .$IP. " 尝试登陆你的网站，" . "登陆成功，" . "用户名为：" .$ID . "，" . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }elseif ($request == "deleteFileYes"){
        $text = "IP是 " .$IP. " 删除了文件，删除成功" . "用户名为：" .$ID . "，". "文件名为：" . $other. "，" . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }elseif ($request == "deleteFileNo"){
        $text = "IP是 " .$IP. " 尝试删除文件，删除失败，" . "用户名为：" .$ID . "，". "文件名为：" . $other. "，" . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }elseif ($request == "registerNo"){
        $text = "IP是 " .$IP. " 尝试注册用户，还未进行验证，" . "用户名为：" .$ID . "，". "邮箱为：" . $other. "，" . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }elseif ($request == "registerYes"){
        $text = "IP是 " .$IP. " 尝试注册用户，完成验证，" . "用户名为：" .$ID . "，". "邮箱为：" . $other. "，" . date('Y-m-d H:i:s', time()) . "\n";
        owc($text);
    }


