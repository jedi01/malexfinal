

<?php
$doc_name = array(
  'name'         => 'doc_name',
  'id'           => 'doc_name',
  'value'        => set_value("doc_name",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
);
$date = array(
  'name'         => 'date',
  'id'           => 'date',
  'value'        => set_value("date",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
);
$journal_name = array(
  'name'         => 'journal_name',
  'id'           => 'journal_name',
  'value'        => set_value("journal_name",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
  
);
$explainations = array(
  'name'         => 'explanations',
  'id'           => 'explanations',
  'value'        => set_value("explanations",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
  
);

$amount = array(
  'name'         => 'amount',
  'id'           => 'amount',
  'value'        => set_value("amount", ""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
  
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
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />

<?php echo form_open("je_current/create", array('class' => 'form-horizontal', 'id'=> 'form_item'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="doc_name"><?php echo lang('doc_name');?></label>
      <div class="col-md-9">
        <?php echo form_input($doc_name);?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="date"><?php echo lang('date');?></label>
      <div class="col-md-9">
        <?php echo form_input($date);?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="journal_name"><?php echo lang('journal_name');?></label>
      <div class="col-md-9">
        <?php echo form_input($journal_name);?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="explanations"><?php echo lang('explanations');?></label>
      <div class="col-md-9">
        <?php echo form_input($explainations);?>
      </div>
    </div>


    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="acc_debt"><?php echo lang('acc_dpt');?></label>
      <div class="col-md-9">
        <input id="acc_debt" class="form-control" name="acc_debt"/>
      </div>
    </div>


    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="acc_crdt"><?php echo lang('acc_crdt');?></label>
      <div class="col-md-9">
        <input  name="acc_crdt" id="acc_crdt" class="form-control">
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="amount"><?php echo lang('amount');?></label>
      <div class="col-md-9">
        <?php echo form_input($amount);?>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="acc_crdt"><?php echo lang('gl_status');?></label>
      <div class="col-md-9">
       
        <?php    
        $status = $this->settings_model->getGLstatus();
        $default_status = "open"; 
        $gl_status = array(
          "id" => "gl_status",
          "class" => "form-control"
        );
        echo form_dropdown('gl_status', $status, set_value("gl_status", $default_status), $gl_status);
        ?>
        
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
<?php
$rawaccounts = array();

foreach ($accounts as $key => $value) { 
  $arr = ["value"=>$value['account_number']];
  array_push($rawaccounts, $arr);
}

?>


<script type="text/javascript">
  $(document).ready(function(){
   $("#date").datepicker("setStartDate", $("#date").datepicker("getDate"));
   $("#gl_status").prop('disabled', true);
 });

  var rawoptions = <?php echo json_encode($rawaccounts); ?>;

  $('#acc_debt').autocomplete({
    lookup: rawoptions
  });
  $('#acc_crdt').autocomplete({
    lookup: rawoptions
  });




</script>
