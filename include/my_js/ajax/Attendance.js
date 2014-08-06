$(function(){
	var cols={"sub_name":"Subject","faculty_name":"Faculty Name","inst_name":"Institute Name","prog_name":"Programme Name","dept_name":"Department Name","semester":"Semester","type":"Lecture Type","division":"Division","batchno":"Batch #","start_date":"Start Date","end_date":"End Date"};
	var filters={"type":"filter-select filter-exact","sub_name":"filter-select filter-exact"};
	columnSelector_columns={
		0:'disable'
	};
	set_header_row(cols,filters,true);
	var modifiers={"type":{"1":"Lab","0":"Lecture"}};
	fillViewTable("",{},cols,["attd_mst_id"],modifiers,function(){
        $("#view_table tbody tr").each(function(){
            $(this).addClass('cursor-pointer');
            $(this).attr('title','Double click to open');
            $(this).tooltip({track:true});
        });
    },"GET");
	$("#view_table").on("dblclick","tbody tr",function(){
		var id=$(this).data('attd_mst_id');
		$.addUrlVar('mst',id);
	});
});