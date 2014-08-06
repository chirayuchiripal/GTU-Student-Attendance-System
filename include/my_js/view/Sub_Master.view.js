$(function(){
	var cols={"sub_name":"Name","sub_code":"Code","sub_status":"Status"};
	set_header_row(cols,{"sub_status":"filter-select filter-exact"},true);
	var data={"CLM5":"sub_id,sub_name,sub_code,sub_status"};
	var modifiers={"sub_status":{"0":"Deactive","1":"Active"}};
	fillViewTable("Sub_Master",data,cols,["sub_id"],modifiers);
});