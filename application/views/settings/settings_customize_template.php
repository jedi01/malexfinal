<?php
$this->load->enqueue_style("assets/vendor/bootstrap.colorpickersliders/bootstrap.colorpickersliders.css", "custom");
$this->load->enqueue_script("assets/vendor/bootstrap.colorpickersliders/bootstrap.colorpickersliders.js");
$this->load->enqueue_script("assets/vendor/bootstrap.colorpickersliders/tinycolor.js");
$this->load->enqueue_script("assets/vendor/ion.rangeSlider/ion.rangeSlider.min.js");
$this->load->enqueue_style("assets/vendor/fileuploader/jquery.fileuploader.css", "custom");
$this->load->enqueue_script("assets/vendor/fileuploader/jquery.fileuploader.min.js");
$this->load->enqueue_script("assets/vendor/dom-to-image/dom-to-image.min.js");
echo $this->load->css("custom");
$header_templates = array(
  array( "title" => "Template 01", "img"=>"model1", "val"=>"model1" ),
  array( "title" => "Template 02", "img"=>"model2", "val"=>"model2" ),
  array( "title" => "Template 03", "img"=>"model3", "val"=>"model3" ),
  array( "title" => "Template 04", "img"=>"model4", "val"=>"model4" ),
  array( "title" => "Template 05", "img"=>"model5", "val"=>"model5" )
);
$fonts_list = array(
  "Serif Fonts"      => array(
  "Georgia, serif"                                       => "Georgia, serif",
  "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
  "'Times New Roman', Times, serif"                      => "'Times New Roman', Times, serif"
  ),
  "Sans-Serif Fonts" => array(
  "Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
  "'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
  "'Comic Sans MS', cursive, sans-serif"                 => "'Comic Sans MS', cursive, sans-serif",
  "Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
  "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
  "Tahoma, Geneva, sans-serif"                           => "Tahoma, Geneva, sans-serif",
  "'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
  "Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
  "'Telex', sans-serif"                                  =>"'Telex', sans-serif"
  ),
  "Monospace Fonts" => array( //
  "'Courier New', Courier, monospace"                    => "'Courier New', Courier, monospace",
  "'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace"
  )
);
$fonts_sizes = array(
  "08px" => "08 px",
  "09px" => "09 px",
  "10px" => "10 px",
  "11px" => "11 px",
  "12px" => "12 px",
  "14px" => "14 px",
  "16px" => "16 px",
  "18px" => "18 px",
  "24px" => "24 px",
  "36px" => "36 px",
);
$logo_sizes = array(
  "30%" => "30 %",
  "40%" => "40 %",
  "50%" => "50 %",
  "60%" => "60 %",
  "70%" => "70 %",
  "80%" => "80 %",
  "90%" => "90 %",
  "100%" => "100 %",
);
$margins      = explode(" ", $invoice_settings->margin);
$marginTop    = $margins[0];
$marginRight  = $margins[1];
$marginBottom = $margins[2];
$marginLeft   = $margins[3];
$selected_model = $invoice_settings->header_model;
echo form_open('/settings/customize_template', 'class="customize_template" style=" margin: 0;"');
?>
<input type="hidden" name="image_blob" value="" id="image_blob">
<div class="invoice_config card m-a-0">
  <div class="card-toggled pull-left flip p-x-1 p-y-h" style="width: 360px; min-height: 600px;">

    <!-- TITLE BAR -->
    <div class="titlebar">
      <div class="row">
        <h4 class="title col-md-6"><?php echo $page_title ?></h4>
        <div class=" col-md-6 text-xs-right right-side">
          <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update") ?></button>
        </div>
        <div class="col-md-12">
          <?php
          if( isset($create_new) ){
            echo form_input('template[name]', $invoice_settings->name, 'class="form-control"');
          }else{
            echo "<h4>".$invoice_settings->name."</h4>";
            echo form_hidden('template[name]', $invoice_settings->name);
          }
          ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <!-- TITLE BAR END -->

    <!-- CONFIGURATION -->
    <div class="card card-default m-a-0">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('template_configuration') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="invoice_default_layout"><?php echo lang('default_layout') ?></label>
          <div class="col-md-8">
            <?php
            $invoice_layouts = $this->settings_model->getPaperLayouts();
            echo form_dropdown('template[invoice_default_layout]', $invoice_layouts, $invoice_settings->invoice_default_layout, 'class="form-control" id="invoice_default_layout"');
            ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="invoice_default_size"><?php echo lang('default_size') ?></label>
          <div class="col-md-8">
            <?php
            $invoice_sizes = $this->settings_model->getPaperSizes();
            echo form_dropdown('template[invoice_default_size]', $invoice_sizes, $invoice_settings->invoice_default_size, 'class="form-control" id="invoice_default_size"');
            ?>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-8 col-md-offset-4">
            <label for="auto_print_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->auto_print == "1"): ?>checked="checked"<?php endif ?> id="auto_print_check"> <?php echo lang('auto_print') ?>
              <input type="hidden" name="template[auto_print]" value="<?php echo $invoice_settings->auto_print ?>" id="auto_print">
            </label>
          </div>
        </div>
      </div>
    </div>
    <!-- CONFIGURATION END -->
    <!-- STYLE -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('template_style_configuration') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="invoice_font"><?php echo lang('font') ?></label>
          <div class="col-md-8">
            <?php echo form_dropdown('template[invoice_font]', $fonts_list, $invoice_settings->invoice_font, 'id="invoice_font" class="form-control"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="font_size"><?php echo lang('font_size') ?></label>
          <div class="col-md-8">
            <?php echo form_dropdown('template[font_size]', $fonts_sizes, $invoice_settings->font_size, 'id="font_size" class="form-control"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="margin"><?php echo lang('margin') ?></label>
          <div class="col-md-8">
            <div class="row">
              <input type="hidden" name="template[margin]" value="<?php echo $invoice_settings->margin; ?>" id="margin">
              <div class="col-md-6 col-md-offset-3">
                <input type="number" value="<?php echo floatval($marginTop) ?>" id="marginTop" class="form-control" step="0.1" min="0" max="5" >
              </div>
              <div class="col-md-6">
                <input type="number" value="<?php echo floatval($marginLeft) ?>" id="marginLeft" class="form-control" step="0.1" min="0" max="5" >
              </div>
              <div class="col-md-6">
                <input type="number" value="<?php echo floatval($marginRight) ?>" id="marginRight" class="form-control" step="0.1" min="0" max="5" >
              </div>
              <div class="col-md-6 col-md-offset-3">
                <input type="number" value="<?php echo floatval($marginBottom) ?>" id="marginBottom" class="form-control" step="0.1" min="0" max="5" >
              </div>
            </div>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="text_color"><?php echo lang('txt_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[text_color]', $invoice_settings->text_color, ' class="color form-control" autocomplete="off" title="'.lang('select_color').'" id="text_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="primary_color"><?php echo lang('primary_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[primary_color]', $invoice_settings->primary_color, ' class="color form-control" autocomplete="off" title="'.lang('select_color').'" id="primary_color"'); ?>
          </div>
        </div>

      </div>
    </div>
    <!-- STYLE END -->
    <!-- TABLES -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('tables') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group" style="margin-bottom: 10px;">
          <div class="col-md-8 col-md-offset-4">
            <label for="table_border_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->table_border == "1"): ?>checked="checked"<?php endif ?> id="table_border_check"> <?php echo lang('bordered') ?>
              <input type="hidden" name="template[table_border]" value="<?php echo $invoice_settings->table_border ?>" id="table_border">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-8 col-md-offset-4">
            <label for="table_strip_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->table_strip == "1"): ?>checked="checked"<?php endif ?> id="table_strip_check"> <?php echo lang('striped') ?>
              <input type="hidden" name="template[table_strip]" value="<?php echo $invoice_settings->table_strip ?>" id="table_strip">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="table_line_th_height"><?php echo lang('line_th_height') ?></label>
          <div class="col-md-8">
            <input type="number" name="template[table_line_th_height]" value="<?php echo $invoice_settings->table_line_th_height ?>" id="table_line_th_height" class="form-control" step="1" min="0" max="65" >
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="table_line_td_height"><?php echo lang('line_td_height') ?></label>
          <div class="col-md-8">
            <input type="number" name="template[table_line_td_height]" value="<?php echo $invoice_settings->table_line_td_height ?>" id="table_line_td_height" class="form-control" step="1" min="0" max="65" >
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="table_line_th_bg"><?php echo lang('line_th_bg') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[table_line_th_bg]', $invoice_settings->table_line_th_bg, ' class="color form-control" autocomplete="off" title="'.lang('select_color').'" id="table_line_th_bg"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="table_line_th_color"><?php echo lang('line_th_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[table_line_th_color]', $invoice_settings->table_line_th_color, ' class="color form-control" autocomplete="off" title="'.lang('select_color').'" id="table_line_th_color"'); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- TABLES END -->
    <!-- LOGO -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('logo') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <h4><?php echo lang("logo") ?></h4>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="logo_size"><?php echo lang('size') ?></label>
          <div class="col-md-8">
            <?php echo form_dropdown('template[logo_size]', $logo_sizes, $invoice_settings->logo_size, 'id="logo_size" class="form-control"'); ?>
          </div>
        </div>
        <div class="row form-group" style="margin-bottom: 10px;">
          <div class="col-md-8 col-md-offset-4">
            <label for="logo_monocolor_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->logo_monocolor == "1"): ?>checked="checked"<?php endif ?> id="logo_monocolor_check"> <?php echo lang('monocolor') ?>
              <input type="hidden" name="template[logo_monocolor]" value="<?php echo $invoice_settings->logo_monocolor ?>" id="logo_monocolor">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-8 col-md-offset-4">
            <label for="logo_greyscale_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->logo_greyscale == "1"): ?>checked="checked"<?php endif ?> id="logo_greyscale_check"> <?php echo lang('grayscale') ?>
              <input type="hidden" name="template[logo_greyscale]" value="<?php echo $invoice_settings->logo_greyscale ?>" id="logo_greyscale">
            </label>
          </div>
        </div>
      </div>
    </div>
    <!-- LOGO END -->
    <!-- BACKGROUND -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('background') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="background_color"><?php echo lang('color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[background_color]', $invoice_settings->background_color, ' class="color form-control":"form-control hover_tip" autocomplete="off" title="'.lang('select_color').'" id="background_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="background_image_btn"><?php echo $this->lang->line('image') ?></label>
          <div class="col-md-12">
            <input type="file" name="userfile" id="background_image_btn">
            <input type="hidden" name="template[background_image]" id="background_image" value="<?php echo $invoice_settings->background_image ?>" />
          </div>
        </div>
        <div id="background_image_div" <?php echo trim($invoice_settings->background_image)==""?"style=\"display:none;\"":""; ?>>
          <div class="row form-group">
            <label class="col-md-4 form-control-label"><?php echo $this->lang->line('preview') ?></label>
            <div class="col-md-8">
              <button type="button" id="background_image_remove_btn" class="btn btn-danger p-a-h" style="position: absolute;"><i class="fa fa-close"></i></button>
              <img  id="background_image_thumb" src="<?php echo base_url($invoice_settings->background_image) ?>" class="img-thumbnail">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-4 form-control-label"><?php echo $this->lang->line('position') ?></label>
            <div class="col-md-8">
              <input type="hidden" name="template[background_position]" id="background_position" value="<?php echo $invoice_settings->background_position; ?>">
              <table id="align_table" class="align_table">
                <tbody>
                  <tr>
                    <td><a href="javascript:void(0)" id="linkalign_left_top" data-hor="left" data-vert="top"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_center_top" data-hor="center" data-vert="top"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_right_top" data-hor="right" data-vert="top"></a></td>
                  </tr>
                  <tr>
                    <td><a href="javascript:void(0)" id="linkalign_left_middle" data-hor="left" data-vert="center"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_center_middle" data-hor="center" data-vert="center"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_right_middle" data-hor="right" data-vert="center"></a></td>
                  </tr>
                  <tr>
                    <td><a href="javascript:void(0)" id="linkalign_left_bottom" data-hor="left" data-vert="bottom"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_center_bottom" data-hor="center" data-vert="bottom"></a></td>
                    <td><a href="javascript:void(0)" id="linkalign_right_bottom" data-hor="right" data-vert="bottom"></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-4 form-control-label"><?php echo $this->lang->line('fit') ?></label>
            <div class="col-md-8">
              <input type="hidden" name="template[background_fit]" id="background_fit" value="<?php echo $invoice_settings->background_fit; ?>">
              <div class="btn-group" id="background_fit_btns" data-toggle="buttons-radio">
                <button type="button" class="btn p-x-h btn-primary" data-value="initial"><i class="fa fa-picture-o"></i></button>
                <button type="button" class="btn p-x-h btn-primary" data-value="contain"><i class="fa fa-arrows-h"></i></button>
                <button type="button" class="btn p-x-h btn-primary" data-value="cover"><i class="fa fa-arrows-v"></i></button>
                <button type="button" class="btn p-x-h btn-primary" data-value="100% 100%"><i class="fa fa-arrows-alt"></i></button>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-4 form-control-label"><?php echo $this->lang->line('opacity') ?></label>
            <div class="col-md-8">
              <input type="number" name="template[background_opacity]" id="background_opacity" min="0" max="1" step="0.1" value="<?php echo floatval($invoice_settings->background_opacity); ?>" class="form-control" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- BACKGROUND END -->
    <!-- HEADER -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('header') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label"></label>
          <div class="col-md-8">
            <label for="show_header_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->show_header == "1"): ?>checked="checked"<?php endif ?> id="show_header_check"> <?php echo lang('show_header') ?>
              <input type="hidden" name="template[show_header]" value="<?php echo $invoice_settings->show_header ?>" id="show_header_hidden">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label"><?php echo lang('bg_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[header_bg_color]', $invoice_settings->header_bg_color, ' class="color form-control col-md-10":"form-control col-md-4 hover_tip" title="'.lang('header_bg_color').'" autocomplete="off" id="header_bg_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label"><?php echo lang('txt_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[header_txt_color]', $invoice_settings->header_txt_color, ' class="color form-control col-md-10":"form-control col-md-4 hover_tip" title="'.lang('header_txt_color').'" autocomplete="off" id="header_txt_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label"><?php echo lang('template') ?></label>
          <div class="col-md-8">
              <div class="thumbnails header_model">
                <div id="header_model_carousel" class="carousel slide">
                  <div class="carousel-inner">
                    <?php foreach ($header_templates as $template): ?>
                    <li class="model-item item <?php if ($selected_model==$template['val']): ?>active<?php endif ?>">
                      <div class="thumbnail">
                        <img  src="<?php echo base_url('assets/img/invoice header models/'.$template["img"].'.png') ?>" alt="">
                        <input type="radio" name="template[header_model]" value="<?php echo $template['val'] ?>" style="display:none;" <?php if ($selected_model==$template['val']): ?>checked="checked"<?php endif ?>>
                      </div>
                    </li>
                    <?php endforeach ?>
                  </div>
                  <a class="left carousel-control" href="#header_model_carousel" data-slide="prev">‹</a>
                  <a class="right carousel-control" href="#header_model_carousel" data-slide="next">›</a>
                </div>
              </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="editor_header_text"><?php echo lang('header_text') ?></label>
          <div class="col-md-12">
            <textarea name="template[header_text]" id="editor_header_text"><?php echo $invoice_settings->header_text ?></textarea>
          </div>
        </div>
      </div>
    </div>
    <!-- HEADER END -->
    <!-- FOOTER -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('footer') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="show_footer_check"></label>
          <div class="col-md-8">
            <label for="show_footer_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->show_footer == "1"): ?>checked="checked"<?php endif ?> id="show_footer_check"> <?php echo lang('show_footer') ?>
              <input type="hidden" name="template[show_footer]" value="<?php echo $invoice_settings->show_footer ?>" id="show_footer">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="footer_bg_color"><?php echo lang('bg_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[footer_bg_color]', $invoice_settings->footer_bg_color, ' class="color form-control col-md-10":"form-control col-md-4 hover_tip" title="'.lang('footer_bg_color').'" autocomplete="off" id="footer_bg_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="footer_txt_color"><?php echo lang('txt_color') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[footer_txt_color]', $invoice_settings->footer_txt_color, ' class="color form-control col-md-10":"form-control col-md-4 hover_tip" title="'.lang('footer_txt_color').'" autocomplete="off" id="footer_txt_color"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="editor_footer_text"><?php echo lang('footer_text') ?></label>
          <div class="col-md-12">
            <textarea name="template[footer_text]" id="editor_footer_text"><?php echo $invoice_settings->footer_text ?></textarea>
          </div>
        </div>
      </div>
    </div>
    <!-- FOOTER END -->
    <!-- SIGNATURE -->
    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
      <div class="card-header p-y-q small font-weight-bold">
        <?php echo lang('signature') ?><div class="pull-right flip"><i class="icon-arrow-down"></i></div>
      </div>
      <div class="card-block" style="display: none;">
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="show_signature_check"></label>
          <div class="col-md-8">
            <label for="show_signature_check" style="line-height:30px;">
              <input type="checkbox" <?php if ($invoice_settings->show_signature == "1"): ?>checked="checked"<?php endif ?> id="show_signature_check"> <?php echo lang('show_footer') ?>
              <input type="hidden" name="template[show_signature]" value="<?php echo $invoice_settings->show_signature ?>" id="show_signature">
            </label>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label required" for="signature_txt"><?php echo lang('signature_txt') ?></label>
          <div class="col-md-8">
            <?php echo form_input('template[signature_txt]', $invoice_settings->signature_txt, ' class="form-control col-md-10":"form-control col-md-4 hover_tip" title="'.lang('signature_txt').'" autocomplete="off" id="signature_txt"'); ?>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-md-4 form-control-label" for="signature_stamp_file"><?php echo $this->lang->line('stamp') ?></label>
          <div class="col-md-12">
            <input type="file" name="userfile" id="signature_stamp_file">
            <input type="hidden" name="template[signature_stamp]" id="signature_stamp" value="<?php echo $invoice_settings->signature_stamp ?>" />
          </div>
        </div>
        <div class="row form-group" id="signature_stamp_preview" <?php echo trim($invoice_settings->signature_stamp)==""?"style=\"display:none;\"":""; ?>>
          <label class="col-md-4 form-control-label"><?php echo $this->lang->line('preview') ?></label>
          <div class="col-md-8">
            <button type="button" id="signature_stamp_remove_btn" class="btn btn-danger p-a-h" style="position: absolute;"><i class="fa fa-close"></i></button>
            <img  id="signature_stamp_thumb" src="<?php echo base_url($invoice_settings->signature_stamp) ?>" class="img-thumbnail">
          </div>
        </div>
      </div>
    </div>
    <!-- SIGNATURE END -->

  </div>
  <div class="well m-a-0 pull-left flip p-a-0">
    <div class="preview">
      <div class="zoom">
        <input type="text" id="zoom" value="">
      </div>
      <div class="invoice_preview"></div>
      <div id="loading_preview" style="display: none;">
        <div class="black_background"></div><div class="loader_img"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(function() {
  var input = $('input[name="userfile"]#background_image_btn').fileuploader({
    limit:1,
    maxSize: 500,
    extensions: ['jpg', 'jpeg', 'png', 'gif'],
    enableApi: true,
    upload: {
      url: '<?php echo site_url("settings/media_upload") ?>',
      data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
      type: 'POST',
      dataType: 'JSON',
      enctype: 'multipart/form-data',
      start: true,
      synchron: true,
      beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
      },
      onSuccess: function(data, item, listEl, parentEl, newInputEl, inputEl, textStatus, jqXHR) {
        item.html.find('.column-actions').append(
          '<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>'
        );
        setTimeout(function() {
          item.html.find('.progress-bar2').fadeOut(400);
        }, 400);
      },
      onError: function(item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {
        var progressBar = item.html.find('.progress-bar2');
        if(progressBar.length > 0) {
          progressBar.find('span').html(0 + "%");
          progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
          item.html.find('.progress-bar2').fadeOut(400);
        }
        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
          '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
        ) : null;
        $('#background_image').val("").change();
        $('#background_image_thumb').attr("src", "");
        $('#background_image_div').slideUp();
      },
      onProgress: function(data, item, listEl, parentEl, newInputEl, inputEl) {
        var progressBar = item.html.find('.progress-bar2');
        if(progressBar.length > 0) {
          progressBar.show();
          progressBar.find('span').html(data.percentage + "%");
          progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
        }
      },
      onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
        result = JSON.parse(jqXHR.responseText);
        if( result.type == "ERROR" ){
          $('#background_image').val("").change();
          $('#background_image_thumb').attr("src", "");
          $('#background_image_div').slideUp();
        }else{
          $('#background_image').val(result.msg).change();
          $('#background_image_thumb').attr("src", "<?php echo base_url(); ?>"+result.msg);
          $('#background_image_div').slideDown();
        }
        api.reset();
      },
    },
    captions: UploaderCaptions
  });
  // get API methods
  api = $.fileuploader.getInstance(input);


  // STAMP
  var input2 = $('input[name="userfile"]#signature_stamp_file').fileuploader({
    limit:1,
    maxSize: 500,
    extensions: ['jpg', 'jpeg', 'png', 'gif'],
    enableApi: true,
    upload: {
      url: '<?php echo site_url("settings/media_upload") ?>',
      data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
      type: 'POST',
      dataType: 'JSON',
      enctype: 'multipart/form-data',
      start: true,
      synchron: true,
      beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
      },
      onSuccess: function(data, item, listEl, parentEl, newInputEl, inputEl, textStatus, jqXHR) {
        item.html.find('.column-actions').append(
          '<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>'
        );
        setTimeout(function() {
          item.html.find('.progress-bar2').fadeOut(400);
        }, 400);
      },
      onError: function(item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {
        var progressBar = item.html.find('.progress-bar2');
        if(progressBar.length > 0) {
          progressBar.find('span').html(0 + "%");
          progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
          item.html.find('.progress-bar2').fadeOut(400);
        }
        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
          '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
        ) : null;
        $('#signature_stamp').val("").change();
        $('#signature_stamp_thumb').attr("src", "");
        $('#signature_stamp_preview').hide();
      },
      onProgress: function(data, item, listEl, parentEl, newInputEl, inputEl) {
        var progressBar = item.html.find('.progress-bar2');
        if(progressBar.length > 0) {
          progressBar.show();
          progressBar.find('span').html(data.percentage + "%");
          progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
        }
      },
      onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
        result = JSON.parse(jqXHR.responseText);
        if( result.type == "ERROR" ){
          $('#signature_stamp').val("").change();
          $('#signature_stamp_thumb').attr("src", "");
          $('#signature_stamp_preview').hide();
        }else{
          $('#signature_stamp').val(result.msg).change();
          $('#signature_stamp_thumb').attr("src", "<?php echo base_url(); ?>"+result.msg);
          $('#signature_stamp_preview').show();
        }
        api.reset();
      },
    },
    captions: UploaderCaptions
  });
  // get API methods
  api = $.fileuploader.getInstance(input2);

  $('#align_table a').click(function(){
    hor = $(this).data('hor');
    vert = $(this).data('vert');
    position = hor + " " + vert;
    $(this).parents('table').find('a').removeClass("selected");
    $(this).addClass("selected");
    $(this).parents('table').prev('input').val(position).change();
  });

  $.each($('#align_table'), function(i, align_table){
    position = $(align_table).prev('input');
    if( position != undefined ){
      position = $(position).val();
      if( position != undefined && position.length != 0 && position.indexOf(" ") != -1 ){
        position = position.split(" ");
        hor = position[0];
        vert = position[1];
        $(align_table).find('a').removeClass("selected");
        $(align_table).find('a[data-hor="'+hor+'"][data-vert="'+vert+'"]').addClass("selected");
      }
    }
  });

  $('#background_fit_btns button').click(function(){
    value = $(this).data('value');
    $(this).parents('#background_fit_btns').prev('input').val(value).change();
  });

  $.each($('#background_fit_btns'), function(i, btn_group){
    fit = $(btn_group).prev('input');
    if( fit != undefined ){
      fit = $(fit).val();
      if( fit != undefined && fit.length != 0 ){
        $(btn_group).find('button').removeClass("active");
        $(btn_group).find('button[data-value="'+fit+'"]').addClass("active");
      }
    }
  });

  $('#background_image_remove_btn').click(function(){
    $('#background_image').val(" ").change();
    $('#background_image_thumb').attr("src", "");
    $('#background_image_div').slideUp();
  });

  $('#signature_stamp_remove_btn').click(function(){
    $('#signature_stamp').val("").change();
    $('#signature_stamp_thumb').attr("src", "");
    $('#signature_stamp_preview').hide();
  });

  tinymce.remove("#editor_header_text, #editor_footer_text");
  tinymce.init(
    Object.assign({}, tinymce_init_mini, {
      selector: '#editor_header_text, #editor_footer_text',
      height: 100,
      toolbar: tinymce_init_mini.toolbar+' | company_btns template',
      plugins: tinymce_init_mini.plugins+' template',
      setup: function(editor) {
        editor.on("change", function () {
          var content = editor.getContent();
          $('#'+editor.id).val(content);
          $('.preview .invoice_preview').refreshPreviewTemplate();
        });
        editor.addButton('company_btns', {
          type: 'menubutton',
          text: '<?php echo lang('company'); ?>',
          icon: false,
          menu: [
            { text: '<?php echo lang('name'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_name]&nbsp;');} },
            { text: '<?php echo lang('address'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_address]&nbsp;');} },
            { text: '<?php echo lang('city'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_city]&nbsp;');} },
            { text: '<?php echo lang('state'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_state]&nbsp;');} },
            { text: '<?php echo lang('postal_code'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_postal_code]&nbsp;');} },
            { text: '<?php echo lang('country'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_country]&nbsp;');} },
            { text: '<?php echo lang('phone'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_phone]&nbsp;');} },
            { text: '<?php echo lang('email'); ?>', onclick: function() {editor.insertContent('&nbsp;[company_email]&nbsp;');} },
            <?php if (isset($company->cfl1) && !empty($company->cfl1)): ?>
            { text: '<?php echo $company->cfl1; ?>', onclick: function() {editor.insertContent('&nbsp;[company_<?php echo strtolower(trim(str_replace(" ", "_", $company->cfl1))); ?>]&nbsp;');} },
            <?php endif ?>
            <?php if (isset($company->cfl2) && !empty($company->cfl2)): ?>
            { text: '<?php echo $company->cfl2; ?>', onclick: function() {editor.insertContent('&nbsp;[company_<?php echo strtolower(trim(str_replace(" ", "_", $company->cfl2))); ?>]&nbsp;');} },
            <?php endif ?>
            <?php if (isset($company->cfl3) && !empty($company->cfl3)): ?>
            { text: '<?php echo $company->cfl3; ?>', onclick: function() {editor.insertContent('&nbsp;[company_<?php echo strtolower(trim(str_replace(" ", "_", $company->cfl3))); ?>]&nbsp;');} },
            <?php endif ?>
            <?php if (isset($company->cfl4) && !empty($company->cfl4)): ?>
            { text: '<?php echo $company->cfl4; ?>', onclick: function() {editor.insertContent('&nbsp;[company_<?php echo strtolower(trim(str_replace(" ", "_", $company->cfl4))); ?>]&nbsp;');} },
            <?php endif ?>
          ]
        });
      },
      templates: [
        { title: 'Header', content: '<h4>[company_name]</h4><p>[company_address], [company_city], [company_postal_code] [company_state], [company_country] <br><b>'+globalLang['phone']+':</b> [company_phone] <b><br>'+globalLang['email']+': </b>[company_email]</p>' },
        { title: 'Footer', content: '[company_name] &copy; 2017' }
      ],
    })
  );

  $('#header_model_carousel').carousel({
    interval: 0
  });
  $('#header_model_carousel').bind('slid', function(){
    $('.model-item [name="template[header_model]"]').prop('checked',false);
    $('.model-item.active  [name="template[header_model]"]').prop('checked',true);
    $('.preview .invoice_preview').refreshPreviewTemplate();
  });

  function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  var waiting = 500;
  var last_send_time = 0;
  var send_ajax_Timeout = undefined;
  $.fn.refreshPreviewTemplate = function(){
      var self = this;
      if( waiting == 0 ){
        $(self).refreshPreviewTemplateAjax();
      }else{
        var time_now = new Date().getTime();
        var waiting_time = (time_now - last_send_time);
        if( waiting_time >= waiting ){
          $(self).refreshPreviewTemplateAjax();
          last_send_time = time_now;
          clearInterval(send_ajax_Timeout);
          send_ajax_Timeout = undefined;
          return;
        }
        if( send_ajax_Timeout != undefined){
          return;
        }
        if( waiting_time < waiting ){
          send_ajax_Timeout = setInterval(function() {
            $(self).refreshPreviewTemplate();
          }, waiting_time );
        }
      }
  };

  var global_zoom = undefined;
  $.fn.refreshPreviewTemplateAjax = function(){
    self = this;
    adata = $('form.customize_template').serialize();
    adata += "&"+$.param({"template[content]":$('#default_content').html()});
    $.ajax({
      url: SITE_URL+'/settings/invoice_template',
      data : adata,
      async: false,
      type: 'POST',
      beforeSend: function(){
        $('.preview').addClass('loading');
        $('.preview #loading_preview').fadeIn('fast');
      },
      success : function(data){
        self.html(data);
        if( global_zoom == undefined ){
          setTimeout(function() {
            setPreviewSize();
          }, 50);
        }else{
          scale_preview(global_zoom);
        }
      },
      complete: function(){
        $('.preview #loading_preview').fadeOut('fast',function(){$('.preview').removeClass('loading')});
      }
    });

  }
  $('#show_header_check').change(function(){
    if( !this.checked ){ $('#show_header_hidden').val('2');
    }else{ $('#show_header_hidden').val('1');}
  });
  $('#show_footer_check').change(function(){
    if( !this.checked ){ $('#show_footer').val('2');
    }else{ $('#show_footer').val('1'); }
  });
  $('#show_signature_check').change(function(){
    if( !this.checked ){ $('#show_signature').val('2');
    }else{ $('#show_signature').val('1'); }
  });
  $('#table_border_check').change(function(){
    if( !this.checked ){ $('#table_border').val('2');
    }else{ $('#table_border').val('1'); }
  });
  $('#table_strip_check').change(function(){
    if( !this.checked ){ $('#table_strip').val('2');
    }else{ $('#table_strip').val('1'); }
  });
  $('#auto_print_check').change(function(){
    if( !this.checked ){ $('#auto_print').val('2');
    }else{ $('#auto_print').val('1'); }
  });
  $('#logo_greyscale_check').change(function(){
    if( !this.checked ){ $('#logo_greyscale').val('0');
    }else{ $('#logo_greyscale').val('1'); }
  });
  $('#logo_monocolor_check').change(function(){
    if( !this.checked ){ $('#logo_monocolor').val('0');
    }else{ $('#logo_monocolor').val('1'); }
  });




  $('#marginTop, #marginBottom, #marginLeft, #marginRight').change(function(){
    $('#margin').val($("#marginTop").val()+"cm "+$("#marginRight").val()+"cm "+$("#marginBottom").val()+"cm "+$("#marginLeft").val()+"cm");
  });


  $('form.customize_template input:not(#zoom), form.customize_template select').change(function(){
    $('.preview .invoice_preview').refreshPreviewTemplate();
  });

  $(".color").ColorPickerSliders({
    size: 'sm',
    placement: 'right',
    swatches: false,
    previewformat: 'hex',
    flat: false,
    order: {
      rgb:1,
      opacity:false
    },
    hsvpanel: true,
    sliders: false,
    onhide: function(){
      $('.preview .invoice_preview').refreshPreviewTemplate();
    }
  });
  $('#invoice_template_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });


  function scale_preview(zoom){
    var preview = $('.preview .invoice_preview');
    var wrap_invoice = $(preview).find('#wrap_invoice');
    var scale = 1;
    if( zoom == undefined ){
      var parent = $(wrap_invoice).parent();
      var outer_height = $(parent).height();
      var inner_height = $(wrap_invoice).outerHeight();
      var outer_width = $(parent).width();
      var inner_width = $(wrap_invoice).outerWidth();
      scale = parseFloat(outer_width/inner_width);
      scale = Math.min(1, scale);
      var slider = $("#zoom").data("ionRangeSlider");
      slider.update({
        from: scale*100
      });
    }else{
      scale = zoom / 100;
    }
    var inner_width = $(wrap_invoice).outerWidth();
    var inner_height = $(wrap_invoice).outerHeight();
    $(wrap_invoice).parents(".wrapper").css({'width': inner_width*scale, 'height': inner_height*scale, "overflow": "hidden"});
    if( $(wrap_invoice).parent().is(".wrapper") ){
      var wrapper = $(wrap_invoice).parents(".wrapper");
    }else{
      var wrapper = $("<div class='wrapper'></div>");
      $(wrap_invoice).wrap(wrapper);
    }
    global_zoom = scale*100;
    var x = 0;
    <?php if (lang("IS_RTL")): ?>
      x = inner_width;
    <?php endif ?>
    var origin = x.toFixed(2)+"0px 0px 0px";
    $(wrap_invoice).css({'-webkit-transform': 'scale('+(scale.toFixed(2))+')', '-webkit-transform-origin': origin});
    $(wrapper).css({'width': inner_width*scale, 'height': inner_height*scale, "overflow": "hidden"});
    createScreenShot();
  };

  $("#zoom").ionRangeSlider({
    min: 1,
    max: 100,
    prefix: "%",
    onChange: function(x){
      scale_preview(x.from);
    }
  });

  var SCREENSHOT = ""; var WAIT_SCREENSHOT = false;
  $('form.customize_template .btn-submit').click(function(){
    if( SCREENSHOT == "" ){
      WAIT_SCREENSHOT = true;
      createScreenShot();
    }
    $('#image_blob').val(SCREENSHOT);
    return !WAIT_SCREENSHOT;
  });

  function createScreenShot(){
    var node = $('#wrap_invoice').parent('.wrapper').get(0);
    domtoimage.toJpeg(node)
    .then(function (dataUrl) {
      //$('#image_blob').val(dataUrl);
      SCREENSHOT = dataUrl;
      if( WAIT_SCREENSHOT ){
        WAIT_SCREENSHOT = false;
        $('form.customize_template .btn-submit').click();
      }
    }).catch(function(e){
      console.log(e);
    });
  }

  $('.preview .invoice_preview').bind("contextmenu",function(e){
    return false;
  });
  $('.preview .invoice_preview').bind("selectstart",function(e){
    return false;
  });
  $('.preview .invoice_preview').refreshPreviewTemplate();

  function setPreviewSize(){
    if( $('.invoice_config').innerWidth() <= 768 ){
      var w = $('.invoice_config').innerWidth();
      $('.preview').parent(".well").css({'width':w});
      $('.invoice_config .card-toggled').css({'width':w, "min-height":""});
    }else{
      var w = $('.invoice_config').innerWidth() - $('.invoice_config .card-toggled').innerWidth();
      var h = $('.invoice_config .card-toggled').height();
      var mh = $(window).height() - 90;
      $('.invoice_config .card-toggled').css({'min-height':mh});
      $('.preview').parent(".well").css({'width':w, 'height': h, 'min-height':mh});
    }
    scale_preview(global_zoom);
  }

  window.onresize = function() {
    setPreviewSize();
  }

  $('.card-toggled .card-header').on("click", function(){
    $(this).find("i").toggleClass("icon-arrow-up");
    $(this).parent().find('.card-block').slideToggle(function(){
      setPreviewSize();
    });
  });
});
</script>






