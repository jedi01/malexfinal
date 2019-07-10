<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
$method_list = array();
foreach ($this->settings_model->getPaymentsMethods() as $key => $value) {
    $method_list[] = array(
        "label" => $value,
        "value" => $key
    );
}
$status_list = array();
foreach ($this->settings_model->getPaymentStatus() as $key => $value) {
    $status_list[] = array(
        "label" => $value,
        "value" => $key
    );
}
?>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if ($purchase): ?>
        <a href="<?php echo site_url('/purchase_payments/create/'.$purchase);?>" sis-modal="payments_table" class="btn btn-primary-outline sis_modal tip" title="<?php echo lang("payments_create"); ?>"> <i class="fa fa-plus"></i></a>
        <?php endif ?>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group tip" title="<?php echo lang("filter"); ?>">
            <?php $class = (isset($_GET['f']) && $_GET['f'] == "method")?"btn-primary":"btn-primary-outline"; ?>
            <a class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $class = isset($_GET['fv'])?"":"active"; ?>
                <a href="<?php echo site_url('/purchase_payments');?>" class="dropdown-item <?php echo $class ?>"><?php echo lang("all") ?></a>
                <?php foreach ($this->settings_model->getPaymentsMethods() as $method => $label): ?>
                    <?php $class = (isset($_GET['fv']) && $_GET['fv'] == $method)?"active":""; ?>
                    <a href="<?php echo site_url('/purchase_payments?f=method&fv='.$method);?>" class="dropdown-item <?php echo $class ?>"><?php echo $label ?></a>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="payments_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
        <div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
        </div>
        <?php if (!defined("BILLER_ID")): ?>
        <div class="btn-group actions-list tip" title="<?php echo lang("actions"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" class="dropdown-item disabled btn-select-multi delete_selected"><i class="fa fa-trash"></i><?php echo lang("delete") ?></a></li>
            </ul>
        </div>
        <?php endif ?>
    </div>
</ol>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
<?php endif ?>
                <table id="payments_table" class="table table-sm table-striped table-hover table-condensed serverSide checkable_datatable">
                    <thead>
                        <tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th><?php echo lang("n°"); ?></th>
                            <th><?php echo lang("purchase"); ?></th>
                            <th><?php echo lang("customer"); ?></th>
							<th><?php echo lang("date"); ?></th>
							<th style="text-align: right;"><?php echo lang("amount"); ?></th>
                            <th style="text-align: center;"><?php echo lang("method"); ?></th>
                            <th style="text-align: center;"><?php echo lang("status"); ?></th>
                            <th><?php echo lang("details"); ?></th>
                            <th width="20" style="width:20px; text-align: end;"><?php echo lang("actions"); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
						</tr>
					</tbody>
				</table>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
            </div>
        </div>
    </div>
