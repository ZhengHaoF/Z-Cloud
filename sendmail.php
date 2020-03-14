<?php
	//邮件发送
function fuck(){
	require '../mailer/class.phpmailer.php';
	require '../mailer/class.smtp.php';
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
		$mail->From = '1715005995@QQ.COM';
		$mail->isHTML(true); 
		$mail->addAddress('1715005995@QQ.COM','这个QQ的昵称');
		$mail->Subject = '这是一个PHPMailer发送邮件的示例';
		$mail->Body = "这是一个<b style=\"color:red;\">PHPMailer</b>发送邮件的一个测试用例";
		$mail->addAttachment('./src/20151002.png','test.png');
		$status = $mail->send();
}
?>

