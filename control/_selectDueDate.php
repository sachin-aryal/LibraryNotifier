<?php
/**
 * Created by PhpStorm.
 * User: sachin
 * Date: 7/10/2015
 * Time: 2:04 PM
 */

$array = array();
$getAllDueDate=$conn->query("select *from book ORDER BY DueDate ASC");
while($allDueDate=mysqli_fetch_assoc($getAllDueDate)){
    $array[]=$allDueDate['DueDate'];
}
?>