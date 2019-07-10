
<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <!-- <div class="text-muted page-desc"><?php echo $page_subheading;?></div> -->
    </div>
</ol>

<div class="container-fluid">
    <div class="p-x-h">

<div class="card">
    <div class="display-flex">
        <div class="card card-inverse card-success m-a-0 p-a-1"><i class="icon-graph fa-2x"></i></div>
        <div class="card-block">
            <a href="<?php echo site_url("/reports/profit_loss") ?>">
                <h5><?php echo lang('profit_loss') ?></h5>
            </a>
            <small class="text-muted"><?php echo lang('profit_loss_subheading') ?></small>
        </div>
    </div>
    <div class="display-flex">
        <div class="card card-inverse card-success m-a-0 p-a-1"><i class="icon-share-alt fa-2x"></i></div>
        <div class="card-block">
            <a href="<?php echo site_url("/reports/tax_summary") ?>">
                <h5><?php echo lang('tax_summary') ?></h5>
            </a>
            <small class="text-muted"><?php echo lang('tax_summary_subheading') ?></small>
        </div>
    </div>
    <div class="display-flex">
        <div class="card card-inverse card-success m-a-0 p-a-1"><i class="icon-hourglass fa-2x"></i></div>
        <div class="card-block">
            <a href="<?php echo site_url("/reports/accounts_aging") ?>">
                <h5><?php echo lang('accounts_aging') ?></h5>
            </a>
            <small class="text-muted"><?php echo lang('accounts_aging_subheading') ?></small>
        </div>
    </div>
    <div class="display-flex">
        <div class="card card-inverse card-success m-a-0 p-a-1"><i class="icon-book-open fa-2x"></i></div>
        <div class="card-block">
            <a href="<?php echo site_url("/reports/invoice_details") ?>">
                <h5><?php echo lang('invoice_details') ?></h5>
            </a>
            <small class="text-muted"><?php echo lang('invoice_det_subheading') ?></small>
        </div>
    </div>
    <div class="display-flex">
        <div class="card card-inverse card-success m-a-0 p-a-1"><i class="icon-people fa-2x"></i></div>
        <div class="card-block">
            <a href="<?php echo site_url("/reports/revenue_by_customer") ?>">
                <h5><?php echo lang('revenue_by_customer') ?></h5>
            </a>
            <small class="text-muted"><?php echo lang('revenue_cust_subheading') ?></small>
        </div>
    </div>
</div>
    </div>
