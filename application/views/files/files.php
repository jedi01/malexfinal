<?php if ($selectable): ?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php endif ?>
<link href="<?php echo base_url("assets/vendor/fileuploader/jquery.fileuploader.css") ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url("assets/vendor/fileuploader/jquery.fileuploader-theme-dragdrop.css") ?>" rel="stylesheet" type="text/css">
<style type="text/css">
<?php if ($selectable): ?>
.filemanager .folders{
    height: 350px;
}
<?php endif ?>
.fileuploader-theme-dragdrop .fileuploader-input {
    display: none;
}
.dropdown-item:hover {
    font-weight: bold;
    background-color: #e6e0e0;
}
</style>
<?php if ($selectable): ?>
<table id="files_table" class="table table-sm table-hover serverSide" style="display: none;">
    <thead>
        <tr>
            <th><?php echo lang("n°"); ?></th>
            <th><?php echo lang("filename"); ?></th>
            <th><?php echo lang("size"); ?></th>
            <th><?php echo lang("file_type"); ?></th>
            <th><?php echo lang("upload_date"); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
        </tr>
    </tbody>
</table>
<input type="file" name="userfile" id="dropfile" tabindex="2" />
<?php else: ?>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
                <table id="files_table" class="table table-sm table-hover serverSide" style="display: none;">
                    <thead>
                        <tr>
                            <th><?php echo lang("n°"); ?></th>
                            <th><?php echo lang("filename"); ?></th>
                            <th><?php echo lang("size"); ?></th>
                            <th><?php echo lang("file_type"); ?></th>
                            <th><?php echo lang("upload_date"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="15" class="dataTables_empty"><?php echo lang('loading_data'); ?></td>
                        </tr>
                    </tbody>
                </table>
                <input type="file" name="userfile" id="dropfile" tabindex="2" />
            </div>
        </div>
    </div>
<?php endif ?>
<div style="display: none;">
    <div class="filemanager-config" style="margin-bottom: .5rem;">
        <button title="<?php echo lang("tabletool_select_all"); ?>" class="btn <?=$small_view?"btn-sm":"" ?> select_all btn-secondary tip"><i class="icon-check"></i></button>
        <div class="btn-group">

            <button title="<?php echo lang("gohome"); ?>" class="btn <?=$small_view?"btn-sm":"" ?> home btn-secondary tip"><i class="icon-home"></i></button>
            <button title="<?php echo lang("open_trash"); ?>" class="btn <?=$small_view?"btn-sm":"" ?> open_trash btn-secondary tip"><i class="icon-trash"></i></button>
            <button title="<?php echo lang("goback"); ?>" class="btn <?=$small_view?"btn-sm":"" ?> back btn-secondary tip"><i class="icon-arrow-left"></i></button>
            <button title="<?php echo lang("refresh"); ?>" class="btn <?=$small_view?"btn-sm":"" ?> refresh btn-secondary tip"><i class="icon-refresh"></i></button>
        </div>

        <div class="btn-group tip" title="<?php echo lang("sort"); ?>">
            <button class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary dropdown-toggle tip" data-toggle="dropdown"><i class="fa fa-sort-alpha-asc"></i></button>
            <ul class="dropdown-menu sort" role="menu">
                <li class="dropdown-item" data-column="2"><i class="fa fa-desc"></i> <?php echo lang("filename"); ?></li>
                <li class="dropdown-item" data-column="3"><i class="fa"></i> <?php echo lang("size"); ?></li>
                <li class="dropdown-item" data-column="4"><i class="fa"></i> <?php echo lang("file_type"); ?></li>
                <li class="dropdown-item" data-column="5"><i class="fa"></i> <?php echo lang("upload_date"); ?></li>
            </ul>
        </div>
        <div class="btn-group view" data-toggle="buttons-radio">
            <button class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary tip active" value="grid" title="<?php echo lang("grid"); ?>"><i class="fa fa-th"></i></button>
            <button class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary tip" value="list" title="<?php echo lang("list"); ?>"><i class="fa fa-list"></i></button>
        </div>
        <button class="btn <?=$small_view?"btn-sm":"" ?> btn-success tip show_uploader" title="<?php echo lang("upload"); ?>"><i class="fa fa-upload"></i></button>

        <button class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary tip disabled btn-select-file multi files_download_selected" title="<?php echo lang("tabletool_collection") ?>"><i class="fa fa-download"></i></button>
    </div>
        <div class="filemanager-config-right" style="margin-bottom: .5rem;">
            <a href="<?php echo site_url('/files/create_folder');?>" class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary sis_modal tip create_folder" sis-modal="files_table" title="<?php echo lang("create_folder"); ?>"> <i class="fa fa-folder"></i></a>
            <div id="actions-list" class="btn-group tip" title="<?php echo lang("actions"); ?>">
                <a class="btn <?=$small_view?"btn-sm":"" ?> btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="icon-link"></i><span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item disabled btn-select-folder folder_open_selected"><i class="fa fa-folder-open"></i><small><?php echo lang("open") ?></small></li>
                    <li class="dropdown-item disabled btn-select-file multi files_preview_selected"><i class="fa fa-eye"></i><small><?php echo lang("preview") ?></small></li>
                    <li class="dropdown-item disabled btn-select-file multi files_share_selected"><i class="fa fa-share-alt"></i><small><?php echo lang("share") ?></small></li>
                    <li class="dropdown-item disabled btn-select-file multi files_copylink_selected" data-clipboard-text="holly"><i class="fa fa-link"></i><small><?php echo lang("copylink") ?></small></li>
                    <li class="dropdown-item disabled btn-select-both multi files_moveto_selected"><i class="fa fa-arrows"></i><small><?php echo lang("move_to") ?></small></li>
                    <li class="dropdown-item disabled btn-select-both files_rename_selected"><i class="fa fa-pencil"></i><small><?php echo lang("rename") ?></small></li>
                    <li class="dropdown-item disabled btn-select-file multi files_download_selected"><i class="fa fa-download"></i><small><?php echo lang("tabletool_collection") ?></small></li>
                    <li class="dropdown-item disabled btn-select-both multi files_trash_selected"><i class="fa fa-trash"></i><small><?php echo lang("delete") ?></small></li>
                    <li class="dropdown-item disabled trash-only btn-select-both multi files_delete_selected" style="display: none;"><i class="fa fa-trash"></i><small><?php echo lang("delete_definitive") ?></small></li>
                    <li class="dropdown-item disabled trash-only btn-select-both multi files_restore_selected" style="display: none;"><i class="fa fa-undo"></i><small><?php echo lang("restore_file") ?></small></li>
                </ul>
            </div>
        </div>
    <div class="filemanager-disc-usage">
        <div class="clearfix">
            <div class="pull-left">
                <small class="text-muted size">2 GB / 8 GB</small>
            </div>
            <div class="pull-right">
                <small class="text-muted percent">20%</small>
            </div>
        </div>
        <progress class="progress progress-xs" value="20" max="100" style="margin:5px 0 0 0;">20%</progress>
    </div>
    <div class="filemanager">
        <ul class="folders <?=$small_view?"folders-sm":"" ?>">
        </ul>
        <div class="clearfix"></div>
    </div>
</div>

<?php if ($selectable): ?>
<div class="text-md-right m-t-1">
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <button type="button" class="btn btn-primary btn-select-file multi files_select disabled" disabled="disabled" tabindex="1"><?php echo lang("select") ?></button>
</div>
<script type="text/javascript">
    $(".files_select").click(function(){
        var selected_items = [];
        $.each($('.folders .item.selected'), function(i, item){
            selected_items[i] = files_list[$(item).data("id")];
        });
        $(this).closest('.modal').trigger("sis-callback", [selected_items]);
    });
</script>
<?php endif ?>
<script src="<?php echo base_url("assets/vendor/jquery-datatable/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendor/jquery-datatable/js/DT_bootstrap.js") ?>"></script>
<script src="<?php echo base_url("assets/vendor/jquery-datatable/js/dataTables.advancedSearch.js") ?>"></script>
<script src="<?php echo base_url("assets/vendor/fileuploader/jquery.fileuploader.min.js") ?>"></script>
<script type="text/javascript">
var current_folder = "", uploader_api, sort_column = 2, sort_orient = "desc", files_table, files_list = {};
function setCurrentFolder(folder){
    current_folder = folder;
    $('.create_folder').attr('href', '<?php echo site_url("files/create_folder") ?>?folder='+current_folder);
    uploader_api.getOptions().upload.url = '<?php echo site_url("files/upload") ?>?folder='+current_folder;
    if( folder == "THIS_IS_TRASH_FOLDER" ){
        $('#actions-list li, #contextmenu li').hide().closest("ul").find('.trash-only').show();
    }else{
        $('#actions-list li, #contextmenu li').show().closest("ul").find('.trash-only').hide();
    }
}
<?php if (!$selectable): ?>
$(document).ready(function() {
<?php endif ?>
    var input = $('#dropfile').fileuploader({
        limit:<?php echo $files_settings->max_simult_uploads; ?>,
        inputNameBrackets: false,
        maxSize: <?php echo $files_settings->max_upload_size; ?>,
        extensions: <?php echo json_encode(explode(",", $files_settings->white_list)); ?>,
        enableApi: true,
        theme: 'dragdrop',

        changeInput: '<div class="fileuploader-input">' +
                          '<button type="button" class="btn btn-primary btn-sm btn-close hide_uploader">&times;</button>'+
                          '<div class="fileuploader-input-inner">' +
                              '<img src="'+BASE_URL+'assets/img/fileuploader-dragdrop-icon.png">' +
                              '<h3 class="fileuploader-input-caption"><span>'+globalLang["drag_drop_file"]+'</span></h3>' +
                              '<p>'+globalLang['or']+'</p>' +
                              '<div class="fileuploader-input-button"><span>'+globalLang["browse_files"]+'</span></div>' +
                          '</div>' +
                      '</div>',
        thumbnails: {
            item: '<li class="fileuploader-item">'+
                '<span class="icon">${icon}</span> '+
                '<b>${name}</b> '+
                '(<i>${size2}</i>)'+
                '<span class="quickMenu">'+
                    '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>'+
                    '<a class="fileuploader-action fileuploader-action-start" title="${captions.start}"><i></i></a>'+
                '</span>'+
                '<div class="progress-bar2">${progressBar}<span></span></div>'+
            '</li>'
        },
        upload: {
            url: '<?php echo site_url("files/upload") ?>?folder='+current_folder,
            data: CSRF_DATA,
            type: 'POST',
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            start: true,
            synchron: true,
            onError: function(item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {
                var progressBar = item.html.find('.progress-bar2');

                if(progressBar.length > 0) {
                    progressBar.find('span').html(0 + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                    item.html.find('.progress-bar2').fadeOut(400);
                }

                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                ) : null;
            },
            onProgress: function(data, item, listEl, parentEl, newInputEl, inputEl) {
                var progressBar = item.html.find('.progress-bar2');

                if(progressBar.length > 0) {
                    progressBar.show();
                    progressBar.find('span').html(data.percentage + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                }
            },
            onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
                result = JSON.parse(jqXHR.responseText);
                if( result.status == "error" ){
                    toastr.error(result.message);
                }else{
                    files_table._fnReDraw();
                }
                //uploader_api.reset();
            },
        },
        captions: {
            button: function(options) { return globalLang['choose']+' ' + (options.limit == 1 ? globalLang['file'] : globalLang['files']); },
            feedback: function(options) { return globalLang['choose']+' ' + (options.limit == 1 ? globalLang['file'] : globalLang['files']) + ' '+globalLang['to_upload']; },
            feedback2: function(options) { return options.length + ' ' + (options.length > 1 ? globalLang['files_were'] : globalLang['file_was']) + ' '+globalLang['chosen']; },
            confirm: globalLang['confirm'],
            cancel: globalLang['cancel'],
            name: globalLang['filename'],
            type: globalLang['file_type'],
            size: globalLang['size'],
            dimensions: globalLang['dimensions'],
            duration: globalLang['duration'],
            crop: globalLang['crop'],
            rotate: globalLang['rotate'],
            close: globalLang['close'],
            download: globalLang['download'],
            remove: globalLang['remove'],
            drop: globalLang['drop_file'],
            paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> '+globalLang['paste_file'],
            removeConfirmation: globalLang["remove_confirmation"],
            errors: {
                filesLimit: globalLang["filesLimit"].replace("%s", "${limit}"),
                filesType: globalLang["filesType"].replace("%s", "${extensions}"),
                fileSize: "${name} "+globalLang["fileSize"].replace("%s", "${fileMaxSize}"),
                filesSizeAll: globalLang["filesSizeAll"].replace("%s", "${maxSize}"),
                fileName: globalLang["fileName"].replace("%s", "${name}") ,
                folderUpload: globalLang["folderUpload"]
            }
        }
    });
    // get uploader_api methods
    uploader_api = $.fileuploader.getInstance(input);

    var filter, value;
    files_table = $('#files_table').dataTable( {
        "sDom": 'R<"row m-a-0"<"col-md-6 p-a-0 folder-config"><"col-md-6 p-a-0 text-md-right folder-right-config inline-content"f>r><"row m-a-0"<"filemanager-p"<"clearfix">>><"row"<"col-md-5"i><"col-md-2"><"col-md-5 disc-usage">><"clear">',
        "iDisplayLength": -1,
        "aaSorting": [],
        'bProcessing'    : true,
        'bServerSide'    : true,
        'sAjaxSource'    : SITE_URL+'/files/getdata',
        'oClasses':{
            'sFilterInput'   : 'form-control <?=$small_view?"form-control-sm":"" ?>',
        },
        'fnServerData': function(sSource, aoData, fnCallback)
        {
            aoData.push( { "name": CSRF_NAME, "value": CSRF_HASH } );
            aoData.push( { "name": "current_folder", "value": current_folder } );
            aoData.push( { "name": "iSortCol_0", "value": sort_column } );
            aoData.push( { "name": "sSortDir_0", "value": sort_orient } );
            $.ajax
            ({
                'dataType': 'json',
                'type'    : 'POST',
                'url'     : sSource,
                'data'    : aoData,
                'success' : fnCallback,
                'complete' : function(data){
                    json = data.responseJSON;
                    disc_usage = ((json.fullsize*1024)*100)/json.maxsize;
                    disc_usage = disc_usage.toFixed(2);
                    $(".filemanager-disc-usage small.size").text(Format_size(json.fullsize*1024)+" / "+Format_size(json.maxsize));
                    $(".filemanager-disc-usage small.percent").text(disc_usage+"%");
                    $(".filemanager-disc-usage .progress").val(disc_usage);
                    if( disc_usage < 20 ){
                        $(".filemanager-disc-usage .progress").attr("class","progress progress-xs progress-success");
                    }else if( disc_usage < 45 ){
                        $(".filemanager-disc-usage .progress").attr("class","progress progress-xs progress-info");
                    }else if( disc_usage < 75 ){
                        $(".filemanager-disc-usage .progress").attr("class","progress progress-xs progress-warning");
                    }else{
                        $(".filemanager-disc-usage .progress").attr("class","progress progress-xs progress-danger");
                    }
                },
            });
        },
        fnInitComplete: function(oSettings, json) {
            $('.filemanager-p').append($('.filemanager'));
            $('.folder-config').append($('.filemanager-config'));
            $('.folder-right-config').append($('.filemanager-config-right'));
            $('.disc-usage').append($('.filemanager-disc-usage'));

            <?php if (!$selectable): ?>
            if( isMobile() ){
                var actions = $('<nav class="quick-nav"></nav>');
                $(actions).append('<a class="quick-nav-trigger" href="#0"><span aria-hidden="true"></span></a>');
                $(actions).append('<ul></ul>');
                $(actions).append('<span aria-hidden="true" class="quick-nav-bg"></span>');
                $.each($(".folder-config .filemanager-config > *"), function(i, item){
                    var title = $(item).data("original-title");
                    var icon = $(item).find("i");
                    var is_button = $(item).is("button");

                    if( is_button ){
                        item = $('<a class="'+$(item).attr("class")+'"></a>');
                        $(item).removeClass("btn btn-sm btn-secondary btn-success tip");
                        $(item).append('<span>'+title+'</span>');
                        $(item).append(icon);
                        var li = $('<li></li>');
                        $(item).appendTo(li);
                        $(li).appendTo($(actions).find("ul"));
                    }else if( $(item).is(".view") ){
                        $(item).appendTo('.folder-right-config .filemanager-config-right');
                    }else if( !is_button && title == undefined ){
                        $.each($(item).children(), function(i, child){
                            var child_title = $(child).data("original-title");
                            var child_icon = $(child).find("i");
                            child = $('<a class="'+$(child).attr("class")+'"></a>');
                            $(child).removeClass("btn btn-sm btn-secondary btn-success tip");
                            $(child).append('<span>'+child_title+'</span>');
                            $(child).append(child_icon);
                            var li = $('<li></li>');
                            $(child).appendTo(li);
                            $(li).appendTo($(actions).find("ul"));
                        });
                    }else{
                        $(item).appendTo('.folder-right-config .filemanager-config-right');
                    }
                });
                $(actions).appendTo('body');
                $(".filemanager-config").remove();
                $(".container-fluid > .col-md-12").addClass("p-a-0");
                $(".container-fluid > .col-md-12 > .card").addClass("m-a-0");
                $(".container-fluid > .col-md-12 > .card > .card-block").addClass("p-a-h");

                p = $(".container-fluid").innerHeight() - $("#files_table_wrapper").height();
                r = $("#files_table_wrapper .row:eq(0)").height() + $("#files_table_wrapper .row:eq(2)").height();
                h = $(document).height() - $(".navbar-mainmenu").height();
                $(".filemanager .folders.folders-sm").css({"height":(h - (r + p))+"px"});
            }
            <?php endif ?>

            $('.sort li[data-column="'+sort_column+'"]').addClass("active");
            $('.sort li[data-column="'+sort_column+'"] i').removeClass("fa-sort-asc").addClass("fa-sort-"+sort_orient);

            <?php if ($selectable): ?>
                $('.folder-config').closest(".row").css({"padding-bottom":"5px"});
                $('#files_table_info').closest(".row").hide();
            <?php endif ?>

            $(document).on("click", '.back', function(){
                setCurrentFolder(current_folder.substring(0, current_folder.lastIndexOf("/")));
                files_table._fnReDraw();
                return false;
            });
            $(document).on("click", '.home', function(){
                setCurrentFolder("");
                files_table._fnReDraw();
                return false;
            });
            $(document).on("click", '.open_trash', function(){
                setCurrentFolder("THIS_IS_TRASH_FOLDER");
                files_table._fnReDraw();
                return false;
            });
            $(document).on("click", '.select_all', function(){
                $('.folders .item').removeClass("selected");
                $.each($('.folders .item'), function(i, item){
                    setItemSelected(item, true);
                });
                return false;
            });
            $(document).on("click", '.refresh', function(){
                files_table._fnReDraw();
                return false;
            });

            $(document).on("click", '.view button', function(){
                $('.view button').removeClass("active");
                $(this).addClass("active");
                if( $(this).val() == "grid" ){
                    $('.filemanager').removeClass('listview');
                }else{
                    $('.filemanager').addClass('listview');
                }
                return false;
            });

            $(document).on("click", '.sort li', function(){
                column = parseInt($(this).data("column"));
                if( sort_column == column ){
                    sort_orient = ( sort_orient == "desc" )?"asc":"desc";
                }else{
                    sort_orient = "desc";
                }
                sort_column = column;
                files_table._fnReDraw();
                $('#files_table_wrapper .sort li').removeClass("active");
                $('#files_table_wrapper .sort li i').removeClass("fa-sort-asc fa-sort-desc");
                $(this).addClass("active").find('i').addClass("fa-sort-"+sort_orient);
                return false;
            });

            $('#data-table').hide();
        },
        fnPreDrawCallback: function(oSettings){
            $('.btn-select-file').addClass("disabled").attr("disabled", "disabled");
            $('.btn-select-folder').addClass("disabled").attr("disabled", "disabled");
            $('.btn-select-both').addClass("disabled").attr("disabled", "disabled");
            $('.folders .item').remove();
            files_list = {};
            $.each(oSettings.aoData, function(i, data){
                var file = data._aData;
                files_list[file.id] = file;
                if( file.folder == current_folder ){
                    if( file.type == "folder" ){
                        item = $('<li class="item folder vide" title="'+file.filename+'" href="#" data-content="'+current_folder+"/"+file.filename+'" data-link="'+file.link+'" data-id="'+file.id+'">'+
                                    '<i class="icon"></i>'+
                                    '<span class="filename">'+file.filename+'</span>'+
                                    '<span class="filesize">Folder</span>'+
                                    '<span class="filetype">'+file.type+'</span>'+
                                    '<span class="filedate">'+Format_Datetime(file.date_upload)+'</span>'+
                                '</li>');
                        item.appendTo($('.folders'));
                    }
                }
            });
            $.each(oSettings.aoData, function(i, data){
                var file = data._aData;
                if( file.folder == current_folder ){
                    if( file.type != "folder" ){
                        thumbnail = "";
                        if( file.thumb != undefined && file.thumb != "" ){
                            thumbnail = '<i class="thumbnail"><img src="'+SITE_URL+'/files/thumbnail/'+file.link+'"></i>';
                        }else{
                            thumbnail = '<i class="icon"></i>';
                        }
                        item = $('<li class="item file '+file.extension.substring(1)+'" title="'+file.filename+file.extension+'" href="#" data-link="'+file.link+'" data-id="'+file.id+'">'+
                                    thumbnail+
                                    '<span class="filename">'+file.filename+file.extension+'</span>'+
                                    '<span class="filesize">'+Format_size(file.size*1024)+'</span>'+
                                    '<span class="filetype">'+file.type+'</span>'+
                                    '<span class="filedate">'+Format_Datetime(file.date_upload)+'</span>'+
                                '</li>');
                        item.appendTo($('.folders'));
                    }
                }
            });

            $('.folders .item').on("click", function(ev){
                setItemSelected(this, ev.ctrlKey);
            })
            .on("dblclick", function(){
                if( current_folder == "THIS_IS_TRASH_FOLDER" ){
                    return false;
                }
                <?php if ($selectable): ?>
                var selected_items = [];
                $.each($('.folders .item.selected'), function(i, item){
                    selected_items[i] = files_list[$(item).data("id")];
                });
                $(this).closest('.modal').trigger("sis-callback", [selected_items]);
                return false;
                <?php else: ?>
                if( $(this).is(".folder") ){
                    setCurrentFolder($(this).attr('data-content'));
                    if( current_folder.startsWith("/") ){
                        setCurrentFolder(current_folder.substring(1));
                    }
                    files_table._fnReDraw();
                }else{
                    link = $(this).attr('data-link');
                    $("#files_table").sis_modal({url: SITE_URL+"/files/preview/"+link, "is_big": true});
                }
                return false;
                <?php endif ?>
            });

            if( current_folder == "" ){
                $('.back').attr('disabled', 'disabled');
            }else{
                $('.back').removeAttr('disabled');
            }


            $(".folders .item").bind("contextmenu",function(e){
                return false;
            });

            $(".folders .item").bind("contextmenu",function(e){
                if( !$(this).is(".selected") )
                    setItemSelected(this, e.ctrlKey);
                x = e.pageX; y = e.pageY;
                bodyW = $(document).width(); bodyH = $(document).height();
                contextW = $('#contextmenu').width(); contextH = $('#contextmenu').height();
                if( x+contextW > bodyW ){
                    x = bodyW-contextW-10;
                }

                if( x+contextW+200 > bodyW ){
                    $('#contextmenu').find('.dropdown-submenu').addClass('pull-right');
                }else{
                    $('#contextmenu').find('.dropdown-submenu').removeClass('pull-right');
                }

                if( y+contextH > bodyH ){
                    y = bodyH-contextH-20;
                }
                $('#contextmenu').css({
                    'top': y,
                    'left': x,
                    'right': 'inherit',
                    'position': 'absolute',
                    'z-index': '9999',
                    'max-width': '130px'
                }).show();
                return false;
            });

            $(".folders .item").draggable({
                revert: true,
                helper: "clone",
                start: function(ev, ui) {
                    if( !$(this).is(".selected") )
                        setItemSelected(this, false);
                    $(ui.helper).css({"opacity": 0.5});
                    if( $('.folders .item.selected').size() > 2 ){
                        $(ui.helper).html("");
                        $(ui.helper).find("*").remove();
                        $(ui.helper).addClass('item-cloner').removeClass("selected item");
                        offset = 0;
                        $.each($('.folders .item.selected'), function(i, item){
                            offset = i*4;
                            $(item).clone().appendTo($(ui.helper)).css({"left": (offset)+"px", "top": (offset)+"px"}).addClass("item-cloned");
                        });
                        $(this).clone().appendTo($(ui.helper)).css({"left": (offset)+"px", "top": (offset)+"px"}).addClass("item-cloned");
                    }else{
                        $(ui.helper).addClass("item-cloned");
                    }
                },
                drag: function(ev, ui) {
                }
            }).droppable({
                accept: ".folders .item",
                classes: {
                    "ui-droppable-hover": "hover"
                },
                drop: function( event, ui ) {
                    if( $(this).is(".folder") ){
                        to_folder = $(this).attr('data-content');
                        if( to_folder.startsWith("/") ){
                            to_folder = to_folder.substring(1);
                        }
                        var selected_items = [];
                        $.each($('.folders .item.selected:not(.item-cloned)'), function(i, item){
                            selected_items[i] = $(item).data("id");
                        });
                        data = {"id":selected_items, "to_folder":to_folder};
                        bconfirm(globalLang['alert_confirmation'], function(){
                            $('#files_table').load_ajax(SITE_URL+"/files/move_to/", 'POST', data);
                        });
                    }
                }
            });
            $( ".folders" ).selectable({
                classes: {
                    "ui-selecting": "hover",
                    "ui-selected": "selected"
                },
                filter: "li",
                selected: function( event, ui ) {
                    refreshItemSelection();
                }
            });
        },
        "aoColumns": [
            { "mDataProp": 'id',         },
            { "mDataProp": 'filename',   },
            { "mDataProp": 'size',       },
            { "mDataProp": 'type',       },
            { "mDataProp": 'date_upload',},
        ]
    }).advancedSearch({
        aoColumns:[
            null,
            { type: "text", bRegex:true },
            { type: "number", bRegex:true },
            { type: "number", bRegex:true },
            { type: "date-range"},
        ]
    });

    $('.columns-list').on("click", "ul", function(e){
        e.stopPropagation();
    });

    $('a[href="#refresh-list"]').bind('click', function() {
        files_table._fnReDraw();
        return false;
    });

    function setItemSelected(item, ctrlKey){
        if( !ctrlKey )
            $('.folders .item').removeClass("selected");
        if( ctrlKey && $('.folders .item.selected').size() > 1 && $(item).is(".selected") ){
            $(item).removeClass("selected ui-selected");
        }else{
            $(item).addClass("selected ui-selected");
        }
        refreshItemSelection();
    }

    function refreshItemSelection(){
        $('.btn-select-file').addClass("disabled").attr("disabled", "disabled");
        $('.btn-select-folder').addClass("disabled").attr("disabled", "disabled");
        $('.btn-select-both').addClass("disabled").attr("disabled", "disabled");
        items_count = $('.folders .item.selected').size();
        files_count = $('.folders .item.file.selected').size();
        folders_count = $('.folders .item.folder.selected').size();

        if( items_count == 1 ){
            if( files_count == 1 ){
                $('.btn-select-file,.btn-select-both').removeClass("disabled").removeAttr("disabled");
            }else{
                $('.btn-select-folder,.btn-select-both').removeClass("disabled").removeAttr("disabled");
            }
        }else{
            if( items_count == files_count ){ // all item are files
                $('.btn-select-file.multi,.btn-select-both.multi').removeClass("disabled").removeAttr("disabled");
            }else if( items_count == folders_count ){ // all item are files
                $('.btn-select-folder.multi,.btn-select-both.multi').removeClass("disabled").removeAttr("disabled");
            }else{
                $('.btn-select-both.multi').removeClass("disabled").removeAttr("disabled");
            }
        }
    }

    var contextmenu = $('.filemanager-config-right #actions-list ul').clone();
    $(contextmenu).attr("id", "contextmenu").appendTo("body");

    $(document).on("click", '.quick-nav-trigger', function(){
        $(".quick-nav").toggleClass("nav-is-visible");
    });

    $(document).bind("mouseup",function(e){
        $('#contextmenu').hide();
    });

    $(document).on('click', '.show_uploader', function() {
        $('.fileuploader-input').show();
        uploader_api.reset();
        return false;
    });

    $('.hide_uploader').bind('click', function() {
        $('.fileuploader-input').hide();
        uploader_api.reset();
        return false;
    });

    $('.files_trash_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            id = $('.folders .item.selected').data('id');
            var selected_items = [];
            selected_items['id[]'] = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items['id[]'].push($(item).data("id"));
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#files_table').load_ajax(SITE_URL+"/files/delete", 'POST', selected_items);
            });
        }
        return false;
    });

    $('.files_restore_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            id = $('.folders .item.selected').data('id');
            var selected_items = [];
            selected_items['id[]'] = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items['id[]'].push($(item).data("id"));
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#files_table').load_ajax(SITE_URL+"/files/restore", 'POST', selected_items);
            });
        }
        return false;
    });

    $('.folder_open_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            setCurrentFolder($('.folders .item.selected').attr('data-content'));
            if( current_folder.startsWith("/") ){
                setCurrentFolder(current_folder.substring(1));
            }
            files_table._fnReDraw();
        }
        return false;
    });

    $('.files_delete_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            id = $('.folders .item.selected').data('id');
            var selected_items = [];
            selected_items['id[]'] = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items['id[]'].push($(item).data("id"));
            });
            bconfirm(globalLang['alert_confirmation'], function(){
                $('#files_table').load_ajax(SITE_URL+"/files/delete_definitive", 'POST', selected_items);
            });
        }
        return false;
    });

    $('.files_preview_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            var selected_items = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items[i] = $(item).data("link");
            });
            link = selected_items.join(",");
            $("#files_table").sis_modal({url: SITE_URL+"/files/preview/"+link, "is_big": true});
        }
        return false;
    });

    $('.files_rename_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            link = $('.folders .item.selected').data('link');
            $("#files_table").sis_modal({url: SITE_URL+"/files/rename/"+link});
        }
        return false;
    });

    $('.files_moveto_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            var selected_items = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items[i] = $(item).data("id");
            });
            link = selected_items.join(",");
            $("#files_table").sis_modal({url: SITE_URL+"/files/move_to?files="+link});
        }
        return false;
    });

    $('.files_share_selected').on('click', function() {
        if( !$(this).is('.disabled') ){
            var selected_items = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items[i] = $(item).data("link");
            });
            link = selected_items.join(",");
            $("#files_table").sis_modal({url: SITE_URL+"/files/share/"+link});
        }
        return false;
    });

    $('.files_copylink_selected').click(function() {
        if( !$(this).is('.disabled') ){
            var selected_items = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items[i] = $(item).data("link");
            });
            link = selected_items.join(",");
            link = SITE_URL+"/files/view/"+link;
            copy_text(link);
        }
        return false;
    });

    $(document).on('click', '.files_download_selected', function() {
        if( !$(this).is('.disabled') ){
            var selected_items = [];
            $.each($('.folders .item.selected'), function(i, item){
                selected_items[i] = $(item).data("link");
            });
            link = selected_items.join(",");
            location.href = SITE_URL+"/files/download/"+link;
        }
        return false;
    });


<?php if (!$selectable): ?>
});
<?php endif ?>
</script>

