$(function(){
    $("body").on("click", "#lecture_delete_confirmation .delete_yes", function() {
        var obj = { del : 1 };
        obj.lec_id = $("#attd_modal").find('.modal-title').data('lec_id');
        $.post('../../core/modules/attendance/update/',obj,function(data){
            if(data.hasOwnProperty("done"))
            {	msgBox(data.done,data.final);
            }
        },"JSON").done(function(){
            $('#lecture_delete_confirmation').modal('hide');
            $('.custom-modal').modal('hide');
            freshUpdate = true;
        });
    });
});