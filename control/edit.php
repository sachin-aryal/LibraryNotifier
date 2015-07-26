<html>
<head>

    <?php
    include '../CommonPage/initializer.php';
    checkUser($_SESSION["Username"]);
    ?>
    <?php
    if (isset($_POST['editDetails'])) {
        $rollNo = $_POST["rollNo"];
        $bookName = $_POST["bookName"];
        $issueDate = date("Y/m/d");
        $dueDate = $_POST["dueDate"];
        $bookId=$_POST["bookId"];
        $query = "Update book set BookName='".$bookName."',IssueDate='".$issueDate."',DueDate='".$dueDate."',StudentId='".$rollNo."' where Id='".$bookId."'";
        $editResult = "yes";
        if ($conn->query($query) === true) {
            $editResult = "yes";
        } else {
            $editResult = "no";
        }
    }
    ?>
    <?php
    if($_GET){
        $bookId=$_GET["bookId"];

        $sql=$conn->query("select *from book where Id='".$bookId."'");
        while($row=mysqli_fetch_assoc($sql)){
            $sId=$row["StudentId"];
            $bName=$row["BookName"];
            $iDate=$row["IssueDate"];
            $dDate=$row["DueDate"];
        }
    }

    ?>
</head>
<script>
    $(document).ready(function(){
        removeAllActiveClass();
    })
</script>
<body>
<?php
include '../CommonPage/header.php';
include '../CommonPage/nav.php';

?>
<div class="container-fluid">
    <?php
    include '../CommonPage/addPopUp.php'
    ?>
</div>
<div class="ui segment">
    <div class="row" style="max-width: 500px;margin:0 auto;border:1px solid black;margin-top: -40px;">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 20px;color:#808080;margin:0px auto; ">Update Details</h4>
            <?php
            if($editResult=="yes"){
                echo '<div class="ui positive message" id="saveSuccess">
                                    <p>The Data is successfully updated!!</p>
                                </div>';
            }else if($editResult=="no"){
                echo '<div class="ui negative message" id="saveFailed">
                                    <p>Sorry internal server error!!</p>
                                </div>';
            }
            ?>
        </div>
        <form class="form-signin" method="post"style="margin-top: 0px;">
            <fieldset>
                <i class="user icon"></i>
                <label>Roll No</label>
                <input type="text" id="RollNo" value="<?php echo $sId;?>" class="form-control" required autofocus name="rollNo">
                <i class="book icon"></i>
                <label>Book Name</label>
                <input type="text" id="BookName" value="<?php echo $bName;?>" class="form-control" required autofocus name="bookName">
                <i class="time icon"></i>
                <label>Issue Date</label>
                <input type="date" id="form-control" value="<?php echo $iDate;?>" placeholder="Issue Date" required autofocus name="issueDate">
                <i class="time icon"></i>
                <label>Due Date</label>
                <input type="date" id="form-control" value="<?php echo $dDate;?>" placeholder="Due Date" required autofocus name="dueDate">
                <br>
                <input type="hidden" value="<?php echo $bookId;?>" name="bookId"/>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="editDetails">Update     <span class="glyphicon glyphicon-saved" aria-hidden="true"></span></button>
            </fieldset>
        </form>

</div>
    </div>
</body>
</html>
