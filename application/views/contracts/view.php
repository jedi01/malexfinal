<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
$headCol = ( isset($contract->date_due) && $contract->date_due != "" )?3:6;
?>
<div class='page_split'>
<center><h4 class="inv" style="margin-top: 5px;"><?php echo $contract->subject ?></h4></center>
<!--
	<div class="row text-md-center">
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("date"); ?>: </b><?php echo date(PHP_DATE, strtotime($contract->date)); ?></h3>
		</div>
		<?php if ( isset($contract->date_due) && $contract->date_due != "" ): ?>
		<div class="col-xs-3">
			<h3 class="inv col"><b><?php echo lang("date_due"); ?>: </b><?php echo date(PHP_DATE, strtotime($contract->date_due)); ?></h3>
		</div>
		<?php endif ?>
		<div class="col-xs-6">
			<h3 class="inv col"><b><?php echo lang("contract_type"); ?>: </b><?php echo $contract->type; ?></h3>
		</div>
	</div>
	<hr>
	<?php echo $this->load->view('billers/biller_view', array("biller"=>$biller), true); ?>
	<br> -->
<?php
if ( !empty($contract->description) ){
	$contract->description = html_entity_decode($contract->description);
	echo $contract->description;
}
?>
</div>
