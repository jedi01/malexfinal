<script src="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.js") ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.css") ?>">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo lang('edit_user_heading');?></h5>
<div class="text-muted page-desc"><?php echo lang('edit_user_subheading');?></div>
<hr />
<?php echo form_open(uri_string(), array('class' => 'form-login form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="first_name"><?php echo lang('index_name_th');?></label>
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
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="company"><?php echo lang('edit_user_company_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($company);?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="phone"><?php echo lang('edit_user_phone_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($phone);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="password"><?php echo lang('edit_user_password_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($password);?>
        <small class="help-block"><em><?php echo lang('edit_user_password_help');?></em></small>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="password_confirm"><?php echo lang('edit_user_password_confirm_label');?></label>
      <div class="col-md-9">
        <?php echo form_input($password_confirm);?>
        <small class="help-block"><em><?php echo lang('edit_user_password_help');?></em></small>
      </div>
    </div>
    <?php if ($this->ion_auth->is_admin() && !($is_biller) ): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('edit_user_groups_heading');?></label>
      <div class="col-md-9">
        <?php foreach ($groups as $group):?>
        <?php
          $gID=$group['id'];
          $checked = null;
          $item = null;
          foreach($currentGroups as $grp) {
            if ($gID == $grp->id) {
              $checked= ' checked="checked"';
              break;
            }
          }
          if( !$this->ion_auth->in_group(array("superadmin")) && $group["name"] == "superadmin" ){
            continue;
          }
        ?>
        <div class="checkbox check-default">
          <input id="<?php echo $group['name'] ?>" class="m-l-0" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
          <label for="<?php echo $group['name'] ?>"><?php echo lang("role_".strtolower($group['name']));?></label>
        </div>
        <?php endforeach?>
      </div>
    </div>
    <?php endif ?>
    <?php echo form_hidden('id', $user->id);?>
    <?php echo form_hidden($csrf); ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn btn-primary'));?>
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
