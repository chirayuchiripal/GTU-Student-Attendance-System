$(function(){
	$(".opt-select-all").on("click",function(e){
		select_change(this,true);
		e.preventDefault();
	});
	$(".opt-deselect-all").on("click",function(e){
		select_change(this,false);
		e.preventDefault();
	});
	function select_change(obj,state)
	{	var container=$(obj).closest(".sel-items").find(".checkbox-items:first");
		var items=$(container).find('input[type="checkbox"]');
		$(items).each(function(i,ele){
			var id="#"+$(ele).attr("id");
			$(ele).prop("checked",state);
			$(id).button("refresh");
		});
	}
});