<?php endif ?>
<script type="text/javascript">
var payments_table;
$(document).ready(function() {
    var filter, value, purchase;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    if( $purchase){
        echo "purchase = '".$purchase."';";
    }
    ?>
    var payments_table = $('#payments_table').dataTable( {
        "oColVis": {
            "aiExclude": [0, 4, 5, 9],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [8] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/purchase_payments/getData',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            if( filter != undefined && value != undefined ){
                aoData.push( { "name": "f", "value": filter } );
                aoData.push( { "name": "v", "value": value } );
            }
            if( purchase != undefined ){
                aoData.push( { "name": "purchase", "value": purchase } );
            }
            <?php
            if( isset($biller_id)){
                echo 'aoData.push( { "name": "biller_id", "value": "'.$biller_id.'" } );';
            }
            ?>
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
            $.each($(this).find('a.biller_popover'), function(i, biller_popover){
                $(biller_popover).popover({
                    placement: 'bottom',
                    template: '<div class="popover"><div class="arrow"></div><div class="popover-content"></div></div>',
                    content:'<ul>'+
                    '<li class="dropdown-item"><a href="'+SITE_URL+'/billers/view?id='+$(biller_popover).data("bill_to_id")+'" class="text-inherit sis_modal" sis-modal="payments_table"><i class="fa fa-expand"></i>'+globalLang["details"]+'</a></li>'+
                    '<li class="dropdown-item">'+filter_format('<i class="fa fa-filter"></i>'+globalLang["filter"], "fullname", $(biller_popover).data("value"), $(biller_popover).data("value"))+'</li>'+
                    '</ul>',
                    html:true,
                });
            });
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'checkbox', "mDataProp": 'checkbox', "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'number'  , "mDataProp": 'number'  , "mRender": number_format},
            { "sName": 'purchase' , "mDataProp": 'purchase' , "mRender": reference_format},
            { "sName": 'fullname', "mDataProp": 'fullname', "mRender": supplier_format},
	        { "sName": 'p_date'  , "mDataProp": 'p_date'  , "mRender": date_format},
	        { "sName": 'amount'  , "mDataProp": 'amount'  , "mRender": Format_Currency},
            { "sName": 'method'  , "mDataProp": 'method'  , "mRender": method_format},
            { "sName": 'status'  , "mDataProp": 'status'  , "mRender": status_format},
            { "sName": 'details' , "mDataProp": 'details' , "mRender": details_format},
	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });
    <?php if (!isset($disable_headings) || !$disable_headings): ?>
    payments_table.advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "date-range"},
            { type: "number" },
            { type: "select", values: <?php echo json_encode($method_list) ?> },
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            { type: "text", bRegex:true },
            null
        ]
    });
    <?php endif ?>

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    payments_table.on("click", "a[href='#filter']", function(e){
        payments_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            payments_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = payments_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            payments_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(payments_table);
        }

        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        payments_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        payments_table._fnReDraw();
        return false;
    });

    payments_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["payment"+(select_count==1?"":"s")]+".";
            totals = [];
            var oSettings = payments_table.fnSettings();
            for (var i = 0; i < oSettings.aoData.length; i++) {
                if( $(oSettings.aoData[i].nTr).is(".row_selected") ){
                    row = oSettings.aoData[i]._aData;
                    if( totals[row.currency] != undefined ){
                        totals[row.currency] += parseFloat(row.amount);
                    }else{
                        totals[row.currency] = parseFloat(row.amount);
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
                $('#payments_table').load_ajax(SITE_URL+"/payments/delete", 'POST', selected_rows);
            });
        }
        return false;
    });

    function actions_format(data, type, row, meta){
        actions = '<div class="btn-group">'+
                    '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                        '<span><i class="icon-settings"></i></span>'+
                    '</button>'+
                    '<ul class="dropdown-menu dropdown-menu-right">';

        actions += $('#payments_table').create_datatable_action("eye", SITE_URL+"/purchase_payments/details/"+row.id, globalLang['details'], false, false, true);
        is_biller = <?php echo defined("BILLER_ID")?"true":"false" ?>;
        if ( (is_biller && row.status!="released") || !is_biller  ){
            actions += '<li class="dropdown-divider" ></li>';
            actions += $('#payments_table').create_datatable_action("trash", SITE_URL+"/purchase_payments/delete?id="+row.id, globalLang['delete'], false, true, false, true);
            actions += $('#payments_table').create_datatable_action("pencil", SITE_URL+"/purchase_payments/edit/"+row.id, globalLang['edit'], false, false, true);
        }

        <?php if ($this->ion_auth->is_admin() ): ?>
        actions += $('#payments_table').create_datatable_action("gear", SITE_URL+"/purchase_payments/set_status?id="+row.id, globalLang['set_status'], false, false, true);
        <?php endif ?>
        <?php if (!defined("BILLER_ID") ): ?>
        if( row.status == "panding" ){
            actions += '<li class="dropdown-divider" ></li>';
            actions += $('#payments_table').create_datatable_action("check", SITE_URL+"/purchase_payments/approve/"+row.id, globalLang['approve'], false, true, false, true);
            actions += $('#payments_table').create_datatable_action("remove", SITE_URL+"/purchase_payments/reject/"+row.id, globalLang['reject'], false, true, false, true);
        }
        <?php endif ?>
        actions += '</ul></div>';
        return "<center>"+actions+"</center>";
    }
    function reference_format(value, y ,row) {
        var html = '<a href="'+SITE_URL+'/invoices/open/'+row.invoice_id+'"><small class="font-weight-bold">'+value+'</small></a>';
        return  html;
    }
    function number_format(data, type, row, meta) {
        var value = String("00000" + data).slice(-5);
        var html = '<a href="'+SITE_URL+'/payments/details/'+row.id+'" sis-modal="payments_table"><small class="font-weight-bold">'+value+'</small></a>';
        return  html;
    }
    function details_format(value) {
        var html = "<small class='text-truncate' style='max-width:130px;display: block;'>"+value+"</small>";
        return  html;
    }
    function date_format(value) {
      var html = "<small>"+Format_Date(value)+"</small>";
      return  filter_format(html, "p_date", value, Format_Date(value));
    }
    function method_format(x, y ,row) {
        var method = x;
        if( x == "cash" ){
            method = "<span class='label label-tall label-info'>"+globalLang[x]+"</span>";
        }
        if( x == "check" ){
            method = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
        }
        if( x == "bank_transfer" ){
            method = "<span class='label label-tall label-warning'>"+globalLang[x]+"</span>";
        }
        if( x == "online" ){
            method = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
        if( x == "other" ){
            method = "<span class='label label-tall label-default'>"+globalLang[x]+"</span>";
        }
        if( x == "paypal" ){
            method = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
        if( x == "stripe" ){
            method = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
        if( x == "twocheckout" ){
            method = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
        return "<center>"+filter_format(method, "method", x, globalLang[x])+"</center>";
    }
    function status_format(x, y ,row) {
        var status = x;
        if( x == "released" ){
            status = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
        }
        if( x == "panding" ){
            status = "<span class='label label-tall label-info'>"+globalLang[x]+"</span>";
        }
        if( x == "canceled" ){
            status = "<span class='label label-tall label-default'>"+globalLang[x]+"</span>";
        }
        return "<center>"+filter_format(status, "status", x, globalLang[x])+"</center>";
    }
    function supplier_format(value, y ,row) {
        var html = "<a class='text-inherit biller_popover' data-toggle='popover' data-bill_to_id='"+row.bill_to_id+"' data-value='"+value+"' ><small>"+value+"</small></a>";
        return  html;
    }
});
</script>
