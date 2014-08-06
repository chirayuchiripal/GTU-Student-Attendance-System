function lecture_wise()
{   
    $.getJSON("../../core/modules/reports/masterwise/?lecwise=true",function(data)
	{	//$("body").append(data);
		if(data.hasOwnProperty("done"))
		{	msgBox(data.done,data.final);
		}
		else
		{	
			setLectureMetaData(data.metadata);
			var cols={"lec_date":"Lecture Date","presence":"Presence","total":"Total Students","percentage":"Percentage (%)"};
			columnSelector_columns={0:'disable',1:'disable'};
			set_header_row(cols,null,true);
			$.each(data.data,function(key,val){
				var p=$("<tr>").appendTo("#view_table tbody");
				$.each(cols,function(k,v){
					var value=val[k];
					if(k=='lec_date')
						value = (new Date(val[k])).toLocaleDateString();
					$("<td>",{html:value}).appendTo(p);
				});
				p.data("lec_id",val["lec_id"]);
			});
			$("#view_table tbody tr").each(function(){
				$(this).addClass('cursor-pointer');
				$(this).attr('title','Click to view more details');
			});
		}
	}).done(function(){
		updateViewTable();
	});
}
function stud_wise_attd_of_lec(lec_id)
{	$.getJSON("../../core/modules/reports/masterwise/",{"lec_id":lec_id,"step2":true},function(data)
	{	if(data.hasOwnProperty("done"))
		{	msgBox(data.done,data.final);
		}
		else
		{	
			var cols={"stud_rollno":"Roll #","stud_enrolmentno":"Enrolment #","stud_name":"Student Name","presence":"Presence"};
			columnSelector_columns={0:'disable',3:'disable'};
			var filters = {"presence":"filter-select filter-exact"};
			set_header_row(cols,filters,true,"#modal_view_table");
			
			$.each(data,function(key,val){
				var p=$("<tr>").appendTo("#modal_view_table tbody");
				$.each(cols,function(k,v){
					if(k=="presence")
					{
						var css="present",value="P";
						if(val['presence']=="0")
						{	css="absent";
							value="A";
						}
						$('<td class="text-center"><span class="attd_status '+css+'" data-old="'+value+'">'+value+'</span></td>').appendTo(p);
					}
					else
					{	
						var value=val[k];
						$("<td>",{html:value}).appendTo(p);
					}
				});
				p.data("stud_id",val["stud_id"]);
			});
		}
	}).done(function(){
		updateViewTable("#modal_view_table");
	});
}