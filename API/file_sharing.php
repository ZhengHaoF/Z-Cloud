<?php
//文件分享模块 + 网址缩短
require "./cos_sdk_config.php";
require "./RSA_decode.php"; //引入加密PHP
require "../config.php";
$TokenJson = RSA_decode($_POST['Token']);
$id = $_POST['id']; //用户名
$key = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$Token = json_decode($TokenJson, true); //true是让这个傻逼东西返回将返回 array 而非 object 。妈的好端端要返回对象，老子搞一天
$pwd = $Token['pwd']; //获取密码MD5
$time = $Token['time'];//获取时间
$userTime = $_POST['userTime']; //用户提交请求时的时间,这个设计有问题，有时间要改，用户采用RC4来加密才行
if (time() - $time < 3600 and time() - $userTime < 5) {
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    mysqli_query($conn, "set character set 'utf8'");//读库
    mysqli_query($conn,"set names 'utf8'");//写库
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$id' AND `reg_confirm` = 'yes' AND `pwd` = '$pwd'");
    $num = mysqli_num_rows($res);
    if ($num > 0) {
        //两次验证完成就放行
        ## getObjectUrl(获取文件 UrL)
        try {
            $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+50000 minutes');
            // 请求成功
            //echo $signedUrl;
            $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $file_code = "";
            $res = mysqli_query($conn, "SELECT COUNT(*) FROM files_share WHERE file_code = $file_code");
            //直到产生唯一数
            do {
                for ($i = 0; $i <= 3; $i++) {
                    $random_num = rand(0, 26);
                    $file_code = $file_code . substr($str, $random_num, 1);
                }
                $res = mysqli_query($conn, "SELECT COUNT(*) FROM files_share WHERE file_code = '$file_code'");
            } while (mysqli_fetch_row($res)[0] = 0);
            $signedUrl = get_short_url(urlencode(str_replace($source_station_domain, $speed_up_domain, $signedUrl))); //原站域名替换成加速域名,并把网址缩短加一个URL编码
            $file_url = json_decode($signedUrl,true)['url'];  //文件短网址
            $res = mysqli_query($conn, "INSERT INTO files_share VALUES('$file_code','$key','$file_url','$id','$time')");  //写入文件分享数据库
            mysqli_close($conn);
            //echo $signedUrl;
            echo "{\"url\":" ."\"" .$host  ."share". "\",". "\"file_code\":" ."\"" . $file_code . "\"" ."}";
            //返回示例：{"url":"http://localhost/Z-Cloud/share","file_code":"1LBN"}
        } catch (\Exception $e) {
            // 请求失败
            print_r($e);
        }
    } else {
        echo "<script>alert('用户不存在')</script>";
        echo $id;
    }
} else {
    echo "<script>alert('非法请求')</script>";
    echo time() - $time;
}

//网址缩短
function get_short_url($long_url)
{
    $api_url = "http://url.zhfblog.ml/API/get_short_url.php"; //API接口
    $url = $api_url . "?url=" . $long_url;
    return file_get_contents($url); //get请求
}
