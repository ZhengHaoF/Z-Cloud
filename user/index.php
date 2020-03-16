<?php
require("../config.php");
require("../API/GetIP.php");
global $SecretId;
global $SecretKey;
global $group;  //定义全局变量
$group = $_COOKIE['group'];
$time = $_COOKIE['time'];    //获取传来的时间
$username = $_COOKIE['id'];
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
    <script src="../js/jquery-3.2.1.min.js"></script>
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
        //手机自适应
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if (clientWidth >= 750) {

                    } else {
                        docEl.style.fontSize = '20px'
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
            $.get("http://api.online-service.vip/ip3",
                {
                    ip: ip,
                },
                function (data) {
                    var As = data.data;//获取json数组
                    t = "&nbsp&nbsp您的IP" + ip + "&nbsp" + As.province + As.city + As.isp;//获取省，市，运营商
                    document.getElementById("IpAddress").innerHTML = t;
                }
            );
        };

        $.get("../API/get_file_list.php", function (data) {
            var files_message_json = $.parseJSON(data);
            var files_lenght = files_message_json.length;
            var files_list_box_html = ""; //要加载的HTML文档
            for (var i = 0; i < files_lenght; i++) {
                var file_name = files_message_json[i]['FilesName']; //文件名
                var file_size = Number(files_message_json[i]['FilesSize']) / 1024 / 1024;//文件大小
                var fiel_last_modified = files_message_json[i]['LastModified'];//文件最后修改日期
                files_list_box_html = files_list_box_html + " <tr>" +
                    "            <td>" + file_name + "</td>" +
                    "            <td>" + file_size.toFixed(2).toString() + "MB" + "</td>" +
                    "            <td>" +
                    "                <button class='layui-btn' style='float: left' onclick='file_operating(this.value)' value='" + file_name + "' >文件操作</button>" +
                    "            </td>" +
                    "        </tr>"
            }
            document.getElementById("files_list_box").innerHTML = files_list_box_html;
        })
    </script>
    <script>
        function file_operating(file_name) {
            //弹窗
            layui.use('layer', function () {
                    layer.confirm('请选择操作？', {
                        btn: ['下载', '删除']
                        , btn1: function (index) {
                            //  文件操作
                            //按钮【按钮一】的回调
                            $.post("../API/git_file_url.php", {
                                "file_name": file_name,
                                "Token":getCookie("Token"),
                                "id":getCookie("id")
                            }, function (data) {
                                window.open(data);
                                layer.close(index);
                            })
                        }, btn2: function (index) {
                            $.post("../API/del_file.php", {
                                "file_name": file_name,
                                "Token":getCookie("Token"),
                                "id":getCookie("ZHF")
                            }, function (data) {
                                layer.msg(data);
                                location.reload();
                            });
                            layer.close(index);
                        }
                    });
                }
            )
        }

        function up() {
            layui.use('layer', function () {
                layer.open({
                    type: 2,
                    area: ['50%', '40%'],
                    content: ['./upload/upload.html', 'no'] //不出现滚动条
                });
            });
        }
    </script>
    <!-- 人物  CSS-->
    <link rel="stylesheet" href="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/css/live2d.css"/>
</head>
<body>
<header>
    <div id="headName"><em>Z-Cloud</em></div>
    <div id="upload" onclick="up()">上传</div>
    <div id="xhx"></div>
    <div id="File_synchronization_time">文件同步时间：<span><?php echo(date("Y-m-d H:i:s")) ?></span><span
                id="IpAddress"></span></div>
    <div id="Time"></div>
</header>
<!--第一列-->
<div id="main_box">
    <table class="layui-table" id="file_list">
        <colgroup>
            <col width="65%">
            <col width="20%">
            <col>
        </colgroup>
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
<!-- 人物 -->
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
</body>

</html>