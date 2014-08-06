$(function(){
	$("#accntForm").submit(function(e){
		$.post("../../core/modules/account/",$(this).serialize(),function(data){
			if(data.hasOwnProperty("done"))
			{	msgBox(data.done,data.final);
			}
		},"JSON");
		e.preventDefault();
	});
});