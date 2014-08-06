$(function(){
	$(".report_table tbody tr").each(function(){
		$("<td>",{class:"no-print",text:""}).appendTo($(this));
		var newCol = $("<i>",{class:"glyphicon glyphicon-remove",text:""}).appendTo($(this).find('td').last());
	});
	$(".glyphicon-remove").click(function(){
		$(this).closest("tr").remove();
	});
});