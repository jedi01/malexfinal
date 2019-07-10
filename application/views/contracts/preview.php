<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/contracts/edit?id='.$contract->id);?>" sis-modal="" class="btn btn-link btn-sm large-modal" >
            <i class="icon-pencil h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
        </a>
        <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/contracts/delete?id='.$contract->id);?>', 'POST', undefined, '<?php echo site_url('/contracts') ?>');}); return false;" class="btn btn-link btn-sm" >
            <i class="icon-trash h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
        </a>
        <span class="divider-vertical"></span>
        <?php endif ?>
        <a href="#" onclick="MyWindow=window.open('<?php echo site_url('/contracts/view?id='.$contract->id);?>', WINDDOW_NAME,WINDDOW_CONFIGURATION); return false;" class="btn btn-link btn-sm" id="print_contract" >
            <i class="icon-printer h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("print"); ?></small>
        </a>
        <a href="<?php echo site_url('/contracts/pdf?id='.$contract->id);?>" class="btn btn-link btn-sm" >
            <i class="icon-cloud-download h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("tabletool_pdf"); ?></small>
        </a>
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
        <a href="<?php echo site_url('/contracts/email?id='.$contract->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-envelope-letter h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("email"); ?></small>
        </a>
        <?php endif ?>
        <?php if (trim($contract->attachments) != ""): ?>
        <a href="<?php echo site_url('/contracts/download_attachment/'.$contract->id);?>" target="_BLANK" class="btn btn-link btn-sm" >
            <i class="icon-paper-clip h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("attachments"); ?></small>
        </a>
        <?php endif ?>
    </div>
</ol>
<div class="container-fluid">
<?php echo $preview; ?>
<?php if (trim($contract->attachments) != ""): ?>
    <div class="col-md-8 col-md-offset-2">
        <div class="card card-default">
            <div class="card-header">
            </div>
            <div class="card-block">
                <div class="attachments">
                    <ul>
                        <?php
                        $attachments = json_decode($contract->attachments);
                        foreach ($attached_files as $file) {
                            echo '<li>'.
                            '<span class="label label-default label-bill">'.substr($file->extension, 1).'</span> '.
                            '<b> <a href="'.site_url('/files/download/'.$file->link).'">'.$file->filename.$file->extension.'</a> </b>'.
                            '<span class="quickMenu"><a href="'.site_url('/files/download/'.$file->link).'"><i class="fa fa-download"></i></a></span>'.
                            '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<script type="text/javascript">
var shortcuts_list = [
    {"selector":"#print_invoice","keyChar":"CTRL+P","click":"#print_contract","description":globalLang["print"], "group": globalLang["contract"]}
];
</script>
