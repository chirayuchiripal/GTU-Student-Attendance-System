var columnSelector_columns={};
$(function() {
	$.extend($.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables
		table      : 'table table-bordered',
		caption    : 'caption',
		header     : 'bootstrap-header white-gloss full-height', // give the header a gradient background
		footerRow  : '',
		footerCells: 'white-gloss',
		icons      : 'icon-white', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
		sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});
	$("#SelectAllColumns").change(function(){
		var cols=$("#columnSelector tbody input[type='checkbox']");
		if(this.checked)
		{	cols.prop('checked',true).trigger('change');
		}
		else
		{	cols.prop('checked',false).trigger('change');
			$(".ts-pager").css("display","table-cell");
		}
		
	});
	$(".pagesize").change(function() {
        var numbers = $(this).val();
        $(this).val(numbers.replace(/\D/, ''));
    });
});
function initViewTable(selector)
{	var sel = "#view_table table.tablesorter";
	if (typeof selector !== 'undefined')
		sel = selector;
	// call the tablesorter plugin and apply the uitheme widget
	//alert("hi");
	$(sel).tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",
		
		widthFixed: true,

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		// widget code contained in the jquery.tablesorter.widgets.js file
		// use the zebra stripe widget if you plan on hiding any rows (filter widget)
		widgets : [ "uitheme", "filter", "zebra", "columnSelector", "resizable" ],

		widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset",

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"
			
			// target the column selector markup
		  columnSelector_container : $('#columnSelector tbody'),
		  // column status, true = display, false = hide
		  // disable = do not display on list
		  columnSelector_columns : columnSelector_columns,
		  // remember selected columns
		  columnSelector_saveColumns: false,

		  // container layout
		  columnSelector_layout : '<tr><td><label for="col_{name}" class="select-none">{name}</label></td><td><input type="checkbox" id="col_{name}"/></td></tr>',
		  // data attribute containing column name to use in the selector container
		  columnSelector_name  : 'data-selector-name',

		  /* Responsive Media Query settings */
		  // enable/disable mediaquery breakpoints
		  columnSelector_mediaquery: false,
		  // data attribute containing column priority
		  // duplicates how jQuery mobile uses priorities:
		  // http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/
		  columnSelector_priority : 'data-priority'

		}
	})
	.tablesorterPager({

		// target the pager markup - see the HTML block below
		container: $(sel + " .ts-pager"),

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

	});
}