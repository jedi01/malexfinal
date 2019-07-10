<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
$cf = $this->settings_model->SYS_Settings;
?>
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
	<div class="flip pull-right" style="line-height: 64px;">
		<a href="<?php echo site_url('/suppliers/create');?>" sis-modal="suppliers_table" class="btn btn-primary-outline sis_modal tip" title="<?php echo lang("create_supplier"); ?>"> <i class="fa fa-plus"></i></a>
		<a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="suppliers_table">
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
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
				<table id="suppliers_table" class="table table-sm table-hover serverSide checkable_datatable">
					<thead>
						<tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th style="width:35px; text-align: center;"><?php echo lang("n°"); ?></th>
                            <th><?php echo lang("company"); ?></th>
                            <th><?php echo lang("contact_name"); ?></th>
							<th><?php echo lang("phone"); ?></th>
							<th><?php echo lang("email"); ?></th>
                            <th><?php echo lang("website"); ?></th>
                            <th><?php echo lang("vat_number"); ?></th>
                            <th><?php echo lang("address"); ?></th>
                            <?php
                            $cols = []; $th = 9;
                            if (!empty($cf->supplier_cf1)){ echo "<th>".$cf->supplier_cf1."</th>"; $cols[]=$th++;}
                            if (!empty($cf->supplier_cf2)){ echo "<th>".$cf->supplier_cf2."</th>"; $cols[]=$th++;}
                            if (!empty($cf->supplier_cf3)){ echo "<th>".$cf->supplier_cf3."</th>"; $cols[]=$th++;}
                            if (!empty($cf->supplier_cf4)){ echo "<th>".$cf->supplier_cf4."</th>"; $cols[]=$th++;}
                            if( $th == 9 ){$cols = [];}
                            ?>
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
var suppliers_table;
$(document).ready(function() {
    var filter, value;
    suppliers_table = $('#suppliers_table').dataTable( {
        "oColVis": {
            "aiExclude": [0, 1, 5, <?php echo $th ?>],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [6,7,<?php echo implode(",", $cols) ?>] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/suppliers/getdata',
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
            { "sName": 'id'      , "mDataProp": 'id'      , "mRender": number_format},
            { "sName": 'company' , "mDataProp": 'company' , "mRender": fullname_format},
            { "sName": 'fullname', "mDataProp": 'fullname', "mRender": fullname_format},
	        { "sName": 'phone'   , "mDataProp": 'phone'   , "mRender": c_normal_format},
	        { "sName": 'email'   , "mDataProp": 'email'   , "mRender": c_normal_format},
            { "sName": 'website' , "mDataProp": 'website' , "mRender": c_normal_format},
            { "sName": 'vat_number' , "mDataProp": 'vat_number' , "mRender": c_normal_format},
            { "sName": 'address' , "mDataProp": 'address' , "mRender": c_normal_format},
            <?php if (!empty($cf->supplier_cf1)): ?>
            { "sName": 'custom_field1' , "mDataProp": 'custom_field1' , "mRender": c_normal_format},
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf2)): ?>
            { "sName": 'custom_field2' , "mDataProp": 'custom_field2' , "mRender": c_normal_format},
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf3)): ?>
            { "sName": 'custom_field3' , "mDataProp": 'custom_field3' , "mRender": c_normal_format},
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf4)): ?>
            { "sName": 'custom_field4' , "mDataProp": 'custom_field4' , "mRender": c_normal_format},
            <?php endif; ?>
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
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            <?php if (!empty($cf->supplier_cf1)): ?>
            { type: "text", bRegex:true },
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf2)): ?>
            { type: "text", bRegex:true },
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf3)): ?>
            { type: "text", bRegex:true },
            <?php endif; ?>
            <?php if (!empty($cf->supplier_cf4)): ?>
            { type: "text", bRegex:true },
            <?php endif; ?>
            null
        ]
    });;

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        suppliers_table._fnReDraw();
        return false;
    });

    suppliers_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["supplier"+(select_count==1?"":"s")]+".";
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
                $('#suppliers_table').load_ajax(SITE_URL+"/suppliers/delete", 'POST', selected_rows);
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
    actions += $('#suppliers_table').create_datatable_action("expand", SITE_URL+"/suppliers/view/"+row.id, globalLang['details'], false, false, true);
    actions += $('#suppliers_table').create_datatable_action("trash", SITE_URL+"/suppliers/delete?id="+row.id, globalLang['delete'], false, true, false, true);
    actions += $('#suppliers_table').create_datatable_action("pencil", SITE_URL+"/suppliers/edit?id="+row.id, globalLang['edit'], false, false, true);

    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function number_format(data, type, row, meta) {
    return "<center><small>"+data+"</small></center>";
}
function fullname_format(value) {
    var html = "<small class='font-weight-bold'>"+value+"</small>";
    return  html;
}
function c_normal_format(value) {
    var html = "<small>"+value+"</small>";
    return  html;
}
</script>
