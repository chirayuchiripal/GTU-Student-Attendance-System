var freshUpdate = false;
$(function(){
	$("body").on("click","#save_btn",function(){
		var updates=new Array();
		var obj={};
		obj.c=new Array();
		$("#modal_view_table tbody tr").each(function(){
			var id='stud_id';
			var mid='lec_id';
			if(typeof $(this).data('stud_id') == "undefined")
			{	id='lec_id';
				mid='stud_id';
			}
			obj[mid]=$('.custom-modal .modal-title').data(mid);
			var attd=$(this).find(".attd_status");
			var tmp={};
			if(attd.text()!=attd.data('old'))
			{	tmp.p=attd.text();
				tmp[id]=$(this).data(id);
				obj.c.push(tmp);
				//alert(tmp[id]+":"+tmp.p);
			}
		});
		if(obj.c != "")
		{	$.post('../../core/modules/attendance/update/',obj,function(data){
				if(data.hasOwnProperty("done"))
				{	msgBox(data.done,data.final);
				}
			},"JSON").done(function(){
				$('.custom-modal').modal('hide');
				freshUpdate = true;
			});
		}
		else
			alert("No changes made by you!");
	});

    // Handler for deleting a lecture. Shows confirmation dialog for deletion
    $("body").on("click", "#delete_btn", function() {
        var $confirmBox = alertModal.clone();
        var id = "lecture_delete_confirmation";
        $confirmBox.attr('id', id);
        $("body").append($confirmBox);
        $('#lecture_delete_confirmation .modal-title').text('Confirm deletion?');
        $('#lecture_delete_confirmation .modal-body').text('Are you sure you want to delete the lecture attendance?');
        $('#lecture_delete_confirmation').modal('show');
        $('#lecture_delete_confirmation').on('hidden.bs.modal', function(){
			$('#lecture_delete_confirmation').remove();
		});
    });

    // Stackable modal backdrop fix
    $(document).on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
    }).on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
    });

    // Fixes z-index and backdrop of the open stacked modals
    function setModalsAndBackdropsOrder() {
        var modalZIndex = 1040;
        $('.modal.in').each(function(index) {
            $('body').addClass('modal-open');
            var $modal = $(this);
            modalZIndex++;
            $modal.css('zIndex', modalZIndex);
            $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
        });
        $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }
});