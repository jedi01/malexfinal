<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<div class='page_split'>
	<div class="row text-md-center">
		<div class="col-xs-4">
			<h3 class="inv col"><b><?php echo lang("invoice_no"); ?>: </b><?php echo $invoice->no; ?></h3>
		</div>
		<div class="col-xs-4">
			<h3 class="inv col"><b><?php echo lang("reference"); ?>: </b><?php echo $invoice->reference; ?></h3>
		</div>
		<div class="col-xs-4">
			<h3 class="inv col"><b><?php echo lang("date"); ?>: </b><?php echo date(PHP_DATE, strtotime($invoice->date)); ?></h3>
		</div>
	</div>
	<br>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th><?php echo lang("n°"); ?></th>
				<th><?php echo lang("date"); ?></th>
				<th><?php echo lang("amount"); ?></th>
				<th><?php echo lang("method"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$r = 1;
				foreach ($payments as $row) {
			?>
			<tr>
				<td class="text-md-center"><?php echo $r; ?></td>
				<td class="text-md-center"><?php echo date(PHP_DATE, strtotime($row["date"])); ?></td>
				<td class="text-md-center"><?php echo formatMoney($row["amount"], $invoice_currency); ?></td>
				<td class="text-md-center"><?php echo lang($row["method"]); ?></td>
			</tr>
			<?php
				$r++;
			}
			$col = 3;
			?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("payments_total"); ?>
				</td>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($invoice->total - $invoice->total_due, $invoice_currency); ?>
				</td>
			</tr>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("invoice_total"); ?>
				</td>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($invoice->total, $invoice_currency); ?>
				</td>
			</tr>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total_due"); ?>
				</td>
				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($invoice->total_due, $invoice_currency); ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
