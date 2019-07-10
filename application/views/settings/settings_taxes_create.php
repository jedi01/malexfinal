<?php
$tax_rate_label = array(
  "placeholder" => lang("tax_rate_label"),
  "class" => "form-control required",
  "tabindex" => "1",
  "autocomplete" => "off"
);
$tax_rate_value = array(
  "name" => 'tax_rate[value]',
  "value" => set_value('tax_rate[value]', ""),
  "placeholder" => lang("tax_rate_value"),
  "class" => "form-control",
  "autocomplete" => "off",
  "type" => "number",
  "step" => "any",
);
$tax_rate_type = array(
  "id" => "tax_rate_type",
  "class" => "form-control"
);
$tax_rate_types = array(
  0 => lang("percent"),
  1 => lang("flat")
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php echo form_open("settings/create_tax_rate", array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="tax_rate_label"><?php echo lang('tax_rate_label');?></label>
      <div class="col-md-9">
        <?php echo form_input('tax_rate[label]', set_value('tax_rate[label]', ""), $tax_rate_label); ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="tax_rate_value"><?php echo lang('tax_rate_value');?></label>
      <div class="col-md-9">
        <?php echo form_input($tax_rate_value); ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="tax_rate_type"><?php echo lang("tax_rate_type"); ?></label>
      <div class="col-md-9">
        <?php echo form_dropdown('tax_rate[type]', $tax_rate_types, set_value("tax_rate[type]", ""), $tax_rate_type); ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="is_default"><?php echo lang('is_default');?></label>
      <div class="col-md-9">
          <label class="switch switch-xs switch-icon switch-primary-outline-alt" style="margin-top: 9px;vertical-align: middle;">
            <?php echo form_checkbox('tax_rate[is_default]', '1', set_value("tax_rate[is_default]", false), 'id="is_default" class="switch-input"');?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
          <?php echo lang('yes', "is_default");?>
      </div>
    </div>

  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
