<?php
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.colVis.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js");
$this->load->enqueue_script("assets/vendor/jquery-datatable/js/DT_bootstrap.js");
$status_list = array();
foreach ($this->settings_model->getRecurringStatus() as $key => $value) {
    $status_list[] = array(
        "label" => $value,
        "value" => $key
    );
}
?>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
<style type="text/css">
.popover-content{padding: 0px;}
</style>
<!-- Page Header -->
<div class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/rinvoices/create');?>" class="btn btn-primary-outline tip" title="<?php echo lang("create"); ?>"> <i class="fa fa-plus"></i></a>
        <?php endif ?>
        <a href="#refresh-list" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
        <div class="btn-group tip" title="<?php echo lang("filter"); ?>">
            <?php $class = (isset($_GET['f']) && $_GET['f'] == "status")?"btn-primary":"btn-primary-outline"; ?>
            <a class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php $class = isset($_GET['fv'])?"":"active"; ?>
                <a href="<?php echo site_url('/rinvoices');?>" class="dropdown-item <?php echo $class ?>"><?php echo lang("all") ?></a>
                <?php foreach ($this->settings_model->getRecurringStatus() as $status => $label): ?>
                    <?php $class = (isset($_GET['fv']) && $_GET['fv'] == $status)?"active":""; ?>
                    <a href="<?php echo site_url('/rinvoices?f=status&fv='.$status);?>" class="dropdown-item <?php echo $class ?>"><?php echo $label ?></a>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="btn-group download-list tip" title="<?php echo lang("tabletool_collection"); ?>" export-table="rinvoices_table">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i><span class="caret"></span></a>
        </div>
        <div class="btn-group columns-list tip" title="<?php echo lang("shown_columns"); ?>">
            <a class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i><span class="caret"></span></a>
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
</div>


<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
<?php endif ?>
				<table id="rinvoices_table" class="table table-sm table-hover serverSide checkable_datatable">
					<thead>
						<tr>
                            <th valign="middle" align="center" style="min-width: 16px;" class="pure-checkbox">
                                <input type="checkbox" id="select_all" name="select_all"/>
                                <label></label>
                            </th>
                            <th><?php echo lang("package_name"); ?></th>
							<th><?php echo lang("customer"); ?></th>
                            <th><?php echo lang("issued_on"); ?></th>
                            <th><?php echo lang("frequency"); ?></th>
                            <th style="text-align: center;"><?php echo lang("occurences"); ?></th>
                            <th style="text-align: center;"><?php echo lang("status"); ?></th>
                            <th><?php echo lang("next_billing_date"); ?></th>
                            <th style="text-align: center;"><?php echo lang("amount"); ?></th>
                            <th width="130" style="width:130px; text-align: end;"><?php echo lang("actions"); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
						</tr>
					</tbody>
				</table>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
            </div>
        </div>
    </div>
