<?php
session_start();
include '../CommonPage/initializer.php';
$_SESSION['Username']=null;
redirect_to('index.php');
?>