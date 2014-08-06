$(function(){
	$(".ui-radio-2").buttonset();
	function field_status(field,error,help_text)
	{	var help=$(field).parent().next('.help-block');
		help.css({color:""}).text(help_text);
		if(error)
			$(field).closest('.form-group').removeClass('form-element').addClass('has-error');
		else
			$(field).closest('.form-group').removeClass('has-error').addClass('form-element');
	}
	$("#user_name").on("blur",function(){
		var len=$(this).val().length;
		var taken=false;
		var help_text="Username available!";
		var regex=/^\w([\.\-@]?\w){4,49}$/;
		if(!regex.test($(this).val()))
		{	taken=true;
			help_text="A-Z, 0-9, _, ., -, @ only. Length: 5 to 50 characters.";
			field_status("#user_name",taken,help_text);
			return;
		}
		var data={"CLM5":"user_name"};
		data.user_name=$(this).val();
		$.post("../core/modules/view/get/?master=User_Master",data,function(data){
			if(data[0].hasOwnProperty("req_aborted"))
			{	taken=false;
				var id = $.getUrlVar('id');
				if(data[0].status!="404")
				{	taken=true;
					help_text=data[0].error;
				}
			}
			else if(data.user_name==id)
			{	help_text="";
			}
			else
			{	taken=true;
				help_text="Username not available!";
			}
		},"JSON").always(function(){
			field_status("#user_name",taken,help_text);
		});
	});
	$("#user_password1").on("blur",function(){
		var pwd=$("#user_password").val();
		var re=$(this).val();
		if(pwd!=re)
			field_status("#user_password1",true,"Passwords do not match!");
		else
			field_status("#user_password1",false,"");
	});
});