<?php
$link = site_url("files/view/".$files_link);
$download = site_url("files/download/".$files_link);
$direct = count($files)==1?site_url("files/get/".$files_link):false;
$filenames = array();
foreach ($files as $file) {
  $filenames[] = $file->filename;
}
$title = implode(", ", $filenames);
if( count($files) == 1 && $files[0]->thumb != NULL && !empty($files[0]->thumb) ){
  $image = site_url("files/get/".$files[0]->link);
  $embed = htmlentities('<a href="'.$link.'" target="_blank"><img src="'.$image.'" border="0" alt="'.$files[0]->filename.'" /></a>');
  $forum = '[URL='.$link.'][IMG]'.$image.'[/IMG][/URL]';
}else{
  $image = false;
  $embed = htmlentities('<a href="'.$link.'" target="_blank">'.implode(", ", $filenames).'</a>');
  $forum = '[URL='.$link.']'.implode(", ", $filenames).'[/URL]';
}
$emails = array(
    "placeholder" => lang("emails_example"),
    "class" => "form-control ",
    "tabindex" => "1",
    "autocomplete" => "off",
    "id" =>"emails",
);
$additional_content = array(
    "name" => "additional_content",
    "value" => set_value("additional_content", ""),
    "placeholder" => lang("additional_content"),
    "class" => "form-control",
    "rows" => 4,
    "style" => "resize: none;",
    "id" => "additional_content"
);
?>
<?php if ($image): ?>
  <meta property="og:image" content="<?php echo $image ?>">
<?php endif ?>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><i class="fa fa-share-alt"></i> <b><?php echo $page_title ?></b>
  <small class="text-muted"><?php echo (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files"); ?></small>
</h5>
<hr />
<div class="row">
  <div class="col-md-12">
    <div class="form-group ">
      <div class="input-group">
        <?php echo form_input('', $link, 'class="form-control" tabindex="1" id="link" readonly="readonly"'); ?>
        <span class="input-group-btn">
          <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
        </span>
      </div>
    </div>
    <div class="sharring"></div>
    <br>

    <div class="bordered_tabs">
      <ul class="nav nav-tabs" id="share_file">
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#share_file_email"><?php echo lang('email') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#share_file_links"><?php echo lang('links') ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="share_file_email">
          <?php echo form_open("files/email/".$files_link, array('class' => 'form-horizontal'));?>
          <p class="text-muted p-x-0"><?php echo lang("send_link_via_email") ?></p>
          <div class="form-group">
            <?php echo form_input('emails', set_value('emails', ""), $emails); ?>
          </div>
          <div class="form-group">
            <?php echo form_textarea($additional_content); ?>
          </div>
          <div class="text-md-right">
            <?php echo form_submit('submit', lang('send'), array('class' => 'btn btn-primary'));?>
          </div>
          <?php echo form_close();?>
        </div>
        <div class="tab-pane form-horizontal" id="share_file_links">
          <div class="col-md-12">
            <!-- View Link -->
            <div class="row form-group">
              <label class="form-control-label col-md-3"><?php echo lang("view_link") ?></label>
              <div class="input-group col-md-9">
                <input type="text" value="<?php echo $link ?>" readonly="readonly" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
                </span>
              </div>
            </div>
            <!-- Direct Link -->
            <?php if ($direct): ?>
            <div class="row form-group">
              <label class="form-control-label col-md-3"><?php echo lang("direct_link") ?></label>
              <div class="input-group col-md-9">
                <input type="text" value="<?php echo $direct ?>" readonly="readonly" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
                </span>
              </div>
            </div>
            <?php endif ?>
            <!-- Download Link -->
            <div class="row form-group">
              <label class="form-control-label col-md-3"><?php echo lang("download_link") ?></label>
              <div class="input-group col-md-9">
                <input type="text" value="<?php echo $download ?>" readonly="readonly" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
                </span>
              </div>
            </div>
            <hr>
            <!-- HTML Embed Code -->
            <div class="row form-group">
              <label class="form-control-label col-md-3"><?php echo lang("html_embed_code") ?></label>
              <div class="input-group col-md-9">
                <input type="text" value="<?php echo $embed ?>" readonly="readonly" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
                </span>
              </div>
            </div>
            <!-- Forum Embed Code -->
            <div class="row form-group">
              <label class="form-control-label col-md-3"><?php echo lang("forum_embed_code") ?></label>
              <div class="input-group col-md-9">
                <input type="text" value="<?php echo $forum ?>" readonly="readonly" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
                </span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("ok") ?></button>
</div>

<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/vendor/jquery.floating-social-share/jquery.floating-social-share.js") ?>"></script>
<script type="text/javascript">
$('#emails').tagsinput();
$(".sharring").floatingSocialShare({
  place: "top-left",
  counter: false,
  twitter_counter: false,
  buttons: [
    "facebook", "google-plus", "twitter", "whatsapp", "pinterest", "reddit", "tumblr", "viber"
  ],
  text: '',
  title: "<?php echo $title ?>",
  url: "<?php echo $link ?>",
  text_title_case: false,
  description: $('meta[name="description"]').attr("content"),
  media: $('meta[property="og:image"]').attr("content")
});
$('.copy-button').click(function(){
  copy_text($(this).closest(".form-group").find(".form-control").val());
});
$('#share_file a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
$('#share_file a[href="#share_file_email"]').tab('show');
</script>
