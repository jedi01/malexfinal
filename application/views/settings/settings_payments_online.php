<?php
$hidden = array("refresh"=>base64_encode($refresh));
echo form_open('/settings/save_payments_online', 'class="no_chosen" style=" margin: 0;"', $hidden);
?>
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title  col-md-6"><?php echo lang('payments_online') ?></h3>
    <?php if( PAYMENTS_ONLINE_REQUIREMENTS ): ?>
    <div class=" col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update_settings") ?></button>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->
<div class="row-fluid">
  <div class="display-table invoice_config">
    <div class="display-margin bordered_tabs">
      <ul class="nav nav-tabs" id="payments_online_tabs">
        <li class="nav-item"><a class="nav-link" href="#conf_po_general"><?php echo lang('general') ?></a></li>
        <?php if (PAYMENTS_ONLINE_REQUIREMENTS): ?>
        <li class="nav-item"><a class="nav-link" href="#conf_paypal"><?php echo lang('paypal') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#conf_stripe"><?php echo lang('stripe') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#conf_twocheckout"><?php echo lang('twocheckout') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#conf_mobilpay"><?php echo lang('mobilpay') ?></a></li>
        <?php endif ?>
      </ul>
      <div class="tab-content" id="po_config">

        <!-- GENERALE -->
        <div class="tab-pane form-horizontal" id="conf_po_general">
          <?php if( !PAYMENTS_ONLINE_REQUIREMENTS ): ?>
          <div class="alert">
            <?php echo lang("payments_online_requirements") ?>
          </div>
          <?php endif; ?>
          <div class="col-md-6">
            <!-- ENABLE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="po_enable"><?php echo lang("payments_online_enable"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[enable]', "1", $PO_settings->enable, 'id="po_enable" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
            <!-- BILLER_ACCOUNTS -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="po_biller_accounts"><?php echo lang("biller_accounts"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[biller_accounts]', "1", $PO_settings->biller_accounts, 'id="po_biller_accounts" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
          </div>
        </div>

        <?php if (PAYMENTS_ONLINE_REQUIREMENTS): ?>
        <!-- PAYPAL -->
        <div class="tab-pane form-horizontal" id="conf_paypal">
          <div class="col-md-6">
            <!-- ENABLE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="paypal_enable"><?php echo lang("enable"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[paypal][enable]', "1", $PO_settings->paypal->enable, 'id="paypal_enable" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
            <!-- USERNAME -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="paypal_username"><?php echo lang("username"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[paypal][username]', $this->encryption->decrypt($PO_settings->paypal->username), 'class="form-control" id="paypal_username"'); ?>
              </div>
            </div>
            <!-- PASSWORD -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="paypal_password"><?php echo lang("password"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[paypal][password]', $this->encryption->decrypt($PO_settings->paypal->password), 'class="form-control" id="paypal_password"'); ?>
              </div>
            </div>
            <!-- SIGNATURE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="paypal_signature"><?php echo lang("signature"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[paypal][signature]', $this->encryption->decrypt($PO_settings->paypal->signature), 'class="form-control" id="paypal_signature"'); ?>
              </div>
            </div>
            <!-- SANDBOX -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="paypal_sandbox"><?php echo lang("sandbox"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[paypal][sandbox]', "1", $PO_settings->paypal->sandbox, 'id="paypal_sandbox" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
          </div>
        </div>
        <!-- PAYPAL END-->

        <!-- STRIPE -->
        <div class="tab-pane form-horizontal" id="conf_stripe">
          <div class="col-md-6">
            <!-- ENABLE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="stripe_enable"><?php echo lang("enable"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[stripe][enable]', "1", $PO_settings->stripe->enable, 'id="stripe_enable" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
            <!-- API_KEY -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="stripe_api_key"><?php echo lang("api_key"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[stripe][api_key]', $this->encryption->decrypt($PO_settings->stripe->api_key), 'class="form-control" id="stripe_api_key"'); ?>
              </div>
            </div>
          </div>
        </div>
        <!-- STRIPE END-->

        <!-- 2checkout -->
        <div class="tab-pane form-horizontal" id="conf_twocheckout">
          <div class="col-md-6">
            <!-- ENABLE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="twocheckout_enable"><?php echo lang("enable"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[twocheckout][enable]', "1", $PO_settings->twocheckout->enable, 'id="twocheckout_enable" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
            <!-- ACCOUNT_NUMBER -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="twocheckout_account_number"><?php echo lang("account_number"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[twocheckout][account_number]', $this->encryption->decrypt($PO_settings->twocheckout->account_number), 'class="form-control" id="twocheckout_account_number"'); ?>
              </div>
            </div>
            <!-- SECRETWORD -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="twocheckout_secretWord"><?php echo lang("secretWord"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[twocheckout][secretWord]', $this->encryption->decrypt($PO_settings->twocheckout->secretWord), 'class="form-control" id="twocheckout_secretWord"'); ?>
              </div>
            </div>
            <!-- TEST_MODE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="twocheckout_test_mode"><?php echo lang("test_mode"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[twocheckout][test_mode]', "1", $PO_settings->twocheckout->test_mode, 'id="twocheckout_test_mode" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
          </div>
        </div>
        <!-- twocheckout END-->

        <!-- MobilPay -->
        <div class="tab-pane form-horizontal" id="conf_mobilpay">
          <div class="col-md-6">
            <!-- ENABLE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="mobilpay_enable"><?php echo lang("enable"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[mobilpay][enable]', "1", $PO_settings->mobilpay->enable, 'id="mobilpay_enable" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
            <!-- ACCOUNT_NUMBER -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="mobilpay_merchant_id"><?php echo lang("merchant_id"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[mobilpay][merchant_id]', $this->encryption->decrypt($PO_settings->mobilpay->merchant_id), 'class="form-control" id="mobilpay_merchant_id"'); ?>
              </div>
            </div>
            <!-- SECRETWORD -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="mobilpay_public_key"><?php echo lang("public_key"); ?></label>
              <div class="col-md-9">
                <?php echo form_input('po[mobilpay][public_key]', $this->encryption->decrypt($PO_settings->mobilpay->public_key), 'class="form-control" id="mobilpay_public_key"'); ?>
              </div>
            </div>
            <!-- TEST_MODE -->
            <div class="row form-group">
              <label class="col-md-3 form-control-label" for="mobilpay_test_mode"><?php echo lang("test_mode"); ?></label>
              <div class="col-md-9">
                  <label class="switch switch-icon switch-success">
                    <?php echo form_checkbox('po[mobilpay][test_mode]', "1", $PO_settings->mobilpay->test_mode, 'id="mobilpay_test_mode" class="switch-input"'); ?>
                    <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                    <span class="switch-handle"></span>
                  </label>
              </div>
            </div>
          </div>
        </div>
        <!-- MobilPay END-->
        <?php endif ?>

      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div><br>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
  $('#payments_online_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#payments_online_tabs a[href="#conf_po_general"]').tab('show');

  <?php if( !PAYMENTS_ONLINE_REQUIREMENTS ): ?>
  $('#po_config input').attr("disabled", "disabled");
  <?php endif; ?>
});
</script>
