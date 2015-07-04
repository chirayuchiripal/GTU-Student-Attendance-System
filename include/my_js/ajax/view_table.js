function set_header_row(cols,classes,footer,container)
{	var c_ele = "#view_table";
	if (typeof container !== 'undefined')
		c_ele = container;
	$(c_ele+" thead tr").empty();
	if(footer)
	{	
		$("<tr>").prependTo(c_ele+" tfoot");
	}
	$.each(cols,function(key,val){
		if(typeof val=='object')
			val=key;
		var th=$("<th>",{html:val});
		if(classes && typeof classes=='object' && typeof classes[key]!='undefined')
			th.addClass(classes[key]);
		th.appendTo(c_ele+" thead tr");
		if(footer)
			$("<th>",{html:val}).appendTo(c_ele+" tfoot tr:first-child");
	});
	$(c_ele + " .ts-pager").prop('colspan',countProperties(cols));
	initViewTable(c_ele + " table.tablesorter");
}
function countProperties(obj) {
   var count=0;
   for(var prop in obj) {
      if (obj.hasOwnProperty(prop)) {
         ++count;
      }
   }
   return count;
}
function updateViewTable(container)
{	var con = "#view_table";
	if(typeof container !== 'undefined')
		con = container;
	$(con + " table.tablesorter").trigger("update");
	$(con + " table.tablesorter").trigger("applyWidgets");
	var p=$("<i>",{class:"glyphicon glyphicon-filter"});
	$(con + " .tablesorter-filter").addClass("form-control").wrap("<div class='input-filter-wrapper'></div>").parent().append(p);
}
function fillViewTable(master,data,cols,data_attr,modifiers,callback,method)
{	$("#view_table tbody").empty();
	if(typeof method == 'undefined')
		method = "POST";
	$.ajax({
		type: method,
		url: getUrl+master,
		"data": data,
		datatype: "JSON",
		success: function(data){
			if(data[0].hasOwnProperty("req_aborted"))
			{	alert(data[0].error);
			}
			else
			{	var value="";
				$.each(data,function(key,val){
					var p=$("<tr>").appendTo("#view_table tbody");
					$.each(cols,function(k,v){
						if(typeof v=='object')
						{	
							value = "";
							$.each(v,function(i,j){
								if(val[j]!=null)
									value+=val[j]+" ";
							});
						}
						else
							value=val[k];
						if(typeof modifiers=='object' && typeof modifiers[k]!='undefined')
						{	
							value=modifiers[k][val[k]];
						}
						$("<td>",{html:value}).appendTo(p);
					});
					$.each(data_attr,function(k,v){
						p.data(v,val[v]);
					});
				});
			}
		}
	}).done(function(){
		updateViewTable();
		$("#view_table table colgroup").remove();
		var access = master.toLowerCase() + "_access";
		if(json_rights.hasOwnProperty(access) && json_rights[access].charAt(2)=='1')
		{	
			$("#view_table tbody tr").each(function(){
				$(this).addClass('cursor-pointer');
				$(this).attr('title','Double click to edit');
				$(this).tooltip({track:true});
			});
			$("#view_table").on("dblclick","tbody tr",function(){
				var id=$(this).data(data_attr[0]);
				var QS=$.addUrlVar('id',id,true);
				$.changeUrlVar('act','update',QS);
			});
		}
        typeof callback === "function" && callback();
	}).fail(function(){
		alert("Some error occured!!");
	});
}