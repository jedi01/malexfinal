<?php
$attrib = array('class'=>'form-horizontal', "id"=>"form_settings_files");
echo form_open("/settings/update_settings_files", $attrib);
?>
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('configuration_files') ?></h3>
    <div class="col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update_settings") ?></button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->
<div class="row-fluid">
  <div class="col-md-6">

    <!-- ENABLE -->
    <!-- <div class="row form-group">
      <label class="col-md-3 form-control-label" for="files_enable"><?php echo lang("file_upload_enable"); ?></label>
      <div class="col-md-9">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('files[enable]', "1", $FILES_settings->enable, 'id="files_enable" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div> -->

    <!-- MAX USER DISC SPACE -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="user_disc_space"><?php echo lang("user_disc_space"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>'files[user_disc_space]', "value"=>$FILES_settings->user_disc_space, "type"=>"number", "step"=>"1", "min"=>"0", "id"=>"user_disc_space", "class"=>"form-control")); ?>
        <small class="help-block text-muted"><?php echo lang("user_disc_space_tip") ?></small>
      </div>
    </div>

    <!-- MAX USER DISC SPACE -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="max_upload_size"><?php echo lang("max_upload_size"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>'files[max_upload_size]', "value"=>$FILES_settings->max_upload_size, "type"=>"number", "step"=>"1", "min"=>"0", "id"=>"max_upload_size", "class"=>"form-control")); ?>
        <small class="help-block text-muted"><?php echo lang("max_upload_size_tip") ?></small>
      </div>
    </div>

    <!-- MAX USER DISC SPACE -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="max_simult_uploads"><?php echo lang("max_simult_uploads"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>'files[max_simult_uploads]', "value"=>$FILES_settings->max_simult_uploads, "type"=>"number", "step"=>"1", "min"=>"0", "max"=>"20", "id"=>"max_simult_uploads", "class"=>"form-control")); ?>
        <small class="help-block text-muted"><?php echo lang("max_simult_uploads_tip") ?></small>
      </div>
    </div>

    <!-- MAX USER DISC SPACE -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="white_list"><?php echo lang("white_list"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>'files[white_list]', "value"=>$FILES_settings->white_list, "type"=>"text", "id"=>"white_list", "class"=>"form-control")); ?>
        <small class="help-block text-muted"><?php echo lang("white_list_tip") ?></small>
      </div>
    </div>

  </div>
</div>
<div class="clearfix"></div>
<?php echo form_close();?>
<script type="text/javascript">
$(document).ready(function(){
  $('#general_settings_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
});
</script>
