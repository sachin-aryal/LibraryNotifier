<?php
function redirect_to($location){
    header('Location:'.$location);
}
function checkUser($userSession){
    if($userSession==null){
        redirect_to("index.php");
    }else{
        return true;
    }
}
function logout(){
    $_SESSION['Username']=null;
    redirect_to('index.php');
}
function is_connected()
{
    $connected = @fsockopen("www.google.com", 80);
//website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}
function sendMailAutomatically()
{
    $currentDate = date("Y/m/d");
    $dueDate = date('Y-m-d', strtotime($currentDate . ' + 1 days'));
    $conn=mysqli_connect('localhost','root','phenol69','LibraryNotifier');
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select *from book where DueDate='".$dueDate."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sId = array();
        $bName = array();
        while ($row = $result->fetch_assoc()){
            $sId[] = $row["StudentId"];
            $bName[] = $row['BookName'];
        }
        $mailNumber = count($sId);
        foreach ($sId as $value) {
            $queryStudent = "select *from student WHERE Rollno = '" . $value . "'";
            $result1 = $conn->query($queryStudent);
            while ($row1 = $result1->fetch_assoc()) {
                $emailId[] = $row1["Email"];
            }
        }
        //error_reporting(E_ERROR);
       // session_start();
        include_once '../CommonPage/linking.php';
        require_once '../CommonPage/initializer.php';
        $connection = is_connected();
        if ($connection == true) {
            require_once('../AdminController/phpMailer/class.phpmailer.php');
            require_once("../AdminController/phpMailer/class.smtp.php");
            require '../AdminController/phpMailer/PHPMailerAutoload.php';
            $mailer = new PHPMailer();
            $mailer->IsSMTP();
            $mailer->SMTPSecure = 'tls';
            $mailer->Host = 'smtp.gmail.com';
            $mailer->Port = 587;
            $mailer->Username = 'sachin.aryal@deerwalk.edu.np';
            $mailer->Password = 'phenol69';
            $mailer->SMTPAuth = true;
            $mailer->From = 'sachin.aryal@deerwalk.edu.np';
            $mailer->FromName = 'Library';
            $mailer->Subject = 'Book Due Date Tomorrow';
            for ($i = 0; $i < $mailNumber; $i++) {
                $studentMail = $emailId[$i];
                $bookName = $bName[$i];
                $mailer->Body = 'Hello You have to return ' . $bookName . " Tomorrow";
                $mailer->ClearAddresses();
                $mailer->AddAddress($studentMail);
                $mailCount=1;
                if ($mailer->Send()) {
                    $sql="UPDATE mailservice SET EmailCount = $mailCount WHERE id = 1";
                    $conn->query($sql);
                    $mailCount++;
                }
            }
        } else {
            redirect_to('Show.php');
        }
    }
    else {
    }
}
function getCurrentDate(){
    date_default_timezone_set('Asia/Kathmandu');
    $time=time();
    return date("Y-m-d",$time);
}
?>