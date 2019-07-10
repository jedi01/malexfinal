<style type="text/css">
  #item_details .form-control-label,
  #item_details .form-control-static{
    padding-top: 0px;
    padding-bottom: 0px;
  }
  #item_details .form-group{
    margin-bottom: 0px;
  }
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<div class="row" id="item_details">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('account_number');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $balance->account_number ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('description');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $balance->description ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('debit_amount');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo "$ ".$balance->dtp_amount ?></p>
      </div>
    </div>
        <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('credit_amount');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo "$ ". $balance->crd_amount ?></p>
      </div>
    </div>

  </div>
</div>
<div class="text-md-right">
  <hr />
  <?php echo form_open('', ''); ?>
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
