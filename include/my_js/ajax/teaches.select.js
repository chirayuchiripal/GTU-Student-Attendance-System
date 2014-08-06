if(typeof dir == 'undefined')
	var dir = '../';
$(function(){
	var json_fac={"faculty_status":1};
	var t_fac=$("#faculty_id").data('val');
	init_fac();
	check_batch();
	setInterval(init_fac,300000);
	function init_fac()
	{	$("#faculty_id").empty();
		$("#faculty_id").prop("disabled",true);
		$("#faculty_id+.ajax_loader").show();
		json_fac.ORD3l2="faculty_name";
		$.post(dir+"core/modules/view/get/?master=Faculty_Master",json_fac,function(data)
		{	if(data[0].hasOwnProperty("req_aborted"))
			{	var p=$('<option>',{
					value: "",
					html: data[0].error,
				}).appendTo("#faculty_id");
			}
			else
			{	$('<option>').appendTo("#faculty_id");
				$.each(data,function(key,val){
					var fname=val.faculty_name;	
					if(val.faculty_father_name)
						fname+=" "+val.faculty_father_name;
					if(val.faculty_surname)
						fname+=" "+val.faculty_surname;
					var p=$('<option>',{
						value: val.faculty_id,
						html: fname+" ["+val.faculty_designation+"]",
						}).appendTo("#faculty_id");
					if(p.val()==t_fac)
						p.prop('selected',true);
				});
			}
		},"JSON").done(function(){
			$("#faculty_id+.ajax_loader").hide();
			$("#faculty_id").prop("disabled",false);
		});
	}
	$("#faculty_id").change(function(){
		t_fac=$(this).val();
	});
	$("#type").change(function(){
		check_batch();
	});
	function check_batch()
	{	var lec=$("#type input:checked").val();
		if(lec==1)
			$("#batchno").prop("disabled",false);
		else
			$("#batchno").prop("disabled",true);
	}
});