<?php
$emails = array(
    "placeholder" => lang("emails_example"),
    "class" => "form-control ",
    "tabindex" => "1",
    "autocomplete" => "off",
    "id" =>"emails",
    //"data-role" =>"tagsinput"
);
$additional_content = array(
    "name" => "additional_content",
    "value" => set_value("additional_content", ""),
    "placeholder" => lang("additional_content"),
    "class" => "form-control",
    "rows" => 4,
    "style" => "resize: none;"
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("receipts/email?id=".$id, array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group required">
      <?php echo form_input('emails', set_value('emails', implode(",", $emails_list)), $emails); ?>
    </div>
    <div class="row form-group m-b-0">
      <?php echo form_textarea($additional_content); ?>
      <div class="attachments">
        <ul></ul>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <a class="btn btn-secondary attach_file pull-left flip" ><i class="fa fa-paperclip"></i> <?php echo lang("add_attached_file") ?></a>
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('send'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<script type="text/javascript">
$('#emails').tagsinput();
$('.attach_file').click(function(e){
  $("#receipts_table").sis_modal({
    url: SITE_URL+"/files/select",
    is_big: true,
    callback: function(data){
      if( data != undefined ){
        for (var i = 0; i < data.length; i++) {
          $.attachments.add(data[i]);
        }
      }
    }
  });
  e.preventDefault();
  return false;
});

$.attachments = {
  add: function(file){
    var index = Math.floor(Math.random() * 9999999) + 1000000 ;
    var self = this;
    var item = $('<li></li>');
    $('<span class="label label-default label-bill">'+file.extension.substring(1)+'</span> ').appendTo(item);
    $('<b> '+file.filename+file.extension+' </b>').appendTo(item);
    $('<i> ('+Format_size(file.size*1024)+') </i>').appendTo(item);
    $('<input name="attached_file[]" value="'+file.id+'" type="hidden">').appendTo(item);
    $('<span class="quickMenu"><a href="#" class="remove_attachement"><i class="fa fa-trash"></i></a></span>').appendTo(item);

    $(item).appendTo($(".attachments ul"));
    $(item).find(".remove_attachement").click(function(){
        self.remove(item);
        return false;
    });
    return item;
  },
  remove : function(item){
      $(item).remove();
  },
}
</script>
