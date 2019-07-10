<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php echo form_open("files/create_folder", array('class' => 'form-horizontal'));?>
<?php echo form_hidden('folder', $folder); ?>
<div class="row">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="foldername"><?php echo lang('foldername');?></label>
      <div class="col-md-9">
        <?php echo form_input('foldername', set_value("foldername", ""), 'class="form-control" tabindex="1" id="foldername"'); ?>
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
