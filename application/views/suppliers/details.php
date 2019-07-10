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
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<div class="row" id="custmer_details">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('company');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->company ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('contact_name');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->fullname ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('vat_number');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->vat_number ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('phone');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->phone ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('email');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->email ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('website');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->website ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('address');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->fulladdress ?></p>
      </div>
    </div>
    <?php $cf = $this->settings_model->SYS_Settings; ?>
    <?php if (!empty($cf->supplier_cf1)): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo $cf->supplier_cf1;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->custom_field1 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->supplier_cf2)): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo $cf->supplier_cf2;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->custom_field2 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->supplier_cf3)): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo $cf->supplier_cf3;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->custom_field3 ?></p>
      </div>
    </div>
    <?php endif ?>
    <?php if (!empty($cf->supplier_cf4)): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo $cf->supplier_cf4;?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $supplier->custom_field4 ?></p>
      </div>
    </div>
    <?php endif ?>

  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
