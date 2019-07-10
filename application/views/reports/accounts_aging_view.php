<?php
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<div class='page_split'>
	<br>
	<?php if (count($aging_accounts) > 0): ?>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th><?php echo lang("customer"); ?></th>
				<th><?php echo lang("aging_age1"); ?></th>
				<th><?php echo lang("aging_age2"); ?></th>
				<th><?php echo lang("aging_age3"); ?></th>
				<th><?php echo lang("aging_age4"); ?></th>
				<th><?php echo lang("total"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$age1 = $age2 = $age3 = $age4 = $total = 0;
			foreach ($aging_accounts as $row) {
				if(is_object($row)){$row = objectToArray($row);} ?>
				<tr>
					<?php if ($row['company'] == ""): ?>
						<td class="text-md-left"><a href="<?php echo site_url("/billers/profile/".$row['biller_id']) ?>"><?php echo $row['fullname']; ?></a></td>
					<?php else: ?>
						<td class="text-md-left"><a href="<?php echo site_url("/billers/profile/".$row['biller_id']) ?>"><?php echo $row['company']; ?></a></td>
					<?php endif ?>
					<td class="text-md-center"><?php echo formatMoney($row["age1"], $currency); ?></td>
					<td class="text-md-center"><?php echo formatMoney($row["age2"], $currency); ?></td>
					<td class="text-md-center"><?php echo formatMoney($row["age3"], $currency); ?></td>
					<td class="text-md-center"><?php echo formatMoney($row["age4"], $currency); ?></td>
					<td class="text-md-center"><?php echo formatMoney($row["total"], $currency); ?></td>
				</tr>
			<?php
				$age1 += $row["age1"];
				$age2 += $row["age2"];
				$age3 += $row["age3"];
				$age4 += $row["age4"];
				$total += $row["total"];
			} // end foreach
			?>
			<tr>
				<td style="font-weight: bold;"><?php echo lang("total"); ?></td>
				<td style="font-weight: bold;"><?php echo formatMoney($age1, $currency); ?></td>
				<td style="font-weight: bold;"><?php echo formatMoney($age2, $currency); ?></td>
				<td style="font-weight: bold;"><?php echo formatMoney($age3, $currency); ?></td>
				<td style="font-weight: bold;"><?php echo formatMoney($age4, $currency); ?></td>
				<td style="font-weight: bold;"><?php echo formatMoney($total, $currency); ?></td>
			</tr>
		</tbody>
	</table>

	<?php else: ?>
		<p class="text-md-center"><?php echo lang("no_aging_accounts"); ?></p>
	<?php endif ?>
</div>