<?php endif ?>
<script type="text/javascript">
var rinvoices_table;
$(document).ready(function() {
    var filter, value;
    <?php
    if( isset($_GET["f"]) && isset($_GET["fv"])){
        echo "filter = '".$_GET['f']."';";
        echo "value = '".$_GET['fv']."';";
    }
    ?>
    rinvoices_table = $('#rinvoices_table').dataTable( {
        "oColVis": {
            "aiExclude": [0,1,9],
        },
        "aoColumnDefs": [{
            "bVisible": false,
            "aTargets": [] ,
        }],
        "aaSorting": [[ 1, "desc" ]],
        'bProcessing'    : true,
        'bServerSide'    : true,
        "bSortCellsTop"  : true,
        'sAjaxSource'    : SITE_URL+'/rinvoices/getdata',
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            if( filter != undefined && value != undefined ){
                aoData.push( { "name": "f", "value": filter } );
                aoData.push( { "name": "v", "value": value } );
            }
            <?php
            if( isset($biller_id)){
                echo 'aoData.push( { "name": "biller_id", "value": "'.$biller_id.'" } );';
            }
            ?>
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
            $.each($(this).find('a.biller_popover'), function(i, biller_popover){
                $(biller_popover).popover({
                    placement: 'bottom',
                    template: '<div class="popover"><div class="arrow"></div><div class="popover-content"></div></div>',
                    content:'<ul>'+
                    '<li class="dropdown-item"><a href="'+SITE_URL+'/billers/view?id='+$(biller_popover).data("bill_to_id")+'" class="text-inherit sis_modal" sis-modal="rinvoices_table"><i class="fa fa-expand"></i>'+globalLang["details"]+'</a></li>'+
                    '<li class="dropdown-item">'+filter_format('<i class="fa fa-filter"></i>'+globalLang["filter"], "fullname", $(biller_popover).data("value"), $(biller_popover).data("value"))+'</li>'+
                    '</ul>',
                    html:true,
                });
            });
            $(this).find('thead input[name="select_all"]').get(0).checked = false;
            $(this).find('thead input[name="select_all"]').get(0).indeterminate = false;
        },
        "aoColumns": [
            { "sName": 'id', "mDataProp": 'id', "mRender": checkboxFormat, "bSortable": false, "bSearchable": false},
            { "sName": 'name'     , "mDataProp": 'name'     , "mRender": title_format},
	        { "sName": 'fullname' , "mDataProp": 'fullname' , "mRender": biller_format},
            { "sName": 'date'     , "mDataProp": 'date'     , "mRender": date_format},
            { "sName": 'number'   , "mDataProp": 'number'   , "mRender": frequency_format},
            { "sName": 'occurence', "mDataProp": 'occurence', "mRender": occurence_format},
	        { "sName": 'status'   , "mDataProp": 'status'   , "mRender": status_format},
            { "sName": 'next_date', "mDataProp": 'next_date', "mRender": next_format},
            { "sName": 'amount'   , "mDataProp": 'amount'   , "mRender": Format_Currency},
	        { "bSortable": false, "mRender": actions_format, "bSearchable": false }
        ]
    });
<?php if (!isset($disable_headings) || !$disable_headings): ?>
    rinvoices_table.advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "text", bRegex:true },
            { type: "date-range"},
            null,
            null,
            { type: "select", values: <?php echo json_encode($status_list) ?> },
            { type: "date-range"},
            { type: "number" },
            null
        ]
    });
