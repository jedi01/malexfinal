

<script src="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.js") ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/vendor/jquery-passwordStrength/jquery.passwordstrength.css") ?>">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo lang('create_user_account');?></h5>
<div class="text-muted page-desc"><?php echo lang('edit_user_subheading');?></div>
<hr />
<?php echo form_open("settings/create_chart_of_account", array('class' => 'form-login form-horizontal'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="account_number"><?php echo lang('account_number');?></label>
      <div class="col-md-9">
        <input type="text" name="account_number" id="account_number" class="form-control" autocomplete="off" maxlength="10">
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="description"><?php echo lang('description');?></label>
      <div class="col-md-9">
        <input type="text" name="description" id="description" class="form-control" autocomplete="off">
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="status"><?php echo lang('status');?></label>
      <div class="col-md-9">
        <select  name="status" value="" id="status" class="form-control">
          <option value="1"> <?php echo lang('active');?></option>
          <option value="0"> <?php echo lang('inactive');?></option>
        </select>
      </div>
    </div>
    <?php echo form_hidden($csrf); ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('save'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


