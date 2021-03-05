<?php
//文件分享模块 + 网址缩短
require "./cos_sdk_config.php";
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
//私有参数
$file_key = $_POST['file_key']; //文件MD5
$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    //验证成功
            ## getObjectUrl(获取文件 UrL)
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
            $res = mysqli_query($conn, "INSERT INTO files_share VALUES('$file_code','$file_key','$user_name','$userTime')");  //写入文件分享数据库
            mysqli_close($conn);
            //echo $signedUrl;
            echo "{\"url\":" ."\"" .$host  ."share". "\",". "\"file_code\":" ."\"" . $file_code . "\"" ."}";
            //返回示例：{"url":"http://localhost/Z-Cloud/share","file_code":"1LBN"}

}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}


//网址缩短
function get_short_url($long_url)
{
    $api_url = "http://url.zhfblog.ml/API/get_short_url.php"; //API接口
    $url = $api_url . "?url=" . $long_url;
    return file_get_contents($url); //get请求
}
