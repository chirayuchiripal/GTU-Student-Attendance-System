$(function(){
	var cols={"inst_name":"Institute Name","prog_name":"Programme Name","dept_name":"Department Name","active":"Status"};
	var filters={"active":"filter-select filter-exact"}
	set_header_row(cols,filters,true);
	var data={"CLM5":"o_id,active","JT":"Inst_Master;Prog_Master;Dept_Master","JO":"inst_id;prog_id;dept_id","JC":"inst_name;prog_name;dept_name"};
	var modifiers={"active":{"0":"Deactive","1":"Active"}};
	fillViewTable("Offers_Master",data,cols,["o_id"],modifiers);
});