<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");

$status_list = array();
foreach ($this->settings_model->getContractStatus() as $key => $value) {
    $status_list[] = array(
        "label" => $value,
        "value" => $key
    );
}
?>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
<!-- Page Header -->
<div class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/contracts/create');?>" sis-modal="contracts_table" class="btn btn-primary-outline tip large-modal" title="<?php echo lang("create"); ?>"> <i class="fa fa-plus"></i></a>
        <?php endif ?>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group tip" title="<?php echo lang("filter"); ?>">
            <?php $class = (isset($_GET['f']) && $_GET['f'] == "status")?"btn-primary":"btn-primary-outline"; ?>
            <a class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $class = isset($_GET['fv'])?"":"active"; ?>
                <a href="<?php echo site_url('/contracts');?>" class="dropdown-item <?php echo $class ?>"><?php echo lang("all") ?></a>
                <?php foreach ($this->settings_model->getContractStatus() as $status => $label): ?>
                    <?php $class = (isset($_GET['fv']) && $_GET['fv'] == $status)?"active":""; ?>
                    <a href="<?php echo site_url('/contracts?f=status&fv='.$status);?>" class="dropdown-item <?php echo $class ?>"><?php echo $label ?></a>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="contracts_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
        <div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
        </div>
        <div class="btn-group actions-list tip" title="<?php echo lang("actions"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" class="dropdown-item disabled btn-select-multi delete_selected"><i class="fa fa-trash"></i><?php echo lang("delete") ?></a></li>
                <li class="dropdown-divider"></li>
                <li><a href="#" class="dropdown-item disabled btn-select-multi print_selected"><i class="fa fa-print"></i><?php echo lang("print") ?></a></li>
                <li><a href="#" class="dropdown-item disabled btn-select-multi pdf_selected"><i class="fa fa-download"></i><?php echo lang("tabletool_pdf") ?></a></li>
            </ul>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
<?php endif ?>
                <table id="contracts_table" class="table table-sm table-hover serverSide checkable_datatable">
                    <thead>
						<tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th><?php echo lang("reference"); ?></th>
                            <th><?php echo lang("subject"); ?></th>
							<th><?php echo lang("issued_on"); ?></th>
							<th><?php echo lang("date_due"); ?></th>
							<th><?php echo lang("customer"); ?></th>
							<th><?php echo lang("contract_type"); ?></th>
                            <th><?php echo lang("status"); ?></th>
                            <th style="text-align: end;"><?php echo lang("contract_value"); ?></th>
                            <th width="110" style="min-width:110px; text-align: end;"><?php echo lang("actions"); ?></th>
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
var contracts_table;
$(document).ready(function() {
    var filter, value;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    ?>
    contracts_table = $('#contracts_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,1,2,8,9],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        "bSortCellsTop"  : true,
        'sAjaxSource'    : SITE_URL+'/contracts/getdata',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            if( filter != undefined && value != undefined ){
                aoData.push( { "name": "f", "value": filter } );
                aoData.push( { "name": "v", "value": value } );
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
                    '<li class="dropdown-item"><a href="'+SITE_URL+'/billers/view?id='+$(biller_popover).data("biller_id")+'" class="text-inherit sis_modal" sis-modal="contracts_table"><i class="fa fa-expand"></i>'+globalLang["details"]+'</a></li>'+
                    '<li class="dropdown-item">'+filter_format('<i class="fa fa-filter"></i>'+globalLang["filter"], "fullname", $(biller_popover).data("value"), $(biller_popover).data("value"))+'</li>'+
                    '</ul>',
                    html:true,
                });
            });
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'id'       , "mDataProp": 'id'       , "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'reference', "mDataProp": 'reference', "mRender": reference_format},
	        { "sName": 'subject'  , "mDataProp": 'subject'  , "mRender": subject_format},
	        { "sName": 'date'     , "mDataProp": 'date'     , "mRender": date_format},
	        { "sName": 'date_due' , "mDataProp": 'date_due' , "mRender": date_due_format},
	        { "sName": 'fullname' , "mDataProp": 'fullname' , "mRender": biller_format},
	        { "sName": 'type'     , "mDataProp": 'type'     , "mRender": type_format},
            { "sName": 'status'   , "mDataProp": 'status'   , "mRender": status_format},
            { "sName": 'amount'   , "mDataProp": 'amount'   , "mRender": prices_format},
	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });
<?php if (!isset($disable_headings) || !$disable_headings): ?>
    contracts_table.advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            { type: "number", bRegex:true },
            null
        ]
    });
