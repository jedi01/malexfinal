<div class='page_split'>
	<h4 class="text-md-left">
		<small class="pull-right flip" style="float: right;"><?php echo RECEIPT_PREFIX.sprintf("%06s", $receipt->number); ?></small>
		<?php echo lang("receipt") ?>
	</h4>
	<hr>

	<div class="row inv">
		<div class="col-xs-4">
			<h4 class="inv"><?php echo lang("basic_informations") ?></h4>
			<b><?php echo lang("date"); ?>:</b> <?php echo date(PHP_DATE, strtotime($receipt->date)); ?><br>
			<b><?php echo lang("payment_method"); ?>:</b> <?php echo lang($receipt->method); ?>
		</div>
		<h4 class="inv"><?php echo lang("receipt_for") ?></h4>
		<?php
		$biller_view["biller"] = $biller;
		$biller_view["show_title"] = false;
		$biller_view["show_row"] = false;
		$biller_view["cols"] = "col-xs-4 col-4";
		echo $this->load->view('billers/biller_view', $biller_view, true);
		?>
		<div style="clear: both;"></div>
	</div>
	<br>
	<table class="table_invoice" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("details"); ?></th>
	            <?php if ($invoice->double_currency): ?>
					<th style="width: 150px !important;"><?php echo lang("cash_in")." (".$currency->value.")" ?></th>
					<th style="width: 150px !important;"><?php echo lang("cash_in")." (".CURRENCY_PREFIX.")" ?></th>
				<?php else: ?>
					<th style="width: 150px !important;"><?php echo lang("cash_in"); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-md-left"><?php echo lang("invoice")." ".$invoice->reference; ?></td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right"><?php echo formatMoney($receipt->cash_in, $invoice_currency); ?></td>
					<td class="text-md-right"><?php echo formatMoney($receipt->cash_in*$invoice->rate, CURRENCY_SYMBOL); ?></td>
				<?php else: ?>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($receipt->cash_in, $invoice_currency); ?>
				</td>
				<?php endif; ?>
			</tr>
			<tr>
				<td colspan="1" class="text-md-right font-weight-bold">
					<?php echo lang("total_paid"); ?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold"><?php echo formatMoney($receipt->cash_in, $invoice_currency); ?></td>
					<td class="text-md-right font-weight-bold"><?php echo formatMoney($receipt->cash_in*$invoice->rate, CURRENCY_SYMBOL); ?></td>
				<?php else: ?>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($receipt->cash_in, $invoice_currency); ?>
				</td>
				<?php endif; ?>
			</tr>
		</tbody>
	</table>
	<?php if ( !empty($receipt->details) ): ?>
	<div class="col-xs-12 inv">
		<p><?php echo $receipt->details ?></p>
	</div>
	<?php endif ?>
</div>
