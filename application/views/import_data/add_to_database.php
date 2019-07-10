<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<div class="row bs-wizard step-count-4">
	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo $this->lang->line('idata_upload_file') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo $this->lang->line('idata_match_fields') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo $this->lang->line('idata_confirm_data') ?></div>
	</div>

	<div class="col-xs-3 bs-wizard-step active"><!-- active -->
		<div class="progress"><div class="progress-bar bar"></div></div>
		<span class="bs-wizard-dot"></span>
		<div class="bs-wizard-info text-center"><?php echo $this->lang->line('idata_add_to_database') ?></div>
	</div>
</div>
<div class="alert alert-success">
	<h4 class="text-bold"><?php echo $this->lang->line('idata_imported') ?></h4>
	<p>
		<?php
			if( count($items) == 1 ){
				echo count($items)." ".$this->lang->line('idata_item_is_imported');
			}else{
				echo count($items)." ".$this->lang->line('idata_items_are_imported');
			}
		?>
	</p>
</div>
<div class="text-md-right">
	<hr />
	<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true" tabindex="1"><?php echo lang("ok") ?></button>
</div>
