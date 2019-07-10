<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
?>
<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/expenses/create_category/');?>" sis-modal="categories_table" class="btn btn-primary-outline sis_modal tip" title="<?php echo lang("expenses_create"); ?>"> <i class="fa fa-plus"></i></a>
        <?php endif ?>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="categories_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
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
                <table id="categories_table" class="table table-sm table-striped table-hover table-condensed serverSide checkable_datatable">
                    <thead>
                        <tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th><?php echo lang("expenses_category_type"); ?></th>
                            <th><?php echo lang("expenses_category_label"); ?></th>
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
            </div>
        </div>
    </div>
<script type="text/javascript">
var categories_table;
$(document).ready(function() {
    var filter, value;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    ?>
    var categories_table = $('#categories_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,4],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/expenses/getDataCategories',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            if( filter != undefined && value != undefined ){
                aoData.push( { "name": "f", "value": filter } );
                aoData.push( { "name": "v", "value": value } );
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
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'checkbox',   "mDataProp": 'checkbox',   "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'type',       "mDataProp": 'type',       "mRender": type_format},
            { "sName": 'label',      "mDataProp": 'label',      "mRender": label_format},
            { "sName": 'is_default', "mDataProp": 'is_default', "mRender": is_default_format},
            { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    }).advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    categories_table.on("click", "a[href='#filter']", function(e){
        categories_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            categories_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = categories_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            categories_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(categories_table);
        }
        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        categories_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        categories_table._fnReDraw();
        return false;
    });

    categories_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["expenses_categor"+(select_count==1?"y":"ies")]+".";
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
                $('#categories_table').load_ajax(SITE_URL+"/expenses/delete_category", 'POST', selected_rows);
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
    actions += $('#categories_table').create_datatable_action("trash", SITE_URL+"/expenses/delete_category?id="+row.id, globalLang['delete'], false, true, false, true);
    actions += $('#categories_table').create_datatable_action("pencil", SITE_URL+"/expenses/update_category/"+row.id, globalLang['edit'], false, false, true);
    actions += '</ul></div>';
    return "<center>"+actions+"</center>";
}
function type_format(value, y ,row) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function label_format(value, y ,row) {
    var html = "<small>"+value+"</small>";
    return  html;
}
function is_default_format(value) {
    if( value == 1 ){
        html = "<small class='label label-pill label-success'><i class='fa fa-check'></i></small>";
    }else{
        html = "";
    }
    return  html;
}
</script>
