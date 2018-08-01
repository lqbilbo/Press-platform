<?php
header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
require 'class.phpmailer.php';
require 'lib/fileutil.php';
try {
    $config = new fileutil();
    $ini_items = $config->get_ini_file("config.ini");
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
	$mail->SMTPAuth   = true;                  //开启认证
	$mail->Port       = 465;//25;
	$mail->Host       = "ssl://smtp.163.com";

	$mail->Username   = $config->get_ini_item($ini_items, 'send_from_mail');
	$mail->Password   = "Luo1988";//"T&H#163";
	//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
	$mail->AddReplyTo(
        $config->get_ini_item($ini_items, 'send_from_mail'),
        $config->get_ini_item($ini_items, 'send_from_mail')
    );//回复地址
	$mail->From       = $config->get_ini_item($ini_items, 'send_from_mail');
	$mail->FromName   = $config->get_ini_item($ini_items, 'send_from_mail');
	$to = $config->get_ini_item($ini_items, 'send_to_mail');
	$mail->AddAddress($to);
	$mail->Subject  = $_POST['mailsubject'];//"发送邮件测试标题";
    $inlineBody = $_POST['mailbody'];
    $mail->Body = "<pre>$inlineBody</pre>";
    $mail->AltBody    = "请使用HTML兼容的邮件客户端"; //当邮件不支持html时备用显示，可以省略
	$mail->WordWrap   = 80; // 设置每行字符串的长度
	//$mail->AddAttachment("f:/test.png");  //可以添加附件
	$mail->IsHTML(true); 
	$mail->Send();
	echo '邮件已发送，感谢您的投稿！';
} catch (phpmailerException $e) {
	echo "邮件发送失败：".$e->errorMessage();
}
?>