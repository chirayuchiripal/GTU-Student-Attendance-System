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
});