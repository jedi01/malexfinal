<?php
$system_settings = $this->settings_model->getSettings("SYSTEM");
$invoice_settings = $this->settings_model->getSettings("INVOICE");
$isStriped = $invoice_settings->table_strip=="1"?"table_invoice-striped":"";
$isBordered = $invoice_settings->table_border=="1"?"table_invoice-bordered":"";
$headCol = ( isset($purchase->date_due) && $purchase->date_due != "" )?3:4;
$currency = $this->settings_model->getFormattedCurrencies($purchase->currency);
if (ITEM_TAX==2) {
	$item_taxes = array();
	$total_discounts = 0;
}
?>
<?php if ($system_settings->show_status): ?>
	<div class="invoice_status"><?php echo lang($purchase->status) ?></div>
<?php endif ?>
<div class='page_split'>
	<?php if (!empty($purchase->description)): ?>
		<center><i><small><?php echo $purchase->description ?></small></i></center>
	<?php endif ?>
	<div class="row row-equal text-md-center">
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("purchase_no"); ?>: </b><?php echo $purchase->no; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("reference"); ?>: </b><?php echo $purchase->reference; ?></h3>
		</div>
		<div class="col-xs-<?php echo $headCol ?>">
			<h3 class="inv col"><b><?php echo lang("date"); ?>: </b><?php echo date(PHP_DATE, strtotime($purchase->date)); ?></h3>
		</div>
		<?php if ( isset($purchase->date_due) && $purchase->date_due != "" ): ?>
		<div class="col-xs-3">
			<h3 class="inv col"><b><?php echo lang("date_due"); ?>: </b><?php echo date(PHP_DATE, strtotime($purchase->date_due)); ?></h3>
		</div>
		<?php endif ?>
	</div>
	<hr>
	<?php echo $this->load->view('suppliers/view', array("supplier"=>$purchase_supplier), true); ?> 
	<br>
	<table class="table_invoice <?php echo $isBordered." ".$isStriped ?>" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th><?php echo lang("n°"); ?></th>
				<th><?php echo lang("description"); ?> (<?php echo lang("code"); ?>)</th>
				<th><?php echo lang("quantity"); ?></th>
				<th><?php echo lang("unit_price"); ?></th>
				<th><?php echo lang("total"); ?></th>
             
			</tr>
		</thead>
		<tbody>
			<?php
				$r = 1;
				foreach ($purchase_items as $row) {
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
				<td class="text-md-center"><?php echo formatMoney($row["unit_price"], $purchase_currency); ?></td>
				<td class="text-md-center"><?php echo formatMoney($row["total"], $purchase_currency); ?></td>
	          
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
					$gg_sub = $purchase->total_due;
					if (ITEM_TAX==2 && count($item_taxes) > 0) {
						$taxes = 0;
						foreach ($item_taxes as $key => $value) {
							$taxes += $value;
						}
						echo formatMoney($purchase->total-($taxes-$total_discounts), $purchase_currency);
						$gg_sub = $purchase->total-($taxes-$total_discounts);
					}else{
						echo formatMoney($purchase->total_due, $purchase_currency);
					}
					?>
				</td>
	           
			</tr>
			
			
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($purchase->total_due, $purchase_currency); ?>
				</td>
	        
			</tr>
			<?php if ($system_settings->show_total_due && $purchase->total_due > 0): ?>
			<tr>
				<td colspan="<?php echo $col; ?>" class="text-md-right font-weight-bold">
					<?php echo lang("total_due"); ?>
				</td>
				<td class="text-md-right font-weight-bold text-nowrap">
					<?php echo formatMoney($purchase->total_due, $purchase_currency); ?>
				</td>
	            
			</tr>
			<?php endif ?>
		</tbody>
	</table>

<!-- AMOUNT IN WORDS -->
<?php if ($system_settings->amount_in_words): ?>
<p>
	<b><?php echo lang("amount_in_words") ?>: </b>
	<span style="text-transform: uppercase;">
		<?php echo convert_number_to_words(floatval($purchase->total_due)); ?>
		<b>
			<?php if (LANGUAGE == 'english' || LANGUAGE == 'french' || LANGUAGE == 'arabic'): ?>
				<?php echo removeThe($this->settings_model->getFormattedCurrencies($purchase->currency)->name); ?>
			<?php else: ?>
				<?php echo $this->settings_model->getFormattedCurrencies($purchase->currency)->value; ?>
			<?php endif ?>
		</b>
	</span>
</p>
<?php endif ?>

<?php
if( !$system_settings->note_terms_on_page ){
	$class = "col-xs-12 inv";
	if ( !empty($purchase->note) ){
		$class = "col-xs-6 inv";
	}
	if ( !empty($purchase->note) ){
		echo "<div class='".$class."'><strong>".lang("note")."</strong><p>".$purchase->note."</p></div>";
	}
	
}
?>
</div>
