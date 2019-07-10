<?php
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<div class='page_split'>
	<br>
	<h4><?php echo lang("summary") ?></h4>
	<table class="table">
		<tbody>
			<tr>
				<th><?php echo lang("total_invoiced") ?></th>
				<td class="text-md-right"><?php echo formatMoney($total_invoiced, $currency); ?></td>
			</tr>
			<tr>
				<th><?php echo lang("total_paid") ?></th>
				<td class="text-md-right"><?php echo formatMoney($total_invoiced-$total_due, $currency); ?></td>
			</tr>
			<tr>
				<th><?php echo lang("total_due") ?></th>
				<td class="text-md-right"><?php echo formatMoney($total_due, $currency); ?></td>
			</tr>
		</tbody>
	</table>
	<?php if (count($invoices) > 0): ?>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("n°"); ?></th>
				<th class="text-md-left"><?php echo lang("date"); ?></th>
				<th class="text-md-left"><?php echo lang("invoice"); ?></th>
				<th class="text-md-left"><?php echo lang("customer"); ?></th>
				<th class="text-md-left"><?php echo lang("status"); ?></th>
				<th class="text-md-right"><?php echo lang("paid_amount"); ?></th>
				<th class="text-md-right"><?php echo lang("amount_due"); ?></th>
				<th class="text-md-left"><?php echo lang("payment_date"); ?></th>
				<th class="text-md-right"><?php echo lang("amount"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0; $k = 1; $sp = strlen(count($invoices)."");
			foreach ($invoices as $row) {
				if(is_object($row)){$row = objectToArray($row);} ?>
				<tr>
					<td class="text-md-left"><small><?php echo str_pad($k, $sp, "0", STR_PAD_LEFT) ?></small></td>
					<td class="text-md-left"><small><?php echo date_MYSQL_PHP($row["date"]) ?></small></td>
					<td class="text-md-left"><small><a href="<?php echo site_url("/invoices/open/".$row['invoice_id']) ?>"><?php echo $row["reference"] ?></a></small></td>
					<?php if ($row['company'] == ""): ?>
						<td class="text-md-left"><a href="<?php echo site_url("/billers/profile/".$row['biller_id']) ?>"><?php echo $row['fullname']; ?></a></td>
					<?php else: ?>
						<td class="text-md-left"><a href="<?php echo site_url("/billers/profile/".$row['biller_id']) ?>"><?php echo $row['company']; ?></a></td>
					<?php endif ?>
					<td class="text-md-left"><small><a href="<?php echo site_url("/invoices?f=status&fv=".$row['status']) ?>"><?php echo lang($row["status"]) ?></a></small></td>
					<td class="text-md-right"><small><?php echo formatMoney($row["total"]-$row["total_due"], $currency); ?></small></td>
					<td class="text-md-right"><small><?php echo formatMoney($row["total_due"], $currency); ?></small></td>
					<td class="text-md-center"><small><?php echo $row["payment_date"]==NULL?" - ":date_MYSQL_PHP($row["payment_date"]) ?></small></td>
					<td class="text-md-right"><small><?php echo formatMoney($row["total"], $currency); ?></small></td>
				</tr>
			<?php
				$k++;
				$total += $row["total"];
			} // end foreach
			?>
			<tr>
				<td class="text-md-right" colspan="5" style="font-weight: bold;"><?php echo lang("total"); ?></td>
				<td class="text-md-right" style="font-weight: bold;"><?php echo formatMoney($total_invoiced-$total_due, $currency); ?></td>
				<td class="text-md-right" style="font-weight: bold;"><?php echo formatMoney($total_due, $currency); ?></td>
				<td class="text-md-right" colspan="2" style="font-weight: bold;"><?php echo formatMoney($total, $currency); ?></td>
			</tr>
		</tbody>
	</table>

	<?php else: ?>
		<p class="text-md-center"><?php echo lang("report_no_data"); ?></p>
	<?php endif ?>
</div>
