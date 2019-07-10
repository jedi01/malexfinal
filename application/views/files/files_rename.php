<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><i class="fa fa-pencil"></i> <b><?php echo $page_title ?></b> <small class="text-muted"><?php echo $file->filename.$file->extension;?></small></h5>
<hr />
<?php echo form_open("files/rename/".$file->link, array('class' => 'form-horizontal'));?>
<?php echo form_hidden('id', $file->id); ?>
<div class="row">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label required" for="filename"><?php echo lang('filename');?></label>
      <div class="col-md-9">
        <?php echo form_input('filename', set_value("filename", $file->filename), 'class="form-control" tabindex="1" id="filename"'); ?>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('rename'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
