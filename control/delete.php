<?php
include '../CommonPage/DbConnection.php';
$bookId=$_GET["bookId"];
$sql = "Delete from book where Id='".$bookId."'";
$conn->query($sql);
?>