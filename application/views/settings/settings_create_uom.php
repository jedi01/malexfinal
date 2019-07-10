

<?php

$unit_of_measurement = array(
  'name'         => 'unit_of_measurement',
  'id'           => 'unit_of_measurement',
  'value'        => set_value("unit_of_measurement",""),
  'class'        => "form-control",
  'autocomplete' => "off",
  'type'         => "text",
 
);

$description = array(
  'name'         => 'description',
  'id'           => 'description',
  'value'        => set_value("description",""),
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
<hr />

<?php echo form_open("settings/create_uom", array('class' => 'form-horizontal', 'id'=> 'form_item'));?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
 <div class="row form-group desc">
      <label class="col-md-3 form-control-label" for="unit_of_measurement"><?php echo lang('unit_of_measurement');?></label>
      <div class="col-md-9">
        <?php echo form_input($unit_of_measurement);?>
      </div>
    </div>
    <div class="row form-group desc">
      <label class="col-md-3 form-control-label" for="description"><?php echo lang('description');?></label>
      <div class="col-md-9">
        <?php echo form_input($description);?>
      </div>
    </div>

    

     <div class="row form-group required">
      <label class="col-md-3 form-control-label " for="status"><?php echo lang('status');?></label>
      <div class="col-md-9">
        <select  name="status" value="" id="status" class="form-control">
          <option value="1"> <?php echo lang('active');?></option>
          <option value="0"> <?php echo lang('inactive');?></option>
        </select>
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



