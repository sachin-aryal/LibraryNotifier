
<div class="ui five item menu">
    <a class="active item" href="../control/admin.php" id="home">
        Home
    </a>
    <a class="item" data-toggle="modal" data-target="#modal1" id="popUp" id="addPopUp">
        <i class="add circle icon"></i>Add Details
    </a>
    <a class="item" href="../control/nData.php" id="newData">New Data</a>
    <a class="item" href="../control/oData.php" id="oldData">Old Data</a>
    <a class="item" href="#">
        Logout
    </a>

</div>
<?php
checkUser($_SESSION["Username"])
?>