$(function(){
	t_sem= typeof(sem_sel)!='undefined' ? $(sem_sel).data('val') : "";
	if(typeof(sem_sel)!='undefined')
	{	$(sem_sel+"+.ajax_loader").hide();
		$(sem_sel).prop('disabled',true);
		$(sem_sel).change(function(){
			t_sem=$(this).val();
		});
	}
});
function populate_sem(id,maxsem,sem)
{	$(id).prop('disabled',true);
	$(id+"+.ajax_loader").show();
	$(id).empty();
	for(var i=1;i<=maxsem;i++)
	{	var s=$('<option>',{
		value: i,
		html: i
		}).appendTo(id);
		if(s.val()==sem)
			s.prop('selected',true);
	}
	$(id+"+.ajax_loader").hide();
	$(id).prop('disabled',false);
	if(typeof fill_acad != 'undefined')
		fill_acad();
}