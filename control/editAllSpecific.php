<html>
<head>
    <?php
    include '../CommonPage/initializer.php';
    checkUser($_SESSION["Username"]);
    $updatedDueDate=getCurrentDate();
    ?>
    <?php
    if (isset($_POST['editDueDetails'])) {
        $dueDate = $_POST["editedDueDate"];
        $unDueDate=$_POST["unEditedDueDate"];
        $query = "Update book set DueDate='".$dueDate."' where DueDate='".$unDueDate."'";
        $editResult = "yes";
        if ($conn->query($query) === true) {
            $editResult = "yes";
            $updatedDueDate=$dueDate;
        } else {
            $editResult = "no";
        }
    }
    if($_GET){
        $specificDueDate=$_GET['specificDueDate'];
        $sql="select DueDate from book where DueDate='".$specificDueDate."'";
        $rowResult=$conn->query($sql);
        while($row=mysqli_fetch_assoc($rowResult)){
            $initialDueDate=$row['DueDate'];
        }
    }
    ?>
    <script>
        $(document).ready(function(){
            removeAllActiveClass();
        })
    </script>

</head>
<body>
<?php
include '../CommonPage/header.php';
include '../CommonPage/nav.php';
?>
<div class="row" style="max-width: 500px;margin:0 auto;border:1px solid black;margin-top: 40px;">
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
            <i class="time icon"></i>
            <label>Due Date</label><br>
            <input  type="date" id="form-control" value="<?php echo $specificDueDate;?>" placeholder="Due Date" required
                    autofocus name="editedDueDate">
            <br>
            <input type="hidden" value="<?php echo $specificDueDate; ?>" name="unEditedDueDate"/>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="editDueDetails">Update <span
                    class="glyphicon glyphicon-saved" aria-hidden="true"></span></button>
        </fieldset>
    </form>
    <div class="container-fluid">
        <?php
        include '../CommonPage/addPopUp.php'
        ?>
    </div>
</body>
</html>
