<?php
include '../CommonPage/initializer.php';
$connection=is_connected();
if($connection==true){
    require_once('phpMailer/class.phpmailer.php');
require_once("phpMailer/class.smtp.php");
require 'phpMailer/PHPMailerAutoload.php';
$mailer = new PHPMailer();
$mailer->IsSMTP();
$mailer->SMTPSecure = 'tls';
$mailer->Host = 'smtp.gmail.com';
$mailer->Port = 587;
$mailer->Username = 'sachin.aryal@deerwalk.edu.np';
$mailer->Password = 'majuwasachin69';
$mailer->SMTPAuth = true;
$mailer->From = 'sachin.aryal@deerwalk.edu.np';
$mailer->FromName = 'Library';
$mailer->Subject = 'Book Due Date Tomorrow';
$totalMail=$_POST['mailNumber'];
    for($i=0;$i<$totalMail;$i++){
    $studentMail=$_POST['emailId_'.$i];
    $bookName=$_POST['bookName_'.$i];
    $mailer->Body = 'You have to return '.$bookName." Tomorrow. Please return book before 7 PM.";
    $mailer->ClearAddresses();
    $mailer->AddAddress($studentMail);
    if($mailer->Send()){
        $_SESSION["mailSent"]=true;
    }else{
        $_SESSION["mailSent"]=false;
        redirect_to('admin.php');
    }
}
redirect_to('admin.php');
}else{
    $_SESSION["mailSent"]=false;
    redirect_to('admin.php');
}
?>
