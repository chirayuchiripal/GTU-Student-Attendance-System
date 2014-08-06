$(document).ready(function(){
	prog_list();
	var json={"p_id":$("#prog_id").data('val'),"sem":$("#semester").data('val')};
	function prog_list()
	{	$("#prog_id+.ajax_loader").show();
		$("#semester").prop('disabled',true);
		$("#semester+.ajax_loader").hide();
		$.getJSON('../core/modules/view/get/?master=Prog_Master',function(data)
		{	$("#prog_id").empty();
			var sem=0;
			if(data[0].hasOwnProperty("req_aborted"))
			{	var p=$('<option>',{
					value: "",
					html: data[0].error,
					'data-sem': 0
					}).appendTo("#prog_id");
			}
			else
			{	sem=data[0].no_of_sem;
				$.each(data,function(key,val){
					var short="";
					if(val.prog_short_name)
						short='['+val.prog_short_name+'] ';
					var p=$('<option>',{
					value: val.prog_id,
					html: short+val.prog_name,
					'data-sem': val.no_of_sem
					}).appendTo("#prog_id");
					if(p.val()==json.p_id)
					{	p.prop('selected',true);
						sem=p.data("sem");
					}
				});
				populate_sem("#semester",sem,json.sem);
			}
			$("#prog_id+.ajax_loader").hide();
		})
		.fail(function(){
			$("#prog_id").empty();
			var p=$('<option>',{
				value: "",
				html: "Error Loading List",
				'data-sem': 0,
				}).appendTo("#prog_id");
		});
	}
	$("#prog_id").change(function(){
	var last=$(this).find('option:selected').data("sem");
	json.p_id=$(this).val();
	populate_sem("#semester",last,json.sem);
	});
	$("#semester").change(function(){
		json.sem=$(this).val();
	});
	setInterval(prog_list,300000);
	$( "#start_date" ).datepicker({
		onClose: function( selectedDate ) {
			$( "#end_date" ).datepicker( "option", "minDate", selectedDate);
			if($("#altfrom").hasClass("error"))
				$("#altfrom").removeClass("error").addClass("guide");
			if(selectedDate)
				$("#altfrom").html($.datepicker.formatDate("d MM yy",$(this).datepicker('getDate')));	
		}
	});
	$( "#end_date" ).datepicker({
		onClose: function( selectedDate ) {
			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
			if($("#altto").hasClass("error"))
				$("#altto").removeClass("error").addClass("guide");
			if(selectedDate)
				$("#altto").html($.datepicker.formatDate("d MM yy",$(this).datepicker('getDate')));
		}
	});
});
