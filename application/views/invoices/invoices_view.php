<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
$headCol = ( isset($invoice->date_due) && $invoice->date_due != "" )?3:4;
$currency = $this->settings_model->getFormattedCurrencies($invoice->currency);
if (ITEM_TAX==2) {
	$item_taxes = array();
	$total_discounts = 0;
}
?>
<?php if ($system_settings->show_status): ?>
	<div class="invoice_status"><?php echo lang($invoice->status) ?></div>
<?php endif ?>
<div class='page_split'>
	<?php if (!empty($invoice->description)): ?>
		<center><i><small><?php echo $invoice->description ?></small></i></center>
	<?php endif ?>
	<div class="row row-equal text-md-center">
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("invoice_no"); ?>: </b><?php echo $invoice->no; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("reference"); ?>: </b><?php echo $invoice->reference; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("date"); ?>: </b><?php echo date(PHP_DATE, strtotime($invoice->date)); ?></h3>
		</div>
		<?php if ( isset($invoice->date_due) && $invoice->date_due != "" ): ?>
		<div class="col-xs-3">
			<h3 class="inv col"><b><?php echo lang("date_due"); ?>: </b><?php echo date(PHP_DATE, strtotime($invoice->date_due)); ?></h3>
		</div>
		<?php endif ?>
	</div>
	<hr>
	<?php
    $cf = $this->settings_model->SYS_Settings;
    $custom_fields = "";
	    if( isset($invoice->custom_field1) && $invoice->custom_field1 && trim($cf->invoice_cf1) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf1.": </b>".$invoice->custom_field1.'</h3></div>';
	   	}
	    if( isset($invoice->custom_field2) && $invoice->custom_field2 && trim($cf->invoice_cf2) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf2.": </b>".$invoice->custom_field2.'</h3></div>';
	   	}
	    if( isset($invoice->custom_field3) && $invoice->custom_field3 && trim($cf->invoice_cf3) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf3.": </b>".$invoice->custom_field3.'</h3></div>';
	   	}
	    if( isset($invoice->custom_field4) && $invoice->custom_field4 && trim($cf->invoice_cf4) != "" ){
	   		$custom_fields .= '<div class="col-xs-3"><h3 class="inv col m-a-0 no-margin"><b>'.$cf->invoice_cf4.": </b>".$invoice->custom_field4.'</h3></div>';
	   	}
	   	if( $custom_fields != "" ){
	    	echo '<div class="row text-md-center">'.$custom_fields."</div><hr>";
	   	}
	?>
	<?php echo $this->load->view('billers/biller_view', array("biller"=>$invoice_biller), true); ?>
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
                <?php if ($invoice->double_currency): ?>
				<th><?php echo lang("total")." (".$currency->value.")" ?></th>
				<th><?php echo lang("total")." (".CURRENCY_PREFIX.")" ?></th>
                <?php else: ?>
				<th><?php echo lang("total"); ?></th>
                <?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php
				$r = 1;
				foreach ($invoice_items as $row) {
					if(is_object($row)){$row = objectToArray($row);}
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
				<td class="text-md-center"><?php echo formatMoney($row["unit_price"], $invoice_currency); ?></td>
                <?php if (ITEM_TAX==2): ?>
				<td class="text-md-center">
					<?php
					if( $row["tax"] == 0 ){
						echo '-';
					}else{
						if( $row["tax_type"] == 0 ){
							echo "(".formatFloat($row["tax"])."%) ".formatMoney(($row["quantity"]*$row["unit_price"])*$row["tax"]/100, $invoice_currency);
							if( isset($item_taxes[$row["tax"]." %"])){
								$item_taxes[$row["tax"]." %"] += ($row["quantity"]*$row["unit_price"])*$row["tax"]/100;
							}else{
								$item_taxes[$row["tax"]." %"] = ($row["quantity"]*$row["unit_price"])*$row["tax"]/100;
							}
						}else{
							echo formatMoney($row["tax"], $invoice_currency);
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
							echo "(".formatFloat($row["discount"])."%) ".formatMoney(($row["quantity"]*$row["unit_price"])*$row["discount"]/100, $invoice_currency);
							$total_discounts += ($row["quantity"]*$row["unit_price"])*$row["discount"]/100;
						}else{
							echo formatMoney($row["discount"], $invoice_currency);
							$total_discounts += $row["discount"];
						}
					}
					?>
				</td>
                <?php endif ?>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-center"><?php echo formatMoney($row["total"], $invoice_currency); ?></td>
					<td class="text-md-center"><?php echo formatMoney($row["total"]*$invoice->rate, CURRENCY_SYMBOL); ?></td>
				<?php else: ?>
					<td class="text-md-center"><?php echo formatMoney($row["total"], $invoice_currency); ?></td>
	            <?php endif ?>
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
					$gg_sub = $invoice->subtotal;
					if (ITEM_TAX==2 && count($item_taxes) > 0) {
						$taxes = 0;
						foreach ($item_taxes as $key => $value) {
							$taxes += $value;
						}
						echo formatMoney($invoice->total-($taxes-$total_discounts), $invoice_currency);
						$gg_sub = $invoice->total-($taxes-$total_discounts);
					}else{
						echo formatMoney($invoice->subtotal, $invoice_currency);
					}
					?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($gg_sub*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php if (ITEM_DISCOUNT==1 && $invoice->global_discount>0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php
					echo lang("global_discount");
					if( $invoice->discount_type == 0 ){
						echo " (".formatFloat($invoice->global_discount)."%)";
					}
					?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
					$gg_dis = $invoice->global_discount;
					if( $invoice->discount_type == 0 ){
						echo "- ".formatMoney($invoice->subtotal*$invoice->global_discount/100, $invoice_currency);
						$gg_dis = $invoice->subtotal*$invoice->global_discount/100;
					}else{
						echo "- ".formatMoney($invoice->global_discount, $invoice_currency);
					}
					?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($gg_dis*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php elseif ( ITEM_DISCOUNT==2 && $total_discounts > 0 ): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("global_discount"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php
						echo "- ".formatMoney($total_discounts, $invoice_currency);
					?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($total_discounts*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php endif ?>
			<?php if ( ITEM_TAX==1 && count($invoice_taxes) > 0 ): ?>
				<?php foreach ($invoice_taxes as $key => $tax): ?>
					<?php if(is_object($tax)){$tax = objectToArray($tax);} ?>
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
						echo formatMoney($invoice->subtotal*$tax["value"]/100, $invoice_currency);
					}else{
						echo formatMoney($tax["value"], $invoice_currency);
					}
					?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($tax["value"]*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
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
					<?php echo formatMoney($tax, $invoice_currency); ?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($invoice->tax*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
				<?php endforeach ?>
			<?php endif ?>
			<?php if (SHIPPING && $invoice->shipping>0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("shipping"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($invoice->shipping, $invoice_currency); ?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($invoice->shipping*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php endif ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($invoice->total, $invoice_currency); ?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($invoice->total*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php if ($system_settings->show_total_due && $invoice->total_due > 0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total_due"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($invoice->total_due, $invoice_currency); ?>
				</td>
	            <?php if ($invoice->double_currency): ?>
					<td class="text-md-right font-weight-bold text-nowrap"><?php echo formatMoney($invoice->total_due*$invoice->rate, CURRENCY_SYMBOL); ?></td>
	            <?php endif ?>
			</tr>
			<?php endif ?>
		</tbody>
	</table>

<!-- AMOUNT IN WORDS -->
<?php if ($system_settings->amount_in_words): ?>
<p>
	<b><?php echo lang("amount_in_words") ?>: </b>
	<span style="text-transform: uppercase;">
		<?php echo convert_number_to_words(floatval($invoice->total)); ?>
		<b>
			<?php if (LANGUAGE == 'english' || LANGUAGE == 'french' || LANGUAGE == 'arabic'): ?>
				<?php echo removeThe($this->settings_model->getFormattedCurrencies($invoice->currency)->name); ?>
			<?php else: ?>
				<?php echo $this->settings_model->getFormattedCurrencies($invoice->currency)->value; ?>
			<?php endif ?>
		</b>
	</span>
</p>
<?php endif ?>

<?php
if( !$system_settings->note_terms_on_page ){
	$class = "col-xs-12 inv";
	if ( !empty($invoice->note) && !empty($invoice->terms) ){
		$class = "col-xs-6 inv";
	}
	if ( !empty($invoice->note) ){
		echo "<div class='".$class."'><strong>".lang("note")."</strong><p>".$invoice->note."</p></div>";
	}
	if ( !empty($invoice->terms) ){
		echo "<div class='".$class."'><strong>".lang("condition_terms")."</strong><p>".$invoice->terms."</p></div>";
	}
}
?>
</div>
