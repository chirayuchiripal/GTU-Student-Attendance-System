if(typeof dir == 'undefined')
	var dir = '../';
var json_acad={};
var t_acad="";
function fill_acad()
{	$("#ac_id").empty();
	$("#ac_id").prop("disabled",true);
	$("#ac_id+.ajax_loader").show();
	json_acad.semester=$("#sub_offered_sem").val();
	json_acad.prog_id=$("#prog_id").val();
	$.post(dir+"core/modules/view/get/?master=Academic_Calendar",json_acad,function(data)
	{	if(data[0].hasOwnProperty("req_aborted"))
		{	var p=$('<option>',{
				value: "",
				html: data[0].error,
			}).appendTo("#ac_id");
		}
		else
		{	$.each(data,function(key,val){
				var sdt=new Date(val.start_date).toLocaleDateString();
				var edt=new Date(val.end_date).toLocaleDateString();
				var p=$('<option>',{
					value: val.ac_id,
					html: sdt+" - "+edt,
					}).appendTo("#ac_id");
				if(p.val()==t_acad)
					p.prop('selected',true);
			});
		}
	},"JSON").done(function(){
		$("#ac_id+.ajax_loader").hide();
		$("#ac_id").prop("disabled",false);
	});
}
$(function(){
	t_acad=$("#ac_id").data('val');
	init_acad();
	setInterval(init_acad,300000);
	$("#prog_id").change(function(){
		if(!$(this).val())
			init_acad();
		else
			fill_acad();
	});
	$("#sub_offered_sem").change(function(){
		fill_acad();
	});
	function init_acad()
	{	$("#ac_id").empty();
		$("#ac_id").prop("disabled",true);
		$("#ac_id+.ajax_loader").hide();
	}
	
	$("ac_id").change(function(){
		t_acad=$(this).val();
	});
});
