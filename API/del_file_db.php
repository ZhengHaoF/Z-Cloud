<?php
//删除文件 数据库版
require "./cos_sdk_config.php";
require "../config.php";
require "./user_authentication.php";
$user_name = $_POST['id']; //用户名
$Token = $_POST['Token']; //用户token
$userTime = $_POST['userTime']; //用户时间
//私有参数
$file_name = $_POST['file_name'];//对象在存储桶中的位置，即称对象键
$file_key = $_POST['file_key']; //文件MD5

$status_json = json_decode(user_authentication($user_name,$Token,$userTime),true); //用户登录验证
if($status_json['status']=="200"){
    //验证成功
    //删除用户表中的文件，文件表中引用数-1
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
	mysqli_query($conn, "DELETE FROM user_files WHERE user_id = '$user_name' AND file_key = '$file_key'");
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
}else{
    echo($status_json['status'] . "_" . $status_json['msg'] . "_" . $status_json['time']);
}
