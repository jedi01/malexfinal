<?php

$controller = NULL;
$method = NULL;
$params = $_GET;
unset($params['module']);
unset($params['view']);
if( is_array($params) && count($params) > 0 ){
  $params = implode('&', array_map(function ($v, $k) { return $k.'='.$v; }, $params, array_keys($params)));
}else{
  $params = NULL;
}
$refresh = "".($controller!=NULL?"module=".$controller:"").($method!=NULL?"&view=".$method:"").($params!=NULL?"&".$params:"");

$temp_name = "INVOICE";

if(isset($template_name)){
  $temp_name = "PURCHASE";


}


if( $this->input->post('template') ){
    $DB_SETTINGS = $this->input->post('template');
    $DF_SETTINGS = objectToArray($this->settings_model->getSettings($temp_name));
    $template_settings = array_merge($DF_SETTINGS, $DB_SETTINGS);
}else{
    $template_settings = objectToArray($this->settings_model->getSettings($temp_name));
}
extract($template_settings);
$header_text = html_entity_decode($header_text);

/*
 *  @Params
 *  signature1_name, signature1_lang
 *  company
 *  page_title
 *  second_footer
 *  show_btn_config
 *  show_btn_resolution
 *  show_btn_rotate
 *  show_center_title
 *  Page_resolution
 *  Page_size
 *  meta_title
 *  Page_content
 */
if(isset($template_settings['purchase_default_layout'])){

$Page_resolution = isset($Page_resolution)?$Page_resolution:$purchase_default_size; // A4, A5
$Page_size = isset($Page_size)?$Page_size:$purchase_default_layout; //landscape, portrait

}
else{

    $Page_resolution = isset($Page_resolution)?$Page_resolution:$invoice_default_size; // A4, A5
$Page_size = isset($Page_size)?$Page_size:$invoice_default_layout; //landscape, portrait
 
}
$page_title = isset($page_title)?$page_title:"";
$other_config = isset($other_config)?$other_config:"";
$show_btn_config = isset($show_btn_config)?$show_btn_config:true;
$isPDF = isset($isPDF)?$isPDF:false;
$show_btn_resolution = isset($show_btn_resolution)?$show_btn_resolution:true;
$show_btn_rotate = isset($show_btn_rotate)?$show_btn_rotate:true;
$show_center_title = isset($show_center_title)?$show_center_title:true;

$meta_title = isset($meta_title)?$meta_title:$page_title;
$Page_content = isset($Page_content)?$Page_content:"";
$auto_print = isset($default_auto_print)?$default_auto_print:$auto_print;
$paggination = isset($paggination)?$paggination:"page";

$show_footer    = isset($enable_footer)?$enable_footer:$show_footer;
$show_signature = isset($enable_signature)?$enable_signature:$show_signature;
$show_signature_2 = isset($show_signature_2)?$show_signature_2:false;
$show_header    = isset($enable_header)?$enable_header:$show_header;
$table_border   = isset($enable_bordered)?$enable_bordered:$table_border;
$table_strip    = isset($enable_strip)?$enable_strip:$table_strip;
$dashed_line    = isset($dashed_line)?$dashed_line:false;

$is_preview = isset($is_preview)?$is_preview:false;

$company = $this->settings_model->getSettings("COMPANY");
if( !$isPDF ){
  if( trim($signature_stamp) != "" ){
    $signature_stamp = base_url($signature_stamp);
  }
  $company->logo_img = $this->config->base_url($company->logo);
}else{
  if( trim($signature_stamp) != "" ){
    $signature_stamp = realpath($signature_stamp);
  }
  $company->logo_img = $company->logo;
}

$margins      = explode(" ", $margin);
$marginTop    = $margins[0];
$marginRight  = $margins[1];
$marginBottom = $margins[2];
$marginLeft   = $margins[3];

if(!function_exists("getHeaderByModel")) {
  function getHeaderByModel($model, $company, $header_text){
    switch ($model) {
      case 'model1': return getHeaderModel1($company, $header_text);
      case 'model2': return getHeaderModel2($company, $header_text);
      case 'model3': return getHeaderModel3($company, $header_text);
      case 'model4': return getHeaderModel4($company, $header_text);
      case 'model5': return getHeaderModel5($company, $header_text);
    }
  }
}

