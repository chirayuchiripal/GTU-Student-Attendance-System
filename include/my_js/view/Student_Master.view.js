$(function(){
	var cols={"stud_rollno":"Roll #","stud_enrolmentno":"Enrolment #","Student Name":["stud_name","stud_father_name","stud_surname"],"stud_sem":"Sem","inst_name":"Institute Name","prog_name":"Programme Name","dept_name":"Department Name","stud_div":"Division","stud_batchno":"Batch #"/*,"stud_mail":"E-mail ID","stud_contact":"Contact #","stud_parent_contact":"Parent's Contact #"*/,"stud_status":"Status"};
	var filters={"stud_status":"filter-select filter-exact"}
	set_header_row(cols,filters,true);
	var data={"CLM5":"stud_id,stud_rollno,stud_enrolmentno,stud_name,stud_father_name,stud_surname,stud_status,stud_sem,stud_div,stud_batchno,stud_mail,stud_contact,stud_parent_contact",
		"JT":"Offers_Master;Inst_Master;Prog_Master;Dept_Master",
		"JO":"o_id;inst_id:0;prog_id:0;dept_id:0",
		"JC":"o_id;inst_name;prog_name;dept_name"};
	var modifiers={"stud_status":{"D":"Detain","L":"Left","C":"Continue","A":"Alumni"}};
	fillViewTable("Student_Master",data,cols,["stud_id"],modifiers);
});