<?php endif ?>

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    rinvoices_table.on("select-count", function(e){
        var table = $(this);
        var select_count = table.data("select-count");
        if( select_count > 0 ){
            html = globalLang["selected"]+" <b>"+select_count+"</b> "+globalLang["rinvoice"+(select_count==1?"":"s")]+".";
            total = 0;
            var oSettings = rinvoices_table.fnSettings();
            for (var i = 0; i < oSettings.aoData.length; i++) {
                if( $(oSettings.aoData[i].nTr).is(".row_selected") ){
                    total += parseFloat(oSettings.aoData[i]._aData.amount);
                }
            }
            html += globalLang["total"]+" <b>"+Format_Currency(total, true)+"</b>";
            table.closest(".dataTables_wrapper").find('.select_area').html(html).show();
        }else{
            table.closest(".dataTables_wrapper").find('.select_area').hide();
        }
    });

    rinvoices_table.on("click", "a[href='#filter']", function(e){
        rinvoices_table.prev(".datatable_filter").remove();
        if( filter == $(this).data("filter") && value == $(this).data("value") ){
            filter = undefined;
            value = undefined;
            rinvoices_table._fnReDraw();
        }else{
            filter = $(this).data("filter");
            value = $(this).data("value");
            column = rinvoices_table.find('thead th:eq('+$(this).parents("td").index()+')').text();
            text = $(this).data("text");
            rinvoices_table._fnReDraw();
            $( "<div class='alert alert-info alert-sm datatable_filter'>"+
                '<button type="button" class="btn btn-sm btn-secondary pull-right flip" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i> '+globalLang["clear_filter"]+'</button>'+
                "<p><span>" +
                "<strong>"+ globalLang["filter"] + "</strong> " +
                column + " = " + text +
            "</span></p></div>" ).insertBefore(rinvoices_table);
        }

        e.preventDefault();
        return false;
    });

    $(document).on('closed', '.datatable_filter', function(){
        filter = undefined;
        value = undefined;
        rinvoices_table._fnReDraw();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        rinvoices_table._fnReDraw();
        return false;
    });

    $(document).on('click', '.delete_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_rows = {};
            $.each($(".checkable_datatable tr.row_selected .row_checkbox"), function(i, checkbox){
                selected_rows["id["+i+"]"] = $(checkbox).data("id");
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#rinvoices_table').load_ajax(SITE_URL+"/rinvoices/delete", 'POST', selected_rows);
            });
        }
        return false;
    });

    function actions_format(data, type, row, meta){
        actions = '<div class="btn-group">'+
                    '<a href="'+SITE_URL+"/rinvoices/open/"+row.id+'" class="btn btn-sm btn-secondary m-a-0" >'+
                        '<span>'+globalLang['details']+'</span>'+
                    '</a>'+
                    '<button data-toggle="dropdown" class="dropdown-toggle btn btn-sm btn-secondary" aria-expanded="true">'+
                        '<span><i class="icon-settings"></i></span>'+
                    '</button>'+
                    '<ul class="dropdown-menu dropdown-menu-right">';

        actions += $('#rinvoices_table').create_datatable_action("eye", SITE_URL+"/rinvoices/open/"+row.id, globalLang['details'], false);

        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        actions += $('#rinvoices_table').create_datatable_action("trash", SITE_URL+"/rinvoices/delete/"+row.id, globalLang['delete'], false, true, false, true);
        if( row.status != "canceled" ){
            actions += $('#rinvoices_table').create_datatable_action("pencil", SITE_URL+"/rinvoices/edit/"+row.id, globalLang['edit'], false);
        }
        actions += $('#rinvoices_table').create_datatable_action("copy", SITE_URL+"/rinvoices/duplicate/"+row.id, globalLang['duplicate'], false, true, false, true);

        actions += '<li class="dropdown-divider" ></li>';
        <?php endif ?>

        if( row.status == 'panding' ){
            actions += $('#rinvoices_table').create_datatable_action("play", SITE_URL+"/rinvoices/profile/start/"+row.id, globalLang['start_profile'], false, false, false, true);
        }else if( row.status == 'active' ){
            actions += $('#rinvoices_table').create_datatable_action("times-circle", SITE_URL+"/rinvoices/profile/cancel/"+row.id, globalLang['cancel_profile'], false, true, false, true);
            actions += $('#rinvoices_table').create_datatable_action("forward", SITE_URL+"/rinvoices/profile/skip/"+row.id, globalLang['skip_next_invoice'], false, true, false, true);
        }

        <?php if ($this->ion_auth->is_admin()): ?>
        actions += $('#rinvoices_table').create_datatable_action("history", SITE_URL+"/rinvoices/activities?id="+row.id, globalLang['activities'], false, false, true);
        <?php endif ?>
        actions += '</ul></div>';
        return "<center>"+actions+"</center>";
    }

    function status_format(x, y ,row) {
        var status = x;
        if( x == "panding" ){
            status = "<span class='label label-tall label-info label-recurring'><i class='fa fa-retweet'></i>"+globalLang[x]+"</span>";
        }
        if( x == "active" ){
            status = "<span class='label label-tall label-warning label-recurring'><i class='fa fa-retweet'></i>"+globalLang[x]+"</span>";
        }
        if( x == "canceled" ){
            status = "<span class='label label-tall label-default label-recurring'><i class='fa fa-retweet'></i>"+globalLang[x]+"</span>";
        }
        if( x == "finished" ){
            status = "<span class='label label-tall label-success label-recurring'><i class='fa fa-retweet'></i>"+globalLang[x]+"</span>";
        }
        return "<center>"+filter_format(status, "status", x, globalLang[x])+"</center>";
    }

    function biller_format(value, y ,row) {
        var html = "<a class='text-inherit biller_popover' data-toggle='popover' data-bill_to_id='"+row.bill_to_id+"' data-value='"+value+"' ><small>"+value+"</small></a>";
        return  html;
    }

    function title_format(value) {
        var html = "<small>"+value+"</small>";
        return  filter_format(html, "name", value, value);
    }

    function occurence_format(value, y ,row) {
        return "<center><small>"+row.count_items+" / "+((value=="0")?"&infin;":value)+"</small></center>";
    }

    function next_format(value, y, row) {
        if( row.status == "finished" || row.status == "canceled" ){
            return "";
        }
        next = moment(value, "YYYY-MM-DD");
        today = moment("<?php echo date("Y-m-d") ?>", "YYYY-MM-DD");
        diff = next.diff(today, "days");
        if( diff == 0 ){
            rest = globalLang["today"];
        }else if( diff == 1 ){
            rest = diff+" "+globalLang["day"];
        }else{
            rest = diff+" "+globalLang["days"];
        }
        return  "<small>"+next.format(JS_DATE)+" ("+rest+")</small>";
    }

    var every_list = <?php echo json_encode($this->settings_model->getRecurringEvery()) ?>;
    function frequency_format(value, y ,row) {
        return "<small>"+globalLang["every"]+" <b>"+every_list[row.frequency][value]+"</b></small>";
    }

    function date_format(value) {
        var html = "<small>"+Format_Date(value)+"</small>";
        return  filter_format(html, "date", value, Format_Date(value));
    }
});
</script>
