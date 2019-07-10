<?php
$emails = array(
    "placeholder" => lang("emails_example"),
    "class" => "form-control ",
    "tabindex" => "1",
    "autocomplete" => "off",
    "id" =>"emails",
);
$additional_content = array(
    "name" => "additional_content",
    "value" => set_value("additional_content", ""),
    "placeholder" => lang("additional_content"),
    "class" => "form-control",
    "rows" => 4,
    "style" => "resize: none;",
    "id" => "additional_content"
);
?>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><i class="fa fa-share-alt"></i> <b><?php echo $page_title ?></b>
  <small class="text-muted"><?php echo (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files"); ?></small>
</h5>
<hr />
<?php echo form_open("files/email/".$files_link, array('class' => 'form-horizontal'));?>
  <div class="row">
    <div class="col-md-10 col-md-offset-1 p-a-0">
        <p class="text-muted p-x-0"><?php echo lang("send_link_via_email") ?></p>
        <div class="form-group">
          <?php echo form_input('emails', set_value('emails', ""), $emails); ?>
        </div>
        <div class="form-group">
          <?php echo form_textarea($additional_content); ?>
        </div>
    </div>
  </div>
  <div class="text-md-right">
    <hr />
    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
    <?php echo form_submit('submit', lang('send'), array('class' => 'btn btn-primary'));?>
  </div>
<?php echo form_close();?>

<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<script type="text/javascript">
$('#emails').tagsinput();
</script>
