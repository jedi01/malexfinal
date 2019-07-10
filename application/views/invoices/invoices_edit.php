<?php
$this->load->enqueue_style("assets/vendor/jquery.autocomplete/easy-autocomplete.css", "custom");
$this->load->enqueue_script("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js");
$this->load->enqueue_script("assets/js/libs/select2.min.js");
$this->load->enqueue_script("assets/vendor/jquery-ui/jquery-ui-sortable.js");
echo $this->load->css("custom");

$sys = $this->settings_model->SYS_Settings;
$label_params = array(
    "class" => "col-md-3 form-control-label"
);
$invoice_title = array(
    "id" => "inv_title",
    "class" => "form-control",
    "placeholder" => lang("invoice_title"),
    "tabindex" => "0",
);
$invoice_description = array(
    "id" => "inv_title",
    "placeholder" => lang("invoice_description"),
    "class" => "form-control",
);
$invoice_status = array(
    "id" => "inv_status",
    "class" => "form-control"
);
$invoice_date = array(
    "id" => "inv_date",
    "class" => "form-control"
);
$invoice_date_due = array(
    "id" => "inv_date_due",
    "class" => "form-control"
);
$invoice_reference = array(
    "id" => "inv_reference",
    "class" => "form-control"
);
if( set_value("invoice_item", "") != "" ){
    $invoice_items = set_value("invoice_item", "");
}
if( set_value("invoice_taxes", "") != "" ){
    $invoice_taxes = set_value("invoice_taxes", "");
}
if( isset($_POST['bill']) ){
    $biller_js = $_POST['bill'];
}else{
    $biller_js = $invoice_biller;
}
if( !empty($this->settings_model->SYS_Settings->invoice_cf1) ){
  $cf1 = array(
    'name'         => 'invoice[custom_field1]',
    'id'           => 'inv_cf1',
    'value'        => set_value("invoice[custom_field1]", isset($invoice->custom_field1)?$invoice->custom_field1:""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf1 = false;
}
if( !empty($this->settings_model->SYS_Settings->invoice_cf2) ){
  $cf2 = array(
    'name'         => 'invoice[custom_field2]',
    'id'           => 'inv_cf2',
    'value'        => set_value("invoice[custom_field2]", isset($invoice->custom_field2)?$invoice->custom_field2:""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf2 = false;
}
if( !empty($this->settings_model->SYS_Settings->invoice_cf3) ){
  $cf3 = array(
    'name'         => 'invoice[custom_field3]',
    'id'           => 'inv_cf3',
    'value'        => set_value("invoice[custom_field3]", isset($invoice->custom_field3)?$invoice->custom_field3:""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf3 = false;
}
if( !empty($this->settings_model->SYS_Settings->invoice_cf4) ){
  $cf4 = array(
    'name'         => 'invoice[custom_field4]',
    'id'           => 'inv_cf4',
    'value'        => set_value("invoice[custom_field4]", isset($invoice->custom_field4)?$invoice->custom_field4:""),
    'class'        => 'form-control',
    'autocomplete' => "off"
  );
}else{
  $cf4 = false;
}

if( set_value("invoice[due_date]", $invoice->date_due) == NULL ){
    $due_date_chooser = "null";
}else{
    $ts1 = strtotime($invoice->date);
    $ts2 = strtotime($invoice->date_due);
    $seconds_diff = $ts2 - $ts1;
    $days_diff = intval($seconds_diff/(3600*24));
    if( in_array($days_diff, array(7,15,30,45,60))){
        $due_date_chooser = $days_diff."";
    }else{
        $due_date_chooser = "-1";
    }
}

$double_currency = set_value('invoice[double_currency]', $invoice->double_currency);
$rate = set_value('invoice[rate]', $invoice->rate);
?>
<style type="text/css">
.input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
}
.global_tax_item{
    width: 100%;
}
</style>
<?php
echo form_open($form_action, array('class' => 'form-horizontal', 'id'=>"form"));
echo form_hidden('id', $invoice->id);
echo form_input(array("type"=>"hidden", "name"=>"invoice[count]","value"=>$invoice->count,"id"=>"next_count"));
?>
<!-- Page Header -->
<ol class="breadcrumb pos-sticky">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <a href="<?php echo site_url("/".$this->router->fetch_class()) ?>" class="btn btn-link btn-sm" >
            <i class="icon-close h3 text-muted font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("cancel"); ?></small>
        </a>
        <button type="submit" class="btn btn-link btn-sm">
            <i class="icon-check h3 text-success font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("save"); ?></small>
        </button>
        <span class="divider-vertical"></span>
        <a href="#" class="btn btn-link btn-sm preview_invoice" id="preview" >
            <i class="icon-eye h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("preview"); ?></small>
        </a>
    </div>
</ol>
<div class="container-fluid">
	<div class="span12">

        <?php if (isset($is_recurring) && $is_recurring): ?>
        <!-- RECURRING INVOICE -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-calendar"></i> <?php echo lang("recu_invoice_schedule"); ?>
                </div>
                <div class="card-block">
                    <div class="col-md-6 col-lg-5 col-lg-offset-1">
                        <div class="form-group row required">
                            <label>
                                <?php echo form_radio("recurring[type]", "draft", set_radio("recurring[type]", "draft", $rinvoice->type=="draft")); ?>
                                <?php echo lang("rinvoice_draft") ?>
                            </label>
                            <label>
                                <?php echo form_radio("recurring[type]", "sent", set_radio("recurring[type]", "sent", $rinvoice->type=="sent")); ?>
                                <?php echo lang("rinvoice_sent") ?>
                            </label>
                        </div>
                        <div class="form-group row required">
                            <?php echo lang('package_name', 'package_name', $label_params); ?>
                            <div class="col-md-9">
                                <?php echo form_input('recurring[name]', set_value("recurring[name]", $rinvoice->name), array("id" => "package_name", "class" => "form-control")); ?>
                            </div>
                        </div>
                        <div class="form-group row required">
                            <?php echo lang('frequency', 'frequency', $label_params); ?>
                            <div class="col-md-9">
                                <?php
                                $frequencies = $this->settings_model->getRecurringFrequencies();
                                echo form_dropdown('recurring[frequency]', $frequencies, set_value("recurring[frequency]", $rinvoice->frequency), array("id" => "frequency", "class" => "form-control")); ?>
                            </div>
                        </div>
                        <div class="form-group row required">
                            <?php echo lang('every', 'every', $label_params); ?>
                            <div class="col-md-9">
                                <?php
                                $recu_every = $this->settings_model->getRecurringEvery();
                                echo form_dropdown('', $recu_every, "", array("id" => "every_list", "style" => "display:none;"));
                                echo form_dropdown('recurring[number]', array(), set_value("recurring[number]", $rinvoice->number), array("id" => "every", "class" => "form-control")); ?>
                            </div>
                        </div>
                        <div class="form-group row required">
                            <?php echo lang('occurences', 'occurences', $label_params); ?>
                            <div class="col-md-9">
                                <?php echo form_input(array("name" => 'recurring[occurence]', "value" => set_value("recurring[occurence]", $rinvoice->occurence), "type" => "number", "step" => "1", "min" => "0", "id" => "occurences", "class" => "form-control")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>
                            <i class="icon-loop h4 media-middle text-primary font-weight-bold"></i> <?php echo lang("recu_when_create") ?>
                        </h4>
                        <small id="recurring_frequency"></small>
                        <hr>
                        <h4>
                            <i class="icon-calendar h4 media-middle text-primary font-weight-bold"></i> <?php echo lang("recu_when_start") ?>
                        </h4>
                        <small id="recurring_end"></small>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <!-- RECURRING INVOICE END -->
        <?php endif ?>

		<div class="card">
            <div class="card-header">
                <div class="col-sm-3 form-group m-a-0">
                    <?php echo form_input('invoice[title]', set_value('invoice[title]', $invoice->title), $invoice_title); ?>
                </div>
                <div class="col-sm-4 form-group m-a-0">
                    <?php echo form_input('invoice[description]', set_value('invoice[description]', $invoice->description), $invoice_description); ?>
                </div>
                <div class="col-md-3 form-group m-a-0">
                    <?php
                    echo '<select name="invoice[currency]" id="currency" class="form-control">';
                    foreach ($this->settings_model->getFormattedCurrencies() as $currency) {
                        echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".($currency->value==set_value("invoice[currency]", $invoice->currency)?"selected='selected'":"" ).">".$currency->label."</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="col-sm-2 form-group m-a-0">
                    <?php
                    $status = $this->settings_model->getInvoiceStatus();
                    if( $invoice->status != "paid" &&  $invoice->status != "partial" ){
                        unset($status['partial']);
                    }
                    /*if( $invoice->status != "canceled" ){
                        unset($status['canceled']);
                    }*/
                    if( $invoice->status != "panding" ){
                        unset($status['panding']);
                    }
                    if( $invoice->status != "overdue" ){
                        unset($status['overdue']);
                    }
                    echo form_dropdown('invoice[status]', $status, set_value("invoice[status]", $invoice->status), $invoice_status);
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="card-block">
                <div class="col-md-6">
                    <!-- REFERENCE -->
                    <div class="form-group row required">
                        <?php echo lang('reference', 'inv_reference', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                <?php echo form_input('invoice[reference]', set_value('invoice[reference]', $invoice->reference), $invoice_reference); ?>
                                <span class="input-group-btn">
                                    <button type="button" id="generate_reference" class="btn btn-secondary tip" title="<?php echo lang("generate") ?>"><i class="fa fa-refresh"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- BILL TO -->
                    <div class="form-group row required">
                        <?php echo lang('customer_bill_to', 'inv_bill_to', $label_params); ?>
                        <?php echo form_hidden('invoice[bill_to_id]', set_value('invoice[bill_to_id]', $invoice_biller->id)); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="inv_bill_to" value="<?php echo set_value("biller",$invoice_biller->fullname) ?>" name="biller">
                                <span class="input-group-btn">
                                    <a href="<?php echo site_url("billers/create") ?>" sis-modal="" class="btn btn-secondary tip sis_modal" title="<?php echo lang("add") ?>" ><i class="fa fa-plus"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- DATE -->
                    <div class="form-group row required">
                        <?php echo lang('date', 'inv_date', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php
                                echo form_input($invoice_date);
                                echo form_hidden('invoice[date]', set_value('invoice[date]', date_MYSQL_JS($invoice->date)));
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- DUE DATE -->
                    <div class="form-group row">
                        <?php echo lang('date_due', 'inv_date_due', $label_params); ?>
                        <div class="col-md-9">
                            <?php
                            echo form_dropdown('due_date_chooser', $this->settings_model->getDueDates(), $due_date_chooser, 'class="form-control" id="due_date_chooser"');
                            ?>
                            <div class="input-group m-t-1">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php
                                echo form_input($invoice_date_due);
                                echo form_hidden('invoice[date_due]', set_value('invoice[date_due]', date_MYSQL_JS($invoice->date_due)));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CUSTOM FIELDS -->
                <?php if ($cf1): ?>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-3 form-control-label" for="inv_cf1"><?php echo $this->settings_model->SYS_Settings->invoice_cf1;?></label>
                        <div class="col-md-9">
                            <?php echo form_input($cf1); ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if ($cf2): ?>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-3 form-control-label" for="inv_cf2"><?php echo $this->settings_model->SYS_Settings->invoice_cf2;?></label>
                        <div class="col-md-9">
                            <?php echo form_input($cf2); ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if ($cf3): ?>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-3 form-control-label" for="inv_cf3"><?php echo $this->settings_model->SYS_Settings->invoice_cf3;?></label>
                        <div class="col-md-9">
                            <?php echo form_input($cf3); ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if ($cf4): ?>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-3 form-control-label" for="inv_cf4"><?php echo $this->settings_model->SYS_Settings->invoice_cf4;?></label>
                        <div class="col-md-9">
                            <?php echo form_input($cf4); ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <!-- CUSTOM FIELDS -->

                <!-- SECOND CURRENCY -->
                <div class="clearfix"></div>
                <div class="well p-b-0" id="double_currency_div" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-md-3 form-control-label" for="double_currency"><?php echo lang("activate_double_currency");?></label>
                                <div class="col-md-9">
                                    <label class="switch switch-icon switch-success">
                                        <?php echo form_checkbox('invoice[double_currency]', "1", $double_currency, 'id="double_currency" class="switch-input"'); ?>
                                        <span class="switch-label" data-on="&#xF00C;" data-off="&#xF00D;"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-md-3 form-control-label" for="rate"><?php echo lang("rate");?></label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><b class="p-x-2">1 <span class="symbol_native"></span></b></span>
                                        <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                        <?php echo form_input(array(
                                            'name'         => 'invoice[rate]',
                                            'id'           => 'rate',
                                            'value'        => $rate,
                                            'class'        => 'form-control',
                                            'autocomplete' => "off",
                                            'type'         => "number",
                                            'min'          => "0",
                                            'step'         => "any",
                                          )); ?>
                                        <span class="input-group-addon"><b class="p-x-2"><?php echo CURRENCY_SYMBOL ?></b></span>
                                        <?php if ( trim(EXCHANGE_API_KEY) != "" ): ?>
                                        <span class="input-group-btn">
                                            <a href="#" class="btn btn-secondary tip" title="<?php echo lang("change") ?>" id="get_rate"><i class="fa fa-refresh"></i></a>
                                        </span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /SECOND CURRENCY -->

                <div class="col-md-12 form-group required">
                    <?php echo form_hidden('items_count', count($invoice_items)); ?>
                    <table class="table table-striped table-hover" id="items">
                        <thead class="transparent">
                            <tr>
                                <th style="max-width:16px;"><i class="fa fa-arrows"></i></th>
                                <th style="min-width:250px;"><?php echo lang('name'); ?> <small><?php echo lang('description'); ?></small></th>
                                <th width="10%"><?php echo lang('quantity'); ?></th>
                                <th width="10%"><?php echo lang('unit_price'); ?></th>
                                <?php if (ITEM_TAX==2): ?>
                                    <th width="10%"><?php echo lang('tax'); ?></th>
                                <?php endif ?>
                                <?php if (ITEM_DISCOUNT==2): ?>
                                    <th width="10%"><?php echo lang('discount'); ?></th>
                                <?php endif ?>
                                <th width="10%"><?php echo lang('total'); ?></th>
                                <th><i class="fa fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button type="button" class="btn" id="add_row"><?php echo lang("add_row") ?></button>
                </div>
                <div class="col-lg-6 col-lg-offset-6">
                    <div class="form-group row">
                        <?php echo lang('subtotal', 'subtotal', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" readonly="readonly" value="0" class="form-control" id="subtotal_shown" />
                                <input type="hidden" readonly="readonly" value="0" name="invoice[subtotal]" id="subtotal" />
                                <span class="input-group-addon symbol_native">$</span>
                            </div>
                        </div>
                    </div>
                    <?php if (ITEM_DISCOUNT==1): ?>
                    <div class="form-group row">
                        <?php echo lang('global_discount', 'global_discount', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="col-xs-6" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="number" step="any" min="0" value="<?php echo set_value("invoice[global_discount]", $invoice->global_discount) ?>" name="invoice[global_discount]" class="form-control" id="global_discount" />
                                        <span class="input-group-addon">
                                            <?php
                                            $discount_types = array("%", CURRENCY_SYMBOL);
                                            echo form_dropdown('invoice[discount_type]', $discount_types, set_value("invoice[discount_type]", $invoice->discount_type), 'id="inv_discount_type"');
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="text" readonly="readonly" value="0" class="form-control" id="global_discount_shown" />
                                        <span class="input-group-addon symbol_native" >$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if (ITEM_TAX==1): ?>
                    <div class="form-group row">
                        <?php echo lang('global_tax', 'global_tax', $label_params); ?>
                        <div class="col-md-9" id="global_taxes">
                            <button type="button" id="add_global_tax" class="btn btn-block btn-primary"><?php echo lang("add_tax") ?></button>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if (SHIPPING): ?>
                    <div class="form-group row">
                        <?php echo lang('shipping', 'shipping', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" step="any" min="0" value="<?php echo set_value("invoice[shipping]", $invoice->shipping) ?>" name="invoice[shipping]" class="form-control" id="shipping" />
                                <span class="input-group-addon symbol_native" >$</span>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="form-group row">
                        <?php echo lang('total', 'total', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" readonly="readonly" value="0" class="form-control" id="total_shown" />
                                <input type="hidden" readonly="readonly" value="0" name="invoice[total]" id="total" />
                                <input type="hidden" readonly="readonly" value="0" name="invoice[total_tax]" />
                                <input type="hidden" readonly="readonly" value="0" name="invoice[total_discount]" />
                                <span class="input-group-addon symbol_native">$</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php echo lang('paid_amount', 'paid_amount', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" step="any" min="0" readonly="readonly" value="<?php echo $invoice->total-$invoice->total_due ?>" class="form-control" id="paid_amount" />
                                <span class="input-group-addon symbol_native" >$</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php echo lang('amount_due', 'total_due', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" readonly="readonly" value="0" class="form-control" id="total_due" />
                                <input type="hidden" readonly="readonly" value="0" name="invoice[total_due]" />
                                <span class="input-group-addon symbol_native" >$</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label"><?php echo lang("invoice_note"); ?></label>
                            <textarea class="form-control" rows="3" name="invoice[note]" id="editor_note"><?php echo set_value("invoice[note]", $invoice->note) ?></textarea>
                        </div>
                    </div>
                </div>
                <?php if ($sys->enable_terms): ?>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label"><?php echo lang("condition_terms"); ?></label>
                            <textarea class="form-control" rows="3" name="invoice[terms]" id="editor_terms"><?php echo set_value("invoice[terms]", $invoice->terms) ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <div class="clearfix"></div>

			</div>
            <div class="card-footer text-md-right">
                <a href="<?php echo site_url("/invoices") ?>" class="btn btn-secondary"><?php echo lang("cancel") ?></a>
                <a href="#" class="btn btn-secondary preview_invoice" id="preview"><i class="fa fa-print"></i> <?php echo lang("preview") ?></a>
                <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
            </div>
		</div>
        <?php echo form_close(); ?>
	</div>

    <!-- Preview -->
    <div class="card card-secondary-outline" style="display: none">
        <div class="card-header">
            <?php echo lang("preview") ?>
        </div>
        <div class="card-block" id="preview_page">
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function() {
    /* DATES */
    $.fn.datepicker.defaults.language = globalLang["lang"];
    $("#inv_date, #inv_date_due").mask(MASK_DATE,{placeholder:JS_DATE});

    $("#inv_date").datepicker({
        "todayHighlight": true,
        "format": DATEPICKER_FORMAT
    })
    .on("changeDate", function(){
        $("#inv_date_due").datepicker("setStartDate", $("#inv_date").datepicker("getDate"));
    })
    .on("change", function(){
        if( $(this).datepicker("getDate") != null ){
            $('input[name="invoice[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="invoice[date]"]').val("");
        }
        $('#due_date_chooser').trigger("change");
    });

    $("#inv_date_due").datepicker({
        "todayHighlight": true,
        "clearBtn": true,
        "format": DATEPICKER_FORMAT
    })
    .on("changeDate", function(){
        $("#inv_date").datepicker("setEndDate", $("#inv_date_due").datepicker("getDate"));
    })
    .on("change", function(){
        if( $(this).datepicker("getDate") != null ){
            $('input[name="invoice[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="invoice[date_due]"]').val("");
        }
    });

    if( $('input[name="invoice[date]"]').val() != "" ){
        $("#inv_date").datepicker("setDate",date_locale($('input[name="invoice[date]"]').val(), "en", globalLang["lang"]));
    }else{
        $("#inv_date").trigger("changeDate");
    }
    if( $('input[name="invoice[date_due]"]').val() != "" ){
        $("#inv_date_due").datepicker("setDate",date_locale($('input[name="invoice[date_due]"]').val(), "en", globalLang["lang"]));
    }else{
        $("#inv_date_due").trigger("changeDate");
    }

    $('#due_date_chooser').on("change", function(){
        var value = $(this).val();
        if( value == "null" ){
            $('#inv_date_due').parent(".input-group").hide();
            $("#inv_date_due").datepicker("setDate", "");
        }
        else if( value == "-1" ){
            $('#inv_date_due').parent(".input-group").show();
        }
        else{
            $('#inv_date_due').parent(".input-group").hide();
            days = parseInt(value);
            start_date = $("#inv_date").datepicker("getDate");
            start_date.setDate(start_date.getDate()+days);
            m = new moment(start_date, JS_DATE);
            $("#inv_date_due").datepicker("setDate",m.locale(globalLang["lang"]).format(JS_DATE));
        }
    }).trigger("change");

    /* REFERENCE */
    function get_next_reference(refresh){
        reference_type = <?php echo REFERENCE_TYPE ?>;
        YEAR =  <?php echo date("y") ?>;
        if( $('#inv_date').datepicker('getDate') != null ){
            YEAR = $('#inv_date').datepicker('getDate').getYear()-100;
        }
        dataJson = {
            "c": <?php echo $invoice->count ?>,
            "y": YEAR
        };
        if( refresh ){
            $.get(
                SITE_URL+"/invoices/get_next_reference",
                dataJson,
                function(data){
                    $("#inv_reference").val(data.reference);
                },
                "JSON"
            );
        }else{
            switch(reference_type){
                case 0: ref_mask = false; ref_placeholder = ""; break;
                case 1: ref_mask = "9?99999"; ref_placeholder = "______"; break;
                case 2: ref_mask = INVOICE_PREFIX+"9?99999"; ref_placeholder = INVOICE_PREFIX+"______"; break;
                case 3: ref_mask = "9?99999"+INVOICE_PREFIX; ref_placeholder = "______"+INVOICE_PREFIX; break;
                case 4: ref_mask = INVOICE_PREFIX+YEAR+"9?999"; ref_placeholder = INVOICE_PREFIX+YEAR+"____"; break;
                case 5: ref_mask = "*?*****"; ref_placeholder = "______"; break;
                case 6: ref_mask = INVOICE_PREFIX+"*?*****"; ref_placeholder = INVOICE_PREFIX+"______"; break;
            }
            $("#inv_reference").mask(ref_mask,{placeholder:ref_placeholder});
        }
    }
    get_next_reference();
    $('#generate_reference').click(function(){
        get_next_reference(true);
    });

    /*
     * TAX RATES MANAGE
     */
    var symbol_native = "<?php echo CURRENCY_SYMBOL ?>";//$("#currency").find('option:selected').attr("symbol_native");

    $.tax = {
        rates : <?php echo json_encode($tax_rates); ?>,
        getAllTaxRates: function(){
            var self = this;
            var ajax_data = {};
            ajax_data[CSRF_NAME] = CSRF_HASH;
            $.ajax({
                url:SITE_URL+"/settings/getAllTaxRates",
                data: ajax_data,
                type: "POST",
                async: false,
                success: function(x, y, z){
                    self.rates = x;
                }
            });
            return self.rates;
        },
        create : function(){
            var self = this;
            var select = $('<select class="tax_rate_select"></select>');
            for (var i = 0; i < self.rates.length; i++) {
                var rate = self.rates[i];
                if( rate.type == 0 ){
                    type = "%";
                }else{
                    type = symbol_native;
                }
                label = rate.label;
                if( label.startsWith("lang:") ){
                    label = globalLang[label.substring(5)];
                }
                value = parseFloat(rate.value);
                selected = "";
                if( rate.is_default == 1 ){
                    selected = "selected='selected'";
                }
                $('<option data-value="'+rate.value+'" data-type="'+rate.type+'" data-label="'+label+'" value="'+rate.id+'" '+selected+'>'+label+" ("+(value.toFixed(2))+" "+type+')</option>').appendTo(select);
            }
            return select;
        },
        addGlobal: function(id, recalculate, isConditional){
            if( id == undefined ){
                id = false;
            }
            if( recalculate == undefined ){
                recalculate = true;
            }
            if( isConditional == undefined ){
                isConditional = false;
            }
            var index = Math.floor(Math.random() * 9999999) + 1000000 ;
            var self = this;
            var item = $('<div class="input-group global_tax_item"></div>');
            var col1 = $('<div class="input-group"></div>');
            var col2 = $('<div class="input-group"></div>');
            $(col1).appendTo($('<div class="col-xs-6" style="padding: 0;"></div>').appendTo(item));
            $(col2).appendTo($('<div class="col-xs-6" style="padding: 0;"></div>').appendTo(item));
            $.tax.create().addClass("form-control sis_select").attr("name", "invoice_taxes["+index+"][tax_rate_id]").appendTo(col1);
            $('<span class="input-group-addon"><button type="button" class="btn btn-link text-danger delete_global_tax"><i class="fa fa-trash"></i></button></span>').appendTo(col1);
            $('<input readonly="readonly" value="0" class="form-control global_row" type="text">').appendTo(col2);
            $('<span class="input-group-addon symbol_native">$</span>').appendTo(col2);
            if( id ){
                item.find("select option[value='"+id+"']").attr("selected", "selected");
            }

            $('<input type="hidden" class="tax_label" value="'+item.find("option:selected").data("label")+'" name="invoice_taxes['+index+'][label]" />'+
              '<input type="hidden" class="tax_value" value="'+item.find("option:selected").data("value")+'" name="invoice_taxes['+index+'][value]" />'+
              '<input type="hidden" class="tax_is_conditional" value="'+(isConditional?"1":"0")+'" name="invoice_taxes['+index+'][is_conditional]" />'+
              '<input type="hidden" class="tax_type" value="'+item.find("option:selected").data("type")+'" name="invoice_taxes['+index+'][type]" />').appendTo(item);
            $(item).insertBefore($("#add_global_tax"));
            $(item).find(".delete_global_tax").click(function(){
                self.deleteGlobal(item);
                return false;
            });
            $(item).find("select").change(function(){
                $.items.calculate();
                $(item).find("input.tax_label").val(item.find("option:selected").data("label"));
                $(item).find("input.tax_value").val(item.find("option:selected").data("value"));
                $(item).find("input.tax_type").val(item.find("option:selected").data("type"));
            });
            if( isConditional ){
                $(item).addClass("tax_conditional");
            }
            if( recalculate ){
                $.items.calculate();
            }
            setCurrency();
            return item;
        },
        deleteGlobal : function(item){
            $(item).remove();
            $.items.calculate();
        },
        updateGlobal: function(){
            var self = this;
            var ids = [];
            $.each($('#global_taxes .global_tax_item'), function(i, item){
                id = $(item).find("select").val();
                ids.push(id);
                self.deleteGlobal(item);
            });
            $.each(ids, function(i, id){
                self.addGlobal(id);
            });
        },
    }
    $('#add_global_tax').click(function(){
        $.tax.addGlobal();
    });

    $('#global_tax, #global_discount, #inv_discount_type, #shipping, #paid_amount').on("change", function(){
        if( $(this).is("input") && $(this).val() == "" ){
            $(this).val("0");
        }
        $.items.calculate();
    });


    tinymce.remove("#editor_note, #editor_terms");
    tinymce.init(
        Object.assign({}, tinymce_init, {
            selector: '#editor_note, #editor_terms',
            height: 150,
        })
    );

    /*
     *  BILLER (AUTOCOMPLETE)
     */
    var selected_biller = <?php echo json_encode($biller_js); ?>;
    $('#inv_bill_to')
    .change(function(){
        if( $(this).val() == "" ){
            selected_biller = null;
            $('input[name="invoice[bill_to_id]"]').val("");
        }
    })
    .blur(function(){
        if( selected_biller != null && $(this).val() != selected_biller.fullname ){
            $('input[name="invoice[bill_to_id]"]').val(selected_biller.id);
            $(this).val(selected_biller.fullname);
        }
    })
    .easyAutocomplete({
        url: function(phrase) {return SITE_URL+"/billers/suggestions?term=" + phrase;},
        ajaxSettings: {data: CSRF_DATA},
        getValue: "label",
        placeholder: globalLang["customer_suggestion_placeholder"],
        minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
        use_on_focus: true,
        template: {
            type: "custom",
            method: function(value, item) {
                var actions = "<div class='actions flip pull-right'>";
                actions += "<a href='#' class='delete_biller btn btn-sm btn-secondary' data-id='" + item.id + "'><i class='fa fa-trash'></i></a>";
                actions += "<a href='" + SITE_URL + "/billers/edit?id=" + item.id + "' sis-modal='' class='sis_modal btn btn-sm btn-secondary'><i class='fa fa-pencil'></i></a>";
                actions += "</div>";
                return actions +  value;
            }
        },
        list: {
            maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
            hideOnEmptyPhrase: false,
            onSelectItemEvent: function() {
                var data = $("#inv_bill_to").getSelectedItemData();
                $('input[name="invoice[bill_to_id]"]').val(data.id).trigger("change");
                $('.easy-autocomplete').css("width","inherit");
                selected_biller = data;
            },
            onShowListEvent: function() {
                $('.delete_biller').unbind("click").on("click", function(ev){
                    var id = $(this).data("id");
                    bconfirm(globalLang['alert_confirmation'], function(){
                        $(document).load_ajax(SITE_URL+"/billers/delete?id="+id);
                        $('#inv_bill_to').val("").get(0).focus();
                    });
                    ev.preventDefault();
                    return false;
                });
            }
        }
    });

    /*
     * ITEMS MANAGE
     */

    $.items = {
        /* CREATE ITEM */
        create : function(name, description, quantity, unit_price, tax, tax_type, discount, discount_type, item_id){
            var self = this;
            description = str_replace("<br>", "\n", description);

            var item = $('<tr class="item"></tr>');
            // sortable td
            $('<td class="dragger"></td>').appendTo(item);
            // name & description
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="text" class="form-control item_name text-xs-left" name="invoice_item[][name]" placeholder="'+globalLang["name"]+'" value="'+name+'" autocomplete="off" />'+
                    '<input type="hidden" class="item_id" name="invoice_item[][item_id]" value="'+item_id+'" />'+
                    '<span class="input-group-addon"><a href="#" class="item_show_description" title="'+globalLang["show_description"]+'"><i class="fa fa-align-center"></i></a></span>'+
                '</div>'+
                '<textarea rows="1" class="form-control item_description" name="invoice_item[][description]" placeholder="'+globalLang["description"]+'" style="display: none;">'+description+'</textarea>'+
            '</td>').appendTo(item);
            // quantity
            $('<td class="td-input">'+
                '<input type="number" step="any" min="0" name="invoice_item[][quantity]" class="form-control item_qty" value="'+quantity+'" />'+
            '</td>').appendTo(item);
            // unit_price
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+unit_price+'" name="invoice_item[][unit_price]" class="form-control item_price" />'+
                    '<span class="input-group-addon symbol_native">$</span>'+
                '</div>'+
            '</td>').appendTo(item);
            // tax
            <?php if (ITEM_TAX==2): ?>
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+tax+'" name="invoice_item[][tax]" class="form-control item_tax" />'+
                    '<span class="input-group-btn">'+
                        '<select class="btn item_tax_type" >'+
                            '<option value="0" '+(tax_type=="0"?"selected='selected'":"")+'>%</option>'+
                            '<option value="1" class="symbol_native" '+(tax_type=="1"?"selected='selected'":"")+'>$</option>'+
                        '</select>'+
                    '</span>'+
                '</div>'+
            '</td>').appendTo(item);
            <?php endif ?>
            // discount
            <?php if (ITEM_DISCOUNT==2): ?>
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+discount+'" name="invoice_item[][discount]" class="form-control item_discount" />'+
                    '<span class="input-group-btn">'+
                        '<select class="btn item_discount_type" >'+
                            '<option value="0" '+(discount_type=="0"?"selected='selected'":"")+'>%</option>'+
                            '<option value="1" class="symbol_native" '+(discount_type=="1"?"selected='selected'":"")+'>$</option>'+
                        '</select>'+
                    '</span>'+
                '</div>'+
            '</td>').appendTo(item);
            <?php endif ?>
            // total
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="text" readonly="readonly" value="0" class="form-control item_total_shown" />'+
                    '<input type="hidden" readonly="readonly" value="0" name="invoice_item[][total]" class="item_total" />'+
                    '<span class="input-group-addon symbol_native">$</span>'+
                '</div>'+
            '</td>').appendTo(item);
            // delete item
            $('<td class="td-input">'+
                '<button type="button" class="btn btn-link text-danger item_delete tip" title="'+globalLang["delete"]+'"><i class="fa fa-trash"></i></button>'+
            '</td>').appendTo(item);

            $("#items tbody").append(item);

            $(item).find("input[type=number], select").on("change keyup", function(){
                if( $(this).is("input[type=number]") ){
                    if( $(this).val() == "" ){
                        $(this).val("0");
                    }else{
                        $(this).extendWidth();
                    }
                }
                self.calculate();
                self.set_items_count();
            });

            $.each($(item).find("input[type=number]"), function(i, input){
                $(input).css({"min-width": $(input).width()});
            });
            $(item).find(".item_name").change(function(){
                self.set_items_count();
            });
            $(item).find(".item_show_description").click(function(){
                $(item).find(".item_description").slideToggle();
                return false;
            });
            $(item).find(".item_delete").click(function(){
                self.delete(item);
                return false;
            });

            $(item).find('.item_name').easyAutocomplete({
                url: function(phrase) {return SITE_URL+"/items/suggestions?term=" + phrase + "&currency="+$("select#currency").val();},
                ajaxSettings: {data: CSRF_DATA},
                getValue: "name",
                placeholder: globalLang["item_suggestion_placeholder"],
                minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
                use_on_focus: true,
                list: {
                    maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
                    hideOnEmptyPhrase: false,
                    onSelectItemEvent: function() {
                        var data = $(item).find('.item_name').getSelectedItemData();
                        $(item).find('.item_id').val(data.id);
                        $(item).find('.item_name').val(data.name);
                        $(item).find('.item_description').val(data.description);
                        $(item).find('.item_price').val(data.price).trigger("change");
                        $(item).find('.item_tax').val(data.tax).trigger("change");
                        $(item).find('.item_tax_type').val(data.tax_type).trigger("change");
                        $(item).find('.item_discount').val(data.discount).trigger("change");
                        $(item).find('.item_discount_type').val(data.discount_type).trigger("change");
                        $('.easy-autocomplete').css("width","inherit");
                    },
                    onLoadEvent: function(){
                        $(item).find('.item_id').val("0");
                        $(item).find('.item_description').val("");
                        $(item).find('.item_price').val("0").trigger("change");
                        $(item).find('.item_tax').val("0").trigger("change");
                        $(item).find('.item_tax_type').val("0").trigger("change");
                        $(item).find('.item_discount').val("0").trigger("change");
                        $(item).find('.item_discount_type').val("0").trigger("change");
                    }
                }
            });
            this.calculate();
            this.reset_count();
            setCurrency();
            if( PAGE_IS_LOADED ){
                $(item).find(".item_name").get(0).focus();
            }
        },
        /* DELETE ITEM */
        delete : function(item){
            $(item).remove();
            this.calculate();
            this.reset_count();
        },
        /* CALCULATE TOTALS */
        calculate: function(){
            var subtotal = 0, total_tax = 0, total_discount = 0;
            $.each($("#items tbody tr.item"), function(i, item){
                if( $(item).find(".item_name").val() == "" ){
                    return true;
                }
                item_qty = $(item).find(".item_qty").val();
                item_price = $(item).find(".item_price").val();

                item_total = parseFloat(item_qty)*parseFloat(item_price);

                item_discount = 0;
                <?php if (ITEM_DISCOUNT==2): ?>
                item_discount = $(item).find(".item_discount").val();
                item_discount_type = $(item).find(".item_discount_type").val();
                if( item_discount_type+"" == "0" ){ // percent %
                    item_discount = item_total * (parseFloat(item_discount)/100);
                }
                <?php endif ?>
                item_total = item_total-parseFloat(item_discount);

                item_tax = 0;
                <?php if (ITEM_TAX==2): ?>
                item_tax = $(item).find(".item_tax").val();
                item_tax_type = $(item).find(".item_tax_type").val();
                if( item_tax_type+"" == "0" ){ // percent %
                    item_tax = item_total * (parseFloat(item_tax)/100);
                }
                <?php endif ?>

                item_total = item_total+parseFloat(item_tax);
                subtotal += item_total;
                total_tax += parseFloat(item_tax);
                total_discount += parseFloat(item_discount);
                $(item).find(".item_total").val(item_total);
                $(item).find(".item_total_shown").val(Format_Currency(item_total)).extendWidth();
            });

            $('#subtotal').val(subtotal);
            $('#subtotal_shown').val(Format_Currency(subtotal));


            global_discount = 0;
            <?php if (ITEM_DISCOUNT==1): ?>
                global_discount = $("#global_discount").val();
                global_discount_type = $("#inv_discount_type").val();
                if( global_discount_type+"" == "0" ){ // percent %
                    global_discount = subtotal * (parseFloat(global_discount)/100);
                }
                $('#global_discount_shown').val(Format_Currency(global_discount));
            <?php endif; ?>
            subtotal = subtotal-parseFloat(global_discount);

            check_conditional_taxes(subtotal);

            global_tax = 0;
            $.each($('#global_taxes .global_tax_item'), function(i, item){
                var item_value = $(item).find("select").find('option:selected').data("value");
                var item_type = $(item).find("select").find('option:selected').data("type");
                var item_total = 0;
                if( item_type+"" == "0" ){ // percent %
                    item_value = subtotal * (parseFloat(item_value)/100);
                }else{ // flat
                    item_value = parseFloat(item_value);
                }
                $(item).find('.global_row').val(Format_Currency(item_value));
                global_tax += item_value;
            });
            total_tax += parseFloat(global_tax);
            total_discount += parseFloat(global_discount);

            shipping = 0;
            <?php if (SHIPPING): ?>
                shipping = parseFloat($('#shipping').val());
            <?php endif; ?>

            total = subtotal+parseFloat(global_tax)+shipping;
            total_due = total;
            if( $('#inv_status').val() == 'paid' ){
                total_due = 0;
            }
            if( $('#inv_status').val() == 'partial' ){
                total_due = total - parseFloat($('#paid_amount').val());
            }
            $('#total_due').val(Format_Currency(total_due));
            $('input[name="invoice[total_tax]"]').val(total_tax);
            $('input[name="invoice[total_discount]"]').val(total_discount);
            $('input[name="invoice[total_due]"]').val(total_due);
            $('#total').val(total);
            $('#total_shown').val(Format_Currency(total));
        },
        /* RESET ITEM INDEXES */
        reset_count: function(){
            $.each($("#items tbody tr.item"), function(index, item){
                if( index == 0 ){
                    $(item).find(".item_delete").attr("disabled", "disabled");
                }else{
                    $(item).find(".item_delete").removeAttr("disabled");
                }
                $(item).find(".item_name").attr("name", "invoice_item["+index+"][name]");
                $(item).find(".item_id").attr("name", "invoice_item["+index+"][item_id]");
                $(item).find(".item_description").attr("name", "invoice_item["+index+"][description]");
                $(item).find(".item_qty").attr("name", "invoice_item["+index+"][quantity]");
                $(item).find(".item_price").attr("name", "invoice_item["+index+"][unit_price]");
                $(item).find(".item_tax").attr("name", "invoice_item["+index+"][tax]");
                $(item).find(".item_tax_type").attr("name", "invoice_item["+index+"][tax_type]");
                $(item).find(".item_discount").attr("name", "invoice_item["+index+"][discount]");
                $(item).find(".item_discount_type").attr("name", "invoice_item["+index+"][discount_type]");
                $(item).find(".item_total").attr("name", "invoice_item["+index+"][total]");
            });
            this.set_items_count();
        },
        /* RESET ITEM INDEXES */
        set_items_count: function(){
            var count = 0;
            $.each($("#items tbody tr.item"), function(index, item){
                if( $(item).find(".item_name").val() != "" ){
                    count++;
                }
            });
            $('input[name=items_count]').val(count);
        }
    }

    $('#items tbody').sortable({
        placeholder: "dragger_tr",
        handle: ".dragger",
        start: function (event, ui) {
            ui.placeholder.html('<td colspan="10">&nbsp;</td>');
            console.log(ui);
            $(ui.item).find('td:first-child').get(0).focus();
            $('#items .item_name').blur();
        },
        update: function(){
            $.items.reset_count();
        },
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }
    });

    function check_conditional_taxes(subtotal){
        $('.tax_conditional').remove();
        var tax_conditional = <?php echo json_encode($this->settings_model->SYS_Settings->tax_conditional) ?>;
        if (tax_conditional.enable) {
            has_condition = false;
            switch(tax_conditional.condition){
                case "<":  has_condition = (parseFloat(subtotal)<parseFloat(tax_conditional.amount)); break;
                case ">":  has_condition = (parseFloat(subtotal)>parseFloat(tax_conditional.amount)); break;
                case "=":  has_condition = (parseFloat(subtotal)==parseFloat(tax_conditional.amount)); break;
                case "<=": has_condition = (parseFloat(subtotal)<=parseFloat(tax_conditional.amount)); break;
                case ">=": has_condition = (parseFloat(subtotal)>=parseFloat(tax_conditional.amount)); break;
            }
            if( has_condition ){ // add conditional tax
                var conditional_item = $.tax.addGlobal(tax_conditional.tax_rate_id, false, true);
            }
        }
    }

    $('#add_row').click(function(){
        $.items.create("","",1,0,0,0,0,0);
    });

    $('#form').submit(function(){
        $.each($("#items tbody tr.item"), function(count, item){
            if( $(item).find(".item_name").val() == ""
                && $(item).find(".item_description").val() == ""
                && $(item).find(".item_qty").val() == "1"
                && $(item).find(".item_price").val() == "0"
                <?php if (ITEM_TAX==2): ?>
                && $(item).find(".item_tax").val() == "0"
                && $(item).find(".item_tax_type").val() == "0"
                <?php endif ?>
                <?php if (ITEM_DISCOUNT==2): ?>
                && $(item).find(".item_discount").val() == "0"
                && $(item).find(".item_discount_type").val() == "0"
                <?php endif ?>
                && $(item).find(".item_total").val() == "0" ){
                $(item).addClass("removed");
            }
        });
        $("#items tbody tr.removed").remove();
    });

    <?php
    if (empty($invoice_items)){
        echo "$.items.create('','',1,0,0,0,0,0,0);\n";
    }else{
        foreach ($invoice_items as $key => $item){
            $item['description'] = str_replace("\r\n", "<br>", $item['description']);
            if( ITEM_TAX==2 && ITEM_DISCOUNT==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",".$item['tax'].",".$item['tax_type'].",".$item['discount'].",".$item['discount_type'].",".$item['item_id'].");\n";
            }
            elseif( ITEM_TAX==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",".$item['tax'].",".$item['tax_type'].",0,0,".$item['item_id'].");\n";
            }
            elseif( ITEM_DISCOUNT==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",0,0,".$item['discount'].",".$item['discount_type'].",".$item['item_id'].");\n";
            }else{
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",0,0,0,0,".$item['item_id'].");\n";
            }
        }
    }

    if( !empty($invoice_taxes) ){
        foreach ($invoice_taxes as $key => $item) {
            echo "$.tax.addGlobal('".$item['tax_rate_id']."', false, ".$item["is_conditional"].");\n";
        }
    }
    ?>
    $('#global_tax, #global_discount, #inv_discount_type, #shipping, #paid_amount').trigger("change");


    $('.preview_invoice').click(function(){
        var data = $('#form').serialize();
        if( $('input[name="invoice[date]"]').val() == ""
            || $('input[name="invoice[bill_to_id]"]').val() == "" ){
            showToastr("error", globalLang["preview_invoice_error"]);
            return false;
        }
        $.ajax({
            url:SITE_URL+"/invoices/preview",
            data: data,
            type: "POST",
            success: function(x, y, z){
                $('#preview_page').parents(".card").slideDown(function(){
                    $('#preview_page').html(x);

                    $('html, body').animate({
                        scrollTop: ($("#preview_page").offset().top) -250
                    }, 'slow');
                });
            }

        });
        return false;
    });

    $('#inv_status').change(function(){
        if( $(this).val() == 'partial' ){
            $('#paid_amount').parents('.form-group').show();
        }else{
            $('#paid_amount').parents('.form-group').hide();
        }
    }).trigger("change");

    function getRate(){
        var amount = 1;
        var from = $("#currency").val(); // selected currency
        var to = '<?php echo CURRENCY_PREFIX ?>'; // default currency

        $('#get_rate').button('loading');
        exchange_amount(amount, from, to, function(result){
            if( result.status == "error" ){
                showToastr("error", result.content);
            }else{
                $('#rate').val(Format_float(result.content, 4));
            }
            $('#get_rate').button('reset');
        });
    }
    $('#get_rate').on("click", function(){
        getRate();
        return false;
    });

    $('#double_currency').on("change", function(){
        $('#rate').prop('disabled', !this.checked);
    }).trigger('change');


    /* CURRENCIES */
    $('#currency').select2();
    $('#currency').on("change", function(){
        setCurrency();
    });
    function setCurrency(){
        if( $('#currency').size() > 0 ){
            symbol_native = $("#currency").find('option:selected').attr("symbol_native");
            $('.symbol_native').text(symbol_native);
            if( symbol_native != '<?php echo CURRENCY_SYMBOL ?>' ){
                $('#double_currency_div').show();
            }else{
                $('#double_currency_div').hide();
                $('#double_currency').removeAttr('checked');
            }
        }
    }
    setCurrency();

    $('#inv_title').get(0).focus();
});

var shortcuts_list = [
    {"selector":"#add_row","keyChar":"SHIFT+A","click":"#add_row","description":globalLang["add_row"], "group": globalLang["edit_invoice"]}
];
</script>

<?php if (isset($is_recurring) && $is_recurring): ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#every').on("change", function(){
            var text = globalLang["invoice_will_every"]+" ";
            var frequency = $('#frequency').val();
            var occurences = $('#occurences').val();
            var date = moment($('#inv_date').datepicker("getDate").toISOString(), moment.ISO_8601);
            var every_text = $('#every option:selected').text();
            text += "<label for='every' onclick=\"$('#every').select2('open');\"><b>"+every_text+"</b></label> ";
            if( frequency == "weekly" ){
                text += globalLang["on"]+" <label for='inv_date'><b>"+date.format("dddd")+"</b></label> ";
            }else if( frequency == "monthly" ){
                text += globalLang["on_the"]+" <label for='inv_date'><b>"+date.format("Do")+"</b></label> ";
            }else if( frequency == "yearly" ){
                text += globalLang["on_the"]+" <label for='inv_date'><b>"+date.format("Do, MMMM")+"</b></label> ";
            }
            if( occurences == 0 ){
                text += "<label for='occurences'>"+globalLang["forever"]+"</label>";
            }else if( occurences == 1 ){
                text += globalLang["for"]+" <label for='occurences'><b>"+globalLang["occurence_time"]+"</b></label>";
            }else{
                text += globalLang["for"]+" <label for='occurences'><b>"+occurences+" "+globalLang["occurence_times"]+"</b></label>";
            }
            $("#recurring_frequency").html(text);
            $("#recurring_end").html(globalLang["recurring_effective"] +" <label for='inv_date'><b>"+date.format(JS_DATE)+"</b></label>");
        });

        $('#frequency').on("change", function(){
            $('#every_list optgroup').removeClass("selected");
            $('#every_list optgroup[label='+$(this).val()+']').addClass("selected");
            $('#every').html($('#every_list optgroup.selected').html());
            $('#every').val($('#every option:first-child').val()).trigger("change").trigger('change.select2');
        }).trigger("change");

        $('#inv_date, #occurences').on("change", function(){
            $('#every').trigger("change");
        });

        $('#frequency, #every').select2({
            containerCss: function (element) {
                var visible = $(element).is(":visible");
                return {
                    display: visible
                };
            }
        });

        $('#every').val("<?php echo $rinvoice->number ?>").trigger("change");
    });
</script>
<?php endif ?>
