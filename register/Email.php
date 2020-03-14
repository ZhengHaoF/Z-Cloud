<?php
    require("../config.php");
    $email = $_POST['email'];
    $username = $_POST['username'];
    $id = $_POST['id'];
    $conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
    PostEmail($email,"【云盘网页端】您的注册链接是"."<br/><a>http://192.168.1.102/register/reg_confirm.php?username=".$username."&id=".$id."</a>"."<br/>"."如果不是本人操作，请忽略此邮件");
    setcookie("reg_id",$id,time()+3600,"/");
    function PostEmail($address,$txt){
        require '../API/mailer/class.phpmailer.php';
        require '../API/mailer/class.smtp.php';
        date_default_timezone_set('PRC');
        ignore_user_abort();
        set_time_limit(0);
        $interval = 60*1;
        $mail = new PHPMailer();
        $mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->Host = 'smtp.qq.com';
        $mail->SMTPSecure = 'ssl';
        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = 465;
        $mail->Hostname = 'localhost';
        $mail->CharSet = 'UTF-8';
        $mail->FromName = '云盘网页端';
        $mail->Username ='1715005995'; //发送账号
        $mail->Password = 'whpvguldlvaqiiee'; //授权码
        $mail->From = 'myzhenghf@foxmail.com';
        $mail->isHTML(true);
        $mail->addAddress($address,'这个QQ的昵称');
        $mail->Subject = '这是来自云盘网页端的邮件';
        $mail->Body = $txt;
        $mail->addAttachment('./src/20151002.png','test.png');
        $status = $mail->send();
    }
?>