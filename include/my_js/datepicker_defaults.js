$(function() {
	var url_base="../";
	if(typeof calendar_base_url == 'string')
		url_base=calendar_base_url;
	$.datepicker.setDefaults({
		defaultDate: null,
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		altFormat: "d MM yy",
		dateFormat: "dd-mm-yy",
		constrainInput: true,
		showOn: "both",
		buttonImage: url_base+"include/ui-lightness/images/calendar.gif",
		buttonImageOnly: true,
	});
});