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
    <a href="<?php echo site_url('settings/create_chart_of_account');?>" sis-modal="users_table" class="btn btn-primary-outline tip" title="<?php echo lang('chart_of_accounts'); ?>"> <i class="fa fa-plus"></i></a>
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
    <h3 class="title col-md-6"><?php echo lang('chart_of_accounts') ?></h3>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->

<style type="text/css">
    #charts_of_Account th{
        font-weight: bold;
    }
</style>
<table id="charts_of_Account" class="table table-sm table-hover" width="100%">
    <thead>
        <tr>
            <th><?php echo lang('account_number');?></th>
            <th><?php echo lang('description');?></th>
            <th><?php echo lang('index_status_th');?></th>
            <th width="20" style="width:20px;"><?php echo lang("actions"); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">
var charts_of_Account;
$(document).ready(function() {
    charts_of_Account = $('#charts_of_Account').dataTable( {
        "oColVis": {
            "aiExclude": [0, 6],
        },
        "aoColumnDefs": [{
            "bVisible": false,
        }],
        "aaSorting": [[ 0, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/settings/getChartsData',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            $.ajax({'dataType':'json','type':'POST','url': sSource,'data':aoData,'success':fnCallback});
        },
        "aoColumns": [
            { "sName": 'account_number', "mDataProp": 'account_number', "mRender": description_format},
            { "sName": 'description'  , "mDataProp": 'description'  , "mRender": description_format},
            { "sName": 'status'  , "mDataProp": 'status'  , "mRender": status_format_chart_of_account},
            { "bSortable": false, "mRender": charts_action_format , "bSearchable": false}
        ]
    }).advancedSearch({
        aoColumns:[
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        charts_of_Account._fnReDraw();
        return false;
    });
});
function charts_action_format(data, type, row, meta){


    actions = '<div class="btn-group">'+
                '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                    '<span><i class="icon-settings"></i></span>'+
                '</button>'+
                '<ul class="dropdown-menu dropdown-menu-right">';
    if( row.status == "1" ){
        actions += $('#charts_of_Account').create_datatable_action("ban", SITE_URL+"/settings/deactivate_chart_of_account/"+row.id, globalLang['index_inactive_link'], false, false, true);
    }else{
        actions += $('#charts_of_Account').create_datatable_action("check", SITE_URL+"/settings/activate_chart_of_account/"+row.id, globalLang['index_active_link'], false, false, false, true);
    }
    actions += $('#charts_of_Account').create_datatable_action("pencil", SITE_URL+"/settings/edit_chart_of_account/"+row.id, globalLang['edit_user_account'], false, false, true);
    actions += $('#charts_of_Account').create_datatable_action("trash", SITE_URL+"/settings/delete_chart_of_account/"+row.id, globalLang['delete'], false, true, false, true);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function number_format(data, type, row, meta) {
    return "<center><small>"+data+"</small></center>";
}
function description_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}

function status_format_chart_of_account(status) {
    // var html = "";
    // if( status == "1" ){
    //     html = "<small class='text-bullet-success'><?php echo lang('index_active_status'); ?></small>";
    // }else{
    //     html = "<small class='text-bullet-danger'><?php echo lang('index_inactive_status'); ?></small>";
    // }
    // return  html;

        if( status == "1" ){
            status = "<span class='label label-tall label-success'><?php echo lang('index_active_status'); ?></span>";
        }
 
       else{
            status = "<span class='label label-tall label-danger'><?php echo lang('index_inactive_status'); ?></span>";
        }
         return  status;
}
</script>
