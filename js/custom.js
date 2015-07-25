/**
 * Created by sachin on 7/10/2015.
 */
function fnOpenNormalDialog(bookId) {
    $.msgBox({
        title: "Delete",
        content: "Are you sure?",
        type: "alert",
        opacity: 0.5,
        buttons: [{ value: "Yes" },{value: "No"}],
        success: function (result) {
            if (result == "Yes") {
                deleteDetail(bookId);
            }else{
                return false
            }
        }
    });
}

function deleteDetail(bookId){
    $.ajax({
        type: "GET",
        url: 'delete.php',
        data: ({bookId:bookId}),
        success: function() {
            $.msgBox({
                title: "Deleted",
                content: "Sucessfully Deleted",
                type: "alert",
                opacity: 0.5,
                buttons: [{ value: "Ok" }],
                success: function (result) {
                    if (result == "Ok") {
                        window.location.reload(true)
                    }
                }
            });
        }
    });
}
function activeClass(id){
    if(id=='home'){
        $("#newData").removeClass('active');
        $("#oldData").removeClass('active');
    }else if(id=='newData'){
        $("#home").removeClass('active');
        $("#oldData").removeClass('active');
    }else if(id='oldData'){
        $("#newData").removeClass('active');
        $("#home").removeClass('active');
    }else{
        $("#newData").removeClass('active');
        $("#oldData").removeClass('active');
    }
    $("#"+id).addClass('active');
}