if(!function_exists("getHeaderModel1")) {
  function getHeaderModel1($company, $header_text){
    return "<div class=\"row model1\">
    <div class=\"col-xs-4 invoice-logo\">
      <img src=\"".$company->logo_img."\" alt=\""."SIS"."\" style=\"vertical-align:middle; width: 100%;\" />
    </div>
    <div class=\"col-xs-8 invoice-header-info\">".parsecompanyText($company, $header_text)."</div>
  </div>";
  }
}

if(!function_exists("getHeaderModel2")) {
  function getHeaderModel2($company, $header_text){
    return "<div class=\"row model2\">
    <div class=\"col-xs-8 invoice-header-info\">".parsecompanyText($company, $header_text)."</div>
    <div class=\"col-xs-4 invoice-logo\">
      <img src=\"".$company->logo_img."\" alt=\""."SIS"."\" style=\"vertical-align:middle; width: 100%;\" />
    </div>
  </div>";
  }
}

if(!function_exists("getHeaderModel3")) {
  function getHeaderModel3($company, $header_text){
    return "<div class=\"row model3\">
    <div class=\"invoice-logo\">
      <img src=\"".$company->logo_img."\" alt=\""."SIS"."\" style=\"vertical-align:middle;\" />
    </div>
    <div class=\"invoice-header-info\">".parsecompanyText($company, $header_text)."</div>
  </div>";
  }
}
if(!function_exists("getHeaderModel4")) {
  function getHeaderModel4($company, $header_text){
    return "<div class=\"row model4\">
    <div class=\"invoice-logo\">
      <img src=\"".$company->logo_img."\" alt=\""."SIS"."\" style=\"vertical-align:middle; margin-left: 20px\" />
    </div>
  </div>";
  }
}
if(!function_exists("getHeaderModel5")) {
  function getHeaderModel5($company, $header_text){
    return "<div class=\"row model5\">
    <div class=\"col-xs-12 invoice-header-info\">".parsecompanyText($company, $header_text)."</div>
  </div>";
  }
}

if(!function_exists("parsecompanyText")) {
  function parsecompanyText($company, $header_text){
    $columns_strs = array(
      "[company_name]" => "name",
      "[company_address]" => "address",
      "[company_city]" => "city",
      "[company_state]" => "state",
      "[company_postal_code]" => "postal_code",
      "[company_country]" => "country",
      "[company_phone]" => "phone",
      "[company_email]" => "email"
      );
    if (isset($company->cfl1) && !empty($company->cfl1)){
      $columns_strs["[company_".strtolower(trim(str_replace(" ", "_", $company->cfl1)))."]"] = "cfv1";
    }
    if (isset($company->cfl2) && !empty($company->cfl2)){
      $columns_strs["[company_".strtolower(trim(str_replace(" ", "_", $company->cfl2)))."]"] = "cfv2";
    }
    if (isset($company->cfl3) && !empty($company->cfl3)){
      $columns_strs["[company_".strtolower(trim(str_replace(" ", "_", $company->cfl3)))."]"] = "cfv3";
    }
    if (isset($company->cfl4) && !empty($company->cfl4)){
      $columns_strs["[company_".strtolower(trim(str_replace(" ", "_", $company->cfl4)))."]"] = "cfv4";
    }
    $company_array = (array)$company;
    foreach ($columns_strs as $column => $value) {
      if($company_array[$value] == false){
        $header_text = str_replace($column, "", $header_text);
      }else{
        $header_text = str_replace($column, $company_array[$value], $header_text);
      }
    }
    return $header_text;
  }
}
$footer_text = parsecompanyText($company, $footer_text);
  ?>
