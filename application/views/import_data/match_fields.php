<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<div class="row bs-wizard step-count-4">
	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo lang('idata_upload_file') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step active"><!-- active -->
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

<?php
$hiddens = array(
	"file_path" => $file_path,
	"csv_delimiter" => $csv_delimiter
	);
echo form_open("import_data/confirm_data?section=".$section, array('class' => 'form-horizontal '), $hiddens);
?>
<?php
	$fields_file[''] = "";
	foreach ($column_headers as $key => $value) {
		$fields_file[$value] = $value;
	}
?>
<?php foreach ($fields as $field_code => $field_info): ?>
<div class="form-group row">
	<label class="form-control-label col-md-3"><?php echo lang($field_info[0]) ?></label>
	<div class="col-md-6">
		<?php
		echo form_dropdown($field_code, $fields_file, $field_code, 'class="form-control" ');
		?>
	</div>
</div>
<?php endforeach ?>

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('previous', lang('previous'), array('class' => 'btn btn-primary'));?>
  <?php echo form_submit('submit', lang('next'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
<script type="text/javascript">
$(function() {
    $("input[name=previous]").click(function(e){
        $(this).parents("form").attr("action", "<?php echo site_url("/import_data/upload_file?section=".$section) ?>").submit();
        e.preventDefault();
        return false;
    });
});
</script>
