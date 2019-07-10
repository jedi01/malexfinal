<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo lang('deactivate_heading');?></h5>
<hr />
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?> ?</p>
<?php echo form_open("auth/deactivate/".$user->id);?>
<?php echo form_hidden($csrf); ?>
<?php echo form_hidden(array('id'=>$user->id)); ?>
<?php echo form_hidden(array('confirm'=>"yes")); ?>
<div class="text-md-right">
  <hr />
  <button type="button" tabindex="1" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("deactivate_confirm_n_label") ?></button>
  <?php echo form_submit('submit', lang('deactivate_confirm_y_label'), array('class' => 'btn btn-primary', "tabindex"=>"2"));?>
</div>
<?php echo form_close();?>
