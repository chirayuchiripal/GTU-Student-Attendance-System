if(typeof dir == 'undefined')
	var dir = '../';
$(function(){
	var json_sub={"sub_status":1};
	var t_sub=$("#sub_id").data('val');
	ResetFlag=false;
	sem_sel="#sub_offered_sem";
	$(".ui-radio-2").buttonset();
	init_sub();
	setInterval(init_sub,300000);
	function init_sub()
	{	$("#sub_id").empty();
		$("#sub_id").prop("disabled",true);
		$("#sub_id+.ajax_loader").show();
		json_sub.ORD3l2="sub_code";
		$.post(dir+"core/modules/view/get/?master=Sub_Master",json_sub,function(data)
		{	if(data[0].hasOwnProperty("req_aborted"))
			{	var p=$('<option>',{
					value: "",
					html: data[0].error,
				}).appendTo("#sub_id");
			}
			else
			{	$.each(data,function(key,val){
					var p=$('<option>',{
						value: val.sub_id,
						html: "["+val.sub_code+"] "+val.sub_name,
						}).appendTo("#sub_id");
					if(p.val()==t_sub)
						p.prop('selected',true);
				});
			}
		},"JSON").done(function(){
			$("#sub_id+.ajax_loader").hide();
			$("#sub_id").prop("disabled",false);
		});
	}
	$("#sub_id").change(function(){
		t_sub=$(this).val();
	});
});