<?php
$expenses_category_type = array(
  "id"           => 'expenses_category_type',
  "name"         => 'category[type]',
  "value"        => set_value('category[type]', ""),
  "class"        => "form-control",
  "autocomplete" => "off",
  "tabindex"     => "1",
);
$expenses_category_label = array(
  "id"           => 'expenses_category_label',
  "name"         => 'category[label]',
  "value"        => set_value('category[label]', ""),
  "class"        => "form-control",
  "autocomplete" => "off"
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php echo form_open("expenses/create_category", array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="expenses_category_type"><?php echo lang('expenses_category_type');?></label>
      <div class="col-md-7">
        <?php echo form_input($expenses_category_type); ?>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="expenses_category_label"><?php echo lang('expenses_category_label');?></label>
      <div class="col-md-7">
        <?php echo form_input($expenses_category_label); ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="is_default"><?php echo lang('is_default');?></label>
      <div class="col-md-7">
          <label class="switch switch-xs switch-icon switch-primary-outline-alt" style="margin-top: 9px;vertical-align: middle;">
            <?php echo form_checkbox('category[is_default]', '1', set_value("category[is_default]", false), 'id="is_default" class="switch-input"');?>
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
