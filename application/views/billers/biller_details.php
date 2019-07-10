<style type="text/css">
  #custmer_details .form-control-label,
  #custmer_details .form-control-static{
    padding-top: 0px;
    padding-bottom: 0px;
  }
  #custmer_details .form-group{
    margin-bottom: 0px;
  }
</style>
<?php if (!isset($disable_headings) || !$disable_headings): ?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php endif ?>
<div class="row m-a-h" id="custmer_details">
  <h4 class="m-x-1">
    <big><?php if( trim($biller->company) != "" ){echo $biller->company;}else{echo $biller->fullname;} ?></big>
    <small class="text-muted"><?php if(trim($biller->company) != ""){ echo "<br><b>".lang("attn")."</b>: ".$biller->fullname; } ?></small>
  </h4>
  <div class="col-md-6">
    <h5><?php echo lang("basic_informations") ?></h5>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('company');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo trim($biller->company)!=""?$biller->company:"-" ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('contact_name');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->fullname ?></p>
      </div>
    </div>
    <?php if ($biller->vat_number): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('vat_number');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->vat_number ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if ($user): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('account_username');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $user->username ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('account_status');?></label>
      <div class="col-md-9">
        <p class="form-control-static">
          <?php
          if( $user->active ){
            echo "<small class='text-bullet-success'>".lang('index_active_status')."</small>";
          }else{
            echo "<small class='text-bullet-danger'>".lang('index_inactive_status')."</small>";
          }
          ?>
        </p>
      </div>
    </div>
    <?php endif ?>
  </div>
  <div class="col-md-6">
    <h5><?php echo lang("additional_informations") ?></h5>
    <?php if ($biller->phone): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('phone');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->phone ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if ($biller->email): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('email');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->email ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if ($biller->website): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('website');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->website ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if ($biller->fulladdress): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo lang('address');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->fulladdress ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php $cf = $this->settings_model->SYS_Settings; ?>
    <?php if (!empty($cf->customer_cf1) && $biller->custom_field1 ): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo $cf->customer_cf1;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->custom_field1 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->customer_cf2) && $biller->custom_field2 ): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo $cf->customer_cf2;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->custom_field2 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->customer_cf3) && $biller->custom_field3 ): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo $cf->customer_cf3;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->custom_field3 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->customer_cf4) && $biller->custom_field4 ): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label font-weight-bold"><?php echo $cf->customer_cf4;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $biller->custom_field4 ?></p>
      </div>
    </div>
    <?php endif ?>
  </div>

</div>



<?php if (!isset($disable_headings) || !$disable_headings): ?>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
<?php endif ?>
