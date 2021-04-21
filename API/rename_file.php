<?php
//文件重命名
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
//私有参数
$file_name = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$file_key = $_POST['file_key']; //文件MD5
$rename_name = $_POST['rename_name']; //新的文件名

$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    //验证成功
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $sql = "UPDATE user_files SET file_name = '$rename_name' WHERE user_id = '$user_name' AND file_key = '$file_key'";
    if(mysqli_query($conn,$sql)){
        $data = array("status"=>"200","old_name"=>$file_name,"new_name" => $rename_name);
        echo(json_encode($data));
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
