<?php
$meta['page_title'] = $this->lang->line("login_heading");
$this->load->view('templates/head', $meta);
$this->load->view('templates/header');
if( $action != "register" && $action != "login" ){
  $action = "login";
}
$hiddens = array();
if( $this->input->get('next') ){
  $hiddens['next'] = $this->input->get('next');
}
?>
<link rel="stylesheet" href="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.css") ?>">
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/login.css"); ?>">
    <div class="row" >
      <div class="content">
        <div class="col-md-5 vamiddle">
          <div class="card-group card-inverse">
            <div id="login-card" class="card" <?php echo $action=="login"?"":'style="display: none;"' ?>>
              <div class="card-block">
                <center>
                  <h1>
                    <img src="<?=base_url("assets/img/logo-light.png"); ?>" width="200px">
                  </h1>
                </center><br>
                <?php echo form_open("auth/login", array('class' => 'form-login'), $hiddens);?>
                <div class="row-fluidd">
                  <div class="input-group m-b-1">
                    <span class="input-group-addon"><span class="arrow"></span><i class="icon-user"></i> </span>
                    <?php echo form_input($identity);?>
                  </div>
                  <div class="input-group m-b-2">
                    <span class="input-group-addon"><span class="arrow"></span><i class="icon-lock"></i> </span>
                    <?php echo form_input($password);?>
                  </div>
                </div>
                <div class="text-md-left">
                  <label class="switch switch-sm switch-icon switch-success-outline-alt">
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember" class="switch-input"');?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
                  <?php echo lang('login_remember_label', "remember");?>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="<?php echo site_url("/auth/forgot_password") ?>" class="btn btn-link text-white p-x-0">
                      <?php echo lang('login_forgot_password');?>
                    </a>
                  </div>
                  <div class="col-xs-6 text-xs-right">
                    <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-secondary'));?>
                  </div>
                </div>
                <?php echo form_close();?>
                <?php if (REGISTER): ?>
                  <div class="text-md-center">
                    <hr>
                    <small class="text-muted"><?php echo lang("register_ask") ?></small>
                    <button type="button" id="register" class="btn btn-success btn-block m-t-1"><?php echo lang("register_btn") ?></button>
                  </div>
                <?php endif ?>
              </div>
            </div>
            <div id="register-card" class="card" <?php echo $action=="register"?"":'style="display: none;"' ?>>
              <div class="card-block">
                <center>
                  <h1>
                    <img src="<?=base_url("assets/img/logo-light.png"); ?>" width="200px">
                  </h1>
                </center><br>
                <?php echo form_open("auth/register", array('class' => 'form-login'));?>
                <div class="input-group m-b-1">
                  <span class="input-group-addon"><i class="icon-user"></i></span>
                  <input class="form-control" placeholder="<?php echo lang("register_username") ?>" type="text" name="username" id="username" autocomplete="off">
                </div>
                <div class="input-group m-b-1">
                  <span class="input-group-addon">@</span>
                  <input class="form-control" placeholder="<?php echo lang("register_email") ?>" type="text" name="email" autocomplete="off">
                </div>
                <div class="input-group m-b-1">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input class="form-control" placeholder="<?php echo lang("register_password") ?>" type="password" name="password" id="reg_pass" autocomplete="off">
                </div>
                <div class="input-group m-b-2">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input class="form-control" placeholder="<?php echo lang("register_password_confirm") ?>" type="password" name="password_confirm" autocomplete="off">
                </div>
                <div class="row row-equal">
                  <div class="col-md-6">
                    <button type="button" id="login" class="btn btn-block btn-secondary"><?php echo lang('cancel') ?></button>
                  </div>
                  <div class="col-md-6">
                    <?php echo form_submit('submit', lang('register_submit_btn'), array('class' => 'btn btn-block btn-success'));?>
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
  <script src="<?=base_url("assets/js/libs/jquery.min.js"); ?>"></script>
  <script src="<?=base_url("assets/js/libs/tether.min.js"); ?>"></script>
  <script src="<?=base_url("assets/js/libs/bootstrap.min.js"); ?>"></script>
  <script src="<?=base_url("assets/vendor/toastrjs/toastr.min.js"); ?>"></script>
  <script src="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.js") ?>"></script>
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
      $('.vamiddle').css('padding-top', marginTop);
    }
  }
  $(document).ready(function()
  {
    verticalAlignMiddle();

    $('#register').click(function(){
      $('#login-card').toggle();
      $('#register-card').toggle();
      verticalAlignMiddle();
      $('#username').focus();
    });
    $('#login').click(function(){
      $('#login-card').toggle();
      $('#register-card').toggle();
      verticalAlignMiddle();
      $('#identity').focus();
    });

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

    $('#reg_pass').passwordstrength({
      'minlength': 6,
      'number'   : true,
      'capital'  : true,
      'special'  : true,
      'labels'   : {
        'general'   : globalLang['pass_strength_general'],
        'minlength' : globalLang['pass_strength_minlength'],
        'number'    : globalLang['pass_strength_number'],
        'capital'   : globalLang['pass_strength_capital'],
        'special'   : globalLang['pass_strength_special'],
      }
    });
  });

  $(window).bind('resize', verticalAlignMiddle);

  var MK_configuration = {
      "theme":"black",
      "hint":<?php echo json_encode(!lang("IS_RTL")) ?>,
      "keyboard_shortcut":true,
      "is_rtl":<?php echo json_encode(lang("IS_RTL")) ?>,
      "always_on_top":true
  };

  <?php if ($action=="register"): ?>
    $('#username').focus();
  <?php else: ?>
    $('#identity').focus();
  <?php endif ?>

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
