<?php
$item_category_name = array(
  "id"           => 'item_category_name',
  "name"         => 'category[name]',
  "value"        => set_value('category[name]', ""),
  "class"        => "form-control",
  "autocomplete" => "off",
  "tabindex"     => "1",
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php echo form_open("items/create_category", array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="item_category_name"><?php echo lang('name');?></label>
      <div class="col-md-7">
        <?php echo form_input($item_category_name); ?>
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
