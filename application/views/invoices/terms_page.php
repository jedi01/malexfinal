<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<?php
	if ( !empty($invoice->note) ){
		echo "<div class='col-xs-12 inv'><strong>".lang("note")."</strong><p>".$invoice->note."</p></div>";
	}
	if ( !empty($invoice->terms) ){
		echo "<div class='col-xs-12 inv'><strong>".lang("condition_terms")."</strong><p>".$invoice->terms."</p></div>";
	}
?>
