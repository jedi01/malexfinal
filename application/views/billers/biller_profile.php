
<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc">
            <?php if( trim($biller->company) != "" ) { echo $biller->company;} else { echo $biller->fullname;}?>
            <?php if( trim($biller->company) != "" ) { echo " <small>".lang("attn").": ".$biller->fullname."</small>"; } ?>
        </div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <?php if (!$this->ion_auth->in_group(array("customer", "supplier"))): ?>
            <a href="<?php echo site_url('/billers/edit?id='.$biller->id);?>" class="btn btn-link btn-sm sis_modal" sis-modal="" >
                <i class="icon-pencil h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("edit"); ?></small>
            </a>
            <a href="#" onclick="bconfirm('<?php echo lang("alert_confirmation") ?>', function(){$(document).load_ajax('<?php echo site_url('/billers/delete?id='.$biller->id);?>', 'POST', undefined, '<?php echo site_url('/billers') ?>');}); return false;" class="btn btn-link btn-sm" >
                <i class="icon-trash h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("delete"); ?></small>
            </a>
            <span class="divider-vertical"></span>
            <?php if ($user): ?>
                <a href="<?php echo site_url('/auth/edit_user/'.$user->id);?>" class="btn btn-link btn-sm sis_modal" sis-modal="" >
                    <i class="icon-user h3 font-weight-bold"></i>
                    <small class="text-muted center-block"><?php echo lang("edit_customer_account"); ?></small>
                </a>
            <?php else: ?>
                <a href="#" onclick="$(document).load_ajax('<?php echo site_url('/billers/create_account/'.$biller->id);?>', 'POST', undefined, '<?php echo site_url('/billers/profile/'.$biller->id) ?>'); return false;" class="btn btn-link btn-sm" >
                    <i class="icon-user h3 font-weight-bold"></i>
                    <small class="text-muted center-block"><?php echo lang("create_customer_account"); ?></small>
                </a>
            <?php endif ?>
            <span class="divider-vertical"></span>
            <a href="#" onclick="$(document).load_ajax('<?php echo site_url('/billers/send_reminder/'.$biller->id);?>', 'POST'); return false;" class="btn btn-link btn-sm" >
                <i class="icon-clock h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("send_payments_reminder"); ?></small>
            </a>
            <a href="<?php echo site_url('/calendar/add?emails='.$biller->email.'&name='.lang('reminder_for').$biller->fullname);?>" class="btn btn-link btn-sm sis_modal" sis-modal="" >
                <i class="icon-bell h3 font-weight-bold"></i>
                <small class="text-muted center-block"><?php echo lang("create_reminder"); ?></small>
            </a>
        <?php endif ?>

    </div>
</ol>
<div class="container-fluid">


<div class="bordered_tabs">
    <ul class="nav nav-tabs" id="profile_biller">
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_details"><?php echo lang('profile') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_estimates"><?php echo lang('estimates') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_invoices"><?php echo lang('invoices') ?></a></li>
        <?php if (ENABLE_RECURRING): ?>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_rinvoices"><?php echo lang('rinvoices') ?></a></li>
        <?php endif ?>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_payments"><?php echo lang('payments') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_receipts"><?php echo lang('receipts') ?></a></li>
        <?php if (ENABLE_CONTRACTS): ?>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#biller_contracts"><?php echo lang('contracts') ?></a></li>
        <?php endif ?>
    </ul>
    <div class="tab-content" style="background: white;">
        <div class="tab-pane form-horizontal" id="biller_details">
            <?php echo $this->load->view('billers/biller_details', array("disable_headings"=>true), true); ?>
        </div>
        <div class="tab-pane form-horizontal" id="biller_invoices">
            <?php echo $this->load->view('invoices/invoices', array("disable_headings"=>true, "biller_id"=>$biller->id), true); ?>
        </div>
        <?php if (ENABLE_RECURRING): ?>
        <div class="tab-pane form-horizontal" id="biller_rinvoices">
            <?php echo $this->load->view('rinvoices/rinvoices', array("disable_headings"=>true, "biller_id"=>$biller->id), true); ?>
        </div>
        <?php endif ?>
        <div class="tab-pane form-horizontal" id="biller_estimates">
            <?php echo $this->load->view('estimates/estimates', array("disable_headings"=>true, "biller_id"=>$biller->id), true); ?>
        </div>
        <?php if (ENABLE_CONTRACTS): ?>
        <div class="tab-pane form-horizontal" id="biller_contracts">
            <?php echo $this->load->view('contracts/contracts', array("disable_headings"=>true, "biller_id"=>$biller->id), true); ?>
        </div>
        <?php endif ?>
        <div class="tab-pane form-horizontal" id="biller_payments">
            <?php echo $this->load->view('payments/payments', array("disable_headings"=>true, "biller_id"=>$biller->id, "invoice"=>false), true); ?>
        </div>
        <div class="tab-pane form-horizontal" id="biller_receipts">
            <?php echo $this->load->view('receipts/receipts', array("disable_headings"=>true, "biller_id"=>$biller->id, "invoice"=>false), true); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#profile_biller a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('#profile_biller a[href="#biller_details"]').tab('show');
    });
</script>
