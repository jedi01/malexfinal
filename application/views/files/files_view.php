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
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<style type="text/css">
.carousel{
  position: relative;
  visibility: hidden;
}
.carousel-control {
  position: absolute;
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
  position: absolute;
  width: 100%;
}
.carousel-inner .item{
  width: 100%;
  height: 100%;
  position: relative;
}
</style>
<div class="row p-a-0 m-a-0" id="files_view">
  <div class="col-md-9 p-a-0" style="background: #242424;" id="fileCarousel">
    <center>
      <div id="carousel-id" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" style="min-height: 350px;">
          <?php foreach ($files as $index => $file): ?>
            <div class="item <?php echo $index==0?"active":"" ?>">
              <?php if (count($files)>1): ?>
                <div class="carousel-caption">
                  <strong><?php echo $file->filename.$file->extension; ?></strong>
                  (<i><?php echo $file->size ?></i>)
                </div>
              <?php endif ?>
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
                <iframe src="<?php echo site_url("files/get/".$file->link) ?>" frameborder="0" width="100%" style="min-height: 500px; height: 100%;"></iframe>
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
  </div>
  <div class="col-md-3 p-a-h">

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5 class="page-title"><i class="fa fa-eye"></i> <?php echo $page_title ?></h5>
    <hr />
    <small class="page-desc">
      <div class="text-truncate">
        <?php echo (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files"); ?> (<span class="text-muted"><?php echo $fullsize;?></span>)
      </div>
    </small>
    <hr />
      <div class="form-group ">
        <div class="input-group">
          <?php echo form_input('', $link, 'class="form-control" tabindex="1" id="link" readonly="readonly"'); ?>
          <span class="input-group-btn">
            <button class="btn btn-primary copy-button" type="button" title="<?php echo lang("copy") ?>"><i class="fa fa-link"></i></button>
          </span>
        </div>
      </div>
      <div class="sharring"></div>
  </div>
</div>

<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/vendor/jquery.floating-social-share/jquery.floating-social-share.js") ?>"></script>
<script type="text/javascript">
$("#files_view").parents(".modal-body").addClass("p-a-0");
$('#files_view').parents(".modal-dialog").css({width: "98%", margin:"1%"}, 'fast');

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
var send_by_email = $('<a title="'+globalLang['send_email']+'" class="email pop-upper btn btn-sm btn-email icon sis-modal" sis-modal="" href="'+SITE_URL+'/files/email/<?php echo $files_link ?>"></a>');
$('#floatingSocialShare > div').append(send_by_email);
$('.copy-button').click(function(){
  copy_text($(this).closest(".form-group").find(".form-control").val());
});
$('#carousel-id .carousel-inner').css({"height": ($("body").height()*0.98)+"px" });
setTimeout(function() {
  var inner_h = $('#carousel-id .carousel-inner').height();
  $('#carousel-id').on('slid.bs.carousel', function () {
    var img = $(this).find(".item.active img");
    $(img).parent().css({"padding-top": ((inner_h-$(img).height())/2)+"px"});
  });
  if( $("#carousel-id .item.active img").size() > 0 ){
    $("#carousel-id .item.active").css({"padding-top": ((inner_h-$("#carousel-id .item.active img").height())/2)+"px"});
  }
  $("#carousel-id").css("visibility","visible");
}, 150);
</script>