<?php endif ?>

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    contracts_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["contract"+(select_count==1?"":"s")]+".";
            total = 0;
            var oSettings = contracts_table.fnSettings();
            for (var i = 0; i < oSettings.aoData.length; i++) {
                if( $(oSettings.aoData[i].nTr).is(".row_selected") ){
                    total += parseFloat(oSettings.aoData[i]._aData.amount);
                }
            }
            html += globalLang["total"]+" <b>"+Format_Currency(total, true)+"</b>";
            table.closest(".dataTables_wrapper").find('.select_area').html(html).show();
        }else{
            table.closest(".dataTables_wrapper").find('.select_area').hide();
        }
    });

    contracts_table.on("click", "a[href='#filter']", function(e){
        contracts_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            contracts_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = contracts_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            contracts_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(contracts_table);
        }

        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        contracts_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        contracts_table._fnReDraw();
        return false;
    });

    $(document).on('click', '.delete_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = {};
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows["id["+i+"]"] = $(checkbox).data("id");
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#contracts_table').load_ajax(SITE_URL+"/contracts/delete", 'POST', selected_rows);
            });
        }
        return false;
    });

    $(document).on('click', '.print_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = [];
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows[i] = $(checkbox).data("id");
            });
            MyWindow=window.open(SITE_URL+"/contracts/view?id="+selected_rows.join(","), WINDDOW_NAME, WINDDOW_CONFIGURATION);
        }
        return false;
    });

    $(document).on('click', '.pdf_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = [];
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows[i] = $(checkbox).data("id");
            });
            location.href = SITE_URL+"/contracts/pdf?id="+selected_rows.join(",");
        }
        return false;
    });

    function actions_format(data, type, row, meta){
        actions = '<div class="btn-group">'+
                    '<a href="'+SITE_URL+"/contracts/open/"+row.id+'" class="btn btn-sm btn-secondary m-a-0" >'+
                        '<span>'+globalLang['details']+'</span>'+
                    '</a>'+
                    '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                        '<span><i class="icon-settings"></i></span>'+
                    '</button>'+
                    '<ul class="dropdown-menu dropdown-menu-right">';

        actions += $('#contracts_table').create_datatable_action("eye", SITE_URL+"/contracts/open/"+row.id, globalLang['details'], false);
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        actions += $('#contracts_table').create_datatable_action("trash", SITE_URL+"/contracts/delete/"+row.id, globalLang['delete'], false, true, false, true);
        actions += $('#contracts_table').create_datatable_action("pencil", SITE_URL+"/contracts/edit/"+row.id, globalLang['edit'], false, false, {large_modal:true});
        <?php endif ?>
        actions += '<li class="dropdown-divider" ></li>';
        actions += $('#contracts_table').create_datatable_action("print", SITE_URL+"/contracts/view/"+row.id, globalLang['print'], true);
        actions += $('#invoices_table').create_datatable_action("download", SITE_URL+"/contracts/pdf?id="+row.id, globalLang['tabletool_pdf'], false);
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        actions += $('#invoices_table').create_datatable_action("envelope", SITE_URL+"/contracts/email?id="+row.id, globalLang['email'], false, false, true);
        <?php endif ?>
        if( row.attachments.trim() != "" ){
            actions += '<li class="dropdown-divider" ></li>';
            actions += '<li><a href="'+SITE_URL+"/contracts/download_attachment/"+row.id+'" target="_BLANK" class="dropdown-item"><i class="fa fa-paperclip"></i> '+globalLang['download_attachments']+'</a></li>';
        }
        actions += '</ul></div>';
        return "<center>"+actions+"</center>";
    }

    function status_format(x, y ,row) {
        var status = x;
        if( x == "panding" ){
            status = "<span class='label label-tall label-secondary'>"+globalLang[x]+"</span>";
        }
        if( x == "active" ){
            status = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
        }
        if( x == "expired" ){
            status = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
        return  filter_format(status, "status", x, globalLang[x]);
    }

    function reference_format(value, y ,row) {
        var html = '<a href="'+SITE_URL+'/contracts/open/'+row.id+'"><small class="font-weight-bold">'+value+'</small></a>';
        return  html;
    }

    function type_format(value, y ,row) {
      var html = "<small>"+value+"</small>";
      return  filter_format(html, "type", value, value);
    }

    function biller_format(value, y ,row) {
        var html = "<a class='text-inherit biller_popover' data-toggle='popover' data-biller_id='"+row.biller_id+"' data-value='"+value+"' ><small>"+value+"</small></a>";
        return  html;
    }

    function subject_format(value) {
      var html = "<small>"+value+"</small>";
      return  filter_format(html, "subject", value, value);
    }


    function date_due_format(value) {
      var html = "<small>"+Format_Date(value)+"</small>";
      return  filter_format(html, "date_due", value, Format_Date(value));
    }

    function date_format(value) {
      var html = "<small>"+Format_Date(value)+"</small>";
      return  filter_format(html, "date", value, Format_Date(value));
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
});
</script>
