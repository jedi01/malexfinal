<?php
$emails = array(
    "placeholder"  => lang("emails_example"),
    "class"        => "form-control ",
    "tabindex"     => "1",
    "autocomplete" => "off",
    "id"           =>"emails",
);
$subject = array(
    "placeholder"  => lang("email_subject"),
    "class"        => "form-control ",
    "id"           =>"subject",
);
$cc = array(
    "placeholder"  => lang("emails_example"),
    "class"        => "form-control ",
    "id"           =>"cc",
);
$bcc = array(
    "placeholder"  => lang("emails_example"),
    "class"        => "form-control ",
    "id"           =>"bcc",
);
$content = array(
    "name"         => "content",
    "value"        => isset($email_content)?$email_content:"",
    "placeholder"  => lang("email_content"),
    "class"        => "form-control email_content",
    "rows"         => 4,
    "style"        => "resize: none;"
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?> <small><?php echo $email_type ?></small></h5>
<hr />
<?php echo form_open($form_action, array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1 p-a-0">
    <div class="form-group m-b-0 required">
      <?php echo lang("email_to", "emails", array("class"=>"form-control-label")) ?>
      <?php echo form_input('emails', set_value('emails', implode(",", $emails_list)), $emails); ?>
    </div>
    <div class="form-group m-b-0 cc_bcc" style="display: none;">
      <?php echo lang("email_cc", "cc", array("class"=>"form-control-label")) ?>
      <?php echo form_input('cc', set_value('cc', $email_cc), $cc); ?>
    </div>
    <div class="form-group m-b-0 cc_bcc" style="display: none;">
      <?php echo lang("email_bcc", "bcc", array("class"=>"form-control-label")) ?>
      <?php echo form_input('bcc', set_value('bcc', ""), $bcc); ?>
    </div>
    <div class="form-group required">
      <?php echo lang("email_subject", "subject", array("class"=>"form-control-label")) ?>
      <?php echo form_input('subject', set_value('subject', $email_subject), $subject); ?>
    </div>
    <div class="form-group m-b-0">
      <?php echo form_textarea($content); ?>
      <div class="attachments">
        <ul>
          <li>
            <label style="width: 100%">
              <span class="label label-default label-bill">PDF</span>
              <b><?php echo $email_type.".pdf"; ?></b>
              <span class="quickMenu"><input type="checkbox" name="attach_pdf" value="1" checked=""></span>
            </label>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary show_hide_cc_bcc pull-left flip"><?php echo lang("show_hide_cc_bcc") ?></button>
  <a class="btn btn-secondary attach_file pull-left flip" ><i class="fa fa-paperclip"></i> <?php echo lang("add_attached_file") ?></a>
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('send'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<script type="text/javascript">
$('#emails, #cc, #bcc').tagsinput();
$('.attach_file').click(function(e){
  $(document).sis_modal({
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

$('.show_hide_cc_bcc').click(function(e){
  $('.cc_bcc').toggle();
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
tinymce.remove(".email_content");
tinymce.init(
  Object.assign({}, tinymce_init_mini, {
    selector: '.email_content',
    height: 100,
  })
);
</script>
