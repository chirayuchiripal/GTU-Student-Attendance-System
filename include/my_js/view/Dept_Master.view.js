$(function(){
	var cols={"dept_name":"Name","dept_code":"Code"};
	set_header_row(cols,null,true);
	var data={"CLM5":"dept_id,dept_name,dept_code"};
	fillViewTable("Dept_Master",data,cols,["dept_id"]);
});