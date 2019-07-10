<?php
$attrib = array('class'=>'form-horizontal', "id"=>"form_settings_email");
echo form_open("/settings/update_settings_email", $attrib);
?>
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('configuration_email') ?></h3>
    <div class="col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update_settings") ?></button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->

<div class="row-fluid">
  <div class="display-table">
    <div class="display-margin bordered_tabs">
      <ul class="nav nav-tabs" id="configuration_email">
        <li class="nav-item"><a class="nav-link" href="#email_settings"><?php echo lang('settings') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#email_templates"><?php echo lang('templates') ?></a></li>
      </ul>
      <div class="tab-content" style="padding-top: 40px;">
        <div class="tab-pane form-horizontal" id="email_settings">
          <div class="row-fluid">
            <div class="col-md-6">
              <!-- PROTOCOL -->
              <div class="row form-group required">
                <label class="col-md-3 form-control-label" for="protocol"><?php echo lang("protocol"); ?></label>
                <div class="col-md-9">
                  <?php
                  $protocols = array(
                    'mail'     => "Send Mail",
                    'sendmail' => "PHP Mail Function",
                    'smtp'     => "SMTP"
                  );
                  echo form_dropdown('email[protocol]', $protocols, $email_Settings->protocol, 'class="form-control" id="protocol"');
                  ?>
                </div>
              </div>
              <div id="smtp" style="display: none;">
                <!-- SMTP_CRYPTO -->
                <div class="row form-group">
                  <label class="col-md-3 form-control-label" for="smtp_crypto"><?php echo lang("smtp_crypto"); ?></label>
                  <div class="col-md-9">
                    <?php
                    $smtp_cryptos = array(
                      ''    => "none",
                      'tls' => "TLS",
                      'ssl' => "SSL"
                    );
                    echo form_dropdown('email[smtp_crypto]', $smtp_cryptos, $email_Settings->smtp_crypto, 'class="form-control" id="smtp_crypto"');
                    ?>
                  </div>
                </div>

                <!-- SMTP_HOST -->
                <div class="row form-group required">
                  <label class="col-md-3 form-control-label" for="smtp_host"><?php echo lang("smtp_host"); ?></label>
                  <div class="col-md-9">
                    <?php echo form_input('email[smtp_host]', $email_Settings->smtp_host, 'class="form-control" id="smtp_host"'); ?>
                  </div>
                </div>

                <!-- SMTP_PORT -->
                <div class="row form-group required">
                  <label class="col-md-3 form-control-label" for="smtp_port"><?php echo lang("smtp_port"); ?></label>
                  <div class="col-md-9">
                    <?php echo form_input('email[smtp_port]', $email_Settings->smtp_port, 'class="form-control" id="smtp_port"'); ?>
                  </div>
                </div>

                <!-- SMTP_USER -->
                <div class="row form-group required">
                  <label class="col-md-3 form-control-label" for="smtp_user"><?php echo lang("smtp_user"); ?></label>
                  <div class="col-md-9">
                    <?php echo form_input('email[smtp_user]', $email_Settings->smtp_user, 'class="form-control" id="smtp_user"'); ?>
                  </div>
                </div>

                <!-- SMTP_HOST -->
                <div class="row form-group required">
                  <label class="col-md-3 form-control-label" for="smtp_pass"><?php echo lang("smtp_pass"); ?></label>
                  <div class="col-md-9">
                    <?php echo form_password('email[smtp_pass]', $email_Settings->smtp_pass, 'class="form-control" id="smtp_pass"'); ?>
                  </div>
                </div>
              </div>

              <div id="mail" style="display: none;">
                <!-- MAILPATH -->
                <div class="row form-group">
                  <label class="col-md-3 form-control-label" for="mailpath"><?php echo lang("mailpath"); ?></label>
                  <div class="col-md-9">
                    <?php echo form_input('email[mailpath]', $email_Settings->mailpath, 'class="form-control" id="mailpath"'); ?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="tab-pane form-horizontal" id="email_templates">
          <ul>
              <li><a href="<?php echo site_url("settings/update_email_template/send_invoices_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_invoices_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_purchase_order_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_purchase_order_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_receipts_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_receipts_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_rinvoices_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_rinvoices_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_estimates_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_estimates_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_contracts_to_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_contracts_to_customer") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_customer_reminder.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_customer_reminder") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_overdue_reminder.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_overdue_reminder") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_file.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_file") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_forgotten_password.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_forgotten_password") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_activate.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_activate") ?></a></li>
              <li><a href="<?php echo site_url("settings/update_email_template/send_activate_customer.tpl"); ?>" class="sis_modal small" sis-modal=""><?php echo lang("send_activate_customer") ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
<?php echo form_close();?>
<script type="text/javascript">
$(document).ready(function(){
  $('#general_settings_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });

  $('#protocol').change(function(){

    if( $(this).val() == "smtp" ){
      $('#mail').fadeOut();
      $('#smtp').fadeIn();
      $('#mail input').attr('disabled', "disabled");
      $('#smtp input, #smtp select').removeAttr('disabled');
    }else if( $(this).val() == "mail" ){
      $('#mail').fadeIn();
      $('#smtp').fadeOut();
      $('#mail input').removeAttr('disabled');
      $('#smtp input, #smtp select').attr('disabled', "disabled");
    }else{
      $('#mail').fadeOut();
      $('#smtp').fadeOut();
      $('#mail input, #smtp input, #smtp select').attr('disabled', "disabled");
    }

  }).trigger("change");


  $('#configuration_email a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#configuration_email a[href="#email_settings"]').tab('show');
});
</script>
