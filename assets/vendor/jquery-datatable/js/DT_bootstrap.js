/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
	"sDom": 'R<"display-none"TC><"row"<"col-md-6"l<"select_area">><"col-md-6 text-md-right"f>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
	"sPaginationType": "bootstrap",
	"bStateSave": true,
	"iDisplayLength": 10,
	"oLanguage": {
	    "sEmptyTable"         :globalLang['sEmptyTable'],
	    "sInfo"               :globalLang['sInfo'],
	    "sInfoEmpty"          :globalLang['sInfoEmpty'],
	    "sInfoFiltered"       :globalLang['sInfoFiltered'],
	    "sLengthMenu"         :globalLang['sLengthMenu'],
	    "sLoadingRecords"     :globalLang['sLoadingRecords'],
	    "sProcessing"         :globalLang['sProcessing'],
	    "sSearch"             :"_INPUT_",
        "sSearchPlaceholder"  :globalLang['sSearch'],
	    "sZeroRecords"        :globalLang['sZeroRecords'],
	    "oPaginate":{
		    "sFirst"          :globalLang['sFirst'],
		    "sNext"           :globalLang['sNext'],
		    "sPrevious"       :globalLang['sPrevious'],
		    "sLast"           :globalLang['sLast'],
	    }
	},
	"aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, globalLang["all"]]],
    "fnInitComplete": function(oSettings, json) {
        if( $('.download-list').size() > 0 ){
            var export_ul = $('<ul class="dropdown-menu dropdown-menu-right"><ul>');
            $('<li><a class="dropdown-item" href="#" export-format="csv"><i class="fa fa-file-code-o"></i>'+globalLang['export_csv']+'</a></li>').appendTo(export_ul);
            $('<li><a class="dropdown-item" href="#" export-format="xls"><i class="fa fa-file-excel-o"></i>'+globalLang['export_xls']+'</a></li>').appendTo(export_ul);
            //$('<li><a class="dropdown-item" href="#" export-format="pdf"><i class="fa fa-file-pdf-o"></i>'+globalLang['export_pdf']+'</a></li>').appendTo(export_ul);
            $('<li><a class="dropdown-item" href="#" export-format="text"><i class="fa fa-file-text-o"></i>'+globalLang['export_text']+'</a></li>').appendTo(export_ul);
            $(export_ul).appendTo($('.download-list'));
        }
    	if( $('.ColVis').size() > 0 ){
	        $colvis = $('.ColVis ul');
	        $('.columns-list').append($colvis.addClass("dropdown-menu-right").removeAttr('style'));
	        $(".ColVis").remove();
	        $($colvis).find('li').addClass('dropdown-item');
	    }
        $(this).find('[data-toggle="popover"]').popover();
		$(this).find(".tip").tooltip();
		$(this).find('.tip-down').tooltip({ placement: "bottom" });
		$(this).find('.tip-datatable').tooltip({ placement: "top" });
        datatable_contextmenu();
        $('.dataTables_length select').select2({containerCssClass : "display-inline"});
    },
    preDrawCallback: function(){
        if( $('.checkable_datatable').size() > 0 ){
            $('.checkable_datatable').data("select-count", 0);
            $('.checkable_datatable').trigger("select-count");
        }
    }
} );


if ( $.fn.DataTable.ColVis ) {
	$.extend( true, $.fn.dataTable.ColVis.defaults, {
		active: 'click',
		buttonText: globalLang['colvis_buttonText'],
        buttonTitle: globalLang['colvis_buttonText'],
        sRestore: globalLang['colvis_sRestore'],
        sShowAll: globalLang['colvis_sShowAll']
	});
	$.fn.DataTable.ColVis.defaults.bRestore = true;
	$.fn.DataTable.ColVis.defaults.bShowAll = true;
}

$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
} );

$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          oSettings._iDisplayLength === -1 ?
		0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    oSettings._iDisplayLength === -1 ?
		0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
};

