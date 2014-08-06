$(function(){
	var mst=$.getUrlVar("mst");
    hideDetails(true);
	$.getJSON("../../core/modules/attendance/getStudents/?mst="+mst,function(data)
	{	//$("#content").append(data);
		if(data.hasOwnProperty("req_aborted"))
		{	msgBox(false,data.error+' <a href=".">[Go Back]</a>');
		}
		else
		{	
            hideDetails(false);
			$.each(data.metadata,function(k,v){
				if(v!=="")
                    $("#"+k).children("td").text(" "+v);
                else
                    $("#"+k).hide();
			});
            var st_date = new Date(data.metadata.start_date);
            st_date.setHours(0,0,0,0);
            var end_date = new Date(data.metadata.end_date);
            $("#lec_date").datepicker({maxDate: $("#lec_date").val(),minDate: st_date});
            var today = $("#lec_date").datepicker("getDate");
            today.setHours(0,0,0,0);
            if(st_date > today)
            {   $("#lec_date").val('');
                $("#lec_date").prop('disabled',true);
                $("#submit_btn").prop('disabled',true);
                $("#lec_date").parent().append(" <b>Starts from "+st_date.toLocaleDateString()+"</b>");
                $("#view_table").hide();
                $("#submit_btn_div").hide();
                return;
            }
			var cols={"stud_rollno":"Roll #","stud_enrolmentno":"Enrolment #","stud_name":"Student Name","absence":"Absent/Present"};
			var filters={"absence":"filter-false sorter-false"};
			columnSelector_columns={0:'disable',3:'disable'};
			set_header_row(cols,filters,true);
			
			$.each(data.data,function(key,val){
				var p=$("<tr>").appendTo("#view_table tbody");
				$.each(cols,function(k,v){
					if(k=="absence")
					{	$("<td class='text-center'><span class='attd_status stud_present'>").appendTo(p);
					}
					else
					{	var value=val[k];
						$("<td>",{html:value}).appendTo(p);
					}
				});
				p.data("stud_id",val["stud_id"]);
			});
		}
	}).done(function(){
		updateViewTable();
		$("#view_table table colgroup").remove();
		$("input.tablesorter-filter.disabled").parent("div").remove();
		$('<div class="ap-all-btn" data-toggle="tooltip" data-placement="top" title="Affects Current Page Only"><span class="present-all"/> / <span class="absent-all"/></div>').appendTo(".tablesorter-filter-row td:last");
		$('.ap-all-btn').bsTooltip();
	});
	$("#view_table").on("click","tbody tr",function(){
		$(this).find(".attd_status").toggleClass("stud_present stud_absent");
	});
	function page_filter()
	{	return $(this).css('display') != 'none';
	}
    function hideDetails(flag)
    {   $("#submit_btn").prop('disabled',flag);
        if(flag)
        {   $("#accordion").hide();
            $("#view_table").hide();
            $("#submit_btn_div").hide();
        }
        else
        {   $("#accordion").show();
            $("#view_table").show();
            $("#submit_btn_div").show();
        }
    }
	$("#view_table").on("click",".present-all",function(){
		$("#view_table tr").filter(page_filter).find(".attd_status").removeClass("stud_absent").addClass("stud_present");
	});
	$("#view_table").on("click",".absent-all",function(){
		$("#view_table tr").filter(page_filter).find(".attd_status").removeClass("stud_present").addClass("stud_absent");
	});
});