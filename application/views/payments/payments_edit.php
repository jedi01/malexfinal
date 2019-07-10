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
<span class="label label-info pull-right"><?php echo $invoice->reference; ?></span>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("payments/edit?id=".$payment->id, array('class' => 'form-horizontals'));?>
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
        <span class="input-group-addon" ><?php echo $this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native ?></span>
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
      if( $this->ion_auth->in_group(array("customer", "supplier")) ){
        $methods = $this->settings_model->getPaymentsMethods(false, true, CUS_PAYMENT_METHODS);
      }else{
        $methods = $this->settings_model->getPaymentsMethods();
      }
      echo form_dropdown('payment[method]', $methods, set_value("payment[method]", $payment->method), $method);
      ?>
    </div>
  </div>

<?php if (PAYMENTS_ONLINE): ?>
  <!-- CREDIT CARD -->
<div class="card card-secondary col-md-12 row" style="margin:0; display: none;" id="credit_card">
  <div class="card-block">
    <h6 class="card-title"><?php echo lang("credit_card") ?></h6>
    <div class="row">
      <div class="form-group col-sm-6 required">
        <?php echo lang('credit_card_firstName', 'cfirstname', $label_params); ?>
        <?php echo form_input('cc[firstname]', set_value("cc[firstname]", isset($payment->credit_card)?$payment->credit_card->firstname:""), 'class="form-control" id="cfirstname"'); ?>
      </div>
      <div class="form-group col-sm-6 required">
        <?php echo lang('credit_card_lastName', 'clastname', $label_params); ?>
        <?php echo form_input('cc[lastname]', set_value("cc[lastname]", isset($payment->credit_card)?$payment->credit_card->lastname:""), 'class="form-control" id="clastname"'); ?>
      </div>
    </div>
      <div class="form-group required">
        <?php echo lang('credit_card_number', 'ccnumber', $label_params); ?>
        <?php echo form_input('cc[number]', set_value("cc[number]", isset($payment->credit_card)?$payment->credit_card->number:""), 'class="form-control" id="ccnumber"'); ?>
      </div>
      <div class="row">
        <div class="form-group col-sm-4 required">
          <?php echo lang('credit_card_expiryMonth', 'ccmonth', $label_params); ?>
          <?php
          $months = array();
          for ($i=1; $i < 13; $i++) {
            $months[$i] = $i;
          }
          echo form_dropdown('cc[expiryMonth]', $months, set_value("cc[expiryMonth]", isset($payment->credit_card)?$payment->credit_card->expiryMonth:""), 'class="form-control" id="ccmonth"');
          ?>
        </div>
        <div class="form-group col-sm-4 required">
          <?php echo lang('credit_card_expiryYear', 'ccyear', $label_params); ?>
          <?php
          $years = array();
          for ($i=date("Y"); $i < date("Y")+10; $i++) {
            $years[$i] = $i;
          }
          echo form_dropdown('cc[expiryYear]', $years, set_value("cc[expiryYear]", isset($payment->credit_card)?$payment->credit_card->expiryYear:""), 'class="form-control" id="ccyear"');
          ?>
        </div>
        <div class="col-sm-4">
            <div class="form-group required">
              <?php echo lang('credit_card_cvv', 'cvv', $label_params); ?>
              <?php echo form_input('cc[cvv]', set_value("cc[cvv]", isset($payment->credit_card)?$payment->credit_card->cvv:""), 'class="form-control" id="cvv"'); ?>
            </div>
        </div>
    </div>
  </div>
</div>
  <!-- CREDIT CARD END -->
<?php endif ?>
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
  <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
  <div class="checkbox pull-left flip">
    <label>
      <input type="checkbox" name="create_receipt" id="create_receipt" value="1" checked="checked">
      <?php echo lang("create_receipt") ?>
    </label>
  </div>
  <?php endif ?>
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

  <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
  $('#method').change(function(){
    if( $(this).val() == "cash" ){
      $("#create_receipt").get(0).checked = true;
    }else{
      $("#create_receipt").get(0).checked = false;
    }
  });
  <?php endif ?>

  <?php if (PAYMENTS_ONLINE): ?>
  $('#method').change(function(){
    if( $(this).val() == "stripe" ){
      $('#credit_card').slideDown();
    }else{
      $('#credit_card').slideUp();
    }
  }).trigger("change");

  $("#ccnumber").mask("9999 9999 9999 9999");
  $("#cvv").mask("999");
  <?php endif ?>
</script>
