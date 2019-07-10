<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<div class="row bs-wizard step-count-4">
	<div class="col-xs-3 bs-wizard-step active"><!-- active -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_upload_file') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step disabled"><!-- disabled -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_match_fields') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step disabled"><!-- disabled -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_confirm_data') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step disabled"><!-- disabled -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_add_to_database') ?></div>
	</div>
</div>
<?php echo form_open("import_data/match_fields?section=".$section, array('class' => 'form-horizontal'));?>
<h4 class="font-weight-bold"><?php echo lang("idata_checklist"); ?></h4>
<p class="font-xs"><?php echo lang("idata_info"); ?></p>
<ul class="fields_list clearfix">
<?php
    foreach ($fields as $field_code => $field_info) {
        echo "<li><span class='".($field_info[1]?"key":"")."'>".lang($field_info[0])."</span></li>";
    }
?>
</ul>
<br>
<ul class="font-xs">
    <li><?php echo lang("idata_download_sample_file"); ?> (<a href="<?php echo $this->config->site_url('import_data/getSample/'.$section); ?>"><?php echo lang('idata_download_sample') ?></a>)</li>
</ul>
<div class="form-group row">
	<label class="form-control-label col-md-3" for="csv_delimiter"><?php echo lang("idata_csv_delimiter"); ?></label>
	<div class="col-md-6">
		<?php
			$csv_delimiters = array(
				"S" => lang('idata_semicolon'),
				"C" => lang('idata_comma'),
				"T" => lang('idata_tab'),
			);
			echo form_dropdown('csv_delimiter', $csv_delimiters, 'C', 'id="csv_delimiter" tabindex="1" class="form-control"');
		?>
	</div>
</div>
<div class="form-group row">
	<label class="form-control-label required col-md-3" for="csv_file"><?php echo lang("idata_file"); ?></label>
	<div class="col-md-9">
		<input type="file" name="userfile" id="csv_file" tabindex="2" />
		<small class="text-help"><?php echo lang('idata_max_file_size') ?></small><br />
        <small class="text-help"><?php echo lang("idata_file_format"); ?></small>
        <?php echo form_hidden('pathfile', ""); ?>
	</div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('previous', lang('previous'), array('class' => 'btn btn-primary'));?>
  <?php echo form_submit('submit', lang('next'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
<script src="<?php echo base_url("assets/vendor/fileuploader/jquery.fileuploader.min.js") ?>"></script>
<link href="<?php echo base_url("assets/vendor/fileuploader/jquery.fileuploader.css") ?>" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(function() {
    $("input[name=previous]").click(function(e){
        $(this).parents("form").attr("action", "<?php echo site_url("/import_data") ?>").submit();
        e.preventDefault();
        return false;
    });
    var input = $('input#csv_file').fileuploader({
        limit:1,
        maxSize: 500,
        extensions: ['csv', 'xls', 'xlsx'],
        enableApi: true,
        upload: {
            url: '<?php echo site_url("import_data/upload") ?>',
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
            type: 'POST',
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            start: true,
            synchron: true,
            beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
                $(':submit').attr("disabled", "disabled");
            },
            onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
                result = JSON.parse(jqXHR.responseText);
                if( result.status == "error" ){
                    $('input[name="pathfile"]').val("");
                    toastr.error(result.message);
                }else{
                    $('input[name="pathfile"]').val(result.message);
                }
                $(':submit').removeAttr("disabled");
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
    // get API methods
    api = $.fileuploader.getInstance(input);
});
</script>
