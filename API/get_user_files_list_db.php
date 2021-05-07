<?php
//查询所有文件列表，使用数据库版
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    //验证成功
    //操作代码
    ## (获取文件 UrL)
    // 请求成功
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    mysqli_query($conn, "set character set 'utf8'");//读库
    mysqli_query($conn, "set names 'utf8'");//写库
    $filesMessage = []; //初始化数组
    $res = mysqli_query($conn, "SELECT * FROM user_files WHERE user_id = '$user_name'");
    $index = 0;
    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
        $rt = mysqli_fetch_assoc($res);
        $filesMessage[$index]['FilesName'] = $rt['file_name'];
        $filesMessage[$index]['FilesSize'] = $rt['file_size'];
        $filesMessage[$index]['FilesKey'] = $rt['file_key'];
        $filesMessage[$index]['FilesPath'] = $rt['file_path'];
        $filesMessage[$index]['FilesType'] = $rt['file_type'];
        $index++;
    }
    echo json_encode($filesMessage);
}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
