<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc">
            <?php echo $page_subheading;?>
            <?php
            if( $rinvoice->status == "panding" ){
                $status_label = "info";
            }elseif( $rinvoice->status == "active" ){
                $status_label = "warning";
            }elseif( $rinvoice->status == "canceled" ){
                $status_label = "default";
            }elseif( $rinvoice->status == "finished" ){
                $status_label = "success";
            }
            echo "<span class='label label-tall label-$status_label'>".lang($rinvoice->status)."</span>";
            ?>
        </div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
            <?php if ($rinvoice->status != "canceled"): ?>
                <a href="<?php echo site_url('/rinvoices/edit?id='.$rinvoice->id);?>" class="btn btn-link btn-sm" >
                    <i class="icon-pencil h3 font-weight-bold"></i>
                    <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
                </a>
            <?php endif ?>
            <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/rinvoices/delete?id='.$rinvoice->id);?>', 'POST', undefined, '<?php echo site_url('/rinvoices') ?>');}); return false;" class="btn btn-link btn-sm" >
                <i class="icon-trash h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
            </a>
            <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/rinvoices/duplicate?id='.$rinvoice->id);?>', 'POST', undefined, '<?php echo site_url('/rinvoices') ?>');}); return false;" class="btn btn-link btn-sm" >
                <i class="icon-docs h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("duplicate"); ?></small>
            </a>
            <span class="divider-vertical"></span>
        <?php endif ?>
        <?php if ($rinvoice->status == "panding"): ?>
            <a href="#" onclick="$(document).load_ajax('<?php echo site_url('/rinvoices/profile/start/'.$rinvoice->id);?>', 'POST', undefined, '<?php echo site_url('/rinvoices/open/'.$rinvoice->id) ?>'); return false;" class="btn btn-link btn-sm" >
                <i class="icon-control-play h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("start_profile"); ?></small>
            </a>
        <?php elseif ($rinvoice->status == "active"): ?>
            <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/rinvoices/profile/cancel/'.$rinvoice->id);?>', 'POST', undefined, '<?php echo site_url('/rinvoices/open/'.$rinvoice->id) ?>');}); return false;" class="btn btn-link btn-sm" >
                <i class="icon-close h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("cancel_profile"); ?></small>
            </a>

            <a href="#" onclick="$(document).load_ajax('<?php echo site_url('/rinvoices/profile/skip/'.$rinvoice->id);?>', 'POST', undefined, '<?php echo site_url('/rinvoices/open/'.$rinvoice->id) ?>'); return false;" class="btn btn-link btn-sm" >
                <i class="icon-control-forward h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("skip_next_invoice"); ?></small>
            </a>
        <?php endif ?>
        <a href="<?php echo site_url('/rinvoices/activities/'.$rinvoice->id);?>" sis-modal="" class="btn btn-link btn-sm" >
            <i class="icon-clock h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("activities"); ?></small>
        </a>
    </div>
</ol>
<div class="container-fluid">
<div class="card">
    <div class="row m-x-0">
        <div class="col-md-3 p-x-0">
            <div class="card-header card-header-<?php echo $status_label ?>">
                <i class="icon-star h4 media-middle"></i>
                <small><?php echo $rinvoice->name ?></small>
            </div>
        </div>
        <div class="col-md-3 p-x-0">
            <div class="card-header card-header-<?php echo $status_label ?>">
                <i class="icon-info h4 media-middle"></i>
                <small><?php echo lang($rinvoice->status) ?></small>
            </div>
        </div>
        <div class="col-md-3 p-x-0">
            <div class="card-header card-header-<?php echo $status_label ?>">
                <i class="icon-loop h4 media-middle"></i>
                <small><?php echo lang("every").$this->rinvoices_model->toString($rinvoice) ?></small>
            </div>
        </div>
        <div class="col-md-3 p-x-0">
            <div class="card-header card-header-<?php echo $status_label ?>">
                <i class="icon-calendar h4 media-middle"></i>
                <small><?php echo lang("recurring_effective");?> <b><?php echo date_MYSQL_JS($rinvoice->date) ?></b></small>
            </div>
        </div>
    </div>
    <div class="row m-x-0 p-a-0 display-flex">
        <?php
        for ($i=0; $i < min(count($items), 6); $i++) {
            $item = $items[$i];
        ?>
        <div class="col-md-2 p-a-0">
            <div class="card-footer">
                <div class="pull-right flip">
                <?php if ($item["invoice_id"] == NULL && !$item["skip"]): ?>
                    <span class="label label-info label-tall label-recurring"><i class="fa fa-retweet"></i><?php echo lang("panding") ?></span>
                <?php elseif($item["skip"]==1): ?>
                    <span class="label label-warning label-tall label-recurring"><i class="fa fa-retweet"></i><?php echo lang("skipped") ?></span>
                <?php else: ?>
                    <span class="label label-success label-tall label-recurring"><i class="fa fa-retweet"></i><?php echo lang($item["invoice"]->status) ?></span>
                <?php endif ?>
                </div>
                <small class="col-md-6 p-a-0"><?php echo date_MYSQL_JS($item["date"]) ?></small>
                <div class="clearfix"></div>
                <hr class="m-y-h">
                <?php if ($item["invoice_id"] == NULL && !$item["skip"]): ?>
                    <i class="fa fa-calendar-check-o media-middle"></i><span><?php echo lang("scheduled") ?></span>
                <?php elseif($item["skip"]==1): ?>
                    <i class="fa fa-calendar-times-o media-middle"></i><span><?php echo lang("this_invoice_skipped") ?></span>
                <?php else: ?>
                    <i class="fa fa-file-text-o media-middle"></i><span><a href="<?php echo site_url("/invoices/open/".$item["invoice"]->id) ?>"><?php echo $item["invoice"]->reference ?></a></span>
                <?php endif ?>
            </div>
        </div>
        <?php } ?>
        <?php for ($i=0; $i < 6-count($items); $i++) { ?>
        <div class="col-md-2 p-a-0 clear">
            <div class="card-footer">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php echo $preview; ?>
