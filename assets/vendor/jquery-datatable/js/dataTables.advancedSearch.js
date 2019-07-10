(function ($) {
    $.fn.advancedSearch = function (options) {
        if( $(this).is(".has-advanced-search") ){
            return this;
        }
        $(this).addClass("has-advanced-search");
        var asInitVals, i, label, th;
        var sRangeFormat = "From {from} to {to}";
        //Array of the functions that will override sSearch_ parameters
        var afnSearch_ = new Array();
        var aiCustomSearch_Indexes = new Array();
        var asFields = new Array();
        var oFunctionTimeout = null;
        var fnOnFiltered = function () { };
        function _fnGetColumnValues(oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty) {
            // check that we have a column id
            if (typeof iColumn == "undefined") return new Array();
            // by default we only wany unique data
            if (typeof bUnique == "undefined") bUnique = true;
            // by default we do want to only look at filtered data
            if (typeof bFiltered == "undefined") bFiltered = true;
            // by default we do not wany to include empty values
            if (typeof bIgnoreEmpty == "undefined") bIgnoreEmpty = true;
            // list of rows which we're going to loop through
            var aiRows;
            // use only filtered rows
            if (bFiltered == true) aiRows = oSettings.aiDisplay;
            // use all rows
            else aiRows = oSettings.aiDisplayMaster; // all row numbers
            // set up data array
            var asResultData = new Array();
            for (var i = 0, c = aiRows.length; i < c; i++) {
                var iRow = aiRows[i];
                var sValue = oTable.fnGetData(iRow, iColumn);
                // ignore empty values?
                if (bIgnoreEmpty == true && sValue.length == 0) continue;
                // ignore unique values?
                else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
                // else push the value onto the result data array
                else asResultData.push(sValue);
            }
            return asResultData.sort();
        }

        function _fnColumnIndex(iColumnIndex) {
            if (properties.bUseColVis){
                return iColumnIndex;
            }else{
                return iColumnIndex;
            }
        }

        function fnCreateInput(oTable, regex, smart, bIsNumber, iFilterLength, iMaxLenght, sName, sClass) {
            label = label.replace(/(^\s*)|(\s*$)/g, "");
            var currentFilter = oTable.fnSettings().aoPreSearchCols[i].sSearch;
            var inputvalue = label;
            if (currentFilter != '' && currentFilter != '^') {
                if (bIsNumber && currentFilter.charAt(0) == '^')
                    inputvalue = currentFilter.substr(1); //ignore trailing ^
                else
                    inputvalue = currentFilter;
                search_init = '';
            }
            var input = $('<input type="text" id="advanced_search_field_'+i+'" class="' + sClass + '" value="" />');
            if (iMaxLenght != undefined && iMaxLenght != -1) {
                input.attr('maxlength', iMaxLenght);
            }
            // Stores the column name
            if(sName != undefined && sName != ""){
            	input.attr('data-column-name', sName);
            }
            th.html(input);
            asInitVals[i] = label;
            var index = i;
            if(properties.sFilteringTrigger == "immediate") {
	            if (bIsNumber && !oTable.fnSettings().oFeatures.bServerSide) {
	                input.keyup(function () {
	                    /* Filter on the column all numbers that starts with the entered value */
	                    oTable.fnFilter('^' + this.value, _fnColumnIndex(index), true, false); //Issue 37
	                    fnOnFiltered();
	                });
	            } else {
	                input.keyup(function () {
	                    if (oTable.fnSettings().oFeatures.bServerSide && iFilterLength != 0) {
	                        //If filter length is set in the server-side processing mode
	                        //Check has the user entered at least iFilterLength new characters
	                        var currentFilter = oTable.fnSettings().aoPreSearchCols[index].sSearch;
	                        var iLastFilterLength = $(this).data("dt-iLastFilterLength");
	                        if (typeof iLastFilterLength == "undefined")
	                            iLastFilterLength = 0;
	                        var iCurrentFilterLength = this.value.length;
	                        if (Math.abs(iCurrentFilterLength - iLastFilterLength) < iFilterLength) {
	                            //Cancel the filtering
	                            return;
	                        }else {
	                            //Remember the current filter length
	                            $(this).data("dt-iLastFilterLength", iCurrentFilterLength);
	                        }
	                    }
	                    /* Filter on the column (the index) of this element */
	                    oTable.fnFilter(this.value, _fnColumnIndex(index), regex, smart); //Issue 37
	                    fnOnFiltered();
	                });
	            }
            }
        }

        function fnCreateRangeInput(oTable, sName, sClass) {
            th.html(_fnRangeLabelPart(0));
            var sFromId = oTable.attr("id") + '_range_from_' + i;
            var from = $('<input type="text" class="' + sClass + '" id="' + sFromId + '" rel="' + i + '"/>');
            // Stores the column name
            if(sName != undefined && sName != ""){
            	from.attr('data-column-name', sName);
            }
            th.append(($('<div class="display-inline"></div>').append(from)));
            th.append(_fnRangeLabelPart(1));
            var sToId = oTable.attr("id") + '_range_to_' + i;
            var to = $('<input type="text" class="' + sClass + '" id="' + sToId + '" rel="' + i + '"/>');
            // Stores the column name
            if(sName != undefined && sName != ""){
            	to.attr('data-column-name', sName);
            }
            th.append(($('<div class="display-inline"></div>').append(to)));
            th.append(_fnRangeLabelPart(2));
            var index = i;
            aiCustomSearch_Indexes.push(i);
            oTable.dataTableExt.afnFiltering.push(
		        function (oSettings, aData, iDataIndex) {
		            if (oTable.attr("id") != oSettings.sTableId)
		                return true;
		            // Try to handle missing nodes more gracefully
		            if (document.getElementById(sFromId) == null)
		                return true;
		            var iMin = document.getElementById(sFromId).value * 1;
		            var iMax = document.getElementById(sToId).value * 1;
		            var iValue = aData[_fnColumnIndex(index)] == "-" ? 0 : aData[_fnColumnIndex(index)] * 1;
		            if (iMin == "" && iMax == "") {
		                return true;
		            }
		            else if (iMin == "" && iValue <= iMax) {
		                return true;
		            }
		            else if (iMin <= iValue && "" == iMax) {
		                return true;
		            }
		            else if (iMin <= iValue && iValue <= iMax) {
		                return true;
		            }
		            return false;
		        }
	        );

            if(properties.sFilteringTrigger == "immediate") {
	            $('#' + sFromId + ',#' + sToId, th).keyup(function () {

	                var iMin = document.getElementById(sFromId).value * 1;
	                var iMax = document.getElementById(sToId).value * 1;
	                if (iMin != 0 && iMax != 0 && iMin > iMax)
	                    return;

	                oTable.fnDraw();
	                fnOnFiltered();
	            });
            }
        }

        function fnCreateDateRangeInput(oTable, sName, sClass, sDateFormat) {
            var aoFragments = sRangeFormat.split(/[}{]/);
            th.html("");
            var dateRangeInput = $('<input type="text" class="' + sClass + '"  id="advanced_search_field_'+i+'" rel="' + i + '" />');
            if(sName != undefined && sName != ""){
                dateRangeInput.attr('data-column-name', sName);
            }
            drp_opts = Object.assign({},daterangepicker_init, {
                autoUpdateInput: false,
                autoApply: true,
                autoInit: false,
            });
            delete drp_opts.startDate; delete drp_opts.endDate;
            drp_opts.locale.cancelLabel = globalLang["clear"];
            dateRangeInput.daterangepicker(drp_opts, function(start, end) {
                if(properties.sFilteringTrigger == "immediate") {
                    oTable.fnFilter(start.format("YYYY-MM-DD")+properties.sRangeSeparator+end.format("YYYY-MM-DD"), _fnColumnIndex(index), false, false);
                }
                $(dateRangeInput).val(start.format(JS_DATE)+ " - "+ end.format(JS_DATE));
            });
            $(dateRangeInput).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                if(properties.sFilteringTrigger == "immediate") {
                    oTable.fnFilter("", _fnColumnIndex(index), false, false);
                }
            });
            $(dateRangeInput).val('');
            th.append(dateRangeInput);
            var index = i;
        }

        function fnCreateColumnSelect(oTable, aData, iColumn, nTh, sLabel, bRegex, oSelected, sName, sClass) {
            if (aData == null)
                aData = _fnGetColumnValues(oTable.fnSettings(), iColumn, true, false, true);
            var index = iColumn;
            var currentFilter = oTable.fnSettings().aoPreSearchCols[i].sSearch;
            if (currentFilter == null || currentFilter == "")//Issue 81
                currentFilter = oSelected;

            var r = '<select class="' + sClass + '" id="advanced_search_field_'+i+'"><option value=""></option>';
            var j = 0;
            var iLen = aData.length;
            for (j = 0; j < iLen; j++) {
                if (typeof (aData[j]) != 'object') {
                    var selected = '';
                    if (escape(aData[j]) == currentFilter
                        || escape(aData[j]) == escape(currentFilter)
                        )
                        selected = 'selected '
                    r += '<option ' + selected + ' value="' + escape(aData[j]) + '">' + aData[j] + '</option>';
                }
                else {
                    var selected = '';
                    if (bRegex) {
                        if (aData[j].value == currentFilter) selected = 'selected ';
                        r += '<option ' + selected + 'value="' + aData[j].value + '">' + aData[j].label + '</option>';
                    } else {
                        if (escape(aData[j].value) == currentFilter) selected = 'selected ';
                        r += '<option ' + selected + 'value="' + escape(aData[j].value) + '">' + aData[j].label + '</option>';
                    }
                }
            }
            var select = $(r + '</select>');
            // Stores the column name
            if(sName != undefined && sName != ""){
            	select.attr('data-column-name', sName);
            }
            nTh.html(select);

            if( Select2 != undefined ){
                var select2 = $(select).select2({allowClear: true});
            }

            if(properties.sFilteringTrigger == "immediate") {
                select.change(function () {
                    if( $(this).val() == "" ){
                        oTable.fnFilter("", iColumn, bRegex);
                        return;
                    }
                    if(properties.sFilteringTrigger == "immediate") {
    	                if (bRegex)
    	                    oTable.fnFilter("="+$(this).val(), iColumn, bRegex); //Issue 41
    	                else
    	                    oTable.fnFilter("="+unescape($(this).val()), iColumn); //Issue 25
    	                fnOnFiltered();
                    }
                });
            }
            if (currentFilter != null && currentFilter != "")//Issue 81
                oTable.fnFilter("="+unescape(currentFilter), iColumn);
        }

        function fnCreateSelect(oTable, aData, bRegex, oSelected, sName, sClass) {
            var oSettings = oTable.fnSettings();
            if (aData == null && oSettings.sAjaxSource != "" && !oSettings.oFeatures.bServerSide) {
                // Add a function to the draw callback, which will check for the Ajax data having
                // been loaded. Use a closure for the individual column elements that are used to
                // built the column filter, since 'i' and 'th' (etc) are locally "global".
                oSettings.aoDrawCallback.push({
                    "fn": (function (iColumn, nTh, sLabel) {
                        return function () {
                            // Only rebuild the select on the second draw - i.e. when the Ajax
                            // data has been loaded.
                            if (oSettings.iDraw == 2 && oSettings.sAjaxSource != null && oSettings.sAjaxSource != "" && !oSettings.oFeatures.bServerSide) {
                                return fnCreateColumnSelect(oTable, null, _fnColumnIndex(iColumn), nTh, sLabel, bRegex, oSelected, sName, sClass); //Issue 37
                            }
                        };
                    })(i, th, label),
                    "sName": "column_filter_" + i
                });
            }
            // Regardless of the Ajax state, build the select on first pass
            fnCreateColumnSelect(oTable, aData, _fnColumnIndex(i), th, label, bRegex, oSelected, sName, sClass); //Issue 37

        }
        function _fnRangeLabelPart(iPlace) {
            switch (iPlace) {
                case 0:
                    return sRangeFormat.substring(0, sRangeFormat.indexOf("{from}"));
                case 1:
                    return sRangeFormat.substring(sRangeFormat.indexOf("{from}") + 6, sRangeFormat.indexOf("{to}"));
                default:
                    return sRangeFormat.substring(sRangeFormat.indexOf("{to}") + 4);
            }
        }
        var oTable = this;
        var defaults = {
            sPlaceHolder: "foot",
            sRangeSeparator: "~",
            iFilteringDelay: 5,
            aoColumns: null,
            sRangeFormat: "{from} {to}",
            sDateFromToken: "from",
            sDateToToken: "to",
            sFilteringTrigger: "submit",
            sDateFormat: "YYYY-MM-DD",
        };

        advancedSearchDiv = $('<div id="advancedSearch" class="row m-a-0"></div>');

        /* Language definitions */
        var properties = $.extend(defaults, options);

        this.each(function () {
            var oSettings = oTable.fnSettings();
            if (!oSettings.oFeatures.bFilter)
                return;
            asInitVals = new Array();
            var aoFilterCells = oTable.fnSettings().aoHeader[0];
            var oHost = oSettings.nTFoot; //Before fix for ColVis
            var sFilterRow = "tr"; //Before fix for ColVis
            $(aoFilterCells).each(function (index) {//fix for ColVis
                i = index;
                var aoColumn = { type: "text",
                    bRegex: false,
                    bSmart: true,
                    iMaxLenght: -1,
                    iFilterLength: 0,
                    sClass: "form-control"
                };
                if (properties.aoColumns != null) {
                    if (properties.aoColumns.length < i || properties.aoColumns[i] == null)
                        return;
                    aoColumn = properties.aoColumns[i];
                }
                aoColumn.sClass = "form-control";
                asFields.push(index);
                label = $($(this)[0].cell).text(); //Fix for ColVis
                if(properties.sPlaceHolder != "none" && aoColumn.type == "null") {
                    $($(this)[0].cell).text("");
                }
                formGroup = $('<div class="form-group m-a-0"></div>');
                $('<label class="form-control-label">'+label+'</label>').appendTo(formGroup);
                th = $('<div class=""></div>');
                $(th).appendTo(formGroup);
                var column = $('<div class="col-md-6"></div>');
                $(formGroup).appendTo(column);
                $(column).appendTo(advancedSearchDiv);

                if (aoColumn != null) {
                    if (aoColumn.sRangeFormat != null)
                        sRangeFormat = aoColumn.sRangeFormat;
                    else
                        sRangeFormat = properties.sRangeFormat;
                    switch (aoColumn.type) {
                        case "null":
                            break;
                        case "number":
                            fnCreateInput(oTable, true, false, true, aoColumn.iFilterLength, aoColumn.iMaxLenght, aoColumn.sName, aoColumn.sClass);
                            break;
                        case "select":
                            if (aoColumn.bRegex != true)
                                aoColumn.bRegex = false;
                            fnCreateSelect(oTable, aoColumn.values, aoColumn.bRegex, aoColumn.selected, aoColumn.sName, aoColumn.sClass);
                            break;
                        case "number-range":
                            fnCreateRangeInput(oTable, aoColumn.sName, aoColumn.sClass);
                            break;
                        case "date-range":
                            fnCreateDateRangeInput(oTable, aoColumn.sName, aoColumn.sClass, properties.sDateFormat);
                            break;
                        case "text":
                        default:
                            bRegex = (aoColumn.bRegex == null ? false : aoColumn.bRegex);
                            bSmart = (aoColumn.bSmart == null ? false : aoColumn.bSmart);
                            fnCreateInput(oTable, bRegex, bSmart, false, aoColumn.iFilterLength, aoColumn.iMaxLenght, aoColumn.sName, aoColumn.sClass);
                            break;

                    }
                }
            });

            for (j = 0; j < aiCustomSearch_Indexes.length; j++) {
                var fnSearch_ = function () {
                    var id = oTable.attr("id");
                    var s_Search = $("#" + id + "_range_date_" + aiCustomSearch_Indexes[j]).val();
                    return s_Search;
                }
                afnSearch_.push(fnSearch_);
            }

            if (oSettings.oFeatures.bServerSide) {
                var fnServerDataOriginal = oSettings.fnServerData;
                oSettings.fnServerData = function (sSource, aoData, fnCallback) {
                    for (j = 0; j < aiCustomSearch_Indexes.length; j++) {
                        var index = aiCustomSearch_Indexes[j];

                        for (k = 0; k < aoData.length; k++) {
                            if (aoData[k].name == "sSearch_" + index)
                                aoData[k].value = afnSearch_[j]();
                        }
                    }
                    aoData.push({ "name": "sRangeSeparator", "value": properties.sRangeSeparator });
                    if (fnServerDataOriginal != null) {
                        if (properties.iFilteringDelay != 0) {
                            if (oFunctionTimeout != null)
                                window.clearTimeout(oFunctionTimeout);
                                oFunctionTimeout = window.setTimeout(function () {
                                    try {
                                        fnServerDataOriginal(sSource, aoData, fnCallback, oSettings);
                                    } catch (ex) {
                                        fnServerDataOriginal(sSource, aoData, fnCallback);
                                    }
                                }, properties.iFilteringDelay);
                        }
                    }
                    else {
                        if (properties.iFilteringDelay != 0) {
                            if (oFunctionTimeout != null)
                                window.clearTimeout(oFunctionTimeout);
                                oFunctionTimeout = window.setTimeout(function () {
                                    $.getJSON(sSource, aoData, function (json) {
                                        fnCallback(json)
                                    });
                                }, properties.iFilteringDelay);
                        }
                    }
                };
            }
        });

        advancedSearchSubmit = function(){
            for (var i = asFields.length - 1; i >= 0; i--) {
                var index = asFields[i];
                var aoColumn = properties.aoColumns[index];
                var input = $("#advanced_search_field_"+index);
                bRegex = (aoColumn.bRegex == null ? false : aoColumn.bRegex);
                bSmart = (aoColumn.bSmart == null ? false : aoColumn.bSmart);

                if( input.val() != "" ){
                    switch (aoColumn.type) {
                        case "null": break;
                        case "select":
                            oTable.fnFilter("="+input.val(), _fnColumnIndex(index), false, bSmart);
                            break;
                        case "date-range":
                            start = input.data("daterangepicker").startDate.format("YYYY-MM-DD");
                            end   = input.data("daterangepicker").endDate.format("YYYY-MM-DD");
                            oTable.fnFilter(start+properties.sRangeSeparator+end, _fnColumnIndex(index), false, false);
                            break;
                        default:
                            oTable.fnFilter(input.val(), _fnColumnIndex(index), bRegex, bSmart);
                            break;
                    }
                }else{
                    oTable.fnFilter("", _fnColumnIndex(index), false, false);
                }
            }
        }

        var advancedSearchWrapper = $('<div class="advancedSearch"></div>');
        var dataTables_wrapper = $(this).closest('.dataTables_wrapper');
        if( dataTables_wrapper.size() == 0 ){
            dataTables_wrapper = $(this).prev('.dataTables_wrapper');
        }
        $(advancedSearchWrapper).appendTo(dataTables_wrapper);
        var searchInput = dataTables_wrapper.find('.dataTables_filter input');
        var wrap = $('<div class="input-group search-bar"></div>');
        $(searchInput).wrap(wrap);
        $('<span class="input-group-addon"><i class="fa fa-search"></i></span>').insertBefore(searchInput);

        var advancedSearchBtn = $('<button class="btn btn-secondary" id="advanced_search"> <i class="fa fa-gear"></i></button>');
        $(advancedSearchBtn).insertAfter(searchInput);
        $(advancedSearchBtn).wrap('<span class="input-group-btn"></span>');

        $(advancedSearchBtn).click(function(){
            var advancedSearchModal = bootbox.dialog(
                advancedSearchDiv,
                [
                    {
                        label: globalLang["cancel"],
                        class: "btn-secondary"
                    },
                    {
                        label: globalLang["clear"],
                        class: "btn-secondary",
                        callback: function(){
                            $(advancedSearchDiv).find('input, select').val('');
                            $(advancedSearchDiv).find('select').select2('data', null);
                            advancedSearchSubmit();
                        }
                    },
                    {
                        label:globalLang["ok"],
                        class: "btn-primary",
                        callback: function(){
                            advancedSearchSubmit();
                        }
                    },
                ],
                {
                    header: globalLang["advanced_search"]
                }
            );
            if(isMobile()){
                advancedSearchModal.addClass("modal-dropdown-mobile");
            }

            $(advancedSearchModal).keyup(function(ev){
                if( ev.keyCode == 27 ){
                    $(this).modal("hide");
                }
            });

            $(advancedSearchModal).on("keyup", "input, select", function(ev){
                if( ev.keyCode == 13 ){
                    advancedSearchSubmit();
                    $(advancedSearchModal).modal("hide");
                }
            });

            $(advancedSearchModal).click(function(ev) {
                if ( ev.target.className != "modal-content" && !$(ev.target).parents(".modal-content").size() ) {
                    $(this).modal("hide");
                }
            });
            $(advancedSearchModal).on("hide.bs.modal", function(){
              $(advancedSearchDiv).appendTo($(advancedSearchWrapper));
            });
            $(advancedSearchModal).on("shown.bs.modal", function(){
                $(advancedSearchDiv).find('input, select').get(0).focus();
            });
        });
        $(searchInput)
          .focus(function(){$(this).parent().addClass("focused");})
          .blur(function(){$(this).parent().removeClass("focused");});
        return this;
    };


})(jQuery);