<!-- DEFAULT CONTENT -->
<div id="default_content" style="display:none;">
  <div class="row text-md-center">
    <div class="col-sm-3">
      <h3 class="inv col"><b><?php echo lang("invoice_no"); ?></b><br>0010</h3>
    </div>
    <div class="col-sm-3">
      <h3 class="inv col"><b><?php echo lang("reference"); ?></b><br>INV-170010</h3>
    </div>
    <div class="col-sm-3">
      <h3 class="inv col"><b><?php echo lang("date"); ?></b><br>09/07/2017</h3>
    </div>
    <div class="col-sm-3">
      <h3 class="inv col"><b><?php echo lang("date_due"); ?></b><br>31/07/2017</h3>
    </div>
  </div>
  <hr><br><div class="row inv">
    <div class="col-sm-12">
      <h4><?php echo lang("customer_bill_to") ?></h4>
    </div>
    <div class="col-sm-6">
      <h3 class="inv"> bessem zitouni</h3>
    <b><?php echo lang("address") ?>:</b> 08 Rue Kahlalache Lakhdar Ain Lahdjar - Setif 19018 Algerie,<br></div>
    <div class="col-sm-6">
    <b><?php echo lang("phone") ?>:</b> +213778681799<br><b><?php echo lang("email") ?>:</b> bessemzitouni@gmail.com    </div>
    <div style="clear: both;"></div>
  </div>
  <br><h3 class="inv"><?php echo lang("invoice_items"); ?></h3>
  <table class="table_invoice table_invoice-condensed table_invoice-striped" style="margin-bottom: 5px;">
    <thead>
      <tr>
        <th><?php echo lang("n°"); ?></th>
        <th><?php echo lang("description"); ?> (<?php echo lang("code"); ?>)</th>
        <th><?php echo lang("quantity"); ?></th>
        <th><?php echo lang("unit_price"); ?></th>
        <th><?php echo lang("total"); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr><td class="text-md-center">1</td><td class="text-md-left">Sony vaio (Pc Portable)</td><td class="text-md-center">2.00</td><td class="text-md-center">500,00 $</td><td class="text-md-center">1 000,00 $</td></tr>
      <tr><td class="text-md-center">2</td><td class="text-md-left">Wireless Alfa + Decoder</td><td class="text-md-center">1.00</td><td class="text-md-center">320,00 $</td><td class="text-md-center">320,00 $</td></tr>
      <tr><td class="text-md-center">3</td><td class="text-md-left">Flash disk</td><td class="text-md-center">5.00</td><td class="text-md-center">1,20 $</td><td class="text-md-center">6,00 $</td></tr>
      <tr><td class="text-md-center">4</td><td class="text-md-left">SkyWifi</td><td class="text-md-center">1.00</td><td class="text-md-center">35,00 $</td><td class="text-md-center">35,00 $</td></tr>
      <tr><td class="text-md-center">5</td><td class="text-md-left">Aduino</td><td class="text-md-center">10.00</td><td class="text-md-center">5,00 $</td><td class="text-md-center">50,00 $</td></tr>
      <tr><td colspan="4" class="text-md-right font-weight-bold"><?php echo lang("subtotal"); ?></td><td class="text-md-right font-weight-bold">1 411,00 $</td></tr>
      <tr><td colspan="4" class="text-md-right font-weight-bold"><?php echo lang("global_tax"); ?></td><td class="text-md-right font-weight-bold">(17%) 239,87 $</td></tr>
      <tr><td colspan="4" class="text-md-right font-weight-bold"><?php echo lang("total"); ?></td><td class="text-md-right font-weight-bold">1 650,87 $</td></tr>
    </tbody>
  </table>
  <div class="col-sm-12">
    <p></p><p>Note: this is preview invoice</p>
  </div>
</div>