<?php if($show_btn_config && !$isPDF){ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $meta_title; ?></title>
    <link rel="shortcut icon" href="<?=base_url("assets/img/favicon.png"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url("assets/css/style.css"); ?>" rel="stylesheet">
    <?php if ( lang("IS_RTL") ): ?>
        <link href="<?=base_url("assets/css/rtl.css"); ?>" rel="stylesheet">
    <?php endif ?>
    <script type="text/javascript" src="<?php echo $this->config->base_url("assets/js/libs/jquery.min.js"); ?>"></script>
    <style type="text/css">
      html, body {
        height: 100%;
      }
      body {
        background: #dfdfdf;
      }
      .fixed-top {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        padding: 0 20px;
        background: white;
        margin: 0;
        z-index: 10;
      }
    </style>
  </head>

  <body dir="<?php echo (lang("IS_RTL"))?"rtl":"ltr" ?>">
    <header class="navbar" id="not-printed">
      <div class="container-fluid">
          <a class="navbar-brand" href="#"></a>
          <ul class="nav navbar-nav">
              <li class="nav-item p-x-1">
                  <a class="nav-link"><?php echo $meta_title; ?></a>
              </li>
          </ul>
          <ul class="nav navbar-nav flip pull-right">
              <li class="nav-item">
                <?php
                if($show_btn_resolution){
                  $template_sizes = $this->settings_model->getPaperSizes();
                  echo form_dropdown('Page_resolution', $template_sizes, $Page_resolution, 'id="resolution" class="btn btn-secondary" onchange="setPrinterConfig()" style="width: 190px;"');
                }
                ?>
              </li>
              <li class="nav-item">
                <?php
                if($show_btn_rotate){
                  $template_layouts = $this->settings_model->getPaperLayouts();
                  echo form_dropdown('Page_size', $template_layouts, $Page_resolution, 'id="rotate" class="btn btn-secondary" onchange="setPrinterConfig()" style="width: 120px;"');
                }
                ?>
              </li>
              <li class="nav-item">
                <button type="button" class="btn btn-secondary" onclick="window.print();return false;" >
                  <i class="fa fa-print"></i> <?php echo lang('print'); ?>
                </button>
              </li>
              <li class="nav-item">
                <a href="#" id="close_page"><i class="fa fa-close"></i></a>
              </li>
          </ul>
      </div>
  </header>
  <?php } ?>
  <div id="css_script">
    <style type="text/css" id="pageInit"><?php
        $w = "21cm"; $h = "29.7cm";
        $w2 = "20cm"; $h2 = "28.7cm";
        if( $Page_resolution == "A4" ){
          $w = "21cm"; $h = "29.7cm";
          $w2 = "20cm"; $h2 = "28.7cm";
        }else if( $Page_resolution == "A5" ){
          $w = "14.8cm"; $h = "21cm";
          $w2 = "13.8cm"; $h2 = "20cm";
        }
        if( $Page_size == "landscape" ){
          echo "@page{size: ".$h." ".$w."}";
          echo ".etat_header,.etat_content,.etat_footer{width: $h2;}";
        }else{
          echo "@page{size: ".$w." ".$h."}";
          echo ".etat_header,.etat_content,.etat_footer{width: $w2;}";
        }
      ?></style>
    <?php if (!$isPDF): ?>
      <link href="<?=base_url("assets/css/print.css"); ?>" rel="stylesheet">
    <?php endif ?>
    <style type="text/css">
      #wrap_invoice.page{
        font-family: <?php echo $invoice_font ?>;
        <?php if ($background_color): ?>
          background-color: <?php echo $background_color ?>;
        <?php endif ?>
        padding: <?php echo $marginTop." ".$marginRight." ".$marginBottom." ".$marginLeft ?>;
        z-index: 1;
      }
      <?php if ($background_image): ?>
      #wrap_invoice::after {
        content: "";
        display: block;
        background-repeat: no-repeat;
        background-image: url(<?php echo base_url($background_image); ?>);
        background-position: <?php echo $background_position; ?>;
        background-size: <?php echo $background_fit; ?>;
        opacity: <?php echo $background_opacity; ?>;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: absolute;
        z-index: -1;
      }
      <?php endif ?>
      #wrap_invoice h3{
        color: <?php echo $primary_color; ?>;
      }
      #wrap_invoice h4{
        color: <?php echo $primary_color; ?>;
      }
      .invoice_header .invoice-logo img{
        <?php if ($logo_size): ?>
          height: <?php echo $logo_size; ?> !important;
          width: auto !important;
          max-width: 100%;
        <?php endif ?>
        <?php if ($logo_greyscale): ?>
          filter: grayscale(100%);
        <?php endif ?>
        <?php if ($logo_monocolor): ?>
          filter: grayscale(100%) brightness(350%);
        <?php endif ?>
      }
      <?php
      if ($isPDF):
        list($logo_sizes_w, $logo_sizes_h) = getimagesize($company->logo_img);
        if( $logo_size ){
          $scale = 60/$logo_sizes_h;
          $logo_sizes_w = floatval($logo_size)*$logo_sizes_w/100*$scale;
          $logo_sizes_h = floatval($logo_size)*$logo_sizes_h/100*$scale;
        }
      ?>
        .invoice_header .model3 .invoice-logo,
        .invoice_header .model4 .invoice-logo{
          height: <?php echo intval($logo_sizes_h) ?>px  !important;
        }
        .invoice_header .model3 .invoice-logo img,
        .invoice_header .model4 .invoice-logo img{
          width: <?php echo intval($logo_sizes_w) ?>px  !important;
          height: <?php echo intval($logo_sizes_h) ?>px  !important;
          padding-left: -<?php echo intval($logo_sizes_w/2) ?>px  !important;
          left: 50%;
        }
      <?php endif ?>
      #wrap_invoice,
      #wrap_invoice p,
      #wrap_invoice .text-color,
      #wrap_invoice .inv.col b,
      #wrap_invoice .table_invoice{
        font-size: <?php echo $font_size ?>;
        color: <?php echo $text_color ?>;
      }
      #wrap_invoice .table_invoice thead th{
        background: <?php echo $table_line_th_bg; ?>;
        color: <?php echo $table_line_th_color; ?>;
        <?php if ($table_line_th_height): ?>
          line-height: <?php echo $table_line_th_height ?>px;
          height: <?php echo $table_line_th_height ?>px;
        <?php endif ?>
      }
      #wrap_invoice .table_invoice td{
        <?php if ($table_line_td_height): ?>
          line-height: <?php echo $table_line_td_height ?>px;
          height: <?php echo $table_line_td_height ?>px;
        <?php endif ?>
      }
      #wrap_invoice .page-title{
        color: <?php echo $primary_color; ?>;
        text-align: <?php echo $title_position ?>;
      }
      #wrap_invoice .invoice_header{
        background: <?php echo $header_bg_color; ?>;
        color: <?php echo $header_txt_color; ?> !important;
        margin: <?php echo "-".$marginTop." -".$marginRight." 0 -".$marginLeft ?>;
        padding: <?php echo $marginTop." ".$marginRight." 0 ".$marginLeft ?>;
      }
      #wrap_invoice .invoice_header *{
        color: <?php echo $header_txt_color; ?> !important;
        margin: 0;
      }
      #wrap_invoice .invoice_footer,
      #wrap_invoice .invoice_footer p,
      #wrap_invoice .invoice_footer .pagging{
        background: <?php echo $footer_bg_color; ?>;
        color: <?php echo $footer_txt_color; ?>;
      }
    </style>
  </div>
