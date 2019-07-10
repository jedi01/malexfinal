<?php
$company = array(
  'name'         => 'supplier[company]',
  'id'           => 'company',
  'value'        => set_value("supplier[company]", $supplier->company),
  'placeholder'  => lang("company_name"),
  'class'        => "form-control required",
  'autocomplete' => "off"
);
$fullname = array(
  'name'         => 'supplier[fullname]',
  'id'           => 'fullname',
  'value'        => set_value("supplier[fullname]", $supplier->fullname),
  'placeholder'  => "ex: Ms. Jane Doe",
  'class'        => "form-control required",
  'tabindex'     => "1",
  'autocomplete' => "off"
);
$phone_code = DEFAULT_PHONE_CODE;
$phone_number = "";
if( isset($supplier->phone) && !empty($supplier->phone) ){
  $phone = explode(" ", $supplier->phone, 2);
  $phone_code = $phone[0];
  $phone_number = $phone[1];
}
$phone = array(
  'name'         => 'supplier[phone]',
  'id'           => 'phone',
  'value'        => set_value("supplier[phone]", $phone_number),
  'placeholder'  => "ex: (+1) 222 333 444",
  'class'        => "form-control",
  'autocomplete' => "off"
);
$vat_number = array(
  'name'         => 'supplier[vat_number]',
  'id'           => 'vat_number',
  'value'        => set_value("supplier[vat_number]", $supplier->vat_number),
  'placeholder'  => lang("vat_number_placeholder"),
  'class'        => "form-control",
  'autocomplete' => "off"
);
$email = array(
  'name'         => 'supplier[email]',
  'id'           => 'email',
  'value'        => set_value("supplier[email]", $supplier->email),
  'placeholder'  => "ex: email@gmail.com",
  'class'        => "form-control",
  'autocomplete' => "off"
);
$website = array(
  'name'         => 'supplier[website]',
  'id'           => 'website',
  'value'        => set_value("supplier[website]", $supplier->website),
  'placeholder'  => "ex: www.mycompany.com",
  'class'        => "form-control",
  'autocomplete' => "off"
);
$address = array(
  'name'         => 'supplier[address]',
  'id'           => 'address',
  'value'        => set_value("supplier[address]", $supplier->address),
  'placeholder'  => "Street Address 1",
  'class'        => 'form-control',
  'autocomplete' => "off"
);
$address2 = array(
  'name'         => 'supplier[address2]',
  'id'           => 'address2',
  'value'        => set_value("supplier[address2]", $supplier->address2),
  'placeholder'  => "Street Address 2",
  'class'        => 'form-control',
  'autocomplete' => "off"
);
$city = array(
  'name'         => 'supplier[city]',
  'id'           => 'city',
  'value'        => set_value("supplier[city]", $supplier->city),
  'placeholder'  => lang("city"),
  'class'        => 'form-control',
  'autocomplete' => "off"
);
$state = array(
  'name'         => 'supplier[state]',
  'id'           => 'state',
  'value'        => set_value("supplier[state]", $supplier->state),
  'placeholder'  => lang("state"),
  'class'        => 'form-control',
  'autocomplete' => "off"
);
$postal_code = array(
  'name'         => 'supplier[postal_code]',
  'id'           => 'postal_code',
  'value'        => set_value("supplier[postal_code]", $supplier->postal_code),
  'placeholder'  => lang("postal_code"),
  'class'        => 'form-control',
  'autocomplete' => "off"
);
$country = array(
  'name'         => 'supplier[country]',
  'id'           => 'country',
  'value'        => set_value("supplier[country]", $supplier->country),
  'placeholder'  => lang("country"),
  'class'        => 'form-control',
  'autocomplete' => "off"
);
if( !empty($this->settings_model->SYS_Settings->supplier_cf1) ){
  $cf1 = array(
    'name'         => 'supplier[custom_field1]',
    'id'           => 'cf1',
    'value'        => set_value("supplier[custom_field1]", $supplier->custom_field1),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf1 = false;
}
if( !empty($this->settings_model->SYS_Settings->supplier_cf2) ){
  $cf2 = array(
    'name'         => 'supplier[custom_field2]',
    'id'           => 'cf2',
    'value'        => set_value("supplier[custom_field2]", $supplier->custom_field2),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf2 = false;
}
if( !empty($this->settings_model->SYS_Settings->supplier_cf3) ){
  $cf3 = array(
    'name'         => 'supplier[custom_field3]',
    'id'           => 'cf3',
    'value'        => set_value("supplier[custom_field3]", $supplier->custom_field3),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf3 = false;
}
if( !empty($this->settings_model->SYS_Settings->supplier_cf4) ){
  $cf4 = array(
    'name'         => 'supplier[custom_field4]',
    'id'           => 'cf4',
    'value'        => set_value("supplier[custom_field4]", $supplier->custom_field4),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf4 = false;
}
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("suppliers/edit?id=".$supplier->id, array('class' => 'form-horizontal'));?>
<?php echo form_hidden('id', $supplier->id); ?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="create_supplier">
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#basic_informations"><?php echo lang('basic_informations') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#contact_informations"><?php echo lang('contact_informations') ?></a></li>
    <?php if ($cf1 || $cf2 || $cf3 || $cf4): ?>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#supplier_custom_fields"><?php echo lang('custom_fields') ?></a></li>
    <?php endif ?>
  </ul>
  <div class="tab-content">
    <div class="tab-pane form-horizontal" id="basic_informations">

      <div class="row form-group required">
        <label class="col-md-3 form-control-label" for="fullname"><?php echo lang('contact_name');?></label>
        <div class="col-md-9">
          <?php echo form_input($fullname); ?>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="company"><?php echo lang('company');?></label>
        <div class="col-md-9">
          <?php echo form_input($company); ?>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="vat_number"><?php echo lang('vat_number');?></label>
        <div class="col-md-9">
          <?php echo form_input($vat_number); ?>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="phone"><?php echo lang('phone');?></label>
        <div class="col-md-9">
          <div class="input-group">
            <div class="input-group-addon" style="padding: 0;min-width: 70px;border: none;">
              <?php
              $phones = $this->settings_model->getFormattedPhones();
              echo '<select name="phone_code" id="phone_flags" class="form-control">';
              foreach ($phones as $phone_row) {
                  echo "<option value='".$phone_row->phone."' data-flag='".$phone_row->code."' ".($phone_row->phone==set_value("phone_code", $phone_code)?"selected='selected'":"" ).">".$phone_row->label."</option>";
              }
              echo "</select>";
              ?>
            </div>
            <?php echo form_input($phone); ?>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="email"><?php echo lang('email');?></label>
        <div class="col-md-9">
          <?php echo form_input($email); ?>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="website"><?php echo lang('website');?></label>
        <div class="col-md-9">
          <?php echo form_input($website); ?>
        </div>
      </div>

    </div>
    <div class="tab-pane form-horizontal" id="contact_informations">

      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="address"><?php echo lang("address"); ?></label>
        <div class="col-md-9">
          <div class="row row-equal">
            <div class="col-md-12">
              <?php echo form_input($address);?>
            </div>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-9 col-md-offset-3">
          <div class="row row-equal">
            <div class="col-md-12">
              <?php echo form_input($address2);?>
            </div>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-9 col-md-offset-3">
          <div class="row row-equal">
            <div class="col-xs-6">
              <?php echo form_input($city); ?>
            </div>
            <div class="col-xs-3">
              <?php echo form_input($state); ?>
            </div>
            <div class="col-xs-3">
              <?php echo form_input($postal_code);?>
            </div>
          </div>
        </div>
      </div>

      <div class="row form-group">
        <div class="col-md-9 col-md-offset-3">
          <div class="row row-equal">
            <div class="col-md-12">
              <?php //echo form_input($country);?>
              <?php
              $countries = $this->settings_model->getFormattedCountries();
              echo '<select name="supplier[country]" id="countries" class="form-control">';
              foreach ($countries as $code => $country) {
                  echo "<option value='".$country."' data-flag='".$code."' ".($country==set_value("supplier[country]", $supplier->country)?"selected='selected'":"").">".$country."</option>";
              }
              echo "</select>";
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if ($cf1 || $cf2 || $cf3 || $cf4): ?>
    <div class="tab-pane form-horizontal" id="supplier_custom_fields">
      <?php if ($cf1): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf1"><?php echo $this->settings_model->SYS_Settings->supplier_cf1;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf1); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf2): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf2"><?php echo $this->settings_model->SYS_Settings->supplier_cf2;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf2); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf3): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf3"><?php echo $this->settings_model->SYS_Settings->supplier_cf3;?></label>
        <div class="col-md-9">
          <?php echo form_input($cf3); ?>
        </div>
      </div>
      <?php endif ?>
      <?php if ($cf4): ?>
      <div class="row form-group">
        <label class="col-md-3 form-control-label" for="cf4"><?php echo $this->settings_model->SYS_Settings->supplier_cf4;?></label>
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
  <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
  $('#create_supplier a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#create_supplier a[href="#basic_informations"]').tab('show');

  // select 2
  $("#phone_flags").select2({
    width: 'resolve',
    dropdownAutoWidth: true,
    minimumResultsForSearch: 5,
    formatResult: function (country) {
      if (!country.id) { return country.text; }
      return $('<span><i class="countries-flags ' + $(country.element).data("flag").toLowerCase() + '"></i> ' + country.text + '</span>');
    },
    formatSelection: function (country){
      if (!country.id) { return country.text; }
      return $('<i class="countries-flags ' + $(country.element).data("flag").toLowerCase() + '"></i>');
    }
  });

  $("#countries").select2({
    width: 'resolve',
    minimumResultsForSearch: 5,
    formatResult: function (country) {
      if (!country.id) { return country.text; }
      return $('<span><i class="countries-flags ' + $(country.element).data("flag").toLowerCase() + '"></i> ' + country.text + '</span>');
    },
    formatSelection: function (country){
      if (!country.id) { return country.text; }
      return $('<span><i class="countries-flags ' + $(country.element).data("flag").toLowerCase() + '"></i> ' + country.text + '</span>');
    }
  });
</script>
