<?php
$label_params = array(
  "class" => "form-control-label"
);
$date = array(
  "id"           => "date",
  "class"        => "form-control"
);
$date_hidden = array(
  'type'         => 'hidden',
  'name'         => 'expense[date]',
  'value'        => set_value("expense[date]", date_MYSQL_JS($expense->date)),
);
$date_due = array(
  "id"           => "date_due",
  "class"        => "form-control"
);
$date_due_hidden = array(
  'type'         => 'hidden',
  'name'         => 'expense[date_due]',
  'value'        => set_value("expense[date_due]", date_MYSQL_JS($expense->date_due)),
);
$payment_date = array(
  "id"           => "payment_date",
  "class"        => "form-control"
);
$payment_date_hidden = array(
  'type'         => 'hidden',
  'name'         => 'expense[payment_date]',
  'value'        => set_value("expense[payment_date]", date_MYSQL_JS($expense->payment_date)),
);
$category = array(
  "id"           => "category",
  "class"        => "form-control"
);
$method = array(
  "id" => "method",
  "class" => "form-control",
  'autocomplete' => "off"
);
$exp_status = array(
  "id" => "exp_status",
  "class" => "form-control",
  'autocomplete' => "off"
);
$details = array(
  'name'         => 'expense[details]',
  'id'           => 'editor_details',
  'value'        => html_entity_decode(set_value("expense[details]", $expense->details)),
  'class'        => 'form-control',
  'rows'         => 5,
  'autocomplete' => "off"
);
$reference = array(
  'name'         => 'expense[reference]',
  'id'           => 'reference',
  'value'        => set_value("expense[reference]", $expense->reference),
  "class"        => "form-control",
  "placeholder"  => lang("invoice_number"),
  'autocomplete' => "off",
);
$supplier_input = array(
  "id" => "supplier_input",
  "class" => "form-control",
  'autocomplete' => "off",
  "value" => isset($supplier)?$supplier->fullname:""
);
$supplier_id = isset($supplier)?$supplier->id:"";
$supplier_js = isset($supplier)?$supplier:null;
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("expenses/edit/".$expense->id, array('class' => 'form-horizontals'));?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="expense_tabs">
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_basic"><?php echo lang('basic_informations') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_additional"><?php echo lang('additional_content') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_attachments"><?php echo lang('attachments') ?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane form-horizontal" id="tab_basic">
        <div class="row">
          <!-- NUMBER -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('expense_no', 'number', $label_params); ?>
              <div class="input-group">
                <span class="input-group-addon"><?php echo EXPENSE_PREFIX ?></span>
                <input type="number" step="1" min="1" value="<?php echo set_value("expense[number]", $expense->number) ?>" name="expense[number]" tabindex="1" class="form-control" id="number" />
              </div>
            </div>
          </div>

          <!-- SUPPLIER -->
          <div class="col-md-6">
            <div class="form-group m-a-0">
              <?php echo lang("supplier", 'supplier_input', $label_params); ?>
              <?php
              echo form_input($supplier_input);
              echo form_hidden('expense[supplier_id]', set_value('expense[supplier_id]', $supplier_id));
              ?>
            </div>
          </div>

          <!-- DATE -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
                <?php echo lang('date', 'date', $label_params); ?><br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <?php
                    echo form_input($date);
                    echo form_input($date_hidden);
                  ?>
                </div>
            </div>
          </div>

          <!-- DUE DATE -->
          <div class="col-md-6">
            <div class="form-group m-a-0">
                <?php echo lang('date_due', 'date_due', $label_params); ?><br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <?php
                    echo form_input($date_due);
                    echo form_input($date_due_hidden);
                  ?>
                </div>
            </div>
          </div>

          <!-- CATEGORY -->
          <div class="col-md-12">
            <div class="form-group m-a-0 required">
              <?php echo lang('category', 'category', $label_params); ?>
              <?php
              foreach ($categories as $cat) {
                $cats[$cat["type"]][$cat["label"]] = $cat["label"];
              }
              echo form_dropdown('expense[category]', $cats, $expense->category, $category);
              ?>
            </div>
          </div>

          <!-- AMOUNT -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('amount', 'amount', $label_params); ?>
              <div class="input-group">
                <input type="number" step="any" min="0" value="<?php echo set_value("expense[amount]", $expense->amount) ?>" name="expense[amount]" class="form-control" id="amount" />
                <span class="input-group-addon" ><?php echo CURRENCY_SYMBOL ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('currency', 'currency', $label_params); ?>
              <?php
              echo '<select name="expense[currency]" id="currency" class="form-control">';
              foreach ($this->settings_model->getFormattedCurrencies() as $currency) {
                  echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".($currency->value==$expense->currency?"selected='selected'":"" ).">".$currency->label."</option>";
              }
              echo "</select>";
              ?>
            </div>
          </div>

          <!-- METHOD -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('payment_method', 'method', $label_params); ?>
              <?php
              $methods = $this->settings_model->getPaymentsMethods();
              $methods = array_merge(array(""=>lang("unpaid")), $methods);
              echo form_dropdown('expense[payment_method]', $methods, set_value("expense[payment_method]", $expense->payment_method), $method);
              ?>
            </div>
          </div>

          <!-- STATUS -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('status', 'exp_status', $label_params); ?>
              <?php
              $status = array(
                "unpaid" => lang("unpaid"),
                "partial" => lang("partial"),
                "paid" => lang("paid"),
              );
              echo form_dropdown('expense[status]', $status, set_value("expense[status]", $expense->status), $exp_status);
              ?>
            </div>
          </div>

          <!-- TAX -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('tax', 'tax', $label_params); ?>
              <?php
              $taxes = array();
              foreach ($tax_rates as $tax) {
                if( strpos($tax['label'], "lang:") === false ){
                  $taxes[$tax['id']] = $tax['label']." (".$tax['value']." ".($tax['type']==0?"%":CURRENCY_SYMBOL).")";
                }else{
                  $taxes[$tax['id']] = lang(substr($tax['label'], 5));
                }
              }
              echo form_dropdown('expense[tax_id]', $taxes, $expense->tax_id, 'class="form-control" id="tax"');
              ?>
              <input type="hidden" name="expense[tax_type]" value="<?php echo $expense->tax_type ?>" id="tax_type">
              <input type="hidden" name="expense[tax_value]" value="<?php echo $expense->tax_value ?>" id="tax_value">
              <input type="hidden" name="expense[tax_total]" value="<?php echo $expense->tax_total ?>" id="tax_total">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group m-a-0">
              <?php echo lang('global_tax', 'global_tax', $label_params); ?>
              <div class="input-group">
                <span class="form-control" id="global_tax">0.00</span>
                <span class="input-group-addon" ><?php echo CURRENCY_SYMBOL ?></span>
              </div>
            </div>
          </div>

          <!-- TOTAL -->
          <div class="col-md-6">
            <div class="form-group m-a-0 required">
              <?php echo lang('total', 'total', $label_params); ?>
              <div class="input-group">
                <span class="form-control" id="total_shown"><?php echo $expense->total ?></span>
                <input type="hidden" name="expense[total]" value="<?php echo $expense->total ?>" id="total">
                <span class="input-group-addon" ><?php echo CURRENCY_SYMBOL ?></span>
              </div>
            </div>
            <div class="form-group m-a-0 required">
              <?php echo lang('paid_amount', 'paid_amount', $label_params); ?>
              <div class="input-group">
                <input type="number" step="any" min="0" value="0" class="form-control" id="paid_amount" />
                <span class="input-group-addon" ><?php echo CURRENCY_SYMBOL ?></span>
              </div>
            </div>
            <div class="form-group m-a-0 required">
                <?php echo lang('payment_date', 'payment_date', $label_params); ?><br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <?php
                    echo form_input($payment_date);
                    echo form_input($payment_date_hidden);
                  ?>
                </div>
            </div>
            <div class="form-group m-a-0">
              <?php echo lang('amount_due', 'total_due', $label_params); ?>
              <div class="input-group">
                <span class="form-control" id="total_due">0.00</span>
                <input type="hidden" readonly="readonly" value="0" name="expense[total_due]" id="amount_due" />
                <span class="input-group-addon" ><?php echo CURRENCY_SYMBOL ?></span>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="tab-pane form-horizontal" id="tab_additional">
        <div class="row">
          <!-- Invoice Reference -->
          <div class="col-md-6">
            <div class="form-group m-a-0">
              <?php echo lang('reference', 'reference', $label_params); ?>
              <?php
              echo form_input($reference);
              ?>
            </div>
          </div>
          <!-- DETAILS -->
          <div class="col-md-12">
            <div class="form-group m-a-0">
              <?php echo lang('details', 'editor_details', $label_params); ?>
              <?php echo form_textarea($details); ?>
            </div>
          </div>
        </div>
    </div>
    <div class="tab-pane form-horizontal" id="tab_attachments">
      <a class="btn btn-secondary attach_file" ><i class="fa fa-paperclip"></i> <?php echo lang("add_attached_file") ?></a>
      <div class="form-group m-b-0">
        <div class="attachments">
          <ul></ul>
        </div>
      </div>
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

