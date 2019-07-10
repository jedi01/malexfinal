<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    <?php
      echo isset($page_title)?$page_title." - ":"";
      echo lang("site_title_head");
    ?>
    </title>
    <link rel="shortcut icon" href="<?=base_url("assets/img/favicon.png"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url("assets/css/style.css"); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/toastrjs/toastr.min.css") ?>">
    <?php if ( lang("IS_RTL") ): ?>
        <link href="<?=base_url("assets/css/rtl.css"); ?>" rel="stylesheet">
    <?php endif ?>
    <script type="text/javascript" src="<?php echo $this->config->base_url("assets/js/libs/jquery.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->config->base_url("index.php/settings/jsConstant?v=".rand(1000, 9999)); ?>"></script>

    <style type="text/css">
    .carousel-control {
      position: fixed;
      top: 0;
      height: 100%;
      width: 50px;
    }
    .carousel-control span{
      top: 50%;
      display: block;
      position: relative;
      margin-top: -15px;
    }
    .carousel-caption {
      position: relative;
      width: 100%;
    }
    </style>
  </head>

  <body dir="<?php echo (lang("IS_RTL"))?"rtl":"ltr" ?>">
    <header class="navbar" style="position: relative !important;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav">
          <li class="nav-item p-x-1">
            <a class="nav-link">
              <b><?php echo (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files"); ?></b>
              <small>(<?php echo $fullsize ?>)</small>
            </a>
          </li>
        </ul>
        <ul class="nav navbar-nav flip pull-right p-x-1">
          <li class="nav-item">
            <a href="<?php echo site_url("files/share/".$files_link) ?>" sis-modal="files_table" class="btn btn-secondary sis_modal" >
              <i class="fa fa-share-alt"></i> <span class="hidden-md-down"><?php echo lang('share'); ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url("files/download/".$files_link) ?>" class="btn btn-secondary" >
              <i class="fa fa-download"></i> <span class="hidden-md-down"><?php echo lang('tabletool_collection'); ?></span>
            </a>
          </li>
        </ul>
      </div>
    </header>
    <div class="clearfix"></div>
    <center>
    <div id="carousel-id" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php foreach ($files as $index => $file): ?>
          <div class="item <?php echo $index==0?"active":"" ?>">
            <div class="carousel-caption">
              <strong><?php echo $file->filename.$file->extension; ?></strong>
              (<i><?php echo $file->size ?></i>)
            </div>
            <?php $mime_type = substr($file->type, 0, strpos($file->type, "/")); ?>
            <?php if ($mime_type == 'audio'): ?>
              <source src="<?php echo site_url("files/get/".$file->link) ?>" type="<?php echo $file->type ?>">
            <?php elseif ($mime_type == 'image'): ?>
              <img src="<?php echo site_url("files/get/".$file->link) ?>" style="max-width: 100%; max-height: 100%;" alt="<?php echo $file->filename ?>"/>
            <?php elseif ($mime_type == 'video'): ?>
              <video width="320" height="240" controls>
                <source src="<?php echo site_url("files/get/".$file->link) ?>" type="<?php echo $file->type ?>">
              </video>
            <?php else: ?>
              <iframe src="<?php echo site_url("files/get/".$file->link) ?>" frameborder="0" width="100%" style="min-height: 500px"></iframe>
            <?php endif ?>
            <?php if (count($files)>1): ?>
            <?php endif ?>
          </div>
        <?php endforeach ?>
      </div>
      <?php if (count($files)>1): ?>
      <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="fa fa-angle-left"></span></a>
      <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="fa fa-angle-right"></span></a>
      <?php endif ?>
    </div>
    </center>
<!-- Main content -->
<main class="main">
<div class="container">
