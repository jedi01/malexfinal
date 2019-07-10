<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
$status_list = array (
    array("label" => lang("paid"), "value" => "paid"),
    array("label" => lang("unpaid"), "value" => "unpaid"),
    array("label" => lang("partial"), "value" => "partial"),
    array("label" => lang("overdue"), "value" => "overdue"),
);
?>
<style type="text/css">
.popover-content{padding: 0px;}
</style>
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
	<div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/expenses/create/'.$supplier_id);?>" sis-modal="expenses_table" class="btn btn-primary-outline sis_modal tip" title="<?php echo lang("expenses_create"); ?>"> <i class="fa fa-plus"></i></a>
        <?php endif ?>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group tip" title="<?php echo lang("filter"); ?>">
            <?php $class = (isset($_GET['f']) && $_GET['f'] == "payment_method")?"btn-primary":"btn-primary-outline"; ?>
            <a class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $class = isset($_GET['fv'])?"":"active"; ?>
                <a href="<?php echo site_url('/expenses');?>" class="dropdown-item <?php echo $class ?>"><?php echo lang("all") ?></a>
                <?php foreach ($this->settings_model->getPaymentsMethods() as $method => $label): ?>
                    <?php $class = (isset($_GET['fv']) && $_GET['fv'] == $method)?"active":""; ?>
                    <a href="<?php echo site_url('/expenses?f=payment_method&fv='.$method);?>" class="dropdown-item <?php echo $class ?>"><?php echo $label ?></a>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="expenses_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
		<div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
			<a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
		</div>
        <div class="btn-group actions-list tip" title="<?php echo lang("actions"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
                <li><a href="#" class="dropdown-item disabled btn-select-multi delete_selected"><i class="fa fa-trash"></i><?php echo lang("delete") ?></a></li>
                <?php endif ?>
            </ul>
        </div>
	</div>
</ol>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
				<table id="expenses_table" class="table table-sm table-striped table-hover table-condensed serverSide checkable_datatable">
					<thead>
						<tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th><?php echo lang("n°"); ?></th>
                            <th><?php echo lang("reference"); ?></th>
                            <th><?php echo lang("supplier"); ?></th>
                            <th><?php echo lang("category"); ?></th>
                            <th><?php echo lang("date"); ?></th>
                            <th><?php echo lang("date_due"); ?></th>
                            <th><?php echo lang("payment_date"); ?></th>
                            <th style="text-align: center;"><?php echo lang("status"); ?></th>
                            <th style="text-align: right;"><?php echo lang("subtotal"); ?></th>
                            <th style="text-align: right;"><?php echo lang("tax"); ?></th>
                            <th style="text-align: right;"><?php echo lang("total"); ?></th>
                            <th style="text-align: end;"><?php echo lang("total_due"); ?></th>
                            <th width="20" style="width:20px; text-align: end;"><?php echo lang("actions"); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="20" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript">
var expenses_table;
$(document).ready(function() {
    var filter, value, supplier_id;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    if( $supplier_id){
        echo "supplier_id = '".$supplier_id."';";
    }
    ?>
    var expenses_table = $('#expenses_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,1,5,8,11,13],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [2,6,9,10] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/expenses/getData',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            if( filter != undefined && value != undefined ){
                aoData.push( { "name": "f", "value": filter } );
                aoData.push( { "name": "v", "value": value } );
            }
            if( supplier_id != undefined ){
                aoData.push( { "name": "supplier_id", "value": supplier_id } );
            }
            $.ajax
            ({
                'dataType': 'json',
                'type'    : 'POST',
                'url'     : sSource,
                'data'    : aoData,
                'success' : fnCallback
            });
        },
        'fnDrawCallback': function(){
            $.each($(this).find('a.supplier_popover'), function(i, supplier_popover){
                $(supplier_popover).popover({
                    placement: 'bottom',
                    template: '<div class="popover"><div class="arrow"></div><div class="popover-content"></div></div>',
                    content:'<ul>'+
                    '<li class="dropdown-item"><a href="'+SITE_URL+'/suppliers/view?id='+$(supplier_popover).data("supplier_id")+'" class="text-inherit sis_modal" sis-modal="expenses_table"><i class="fa fa-expand"></i>'+globalLang["details"]+'</a></li>'+
                    '<li class="dropdown-item">'+filter_format('<i class="fa fa-filter"></i>'+globalLang["filter"], "fullname", $(supplier_popover).data("value"), $(supplier_popover).data("value"))+'</li>'+
                    '</ul>',
                    html:true,
                });
            });
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'checkbox',       "mDataProp": 'checkbox',       "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'number',         "mDataProp": 'number',         "mRender": number_format},
            { "sName": 'reference',      "mDataProp": 'reference',      "mRender": reference_format},
            { "sName": 'fullname',       "mDataProp": 'fullname',       "mRender": supplier_format},
            { "sName": 'category',       "mDataProp": 'category',       "mRender": category_format},
            { "sName": 'date',           "mDataProp": 'date',           "mRender": date_format},
            { "sName": 'date_due',       "mDataProp": 'date_due',       "mRender": date_due_format},
            { "sName": 'payment_date',   "mDataProp": 'payment_date',   "mRender": payment_date_format},
            { "sName": 'status',         "mDataProp": 'status',         "mRender": status_format},
            { "sName": 'amount',         "mDataProp": 'amount',         "mRender": prices_format},
            { "sName": 'tax_total',      "mDataProp": 'tax_total',      "mRender": prices_format},
            { "sName": 'total',          "mDataProp": 'total',          "mRender": prices_format},
            { "sName": 'total_due',      "mDataProp": 'total_due',      "mRender": prices_format},
	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    }).advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "date-range"},
            { type: "date-range"},
            { type: "date-range"},
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            { type: "number" },
            { type: "number" },
            { type: "number" },
            { type: "number" },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    expenses_table.on("click", "a[href='#filter']", function(e){
        expenses_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            expenses_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = expenses_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            expenses_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(expenses_table);
        }

        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        expenses_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        expenses_table._fnReDraw();
        return false;
    });

    expenses_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["expense"+(select_count==1?"":"s")]+".";
            totals = [];
            var oSettings = expenses_table.fnSettings();
            for (var i = 0; i < oSettings.aoData.length; i++) {
                if( $(oSettings.aoData[i].nTr).is(".row_selected") ){
                    row = oSettings.aoData[i]._aData;
                    if( totals[row.currency] != undefined ){
                        totals[row.currency] += parseFloat(row.total);
                    }else{
                        totals[row.currency] = parseFloat(row.total);
                    }
                }
            }
            tots = [];
            for (var currency in totals) {
                tots.push("<b dir='ltr'>("+Format_Currency(totals[currency], true, {"currency":currency})+")</b>");
            }
            html += globalLang["total"]+" <b>"+tots.join(", ")+"</b>";
            table.closest(".dataTables_wrapper").find('.select_area').html(html).show();
        }else{
            table.closest(".dataTables_wrapper").find('.select_area').hide();
        }
    });

    $(document).on('click', '.delete_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = {};
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows["id["+i+"]"] = $(checkbox).data("id");
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#expenses_table').load_ajax(SITE_URL+"/expenses/delete", 'POST', selected_rows);
            });
        }
        return false;
    });

});

