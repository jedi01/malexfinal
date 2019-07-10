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
$status_list = array();
foreach ($this->settings_model->getProjectTaskStatus() as $key => $value) {
    $status_list[] = array(
        "label" => $value,
        "value" => $key
    );
}
?>
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
            <a href="<?php echo site_url('/projects/edit?id='.$project->id);?>" sis-modal="" class="btn btn-link btn-sm" >
                <i class="icon-pencil h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
            </a>
            <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/projects/delete?id='.$project->id);?>', 'POST', undefined, '<?php echo site_url('/projects') ?>');}); return false;" class="btn btn-link btn-sm" >
                <i class="icon-trash h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
            </a>
        <?php endif ?>
    </div>
</ol>
<div class="container-fluid">
<div class="bordered_tabs">
    <ul class="nav nav-tabs" id="project_preview">
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#project_overview"><?php echo lang('overview') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#project_tasks"><?php echo lang('tasks') ?></a></li>
    </ul>
    <div class="tab-content" style="background: white;">
        <div class="tab-pane form-horizontal" id="project_overview">
            <div class="row row-equal">
                <div class="col-md-6">
                    <div class="card-header">
                        <span><?php echo lang("project_informations") ?></span>
                    </div>
                    <div class="card-block">
                        <div class="row form-group m-b-0">
                            <label class="col-md-3 form-control-label text-md-left"><?php echo lang('project_name');?></label>
                            <div class="col-md-9">
                                <p class="form-control-static"><?php echo $project->name ?></p>
                            </div>
                        </div>
                        <div class="row form-group m-b-0">
                            <label class="col-md-3 form-control-label text-md-left"><?php echo lang('customer');?></label>
                            <div class="col-md-9">
                                <p class="form-control-static"><?php echo $biller->fullname ?></p>
                            </div>
                        </div>
                        <div class="row form-group m-b-0">
                            <label class="col-md-3 form-control-label text-md-left"><?php echo lang('billing_type');?></label>
                            <div class="col-md-9">
                                <p class="form-control-static"><?php echo lang($project->billing_type) ?></p>
                            </div>
                        </div>
                        <?php if ( $project->billing_type == "fixed_rate" ): ?>
                            <div class="row form-group m-b-0">
                                <label class="col-md-3 form-control-label text-md-left"><?php echo lang('total_rate');?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo formatMoney($project->rate, $project->currency) ?></p>
                                </div>
                            </div>
                        <?php elseif ( $project->billing_type == "project_hours" ): ?>
                            <div class="row form-group m-b-0">
                                <label class="col-md-3 form-control-label text-md-left"><?php echo lang('rate_per_hour');?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo formatMoney($project->rate, $project->currency) ?></p>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="row form-group m-b-0">
                            <label class="col-md-3 form-control-label text-md-left"><?php echo lang('date');?></label>
                            <div class="col-md-9">
                                <p class="form-control-static"><?php echo date(PHP_DATE, strtotime($project->date)) ?></p>
                            </div>
                        </div>
                        <?php if ( $project->date_due != NULL ): ?>
                            <div class="row form-group m-b-0">
                                <label class="col-md-3 form-control-label text-md-left"><?php echo lang('deadline');?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo date(PHP_DATE, strtotime($project->date_due)) ?></p>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if ( $project->estimated_hours != 0 ): ?>
                            <div class="row form-group m-b-0">
                                <label class="col-md-3 form-control-label text-md-left"><?php echo lang('estimated_hours');?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $project->estimated_hours." ".lang("hour") ?></p>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="card-header">
                        <span><?php echo lang("description") ?></span>
                    </div>
                    <div class="card-block">
                        <div class="col-md-12">
                            <?php echo $project->description ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-header">
                        <span><?php echo lang("project_progress") ?></span>
                    </div>
                    <div class="card-block">
                        <div class="row row-equal">
                            <?php
                            $tasks_progress=$countTasks==0?100:floor($countComTasks*100/$countTasks);
                            $project_progress=$project->progress=="0"?$tasks_progress:$project->progress;
                            $not_completed_tasks = 100-$tasks_progress;
                            ?>
                            <div class="col-md-12">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <strong>Project progress</strong>
                                    </div>
                                    <div class="pull-right">
                                        <small class="text-muted"><?php echo $project_progress; ?> %</small>
                                    </div>
                                </div>
                                <div class="m-y-h">
                                    <progress class="progress progress-xs progress-<?php echo progress_text($project_progress) ?>" value="<?php echo $project_progress; ?>" max="100"><?php echo $project_progress; ?>%</progress>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="pull-right">
                            <small class="label label-<?php echo progress_text($tasks_progress) ?>"><?php echo $tasks_progress; ?> %</small>
                        </div>
                        <span><?php echo lang("tasks_progress") ?></span>
                    </div>
                    <div class="card-block">
                        <div class="row row-equal">
                            <div class="<?php echo $days_left=$project->date_due==NULL?"col-md-12":"col-md-6" ?>">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <strong><?php echo ($countTasks-$countComTasks)." / ".$countTasks." ".lang("not_completed_tasks") ?></strong>
                                    </div>
                                    <div class="pull-right">
                                        <small class="text-muted"><?php echo $not_completed_tasks; ?> %</small>
                                    </div>
                                </div>
                                <div class="m-y-h">
                                    <progress class="progress progress-xs progress-<?php echo progress_text($tasks_progress) ?>" value="<?php echo $not_completed_tasks ?>" max="100"><?php echo $not_completed_tasks ?>%</progress>
                                </div>
                            </div>
                            <?php if ($project->date_due!=NULL): ?>
                            <div class="col-md-6">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <?php $days_left = ($alldays-$days)<0?0:($alldays-$days); ?>
                                        <strong><?php echo $days_left." / ".$alldays." ".lang("days_left") ?></strong>
                                    </div>
                                    <div class="pull-right">
                                        <small class="text-muted"><?php echo ($days_left_percent=$alldays==0?0:floor($days_left*100/$alldays)) ?> %</small>
                                    </div>
                                </div>
                                <div class="m-y-h">
                                    <progress class="progress progress-xs progress-<?php echo progress_text($days_left_percent) ?>" value="<?php echo $days_left_percent ?>" max="100"><?php echo $days_left_percent ?>%</progress>
                                </div>
                            </div>
                            <?php endif ?>
                            <div class="col-md-12 p-y-1">
                                <canvas id="overview_chart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <span><?php echo lang("members") ?></span>
                    </div>
                    <div class="card-block p-a-0">
                        <?php
                            $members = json_decode($project->members);
                            $all_members = $this->projects_model->getAllMembers();
                        ?>
                        <table class="table table-sm table-align-middle m-b-0">
                            <tbody class="transparent">
                                <?php foreach ($members as $member): ?>
                                <tr>
                                    <td style="line-height: 25px; height: 25px;" class="small"><?php echo $all_members[$member] ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane form-horizontal" id="project_tasks">
            <div class="titlebar">
                <h3 class="flip pull-left"><?php echo lang('tasks_list') ?></h3>
                <div class="flip pull-right" style="line-height: 30px;">
                    <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
                    <a href="<?php echo site_url('/projects/create_task/'.$project->id);?>" sis-modal="tasks_list" class="btn btn-primary-outline tip" title="<?php echo lang("create"); ?>"> <i class="fa fa-plus"></i></a>
                    <?php endif ?>
                    <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
                    <div class="btn-group download-list tip" style="margin-top: -3px;" title="<?php echo lang("tabletool_collection"); ?>" export-table="tasks_list">
                        <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
                    </div>
                    <div class="btn-group columns-list tip" style="margin-top: -3px;" title="<?php echo lang("shown_columns"); ?>">
                        <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <table id="tasks_list" class="table table-sm table-hover serverSide">
                <thead>
                    <tr>
                        <th><?php echo lang("subject"); ?></th>
                        <th><?php echo lang("date"); ?></th>
                        <th><?php echo lang("date_due"); ?></th>
                        <th><?php echo lang("priority"); ?></th>
                        <th><?php echo lang("hour_rate"); ?></th>
                        <th><?php echo lang("status"); ?></th>
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
<script src="<?php echo base_url("assets/js/libs/colour_palette.js") ?>"></script>
<script type="text/javascript">
var tasks_list;
$(document).ready(function(){
    $('#project_preview a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#project_preview a[href="#project_overview"]').tab('show');
    <?php if ( $overviewTasks ): ?>
        var pieData = <?php echo json_encode($overviewTasks["data"]); ?>;
        var labels = <?php echo json_encode($overviewTasks["labels"]); ?>;
        pieChart = new Chart(document.getElementById('overview_chart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: palette('all', pieData.length).map(function(hex) {
                        return '#' + hex;
                    }),
                    data: pieData
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                cutoutPercentage: 80,
                legend: {
                    display: true,
                    position: "left",
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        fontSize: 11,
                    }
                }
            }
        });
    <?php else: ?>
        pieChart = new Chart(document.getElementById('overview_chart'), {
            type: 'doughnut',
            data: {
                labels: ["no_tasks"],
                datasets: [{
                    data: ["100"]
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                cutoutPercentage: 80,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: false,
                }
            }
        });
    <?php endif ?>

    tasks_list = $('#tasks_list').dataTable( {
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
        'sAjaxSource'    : SITE_URL+'/projects/getTasksdata/<?php echo $project->id ?>',
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
        "aoColumns": [
            { "sName": 'subject'  , "mDataProp": 'subject'  , "mRender": subject_format},
            { "sName": 'date'     , "mDataProp": 'date'     , "mRender": date_format},
            { "sName": 'date_due' , "mDataProp": 'date_due' , "mRender": date_due_format},
            { "sName": 'priority' , "mDataProp": 'priority' , "mRender": priority_format},
            { "sName": 'hour_rate', "mDataProp": 'hour_rate', "mRender": Format_Currency},
            { "sName": 'status'   , "mDataProp": 'status'   , "mRender": status_format},
            { "sName": 'description', "mDataProp": 'description', "mRender": description_format},
            { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });
    tasks_list.advancedSearch({
        aoColumns:[
            { type: "text", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "date-range", bRegex:true },
            { type: "select", values: <?php echo json_encode($priorities) ?> },
            { type: "number", bRegex:true },
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            { type: "text", bRegex:true },
            null
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        tasks_list._fnReDraw();
        return false;
    });

    function actions_format(data, type, row, meta){
        actions = '<div class="btn-group">'+
                    '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                        '<span><i class="icon-settings"></i></span>'+
                    '</button>'+
                    '<ul class="dropdown-menu dropdown-menu-right">';
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        actions += $('#tasks_list').create_datatable_action("trash", SITE_URL+"/projects/delete_task/"+row.id, globalLang['delete'], false, true, false, true);
        actions += $('#tasks_list').create_datatable_action("pencil", SITE_URL+"/projects/edit_task/"+row.id, globalLang['edit'], false, false, true);
        if( row.status != "complete" ){
            actions += $('#tasks_list').create_datatable_action("check", SITE_URL+"/projects/complete_task/"+row.id, globalLang['mark_as_complete'], false, false, false, true);
        }
        <?php endif ?>
        if( row.attachments.trim() != "" ){
            actions += '<li class="dropdown-divider" ></li>';
            actions += '<li><a href="'+SITE_URL+"/projects/download_attachment_task/"+row.id+'" target="_BLANK" class="dropdown-item"><i class="fa fa-paperclip"></i> '+globalLang['download_attachments']+'</a></li>';
        }
        actions += '</ul></div>';
        <?php if ($this->ion_auth->in_group(array("customer", "supplier"))): ?>
        if( row.attachments.trim() == "" ){
            actions = "";
        }
        <?php endif ?>
        return "<center>"+actions+"</center>";
    }

    function status_format(x, y ,row) {
        var status = x;
        if( x == "not_started" ){
            status = "<span class='label label-tall label-secondary'>"+globalLang[x]+"</span>";
        }
        if( x == "in_progress" ){
            status = "<span class='label label-tall label-default'>"+globalLang[x]+"</span>";
        }
        if( x == "testing" ){
            status = "<span class='label label-tall label-warning'>"+globalLang[x]+"</span>";
        }
        if( x == "panding" ){
            status = "<span class='label label-tall label-primary'>"+globalLang[x]+"</span>";
        }
        if( x == "complete" ){
            status = "<span class='label label-tall label-success'>"+globalLang[x]+"</span>";
        }

        return status;
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
        return html;
    }

    function description_format(value, y ,row) {
        return "<small>"+value+"</small>";
    }

    function subject_format(value, y ,row) {
        return "<small>"+value+"</small>";
    }

    function date_due_format(value) {
        return "<small>"+Format_Date(value)+"</small>";
    }

    function date_format(value) {
        return "<small>"+Format_Date(value)+"</small>";
    }
});
</script>
