
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/purchases/edit?id='.$purchase->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-pencil h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
        </a>
        <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$('#invoices_table').load_ajax('<?php echo site_url('/purchases/delete?id='.$purchase->id);?>', 'POST', undefined, '<?php echo site_url('/purchases') ?>');}); return false;" class="btn btn-link btn-sm" >
            <i class="icon-trash h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
        </a>
        <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$('#invoices_table').load_ajax('<?php echo site_url('/purchases/duplicate?id='.$purchase->id);?>', 'POST', undefined, '<?php echo site_url('/purchases') ?>');}); return false;" class="btn btn-link btn-sm" >
            <i class="icon-docs h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("duplicate"); ?></small>
        </a>
        <span class="divider-vertical"></span>
        <?php endif ?>
        <a href="#" onclick="MyWindow=window.open('<?php echo site_url('/purchases/view?id='.$purchase->id);?>', WINDDOW_NAME,WINDDOW_CONFIGURATION); return false;" class="btn btn-link btn-sm" id="print_invoice" >
            <i class="icon-printer h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("print"); ?></small>
        </a>
        <a href="<?php echo site_url('/purchases/pdf?id='.$purchase->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-cloud-download h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("tabletool_pdf"); ?></small>
        </a>
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/purchases/email?id='.$purchase->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-envelope-letter h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("email"); ?></small>
        </a>
        <?php endif ?>
        <span class="divider-vertical"></span>
        <?php if ($purchase->total_due != 0): ?>
            <a href="<?php echo site_url('/payments/create?id='.$purchase->id);?>" sis-modal="" class="btn btn-link btn-sm" >
                <i class="icon-credit-card h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("payments_create"); ?></small>
            </a>
            <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
            <a href="<?php echo site_url('/purchase_receipts/create?id='.$purchase->id);?>" sis-modal="" class="btn btn-link btn-sm" >
                <i class="icon-doc h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("receipts_create"); ?></small>
            </a>
            <?php endif ?>
        <?php endif ?>
        <?php if ($this->ion_auth->is_admin()): ?>
        <a href="<?php echo site_url('/purchases/activities?id='.$purchase->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-clock h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("activities"); ?></small>
        </a>
        <?php endif ?>
    </div>
</ol>
<div class="container-fluid">
<?php echo $preview; ?>
<script type="text/javascript">
var shortcuts_list = [
    {"selector":"#print_invoice","keyChar":"CTRL+P","click":"#print_invoice","description":globalLang["print"], "group": globalLang["invoice"]}
];
</script>
