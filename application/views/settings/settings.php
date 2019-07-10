<?php
$this->load->enqueue_style("assets/vendor/jquery.autocomplete/easy-autocomplete.css", "custom");
$this->load->enqueue_script("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js");
$this->load->enqueue_script("assets/js/libs/select2.min.js");
echo $this->load->css("custom");
?>
<!-- Page Header -->
<ol class="breadcrumb">
  <div class="flip pull-left">
    <h1 class="h2 page-title"><?php echo $page_title;?></h1>
    <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
  </div>
</ol>
<div class="container-fluid">
  <div class="col-md-12">
<div class="error-zone"></div>
<div class="clearfix"></div>

<div class="tabbable tabs-left">
  <ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="#settings_general" data-toggle="tab"><span class="icon-settings"></span> <span class="text"><?php echo lang('settings_general') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#settings_company" data-toggle="tab"><span class="icon-home"></span> <span class="text"><?php echo lang('settings_company') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#settings_template" data-toggle="tab"><span class="icon-doc"></span> <span class="text"><?php echo lang('settings_template') ?></span></a></li>
     <!-- <li class="nav-item"><a class="nav-link" href="#settings_purchase_template" data-toggle="tab"><span class="icon-doc"></span> <span class="text"><?php echo lang('purchase_template') ?></span></a></li> -->
    <li class="nav-item"><a class="nav-link" href="#settings_email" data-toggle="tab"><span class="icon-envelope"></span> <span class="text"><?php echo lang('settings_email') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#settings_tax_rates" data-toggle="tab"><span class="icon-calculator"></span> <span class="text"><?php echo lang('settings_tax_rates') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#payments_online" data-toggle="tab"><span class="icon-paypal"></span> <span class="text"><?php echo lang('payments_online') ?></span></a></li>
    <?php if ($this->ion_auth->in_group(array("superadmin"))): ?>
    <li class="nav-item"><a class="nav-link" href="#settings_files" data-toggle="tab"><span class="icon-folder-alt"></span> <span class="text"><?php echo lang('settings_files') ?></span></a></li>
    <?php endif ?>
    <li class="nav-item"><a class="nav-link" href="#settings_charts_of_accounts" data-toggle="tab"><span class="icon-layers"></span> <span class="text"><?php echo lang('chart_of_accounts') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#settings_db" data-toggle="tab"><span class="icon-layers"></span> <span class="text"><?php echo lang('settings_db') ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="#initial_balance" data-toggle="tab"><span class="icon-layers"></span> <span class="text"><?php echo lang('initial_balance') ?></span></a></li>

     <li class="nav-item"><a class="nav-link" href="#users" data-toggle="tab"><span class="icon-layers"></span> <span class="text"><?php echo lang('users') ?></span></a></li>
  </ul>
  <div class="tab-content">
    <!-- CONFIGURATION GENERAL -->
    <div class="tab-pane" id="settings_general">
      <?php
      $data_general['general']            = $general;
      $data_general['currencies']         = $this->settings_model->getFormattedCurrencies();
      $data_general['number_formats']     = $this->settings_model->getNumbersFormats();
      $data_general['round_numbers']      = $this->settings_model->getRoundNumbers();
      $data_general['currencies_formats'] = $this->settings_model->getCurrenciesFormats();
      $data_general['decimal_places']     = $this->settings_model->getDecimalPlaces();
      $data_general['user_groups']        = $this->settings_model->getUserGroups();
      $data_general['available_lang']     = $this->settings_model->getAvailableLanguages();
      $data_general['date_formats']       = $this->settings_model->getDateFormats();
      $data_general['reference_types']    = $this->settings_model->getReferenceTypes();
      $data_general['yes_no']             = $this->settings_model->getYesNoArray();
      $data_general['status_invoice']     = $this->settings_model->getInvoiceStatus();
      $data_general['taxes_settings']     = $this->settings_model->getTaxesSettings();
      $data_general['currency_places']    = $this->settings_model->getCurrencyPlaces();

      echo $this->load->view ( 'settings/settings_general' , $data_general ,true );
      ?>
    </div>
    <!-- CONFIGURATION GENERAL END -->

    <!-- CONFIGURATION TEMPLATE -->
    <div class="tab-pane" id="settings_template">
      <?php
      $data_invoice['refresh']          = '/settings?config=settings_purchase_template';
      $data_invoice['invoice_settings'] = $invoice_settings;
      $data_invoice['controller']       = NULL;
      $data_invoice['method']           = NULL;
      $data_invoice['params']           = NULL;
      echo $this->load->view ( 'settings/settings_templates' , $data_invoice ,true );
      ?>
    </div>
    <!-- CONFIGURATION TEMPLATE END -->

    <!-- CONFIGURATION COMPANY -->
    <div class="tab-pane" id="settings_company">
      <?php
      $data_company['company'] = $company;
      echo $this->load->view ( 'settings/settings_company' , $data_company ,true );
      ?>
    </div>
    <!-- CONFIGURATION COMPANY END -->


    <!-- CONFIGURATION EMAIL -->
    <div class="tab-pane" id="settings_email">
      <?php
      $data_email['email_Settings'] = $this->settings_model->email_Settings;
      echo $this->load->view ( 'settings/settings_email' , $data_email ,true );
      ?>
    </div>
    <!-- CONFIGURATION EMAIL END -->

    <!-- CONFIGURATION TAX RATES -->
    <div class="tab-pane" id="settings_tax_rates">
      <?php
      echo $this->load->view ( 'settings/settings_taxes' , array() ,true );
      ?>
    </div>
    <!-- CONFIGURATION TAX RATES END -->

    <!-- CONFIGURATION PAYMENTS ONLINE -->
    <div class="tab-pane" id="payments_online">
      <?php
      $data_po['PO_settings'] = $this->settings_model->PO_settings;
      echo $this->load->view ( 'settings/settings_payments_online' , $data_po ,true );
      ?>
    </div>
    <!-- CONFIGURATION PAYMENTS ONLINE END -->

    <?php if ($this->ion_auth->in_group(array("superadmin"))): ?>
    <!-- CONFIGURATION PAYMENTS ONLINE -->
    <div class="tab-pane" id="settings_files">
      <?php
      $data_file['FILES_settings'] = $this->settings_model->FILES_settings;
      echo $this->load->view ( 'settings/settings_files' , $data_file ,true );
      ?>
    </div>
    <!-- CONFIGURATION PAYMENTS ONLINE END -->
    <?php endif ?>


     <!-- Charts OF Accounts -->
    <div class="tab-pane" id="settings_charts_of_accounts">
      <?php
      echo $this->load->view ( 'settings/setting_charts_of_accounts' , array() ,true );
      ?>
    </div>
    <!-- Charts OF Accounts END -->

    <!-- CONFIGURATION DATABASE -->
    <div class="tab-pane" id="settings_db">
      <?php
      echo $this->load->view ( 'settings/settings_db' , array() ,true );
      ?>
    </div>
    <!-- CONFIGURATION DATABASE END -->

    <!-- CONFIGURATION Initial Balance -->
    <div class="tab-pane" id="initial_balance">
      <?php
      echo $this->load->view ( 'settings/setting_initial_balance' , array() ,true );
      ?>
    </div>
    <!-- CONFIGURATION Initial Balance END -->

     <!-- CONFIGURATION users  -->
    <div class="tab-pane" id="users">
      <?php
      echo $this->load->view ( 'settings/setting_users' , array() ,true );
      ?>
    </div>
    <!-- CONFIGURATION users  END -->
    <div class="clearfix"></div>
  </div>
</div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
  $(document).ready(function(){
    var open_tab = "<?php echo $config ?>";
    var nav_height = $('.tabbable > .nav-tabs').innerHeight();
    $('.tabbable a.nav-link').on('shown.bs.tab', function (e) {
      var content_height = $('.tabbable > .tab-content').outerHeight();
      var height = $('.tabbable').innerHeight();
      height = Math.max(500, nav_height, content_height);
      $('.tabbable > .nav-tabs').innerHeight(height+15);
      $(document).responsiveNavTabs();
    });
    $('.tabbable a[href="#'+open_tab+'"]').tab('show');

    tinymce.remove(".editor_textarea");
    tinymce.init(
      Object.assign({}, tinymce_init_mini, {
        selector: '.editor_textarea',
        //height: 100,
      })
    );
  });
</script>
<br>
