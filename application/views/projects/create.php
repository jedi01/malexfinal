<?php
$this->load->enqueue_style("assets/vendor/jquery.autocomplete/easy-autocomplete.css", "custom");
$this->load->enqueue_script("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js", "custom");
$this->load->enqueue_script("assets/js/libs/select2.min.js", "custom");
echo $this->load->css("custom");
echo $this->load->javascript("custom");
$label_params = array(
  "class" => "form-control-label"
);
$name = array(
  'name'         => 'project[name]',
  'id'           => 'name',
  'value'        => "",
  'class'        => "form-control",
  'placeholder'  => lang("name"),
  'tabindex'     => "1",
  'autocomplete' => "off"
);
$biller = array(
  'name'         => 'biller',
  'id'           => 'biller_id',
  'value'        => "",
  'class'        => "form-control",
);
$biller_id_hidden = array(
  'type'         => 'hidden',
  'name'         => 'project[biller_id]',
  'value'        => "",
);
$billing_type = array(
  "id"           => "billing_type",
  "class"        => "form-control",
);
$status = array(
  "id"           => "status",
  "class"        => "form-control",
);
$estimated_hours = array(
  "id"           => 'estimated_hours',
  "name"         => 'project[estimated_hours]',
  "value"        => "0",
  "class"        => "form-control",
  "autocomplete" => "off",
  "type"         => "number",
  "step"         => "1",
  "min"          => "0",
);
$rate = array(
  "id"           => 'rate',
  "name"         => 'project[rate]',
  "value"        => "0",
  "class"        => "form-control",
  "autocomplete" => "off",
  "type"         => "number",
  "step"         => "any",
  "min"          => "0",
);
$progress = array(
  "id"           => 'progress',
  "name"         => 'project[progress]',
  "value"        => "0",
  "class"        => "form-control",
  "autocomplete" => "off",
  "type"         => "number",
  "step"         => "any",
  "min"          => "0",
  "max"          => "100",
);
$members = array(
  "id"           => 'members',
  "class"        => "form-control",
);
$date = array(
  "id"           => "date",
  "class"        => "form-control"
);
$date_hidden = array(
  'type'         => 'hidden',
  'name'         => 'project[date]',
  'value'        => date_MYSQL_JS(date("Y-m-d")),
);
$date_due = array(
  "id"           => "date_due",
  "class"        => "form-control"
);
$date_due_hidden = array(
  'type'         => 'hidden',
  'name'         => 'project[date_due]',
  'value'        => "",
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("projects/create", array('class' => 'form-horizontal'));?>


<div class="row">
  <div class="col-md-12">
    <!-- PROJECT NAME -->
    <div class="m-a-0 form-group required">
      <?php echo lang('project_name', 'name', $label_params); ?>
      <?php echo form_input($name); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
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
</div>
<div class="row">
  <div class="col-md-6">
    <!-- TYPE -->
    <div class="form-group m-a-0 required">
      <?php echo lang('billing_type', 'billing_type', $label_params); ?>
      <?php echo form_dropdown('project[billing_type]', $this->settings_model->getProjectBillingTypes(), '', $billing_type); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row row-equal">
      <div class="col-md-7">
        <div class="m-a-0 form-group required">
          <?php echo lang('total_rate', 'rate', $label_params); ?>
          <?php echo form_input($rate); ?>
        </div>
      </div>
      <div class="col-md-5">
        <div class="m-a-0 form-group required">
          <?php echo lang('currency', 'currency', $label_params); ?>
          <?php
          echo '<select name="project[currency]" id="currency" class="form-control">';
            foreach ($this->settings_model->getFormattedCurrencies() as $currency) {
              echo "<option value='".$currency->value."' ".($currency->value==CURRENCY_PREFIX?"selected='selected'":"" ).">".$currency->label."</option>";
            }
          echo "</select>";
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <!-- STATUS -->
    <div class="form-group m-a-0 required">
      <?php echo lang('status', 'status', $label_params); ?>
      <?php echo form_dropdown('project[status]', $this->settings_model->getProjectStatus(), '', $status); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="m-a-0 form-group required">
      <?php echo lang('progress', 'progress', $label_params); ?>
      <?php echo form_input($progress); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="m-a-0 form-group required">
      <?php echo lang('estimated_hours', 'estimated_hours', $label_params); ?>
      <?php echo form_input($estimated_hours); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="m-a-0 form-group required">
      <?php echo lang('members', 'members', $label_params); ?>
      <?php echo form_multiselect("project[members][]", $this->projects_model->getAllMembers(), "", $members); ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
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
  <div class="col-md-6">
    <!-- DUE DATE -->
    <div class="form-group">
        <?php echo lang('deadline', 'date_due', $label_params); ?><br>
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
    <textarea class="form-control" rows="3" name="project[description]" id="editor_description"></textarea>
  </div>
</div>

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
  $('#project_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#project_tabs a[href="#tab_basic"]').tab('show');

  $('#members').select2();
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
          $('input[name="project[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="project[date]"]').val("");
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
          $('input[name="project[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="project[date_due]"]').val("");
      }
  });
  if( $('input[name="project[date]"]').val() != "" ){
      $("#date").datepicker("setDate",date_locale($('input[name="project[date]"]').val(), "en", globalLang["lang"]));
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

  /*
   *  BILLER (AUTOCOMPLETE)
   */
  var selected_biller = null;
  $('#biller_id')
  .change(function(){
      if( $(this).val() == "" ){
          selected_biller = null;
          $('input[name="project[biller_id]"]').val("");
      }
  })
  .blur(function(){
      if( selected_biller != null && $(this).val() != selected_biller.fullname ){
          $('input[name="project[biller_id]"]').val(selected_biller.id);
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
              $('input[name="project[biller_id]"]').val(data.id).trigger("change");
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
      $('<input name="project[attachments][]" value="'+file.id+'" type="hidden">').appendTo(item);
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

  // billing_type
  var last_rate = undefined;
  $('#billing_type').on("change", function(){
    if( $(this).val() == "fixed_rate" || $(this).val() == "project_hours" ){
      if( $('#rate').is(".disabled") ){
        $("#rate").removeClass("disabled").removeAttr("disabled").val(last_rate);
        last_rate = undefined;
      }
    }

    if( $(this).val() == "fixed_rate" ){
      $('label[for=rate]').text(globalLang["total_rate"]);
    }
    else if( $(this).val() == "project_hours" ){
      $('label[for=rate]').text(globalLang["rate_per_hour"]);
    }
    else{
      last_rate = $('#rate').val();
      $("#rate").addClass("disabled").attr("disabled", "disabled").val(0);
    }
  }).trigger("change");

  $('#name').focus();
</script>
