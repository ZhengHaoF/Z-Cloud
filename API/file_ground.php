<?php
//文件系统底层封装，这是整个云盘架构的基础
function select_db_have_file_key($conn, $file_key)
{
    //查询数据库里面有没有上传的文件
    $res = mysqli_query($conn, "SELECT COUNT(*) FROM files_all WHERE file_key = '$file_key'");
    if (mysqli_fetch_row($res)[0] == 0) {
        return 0;//文件不存在
    } else {
        return 1;//文件存在
    }
    mysqli_close($conn);
}

function add_file_key_in_db($conn,$user_name, $file_name,$file_key ,$file_size,$file_path,$file_type)
{
    //添加新的文件参数在数据库中
    if(select_db_have_file_key($conn,$file_key)==1){
        //查看用户是否有该文件，如果有就返回已存在
        //文件以及存在的话就让引用数+1
        $res = mysqli_query($conn,"SELECT COUNT(*) FROM user_files WHERE user_id= '$user_name' AND file_key ='$file_key'");
        if (mysqli_fetch_row($res)[0]==0){
            $res = mysqli_query($conn, "UPDATE files_all SET citations_number = citations_number + 1 WHERE file_key ='$file_key'");
            //添加进用户文件表
            $res = mysqli_query($conn, "INSERT INTO user_files VALUES('$user_name','$file_name','$file_key','$file_size','$file_path','$file_type')");
            return "引用数+1";
        }else{
            $res = mysqli_query($conn, "INSERT INTO user_files VALUES('$user_name','$file_name','$file_key','$file_size','$file_path','$file_type')");
            return "文件已存在";
        }
    }else{
        //文件不存在就添加进数据库
        $res = mysqli_query($conn, "INSERT INTO files_all VALUES('$file_name','$file_key','$file_size',1)");
        //添加进用户文件表
        $res = mysqli_query($conn, "INSERT INTO user_files VALUES('$user_name','$file_name','$file_key','$file_size','$file_path','$file_type')");
        return "添加成功";
    }
    mysqli_close($conn);
}

/*
//暂时废弃
function del_file_key_in_db($conn,$file_key,$file_name){
    //用户删除文件后，引用数-1，如果为0就删除文件
    $res = mysqli_query($conn,"UPDATE files_all SET citations_number = citations_number -1 WHERE file_key ='$file_key'");
    $res = mysqli_query($conn,"SELECT COUNT(*) FROM files_all WHERE file_key = '$file_key'");
    if (mysqli_fetch_row($res)[0]==0){
        $res = mysqli_query($conn,"DELETE FROM files_all WHERE file_key = '$file_key'");
    }
    mysqli_close($conn);
}
*/