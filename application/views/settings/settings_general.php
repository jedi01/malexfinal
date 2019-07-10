<?php
$attrib = array('class'=>'form-horizontal', "id"=>"form_settings_general");
echo form_open("/settings/update_settings_general", $attrib);
?>
<style type="text/css">
.input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
}
</style>
<input type="hidden" name="reset_all_references" value="0">
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('configuration_general') ?></h3>
    <div class="col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update_settings") ?></button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->
<div class="row-fluid">
  <div class="display-table invoice_config">
    <div class="display-margin bordered_tabs">
      <ul class="nav nav-tabs" id="general_tabs">
        <li class="nav-item"><a class="nav-link" href="#general_system"><?php echo lang('system') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_defaults"><?php echo lang('defaults') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_invoice"><?php echo lang('invoice') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_custom_fields"><?php echo lang('custom_fields') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_chat"><?php echo lang('chat') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_reminder"><?php echo lang('calendar') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#general_privileges"><?php echo lang('permissions') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#taxes_conditional"><?php echo lang('conditional_taxes') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#exchange_api"><?php echo lang('exchange_api') ?></a></li>
        
      </ul>
      <div class="tab-content">
        <!-- SYSTEM SETTINGS -->
        <div class="tab-pane form-horizontal" id="general_system">

