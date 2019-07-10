
<script type="text/javascript">
    $("#account_number").select2({
      width: 'resolve',
     dropdownAutoWidth: true,
     placeholder:"Select Account",
   });

</script>
<?php


$description = array(
  'name'         => 'description',
  'id'           => 'description',
  'value'        => set_value("description",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
 
);

$dtp_amount = array(
  'name'         => 'dtp_amount',
  'id'           => 'dtp_amount',
  'value'        => set_value("dtp_amount", ""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "number",
 
);

$crd_amount = array(
  'name'         => 'crd_amount',
  'id'           => 'crd_amount',
  'value'        => set_value("crd_amount", ""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "number",
 
);

?>
<style type="text/css">
.input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
}
</style>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />

<?php echo form_open("settings/create_balance", array('class' => 'form-horizontal', 'id'=> 'form_item'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="account_number"><?php echo lang('account_number');?></label>
      <div class="col-md-9">
       <select class="form-control" name="account_number" id="account_number">
        <option></option>
        <?php 
         foreach ($accounts as $key => $value) {  ?>
      <option <?=$value['account_number']?>><?=$value['account_number']?></option>
   <?php } ?>
         
       </select>
      </div>
    </div>

    <div class="row form-group desc">
      <label class="col-md-3 form-control-label" for="description"><?php echo lang('description');?></label>
      <div class="col-md-9">
        <?php echo form_input($description);?>
      </div>
    </div>

     <div class="row form-group">
      <label class="col-md-3 form-control-label" for="dtp_amount"><?php echo lang('debit_amount');?></label>
      <div class="col-md-9">
        <?php echo form_input($dtp_amount);?>
      </div>
    </div>

     <div class="row form-group">
      <label class="col-md-3 form-control-label" for="crd_amount"><?php echo lang('credit_amount');?></label>
      <div class="col-md-9">
        <?php echo form_input($crd_amount);?>
      </div>
    </div>

    <?php echo form_hidden($csrf); ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('save'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>



<script type="text/javascript">
  $(document).ready(function(){
$("#account_number").on("change",function () {
  if($("#account_number").val() == ""){
    return false;
  }else{
    var account = $("#account_number").val();
    var csrf_sis = $("[name='csrf_sis']").val();
    $.ajax({
      method:'POST',
      url:"<?php echo base_url('accounts/getAccount');?>",
      data:{account:account,csrf_sis:csrf_sis},
      dataType:'json',

      success:function(res)
      {

        $("#description").val(res.description);

      }
    }); 
  }
  
})

});






</script>
