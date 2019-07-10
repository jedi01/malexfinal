<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("estimates/set_status?id=".$estimate->id, array('class' => 'form-horizontal'));?>
<?php echo form_hidden('id', $estimate->id); ?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('reference');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $estimate->reference; ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('old_status');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $estimate->status; ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="status"><?php echo lang('status');?></label>
      <div class="col-md-9">
        <?php
        $attributes = array(
          "id" => "status",
          "class" => "form-control"
        );
        $options = $this->settings_model->getEstimateStatus();
        echo form_dropdown('status', $options, set_value("status", $estimate->status), $attributes);
        ?>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
