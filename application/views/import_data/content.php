<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<style type="text/css">
	.import_data {
		display: table;
	}
	.import_data > label{
		height: 74px;
		display: table-row;
		cursor: pointer;
	}
	.import_data > label .icon,
	.import_data > label .text {
	    display: table-cell;
		vertical-align: middle;
		padding: 5px;
	}
	.import_data .icon {
	    max-width: 48px;
	}
	.import_data .icon .card{
	    margin: 0;
	}
	.import_data .text h5{
	    margin: 0;
	}
</style>
<?php echo form_open("import_data/upload_file", array('class' => 'form-horizontal'));?>

<div class="table import_data" >
	<label for="switch_billers">
		<div class="icon">
			<div class="card card-inverse card-primary"><div class="card-block"><i class="icon-basket fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_billers" value="billers" class="switch-input" checked>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_customers') ?></h5>
			<small class="text-muted"><?php echo lang('idata_customers_description') ?></small>
		</div>
	</label>
	<label for="switch_suppliers">
		<div class="icon">
			<div class="card card-inverse card-danger"><div class="card-block"><i class="icon-people fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_suppliers" value="suppliers" class="switch-input"/>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_suppliers') ?></h5>
			<small class="text-muted"><?php echo lang('idata_suppliers_description') ?></small>
		</div>
	</label>
	<label for="switch_expenses_categories">
		<div class="icon">
			<div class="card card-inverse card-info"><div class="card-block"><i class="icon-plane fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_expenses_categories" value="expenses_categories" class="switch-input"/>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_ex_cats') ?></h5>
			<small class="text-muted"><?php echo lang('idata_ex_cats_description') ?></small>
		</div>
	</label>
	<label for="switch_taxs">
		<div class="icon">
			<div class="card card-inverse card-success"><div class="card-block"><i class="icon-calculator fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_taxs" value="tax_rates" class="switch-input"/>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_tax_rates') ?></h5>
			<small class="text-muted"><?php echo lang('idata_tax_rates_description') ?></small>
		</div>
	</label>
	<label for="switch_items">
		<div class="icon">
			<div class="card card-inverse card-warning"><div class="card-block"><i class="icon-layers fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_items" value="items" class="switch-input"/>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_items') ?></h5>
			<small class="text-muted"><?php echo lang('idata_items_description') ?></small>
		</div>
	</label>
	<label for="switch_items_categories">
		<div class="icon">
			<div class="card card-inverse card-warning"><div class="card-block"><i class="icon-tag fa-2x"></i></div></div>
		</div>
		<div class="text">
			<label class="switch switch-icon switch-pill switch-primary flip pull-right">
			    <input type="radio" name="section" id="switch_items_categories" value="items_categories" class="switch-input"/>
			    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
			    <span class="switch-handle"></span>
			</label>
			<h5><?php echo lang('idata_item_cats') ?></h5>
			<small class="text-muted"><?php echo lang('idata_item_cats_description') ?></small>
		</div>
	</label>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <button type="button" class="btn btn-primary" disabled="disabled"><?php echo lang("previous") ?></button>
  <?php echo form_submit('submit', lang('next'), array('class' => 'btn btn-primary', 'tabindex'=>1));?>
</div>
<?php echo form_close();?>
