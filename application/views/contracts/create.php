<?php
$this->load->enqueue_style("assets/vendor/jquery.autocomplete/easy-autocomplete.css", "custom");
$this->load->enqueue_script("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js", "custom");
$this->load->enqueue_script("assets/js/libs/select2.min.js", "custom");
echo $this->load->css("custom");
echo $this->load->javascript("custom");
$label_params = array(
  "class" => "form-control-label"
);
$subject = array(
  'name'         => 'contract[subject]',
  'id'           => 'subject',
  'value'        => set_value("contract[subject]", ""),
  'class'        => "form-control",
  'placeholder'  => lang("subject"),
  'tabindex'     => "1",
  'autocomplete' => "off"
);
$biller = array(
  'name'         => 'biller',
  'id'           => 'biller_id',
  'value'        => set_value("biller", ""),
  'class'        => "form-control",
);
$biller_id_hidden = array(
  'type'         => 'hidden',
  'name'         => 'contract[biller_id]',
  'value'        => set_value("contract[biller_id]", ""),
);
$amount = array(
  "id"           => 'amount',
  "name"         => 'contract[amount]',
  "value"        => set_value('contract[amount]', "0"),
  "class"        => "form-control",
  "autocomplete" => "off",
  "type"         => "number",
  "step"         => "any",
  "min"          => "0",
);
$type = array(
  'name'         => 'contract[type]',
  "id"           => "type",
  "class"        => "form-control",
  'value'        => set_value("contract[type]", ""),
);
$date = array(
  "id"           => "date",
  "class"        => "form-control"
);
$date_hidden = array(
  'type'         => 'hidden',
  'name'         => 'contract[date]',
  'value'        => set_value("contract[date]", date_MYSQL_JS(date("Y-m-d"))),
);
$date_due = array(
  "id"           => "date_due",
  "class"        => "form-control"
);
$date_due_hidden = array(
  'type'         => 'hidden',
  'name'         => 'contract[date_due]',
  'value'        => set_value("contract[date_due]", ""),
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("contracts/create", array('class' => 'form-horizontal'));?>
<?php echo form_hidden('contract[count]', $next_count); ?>
<?php echo form_hidden('contract[reference]', $next_reference); ?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="contract_tabs">
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_basic"><?php echo lang('basic_informations') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_attachments"><?php echo lang('attachments') ?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane form-horizontal" id="tab_basic">

<div class="row">
  <div class="col-md-5 col-md-offset-1">
    <!-- REFERENCE -->
    <div class="m-a-0 form-group ">
      <?php echo lang('reference', 'reference', $label_params); ?>
      <span class="form-control"><?php echo $next_reference ?></span>
    </div>
  </div>
  <div class="col-md-5">
    <!-- SUBJECT -->
    <div class="m-a-0 form-group required">
      <?php echo lang('subject', 'subject', $label_params); ?>
      <?php echo form_input($subject); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-5 col-md-offset-1">
    <!-- AMOUNT -->
    <div class="m-a-0 form-group required">
      <?php echo lang('contract_value', 'amount', $label_params); ?>
      <?php echo form_input($amount); ?>
    </div>
  </div>
  <div class="col-md-5">
    <div class="m-a-0 form-group required">
      <?php echo lang('currency', 'currency', $label_params); ?>
      <?php
      echo '<select name="contract[currency]" id="currency" class="form-control">';
        foreach ($this->settings_model->getFormattedCurrencies() as $currency) {
          echo "<option value='".$currency->value."' ".($currency->value==CURRENCY_PREFIX?"selected='selected'":"" ).">".$currency->label."</option>";
        }
      echo "</select>";
      ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-5 col-md-offset-1">
    <!-- CUSTOMER -->
    <div class="form-group m-a-0 required">
        <?php echo lang("customer", 'biller_id', $label_params); ?>
        <?php echo form_input($biller_id_hidden); ?>
        <div class="input-group">
            <?php echo form_input($biller); ?>
            <span class="input-group-btn">
                <a href="<?php echo site_url("billers/create") ?>" sis-modal="" class="btn btn-secondary tip sis_modal" title="<?php echo lang("add") ?>" ><i class="fa fa-plus"></i></a>
            </span>
        </div>
    </div>
  </div>
  <div class="col-md-5">
    <!-- TYPE -->
    <div class="form-group m-a-0 required">
      <?php echo lang('contract_type', 'type', $label_params); ?>
      <?php echo form_input($type); ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-5 col-md-offset-1">
    <!-- DATE -->
    <div class="form-group required">
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
  <div class="col-md-5">
    <!-- DUE DATE -->
    <div class="form-group">
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
</div>

<div class="form-group row">
  <div class="col-md-12">
    <textarea class="form-control" rows="3" name="contract[description]" id="editor_description"><?php echo set_value("contract[description]", $this->settings_model->SYS_Settings->df_contract_desc) ?></textarea>
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

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
  $('#contract_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#contract_tabs a[href="#tab_basic"]').tab('show');
  $('#currency').select2({dropdownAutoWidth: true, width: 'resolve'});

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
          $('input[name="contract[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="contract[date]"]').val("");
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
          $('input[name="contract[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="contract[date_due]"]').val("");
      }
  });
  if( $('input[name="contract[date]"]').val() != "" ){
      $("#date").datepicker("setDate",date_locale($('input[name="contract[date]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#date").trigger("changeDate");
  }

  // description
  tinymce.remove("#editor_description");
  tinymce.init(
    Object.assign({}, tinymce_init, {
      selector: '#editor_description',
      height: 150,
    })
  );

  // type
  $('#type').easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/contracts/suggestions_type?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["contract_type_ph"],
      minCharNumber: 0,
      use_on_focus: false,
      list: {
        maxNumberOfElements: 3,
        hideOnEmptyPhrase: false
      }
  });

  /*
   *  BILLER (AUTOCOMPLETE)
   */
  var selected_biller = null;
  $('#biller_id')
  .change(function(){
      if( $(this).val() == "" ){
          selected_biller = null;
          $('input[name="contract[biller_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_biller != null && $(this).val() != selected_biller.fullname ){
          $('input[name="contract[biller_id]"]').val(selected_biller.id);
          $(this).val(selected_biller.fullname);
      }
  })
  .easyAutocomplete({
      url: function(phrase) {return SITE_URL+"/billers/suggestions?term=" + phrase;},
      ajaxSettings: {data: CSRF_DATA},
      getValue: "label",
      placeholder: globalLang["customer_suggestion_placeholder"],
      minCharNumber: 2,
      use_on_focus: false,
      list: {
          maxNumberOfElements: 3,
          hideOnEmptyPhrase: false,
          onSelectItemEvent: function() {
              var data = $("#biller_id").getSelectedItemData();
              $('input[name="contract[biller_id]"]').val(data.id).trigger("change");
              $('.easy-autocomplete').css("width","inherit");
              selected_biller = data;
          }
      }
  });

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
      $('<input name="contract[attachments][]" value="'+file.id+'" type="hidden">').appendTo(item);
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
  $('#subject').focus();
</script>