<div class="row-fluid">
  <div class="col-md-6">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="language"><?php echo lang("language"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('language', $available_lang, $general->language, 'class="form-control" id="language" data-placeholder="'.lang("select").' '.lang("language").'" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="date_format"><?php echo lang("date_format"); ?></label>
      <div class="col-md-9">
        <?php
        foreach($date_formats as $date_format){
          $dt[$date_format->id] = $date_format->label;
        }
        echo form_dropdown('date_format', $dt, $general->dateformat, 'class="form-control" id="date_format" data-placeholder="'.lang("select").' '.lang("date_format").'" required="required"'); ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="number_format"><?php echo lang("number_format"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('number_format', $number_formats, $general->number_format, 'class="form-control" id="number_format" data-placeholder="'.lang("select").' '.lang("number_format").'" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="round_number"><?php echo lang("round_number"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('round_number', $round_numbers, $general->round_number, 'class="form-control" id="round_number" data-placeholder="'.lang("select").' '.lang("round_number").'" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="currency_format"><?php echo lang("currency_format"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('currency_format', $currencies_formats, $general->currency_format, 'class="form-control" id="currency_format" data-placeholder="'.lang("select").' '.lang("currency_format").'" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="decimal_place"><?php echo lang("decimal_place"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('decimal_place', $decimal_places, $general->decimal_place, 'class="form-control" id="decimal_place" data-placeholder="'.lang("select").' '.lang("decimal_place").'" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="currency_place"><?php echo lang("currency_place"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('currency_place', $currency_places, $general->currency_place, 'class="form-control" id="currency_place" data-placeholder="'.lang("select").' '.lang("currency_place").'" required="required"');
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-6">

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="enable_register"><?php echo lang("enable_register"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('enable_register', $yes_no, set_value("enable_register", $general->enable_register), 'id="enable_register" class="form-control" required="required"');
        ?>
      </div>
    </div>

    <div class="row form-group" id="default_group_div">
      <label class="col-md-3 form-control-label" for="default_group"><?php echo lang("default_group"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('default_group', $user_groups, $general->default_group, 'class="form-control" id="default_group" data-placeholder="'.lang("select").' '.lang("default_group").'" required="required"');
        ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="enable_contracts"><?php echo lang("contracts"); ?></label>
      <div class="col-md-9">
          <label class="switch switch-icon switch-success">
            <?php
            echo form_checkbox('enable_contracts', "1", $general->enable_contracts, 'id="enable_contracts" class="switch-input"');
            ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>
  </div>
</div>
        </div>
        <!-- SYSTEM SETTINGS END -->


        <!-- DEFAULTS SETTINGS -->
        <div class="tab-pane form-horizontal" id="general_defaults">

<div class="row-fluid">
  <div class="col-md-6">

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="default_status"><?php echo lang("default_status"); ?></label>
      <div class="col-md-9">
        <?php
        unset($status_invoice['partial']);
        unset($status_invoice['canceled']);
        unset($status_invoice['panding']);
        unset($status_invoice['overdue']);
        echo form_dropdown('default_status', $status_invoice, $general->default_status, 'class="form-control" id="default_status" data-placeholder="'.lang("select").' '.lang("default_status").'" required="required"');
        ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="default_due_date"><?php echo lang("date_due"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_dropdown('default_due_date', $this->settings_model->getDueDates(), $general->default_due_date, 'class="form-control" id="default_due_date"');
        ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="reference_type"><?php echo lang("reference_type"); ?></label>
      <div class="col-md-9">
        <div class="input-group">
          <?php
          echo form_dropdown('reference_type', $reference_types, set_value("reference_type", $general->reference_type), 'id="reference_type" class="form-control" required="required"');
          ?>
          <span class="input-group-btn">
            <button type="button" class="btn btn-secondary show_reference tip" title="<?php echo lang("show_reference") ?>">
              <i class="fa fa-eye"></i>
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <!-- DEFAULT CURRENCY -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="currency"><?php echo lang("default_currency"); ?></label>
      <div class="col-md-9">
        <?php
        echo '<select name="default_currency" id="currency" class="form-control">';
        foreach ($currencies as $currency) {
            echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".($currency->value==set_value("default_currency", $general->default_currency)?"selected='selected'":"" ).">".$currency->label."</option>";
        }
        echo "</select>";
        ?>
      </div>
    </div>
    <!-- DEFAULT COUNTRY -->
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="default_country"><?php echo lang("country"); ?></label>
      <div class="col-md-9">
        <?php
        echo '<select name="default_country" id="default_country" class="form-control">';
        foreach ($this->settings_model->getFormattedCountries() as $code => $country) {
            echo "<option value='".$code."' data-flag='".$code."' ".($code==$general->default_country?"selected='selected'":"").">".$country."</option>";
        }
        echo "</select>";
        ?>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="row-fluid">
  <div class="col-md-6">

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="prefix_invoice"><?php echo lang("prefix_invoice"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('prefix_invoice', $general->prefix_invoice, 'id="prefix_invoice" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="estimate_prefix"><?php echo lang("estimate_prefix"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('estimate_prefix', $general->estimate_prefix, 'id="estimate_prefix" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>


    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="receipt_prefix"><?php echo lang("receipt_prefix"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('receipt_prefix', $general->receipt_prefix, 'id="receipt_prefix" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>
    <?php if (ENABLE_CONTRACTS): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="contract_prefix"><?php echo lang("contract_prefix"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('contract_prefix', $general->contract_prefix, 'id="contract_prefix" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>
    <?php else: ?>
      <?php echo form_hidden('contract_prefix', $general->contract_prefix); ?>
    <?php endif ?>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="expense_prefix"><?php echo lang("expense_prefix"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('expense_prefix', $general->expense_prefix, 'id="expense_prefix" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="purchase_order_prefix"><?php echo lang("purchase_order_prefix"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('purchase_order_prefix', $general->purchase_order_prefix, 'id="purchase_order_prefix" autocomplete="off" class="form-control" required="required"');?>
      </div>
    </div>

  </div>
  <div class="col-md-6">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="invoice_next"><?php echo lang("invoice_next"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"invoice_next", "type"=>"number", "value"=>$general->invoice_next, "id"=>"invoice_next", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="estimate_next"><?php echo lang("estimate_next"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"estimate_next", "type"=>"number", "value"=>$general->estimate_next, "id"=>"estimate_next", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="receipt_next"><?php echo lang("receipt_next"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"receipt_next", "type"=>"number", "value"=>$general->receipt_next, "id"=>"receipt_next", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>
    <?php if (ENABLE_CONTRACTS): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="contract_next"><?php echo lang("contract_next"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"contract_next", "type"=>"number", "value"=>$general->contract_next, "id"=>"contract_next", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>
    <?php else: ?>
      <?php echo form_hidden('contract_next', $general->contract_next); ?>
    <?php endif ?>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="expense_next"><?php echo lang("expense_next"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"expense_next", "type"=>"number", "value"=>$general->expense_next, "id"=>"expense_next", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="next_purchase_order"><?php echo lang("next_purchase_order"); ?></label>
      <div class="col-md-9">
        <?php echo form_input(array("name"=>"next_purchase_order", "type"=>"number", "value"=>$general->next_purchase_order, "id"=>"next_purchase_order", "class"=>"form-control", "step"=>"1", "min"=>"1")); ?>
      </div>
    </div>

  </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="row-fluid">
  <div class="col-md-12">
    <div class="row form-group">
      <label class="form-control-label" for="default_note"><?php echo lang("invoice_note"); ?></label>
      <?php echo form_textarea(array("name"=>'default_note', "value"=>$general->default_note, "id"=>"default_note", "class"=>"form-control editor_textarea", "rows"=>"2"));?>
    </div>

    <div class="row form-group">
      <label class="col3 form-control-label" for="default_terms"><?php echo lang("invoice_terms"); ?></label>
      <?php echo form_textarea(array("name"=>'default_terms', "value"=>$general->default_terms, "id"=>"default_terms", "class"=>"form-control editor_textarea", "rows"=>"2"));?>
    </div>

    <?php if (ENABLE_CONTRACTS): ?>
    <div class="row form-group">
      <label class="form-control-label" for="df_contract_desc"><?php echo lang("contract_description"); ?></label>
      <?php echo form_textarea(array("name"=>'df_contract_desc', "value"=>$general->df_contract_desc, "id"=>"df_contract_desc", "class"=>"form-control editor_textarea", "rows"=>"2"));?>
    </div>
    <?php else: ?>
      <?php echo form_hidden('df_contract_desc', $general->df_contract_desc); ?>
    <?php endif ?>
  </div>
</div>
        </div>
        <!-- DEFAULTS SETTINGS END -->

        <!-- INVOICE SETTINGS -->
        <div class="tab-pane form-horizontal" id="general_invoice">
<div class="row-fluid">
  <div class="col-md-6">
    <h4><i class="fa fa-gears"></i> <?php echo lang("manage_configurations") ?></h4>
    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="shipping"><?php echo lang("shipping"); ?></label>
      <div class="col-md-8">
        <?php
        echo form_dropdown('shipping', $yes_no, set_value("shipping", $general->shipping), 'id="shipping" class="form-control" required="required"');
        ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="item_tax"><?php echo lang("taxes"); ?></label>
      <div class="col-md-8">
        <?php
        echo form_dropdown('item_tax', $taxes_settings, set_value("item_tax", $general->item_tax), 'id="item_tax" class="form-control" required="required"');
        ?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="item_discount"><?php echo lang("discount"); ?></label>
      <div class="col-md-8">
        <?php
        echo form_dropdown('item_discount', $taxes_settings, set_value("item_discount", $general->item_discount), 'id="item_discount" class="form-control" required="required"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="enable_terms"><?php echo lang("enable_terms"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('enable_terms', "1", $general->enable_terms, 'id="enable_terms" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

  </div>
  <div class="col-md-6">
    <h4><i class="fa fa-print"></i> <?php echo lang("printing_configurations") ?></h4>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="show_status"><?php echo lang("show_invoice_status"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('show_status', "1", $general->show_status, 'id="show_status" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="show_total_due"><?php echo lang("show_total_due"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('show_total_due', "1", $general->show_total_due, 'id="show_total_due" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="show_payments_page"><?php echo lang("show_payments_page"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('show_payments_page', "1", $general->show_payments_page, 'id="show_payments_page" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="note_terms_on_page"><?php echo lang("note_terms_on_page"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('note_terms_on_page', "1", $general->note_terms_on_page, 'id="note_terms_on_page" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="amount_in_words"><?php echo lang("amount_in_words"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('amount_in_words', "1", $general->amount_in_words, 'id="amount_in_words" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-4 form-control-label" for="description_inline"><?php echo lang("description_inline"); ?></label>
      <div class="col-md-8">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('description_inline', "1", $general->description_inline, 'id="description_inline" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label><br>
          <small class="text-muted"><?php echo lang("description_inline_tip"); ?></small>
      </div>
    </div>

  </div>

  <!-- Recurring Invoices -->
  <div class="col-md-12">
    <h4><i class="fa fa-retweet"></i> <?php echo lang("rinvoices") ?></h4>
    <?php if (defined("CRON_JOB_ACTIVATED") && CRON_JOB_ACTIVATED): ?>
      <div class="col-md-6">
        <div class="row form-group">
          <label class="col-md-3 form-control-label" for="enable_recurring"><?php echo lang("enable"); ?></label>
          <div class="col-md-9">
              <label class="switch switch-icon switch-success">
                <?php
                echo form_checkbox('enable_recurring', "1", $general->enable_recurring, 'id="enable_recurring" class="switch-input"');
                ?>
                <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                <span class="switch-handle"></span>
              </label>
          </div>
        </div>
      </div>
    <?php else: ?>
      <p><?php echo sprintf(lang("cronjob_desactivated"), "/usr/bin/curl -k ".site_url("/cron/synchronize")  ) ?></p>
    <?php endif ?>
  </div>
  <!-- Recurring Invoices END -->

  <!-- Overdue reminder -->
  <div class="col-md-12">
    <h4><i class="fa fa-clock-o"></i> <?php echo lang("overdue_reminder") ?></h4>
    <?php if (defined("CRON_JOB_ACTIVATED") && CRON_JOB_ACTIVATED): ?>
      <div class="col-md-6">
        <div class="row form-group">
          <label class="col-md-3 form-control-label" for="enable_overdue_reminder"><?php echo lang("enable"); ?></label>
          <div class="col-md-9">
              <label class="switch switch-icon switch-success">
                <?php
                echo form_checkbox('enable_overdue_reminder', "1", $general->enable_overdue_reminder, 'id="enable_overdue_reminder" class="switch-input"');
                ?>
                <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                <span class="switch-handle"></span>
              </label>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-3 form-control-label" for="overdue_first_time"><?php echo lang("once_is"); ?></label>
          <div class="col-md-3">
            <?php echo form_input(array("name"=>"overdue_first_time", "type"=>"number", "value"=>$general->overdue_first_time, "id"=>"overdue_first_time", "class"=>"form-control", "step"=>"1", "min"=>"0", "max"=>"7")); ?>
          </div>
          <label class="form-control-label" for="overdue_first_time"><?php echo lang("days_late"); ?></label>
        </div>
        <div class="row form-group">
          <label class="col-md-3 form-control-label" for="overdue_first_time"><?php echo lang("and_every"); ?></label>
          <div class="col-md-3">
            <?php echo form_input(array("name"=>"overdue_every", "type"=>"number", "value"=>$general->overdue_every, "id"=>"overdue_every", "class"=>"form-control", "step"=>"1", "min"=>"4", "max"=>"7")); ?>
          </div>
          <label class="form-control-label" for="overdue_first_time"><?php echo lang("days_after"); ?></label>
        </div>
      </div>
    <?php else: ?>
      <p><?php echo sprintf(lang("cronjob_desactivated"), "/usr/bin/curl -k ".site_url("/cron/synchronize")  ) ?></p>
    <?php endif ?>
  </div>
  <!-- Overdue reminder END -->
</div>
        </div>
        <!-- INVOICE SETTINGS END -->


        <!-- CUSTOMER CUSTOM FIELDS SETTINGS -->
        <div class="tab-pane form-horizontal" id="general_custom_fields">
<div class="row-fluid">
  <div class="col-md-6">
    <h4><i class="fa fa-user"></i> <?php echo lang("customer") ?></h4>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="customer_cf1"><?php echo lang("custom_field_1"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('customer_cf1', $general->customer_cf1, 'id="customer_cf1" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="customer_cf2"><?php echo lang("custom_field_2"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('customer_cf2', $general->customer_cf2, 'id="customer_cf2" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="customer_cf3"><?php echo lang("custom_field_3"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('customer_cf3', $general->customer_cf3, 'id="customer_cf3" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="customer_cf4"><?php echo lang("custom_field_4"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('customer_cf4', $general->customer_cf4, 'id="customer_cf4" autocomplete="off" class="form-control"');?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <h4><i class="fa fa-user"></i> <?php echo lang("supplier") ?></h4>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="supplier_cf1"><?php echo lang("custom_field_1"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('supplier_cf1', $general->supplier_cf1, 'id="supplier_cf1" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="supplier_cf2"><?php echo lang("custom_field_2"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('supplier_cf2', $general->supplier_cf2, 'id="supplier_cf2" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="supplier_cf3"><?php echo lang("custom_field_3"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('supplier_cf3', $general->supplier_cf3, 'id="supplier_cf3" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="supplier_cf4"><?php echo lang("custom_field_4"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('supplier_cf4', $general->supplier_cf4, 'id="supplier_cf4" autocomplete="off" class="form-control"');?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <h4><i class="fa fa-book"></i> <?php echo lang("item") ?></h4>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="item_cf1"><?php echo lang("custom_field_1"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('item_cf1', $general->item_cf1, 'id="item_cf1" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="item_cf2"><?php echo lang("custom_field_2"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('item_cf2', $general->item_cf2, 'id="item_cf2" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="item_cf3"><?php echo lang("custom_field_3"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('item_cf3', $general->item_cf3, 'id="item_cf3" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="item_cf4"><?php echo lang("custom_field_4"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('item_cf4', $general->item_cf4, 'id="item_cf4" autocomplete="off" class="form-control"');?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <h4><i class="fa fa-file-o"></i> <?php echo lang("invoice") ?></h4>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="invoice_cf1"><?php echo lang("custom_field_1"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('invoice_cf1', $general->invoice_cf1, 'id="invoice_cf1" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="invoice_cf2"><?php echo lang("custom_field_2"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('invoice_cf2', $general->invoice_cf2, 'id="invoice_cf2" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="invoice_cf3"><?php echo lang("custom_field_3"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('invoice_cf3', $general->invoice_cf3, 'id="invoice_cf3" autocomplete="off" class="form-control"');?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="invoice_cf4"><?php echo lang("custom_field_4"); ?></label>
      <div class="col-md-9">
        <?php echo form_input('invoice_cf4', $general->invoice_cf4, 'id="invoice_cf4" autocomplete="off" class="form-control"');?>
      </div>
    </div>
  </div>
</div>
        </div>
        <!-- CUSTOMER CUSTOM FIELDS SETTINGS END -->


<!-- CHAT -->
<div class="tab-pane form-horizontal" id="general_chat">
  <div class="col-md-12">
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="chat_enable"><?php echo lang("enable"); ?></label>
      <div class="col-md-4">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('chat_enable', "1", $general->chat_enable, 'id="chat_enable" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="chat_support_label"><?php echo lang("chat_support_label"); ?></label>
      <div class="col-md-4">
        <?php
        echo form_input('chat_support_label', set_value("chat_support_label", $general->chat_support_label), 'id="chat_support_label" class="form-control"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="chat_support_id"><?php echo lang("chat_support_id"); ?></label>
      <div class="col-md-4">
        <?php
        $admins = array();
        foreach ($this->ion_auth->get_admins() as $admin) {
          $admins[$admin->id] = $admin->username;
        }
        echo form_dropdown('chat_support_id', $admins, set_value("chat_support_id", $general->chat_support_id), 'id="chat_support_id" class="form-control" required="required"');
        ?>
      </div>
    </div>
  </div>
</div>
<!-- CHAT END -->

<!-- REMINDER -->
<div class="tab-pane form-horizontal" id="general_reminder">
  <div class="col-md-12">
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="reminder_enable"><?php echo lang("enable"); ?></label>
      <div class="col-md-4">
          <label class="switch switch-icon switch-success">
            <?php echo form_checkbox('reminder_enable', "1", $general->reminder_enable, 'id="reminder_enable" class="switch-input"'); ?>
            <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
            <span class="switch-handle"></span>
          </label>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="reminder_subject"><?php echo lang("reminder_subject"); ?></label>
      <div class="col-md-4">
        <?php
        echo form_input('reminder_subject', set_value("reminder_subject", $general->reminder_subject), 'id="reminder_subject" class="form-control"');
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-2 form-control-label" for="reminder_content"><?php echo lang("reminder_content"); ?></label>
      <div class="col-md-10">
        <textarea id="reminder_content" name="reminder_content" class="form-control editor_textarea" rows="6"><?php echo set_value("reminder_content", $general->reminder_content) ?></textarea>
      </div>
    </div>
  </div>
</div>
<!-- REMINDER END -->

<!-- PRIVILEGES -->
<div class="tab-pane form-horizontal" id="general_privileges">
  <div class="col-md-12">
    <h4><?php echo lang("members_permission") ?></h4>
    <div class="col-md-10">
      <b><?php echo lang("posts_level_permission"); ?></b>
      <p>
        <small><?php echo lang("posts_level_permission_p") ?></small><br>
        <small class="text-help text-muted"><?php echo lang("posts_tip") ?></small>
      </p>
      <p>
        <label class="switch switch-xs switch-3d switch-primary">
          <?php echo form_radio('user_all_privileges', "0", !$general->user_all_privileges, 'id="user_all_privileges" class="switch-input"'); ?>
          <span class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
        <label for="user_all_privileges"><?php echo lang("read_his_posts") ?></label>
      </p>
      <p>
        <label class="switch switch-xs switch-3d switch-primary">
          <?php echo form_radio('user_all_privileges', "1", $general->user_all_privileges, 'id="user_all_privileges1" class="switch-input"'); ?>
          <span class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
        <label for="user_all_privileges1"><?php echo lang("read_all_posts") ?></label>
      </p>
    </div>
  </div>
  <div class="col-md-12">
    <h4><?php echo lang("customer_permission") ?></h4>
    <div class="col-md-10">
      <b><?php echo lang("customer_pay_methods"); ?></b>
      <p>
        <small><?php echo lang("customer_pay_methods_p") ?></small><br>
        <small class="text-help text-muted"><?php echo lang("customer_pay_methods_tip") ?></small>
      </p>
      <p>
        <label class="switch switch-xs switch-3d switch-primary">
          <?php echo form_radio('cus_payment_methods', "0", !$general->cus_payment_methods, 'id="cus_payment_methods" class="switch-input"'); ?>
          <span class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
        <label for="cus_payment_methods"><?php echo lang("use_offline_pay_methods") ?></label>
      </p>
      <p>
        <label class="switch switch-xs switch-3d switch-primary">
          <?php echo form_radio('cus_payment_methods', "1", $general->cus_payment_methods, 'id="cus_payment_methods1" class="switch-input"'); ?>
          <span class="switch-label"></span>
          <span class="switch-handle"></span>
        </label>
        <label for="cus_payment_methods1"><?php echo lang("use_all_pay_methods") ?></label>
      </p>
    </div>
  </div>
</div>
<!-- PRIVILEGES END -->


<!-- CONDITIONAL TAXES -->
<div class="tab-pane form-horizontal" id="taxes_conditional">
  <div class="alert alert-info">
    <?php echo lang("conditional_taxes_subheading") ?>
    <p class="small text-muted"><?php echo lang("conditional_taxes_tip") ?></p>
  </div>
  <div class="row form-group">
    <label class="col-md-2 form-control-label" for="tax_conditional_enable"><?php echo lang("enable"); ?></label>
    <div class="col-md-4">
      <label class="switch switch-icon switch-success">
        <?php echo form_checkbox('tax_conditional[enable]', "1", isset($general->tax_conditional->enable), 'id="tax_conditional_enable" class="switch-input"'); ?>
        <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
        <span class="switch-handle"></span>
      </label>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-2 form-control-label" for="tax_conditional_tax_id"><?php echo lang("tax_rate"); ?></label>
    <div class="col-md-4">
      <?php
      $taxes = array();
      foreach ($this->settings_model->getAllTaxRates() as $row) {
        if( strpos($row["label"], "lang:") === false ){
          $taxes[$row["id"]] = $row["label"];
        }else{
          $taxes[$row["id"]] = lang(substr($row["label"], 5));
        }
      }
      echo form_dropdown('tax_conditional[tax_rate_id]', $taxes, $general->tax_conditional->tax_rate_id, 'class="form-control" id="tax_conditional_tax_id"');
      ?>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-2 form-control-label" for="tax_conditional_amount"><?php echo lang("condition"); ?></label>
    <div class="col-md-4">
      <?php $conditions = array("<" => "<", ">" => ">", "=" => "=", "<=" => "<=", ">=" => ">="); ?>
      <div class="input-group">
        <div class="input-group-addon">
          <?php echo form_dropdown('tax_conditional[condition]', $conditions, $general->tax_conditional->condition, 'class="sis_select" id="tax_conditional_condition"'); ?>
        </div>
        <input type="number" step="any" min="0" value="<?php echo $general->tax_conditional->amount ?>" name="tax_conditional[amount]" class="form-control" id="tax_conditional_amount" />
      </div>
    </div>
  </div>
</div>
<!-- CONDITIONAL TAXES END -->


<!-- EXCHANGE API -->
<div class="tab-pane form-horizontal" id="exchange_api">
  <h4>OpenAPI</h4>
  <p>
    <small class="text-help text-muted"><a href="https://openapi.ro/users/sign_up" target="_BLANK"><?php echo lang("create_an_account") ?></a> <?php echo lang("generates_an_api_key") ?></small>
  </p>
  <div class="row form-group">
    <label class="col-md-2 form-control-label" for="exchange_api_key"><?php echo lang("api_key"); ?></label>
    <div class="col-md-9">
      <input type="text" value="<?php echo $general->exchange_api_key ?>" name="exchange_api_key" class="form-control" id="exchange_api_key" />
    </div>
  </div>
</div>
<!-- EXCHANGE API END -->
      </div>
    </div>
  </div>
</div>



<div class="clearfix"></div>
<?php echo form_close();?>
<script type="text/javascript">
$(document).ready(function(){

  $('#enable_register').change(function(){
    if( $(this).val() == "0" ){
      $('#default_group_div').slideDown();
    }else{
      $('#default_group_div').hide();
    }
  }).trigger("change");

  $('.show_reference').click(function(){
    $.get(
      SITE_URL+"/invoices/get_next_reference",
      {
        "t": $('#reference_type').val(),
        "p": $('#prefix_invoice').val(),
      },
      function(data){
        alert(data.reference, "Reference");
      },
      "JSON"
    );
  });

  var SUBMIT = false;
  $('#form_settings_general').submit(function(){
    if( $('#reference_type').val() == <?php echo REFERENCE_TYPE ?> ) {
      SUBMIT = true;
    }
    if( !SUBMIT ){
      bconfirm(globalLang["reference_type_changed"], function(){
        $('input[name=reset_all_references]').val(1);
        SUBMIT = true;
        $('#form_settings_general').submit();
      }, function(){
        $('input[name=reset_all_references]').val(0);
        SUBMIT = true;
        $('#form_settings_general').submit();
      });
    }
    return SUBMIT;
  });


  $("#currency").select2({
    width: 'resolve',
    minimumResultsForSearch: 5
  });

  $("#default_country").select2({
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

  $('#general_tabs a').click(function (e) {
    e.preventDefault();
    createCookie("settings_general_tab", $(this).attr("href"));
    $(this).tab('show');
  });
  //$('#general_tabs a[href="#general_system"]').tab('show');
  var general_tab = "<?php echo isset($_GET['tab'])?$_GET['tab']:"general_system" ?>";
  $('#general_tabs a[href="#'+general_tab+'"]').tab('show');
  if( (general_tab_cookie = readCookie("settings_general_tab")) != undefined ){
    $('#general_tabs a[href="'+general_tab_cookie+'"]').tab("show");
    eraseCookie("settings_general_tab");
  }
});
</script>
