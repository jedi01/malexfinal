<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");


$status_list = array (
    array("label" => lang("index_active_status"), "value" => "1"),
    array("label" => lang("index_inactive_status"), "value" => "0"),
);

?>

<!-- TITLE BAR -->

<div class="flip pull-right" style="line-height: 64px;">
    <a href="<?php echo site_url('settings/create_balance');?>" sis-modal="users_table" class="btn btn-primary-outline tip" title="<?php echo lang('create_initial_balance'); ?>"> <i class="fa fa-plus"></i></a>
    <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
    <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="users_table">
        <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
    </div>
    <div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
        <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
    </div>
</div>  
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('initial_balance') ?></h3>
    
  <div class="clearfix"></div>
</div>
</div>
<!-- TITLE BAR END -->


<table id="balance" class="table table-sm table-hover serverSide checkable_datatable">
    <thead>
        <tr>
            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                <input type="checkbox" id="select_all" name="select_all"/>
                <label></label>
            </th>
            <th style="width:35px; text-align: center;"><?php echo lang("n°"); ?></th>
            <th><?php echo lang("account_number"); ?></th>
            <th><?php echo lang("description"); ?></th>
            <th style="text-align: end;"><?php echo lang("debit_amount"); ?></th>
            <th style="text-align: end;"><?php echo lang("credit_amount"); ?></th>
            <th width="20" style="width:20px; text-align: end;"><?php echo lang("actions"); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">
    var balance;
    $(document).ready(function() {
        var filter, value;
        balance = $('#balance').dataTable( {
            "oColVis": {
                "aiExclude": [1],
            },
            "aoColumnDefs": [{
                "bVisible": false,
            }],
            "aaSorting": [[ 1, "desc" ]],
            'bProcessing'    : true,
            'bServerSide'    : true,
            'sAjaxSource'    : SITE_URL+'/settings/getBalanceData',
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
            { "sName": 'account_number',        "mDataProp": 'account_number',        "mRender": description_format},
            { "sName": 'description', "mDataProp": 'description', "mRender": description_format},
            { "sName": 'dtp_amount',    "mDataProp": 'dtp_amount',    "mRender": prices_format},
            { "sName": 'crd_amount',        "mDataProp": 'crd_amount',        "mRender": prices_format},
            { "bSortable": false, "mRender": actions_format, "bSearchable": false }
            ]
        }).advancedSearch({
            aoColumns:[
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
            balance._fnReDraw();
            return false;
        });

        balance.on("select-count", function(e){
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
                    $('#balance').load_ajax(SITE_URL+"/items/delete", 'POST', selected_rows);
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
    actions += $('#balance').create_datatable_action("expand", SITE_URL+"/settings/view_balance?id="+row.id, globalLang['details'], false, false, true);
    actions += $('#balance').create_datatable_action("trash", SITE_URL+"/settings/delete_balance?id="+row.id, globalLang['delete'], false, true, false, true);
    actions += $('#balance').create_datatable_action("pencil", SITE_URL+"/settings/edit_balance/"+row.id, globalLang['edit'], false, false, true);
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
        var html = "<small>"+value+" <b>$</b></small>";
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
        result = "<div class='text-md-right' dir='ltr'>-</div>";
    }else if( row.tax_type == 0 ){
        result = "<div class='text-md-right' dir='ltr'>"+value + " <b>%</b>"+"</div>";
    }else{
        result = Format_Currency(value,type,row,meta);
    }
    return  "<small>"+result+"</small>";
}
function discount_format(value, type, row, meta) {
    if( value == 0 ){
        result = "<div class='text-md-right' dir='ltr'>-</div>";
    }else if( row.discount_type == 0 ){
        result = "<div class='text-md-right' dir='ltr'>"+value + " <b>%</b>"+"</div>";
    }else{
        result = Format_Currency(value,type,row,meta);
    }
    return  "<small>"+result+"</small>";
}
</script>
