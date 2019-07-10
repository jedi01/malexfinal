<?php
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<div class='page_split'>
	<br>
	<?php if (count($revenues) > 0): ?>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("supplier"); ?></th>
				<th class="text-md-right"><?php echo lang("total"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			foreach ($revenues as $row) {
				if(is_object($row)){$row = objectToArray($row);} ?>
				<tr>
					<?php if ($row['company'] == ""): ?>
						<td class="text-md-left"><a href="<?php echo site_url("/suppliers/view/".$row['supplier_id']) ?>" sis-modal=""><?php echo $row['fullname']; ?></a></td>
					<?php else: ?>
						<td class="text-md-left"><a href="<?php echo site_url("/suppliers/view/".$row['supplier_id']) ?>" sis-modal=""><?php echo $row['company']; ?></a></td>
					<?php endif ?>
					<td class="text-md-right"><?php echo formatMoney($row["total"], $currency); ?></td>
				</tr>
			<?php
				$total += $row["total"];
			} // end foreach
			?>
			<tr>
				<td class="text-md-left" style="font-weight: bold;"><?php echo lang("total_revenue"); ?></td>
				<td class="text-md-right" style="font-weight: bold;"><?php echo formatMoney($total, $currency); ?></td>
			</tr>
		</tbody>
	</table>

	<?php else: ?>
		<p class="text-md-center"><?php echo lang("report_no_data"); ?></p>
	<?php endif ?>
</div>
