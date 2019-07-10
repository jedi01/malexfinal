<?php
$attrib = array('class'=>'form-horizontal', "id"=>"form_settings_general");
echo form_open("/settings/update_settings_general", $attrib);
?>
<style type="text/css">
  .input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
  }
</style>
<input type="hidden" name="reset_all_references" value="0">
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title col-md-6"><?php echo lang('configuration_general') ?></h3>
    <div class="col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update_settings") ?></button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->


<div class="row-fluid">
  <div class="display-table invoice_config">
    <div class="display-margin bordered_tabs">
      <ul class="nav nav-tabs" id="general_tabs">
        <li class="nav-item active"><a class="nav-link" href="#template_purchase"><?php echo lang('purchase_order') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#template_invoice"><?php echo lang('invoices') ?></a></li>
      </ul>
      <div class="tab-content">

        <!-- SYSTEM PURCHASE TEMPLATE -->
        <div class="tab-pane form-horizontal show active" id="template_purchase">
          <div class="row-fluid">
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
          </div>
        </div>
        <!-- SYSTEM PURCHASE TEMPLATE END -->


        <!-- SYSTEM PURCHASE TEMPLATE -->
        <div class="tab-pane form-horizontal" id="template_invoice">
          <div class="row-fluid">
              <div class="templates">
                <div class="template">
                  <div class="template-image" style="background-image: url(<?php echo base_url("/assets/img/create_template.jpg") ?>);">
                    <div class="template-actions">
                      <a href="<?php echo site_url("/settings/customize_template/") ?>" class="btn btn-secondary btn-block"><?php echo lang("create") ?></a>
                    </div>
                  </div>
                  <h4 class="template-title"><?php echo lang("blank") ?></h4>
                </div>
                <?php foreach (glob("assets/templates/InvoiceTemplates/*", GLOB_ONLYDIR) as $template): ?>
                  <?php
                  $name = pathinfo($template, PATHINFO_BASENAME);
                  $f = file_get_contents(realpath($template)."/template.json");
                  $template_settings = json_decode($f);
                  $isSelected = ($invoice_settings->name == $template_settings->name)?"selected":"";

                  $template =  str_replace(" ","%20",$template);
                  ?>
                <div class="template <?php echo $isSelected ?>">
                  <div class="template-image" style="background-image: url(<?php echo base_url($template."/preview.jpg") ?>);">
                    <div class="template-actions">
                      <?php if ($invoice_settings->name == $template_settings->name): ?>
                        <a href="<?php echo site_url("/settings/customize_template/".$name) ?>" class="btn btn-secondary btn-block"><?php echo lang("customize") ?></a>
                        <?php else: ?>
                          <a href="<?php echo site_url("/settings/select_template/".$name) ?>" class="btn btn-secondary btn-block"><?php echo lang("select") ?></a>
                        <?php endif ?>
                    </div>
                  </div>
                  <h4 class="template-title"><?php echo $template_settings->name ?></h4>
                </div>
                  <?php endforeach ?>
              </div>
          </div>
        </div>
        <!-- SYSTEM PURCHASE TEMPLATE END -->







    </div>
  </div>
</div>
</div>


<div class="clearfix"></div>
<?php echo form_close();?>