<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/jquery.autocomplete/easy-autocomplete.css") ?>">
<script src="<?php echo base_url("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js") ?>"></script>
<script type="text/javascript">
  $('#expense_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#expense_tabs a[href="#tab_basic"]').tab('show');


  /* DATES */
  $.fn.datepicker.defaults.language = globalLang["lang"];
  $("#date, #date_due").mask(MASK_DATE,{placeholder:JS_DATE});

  $("#date").datepicker({
      "todayHighlight": true,
      "format": DATEPICKER_FORMAT
  })
  .on("changeDate", function(){
      $("#date_due").datepicker("setStartDate", $("#date").datepicker("getDate"));
  })
  .on("change", function(){
      if( $(this).datepicker("getDate") != null ){
          $('input[name="expense[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="expense[date]"]').val("");
      }
  });

  $("#date_due").datepicker({
      "todayHighlight": true,
      "clearBtn": true,
      "format": DATEPICKER_FORMAT
  })
  .on("changeDate", function(){
      $("#date").datepicker("setEndDate", $("#date_due").datepicker("getDate"));
  })
  .on("change", function(){
      if( $(this).datepicker("getDate") != null ){
          $('input[name="expense[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="expense[date_due]"]').val("");
      }
  });
  if( $('input[name="expense[date]"]').val() != "" ){
      $("#date").datepicker("setDate",date_locale($('input[name="expense[date]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#date").trigger("changeDate");
  }
  if( $('input[name="expense[date_due]"]').val() != "" ){
      $("#date_due").datepicker("setDate",date_locale($('input[name="expense[date_due]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#date_due").trigger("changeDate");
  }

  $("#payment_date").datepicker({
    "todayHighlight": true,
    "clearBtn": true,
    "format": DATEPICKER_FORMAT
  })
  .on("change", function(){
    if( $(this).datepicker("getDate") != null ){
      $('input[name="expense[payment_date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
    }else{
      $('input[name="expense[payment_date]"]').val("");
    }
  });
  if( $('input[name="expense[payment_date]"]').val() != "" ){
      $("#payment_date").datepicker("setDate",date_locale($('input[name="expense[payment_date]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#payment_date").trigger("changeDate");
  }

  // Category
  $('#category').select2();

  // details
  tinymce.remove("#editor_details");
  tinymce.init(
      Object.assign({}, tinymce_init_mini, {
          selector: '#editor_details',
          height: 150,
      })
  );

  // attachments
  $('.attach_file').click(function(e){
    $(document).sis_modal({
      url: SITE_URL+"/files/select",
      is_big: true,
      callback: function(data){
        if( data != undefined ){
          for (var i = 0; i < data.length; i++) {
            $.attachments.add(data[i]);
          }
        }
      }
    });
    e.preventDefault();
    return false;
  });
  $.attachments = {
    add: function(file){
      var index = Math.floor(Math.random() * 9999999) + 1000000 ;
      var self = this;
      var item = $('<li></li>');
      $('<span class="label label-default label-bill">'+file.extension.substring(1)+'</span> ').appendTo(item);
      $('<b> '+file.filename+file.extension+' </b>').appendTo(item);
      $('<i> ('+Format_size(file.size*1024)+') </i>').appendTo(item);
      $('<input name="expense[attachments][]" value="'+file.id+'" type="hidden">').appendTo(item);
      var quickMenu = $('<span class="quickMenu"></span>');
      $('<a href="'+SITE_URL+'/files/download/'+file.link+'"><i class="fa fa-download"></i></a>').appendTo(quickMenu);
      $('<a href="#" class="remove_attachement"><i class="fa fa-trash"></i></a>').appendTo(quickMenu);
      $(quickMenu).appendTo(item);

      $(item).appendTo($(".attachments ul"));
      $(item).find(".remove_attachement").click(function(){
          self.remove(item);
          return false;
      });
      return item;
    },
    remove : function(item){
        $(item).remove();
    },
  }
  <?php
  if (isset($attached_files)){
    foreach ($attached_files as $file){
      echo "$.attachments.add(".json_encode($file).");";
    }
  }
  ?>

  /*
   *  supplier (AUTOCOMPLETE)
   */
  var selected_supplier = <?php echo json_encode($supplier_js); ?>;
  $('#supplier_input')
  .change(function(){
      if( $(this).val() == "" ){
          selected_supplier = null;
          $('input[name="expense[supplier_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_supplier != null && $(this).val() != selected_supplier.fullname ){
          $('input[name="expense[supplier_id]"]').val(selected_supplier.id);
          $(this).val(selected_supplier.fullname);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/suppliers/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["supplier_suggestion_placeholder"],
      minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
      use_on_focus: true,
      list: {
          maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#supplier_input").getSelectedItemData();
              $('input[name="expense[supplier_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_supplier = data;
          }
      }
  });

  function getTaxById(id){
    var taxes = <?php echo json_encode($tax_rates) ?>;
    for (var i = taxes.length - 1; i >= 0; i--) {
      if( taxes[i].id == id ){
        return taxes[i];
      }
    }
    return false;
  }

  function calculate_expense(){
    var amount = $('#amount').val();
    var tax = $('#tax').val();
    var global_tax = 0;
    var tax_item = getTaxById(tax);
    if( tax_item.type+"" == "0" ){ // percent %
        global_tax = parseFloat(amount) * (parseFloat(tax_item.value)/100);
    }else{ // flat
        global_tax = parseFloat(tax_item.value);
    }
    var total = parseFloat(amount)+parseFloat(global_tax);
    var total_due = total;
    if( $('#exp_status').val() == 'paid' ){
        total_due = 0;
    }
    if( $('#exp_status').val() == 'partial' ){
        total_due = total - parseFloat($('#paid_amount').val());
    }
    $('#total_due').text(Format_Currency(total_due));
    $('#tax_type').val(tax_item.type);
    $('#tax_value').val(tax_item.value);
    $('#tax_total').val(global_tax);
    $('#amount_due').val(total_due);
    $('#global_tax').text(Format_Currency(global_tax));
    $('#total').val(total);
    $('#total_shown').text(Format_Currency(total));
  }
  calculate_expense();

  $('#amount, #tax, #paid_amount, #exp_status').on("change", function(){
    calculate_expense();
  });

  $('#exp_status').change(function(){
    if( $(this).val() == 'partial' ){
      $('#paid_amount').parents('.form-group').show();
      $('#payment_date').parents('.form-group').hide();
      $('#method').parents('.form-group').show();
    }else if( $(this).val() == 'paid' ){
      $('#paid_amount').parents('.form-group').hide();
      $('#payment_date').parents('.form-group').show();
      $('#method').parents('.form-group').show();
    }else if( $(this).val() == 'unpaid' ){
      $('#paid_amount').parents('.form-group').hide();
      $('#payment_date').parents('.form-group').hide();
      $('#method').parents('.form-group').hide();
    }
  }).trigger("change");

  $('#method').select2();

  /* CURRENCIES */
  $('#currency').select2();
  $('#currency').on("change", function(){
      setCurrency();
  });
  function setCurrency(){
    if( $('#currency').size() > 0 ){
      symbol_native = $("#currency").find('option:selected').attr("symbol_native");
      $('#amount').next(".input-group-addon").text(symbol_native);
      $('#total').next(".input-group-addon").text(symbol_native);
      $('#paid_amount').next(".input-group-addon").text(symbol_native);
      $('#amount_due').next(".input-group-addon").text(symbol_native);
      $('#global_tax').next(".input-group-addon").text(symbol_native);
    }
  }
  setCurrency();
</script>
