<script src="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.js") ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.css") ?>">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo lang('create_user_heading');?></h5>
<div class="text-muted page-desc"><?php echo lang('create_user_subheading');?></div>
<hr />
<?php echo form_open("auth/create_user", array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="first_name"><?php echo lang('index_name_th');?></label>
      <div class="col-md-9">
        <div class="row-equal">
          <div class="col-md-6" style="padding: 0px;">
            <?php echo form_input($first_name);?>
          </div>
          <div class="col-md-6" style="padding: 0px;">
            <?php echo form_input($last_name);?>
          </div>
        </div>
      </div>
    </div>
    <?php if ($identity_column!=='email'): ?>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="identity"><?php echo lang('create_user_identity_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($identity);?>
      </div>
    </div>
    <?php endif ?>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="email"><?php echo lang('create_user_email_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($email);?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="company"><?php echo lang('create_user_company_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($company);?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="phone"><?php echo lang('create_user_phone_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($phone);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="password"><?php echo lang('create_user_password_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($password);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="password_confirm"><?php echo lang('create_user_password_confirm_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($password_confirm);?>
      </div>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create_user_submit_btn'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
<script type="text/javascript">
$('#password').passwordstrength({
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
</script>
