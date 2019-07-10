<style type="text/css">
  #payment_details .form-control-label,
  #payment_details .form-control-static{
    padding-top: 0px;
    padding-bottom: 0px;
  }
  #payment_details .form-group{
    margin-bottom: 0px;
  }
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<div class="row row-equal" id="payment_details">
  <div class="col-md-6">
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('payment_number');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo sprintf("%06s", $payment->number); ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-5 form-control-label"><?php echo lang('date');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo date(PHP_DATE, strtotime($payment->date)); ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-5 form-control-label"><?php echo lang('payment_method');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo lang($payment->method); ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('payment_for');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo $supplier->fullname ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('expense');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo EXPENSE_PREFIX.sprintf("%06s", $expense->number); ?></p>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('status');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo $payment->status; ?></p>
      </div>
    </div>
  </div>
  <?php if (!empty($payment->details)): ?>
  <div class="col-md-12">
    <small class="text-muted font-italic"><?php echo $payment->details; ?></small>
  </div>
  <?php endif ?>
  <div class="col-md-12">
  <hr>
    <div class="row form-group text-xs-center">
      <label><?php echo lang('amount');?></label>
      <p class="form-control-static text-success font-weight-light font-4xl">
          <?php echo formatMoney($payment->amount, $currency); ?>
      </p>
    </div>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
