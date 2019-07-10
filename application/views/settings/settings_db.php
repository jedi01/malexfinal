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
        <h3 class="title col-md-6"><?php echo lang('configuration_db') ?></h3>
        <div class="col-md-6 text-xs-right right-side">
            <a href="<?php echo site_url("settings/create_backup") ?>" class="create_backup btn btn-secondary"><i class="fa fa-download"></i> <?php echo lang("create_backup") ?></a>
            <a href="#refresh-list" class="btn btn-secondary"><i class="fa fa-refresh"></i> <?php echo lang("refresh"); ?></a>
            <div class="btn-group actions-list" style="margin-top: -2px;">
                <a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i><span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" class="dropdown-item disabled btn-select-multi delete_selected"><i class="fa fa-trash"></i><?php echo lang("delete") ?></a></li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- TITLE BAR END -->

<table id="settings_db_table" class="table table-sm table-hover serverSide checkable_datatable" width="100%">
	<thead>
		<tr>
            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                <input type="checkbox" id="select_all" name="select_all"/>
                <label></label>
            </th>
			<th><?php echo lang('filename'); ?></th>
			<th width="300"><?php echo lang('date_creation'); ?></th>
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
var settings_db_table;
$(document).ready(function() {
    var settings_db_table = $('#settings_db_table').dataTable( {
        "aaSorting": [[ 1, "asc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/settings/getBackups',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            $.ajax({'dataType':'json','type':'POST','url': sSource,'data':aoData,'success':fnCallback});
        },
        'fnDrawCallback': function(){
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'id'  , "mDataProp": 'id'  , "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'name', "mDataProp": 'name', "mRender": name_format},
            { "sName": 'date', "mDataProp": 'date', "mRender": date_format},
            { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        settings_db_table._fnReDraw();
        return false;
    });

    $('a.create_backup').bind('click', function() {
        setTimeout(function() {
            settings_db_table._fnReDraw();
        }, 250);
    });

    $(document).on('click', '.delete_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = {};
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows["id["+i+"]"] = $(checkbox).data("id");
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#settings_db_table').load_ajax(SITE_URL+"/settings/delete_backup", 'POST', selected_rows);
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
    actions += $('#settings_db_table').create_datatable_action("clock-o", SITE_URL+"/settings/restore_backup?date="+row.date, globalLang['restore_backup'], false, true, false, true);
    actions += $('#settings_db_table').create_datatable_action("trash", SITE_URL+"/settings/delete_backup?date="+row.date, globalLang['delete_backup'], false, true, false, true);
    actions += $('#settings_db_table').create_datatable_action("download", SITE_URL+"/settings/download_backup?date="+row.date, globalLang['tabletool_collection'], false, false, false, false);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function name_format(value) {
    var html = "<small class='font-weight-bold'><i class='fa fa-file-text'></i> "+(value)+"</small>";
    return  html;
}
function date_format(value) {
    var html = "<small>"+(value)+"</small>";
    return  html;
}
</script>
