<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title">
  <i class="fa fa-arrows"></i> <b><?php echo $page_title ?></b>
  <small class="text-muted"><?php echo (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files"); ?></small>
</h5>
<hr />
<?php echo form_open("files/move_to?files=".implode(",", $id_list), array('class' => 'form-horizontal'));?>
<?php echo form_hidden('id', $id_list); ?>
<div class="row">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="folder"><?php echo lang('folder');?></label>
      <div class="col-md-9">
        <?php echo form_dropdown('to_folder', $folders, set_value("to_folder", $files[0]->folder), 'class="form-control" tabindex="1" id="folder"'); ?>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('move'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
