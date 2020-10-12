<?php
require "./API/GetIP.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <!--//手机端自适应-->
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <!--//手机端自适应-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <script src="js/mDialogMin.js"></script><!--弹窗JS-->
    <link href="css/dialog.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="other/normalize.css">
    <link rel="stylesheet" href="css/index.css">
    <script>
        function zc() {
            Dialog.init('<input type="text" placeholder="账号" id = "users" style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/><input type="password" id = "pwd1" placeholder="密码"  style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/><input type="password" placeholder="确认密码" id = "pwd2"  style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/><input type="mail" placeholder="邮箱" id="email" style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/>', {
                title: '用户注册',
                button: {
                    确定: function () {
                        var users = document.getElementById("users").value;
                        var pwd1 = document.getElementById("pwd1").value;
                        var pwd2 = document.getElementById("pwd2").value;
                        var email = document.getElementById("email").value;
                        var time = getTimer();
                        if (users.length < 3) {
                            Dialog.init('用户名不能小于2位', 1000);
                        } else {
                            if (pwd1 == pwd2) {
                                $.post("register/register.php",
                                    {
                                        username: users,
                                        password: pwd1,
                                        email: email,
                                        timer: time,
                                    },
                                    function (data, status) {
                                        Dialog.init(data, 1000);
                                        //location.reload();
                                    }
                                );

                                $.post("./API/Email.php",
                                    {
                                        username: users,
                                        email: email,
                                        id: randomn(10),
                                    }
                                );
                                $.post("./API/Record_IP.php",
                                    {
                                        request: "registerNo",
                                        IP: "<?php getIp() ?>",
                                        ID: users,
                                        other: email,
                                    },
                                    function (data) {
                                        console.log(data);
                                    });
                            } else {
                                Dialog.init('两次密码不相同', 1000);
                            }
                            ;
                        }
                        Dialog.close(this);
                    },
                    关闭: function () {
                        Dialog.close(this);
                    }
                }
            });
        }
    </script>
    <script>
        function retrieve_password() {
            Dialog.init(' <input type="mail" placeholder="请输入邮箱" id="email" style="margin:8px 0;width:100%;padding:' +
                '11px 8px;font-size:15px; border:1px solid #999;"/>', {
                    title: '找回密码',
                    button: {
                        确定: function () {
                            var email = document.getElementById("email").value;
                            var time = getTimer();

                            Dialog.close(this);
                            Dialog.init('两次密码不相同', 1000);

                        }
                    },
                    关闭: function () {
                        Dialog.close(this);
                    }
                }
            )
            ;
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
    <script>
        function getTimer() {
            var mill = new Date().getTime(); //获取时间
            var second = parseInt(mill / 1000); //转化成秒取整
            return second;
        }

        //字母随机数
        function randomn(n) {
            let res = ''
            for (; res.length < n; res += Math.random().toString(36).substr(2).toUpperCase()) {
            }
            return res.substr(0, n)
        }

        //记录IP
        function Record_ip() {
            $.post("./API/Record_IP.php",
                {
                    request: "visit",
                    IP: "<?php getIp() ?>",
                },
                function (data, status) {
                    console.log(data);
                }
            );
        }
    </script>
    <script>
        window.onload = function () {
            Record_ip();
        }
    </script>
</head>
<body>
<div class="login">
    <h1>Login</h1>
    <form method="post" action="login/getfuck.php">
        <input type="text" name="u" placeholder="用户名" required="required"/>
        <input type="password" name="p" placeholder="密码" required="required"/>
        <button type="submit" class="btn btn-primary btn-block btn-large">登录</button>
        <button type="button" onClick="zc()" id="register" name="register" class="btn btn-primary btn-block btn-large"
                style="margin-top: 10px">注册
        </button>
        <!--<div style="color: white" onclick="retrieve_password()">找回密码</div>-->
    </form>
</div>
</body>
</html>