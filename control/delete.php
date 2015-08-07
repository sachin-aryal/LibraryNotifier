<?php
include '../CommonPage/initializer.php';
checkUser($_SESSION["Username"]);
$deleteItem=$_GET["deleteItem"];
if($deleteItem=='ajakoDate'){
    $sql="Delete from book where DueDate='".getCurrentDate()."'";
    $conn->query($sql);
}else if(is_numeric($deleteItem)){
    $sql = "Delete from book where Id='".$deleteItem."'";
    $conn->query($sql);
}else {
    $sql = "Delete from book where DueDate='" . $deleteItem . "'";
    $conn->query($sql);
    $_SESSION['deleteMessage']=true;
    redirect_to('admin.php');
}
?>