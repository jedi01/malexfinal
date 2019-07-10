<?php
$label_params = array(
  "class" => "form-control-label"
);
$date = array(
  "id" => "date_input",
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
  'value'        => set_value("receipt[details]", ""),
  'class'        => 'form-control',
  'rows'         => 2,
  'autocomplete' => "off"
);
$purchase_input = array(
  "id" => "purchase_input",
  "class" => "form-control",
  'autocomplete' => "off",
  "value" => isset($purchase)?$purchase->reference:""
);
$supplier_input = array(
  "id" => "supplier_input",
  "class" => "form-control",
  'autocomplete' => "off",
  "value" => isset($supplier)?$supplier->fullname:""
);
$amount = isset($purchase)?$purchase->total_due:"0";
$currency = isset($purchase)?$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native:CURRENCY_SYMBOL;
$purchase_id = isset($purchase)?$purchase->id:"";
$purchase_js = isset($purchase)?$purchase:null;
$supplier_id = isset($supplier)?$supplier->id:"";
$supplier_js = isset($supplier)?$supplier:null;
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("purchase_receipts/create/", array('class' => 'form-horizontals'));?>
<div class="row">
  <div class="col-md-5 col-md-offset-1">

    <!-- NUMBER -->
    <div class="form-group required">
      <?php echo lang('receipt_no', 'number', $label_params); ?>
      <div class="input-group">
        <span class="input-group-addon"><?php echo RECEIPT_PREFIX ?></span>
        <input type="number" step="1" min="<?php echo $next_number ?>" value="<?php echo set_value("receipt[number]", $next_number) ?>" name="receipt[number]" tabindex="1" class="form-control" id="number" />
      </div>
    </div>
    <!-- AMOUNT -->
    <div class="form-group required">
      <?php echo lang('amount', 'amount', $label_params); ?>
      <div class="input-group">
        <input type="number" step="any" min="0" value="<?php echo set_value("receipt[amount]", $amount) ?>" name="receipt[amount]" class="form-control" id="amount" />
        <span class="input-group-addon" ><?php echo $currency ?></span>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <!-- DATE -->
    <div class="form-group required">
      <?php echo lang('date', 'date_input', $label_params); ?>
      <div class="input-group">
        <?php
        echo form_input($date);
        echo form_hidden('receipt[date]', set_value('receipt[date]', date_MYSQL_JS(date("Y-m-d"))));
        ?>
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      </div>
    </div>
    <!-- METHOD -->
    <div class="form-group required">
      <?php echo lang('payment_method', 'method', $label_params); ?>
      <?php
      $methods = $this->settings_model->getPaymentsMethods(false,false);
      echo form_dropdown('receipt[method]', $methods, set_value("receipt[method]", ""), $method);
      ?>
    </div>
  </div>

  <div class="col-md-5 col-md-offset-1">
    <!-- purchase -->
    <div class="form-group required">
      <?php echo lang('purchase', 'purchase_input', $label_params); ?>
      <?php
      echo form_input($purchase_input);
      echo form_hidden('receipt[purchase_id]', set_value('receipt[purchase_id]', $purchase_id));
      ?>
    </div>
  </div>

  <div class="col-md-5">
    <!-- purchase -->
    <div class="form-group required">
      <?php echo lang("customer", 'supplier_input', $label_params); ?>
      <?php
      echo form_input($supplier_input);
      echo form_hidden('receipt[supplier_id]', set_value('receipt[supplier_id]', $supplier_id));
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
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>

<script src="<?php echo base_url("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/jquery.autocomplete/easy-autocomplete.css") ?>">
<script type="text/javascript">
  $.fn.datepicker.defaults.language = globalLang["lang"];
  $("#date_input")
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
    $("#date_input").datepicker("setDate",date_locale($('input[name="receipt[date]"]').val(), "en", globalLang["lang"]));
  }else{
    $("#date_input").trigger("changeDate");
  }



  /*
   *  supplier (AUTOCOMPLETE)
   */
  var selected_supplier = <?php echo json_encode($supplier_js); ?>;
  $('#supplier_input')
  .change(function(){
      if( $(this).val() == "" ){
          selected_supplier = null;
          $('input[name="receipt[supplier_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_supplier != null && $(this).val() != selected_supplier.fullname ){
          $('input[name="receipt[supplier_id]"]').val(selected_supplier.id);
          $(this).val(selected_supplier.fullname);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/suppliers/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["customer_suggestion_placeholder"],
      minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
      use_on_focus: true,
      list: {
          maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#supplier_input").getSelectedItemData();
              $('input[name="receipt[supplier_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_supplier = data;
          }
      }
  });



  /*
   *  purchase (AUTOCOMPLETE)
   */
  var selected_purchase = <?php echo json_encode($purchase_js); ?>;
  $('#purchase_input')
  .change(function(){
      if( $(this).val() == "" ){
          selected_purchase = null;
          $('input[name="receipt[purchase_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_purchase != null && $(this).val() != selected_purchase.reference ){
          $('input[name="receipt[purchase_id]"]').val(selected_purchase.id);
          $(this).val(selected_purchase.reference);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/purchases/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["reference"],
      minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
      use_on_focus: true,
      list: {
          maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#purchase_input").getSelectedItemData();
              $('input[name="receipt[purchase_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_purchase = data;
              $("#supplier_input").val(data.supplier.fullname);
              $('input[name="receipt[supplier_id]"]').val(data.supplier.id).trigger("change");
              $('input[name="receipt[amount]"]').val(Format_float(data.total_due));
              $('input[name="receipt[amount]"]').next('.input-group-addon').text(getFormatedCurrency(data.currency));
              selected_supplier = data.supplier;
          }
      }
  });

</script>
