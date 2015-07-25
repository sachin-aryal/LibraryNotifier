<html>
<head>
</head>
<body>


<div id="dialog-confirm">

</div>
<div class="table-responsive">
    <?php
    if($_POST) {
        $conn=mysqli_connect('localhost','root','phenol69','LibraryNotifier');
        error_reporting(E_ERROR);
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
        $query="SELECT * FROM book WHERE DueDate = '" . $dueDate . "' ORDER BY DueDate ASC LIMIT $start, $limit ";
        $emailId = array();

        $sId = array();
        $bName=array();
        echo '<table class="ui celled table" data-toggle="table" id="student-grid" style="margin: 0 auto;margin-top:72px;">
                  <thead>
                    <tr><th>Student Id</th>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>';
        $dueResult=$conn->query($query);
        while($row=mysqli_fetch_assoc($dueResult))
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
        $numRows=$conn->query("select * from book WHERE DueDate = '" . $dueDate . "'");
        $rows=$numRows->num_rows;
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
            $queryStudent = ("SELECT *FROM student WHERE Rollno = '" . $value . "'");
            $mailResult=$conn->query($queryStudent);
            while ($row1=mysqli_fetch_assoc($mailResult)) {
                $emailId[] = $row1["Email"];
            }
            echo "<input type='hidden'  name='mailNumber' value='$mailNumber'/>";
            echo "<input type='hidden' name='emailId_".$i."' value='$emailId[$i]'/>";
            echo "<input type='hidden' name='bookName_".$i."' value='$bName[$i]'/>";
            $i++;
        }
        echo '<button type="submit" class="ui primary button">Send Mail&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>';
        echo '</form>';

    }
    ?>
    </th>
    </tr>
    </tfoot>
    </table>
</div>
<!--<div id="dialog" title="Alert message" style="display: none">-->
<!--    <div class="ui-dialog-content ui-widget-content">-->
<!--        <p>-->
<!--            <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>-->
<!--            <label id="lblMessage">-->
<!--            </label>-->
<!--        </p>-->
<!--    </div>-->
<!--</div>-->


</body>
</html>