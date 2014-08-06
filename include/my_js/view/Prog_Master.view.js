$(function(){
	var cols={"prog_name":"Name","prog_short_name":"Abbreviation","no_of_sem":"Sem"};
	set_header_row(cols,{"no_of_sem":"filter-select filter-exact"},true);
	var data={"CLM5":"prog_id,prog_name,prog_short_name,no_of_sem"};
	fillViewTable("Prog_Master",data,cols,["prog_id"]);
});