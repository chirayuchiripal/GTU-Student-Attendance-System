$(function(){
	var bbtn = $.fn.button.noConflict(); // Revert "button" to Jquery UI Button
	$.fn.bsButton = bbtn;	// Assign new "bsButton" for bootstrap button
	var btooltip = $.fn.tooltip.noConflict(); // Revert "tooltip" to Jquery UI Tooltip
	$.fn.bsTooltip = btooltip;	// Assign new "bsTooltip" for bootstrap tooltip
	$(".form-control").on("focus mouseover",function(){
		if($(this).closest(".form-element").length)
			$(this).parent().next('.help-block').css({color:"#06789A"});
	});
	$('.form-control').focus(function()
	{	var top = $(this).offset().top;
		var win_top=$(window).scrollTop();
		if (top - win_top < 60)
			$(window).scrollTop(Math.max(win_top-80,0));
	});
	$(".form-element .form-control").on("blur mouseout",function()
	{	$(this).not(":focus").parent().next('.help-block').css({color:""});
	});
	if($(".has-error").length)
	{	$(".has-error:first .form-control").focus();
	}
	$("#addForm").submit(function(e){
		default_add_submit($.getUrlVar("master"),$(this).serialize());
		e.preventDefault();
	});
});
function default_add_submit(name,data)
{	var act = $.getUrlVar('act');
	$("#submit_btn").bsButton("loading");
	$.post("../core/modules/"+act+"/post/?master="+name,data,function(data){
		if(data.hasOwnProperty("done"))
		{	msgBox(data.done,data.final);
			if(data.done)
			{	if(typeof(ResetFlag)=='undefined' && act!='update')
					$("#addForm")[0].reset();
			}
			$("#addForm .form-group").removeClass("has-error").addClass("form-element");
		}
		else
		{	
			for(var key in data)
			{	if(data.hasOwnProperty(key))
				{	var id="#"+key;
					if(key=="o_id")
						var container=$(".o_id_select");
					else	
						var container=$(id).closest(".form-group");
					if(!container.length)
						continue;
					container.removeClass("has-error form-element");
					if(data[key]!==true)
						container.addClass("has-error");
					else
						container.addClass("form-element");
				}
			}
			$(".has-error:first .form-control").focus();
		}
	},"json").fail(function(){
		alert("Error Submitting Form!! Please try again later!!");
	}).always(function(){
		$("#submit_btn").bsButton("reset");
	});
}
// type = true for success
function msgBox(type,message)
{   var alert_type=type?"success":"danger";
    $("#final-msg-box").append('<div class="alert alert-'+alert_type+' alert-dismissable fade in">'+
    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
    message+
    "</div>");
    $('html, body').animate({ scrollTop: $('#final-msg-box .alert').last().offset().top-80 }, 'slow');
}
var replaceElements = function(text, selector,replaceText) {
    var wrapped = $("<div>" + text + "</div>");
    wrapped.find(selector).replaceWith(replaceText);
    return wrapped.html();
}