function student_wise()
{  	
    $.getJSON("../../core/modules/reports/masterwise/",function(data)
	{	if(data.hasOwnProperty("done"))
		{	msgBox(data.done,data.final);
		}
		else
		{	
			setLectureMetaData(data.metadata);
			var cols={"stud_rollno":"Roll #","stud_enrolmentno":"Enrolment #","stud_name":"Student Name","presence":"Total Presence","total":"Total Lectures","percentage":"Percentage (%)"};
			
			columnSelector_columns={0:'disable',5:'disable'};
			set_header_row(cols,null,true);
			
			$.each(data.data,function(key,val){
				var p=$("<tr>").appendTo("#view_table tbody");
				$.each(cols,function(k,v){
					var value=val[k];
					$("<td>",{html:value}).appendTo(p);
				});
				p.data("stud_id",val["stud_id"]);
			});
		}
		$("#view_table tbody tr").each(function(){
            $(this).addClass('cursor-pointer');
            $(this).attr('title','Click to view more details');
        });
	}).done(function(){
		updateViewTable();
	});
}
function lecture_wise_attd_of_stud(stud_id)
{	
	$.getJSON("../../core/modules/reports/masterwise/",{"stud_id":stud_id,"step2":true},function(data)
	{	if(data.hasOwnProperty("done"))
		{	msgBox(data.done,data.final);
		}
		else
		{	
			var cols={"lec_date":"Lecture Date","presence":"Presence"};
			columnSelector_columns={0:'disable',1:'disable'};
			var filters={"presence":"filter-select filter-exact"};
			set_header_row(cols,filters,true,"#modal_view_table");
			$.each(data,function(key,val){
				var p=$("<tr>").appendTo("#modal_view_table tbody");
				$("<td>",{html:(new Date(val['lec_date']).toLocaleDateString())}).appendTo(p);
				var css="na";
				var value="N/A";
				if(val['presence']=='0')
				{	css="absent";
					value="A";
				}
				else if(val['presence']=='1')
				{	css="present";
					value="P";
				}
				$('<td class="text-center"><span class="attd_status '+css+'" data-old="'+value+'">'+value+'</span></td>').appendTo(p);
				p.data("lec_id",val["lec_id"]);
			});
		}
	}).done(function(){
		updateViewTable("#modal_view_table");
	});
}