$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>' +
				'<li class="prev disabled"><a href="#">' + oLang.sFirst + '</a></li>' +
				'<li class="prev disabled"><a href="#">'+oLang.sPrevious+'</a></li>'+
				'<li class="next disabled"><a href="#">' + oLang.sNext + '</a></li>' +
				'<li class="next disabled"><a href="#">' + oLang.sLast + '</a></li>' +
				'</ul>'
				);
			var els = $('a', nPaging);
			$(els[0]).bind('click.DT', { action: "first" }, fnClickHandler);
			$(els[1]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[2]).bind('click.DT', { action: "next" }, fnClickHandler);
			$(els[3]).bind('click.DT', { action: "last" }, fnClickHandler);
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
                // Remove the middle elements
                $('li:gt(1)', an[i]).filter(':not(.next)').remove();

                // Add the new list items and their event handlers
                for ( j=iStart ; j<=iEnd ; j++ ) {
                	sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                	$('<li '+sClass+'><a href="#">'+j+'</a></li>')
                	.insertBefore( $('li.next:first', an[i])[0] )
                	.bind('click', function (e) {
                		e.preventDefault();
                		oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                		fnDraw( oSettings );
                	} );
                }

                // Add / remove disabled classes from the static elements
                if ( oPaging.iPage === 0 ) {
                	$('li.prev', an[i]).addClass('disabled');
                } else {
                	$('li.prev', an[i]).removeClass('disabled');
                }

                if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                	$('li.next', an[i]).addClass('disabled');
                } else {
                	$('li.next', an[i]).removeClass('disabled');
                }
            }
        }
    }
} );


$.fn.dataTableExt.oStdClasses["sLengthSelect"] = "form-control";
$.fn.dataTableExt.oStdClasses["sFilterInput"] = "form-control";
if ( $.fn.DataTable.TableTools ) {
	// Set the classes that TableTools uses to something suitable for Bootstrap
	$.fn.DataTable.TableTools.DEFAULTS.aButtons = [ "csv", "xls", "pdf", "copy" ];
	$.fn.DataTable.TableTools.DEFAULTS.sSwfPath = BASE_URL+"assets/vendor/jquery-datatable/extra/swf/copy_csv_xls_pdf.swf";
	$.extend( true, $.fn.DataTable.TableTools.classes, {
		"container": "tabletools dropdown-menu dropdown-menu-right",
		"buttons": {
			"normal": "dropdown-item",
			"disabled": "disabled"
		},
	} );

	// Have the collection use a bootstrap compatible dropdown
	$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
		"collection": {
			"container": "ul",
			"button": "li",
			"liner": "a"
		},
		"container": "ul",
		"button": "li",
		"liner": "a"
	} );

	$.extend( true, TableTools.BUTTONS, {
		"csv"	: {"sButtonText": globalLang['tabletool_csv'], "mColumns": "sortable"},
		"xls"	: {"sButtonText": globalLang['tabletool_xls'], "mColumns": "sortable"},
		"copy"	: {"sButtonText": globalLang['tabletool_copy'], "mColumns": "sortable"},
		"pdf"	: {"sButtonText": globalLang['tabletool_pdf'], "mColumns": "sortable"},
		"print"	: {
			"sButtonText": globalLang['tabletool_print'],
			"sInfo":       globalLang['tabletool_print_sInfo'],
			"sToolTip":    globalLang['tabletool_print_sToolTip']
		},
		"select"	    : {"sButtonText": globalLang['tabletool_select']},
		"select_single"	: {"sButtonText": globalLang['tabletool_select_single']},
		"select_all"	: {"sButtonText": globalLang['tabletool_select_all']},
		"select_none"	: {"sButtonText": globalLang['tabletool_select_none']},
		"ajax"	        : {"sButtonText": globalLang['tabletool_ajax']},
		"collection"	: {"sButtonText": globalLang['tabletool_collection']}
	});
}

