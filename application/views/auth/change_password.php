<script src="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.js") ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.css") ?>">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo lang('change_password_heading');?></h5>
<hr />
<?php echo form_open("auth/change_password", array('class' => 'form-horizontal'));?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="row form-group required">
      <label class="col-md-4 form-control-label" for="old"><?php echo lang('change_password_old_password_label');?></label>
      <div class="col-md-8">
        <?php echo form_input($old_password);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-4 form-control-label" for="new"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
      <div class="col-md-8">
        <?php echo form_input($new_password);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-4 form-control-label" for="new_confirm"><?php echo lang('change_password_new_password_confirm_label');?></label>
      <div class="col-md-8">
        <?php echo form_input($new_password_confirm);?>
      </div>
    </div>
    <?php echo form_input($user_id);?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('change_password_submit_btn'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
$('#new').passwordstrength({
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
