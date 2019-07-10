<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if ($this->ion_auth->in_group(array("customer", "supplier")) && $estimate->status == "sent"): ?>
        <a href="#" data-id="<?php echo $estimate->id; ?>" class="btn btn-link btn-sm estimate_approve" >
            <i class="icon-check text-success h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("approve"); ?></small>
        </a>
        <a href="#" data-id="<?php echo $estimate->id; ?>" class="btn btn-link btn-sm estimate_reject" >
            <i class="icon-close text-danger h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("reject"); ?></small>
        </a>
        <span class="divider-vertical"></span>
        <?php endif ?>
        <?php if (isset($invoice_id)): ?>
            <a href="<?php echo site_url('/invoices/open/'.$invoice_id);?>" class="btn btn-link btn-sm" >
                <i class="icon-doc h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("invoice"); ?></small>
            </a>
        <?php endif ?>
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/estimates/edit?id='.$estimate->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-pencil h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
        </a>
        <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$('#estimates_table').load_ajax('<?php echo site_url('/estimates/delete?id='.$estimate->id);?>', 'POST', undefined, '<?php echo site_url('/estimates') ?>');}); return false;" class="btn btn-link btn-sm" >
            <i class="icon-trash h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
        </a>
        <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$('#estimates_table').load_ajax('<?php echo site_url('/estimates/duplicate?id='.$estimate->id);?>', 'POST', undefined, '<?php echo site_url('/estimates') ?>');}); return false;" class="btn btn-link btn-sm" >
            <i class="icon-docs h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("duplicate"); ?></small>
        </a>
        <span class="divider-vertical"></span>
        <?php endif ?>
        <a href="#" onclick="MyWindow=window.open('<?php echo site_url('/estimates/view?id='.$estimate->id);?>', WINDDOW_NAME,WINDDOW_CONFIGURATION); return false;" class="btn btn-link btn-sm" id="print_estimate" >
            <i class="icon-printer h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("print"); ?></small>
        </a>
        <a href="<?php echo site_url('/estimates/pdf?id='.$estimate->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-cloud-download h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("tabletool_pdf"); ?></small>
        </a>
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/estimates/email?id='.$estimate->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-envelope-letter h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("email"); ?></small>
        </a>
        <span class="divider-vertical"></span>
        <a href="<?php echo site_url('/invoices/create?estimate_id='.$estimate->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-shuffle h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("convert_to_invoice"); ?></small>
        </a>
        <a href="<?php echo site_url('/estimates/activities?id='.$estimate->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-clock h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("activities"); ?></small>
        </a>
        <?php endif ?>
    </div>
</ol>
<div class="container-fluid">
<?php echo $preview; ?>
<script type="text/javascript">
$(document).on('click', '.estimate_approve', function(ev) {
    if( !$(this).is('.disabled') ){
        var id = $(this).data("id");
        bconfirm(globalLang['alert_confirmation'], function(){
            $(document).load_ajax(SITE_URL+"/estimates/approve/"+id, 'POST', {}, SITE_URL+"/estimates/open/"+id);
        });
    }
    ev.preventDefault();
    return false;
});
$(document).on('click', '.estimate_reject', function(ev) {
    if( !$(this).is('.disabled') ){
        var id = $(this).data("id");
        bconfirm(globalLang['alert_confirmation'], function(){
            $(document).load_ajax(SITE_URL+"/estimates/reject/"+id, 'POST', {}, SITE_URL+"/estimates/open/"+id);
        });
    }
    ev.preventDefault();
    return false;
});
var shortcuts_list = [
    {"selector":"#print_estimate","keyChar":"CTRL+P","click":"#print_estimate","description":globalLang["print"], "group": globalLang["estimate"]}
];
</script>
