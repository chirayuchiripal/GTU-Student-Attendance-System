$(function(){
	init_priv();
	var t_priv=$("#privilege_id").data('val');
	setInterval(init_priv,300000);
	function init_priv()
	{	$("#privilege_id").empty();
		$("#privilege_id").prop("disabled",true);
		$("#privilege_id+.ajax_loader").show();
		var json_priv={"CLM5":"privilege_name,privilege_id"};
		json_priv.ORD3l2="privilege_name";
		$.post("../core/modules/view/get/?master=Privilege_Master",json_priv,function(data)
		{	if(data[0].hasOwnProperty("req_aborted"))
			{	var p=$('<option>',{
					value: "",
					html: data[0].error,
				}).appendTo("#privilege_id");
			}
			else
			{	$('<option>').appendTo("#privilege_id");
				$.each(data,function(key,val){
					var p=$('<option>',{
						value: val.privilege_id,
						html: val.privilege_name,
						}).appendTo("#privilege_id");
					if(p.val()==t_priv)
						p.prop('selected',true);
				});
			}
		},"JSON").done(function(){
			$("#privilege_id+.ajax_loader").hide();
			$("#privilege_id").prop("disabled",false);
		});
	}
});