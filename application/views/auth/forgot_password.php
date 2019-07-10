<?php
$meta['page_title'] = $this->lang->line("forgot_password_heading");
$this->load->view('templates/head', $meta);
$this->load->view('templates/header');
?>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/login.css"); ?>">
<!-- BEGIN PAGE CONTAINER-->
<div class="row" >
  <div class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="card-group card-inverse vamiddle">
        <div class="card  p-a-2">
          <div class="card-block">
            <center>
              <h3><?php echo lang('forgot_password_heading');?></h3>
              <small class="text-muted"><?php echo sprintf(lang('forgot_password_subheading'),$identity_label);?></small>
            </center>
            <br>
            <?php echo form_open("auth/forgot_password", array('class' => 'form-login'));?>
            <div class="row text-xs-center">
              <label class="form-control-label" for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
            </div>
            <div class="row form-group">
              <div class="col-md-6 col-md-offset-3">
                <?php echo form_input($identity);?>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-6 col-md-offset-3">
                <?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class' => 'btn btn-success btn-block'));?>
              </div>
            </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Bootstrap and necessary plugins -->
<script src="<?=base_url(); ?>assets/js/libs/jquery.min.js"></script>
<script src="<?=base_url(); ?>assets/js/libs/tether.min.js"></script>
<script src="<?=base_url(); ?>assets/js/libs/bootstrap.min.js"></script>
<script src="<?=base_url("assets/vendor/toastrjs/toastr.min.js"); ?>"></script>
<!-- BOOTBOX -->
<script src="<?=base_url("assets/vendor/bootbox/bootbox.js"); ?>" type="text/javascript"></script>
<script>
function isMobile(){
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
function verticalAlignMiddle()
{
  var bodyHeight = $(window).height();
  var formHeight = $('.vamiddle').height();
  var marginTop = (bodyHeight / 2) - (formHeight / 2);

  if( isMobile() ){
    marginTop = marginTop / 2;
  }
  if (marginTop > 0)
  {
    $('.vamiddle').css('margin-top', marginTop);
  }
}
$(document).ready(function()
{
  verticalAlignMiddle();
  <?php
  if (isset($message)) {
    $messages = explode("\n", trim(str_replace("</p>", "", str_replace("<p>", "", $message))));
    foreach ($messages as $message) {
      echo "toastr.error('".$message."', '".lang("error")."');";
    }
  }
  ?>

  <?php
  if (isset($success_message)) {
    $messages = explode("\n", trim(str_replace("</p>", "", str_replace("<p>", "", $success_message))));
    foreach ($messages as $message) {
      echo "toastr.success('".$message."', '".lang("success")."');";
    }
  }
  ?>
});
$(window).bind('resize', verticalAlignMiddle);
var MK_configuration = {
    "theme":"black",
    "hint":<?php echo json_encode(!lang("IS_RTL")) ?>,
    "keyboard_shortcut":true,
    "is_rtl":<?php echo json_encode(lang("IS_RTL")) ?>,
    "always_on_top":true
};

$('#identity').focus();

if( shortcuts_list == undefined )
    var shortcuts_list = [];
</script>
<!-- Main Menu scripts -->
<script src="<?=base_url(); ?>assets/js/mainmenu.js"></script>
<script type="text/javascript">
    $('#page_loading').fadeOut(function(){$(this).remove();});
</script>
</body>
</html>
