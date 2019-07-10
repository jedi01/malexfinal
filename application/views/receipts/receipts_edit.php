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
  'name'         => 'receipt[details]',
  'id'           => 'details',
  'value'        => set_value("receipt[details]", $receipt->details),
  'class'        => 'form-control',
  'rows'         => 2,
  'autocomplete' => "off"
);
$invoice_input = array(
  "id" => "invoice_input",
  "class" => "form-control",
  'autocomplete' => "off",
  "value" => $invoice->reference
);
$biller_input = array(
  "id" => "biller_input",
  "class" => "form-control",
  'autocomplete' => "off",
  "value" => $biller->fullname
);
$invoice_js = isset($invoice)?$invoice:null;
$biller_js = isset($biller)?$biller:null;
$currency = isset($invoice)?$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native:CURRENCY_SYMBOL;
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("receipts/edit?id=".$receipt->id, array('class' => 'form-horizontals'));?>
<div class="row">
  <div class="col-md-5 col-md-offset-1">

    <!-- NUMBER -->
    <div class="form-group required">
      <?php echo lang('receipt_no', 'number', $label_params); ?>
      <div class="input-group">
        <span class="input-group-addon"><?php echo RECEIPT_PREFIX ?></span>
        <input type="number" step="1" min="0" value="<?php echo set_value("receipt[number]", $receipt->number) ?>" name="receipt[number]" tabindex="1" class="form-control" id="number" />
      </div>
    </div>
    <!-- cash_in -->
    <div class="form-group required">
      <?php echo lang('cash_in', 'cash_in', $label_params); ?>
      <div class="input-group">
        <input type="number" step="any" min="0" value="<?php echo set_value("receipt[cash_in]", $receipt->cash_in) ?>" name="receipt[cash_in]" class="form-control" id="cash_in" />
        <span class="input-group-addon" ><?php echo $currency; ?></span>
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
        echo form_hidden('receipt[date]', set_value('receipt[date]', date_MYSQL_JS($receipt->date)));
        ?>
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      </div>
    </div>
    <!-- METHOD -->
    <div class="form-group required">
      <?php echo lang('payment_method', 'method', $label_params); ?>
      <?php
      $methods = $this->settings_model->getPaymentsMethods();
      echo form_dropdown('receipt[method]', $methods, set_value("receipt[method]", $receipt->method), $method);
      ?>
    </div>
  </div>

  <div class="col-md-5 col-md-offset-1">
    <!-- Invoice -->
    <div class="form-group required">
      <?php echo lang('invoice', 'invoice_input', $label_params); ?>
      <div class="input-group">
        <?php
        echo form_input($invoice_input);
        echo form_hidden('receipt[invoice_id]', set_value('receipt[invoice_id]', $receipt->invoice_id));
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <!-- Invoice -->
    <div class="form-group required">
      <?php echo lang("customer", 'biller_input', $label_params); ?>
      <div class="input-group">
        <?php
        echo form_input($biller_input);
        echo form_hidden('receipt[biller_id]', set_value('receipt[biller_id]', $receipt->biller_id));
        ?>
      </div>
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

<script src="<?php echo base_url("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/jquery.autocomplete/easy-autocomplete.css") ?>">
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
          $('input[name="receipt[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="receipt[date]"]').val("");
      }
  });
  if( $('input[name="receipt[date]"]').val() != "" ){
    $("#date").datepicker("setDate",date_locale($('input[name="receipt[date]"]').val(), "en", globalLang["lang"]));
  }else{
    $("#date").trigger("changeDate");
  }


  /*
   *  BILLER (AUTOCOMPLETE)
   */
  var selected_biller = <?php echo json_encode($biller_js); ?>;
  $('#biller_input')
  .change(function(){
      if( $(this).val() == "" ){
          selected_biller = null;
          $('input[name="receipt[biller_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_biller != null && $(this).val() != selected_biller.fullname ){
          $('input[name="receipt[biller_id]"]').val(selected_biller.id);
          $(this).val(selected_biller.fullname);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/billers/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["customer_suggestion_placeholder"],
      minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
      use_on_focus: true,
      list: {
          maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#biller_input").getSelectedItemData();
              $('input[name="receipt[biller_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_biller = data;
          }
      }
  });



  /*
   *  INVOICE (AUTOCOMPLETE)
   */
  var selected_invoice = <?php echo json_encode($invoice_js); ?>;
  $('#invoice_input')
  .change(function(){
      if( $(this).val() == "" ){
          selected_invoice = null;
          $('input[name="receipt[invoice_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_invoice != null && $(this).val() != selected_invoice.reference ){
          $('input[name="receipt[invoice_id]"]').val(selected_invoice.id);
          $(this).val(selected_invoice.reference);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/invoices/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["reference"],
      minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
      use_on_focus: true,
      list: {
          maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#invoice_input").getSelectedItemData();
              $('input[name="receipt[invoice_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_invoice = data;
              $("#biller_input").val(data.biller.fullname);
              $('input[name="receipt[biller_id]"]').val(data.biller.id).trigger("change");
              $('input[name="receipt[cash_in]"]').next('.input-group-addon').text(getFormatedCurrency(data.currency));
              selected_biller = data.biller;
          }
      }
  });
</script>
