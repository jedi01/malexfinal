<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title  col-md-6"><?php echo lang('purchase_template') ?></h3>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->

<div class="templates">
  <div class="template">
    <div class="template-image" style="background-image: url(<?php echo base_url("/assets/img/create_template.jpg") ?>);">
      <div class="template-actions">
        <a href="<?php echo site_url("/settings/customize_purchase_template/") ?>" class="btn btn-secondary btn-block"><?php echo lang("create") ?></a>
      </div>
    </div>
    <h4 class="template-title"><?php echo lang("blank") ?></h4>
  </div>
  <?php foreach (glob("assets/templates/PurchaseTemplates/*", GLOB_ONLYDIR) as $template): ?>
    <?php
    $name = pathinfo($template, PATHINFO_BASENAME);
    $f = file_get_contents(realpath($template)."/template.json");
    $template_settings = json_decode($f);
    $isSelected = ($purchase_settings->name == $template_settings->name)?"selected":"";

     $template =  str_replace(" ","%20",$template);
     ?>
    <div class="template <?php echo $isSelected ?>">

      <div class="template-image" style="background-image: url(<?php echo base_url($template."/preview.jpg") ?>);">
        <div class="template-actions">
          <?php if ($purchase_settings->name == $template_settings->name): ?>
            <a href="<?php echo site_url("/settings/customize_purchase_template/".$name) ?>" class="btn btn-secondary btn-block"><?php echo lang("customize") ?></a>
          <?php else: ?>
            <a href="<?php echo site_url("/settings/select_purchase_template/".$name) ?>" class="btn btn-secondary btn-block"><?php echo lang("select") ?></a>
          <?php endif ?>
        </div>
      </div>
      <h4 class="template-title"><?php echo $template_settings->name ?></h4>
    </div>
  <?php endforeach ?>
</div>
