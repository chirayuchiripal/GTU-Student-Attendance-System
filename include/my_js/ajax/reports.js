$(function(){
	sem_sel="#sub_offered_sem";
	$("#sub_id").prop('disabled',true);
	$(".ui-radio-3").buttonset();
	$("#sub_id+.ajax_loader").hide();
	$("#o_id").change(function(){
		update_sub();
	});
	$(sem_sel).change(function(){
		update_sub();
	});
	$("#type").change(function(){
		check_batch();
	});
	check_batch();
	function check_batch()
	{	var lec=$("#type input:checked").val();
		if(lec==1)
			$("#batchno").prop("disabled",false);
		else
			$("#batchno").prop("disabled",true);
	}
	function update_sub()
	{	if($("#o_id").val())
			fill_sub();
		else
		{	$("#sub_id").empty();
			$("#sub_id").prop('disabled',true);
			$("#sub_id+.ajax_loader").hide();
		}
	}
	function fill_sub()
	{	$("#sub_id").prop('disabled',true);
		$("#sub_id+.ajax_loader").show();
		var json_sub={sub_offered_sem:$(sem_sel).val(),o_id:$("#o_id").val(),sub_status:1,
					JT:"Syllabus",JO:"sub_id"
		};
		$.post(dir+"core/modules/view/get/?master=Sub_Master",json_sub,function(data){
			$("#sub_id").empty();
			if(data[0].hasOwnProperty("req_aborted"))
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
				});
			}
		},"JSON").done(function(){
			$("#sub_id").prop('disabled',false);
		}).always(function(){
			$("#sub_id+.ajax_loader").hide();
		});
	}
	$("#reportForm").submit(function(){
		if($("#report_format").val()=="html")
			$(this).attr('target','_blank');
		else
			$(this).attr('target','');
	});
});