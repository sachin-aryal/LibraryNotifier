
<html>

<?php
//
include '../CommonPage/initializer.php';
include 'autoMail.php';
//Check For Login using checkUser function

?>
<!--<link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css">-->
<!--<script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>-->
<head>
    <meta http-equiv="refresh" content="3600">
    <?php
    include '../CommonPage/addDetails.php';
    ?>
    <script>
        $(document).ready(function () {
            activeClass('home')
        })
    </script>
    <style>
        div#allButton {
            float: right;
            margin-top: -43px;}

    </style>
</head>
<body>
<?php
if($_SESSION['deleteMessage']!=null){
if($_SESSION["deleteMessage"]==true) {
    $_SESSION["deleteMessage"]=null;
    echo '<script>
           $.msgBox({
                title: "Deleted",
                content: "Sucessfully Deleted",
                type: "alert",
                opacity: 0.5,
                buttons: [{ value: "Ok" }],
                success: function (result) {
                   return true;
                }
            });
            </script>';
}
}
$_SESSION["mailSent"]=true;
if($_SESSION["mailSent"]!=null){
    if($_SESSION["mailSent"]==true){
        /* echo '<div class="ui positive message" id="saveSuccess">
                                     <p>Mail sent!!!</p>
                                 </div>';*/
        echo '<script>$.msgBox({
                    title: "Mail",
                    content: "Mail Sent Sucessfully!!",
                    type: "alert",
                    opacity: 0.5,
                    buttons: [{ value: "Ok" }],
                    success: function (result) {
                        if (result == "Ok") {
                        }
                    }
                });</script>';
        $_SESSION["mailSent"]=null;
    }
    else{
        echo '<div class="ui negative message" id="saveSuccess">
                                    <p>Error while sending mail!!!</p>
                                </div>';
        $_SESSION["mailSent"]=null;
    }
}

?>
<?php
        include "../CommonPage/header.php";
        include_once '../CommonPage/nav.php'
        ?>
    <div class="container-fluid">
        <?php
       include '../CommonPage/addPopUp.php'
        ?>
    </div>
<div class="ui segment">
    <div class="table-responsive">
        <?php
        $currentDate=getCurrentDate();

        $dueDate = $_POST['search'];
        $start=0;
        $limit=6;
        $id=1;
        $array = array();
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
            $start=($id-1)*$limit;
        }

        $query="SELECT * FROM book WHERE DueDate = '" . $currentDate . "' ORDER BY DueDate ASC LIMIT $start, $limit ";
        $emailId = array();

        $sId = array();
        $bName=array();
        $queryResult=$conn->query($query);
        if($queryResult->num_rows>=1){
        echo '<table class="ui celled table class=table table-small-font table-bordered table-striped" id="student-grid" style="margin: 0 auto;margin-top:72px;">
                  <thead>
                    <tr><th>Student Id</th>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>';
        $queryResult=$conn->query($query);
        while($row=mysqli_fetch_assoc($queryResult))
        {
            $studentId = $row["StudentId"];
            $sId[] = $row["StudentId"];
            $bookName = $row['BookName'];
            $bName[]= $row['BookName'];
            $issueDate = $row['IssueDate'];
            $DueDate = $row['DueDate'];
            $bookId=$row["Id"];
            echo"
                <tr>
                  <td>$studentId</td>
                  <td>$bookName</td>
                  <td>$issueDate</td>
                  <td>$DueDate</td>
                <td>
                  <a class='ui primary button' href='edit.php?bookId=".$bookId."'>Edit&nbsp;&nbsp;<span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>
                  <a style='cursor: pointer;' class='ui button' onClick='javascript:fnOpenNormalDialog(".$bookId.")'>Delete&nbsp;&nbsp;<span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
                    </td>
                </tr>";
        }
        $i = 0;
        $mailNumber=count($sId);
        echo "</tbody>
 <tfoot>
 <tr>

 <th colspan='5'>
    <div class='ui right floated pagination menu'>";
        $rowResult=$conn->query("select * from book WHERE DueDate = '" . $currentDate . "'");
        $rows=$rowResult->num_rows;
        $total=ceil($rows/$limit);
        if($rows>6) {
            if ($id > 1) {
                echo "<a href='?id=" . ($id - 1) . "' class='icon item'>
                      <i class='left chevron icon'></i>
                    </a>";
            }

            for ($i = 1; $i <= $total; $i++) {
                if ($i == $id) {
                    echo "<li class='item current'>$i</li>";
                } else {
                    echo "<a  href='?id=" . $i . "' class='item'>$i</a>";
                }
            }

            if ($id != $total) {
                echo "<a href='?id=" . ($id + 1) . "' class='icon item'>
                      <i class='right chevron icon'></i>
                    </a>";
            }

        }
        echo '</div>';

        echo '<form action="sendMail.php" method="post">';
        foreach ($sId as $value) {
            $queryStudent = $conn->query("SELECT *FROM student WHERE Rollno = '" . $value . "'");
            while ($row1=mysqli_fetch_assoc($queryStudent)) {
                $emailId[] = $row1["Email"];
            }
            echo "<input type='hidden'  name='mailNumber' value='$mailNumber'/>";
            echo "<input type='hidden' name='emailId_".$i."' value='$emailId[$i]'/>";
            echo "<input type='hidden' name='bookName_".$i."' value='$bName[$i]'/>";
            $i++;
        }
        echo '<button type="submit" class="ui primary button">Send Mail&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>';
        ?>
        </form>
        <div id="allButton">
            <a class='ui primary button' href="editAll.php">Edit All&nbsp;&nbsp;<span class='glyphicon glyphicon-edit' aria-hidden='true'></a>
            <a class='ui button' onclick="javascript:fnOpenNormalDialog('ajakoDate')">Delete All&nbsp;&nbsp;<span class='glyphicon glyphicon-remove' aria-hidden='true'></a>
        </div>

        </th>
        </tr>
        </tfoot>
        </table>
    </div>
    <?php

    }else {
        echo '<div class="ui positive message" id="saveFailed" style="width: 457px;text-align: center;">
                                   <b> <p style="color: black;font-size:20px;">No any Duedate for today!!</p></b></div>';
    }
?>
</div>
</body>
</html>
