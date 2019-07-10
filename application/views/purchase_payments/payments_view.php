<div class='page_split'>
	<h4 class="text-md-left">
		<small class="pull-right flip" style="float: right;"><?php echo RECEIPT_PREFIX.sprintf("%06s", $payment->number); ?></small>
		<?php echo lang("receipt") ?>
	</h4>
	<hr>

	<div class="row inv">
		<div class="col-xs-4">
			<h4 class="inv"><?php echo lang("basic_informations") ?></h4>
			<b><?php echo lang("date"); ?>:</b> <?php echo date(PHP_DATE, strtotime($payment->date)); ?><br>
			<b><?php echo lang("payment_method"); ?>:</b> <?php echo lang($payment->method); ?>
		</div>
		<div class="col-xs-8">
			<h4 class="inv"><?php echo lang("payment_for") ?></h4>
			<?php
			$biller_view["biller"] = $invoice_biller;
			$biller_view["show_title"] = false;
			echo $this->load->view('billers/biller_view', $biller_view, true);
			?>
		</div>
		<div style="clear: both;"></div>
	</div>
	<br>
	<table class="table_invoice" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("details"); ?></th>
				<th style="width: 150px !important;"><?php echo lang("amount"); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-md-left"><?php echo lang("invoice")." ".$invoice->reference; ?></td>
				<td class="text-md-right"><?php echo formatMoney($payment->amount, $invoice_currency); ?></td>
			</tr>
			<tr>
				<td colspan="1" class="text-md-right font-weight-bold">
					<?php echo lang("total_paid"); ?>
				</td>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($payment->amount, $invoice_currency); ?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php if ( !empty($payment->details) ): ?>
	<div class="col-xs-12 inv">
		<p><?php echo $payment->details ?></p>
	</div>
	<?php endif ?>
</div>
