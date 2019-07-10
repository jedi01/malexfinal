<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$estimate_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $estimate_settings->table_strip=="1"?"table_estimate-striped":"";
$isBordered = $estimate_settings->table_border=="1"?"table_estimate-bordered":"";
$headCol = ( isset($estimate->date_due) && $estimate->date_due != "" )?3:4;
if (ITEM_TAX==2) {
	$item_taxes = array();
	$total_discounts = 0;
}
?>
<?php if ($system_settings->show_status): ?>
	<div class="invoice_status"><?php echo lang($estimate->status) ?></div>
<?php endif ?>
<div class='page_split'>
	<?php if (!empty($estimate->description)): ?>
		<center><i><small><?php echo $estimate->description ?></small></i></center>
	<?php endif ?>
	<div class="row row-equal text-md-center">
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("estimate_no"); ?>: </b><?php echo $estimate->no; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("reference"); ?>: </b><?php echo $estimate->reference; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("date"); ?>: </b><?php echo date(PHP_DATE, strtotime($estimate->date)); ?></h3>
		</div>
		<?php if ( isset($estimate->date_due) && $estimate->date_due != "" ): ?>
		<div class="col-xs-3">
			<h3 class="inv col"><b><?php echo lang("valid_till"); ?>: </b><?php echo date(PHP_DATE, strtotime($estimate->date_due)); ?></h3>
		</div>
		<?php endif ?>
	</div>
	<hr>
	<?php
    $cf = $this->settings_model->SYS_Settings;
    $custom_fields = "";
	    if( isset($estimate->custom_field1) && $estimate->custom_field1 && trim($cf->invoice_cf1) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf1.": </b>".$estimate->custom_field1.'</h3></div>';
	   	}
	    if( isset($estimate->custom_field2) && $estimate->custom_field2 && trim($cf->invoice_cf2) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf2.": </b>".$estimate->custom_field2.'</h3></div>';
	   	}
	    if( isset($estimate->custom_field3) && $estimate->custom_field3 && trim($cf->invoice_cf3) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf3.": </b>".$estimate->custom_field3.'</h3></div>';
	   	}
	    if( isset($estimate->custom_field4) && $estimate->custom_field4 && trim($cf->invoice_cf4) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf4.": </b>".$estimate->custom_field4.'</h3></div>';
	   	}
	   	if( $custom_fields != "" ){
	    	echo '<div class="row text-md-center">'.$custom_fields."</div><hr>";
	   	}
	?>
	<?php echo $this->load->view('billers/biller_view', array("biller"=>$estimate_biller), true); ?>
	<br>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th><?php echo lang("n°"); ?></th>
				<th><?php echo lang("description"); ?> (<?php echo lang("code"); ?>)</th>
				<th><?php echo lang("quantity"); ?></th>
				<th><?php echo lang("unit_price"); ?></th>
                <?php if (ITEM_TAX==2): ?>
					<th><?php echo lang('tax'); ?></th>
                <?php endif ?>
                <?php if (ITEM_DISCOUNT==2): ?>
					<th><?php echo lang('discount'); ?></th>
                <?php endif ?>
				<th><?php echo lang("total"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$r = 1;
				foreach ($estimate_items as $row) {
			?>
			<tr>
				<td class="text-md-center"><?php echo $r; ?></td>
				<?php if ($system_settings->description_inline): ?>
					<td class="text-md-left"><?php echo $row["name"].(!empty($row["description"])?" (".$row["description"].")":""); ?></td>
				<?php else: ?>
					<td class="text-md-left">
						<?php echo $row["name"]; ?><br>
						<?php if (!empty($row["description"])): ?>
							<small class="text-muted font-italic"><?php echo str_replace("\n", "<br>", $row["description"]); ?></small>
						<?php endif ?>
					</td>
				<?php endif ?>
				<td class="text-md-center"><?php echo formatFloat($row["quantity"]); ?></td>
				<td class="text-md-center"><?php echo formatMoney($row["unit_price"], $estimate_currency); ?></td>
                <?php if (ITEM_TAX==2): ?>
				<td class="text-md-center">
					<?php
					if( $row["tax"] == 0 ){
						echo '-';
					}else{
						if( $row["tax_type"] == 0 ){
							echo "(".formatFloat($row["tax"])."%) ".formatMoney(($row["quantity"]*$row["unit_price"])*$row["tax"]/100, $estimate_currency);
							if( isset($item_taxes[$row["tax"]." %"])){
								$item_taxes[$row["tax"]." %"] += ($row["quantity"]*$row["unit_price"])*$row["tax"]/100;
							}else{
								$item_taxes[$row["tax"]." %"] = ($row["quantity"]*$row["unit_price"])*$row["tax"]/100;
							}
						}else{
							echo formatMoney($row["tax"], $estimate_currency);
							if( isset($item_taxes["flat"])){
								$item_taxes["flat"] += $row["tax"];
							}else{
								$item_taxes["flat"] = $row["tax"];
							}
						}
					}
					?>
				</td>
                <?php endif ?>
                <?php if (ITEM_DISCOUNT==2): ?>
				<td class="text-md-center">
					<?php
					if( $row["discount"] == 0 ){
						echo '-';
					}else{
						if( $row["discount_type"] == 0 ){
							echo "(".formatFloat($row["discount"])."%) ".formatMoney(($row["quantity"]*$row["unit_price"])*$row["discount"]/100, $estimate_currency);
							$total_discounts += ($row["quantity"]*$row["unit_price"])*$row["discount"]/100;
						}else{
							echo formatMoney($row["discount"], $estimate_currency);
							$total_discounts += $row["discount"];
						}
					}
					?>
				</td>
                <?php endif ?>
				<td class="text-md-center"><?php echo formatMoney($row["total"], $estimate_currency); ?></td>
			</tr>
			<?php
				$r++;
			}
			$col = 6;
			$col = ITEM_TAX==2?$col:$col-1;
			$col = ITEM_DISCOUNT==2?$col:$col-1;
			?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("subtotal"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
					if (ITEM_TAX==2 && count($item_taxes) > 0) {
						$taxes = 0;
						foreach ($item_taxes as $key => $value) {
							$taxes += $value;
						}
						echo formatMoney($estimate->total-($taxes-$total_discounts), $estimate_currency);
					}else{
						echo formatMoney($estimate->subtotal, $estimate_currency);
					}
					?>
				</td>
			</tr>
			<?php if (ITEM_DISCOUNT==1 && $estimate->global_discount>0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php
					echo lang("global_discount");
					if( $estimate->discount_type == 0 ){
						echo " (".formatFloat($estimate->global_discount)."%)";
					}
					?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
					if( $estimate->discount_type == 0 ){
						echo "- ".formatMoney($estimate->subtotal*$estimate->global_discount/100, $estimate_currency);
					}else{
						echo "- ".formatMoney($estimate->global_discount, $estimate_currency);
					}
					?>
				</td>
			</tr>
			<?php elseif ( ITEM_DISCOUNT==2 && $total_discounts > 0 ): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("global_discount"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
						echo "- ".formatMoney($total_discounts, $estimate_currency);
					?>
				</td>
			</tr>
			<?php endif ?>
			<?php if ( ITEM_TAX==1 && count($estimate_taxes) > 0 ): ?>
				<?php foreach ($estimate_taxes as $key => $tax): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php
					echo $tax["label"];
					if( $tax["type"] == 0 ){
						echo " (".formatFloat($tax["value"])."%)";
					}
					?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
					if( $tax["type"] == 0 ){
						echo formatMoney($estimate->subtotal*$tax["value"]/100, $estimate_currency);
					}else{
						echo formatMoney($tax["value"], $estimate_currency);
					}
					?>
				</td>
			</tr>
				<?php endforeach ?>
			<?php elseif ( ITEM_TAX==2 && count($item_taxes) > 0 ): ?>
				<?php foreach ($item_taxes as $key => $tax): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php
					$tax_label = $this->settings_model->SYS_Settings->item_tax_label;
					echo (strpos($tax_label, "lang:")!==FALSE)?lang(substr($tax_label, 5)):$tax_label;
					if( $key != "flat" ){ echo " (".$key.")"; }
					?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($tax, $estimate_currency); ?>
				</td>
			</tr>
				<?php endforeach ?>
			<?php endif ?>
			<?php if (SHIPPING && $estimate->shipping>0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("shipping"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($estimate->shipping, $estimate_currency); ?>
				</td>
			</tr>
			<?php endif ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($estimate->total, $estimate_currency); ?>
				</td>
			</tr>
		</tbody>
	</table>

<!-- AMOUNT IN WORDS -->
<?php if ($system_settings->amount_in_words): ?>
<p>
	<b><?php echo lang("amount_in_words") ?>: </b>
	<span style="text-transform: uppercase;">
		<?php echo convert_number_to_words(floatval($estimate->total)); ?>
		<b>
			<?php if (LANGUAGE == 'english' || LANGUAGE == 'french' || LANGUAGE == 'arabic'): ?>
				<?php echo removeThe($this->settings_model->getFormattedCurrencies($estimate->currency)->name); ?>
			<?php else: ?>
				<?php echo $this->settings_model->getFormattedCurrencies($estimate->currency)->value; ?>
			<?php endif ?>
		</b>
	</span>
</p>
<?php endif ?>

<?php
$class = "col-xs-12 inv";
if ( !empty($estimate->note) && !empty($estimate->terms) ){
	$class = "col-xs-6 inv";
}
if ( !empty($estimate->note) ){
	echo "<div class='".$class."'><strong>".lang("note")."</strong><p>".$estimate->note."</p></div>";
}
if ( !empty($estimate->terms) ){
	echo "<div class='".$class."'><strong>".lang("condition_terms")."</strong><p>".$estimate->terms."</p></div>";
}
?>
</div>
