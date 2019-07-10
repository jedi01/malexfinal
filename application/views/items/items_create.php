<?php
$name = array(
  'name'         => 'item[name]',
  'id'           => 'name',
  'value'        => set_value("item[name]", ""),
  'class'        => "form-control",
  'tabindex'     => "1",
  'autocomplete' => "off",
);
$description = array(
  'name'         => 'item[description]',
  'id'           => 'description',
  'value'        => set_value("item[description]", ""),
  'class'        => "form-control",
  'autocomplete' => "off"
);
$tax = array(
  'name'         => 'item[tax]',
  'id'           => 'tax',
  'value'        => set_value("item[tax]", "0"),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "number",
  'step'         => "any",
  'min'          => "0"
);
$discount = array(
  'name'         => 'item[discount]',
  'id'           => 'discount',
  'value'        => set_value("item[discount]", "0"),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "number",
  'step'         => "any",
  'min'          => "0"
);
$unit = array(
  'name'         => 'item[unit]',
  'id'           => 'unit',
  'value'        => set_value("item[unit]", ""),
  'class'        => "form-control",
  'autocomplete' => "on",
);
$category = array(
  "id"           => "category",
  "class"        => "form-control"
);
$vat_tax = array(
  "id"           => "vat",
  "class"        => "form-control"
);
if( !empty($this->settings_model->SYS_Settings->item_cf1) ){
  $cf1 = array(
    'name'         => 'item[custom_field1]',
    'id'           => 'cf1',
    'value'        => set_value("item[custom_field1]", ""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf1 = false;
}
if( !empty($this->settings_model->SYS_Settings->item_cf2) ){
  $cf2 = array(
    'name'         => 'item[custom_field2]',
    'id'           => 'cf2',
    'value'        => set_value("item[custom_field2]", ""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf2 = false;
}
if( !empty($this->settings_model->SYS_Settings->item_cf3) ){
  $cf3 = array(
    'name'         => 'item[custom_field3]',
    'id'           => 'cf3',
    'value'        => set_value("item[custom_field3]", ""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf3 = false;
}
if( !empty($this->settings_model->SYS_Settings->item_cf4) ){
  $cf4 = array(
    'name'         => 'item[custom_field4]',
    'id'           => 'cf4',
    'value'        => set_value("item[custom_field4]", ""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf4 = false;
}
?>
<style type="text/css">
.input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
}
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("items/create", array('class' => 'form-horizontal', 'id'=> 'form_item'));?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="create_item">
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#basic_informations"><?php echo lang('basic_informations') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#prices_tab"><?php echo lang('prices') ?></a></li>
    <?php if ($cf1 || $cf2 || $cf3 || $cf4): ?>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#item_custom_fields"><?php echo lang('custom_fields') ?></a></li>
    <?php endif ?>
  </ul>
  <div class="tab-content">
    <div class="tab-pane form-horizontal" id="basic_informations">

      <div class="row form-group required">
        <label class="col-md-3 form-control-label" for="name"><?php echo lang('name');?></label>
        <div class="col-md-9">
          <?php echo form_input($name); ?>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="description"><?php echo lang('description');?></label>
        <div class="col-md-9">
          <?php echo form_input($description); ?>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="unit"><?php echo lang('unit');?></label>
        <div class="col-md-9">
          <?php echo form_input($unit); ?>
        </div>
      </div>

      <!-- CATEGORY -->
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="category"><?php echo lang('category');?></label>
        <div class="col-md-9">
          <?php
          $cats = array(); $default_cat = "";
          $cats[""] = '';
          foreach ($categories as $cat) {
            if( $cat["is_default"] ){
              $default_cat = $cat["id"];
            }
            $cats[$cat["id"]] = $cat["name"];
          }
          echo form_dropdown('item[category]', $cats, $default_cat, $category);
          ?>
        </div>
      </div>


      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="tax"><?php echo lang('vat_tax');?></label>
        <div class="col-md-9">
          <?php
          $taxs = array(); $default_tax = "";
          $taxs[""] = '';
          foreach ($tax_rates as $tax) {
            if( $tax["is_default"] ){
              $default_tax = $tax["id"];
            }
            $taxs[$tax["id"]] = $tax["value"];
          }
          echo form_dropdown('item[vat_rate]', $taxs, $default_tax, $vat_tax);
          ?>
        </div>
      </div>


      <?php if (ITEM_TAX==2): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="tax"><?php echo lang('default_tax');?></label>
        <div class="col-md-9">
          <div class="input-group">
            <?php echo form_input($tax); ?>
            <span class="input-group-addon">
              <?php
              $tax_types = array("%", CURRENCY_SYMBOL);
              echo form_dropdown('item[tax_type]', $tax_types, set_value("item[tax_type]", 2));
              ?>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php if (ITEM_DISCOUNT==2): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="discount"><?php echo lang('default_discount');?></label>
        <div class="col-md-9">
          <div class="input-group">
            <?php echo form_input($discount); ?>
            <span class="input-group-addon">
              <?php
              $discount_types = array("%", CURRENCY_SYMBOL);
              echo form_dropdown('item[discount_type]', $discount_types, set_value("item[discount_type]", 2));
              ?>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
    </div>

    <div class="tab-pane form-horizontal p-a-0" id="prices_tab">
      <div class="form-group required m-a-0">
        <?php echo form_hidden('items_count', '0'); ?>
        <table class="table table-hover m-a-0" id="prices_table">
          <thead class="transparent">
            <tr>
              <th style="width:50%;"><?php echo lang("price") ?></th>
              <th style="width:200px;"><?php echo lang("currency") ?></th>
              <th style="text-align:center"><i class="fa fa-trash"></i></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="p-a-q text-sm-right">
                <small class="text-muted"><?php echo lang("add_new_price") ?></small>
                <button type="button" id="add_price" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php echo lang("add") ?></button>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <?php if ($cf1 || $cf2 || $cf3 || $cf4): ?>
    <div class="tab-pane form-horizontal" id="item_custom_fields">
      <?php if ($cf1): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf1"><?php echo $this->settings_model->SYS_Settings->item_cf1;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf1); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf2): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf2"><?php echo $this->settings_model->SYS_Settings->item_cf2;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf2); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf3): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf3"><?php echo $this->settings_model->SYS_Settings->item_cf3;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf3); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf4): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf4"><?php echo $this->settings_model->SYS_Settings->item_cf4;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf4); ?>
        </div>
      </div>
      <?php endif ?>
    </div>
    <?php endif ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
  $('#create_item a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#create_item a[href="#basic_informations"]').tab('show');


  $('#category').select2({
    allowClear: true,
  });

  $.prices = {
    create : function(price, currency){
      var self = this;
      var currencies = <?php echo json_encode($currencies) ?>;
      var index = Math.floor(Math.random() * 9999999) + 1000000 ;
      var item = $('<tr class="item"></tr>');
      // price
      $('<td class="p-y-q p-x-h">'+
          '<div class="form-group">'+
            '<input type="number" step="any" min="0" value="'+price+'" name="prices['+index+'][price]" class="form-control item_price" />'+
          '</div>'+
      '</td>').appendTo(item);
      // currency
      var select_currency = $('<select name="prices['+index+'][currency]" class="form-control item_currency"></select>');
      $('<option value="" ></option>').appendTo(select_currency);
      for (key in currencies) {
        $('<option value="'+currencies[key].value+'" symbol_native="'+currencies[key].symbol_native+'" >'+currencies[key].label+'</option>').appendTo(select_currency);
      }
      if( currency == "" || currency == undefined ){
        currency = CURRENCY_PREFIX;
      }
      $('<td class="p-y-q p-x-h" style="width:200px !important;min-width:200px !important;max-width:200px !important;">'+
          '<div class="form-group">'+
            $(select_currency).get(0).outerHTML+
          '</div>'+
        '</td>').appendTo(item);
      $(item).find('select').select2().val(currency).change();
      // delete item
      $('<td class="p-y-q p-x-h">'+
          '<button type="button" class="btn btn-link text-danger price_delete tip" title="'+globalLang["delete"]+'"><i class="fa fa-trash"></i></button>'+
      '</td>').appendTo(item);

      $(item).find(".price_delete").click(function(){
          self.delete(item);
          return false;
      });
      // append to table
      $("#prices_table").find("tbody").append(item);
      if( LOAD_FROM_CLICK ){
        $(item).find(".item_price").get(0).focus();
        LOAD_FROM_CLICK = false;
      }
    },
    delete : function(item){
        $(item).remove();
    },
  }
  var LOAD_FROM_CLICK = false;
  $('#add_price').click(function(){
    LOAD_FROM_CLICK = true;
    $.prices.create();
  });

  $('#form_item').submit(function(){
      $.each($("#prices_table tbody tr.item"), function(count, item){
          if( $(item).find("select.item_currency").val() == "" && $(item).find(".item_price").val() == "0" ){
              $(item).addClass("removed");
          }
      });
      $("#prices_table tbody tr.removed").remove();
      $('input[name=items_count]').val($("#prices_table tbody tr.item").size());
  });

</script>
