$(function(){
	var cols={"prog_name":"Programme Name","semester":"Semester","start_date":"Start Date","end_date":"End Date"};
	var filters={"semester":"filter-select filter-exact"};
	set_header_row(cols,filters,true);
	var data={"CLM5":"ac_id,semester,start_date,end_date","JT":"Prog_Master","JO":"prog_id","JC":"prog_name"};
	fillViewTable("Academic_Calendar",data,cols,["ac_id"]);
});