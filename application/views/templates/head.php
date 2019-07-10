<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Lynks Bookkeeping Software">
        <meta name="author" content="Bessem Zitouni">
        <meta name="keyword" content="Smart, Invoice, System, SIS">
        <link rel="shortcut icon" href="<?php echo base_url("assets/img/favicon.png") ?>">
        <title>
        <?php
            echo lang("site_title_head");
            echo isset($page_title)?" - ".$page_title:"";
        ?>
        </title>
        <?php
            $this->load->enqueue_style("assets/vendor/bootstrap.datepicker/css/bootstrap-datepicker.css");
            $this->load->enqueue_style("assets/vendor/toastrjs/toastr.min.css");
            $this->load->enqueue_style("assets/css/style.css");
            $this->load->enqueue_style("assets/css/mainmenu.css");
            $this->load->enqueue_style("assets/css/responsive.css");
            if ( lang("IS_RTL") ){
                $this->load->enqueue_style("assets/css/rtl.css");
            }
            echo $this->load->css();
            $this->load->enqueue_script("assets/js/libs/jquery.min.js", "head");
            $this->load->enqueue_script("index.php/settings/jsConstant/head?v=".rand(1000, 9999), "head");
            $this->load->enqueue_script("assets/js/jquery.autocomplete.min.js");
            echo $this->load->javascript("head");
        ?>
        <style type="text/css">.cbalink{display: none;}</style>
    </head>
