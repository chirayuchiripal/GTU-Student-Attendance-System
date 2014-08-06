$(function(){
	var cols={"user_name":"Username","privilege_name":"Account Type","Faculty Name":["faculty_name","faculty_father_name","faculty_surname"],"email_id":"Email Address","user_status":"Status","user_creation_date":"Creation Date","user_update_date":"Last Updated On"};
	var filters={"user_status":"filter-select filter-exact","privilege_name":"filter-select filter-exact"};
	set_header_row(cols,filters,true);
	var data={"CLM5":"user_name,email_id,user_creation_date,user_update_date,user_status","JT":"Faculty_Master;Privilege_Master","JO":"faculty_id;privilege_id","JC":"faculty_name,faculty_father_name,faculty_surname;privilege_name","J3":"left"};
	var modifiers={"user_status":{"0":"Locked","1":"Unlocked"}};
	fillViewTable("User_Master",data,cols,["user_name"],modifiers);
});