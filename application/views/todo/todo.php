<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
$priorities = array();
foreach ($this->settings_model->getPriorities() as $key => $value) {
    $priorities[] = array(
        "label" => $value,
        "value" => $key
    );
}
?>
<!-- Page Header -->
<div class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <a href="<?php echo site_url('/todo/create');?>" sis-modal="todo_table" class="btn btn-primary-outline tip" title="<?php echo lang("create"); ?>"> <i class="fa fa-plus"></i></a>
        <div class="btn-group tip" title="<?php echo lang("filter"); ?>">
            <?php $class = (isset($_GET['f']) && $_GET['f'] == "priority")?"btn-primary":"btn-primary-outline"; ?>
            <a class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $class = isset($_GET['fv'])?"":"active"; ?>
                <a href="<?php echo site_url('/todo');?>" class="dropdown-item <?php echo $class ?>"><?php echo lang("all") ?></a>
                <?php foreach ($this->settings_model->getPriorities() as $priority => $label): ?>
                    <?php $class = (isset($_GET['fv']) && $_GET['fv'] == $priority)?"active":""; ?>
                    <a href="<?php echo site_url('/todo?f=priority&fv='.$priority);?>" class="dropdown-item <?php echo $class ?>"><?php echo $label ?></a>
                <?php endforeach ?>
            </ul>
        </div>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="todo_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
        <div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <table id="todo_table" class="table table-sm table-hover serverSide">
                    <thead>
						<tr>
                            <th><?php echo lang("subject"); ?></th>
							<th><?php echo lang("date"); ?></th>
							<th><?php echo lang("date_due"); ?></th>
							<th><?php echo lang("priority"); ?></th>
                            <th><?php echo lang("description"); ?></th>
                            <th width="20" style="min-width:20px; text-align: end;"><?php echo lang("actions"); ?></th>
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
var todo_table;
$(document).ready(function() {
    var filter, value;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    ?>
    todo_table = $('#todo_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,1,5],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [] ,
        }],
        "aaSorting": [[ 3, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        "bSortCellsTop"  : true,
        'sAjaxSource'    : SITE_URL+'/todo/getdata',
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
        "aoColumns": [
	        { "sName": 'subject'  , "mDataProp": 'subject'  , "mRender": subject_format},
	        { "sName": 'date'     , "mDataProp": 'date'     , "mRender": date_format},
	        { "sName": 'date_due' , "mDataProp": 'date_due' , "mRender": date_due_format},
	        { "sName": 'priority' , "mDataProp": 'priority' , "mRender": priority_format},
            { "sName": 'description', "mDataProp": 'description', "mRender": description_format},
	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });
    todo_table.advancedSearch({
        aoColumns:[
            { type: "text", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "select", values: <?php echo json_encode($priorities) ?> },
            { type: "text", bRegex:true },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    todo_table.on("click", "a[href='#filter']", function(e){
        todo_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            todo_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = todo_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            todo_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(todo_table);
        }

        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        todo_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        todo_table._fnReDraw();
        return false;
    });

    function actions_format(data, type, row, meta){
        actions = '<div class="btn-group">'+
                    '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                        '<span><i class="icon-settings"></i></span>'+
                    '</button>'+
                    '<ul class="dropdown-menu dropdown-menu-right">';
        actions += $('#todo_table').create_datatable_action("trash", SITE_URL+"/todo/delete/"+row.id, globalLang['delete'], false, true, false, true);
        actions += $('#todo_table').create_datatable_action("pencil", SITE_URL+"/todo/edit/"+row.id, globalLang['edit'], false, false, true);
        if( row.complete == "0" ){
            actions += $('#todo_table').create_datatable_action("check", SITE_URL+"/todo/complete/"+row.id, globalLang['mark_as_complete'], false, false, false, true);
        }
        if( row.attachments.trim() != "" ){
            actions += '<li class="dropdown-divider" ></li>';
            actions += '<li><a href="'+SITE_URL+"/todo/download_attachment/"+row.id+'" target="_BLANK" class="dropdown-item"><i class="fa fa-paperclip"></i> '+globalLang['download_attachments']+'</a></li>';
        }
        actions += '</ul></div>';
        return "<center>"+actions+"</center>";
    }

    function priority_format(priority, y ,row) {
        var html = priority;
        if( priority == "1" ){
            html = "<span class='label label-tall label-danger'>"+globalLang["low"]+"</span>";
        }
        if( priority == "2" ){
            html = "<span class='label label-tall label-warning'>"+globalLang["medium"]+"</span>";
        }
        if( priority == "3" ){
            html = "<span class='label label-tall label-success'>"+globalLang["high"]+"</span>";
        }
        return  filter_format(html, "priority", priority, globalLang[priority]);
    }

    function description_format(value, y ,row) {
        return "<small>"+value+"</small>";
    }

    function subject_format(value, y ,row) {
        if (row.complete == "0") {
            var html = "<small>"+value+"</small>";
        }else{
            var html = "<small style='text-decoration:line-through'>"+value+"</small>";
        }
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
});
</script>