function actions_format(data, type, row, meta){
    actions = '<div class="btn-group">'+
                '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                    '<span><i class="icon-settings"></i></span>'+
                '</button>'+
                '<ul class="dropdown-menu dropdown-menu-right">';
    actions += $('#expenses_table').create_datatable_action("trash", SITE_URL+"/expenses/delete?id="+row.id, globalLang['delete'], false, true, false, true);
    actions += $('#expenses_table').create_datatable_action("pencil", SITE_URL+"/expenses/edit/"+row.id, globalLang['edit'], false, false, true);
    actions += $('#expenses_table').create_datatable_action("eye", SITE_URL+"/expenses/view/"+row.id, globalLang['details'], false, false, true);
    if( row.attachments.trim() != "" ){
        actions += '<li class="dropdown-divider" ></li>';
        actions += '<li><a href="'+SITE_URL+"/expenses/download_attachment/"+row.id+'" target="_BLANK" class="dropdown-item"><i class="fa fa-paperclip"></i> '+globalLang['download_attachments']+'</a></li>';
    }
    actions += '<li class="dropdown-divider" ></li>';
    if( row.total_due != 0 ){
        actions += $('#expenses_table').create_datatable_action("money", SITE_URL+"/expenses/add_payment/"+row.id, globalLang['payments_create'], false, false, true);
    }
    actions += $('#expenses_table').create_datatable_action("calendar-check-o", SITE_URL+"/expenses/payments/"+row.id, globalLang['payments'], false);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function number_format(data, type, row, meta) {
    var value = "<?php echo EXPENSE_PREFIX ?>"+String("00000" + data).slice(-5);
    var html = "<small>"+value+"</small>";
    return  html;
}
function reference_format(value, y ,row) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function supplier_format(value, y ,row) {
    var html = "";
    if( value != null ){
        html = "<a class='text-inherit supplier_popover' data-toggle='popover' data-supplier_id='"+row.supplier_id+"' data-value='"+value+"' ><small>"+value+"</small></a>";
    }
    return  html;
}
function category_format(value) {
    var html = "<small>"+value+"</small>";
    return  filter_format(html, "category", value, value);
}
function date_format(value) {
    var html = "<small>"+Format_Date(value)+"</small>";
    return  filter_format(html, "date", value, Format_Date(value));
}
function date_due_format(value) {
    var html = "<small>"+Format_Date(value)+"</small>";
    return  filter_format(html, "date_due", value, Format_Date(value));
}
function payment_date_format(value) {
    var html = "<small>"+Format_Date(value)+"</small>";
    return  filter_format(html, "payment_date", value, Format_Date(value));
}
function status_format(x, y ,row) {
    var status = x;
    if( x == "unpaid" ){
        status = "<span class='label label-tall label-warning'>"+globalLang[x]+"</span>";
    }
    else if( x == "paid" ){
        status = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
    }
    else if( x == "overdue" ){
        status = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
    }
    else{
        status = "<span class='label label-tall label-info'>"+globalLang[x]+"</span>";
    }
    return "<center>"+filter_format(status, "status", x, globalLang[x])+"</center>";
}

function prices_format(value, type, row, meta) {
    prices = value.split(",");
    result = [];
    for (var i = 0; i < prices.length; i++) {
        var value = prices[i].split("%");
        price = value[0];
        currency = value[1];
        row.currency = currency;
        result.push(Format_Currency(price, type, row));
    }
    return  "<small>"+result.join("")+"</small>";
}
</script>
