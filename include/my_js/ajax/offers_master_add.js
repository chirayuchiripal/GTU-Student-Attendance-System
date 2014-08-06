$(function(){
	prog_list();
	inst_list();
	dept_list();
	$("#link_btn").on("click",function(e)
	{	$(this).bsButton("loading");
		var inst_list=$('#inst_list input[type="checkbox"]:checked');
		var prog_list=$('#prog_list input[type="checkbox"]:checked');
		var dept_list=$('#dept_list input[type="checkbox"]:checked');
		$(inst_list).each(function(i,inst){
			var ilabel=$(inst).button("option","label");
			$(prog_list).each(function(j,prog){
				var plabel=$(prog).button("option","label");
				$(dept_list).each(function(k,dept){
					var dlabel=$(dept).button("option","label");
					var value=$(inst).val()+"_"+$(prog).val()+"_"+$(dept).val();
					var id="ipd_"+value;
					if($("#"+id).length==0)
					{	var c="d_"+id;
						$('<div class="col-lg-11 col-xs-10 zero-pad" id="'+c+'"/>').appendTo("#mapped_ipd");
						$('<input type="checkbox" id="'+id+'" value="'+value+'"/>').appendTo("#"+c);
						$('<label for="'+id+'">'+ilabel+' offers '+plabel+' in '+dlabel+'</label>').appendTo("#"+c);
						$('<span class="col-lg-1 col-xs-1 text-center glyphicon glyphicon-info-sign sel-icons blue" data-toggle="tooltip" data-placement="top" title="Not yet added to database!" id="st_'+id+'"/>').appendTo("#mapped_ipd").bsTooltip();
						$('<form id="form_'+id+'">'+
						'<input type="hidden" name="inst_id" value="'+$(inst).val()+'"/>'+
						'<input type="hidden" name="prog_id" value="'+$(prog).val()+'"/>'+
						'<input type="hidden" name="dept_id" value="'+$(dept).val()+'"/>'+
						'</form>').appendTo("#forms");
						$("#"+id).button();
					}
				});
			});
		});
		$(this).bsButton("reset");
	});
	$("#remove_ipd_btn").on("click",function(){
		$("#mapped_ipd input[type='checkbox']:checked").button("destroy").closest("div").next().addBack().remove();
	});
	$("#submit_btn").on("click",function(){
		$("#forms form").each(function(i,f){
			add_submit($.getUrlVar("master"),f);
		});
	});
	function prog_list()
	{	$.getJSON('../core/modules/view/get/?master=Prog_Master',function(data)
		{	$("#prog_list").empty();
			var n=0;
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var short="";
					if(val.prog_short_name)
						short='['+val.prog_short_name+'] ';
					var p=$('<input type="checkbox" id="pl_'+n+'" value="'+val.prog_id+'"/>').appendTo("#prog_list");
					var l=$('<label for="pl_'+n+'">'+short+val.prog_name+'</label>').appendTo("#prog_list");
					$("#pl_"+n).button();
					n++;
				});
			}
		});
	}
	function inst_list()
	{	$.getJSON('../core/modules/view/get/?master=Inst_Master',function(data)
		{	$("#inst_list").empty();
			var n=0;
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var icode="";
					if(val.inst_code)
						icode='['+val.inst_code+'] ';
					var p=$('<input type="checkbox" id="il_'+n+'" value="'+val.inst_id+'"/>').appendTo("#inst_list");
					var l=$('<label for="il_'+n+'">'+icode+val.inst_name+'</label>').appendTo("#inst_list");
					$("#il_"+n).button();
					n++;
				});
			}
		});
	}
	function dept_list()
	{	$.getJSON('../core/modules/view/get/?master=Dept_Master',function(data)
		{	$("#dept_list").empty();
			var n=0;
			if(!check_error_status(data[0]))
			{	$.each(data,function(key,val){
					var dcode="";
					if(val.dept_code)
						dcode='['+val.dept_code+'] ';
					var p=$('<input type="checkbox" id="dl_'+n+'" value="'+val.dept_id+'"/>').appendTo("#dept_list");
					var l=$('<label for="dl_'+n+'">'+dcode+val.dept_name+'</label>').appendTo("#dept_list");
					$("#dl_"+n).button();
					n++;
				});
			}
		});
	}
	function check_error_status(data)
	{	if(data.hasOwnProperty("req_aborted"))
		{	alert(data.error);
			return true;
		}
		return false;
	}
	function add_submit(name,ele)
	{	$("#submit_btn").bsButton("loading");
		$.post("../core/modules/add/post/?master="+name,$(ele).serialize(),function(data){
			if(data.hasOwnProperty("done"))
			{	var glyph_class="glyphicon-warning-sign red";
				var id=ele.id.substring(5);
				var title=replaceElements(data.final,"br",", ");
				if(data.done)
				{	//glyph_class="glyphicon-saved green";
					$("#"+id).button("destroy").closest("div").next().addBack().remove();
				}
				else
				{	$("#st_"+id).removeClass("glyphicon-info-sign glyphicon-saved glyphicon-warning-sign blue red green")
					.addClass(glyph_class).attr('data-original-title', title);
				}
			}
			else
				alert("Error in data!!");
		},"json").fail(function(){
			alert("Error Submitting Form!! Please try again later!!");
		});
		$("#submit_btn").bsButton("reset");
	}
});