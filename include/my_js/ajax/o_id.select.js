if(typeof dir == 'undefined')
	var dir = '../';
if(typeof ac_bit == 'undefined')
	var ac_bit=1;
$(function(){
	var json_oid={"inst_id":$('#inst_id').data('val'),"prog_id":$('#prog_id').data('val'),"dept_id":$('#dept_id').data('val')};
	init_oid();
	setInterval(inst_list,300000);
	setInterval(prog_list,300000);
	setInterval(dept_list,300000);
	$("#inst_id").change(function()
	{	json_oid.inst_id=$(this).val();
		prog_list();
	});
	$("#prog_id").change(function()
	{	json_oid.prog_id=$(this).val();
		if(!json_oid.prog_id && typeof(sem_sel)!='undefined')
		{	$(sem_sel).empty();
			$(sem_sel).prop('disabled',true);
		}
		else
		{	var last=$(this).find('option:selected').data("sem");
			if(typeof(populate_sem)==='function')
				populate_sem(sem_sel,last,t_sem);
		}
		dept_list();
	});
	$("#dept_id").change(function()
	{	json_oid.dept_id=$(this).val();
		if(json_oid.dept_id)
			get_oid();
		else
			$("#o_id").val("").trigger('change');
	});
	function inst_list()
	{	$("#inst_id").prop("disabled",true);
		$("#inst_id+.ajax_loader").show();
		$.getJSON(dir+'core/modules/view/get/?master=Inst_Master',function(data)
		{	$("#inst_id").empty();
			$('<option>').appendTo("#inst_id");
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var icode="";
					if(val.inst_code)
						icode='['+val.inst_code+'] ';
					var p=$('<option>',{
						value: val.inst_id,
						html: icode+val.inst_name,
						}).appendTo("#inst_id");
					if(p.val()==json_oid.inst_id)
						p.prop('selected',true);
				});
			}
		}).done(function()
		{	$("#inst_id+.ajax_loader").hide();
			$("#inst_id").prop("disabled",false);
			prog_list();
		});
		
	}
	function prog_list()
	{	var id=$("#inst_id").val();
		if(!id)
		{	$("#prog_id").empty();
			$("#prog_id").prop("disabled",true);
			$("#ac_id").empty();
			$("#ac_id").prop('disabled',true);
			if(typeof(sem_sel)!='undefined')
			{	$(sem_sel).empty();
				$(sem_sel).prop('disabled',true);
			}
			dept_list();
			return;
		}
		$("#prog_id+.ajax_loader").show();
		$("#prog_id").prop("disabled",true);
		$.getJSON(dir+'core/modules/view/get/?master=Prog_Master&j=jxUiQ3Gh8xC&iid='+id+'&ac='+ac_bit,function(data)
		{	$("#prog_id").empty();
			$('<option>').appendTo("#prog_id");
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var psn="";
					if(val.prog_short_name)
						psn='['+val.prog_short_name+'] ';
					var p=$('<option>',{
						value: val.prog_id,
						html: psn+val.prog_name,
						'data-sem': val.no_of_sem
						}).appendTo("#prog_id");
					if(p.val()==json_oid.prog_id)
					{	p.prop('selected',true);
						if(typeof(populate_sem)==='function')
							populate_sem(sem_sel,p.data("sem"),t_sem);
					}
				});
			}
		}).done(function()
		{	$("#prog_id+.ajax_loader").hide();
			$("#prog_id").prop("disabled",false);
		}).always(function()
		{	dept_list();
		});
	}
	function dept_list()
	{	var iid=$("#inst_id").val();
		var pid=$("#prog_id").val();
		if(!iid || !pid)
		{	$("#dept_id").empty();
			$("#dept_id").prop("disabled",true);
			$("#o_id").val("").trigger('change');
			return;
		}
		$("#dept_id+.ajax_loader").show();
		$("#dept_id").prop("disabled",true);
		$.getJSON(dir+'core/modules/view/get/?master=Dept_Master&j=yUlxT0qW3b&iid='+iid+'&pid='+pid+'&ac='+ac_bit,function(data)
		{	$("#dept_id").empty();
			$('<option>').appendTo("#dept_id");
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var dc="";
					if(val.dept_code)
						dc='['+val.dept_code+'] ';
					var p=$('<option>',{
						value: val.dept_id,
						html: dc+val.dept_name,
						}).appendTo("#dept_id");
					if(p.val()==json_oid.dept_id)
					{	p.prop('selected',true);
					}
				});
			}
		}).done(function()
		{	$("#dept_id+.ajax_loader").hide();
			$("#dept_id").prop("disabled",false);
			$("#dept_id").change();
		});
	}
	function get_oid()
	{	if(ac_bit==1)
			json_oid.active=1;
		json_oid.CLM5="o_id";
		$.post(dir+"core/modules/view/get/?master=Offers_Master",json_oid,function(data)
		{	if(!check_error_status(data[0]))
				$("#o_id").val(data[0].o_id).trigger('change');
		},"JSON");
		
	}
	function check_error_status(data)
	{	if(data.hasOwnProperty("req_aborted"))
		{	alert(data.error);
			return true;
		}
		return false;
	}
	function init_oid()
	{	$("#inst_id").prop("disabled",true);
		$("#inst_id+.ajax_loader").hide();
		$("#prog_id").prop("disabled",true);
		$("#prog_id+.ajax_loader").hide();
		$("#dept_id").prop("disabled",true);
		$("#dept_id+.ajax_loader").hide();
		inst_list();	
	}
});