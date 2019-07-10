<style type="text/css">
  #item_details .form-control-label,
  #item_details .form-control-static{
    padding-top: 0px;
    padding-bottom: 0px;
  }
  #item_details .form-group{
    margin-bottom: 0px;
  }
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<div class="row" id="item_details">
  <div class="col-md-12">
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('name');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $item->name ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('description');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $item->description ?></p>
      </div>
    </div>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('unit');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $item->unit ?></p>
      </div>
    </div>
    <?php if (isset($category->name)): ?>
    <div class="row form-group ">
      <label class="col-md-3 form-control-label"><?php echo lang('category');?></label>
      <div class="col-md-9">
        <p class="form-control-static"><?php echo $category->name ?></p>
      </div>
    </div>
    <?php endif ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('price') ?></label>
      <?php
      foreach ($item_prices as $key => $item_price) {
        if( $key != 0 ){
          echo '<div class="col-md-3"></div>';
        }
        echo '<div class="col-md-9"><p class="form-control-static">'.formatMoney($item_price['price'], $item_price['currency']) .'</p></div>';
      }
      ?>
    </div>
    <?php if (ITEM_TAX==2): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('tax');?></label>
      <div class="col-md-9">
        <p class="form-control-static">
          <?php
          if( $item->tax_type == 0 ){
            echo $item->tax." %";
          }else{
            echo formatMoney($item->tax, CURRENCY_SYMBOL);
          }
          ?>
        </p>
      </div>
    </div>
    <?php endif ?>
    <?php if (ITEM_DISCOUNT==2): ?>
    <div class="row form-group">
      <label class="col-md-3 form-control-label"><?php echo lang('discount');?></label>
      <div class="col-md-9">
        <p class="form-control-static">
          <?php
          if( $item->discount_type == 0 ){
            echo $item->discount." %";
          }else{
            echo formatMoney($item->discount, CURRENCY_SYMBOL);
          }
          ?>
        </p>
      </div>
    </div>
    <?php endif ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <?php echo form_open('', ''); ?>
  <button type="button" class="btn btn-primary" tabindex="1" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>
