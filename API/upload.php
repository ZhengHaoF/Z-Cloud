<?php
        require("./config.php");
        if ($_FILES["file"]["name"] != ""){
                if ($_FILES["file"]["error"] > 0 )
                {
                    echo "错误：" . $_FILES["file"]["error"] . "<br>";
                }
                else {
                        if($_FILES["file"]["type"] != "image/jpeg"){
                            echo "请勿上传非jpg文件" ;
                        }else{
                            $original_file_name = $_FILES["file"]["name"]; //原始文件名
                            preg_match_all ("/\.[a-zA-Z]{3}/", $original_file_name, $pat_array);
                            //文件后缀名：print_r($pat_array[0][1]);
                            //源文件后缀
                            $original_file_suffix =  $pat_array[0][0];
                            $FILE_NAME = GetRandStr(10) . $original_file_suffix;
                            //$FILE_NAME = $_FILES["file"]["name"];
                            $FILE_TYPE = $_FILES["file"]["type"];
                            $FILE_SIZE = round($_FILES["file"]["size"] / 1024 / 1024, 2);
                            $file_url = $host ."img/" . $FILE_NAME;
                            //生成文件信息JSON数组
                            $file_msg_array = array("file_url"=>$file_url,"file_size"=>$FILE_SIZE,"file_type"=>$FILE_TYPE,"success"=>"200");
                            
                           //$coon = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
                          //mysqli_select_db($coon, "img_all");
                            
                            //文件保存
                            if (file_exists("img/" . $_FILES["file"]["name"])) {
                                echo $_FILES["file"]["name"] . "<br/> 文件已经存在。 ";
                            } else {
                                // 如果 img 目录不存在该文件则将文件上传到 video 目录下
                                //把文件写入数据库
                                //$res = mysqli_query($coon, "INSERT INTO files_data VALUES ('$FILE_NAME','$FILE_TYPE','$FILE_SIZE')");
                                move_uploaded_file($_FILES["file"]["tmp_name"], "img/" . $FILE_NAME);
                                echo(json_encode($file_msg_array));
                            }
                            
                        }
                    }
        }else{
            echo "未上传文件";
        }
        function GetRandStr($length){
            //字符组合
            $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $len = strlen($str)-1;
            $randstr = '';
            for ($i=0;$i<$length;$i++) {
             $num=mt_rand(0,$len);
             $randstr .= $str[$num];
            }
            return $randstr;
           }