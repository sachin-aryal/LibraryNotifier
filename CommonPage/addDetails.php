<?php
/**
 * Created by PhpStorm.
 * User: sachin
 * Date: 7/10/2015
 * Time: 1:54 PM
 */

require_once '../CommonPage/initializer.php';
if (isset($_POST['saveDetails'])) {
    $rollNo=$_POST["rollNo"];
    $bookName=$_POST["bookName"];
    $issueDate=date("Y/m/d");
    $dueDate = $_POST['dueDate'];
    $query="insert into book values(null,'$bookName','$issueDate','$dueDate',$rollNo)";
    $saveResult="yes";
    if($conn->query($query)===true){
        $saveResult="yes";
    }
    else{
        $saveResult="no";
    }
    echo '<script>
            jQuery(function(){
               jQuery("#popUp").click();
            });
        </script>';
}
?>