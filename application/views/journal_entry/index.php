<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
?>
<style type="text/css">
    .tip-datatable{
        text-align: center;
    }
</style>
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
	<div class="flip pull-right" style="line-height: 64px;">
		<a href="<?php echo site_url('je_current/create');?>" class="btn btn-primary-outline sis_modal tip" sis-modal="items_table" title="<?php echo lang("create_item"); ?>"> <i class="fa fa-plus"></i></a>
		<a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="items_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
		<div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
			<a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
		</div>
        <div class="btn-group actions-list tip" title="<?php echo lang("actions"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" class="dropdown-item disabled btn-select-multi delete_selected"><i class="fa fa-trash"></i><?php echo lang("delete") ?></a></li>
            </ul>
        </div>
	</div>
</ol>
<!-- <ol class="breadcrumb2" style="display: block;">
    <li>
        <a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a>
    </li>
    <li><?php echo lang("je_current"); ?></li>
    <li class="active"><?php echo $page_title;?></li>
</ol> -->
<style type="text/css">
    #items_table th{
        font-weight: bold;
    }
</style>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
				<table id="items_table" class="table table-sm table-hover serverSide checkable_datatable">
					<thead>
						<tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th style="width:35px; text-align: center;"><?php echo lang("n°"); ?></th>
                            <th><?php echo lang("doc_name"); ?></th>
                            <th><?php echo lang("journal_name"); ?></th>
                            <th><?php echo lang("acc_dpt"); ?></th>
                            <th><?php echo lang("acc_crdt"); ?></th>
                            <th><?php echo lang("date"); ?></th>
                            <th style="text-align: end;"><?php echo lang("amount"); ?></th>
                            <th><?php echo lang("gl_status"); ?></th>
                            <th width="20" style="width:20px; text-align: end;"><?php echo lang("actions"); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript">
var items_table;
$(document).ready(function() {
    var filter, value;
    items_table = $('#items_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,1],
        },
        "aoColumnDefs": [{
            "bVisible": false
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/je_current/getdata',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
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
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'checkbox', "mDataProp": 'checkbox', "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'id',          "mDataProp": 'id',          "mRender": number_format},
            { "sName": 'doc_name',        "mDataProp": 'doc_name',        "mRender": name_format},
            { "sName": 'journal_name', "mDataProp": 'journal_name', "mRender": description_format},
            { "sName": 'acc_debt',    "mDataProp": 'acc_debt',    "mRender": name_format},
            { "sName": 'acc_crdt',        "mDataProp": 'acc_crdt',        "mRender": name_format},
                        { "sName": 'date',      "mDataProp": 'date',      "mRender": date_format},
	        { "sName": 'amount',      "mDataProp": 'amount',      "mRender": prices_format},
             { "sName": 'gl_status',      "mDataProp": 'gl_status',      "mRender": gl_status_format},

	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    }).advancedSearch({
        aoColumns:[
            null,
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        items_table._fnReDraw();
        return false;
    });

    items_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["item"+(select_count==1?"":"s")]+".";
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
                $('#items_table').load_ajax(SITE_URL+"/items/delete", 'POST', selected_rows);
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
    actions += $('#items_table').create_datatable_action("trash", SITE_URL+"/je_current/delete?id="+row.id, globalLang['delete'], false, true, false, true);
    actions += $('#items_table').create_datatable_action("pencil", SITE_URL+"/je_current/edit?id="+row.id, globalLang['edit'], false, false, true);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function number_format(data, type, row, meta) {
    return "<center><small>"+data+"</small></center>";
}
function name_format(value) {
    var html = "<small class='font-weight-bold'>"+value+"</small>";
    return  html;
}
function description_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function category_format(value) {
    if( value != undefined ){
        var html = "<small>"+value+"</small>";
        return  html;
    }
    return "";
}
function unit_format(value) {
    if( value != undefined ){
        var html = "<small>"+value+"</small>";
        return  html;
    }
    return "";
}
function c_normal_format(value) {
    if( value == 'null' || value == null ){
        return "";
    }
    var html = "<small>"+value+"</small>";
    return  html;
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
function tax_format(value, type, row, meta) {
    if( value == 0 ){
        result = "<div class='' dir='ltr'>-</div>";
    }else if( row.tax_type == 0 ){
        result = "<div class='' dir='ltr'>"+value + " <b>%</b>"+"</div>";
    }else{
        result = Format_Currency(value,type,row,meta);
    }
    return  "<small>"+result+"</small>";
}
function discount_format(value, type, row, meta) {
    if( value == 0 ){
        result = "<div class='' dir='ltr'>-</div>";
    }else if( row.discount_type == 0 ){
        result = "<div class='' dir='ltr'>"+value + " <b>%</b>"+"</div>";
    }else{
        result = Format_Currency(value,type,row,meta);
    }
    return  "<small>"+result+"</small>";
}

function date_format(value) {
      var html = "<small>"+Format_Date(value)+"</small>";
      return  filter_format(html, "date", value, Format_Date(value));
    }

 function gl_status_format(x, y ,row) {
        var status = x;
        if( x == "open" ){
            status = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
        }
 
        if( x == "posted" ){
            status = "<span class='label label-tall label-danger'>"+globalLang[x]+"</span>";
        }
       

        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
            var html = "<a href='#' class='text-inherit status_popover' data-toggle='popover' data-id='"+row.id+"' data-status='"+x+"' data-value='"+globalLang[x]+"' >"+status+"</a>";
            return html;
        <?php else: ?>
            return filter_format(status, "status", x, globalLang[x]);
        <?php endif ?>
    }
</script>
