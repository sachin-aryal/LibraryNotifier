<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 7/24/15
 * Time: 12:30 PM
 */
require_once '../CommonPage/initializer.php';
$username=$_POST["Username"];
$password=$_POST["Password"];
$query="Select *from user where Username='$username' AND Password='$password'";
$result = $conn -> query($query);
$row = mysqli_fetch_assoc($result);
$_SESSION["Username"]=null;
if(!$row){
    redirect_to('index.php');
}
else
{
    $_SESSION["Username"] = $row["Username"];
    redirect_to('admin.php');
}
?>