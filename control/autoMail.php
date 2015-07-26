<?php
/**
 * Created by PhpStorm.
 * User: sachin
 * Date: 7/10/2015
 * Time: 1:52 PM
 */
date_default_timezone_set('Asia/Kathmandu');
$currentTime= strftime("%H:%M:%S", time());
if($currentTime>="08:00:00"&&$currentTime<"17:00:00"){
    $mailCountQuery=$conn->query("select *from mailservice where id='1'");
    $mailCount=0;
    while($row=mysqli_fetch_assoc($mailCountQuery)){
        $mailCount=$row['EmailCount'];
    }
    if($mailCount!=0){
        $sql="UPDATE mailservice SET EmailCount = 0 WHERE id = 1";
        $conn->query($sql);
    }
}
else if($currentTime>="17:00:00"&&$currentTime<"24:59:59"){
    $mailCountQuery=$conn->query("select *from mailservice where id='1'");
    $mailCount=0;
    while($row=mysqli_fetch_assoc($mailCountQuery)){
        $mailCount=$row['EmailCount'];
    }
    if($mailCount==0){
        sendMailAutomatically();
    }
}
?>