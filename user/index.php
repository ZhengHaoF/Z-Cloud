<?php
require("../config.php");
require("../API/GetIP.php");
global $SecretId;
global $SecretKey;
global $group;  //定义全局变量
$group = $_COOKIE['group'];
$time = $_COOKIE['time'];    //获取传来的时间
$username = $_COOKIE['user_id'];
if (time() - $time < 3600) {      //判断时间
    $conn = mysqli_connect($MySqlHost, $MySqlUser, $MySqlPwd, $MySqlDatabaseName);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE `user` = '$username' AND reg_confirm = 'yes'");
    $num = mysqli_num_rows($res);
    $res = mysqli_query($conn, "SELECT * from secre");
    if ($num > 0) {
        //通过验证并开始获取文件
    } else {
        echo "<script>alert('您的账户还未通过邮箱验证')</script>";
        echo "<script>window.history.go(-1);</script>";
    }
} else {
    echo "<script>alert('参数有误，请重新登录')</script>";
    echo "<script>window.history.go(-1);</script>";
}

function getGroup()
{
    echo($GLOBALS['group']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>COS</title>
    <!--//手机端自适应-->
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <!--//手机端自适应-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <script src="js/cos-js-sdk-v5.js"></script>
    <script src="js/cos-auth.min.js"></script>
    <script src="js/mDialogMin.js"></script> <!-- 弹窗js-->
    <link href="css/dialog.css" rel="stylesheet"><!-- 弹窗css-->
    <style>
        /*不知道为啥，这个只能在页内样式中设置 */
        #user_count{
            color: #5cacee;
            position: absolute;
            right: 15%;
            top: 2%;
            font-size: 18px;
        }
    </style>
    <script src="https://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>
    <!--
    <script src="../js/jquery-3.2.1.min.js"></script>
    -->
    <link href="../layui/css/layui.css" rel="stylesheet">
    <script src="../layui/layui.js"></script>
    <link href="./css/index.css" rel="stylesheet">
    <script>
        //sleep函数
        function sleep(delay) {
            var start = (new Date()).getTime();
            while ((new Date()).getTime() - start < delay) {
                continue;
            }
        }
    </script>
    <script>
        var up_box_h; //单击上传弹出框的高度
        //手机自适应
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if (clientWidth >= 750) {
                        up_box_h = "50%";
                    } else {
                        docEl.style.fontSize = '20px';
                        up_box_h = "90%";
                    }
                };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <!--<script src="js/md5.js"></script>md5加密 -->
    <script>
        //获取COOKIE
        function getCookie(cookie_name) {
            var allcookies = document.cookie;
            //索引长度，开始索引的位置
            var cookie_pos = allcookies.indexOf(cookie_name);

            // 如果找到了索引，就代表cookie存在,否则不存在
            if (cookie_pos != -1) {
                // 把cookie_pos放在值的开始，只要给值加1即可
                //计算取cookie值得开始索引，加的1为“=”
                cookie_pos = cookie_pos + cookie_name.length + 1;
                //计算取cookie值得结束索引
                var cookie_end = allcookies.indexOf(";", cookie_pos);

                if (cookie_end == -1) {
                    cookie_end = allcookies.length;

                }
                //得到想要的cookie的值
                var value = unescape(allcookies.substring(cookie_pos, cookie_end));
            }
            return value;
        }

        window.onload = function () {
            //记录日志
            /*  if ("<?php echo $_COOKIE['id'];?>" != "") {
                Send_post("loginYes", null);
            }*/
            //获取IP
            var ip = "<?php getIp() ?>";
            $.get("https://www.36ip.cn/?ip=",
                {
                    ip: ip,
                },
                function (data) {
                    var As = data.data;//获取json数组
                    t = "&nbsp&nbsp您的IP" + ip + "&nbsp" + As.province + As.city + As.isp;//获取省，市，运营商
                    document.getElementById("IpAddress").innerHTML = t;
                    console.log(data);
                }
            );
            //获取用户文件
            get_user_files();
        };
    </script>
    <script>
        function get_user_files() {
            //获取用户文件
            $.post("../API/get_user_files_list_db.php", {  //获取用户文件
                "Token": getCookie("Token"),
                "id": getCookie("user_id"),
                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳s
            }, function (data) {
                var files_message_json = $.parseJSON(data);
                var files_lenght = files_message_json.length;
                var files_list_box_html = ""; //要加载的HTML文档
				//清空文件列表
				if(document.getElementById("files_list_box").childNodes.length!=1){
						document.getElementById("files_list_box").innerHTML = "";
				}
                for (var i = 0; i < files_lenght; i++) {
                    var file_name = decodeURI(files_message_json[i]['FilesName']); //文件名URL解码
                    var file_size = Number(files_message_json[i]['FilesSize']) / 1024 / 1024;//文件大小
                    //var file_last_modified = files_message_json[i]['LastModified'];//文件最后修改日期

                    var file_key = files_message_json[i]['FilesKey']; //文件的KEY

                    var file_list_tr = document.createElement('tr');
                    var file_list_td = document.createElement('td');
                    file_list_td.setAttribute("onclick","file_operating(this.value)");
                    file_list_td.setAttribute("value",file_name);
                    file_list_td.innerHTML = file_name;
                    file_list_tr.appendChild(file_list_td);
                    file_list_td = document.createElement('td');
                    file_list_td.innerHTML = file_size.toFixed(2).toString() + "MB";
                    file_list_tr.appendChild(file_list_td);
                    file_list_td = document.createElement('td');
                    file_list_tr.appendChild(file_list_td);
                    var file_list_button = document.createElement("button");
                    file_list_button.innerText = "文件操作";
                    file_list_button.className = "layui-btn";
                    file_list_button.style.float="left"
                    file_list_button.setAttribute("onclick","file_operating(" + "\"" + file_name + "\"," + "\"" + file_key + "\"," +"\"" +files_message_json[i]['FilesSize'] +"\""+ ")")
                    file_list_button.setAttribute("value",file_name)
                    file_list_td.appendChild(file_list_button);
                    file_list_tr.appendChild(file_list_td);
                    document.getElementById("files_list_box").appendChild(file_list_tr);



                    
/*
                                        files_list_box_html = files_list_box_html + " <tr>" +
                        "            <td onclick='file_operating(this.value)' value='" + file_name + "'>" + file_name + "</td>" +
                        "            <td>" + file_size.toFixed(2).toString() + "MB" + "</td>" +
                        "            <td>" +
                        "                <button class='layui-btn' style='float: left' onclick='file_operating(" + "\"" + file_name + "\"," + "\"" + file_key + "\"," +"\"" +files_message_json[i]['FilesSize'] +"\""+ ")' value='" + file_name + "' >文件操作</button>" +
                        "            </td>" +
                        "        </tr>"
*/
                }

                //document.getElementById("files_list_box").innerHTML = files_list_box_html;
                
            })
        }

        function file_operating(file_name, file_key, file_size) {
            //弹窗
            layui.use('layer', function () {
                    layer.confirm('请选择操作？', {
                        //btn: ['下载', '删除', '分享','在线播放','文件预览（测试）','PDF预览（测试）','文件预览']
                        btn: ['下载', '删除', '分享','文件预览（测试）']
                        , btn1: function (index) {
                            //  文件操作
                            //按钮：下载
                            $.post("../API/git_file_url_db.php", {
                                "file_name": file_name,
                                "Token": getCookie("Token"),
                                "id": getCookie("user_id"),
                                "file_key": file_key,
                                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
                            }, function (data) {
                                window.open(data);
                                layer.close(index);
                            })
                        }, btn2: function (index) {
                            //删除
                            $.post("../API/del_file_db.php", {
                                "file_name": file_name,
                                "Token": getCookie("Token"),
                                "id": getCookie("user_id"),
                                "file_key": file_key,
                                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
                            }, function (data) {
                                layer.msg(data);
                                get_user_files();
                            });
                            layer.close(index);
                        }, btn3: function (index) {
                            //分享
                            $.post("../API/file_sharing.php", {
                                "Token": getCookie("Token"),
                                "id": getCookie("user_id"),
                                "file_key": file_key,
                                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
                            }, function (data) {
                                layer.open({
                                    title: '文件链接',
                                    content: $.parseJSON(data)['url'] + "<br>提取码：" + $.parseJSON(data)['file_code'] + "<br>链接30天内有效"
                                });
                            });
                            layer.close(index);
                        },btn4: function (index) {
                            $.post("../API/git_file_url_db.php", {
                                "file_name": file_name,
                                "Token": getCookie("Token"),
                                "id": getCookie("user_id"),
                                "file_key": file_key,
                                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
                            }, function (url_data) {
                                var suffix = file_name.substring(file_name.lastIndexOf(".")+1).toLocaleUpperCase();//文件后缀
                                console.log(suffix);
                                if(suffix == "EXE"){
                                    layer.msg("该文件不支持预览");
                                }else if(suffix == "PDF"){
                                    //PDF处理
                                    layer.open({
                                        title:file_name,
                                        offset: 'auto',
                                        area: ['60%', '70%'],
                                        type: 2, 
                                        content: "../API/pdf_read/web/viewer.html?file=" + url_data + "#page=1" //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                                        });
                                }else if(suffix == "TXT"){
                                    $.get(url_data, function(str){
                                        layer.open({
                                            type: 1,
                                            content:str,
                                            offset: 'auto',
                                            area: ['60%', '70%'],
                                            title:file_name
                                        });
                                    });
                                }else if(suffix == "MP4"){
                                    //视频预览
                                    console.log(url_data)
                                    vod_url = "../API/to_player.html?vod_url=" + window.encodeURI(window.btoa(url_data));
                                    console.log(vod_url)
                                    layer.open({
                                        title:file_name,
                                        offset: 'auto',
                                        area: ['60%', '70%'],
                                        type: 2,
                                        content: vod_url //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                                        });
                                }else if(suffix == "JPG" || suffix == "PNG"){
                                    //按钮，查看图片
                                    $.post("../API/git_file_url_db.php", {
                                        "file_name": file_name,
                                        "Token": getCookie("Token"),
                                        "id": getCookie("user_id"),
                                        "file_key": file_key,
                                        "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
                                    }, function (data) {
                                        var str = "<img src='" + data + "' width='100%'>"
                                        layer.open({
                                        type: 1, 
                                        content: str,
                                        offset: 'auto',
										area: ['50%', '80%']
                                        });
                                        layer.close(index);
                                    })

                                }else{
                                    layer.msg("该文件暂不支持在线预览");
                                }
                            })                           
                        }
                    });
                }
            )
        }

        function up() {
            //上传文件
            layui.use('layer', function () {
                layer.open({
                    type: 2,
                    area: [up_box_h, '30%'],
                    content: ['./upload/upload.html', 'no'], //不出现滚动条
                    end: function (index, layero) { //层销毁后回调
                        layer.msg("上传完成");
                        get_user_files(); //重新获取用户文件列表
                    }
                });
            });
        }

        function user_count(){
            //用量统计
            $.post("../API/user_count.php",{
                "Token": getCookie("Token"),
                "id": getCookie("user_id"),
                "userTime": Date.parse(new Date()) / 1000 //获取精确到秒的时间戳
            },function(data){
                var user_count_files_num_and_size_json = JSON.parse(data);
                var status = user_count_files_num_and_size_json['status']
                if(status="200"){
                    //成功
                    var user_files_count_size = user_count_files_num_and_size_json['user_files_count_size']; //空间用量：
                    var user_files_count_num = user_count_files_num_and_size_json['user_files_count_num']; //文件数量
                    console.log("空间用量：" + Math.round(user_files_count_size/1024/1024*10)/10 + "MB");
                    console.log("文件数量：" + user_files_count_num);
                    var str = "空间用量：" + Math.round(user_files_count_size/1024/1024*10)/10 + "MB" + "<br/>" +"文件数量：" + user_files_count_num
                    layui.use('layer', function (){
                        layer.open({
                            type: 1,
                            content:str
                        });
                    });

                }else{
                    alert(status)
                }
            })
        }

        function d_offline(){
            alert("正在开发");
        }
    </script>
    <!-- 人物  CSS
    <link rel="stylesheet" href="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/css/live2d.css"/>
    -->
</head>
<body>
<header>
    <div id="headName"><em>Z-Cloud</em></div>
    <div id="user_count" onclick="user_count()">用量统计</div>
    <div id="upload" onclick="up()">上传</div>
    <!-- <div id="xhx"></div>
  <div id="File_synchronization_time">登录时间：<span><?php echo(date("Y-m-d H:i:s")) ?></span><span
                id="IpAddress"></span></div>
    <div id="Time"></div>-->
</header>
<!--第一列-->
<div id="main_box">
    <table class="layui-table" id="file_list">
        <thead>
        <tr>
            <th>文件名</th>
            <th>大小</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="files_list_box">
        </tbody>
    </table>
</div>
<!--
live2D人物配置
<div id="landlord">
    <div class="message" style="opacity:0"></div>
    <canvas id="live2d" width="280" height="300" class="live2d"></canvas>
    <div class="hide-button">隐藏</div>
</div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
    var message_Path = '/live2d/'
    var home_Path = 'https://model-1253780623.cos.ap-guangzhou.myqcloud.com/' //你的网站地址，最后必须要加斜杠
</script>
<script type="text/javascript"
        src="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/js/live2d.js"></script>
<script type="text/javascript"
        src="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/js/message.js"></script>
<script type="text/javascript">

    function RandomNumBoth(Min, Max) {
        var Range = Max - Min;
        var Rand = Math.random();
        var num = Min + Math.round(Rand * Range); //四舍五入
        return num;
    }

    $.getJSON('https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/model.json', function (model) {
        modelObj = JSON.parse(JSON.stringify(model, null, 2)); //这里
        textures = modelObj.textures;
        modelObj.textures = ['https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/textures/' + textures[RandomNumBoth(0, textures.length)]];
        loadlive2d('live2d', 'https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/model.json', '', modelObj);
    });
    console.log("使用的贴图和模型：" + modelObj);
</script>
-->
</body>

</html>