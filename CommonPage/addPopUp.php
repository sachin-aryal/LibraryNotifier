<div class="row">

    <div class="col-xs-6 col-md-6 big-box" id="first-child">

        <!-- Modal -->

        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog" style="max-width:500px;height: 400px;margin:0 auto">

                <div class="modal-content modal-content-one">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                        <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 20px;color:#808080">Add Details</h4>
                        <?php
                        if($saveResult=="yes"){
                            echo '<div class="ui positive message" id="saveSuccess">
                                    <p>The Data is successfully stored!!</p>
                                </div>';
                        }else if($saveResult=="no"){
                            echo '<div class="ui negative message" id="saveFailed">
                                    <p>Sorry internal server error!!</p>
                                </div>';
                        }
                        ?>
                    </div>
                    <div class="modal-body">

                        <form class="form-signin" method="post"style="margin-top: 0px;">
                            <fieldset>
                                <i class="user icon"></i>
                                <label>Roll No</label>
                                <input type="text" id="RollNo"  class="form-control" placeholder="RollNo" required autofocus name="rollNo">
                                <i class="book icon"></i>
                                <label>Book Name</label>
                                <input type="text" id="BookName"  class="form-control" placeholder="Book Name" required autofocus name="bookName">
                                <i class="time icon"></i>
                                <label>Due Date</label>
                                <input type="date" id="form-control" placeholder="Due Date" value="" required autofocus name="dueDate">
                                <br>
                                <button class="btn btn-lg btn-primary btn-block" type="submit" name="saveDetails">Save</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>