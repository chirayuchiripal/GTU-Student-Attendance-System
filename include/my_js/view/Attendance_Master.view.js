$(function(){
	var cols={"sub_name":"Subject","Faculty Name":["faculty_name","faculty_father_name","faculty_surname"],"inst_name":"Institute Name","prog_name":"Programme Name","dept_name":"Department Name","semester":"Semester","type":"Lecture Type","division":"Division","batchno":"Batch #","start_date":"Start Date","end_date":"End Date"};
	var filters={"type":"filter-select filter-exact","sub_name":"filter-select filter-exact"}
	columnSelector_columns={
		0:'disable'
	};
	set_header_row(cols,filters,true);
	var data={"CLM5":"attd_mst_id,batchno,division",
		"JT":"Academic_Calendar;Teaches;Syllabus;Offers_Master;Inst_Master;Prog_Master;Dept_Master;Sub_Master;Faculty_Master",
		"JO":"ac_id;teaches_id;syllabus_id:1;o_id:2;inst_id:3;prog_id:3;dept_id:3;sub_id:2;faculty_id:1",
		"JC":"start_date,end_date,semester;type;sub_id;o_id;inst_name;prog_name;dept_name;sub_name;faculty_name,faculty_father_name,faculty_surname"};
	var modifiers={"type":{"1":"Lab","0":"Lecture"}};
	fillViewTable("Attendance_Master",data,cols,["attd_mst_id"],modifiers);
	
});