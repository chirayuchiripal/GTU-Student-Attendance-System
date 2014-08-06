$(function(){
	var cols={"inst_name":"Name","inst_code":"Code","inst_estb_year":"Established Year"};
	set_header_row(cols,null,true);
	var data={"CLM5":"inst_id,inst_name,inst_code,inst_estb_year"};
	fillViewTable("Inst_Master",data,cols,["inst_id"]);
});