<?php
echo $other_config;
$etat_header = "<header class=\"invoice_header etat_header\">";
if( $show_header == "1" ){
  if( isset($company) ){
    $etat_header .= getHeaderByModel($header_model, $company, $header_text);
  }
  $etat_header .= "<hr>";
}
$etat_header .= "<div class='clearfix'></div>";
$etat_header .= "</header>";
$etat_header .= ($show_center_title?("<center><h3 class=\"page-title\">".$page_title."</h3></center>"):"");
if( VERSION == "DEMO" ){
  $etat_header .= "<div class='demo_invoice'>DEMO</div>";
}
$etat_footer = "<div style=\"clear: both;\"></div><div class=\"etat_footer\">";
if( isset($second_footer) ){
  $etat_footer .= $second_footer;
}
$etat_footer .= "<div class=\"row\">";
if( $show_signature == "1" ){
  if( $show_signature_2 ){
    $etat_footer .= "<div class=\"col-xs-4 col-xs-offset-4\">
      <p>&nbsp;</p>
      <p style=\"border-bottom: 1px solid #666;\">&nbsp;</p>
      <p class='text-md-center'>".$signature_txt."</p>
    </div>";
    $etat_footer .= "<div class=\"col-xs-4\">";
    if( trim($signature_stamp) != "" ){
      $etat_footer .= "<p style=\"text-align: center; border-bottom: 1px solid #666;\">
        <img src=\"".($signature_stamp)."\" style=\"max-width:130px; max-height:120px; margin-bottom:-15px;\" />
      </p>";
    }else{
      $etat_footer .= "<p>&nbsp;</p><p style=\"border-bottom: 1px solid #666;\">&nbsp;</p>";
    }
    $etat_footer .= "<p class='text-md-center'>".$signature_txt."</p>
    </div>";
  }else{
    $etat_footer .= "<div class=\"col-xs-4 col-xs-offset-8\">";
    if( trim($signature_stamp) != "" ){
      $etat_footer .= "<p style=\"text-align: center; border-bottom: 1px solid #666;\">
        <img src=\"".($signature_stamp)."\" style=\"max-width:130px; max-height:120px; margin-bottom:-15px;\" />
      </p>";
    }else{
      $etat_footer .= "<p>&nbsp;</p><p style=\"border-bottom: 1px solid #666;\">&nbsp;</p>";
    }
    $etat_footer .= "<p class='text-md-center'>".$signature_txt."</p>
    </div>";
  }
}

