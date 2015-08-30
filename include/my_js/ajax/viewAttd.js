var customModal = $('<div class="custom-modal modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title"></h4></div><div class="modal-body zero-pad"></div><div class="modal-footer no-border zero-top-margin"><input type="checkbox" id="unlock"/>&nbsp;<label for="unlock">Unlock for update</label>&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="save_btn" disabled="disabled">Save changes</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>');
var alertModal = $('<div id="confirm-modal-id" class="confirm-modal modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-danger delete_yes">Yes</button><button type="button" class="btn btn-primary" data-dismiss="modal">No</button></div></div></div></div>');
var deleteBtn = $('<button type="button" id="delete_btn" class="btn btn-danger">Delete</button>');
var customTable = $('<div class="table-responsive" id="modal_view_table"><table class="tablesorter"><thead><tr></tr></thead><tfoot><tr class="ams-perma"><th class="ts-pager form-horizontal" colspan="0"><button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button><button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button><span class="pagedisplay"></span><button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button><button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button><input type="text" class="pagesize input-mini" title="# of records/page" size="3" /><select class="pagenum input-mini" title="Select page number"></select><button type="button" class="reset btn" data-column="0" data-filter=""><i class="icon-white icon-refresh glyphicon glyphicon-refresh"></i> Reset filters</button></th></tr></tfoot><tbody></tbody></table></div>');
$(function(){
	$(".ui-radio-2").buttonset();
	var tableCopy = $("#view_table table").clone();
	var colSelectorCopy = $("#columnSelectorDiv table").clone();
    student_wise();
	$("#view_type input[type='radio']").change(function(){
		var type=$("#view_type input[type='radio']:checked").val();
		$("#view_table table").remove();
		$("#view_table").append(tableCopy.clone());
		$("#columnSelectorDiv table").remove();
		$("#columnSelectorDiv").append(colSelectorCopy.clone());
		if(type==1)
			student_wise();
		else
			lecture_wise();
	});
	$("#view_table").on("click","tbody tr",function(){
		var type = $("#view_type input[type='radio']:checked").val();
		$("body").append(customModal.clone().prop('id', 'attd_modal'));
		var modal_title = "";
		$('.custom-modal .modal-body').html(customTable.clone());
		if(type==1)
		{	modal_title = $(this).find('td:first').text() + " - " +$(this).find('td:nth-child(3)').text();
			id = 'stud_id';
			lecture_wise_attd_of_stud($(this).data('stud_id'));
		}
		else
		{	$('.custom-modal .modal-dialog').addClass('modal-lg');
            $(deleteBtn).insertBefore('#save_btn');
			modal_title = (new Date($(this).find('td:first').text())).toLocaleDateString();
			id = 'lec_id';
			stud_wise_attd_of_lec($(this).data('lec_id'));
		}
		$('.custom-modal .modal-title').text(modal_title);
		$('.custom-modal .modal-title').data(id,$(this).data(id));
		$('.custom-modal').modal('show');
		$('.custom-modal').on('hidden.bs.modal', function(){
			$('.custom-modal').remove();
			if(freshUpdate)
				$("#view_type input[type='radio']:first").change();
			freshUpdate = false;
		});
		$('.custom-modal').on('shown.bs.modal', function(){
			$('#modal_view_table table.tablesorter').trigger("applyWidgets");
		});
	});
	var updateHandler = function(){
		var attd=$(this).find(".attd_status");
		var classes=['present','absent'];
		var labels=['P','A'];
		if(attd.data('old')=="N/A")
		{	classes.push('na');
			labels.push('N/A');
		}
		//alert(classes);
		for(var i=0;i<classes.length;i++)
		{	if(attd.hasClass(classes[i]))
			{	var ind=(i+1)%classes.length;
				attd.removeClass(classes[i]);
				attd.addClass(classes[ind]);
				attd.text(labels[ind]);
				break;
			}
		}
		//attd.toggleClass("stud_present stud_absent");
		//alert($(this).data('stud_id'));
	};
	$("body").on("change","#unlock",function(){
		if($(this).is(':checked'))
		{	$("#modal_view_table tbody tr").bind('click',updateHandler);
			$("#modal_view_table tbody tr").css('cursor','pointer');
			$("#save_btn").prop('disabled',false);
		}
		else
		{	$("#modal_view_table tbody tr").unbind('click',updateHandler);
			$("#modal_view_table tbody tr").css('cursor','auto');
			$("#save_btn").prop('disabled',true);
		}
	});
});
function setLectureMetaData(metadata)
{   $.each(metadata,function(k,v){
        if(v!=="")
            $("#"+k).children("td").text(" "+v);
        else
            $("#"+k).hide();
    });
}