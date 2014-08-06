$(function(){
	$("#submit_btn").click(function(){
		$("#submit_btn").bsButton("loading");
        var rows=$("#view_table tbody tr").filter(function(){
			return $(this).find(".attd_status").hasClass("stud_absent");
		});
		var ids="";
		var lecture={"date":$("#lec_date").val()};
		lecture.abs=new Array();
		rows.each(function(i){
			lecture.abs.push($(this).data("stud_id"));
		});
		$.post("../../core/modules/attendance/",lecture,function(data){
            if(data.hasOwnProperty("done"))
            {	msgBox(data.done,data.final);
            }
		},"JSON").always(function(){
            $("#submit_btn").bsButton("reset");
            
        }).fail(function(){
            msgBox(false,"Error submitting attendance!");
        });
	});
});