$etat_footer .= "</div><p>&nbsp;</p>";
$etat_footer .= "<div style=\"clear: both;\"></div></div>";
$final_footer = "<footer class='invoice_footer'>";
if( $show_footer == "1" ){
  if( isset($company) ){
    $final_footer .= "<hr>";
    $final_footer .= html_entity_decode($footer_text);
  }
}
$wrap_classes = array("page", $Page_size, $Page_resolution);
$warp_start = "<div id=\"wrap_invoice\" class=\"".implode(" ", $wrap_classes)."\" >";
$warp_end = "<div style=\"clear: both;\"></div></div>";
if( $dashed_line ){
  $warp_end = "<hr style='border-style:dashed; border-color:gray'>".$warp_end;
}
if( is_array($Page_content) && count($Page_content) > 1 ){
  $page_counter = 1;
  foreach ($Page_content as $innerHTML) {
    $etat_content = "<div class=\"etat_content\">".$innerHTML."</div>";
    $final_footer1 = $final_footer."<div class=\"pagging\">".($page_counter++)." / ".count($Page_content)."</div>";
    echo $warp_start;
    echo $etat_header;
    echo $etat_content;
    echo $etat_footer;
    echo $final_footer1."</footer>";
    echo $warp_end;
  }
}else{
  if( is_array($Page_content) ){
    $Page_content = $Page_content[0];
  }
  $etat_content = "<div class=\"etat_content\">".$Page_content."</div>";
  echo $warp_start;
  echo $etat_header;
  echo $etat_content;
  echo $etat_footer;
  echo $final_footer."</footer>";
  echo $warp_end;
}
?>

<?php if ( !$isPDF): ?>
<script type="text/javascript">
function setPrinterConfig(){
  resolution = $('#resolution').val()!=undefined?$('#resolution').val():"<?php echo $Page_resolution; ?>";
  rotate = $('#rotate').val()!=undefined?$('#rotate').val():"<?php echo $Page_size; ?>";

  $('.page').removeClass('A4 A5 Letter Legal');
  $('.page').addClass(resolution);
  $('.page').removeClass('portrait landscape');
  $('.page').addClass(rotate);

  w = "21cm"; h = "29.7cm";
  if( resolution == "A4" ){
    w = "21cm"; h = "29.7cm";
  }else if( resolution == "A5" ){
    w = "14.8cm"; h = "21cm";
  }else if( resolution == "Letter" ){
    w = "21.6cm"; h = "27.9cm";
  }else if( resolution == "Legal" ){
    w = "21.6cm"; h = "35.6cm";
  }
  if( rotate == "landscape" ){
    $('#pageInit').html("@page{size: "+h+" "+w+"}");
  }else{
    $('#pageInit').html("@page{size: "+w+" "+h+"}");
  }
  scaleTemplate();
};

