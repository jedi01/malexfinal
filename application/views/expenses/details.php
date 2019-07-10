<style type="text/css">
  #custmer_details .form-control-label,
  #custmer_details .form-control-static{
    padding-top: 0px;
    padding-bottom: 0px;
  }
  #custmer_details .form-group{
    margin-bottom: 0px;
  }
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title">
  <?php echo EXPENSE_PREFIX.sprintf("%06s", $expense->number); ?>
  <?php
  $status = $expense->status;
  if( $status == "unpaid" ){
      $status_label = "warning";
      if( strtotime($expense->date_due) < strtotime(date("Y-m-d")) ){
        $status = "overdue";
      }
  }elseif( $status == "paid" ){
      $status_label = "success";
  }elseif( $status == "partial" ){
      $status_label = "info";
  }
  if( $status == "overdue" ){
      $status_label = "danger";
  }
  echo "<span class='label label-tall label-$status_label'><small>".lang($status)."</small></span>";
  ?>
</h5>
<hr />
<div class="row" id="custmer_details">
  <div class="col-md-4">
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('date');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo date(PHP_DATE, strtotime($expense->date)); ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('date_due');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo date(PHP_DATE, strtotime($expense->date_due)); ?></p>
      </div>
    </div>
  </div>
  <?php if (!empty($expense->reference)): ?>
  <div class="col-md-4">
    <div class="row form-group">
      <label class="col-md-5 form-control-label"><?php echo lang('reference');?></label>
      <div class="col-md-7">
        <p class="form-control-static"><?php echo $expense->reference ?></p>
      </div>
    </div>
  </div>
  <?php endif ?>

  <div class="col-md-12">
    <?php if (isset($supplier)): ?>
    <hr>
    <?php echo $this->load->view('suppliers/view', array("supplier"=>$supplier), true); ?>
    <?php endif ?>
  </div>
  <div class="col-md-12 m-t-3">
    <table class="table table-striped table-condensed table-sm">
      <thead>
        <tr>
          <th width="30"><?php echo lang("n°"); ?></th>
          <th><?php echo lang("category"); ?></th>
          <th class="text-md-right" width="150"><?php echo lang("amount"); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-md-left"><small>01</small></td>
          <td class="text-md-left"><small><?php echo $expense->category ?></small></td>
          <td class="text-md-right"><small><?php echo formatMoney($expense->amount, $currency); ?></small></td>
        </tr>
        <?php if ($expense->tax_total != 0): ?>
        <tr>
          <td colspan="2" class="text-md-right font-weight-bold"><?php echo lang("subtotal"); ?></td>
          <td class="text-md-right font-weight-bold">
            <?php echo formatMoney($expense->amount, $currency); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-md-right font-weight-bold">
            <?php
              $tax = $this->settings_model->get_tax_rate($expense->tax_id);
              echo $tax->label;
              if( $tax->type == 0 ){
                echo " (".formatFloat($tax->value)."%)";
              }
            ?>
          </td>
          <td class="text-md-right font-weight-bold">
            <?php echo formatMoney($expense->tax_total, $currency); ?>
          </td>
        </tr>
        <?php endif ?>
        <tr>
          <td colspan="2" class="text-md-right font-weight-bold"><?php echo lang("total"); ?></td>
          <td class="text-md-right font-weight-bold">
            <?php echo formatMoney($expense->total, $currency); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-md-right font-weight-bold"><?php echo lang("paid_amount"); ?></td>
          <td class="text-md-right font-weight-bold">
            <?php echo formatMoney($expense->total-$expense->total_due, $currency); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-md-right font-weight-bold"><?php echo lang("total_due"); ?></td>
          <td class="text-md-right font-weight-bold">
            <?php echo formatMoney($expense->total_due, $currency); ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-12">
    <?php if (!empty($expense->details)): ?>
      <label class="form-control-label"><?php echo lang("details") ?></label>
      <p>
        <?php echo html_entity_decode($expense->details) ?>
      </p>
    <?php endif ?>
  </div>
  <div class="col-md-12">
    <?php
    if (!empty($expense->attachments)){
      $attachments = json_decode($expense->attachments);
      echo "<label class='form-control-label'>".lang("attachments")."</label>";
      echo '<div class="attachments"><ul>';
      foreach ($attached_files as $file) {
        echo '<li>'.
          '<span class="label label-default label-bill">'.substr($file->extension, 1).'</span> '.
          '<b> '.$file->filename.$file->extension.' </b>'.
          '<span class="quickMenu"><a href="'.site_url('/files/download/'.$file->link).'"><i class="fa fa-download"></i></a></span>'.
        '</li>';
      }
      echo '</ul></div>';
    }
    ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
