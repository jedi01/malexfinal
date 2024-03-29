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
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
	<div class="flip pull-right" style="line-height: 64px;">
		<a href="<?php echo site_url('/accounts/create');?>" sis-modal="users_table" class="btn btn-primary-outline tip" title="<?php echo lang("create_user_account"); ?>"> <i class="fa fa-plus"></i></a>
		<a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="users_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
		<div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
			<a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
		</div>
	</div>
</ol>
<ol class="breadcrumb2" style="display: block;">
    <li>
        <a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a>
    </li>
    <li><?php echo lang("settings"); ?></li>
    <li class="active"><?php echo $page_title;?></li>
</ol>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
            <table id="users_table" class="table table-sm table-striped table-hover table-condensed" width="100%">
                <thead>
                    <tr>
                        <th width="180"><?php echo lang('account_number');?></th>
                        <th width="100"><?php echo lang('index_status_th');?></th>
                        <th width="180"><?php echo lang('description');?></th>
                        <th width="20" style="width:20px;"><?php echo lang("actions"); ?></th>
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
var users_table;
$(document).ready(function() {
    users_table = $('#users_table').dataTable( {
        "oColVis": {
            "aiExclude": [0, 6],
        },
        "aoColumnDefs": [{
            "bVisible": false,
        }],
        "aaSorting": [[ 0, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/accounts/getData',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            $.ajax({'dataType':'json','type':'POST','url': sSource,'data':aoData,'success':fnCallback});
        },
        "aoColumns": [
            { "sName": 'account_number', "mDataProp": 'account_number', "mRender": username_format},
            { "sName": 'status'  , "mDataProp": 'status'  , "mRender": status_format},
             { "sName": 'description'  , "mDataProp": 'description'  , "mRender": username_format},
            { "bSortable": false, "mRender": actions_format , "bSearchable": false}
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
        users_table._fnReDraw();
        return false;
    });
});
function actions_format(data, type, row, meta){


    actions = '<div class="btn-group">'+
                '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                    '<span><i class="icon-settings"></i></span>'+
                '</button>'+
                '<ul class="dropdown-menu dropdown-menu-right">';
    if( row.status == "1" ){
        actions += $('#users_table').create_datatable_action("ban", SITE_URL+"/accounts/deactivate/"+row.id, globalLang['index_inactive_link'], false, false, true);
    }else{
        actions += $('#users_table').create_datatable_action("check", SITE_URL+"/accounts/activate/"+row.id, globalLang['index_active_link'], false, false, false, true);
    }
    actions += $('#users_table').create_datatable_action("pencil", SITE_URL+"/accounts/edit/"+row.id, globalLang['edit_user_account'], false, false, true);
    actions += $('#users_table').create_datatable_action("trash", SITE_URL+"/accounts/delete/"+row.id, globalLang['delete'], false, true, false, true);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function username_format(value) {
    var html = "<small class='font-weight-bold'>"+(value)+"</small>";
    return  html;
}
function fullname_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function email_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function phone_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}

function groups_format(groups_value) {
    if( groups_value == null || groups_value == undefined ){
        return "";
    }
    var groups = groups_value.split(",");
    var html = "";
    for (var i = 0; i < groups.length; i++) {
        group = groups[i].trim();
        role  = globalLang['role_'+group.toLowerCase()];
        if( group == "superadmin" ){
            html += "<span class='label label-warning text-capitalize'>"+role+"</span> ";
        }else if(group == "admin"){
            html += "<span class='label label-danger text-capitalize'>"+role+"</span> ";
        }else if(group == "customer"){
            html += "<span class='label label-success text-capitalize'>"+role+"</span> ";
        }else if(group == "supplier"){
            html += "<span class='label label-warning text-capitalize'>"+role+"</span> ";
        }else{
            html += "<span class='label label-info text-capitalize'>"+role+"</span> ";
        }
    }
    return  html;
}
function status_format(status) {
    var html = "";
    if( status == "1" ){
        html = "<small class='text-bullet-success'><?php echo lang('index_active_status'); ?></small>";
    }else{
        html = "<small class='text-bullet-danger'><?php echo lang('index_inactive_status'); ?></small>";
    }
    return  html;
}
</script>