function getPageHeight(){
  resolution = $('#resolution').val()!=undefined?$('#resolution').val():"<?php echo $Page_resolution; ?>";
  rotate = $('#rotate').val()!=undefined?$('#rotate').val():"<?php echo $Page_size; ?>";

  w = 21; h = 29.7;
  if( resolution == "A4" ){
    w = 21; h = 29.7;
  }else if( resolution == "A5" ){
    w = 14.8; h = 21;
  }else if( resolution == "Letter" ){
    w = 21.6; h = 27.9;
  }else if( resolution == "Legal" ){
    w = 21.6; h = 35.6;
  }
  if( rotate == "landscape" ){
    return w;
  }else{
    return h;
  }
};

function getPageWidth(){
  resolution = $('#resolution').val()!=undefined?$('#resolution').val():"<?php echo $Page_resolution; ?>";
  rotate = $('#rotate').val()!=undefined?$('#rotate').val():"<?php echo $Page_size; ?>";

  w = 21; h = 29.7;
  if( resolution == "A4" ){
    w = 21; h = 29.7;
  }else if( resolution == "A5" ){
    w = 14.8; h = 21;
  }else if( resolution == "Letter" ){
    w = 21.6; h = 27.9;
  }else if( resolution == "Legal" ){
    w = 21.6; h = 35.6;
  }
  if( rotate == "landscape" ){
    return h;
  }else{
    return w;
  }
};

function scaleTemplate(){
  $.each($('[id=wrap_invoice]'), function(i, wrap_invoice){
    var scale = 1;
    if( $(wrap_invoice).parent().is(".wrapper") ){
      $(wrap_invoice).unwrap();
    }
    var parent = $(wrap_invoice).parent();
    var padding = $(parent).outerWidth()-$(parent).width();
    var outer_height = $(parent).height();
    var inner_height = $(wrap_invoice).outerHeight();
    var outer_width = $(parent).width();
    var inner_width = $(wrap_invoice).outerWidth();
    if( outer_width < inner_width ){
      if( padding == 0 ){
        scale = parseFloat(outer_width/(inner_width+20));
        padding = 20;
      }else{
        scale = parseFloat(outer_width/inner_width);
        padding = 0;
      }
      var x = padding/2;
      <?php if (lang("IS_RTL")): ?>
        var x = inner_width-x;
      <?php endif ?>
      var origin = x.toFixed(2)+"px 0px 0px";
      $(wrap_invoice).css({'-webkit-transform': 'scale('+(scale.toFixed(2))+')', '-webkit-transform-origin': origin});
      var wrapper = $("<div class='wrapper'></div>");
      $(wrapper).css({'width': inner_width*scale, 'height': inner_height*scale, "overflow": "hidden"});
      $(wrap_invoice).wrap(wrapper);
    }else{
      $(wrap_invoice).css({'-webkit-transform': '', '-webkit-transform-origin': ""});
    }
  });
};

document.table_border = false;
document.table_strip = false;
<?php if( isset($table_border) && $table_border == "1" ): ?>
  document.table_border = true;
<?php endif; ?>
<?php if( isset($table_strip) && $table_strip == "1" ): ?>
  document.table_strip = true;
<?php endif; ?>

$(document).ready(function(){
  $('#wrap_invoice table').removeClass();
  $('#wrap_invoice table').addClass('table_invoice table_invoice-condensed');

  <?php if( isset($table_border) && $table_border == "1" ): ?>
    $('#wrap_invoice table').addClass('table_invoice-bordered');
  <?php endif; ?>

  <?php if( isset($table_strip) && $table_strip == "1" ): ?>
    $('#wrap_invoice table').addClass('table_invoice-striped');
  <?php endif; ?>

  <?php if( isset($auto_print) && $auto_print == "1" && !$is_preview ): ?>
    window.print();
    window.close();
    window.parent.window.close();
  <?php endif; ?>


  setPrinterConfig();
  $('body').on('keyup', function(ev){
    if( ev.keyCode == 27 ){
      $('#close_page').click();
    }
  });

  $('#close_page').click(function(){
    window.close();
    window.parent.window.close();
    return false;
  });
  <?php if (!$is_preview): ?>
  window.onresize = function() {
    scaleTemplate();
  }
  scaleTemplate();
  <?php endif ?>
});
setTimeout(function() {
  $(window).trigger("resize");
}, 100);
</script>
<?php endif ?>
<?php if($show_btn_config && !$isPDF){ ?>
</body>
</html>
<?php } ?>
