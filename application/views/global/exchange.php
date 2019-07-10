<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<div class="row form-group">
    <label class="col-md-3 form-control-label" for="exchange_amount"><?php echo lang('amount');?></label>
    <div class="col-md-7">
        <input type="number" step="any" min="0" name="amount" id="exchange_amount" class="form-control" value="1">
    </div>
</div>

<?php
$currencies = $this->settings_model->getFormattedCurrencies();
$general = $this->settings_model->SYS_Settings;
?>

<div class="row form-group">
    <label class="col-md-3 form-control-label" for="exchange_from"><?php echo lang("currency"); ?></label>
    <div class="col-md-7">
        <div class="row row-equal">
            <div class="col-md-5">
            <?php
                $index = 0; $k = 0;
                echo '<select name="from" id="exchange_from" class="form-control">';
                foreach ($currencies as $currency) {
                    $selected = "";
                    if($currency->value==$general->default_currency){
                        $selected = "selected='selected'";
                        $index = $k;
                    }
                    echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".$selected.">".$currency->value."</option>";
                    $k++;
                }
                echo "</select>";
            ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-block p-x-0" id="exchange_inverse"><i class="fa fa-exchange"></i></button>
            </div>
            <div class="col-md-5">
            <?php
                $k = 0;
                echo '<select name="to" id="exchange_to" class="form-control">';
                foreach ($currencies as $currency) {
                    $selected = "";
                    if($k==($index+1)){
                        $selected = "selected='selected'";
                    }
                    echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".$selected.">".$currency->value."</option>";
                    $k++;
                }
                echo "</select>";
            ?>
            </div>
        </div>
    </div>
</div>

<div class="row form-group">
    <label class="col-md-3 form-control-label"><?php echo lang('result');?></label>
    <div class="col-md-7">
        <span id="exchange_result" class="form-control">&nbsp;</span>
    </div>
</div>

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <button type="button" class="btn btn-primary" id="exchange_submit"><?php echo lang("change") ?></button>
</div>


<script type="text/javascript">
$('#exchange_from, #exchange_to').select2();
$('#exchange_inverse').click(function(){
    var from = $("#exchange_from").val();
    var to = $("#exchange_to").val();
    $("#exchange_from").val(to).trigger("change");
    $("#exchange_to").val(from).trigger("change");
});
$('#exchange_submit').click(function(){
    var amount = $("#exchange_amount").val();
    var from = $("#exchange_from").val();
    var to = $("#exchange_to").val();
    $('#exchange_submit').button('loading');
    exchange_amount(amount, from, to, function(result){
        if( result.status == "error" ){
            $('#exchange_result').html(result.content);
        }else{
            $('#exchange_result').html(Format_Currency(amount)+" <small>"+from+'</small> <i class="fa fa-exchange"></i> '+Format_Currency(result.content)+" <small>"+to+"</small>");
        }
        $('#exchange_submit').button('reset');
    });
});
</script>
