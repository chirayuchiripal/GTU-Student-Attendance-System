$(function(){
	var cols={"Faculty Name":["faculty_name","faculty_father_name","faculty_surname"],"faculty_designation":"Designation","faculty_mail_id":"Email ID","inst_name":"Institute Name","prog_name":"Programme Name","dept_name":"Department Name","faculty_joining_date":"Joining Date","faculty_status":"Status"};
	var filters={"faculty_status":"filter-select filter-exact"}
	set_header_row(cols,filters,true);
	var data={"CLM5":"faculty_id,faculty_name,faculty_father_name,faculty_surname,faculty_status,faculty_designation,faculty_mail_id",
		"JT":"Offers_Master;Inst_Master;Prog_Master;Dept_Master",
		"JO":"o_id;inst_id:0;prog_id:0;dept_id:0",
		"JC":"o_id;inst_name;prog_name;dept_name"};
	var modifiers={"faculty_status":{"1":"Active","0":"Deactive"}};
	fillViewTable("Faculty_Master",data,cols,["faculty_id"],modifiers);
});