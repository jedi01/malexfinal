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
		$supplier_view["supplier"] = $supplier;
		$supplier_view["show_title"] = false;
		$supplier_view["show_row"] = false;
		$supplier_view["cols"] = "col-xs-4 col-4";
		echo $this->load->view('suppliers/view', $supplier_view, true);
		?>
		<div style="clear: both;"></div>
	</div>
	<br>
	<table class="table_purchase" style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th class="text-md-left"><?php echo lang("details"); ?></th>
	           
					<th style="width: 150px !important;"><?php echo lang("amount"); ?></th>
		
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-md-left"><?php echo lang("purchase")." ".$purchase->reference; ?></td>

				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($receipt->amount, $purchase_currency); ?>
				</td>
				
			</tr>
			<tr>
				<td colspan="1" class="text-md-right font-weight-bold">
					<?php echo lang("total_paid"); ?>
				</td>

				<td class="text-md-right font-weight-bold">
					<?php echo formatMoney($receipt->amount, $purchase_currency); ?>
				</td>
		
			</tr>
		</tbody>
	</table>
	<?php if ( !empty($receipt->details) ): ?>
	<div class="col-xs-12 inv">
		<p><?php echo $receipt->details ?></p>
	</div>
	<?php endif ?>
</div>
