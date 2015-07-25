<!--/**-->
<!--* Created by PhpStorm.-->
<!--* User: sachin-->
<!--* Date: 6/10/2015-->
<!--* Time: 1:47 PM-->
<!--*/-->

<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    require_once '../CommonPage/initializer.php';
    error_reporting(E_ERROR);
    ?>
    <script>
        $(function() {
            $("#selectDueDate").change(function () {
                var selectDate=$( "#selectDueDate" ).val();
                var dataString = 'search='+selectDate;
                if(selectDate=="start"){
                    window.location = "nData.php";
                }
                $("#firstResult").remove();
                $.ajax({
                    type: "POST",
                    url: 'DueData.php',
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $("#result").html(html).show();
                    }
                });
                return false;
            });
        });

    </script>

    <script type="text/javascript" language="javascript" >
        $(document).ready(function() {
            activeClass('newData');
            var dataTable =  $('#student-grid').DataTable( {
                responsive: {
                    details: {
                        renderer: function ( api, rowIdx ) {
                            var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
                                var header = $( api.column( cell.column ).header() );
                                return  '<p style="color:#00A">'+header.text()+' : '+api.cell( cell ).data()+'</p>';
                            } ).toArray().join('');

                            return data ?    $('<table/>').append( data ) :    false;
                        }
                    }
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'getBorrowedBook.php',
                    data: {
                        whichData: 'new'
                    }
                },
                destroy:true
            } );

        } );

    </script>
    <style>
        div.container {
            width:100%;
            margin: 0 auto;
        }
        #student-grid{
            width: 100%;
        }
        div.tableTop {
            margin: 0 auto;
            max-width:980px;
            margin-bottom:30px;
        }
        body {
            background: #f7f7f7;
            color: #333;
        }
        select#selectDueDate {
            display: inline-block;
            margin-top: 26px;
            margin-left: 6px;
            width: 170px;
        }
        .msgBox{
            background-color: ghostwhite;
        }
        div.msgBoxContent{
            margin-top:46px;
        }
        div#dueDorm {
            margin: 25px 0px -64px -6px;
        }
        #firstResult{
            margin-bottom:25px;
        }
    </style>
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
<?php
include '../CommonPage/addDetails.php';
include '_selectDueDate.php';
?>

<div id="dueDorm">
    <form action="" method="post">
        <select class="ui search dropdown" id="selectDueDate" name="DueDateSelector">
            <?php
            error_reporting(E_ERROR);
            $DateList=array();
            $DateList=array_unique($array);
            echo "<option value='start'>Due Date</option>";
            foreach ($DateList as $value) {
                if($value>=getCurrentDate()){
                echo '<option>'.$value.'</option> <br>';
            }
            }
            ?>
        </select>
    </form>
</div>

<?php
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
<div id="firstResult">
    <div class="tableTop"><h1 style="text-align: center">Student List</h1></div>
    <div class="container" style="border:1px solid #000000">
        <table id="student-grid"  class="display ui celled table" cellspacing="0";width="100%"style="border:"1px solid black"">
        <thead style="background-color: rgb(240, 240, 240)">
        <tr>
            <td>Student RollNo</td>
            <td>Book Name</td>
            <td>Issue Date</td>
            <td>Due Date</td>
        </tr>
        </thead>
        </table>
    </div>

</div>
<div id="result">

</div>

</body>

</html>
