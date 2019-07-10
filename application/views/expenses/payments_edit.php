<?php
$label_params = array(
  "class" => "form-control-label"
);
$date = array(
  "id" => "date",
  "class" => "form-control",
  'autocomplete' => "off"
);
$method = array(
  "id" => "method",
  "class" => "form-control",
  'autocomplete' => "off"
);
$details = array(
  'name'         => 'payment[details]',
  'id'           => 'details',
  'value'        => set_value("payment[details]", $payment->details),
  'class'        => 'form-control',
  'rows'         => 2,
  'autocomplete' => "off"
);

?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<span class="label label-info pull-right"><?php echo EXPENSE_PREFIX.sprintf("%06s", $expense->number); ?></span>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("expenses/edit_payment?id=".$payment->id, array('class' => 'form-horizontals'));?>
<div class="row">
  <div class="col-md-5 col-md-offset-1">

    <!-- NUMBER -->
    <div class="form-group required">
      <?php echo lang('payment_number', 'number', $label_params); ?>
      <div class="input-group">
        <span class="input-group-addon"><?php echo lang("n°") ?></span>
        <input type="number" step="1" min="0" value="<?php echo set_value("payment[number]", $payment->number) ?>" name="payment[number]" tabindex="1" class="form-control" id="number" />
      </div>
    </div>
    <!-- AMOUNT -->
    <div class="form-group required">
      <?php echo lang('amount', 'amount', $label_params); ?>
      <div class="input-group">
        <input type="number" step="any" min="0" value="<?php echo set_value("payment[amount]", $payment->amount) ?>" name="payment[amount]" class="form-control" id="amount" />
        <span class="input-group-addon" ><?php echo $this->settings_model->getFormattedCurrencies($expense->currency)->symbol_native ?></span>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <!-- DATE -->
    <div class="form-group required">
      <?php echo lang('date', 'date', $label_params); ?>
      <div class="input-group">
        <?php
        echo form_input($date);
        echo form_hidden('payment[date]', set_value('payment[date]', date_MYSQL_JS($payment->date)));
        ?>
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      </div>
    </div>
    <!-- METHOD -->
    <div class="form-group required">
      <?php echo lang('payment_method', 'method', $label_params); ?>
      <?php
      $methods = $this->settings_model->getPaymentsMethods();
      echo form_dropdown('payment[method]', $methods, set_value("payment[method]", $payment->method), $method);
      ?>
    </div>
  </div>
  <div class="col-md-10 col-md-offset-1">
    <div class="form-group">
      <?php echo lang('details', 'details', $label_params); ?>
      <?php echo form_textarea($details); ?>
    </div>
  </div>
</div>
<!-- DETAILS -->
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>
<script type="text/javascript">
  $.fn.datepicker.defaults.language = globalLang["lang"];
  $("#date")
  .mask(MASK_DATE,{
    placeholder:JS_DATE
  });
  $("#date_input").datepicker({
      "todayHighlight": true,
      "format": DATEPICKER_FORMAT
  })
  .on("change", function(){
      if( $(this).datepicker("getDate") != null ){
          $('input[name="payment[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="payment[date]"]').val("");
      }
  });
  if( $('input[name="payment[date]"]').val() != "" ){
    $("#date").datepicker("setDate",date_locale($('input[name="payment[date]"]').val(), "en", globalLang["lang"]));
  }else{
    $("#date").trigger("changeDate");
  }
</script>
