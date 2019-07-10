<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/extra/js/TableTools.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/extra/js/ZeroClipboard.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
?>

<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('configuration_tax_rates') ?></h3>
    <div class="col-md-6 text-xs-right right-side">
      <a href="<?php echo site_url("settings/create_tax_rate") ?>" sis-modal="datatable_tax_rates" class="sis_modal btn btn-secondary"><i class="fa fa-plus"></i> <?php echo lang("create_tax_rate") ?></a>
      <a href="#refresh-list-tr" class="btn btn-secondary"><i class="fa fa-refresh"></i> <?php echo lang("refresh"); ?></a>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->

<table id="datatable_tax_rates" class="table table-sm table-hover" width="100%">
	<thead>
		<tr>
            <th width="20"><?php echo lang('n°'); ?></th>
            <th><?php echo lang('tax_rate_label'); ?></th>
            <th><?php echo lang('tax_rate_value'); ?></th>
            <th width="80"><?php echo lang('default'); ?></th>
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
var settings_taxes_table;
$(document).ready(function() {
    var settings_taxes_table = $('#datatable_tax_rates').dataTable( {
        "aaSorting": [[ 0, "asc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/settings/getTaxRates',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            $.ajax({'dataType':'json','type':'POST','url': sSource,'data':aoData,'success':fnCallback});
        },
        "aoColumns": [
            { "sName": 'id', "mDataProp": 'id', "mRender": tax_rate_n_format},
            { "sName": 'label', "mDataProp": 'label', "mRender": tax_rate_label_format},
            { "sName": 'value', "mDataProp": 'value', "mRender": tax_rate_value_format},
            { "sName": 'is_default', "mDataProp": 'is_default', "mRender": tax_rate_is_default_format},
            { "bSortable": false, "mRender": tax_rate_actions_format, "bSearchable": false }
        ]
    });

    $('a[href="#refresh-list-tr"]').bind('click', function() {
        settings_taxes_table._fnReDraw();
        return false;
    });

});
function tax_rate_n_format(value, type, row, meta) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function tax_rate_label_format(value) {
    if( value.startsWith("lang:") ){
        value = globalLang[value.substring(5)];
    }
    var html = "<small class='font-weight-bold'>"+(value)+"</small>";
    return  html;
}
function tax_rate_value_format(value, type, row, meta) {
    if( row.type == 0 ){
        type = "%";
    }else{
        type = CURRENCY_SYMBOL;
    }
    value = parseFloat(value);
    if( value == 0 ){
        html = "<small>-</small>";
    }else{
        html = "<small>"+(value.toFixed(2))+" "+type+"</small>";
    }
    return  html;
}
function tax_rate_is_default_format(value) {
    if( value == 1 ){
        html = "<small class='label label-pill label-success'><i class='fa fa-check'></i></small>";
    }else{
        html = "";
    }
    return  html;
}
function tax_rate_actions_format(data, type, row, meta){
    actions = "";
    if( row.can_delete == 1 ){
        actions = '<div class="btn-group">'+
                '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                    '<span><i class="icon-settings"></i></span>'+
                '</button>'+
                '<ul class="dropdown-menu dropdown-menu-right">';
        actions += $("#datatable_tax_rates").create_datatable_action("pencil", SITE_URL+"/settings/update_tax_rate?id="+row.id, globalLang['edit'], false, false, true);
        actions += $("#datatable_tax_rates").create_datatable_action("trash", SITE_URL+"/settings/delete_tax_rate?id="+row.id, globalLang['delete'], false, true, false, true);
        actions += '</ul></div>';
    }
    return "<center>"+actions+"</center>";
}
</script>
