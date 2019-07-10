<?php
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
?>
<div class='page_split'>
	<br>
	<?php if (count($taxes) > 0): ?>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("tax_name"); ?></th>
				<th class="text-md-right"><?php echo lang("taxable_amount"); ?></th>
				<th class="text-md-right"><?php echo lang("taxes"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			foreach ($taxes as $row) {
				if(is_object($row)){$row = objectToArray($row);} ?>
				<tr>
					<td class="text-md-left">
						<?php
							echo $row["label"];
							if( $row["type"] == 0 ){
								echo " <small>(".formatFloat($row["value"])."%)</small>";
							}
						?>
					</td>
					<td class="text-md-right"><?php echo formatMoney($row["subtotal"], $currency); ?></td>
					<td class="text-md-right">
						<?php
							if( $row["type"] == 0 ){
								$tax = $row["subtotal"]*$row["value"]/100;
							}else{
								$tax = $row["sum_value"];
							}
							echo formatMoney($tax, $currency);
						?>
					</td>
				</tr>
			<?php
				$total += $tax;
			} // end foreach
			?>
			<tr>
				<td class="text-md-left" colspan="2" style="font-weight: bold;"><?php echo lang("total"); ?></td>
				<td class="text-md-right" style="font-weight: bold;"><?php echo formatMoney($total, $currency); ?></td>
			</tr>
		</tbody>
	</table>

	<?php else: ?>
		<p class="text-md-center"><?php echo lang("report_no_data"); ?></p>
	<?php endif ?>
</div>
