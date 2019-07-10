<?php
$sys = $this->settings_model->SYS_Settings;
$emails = array(
    "placeholder"  => lang("emails_example"),
    "class"        => "form-control ",
    "tabindex"     => "1",
    "autocomplete" => "off",
    "id"           =>"emails",
);
$subject = array(
    "placeholder"  => lang("email_subject"),
    "class"        => "form-control ",
    "id"           =>"subject",
);
$reminder_name = isset($name)?$name:lang("untitled_reminder");
$emails_list = isset($emails_list)?$emails_list:"";
$email_subject = isset($email_subject)?$email_subject:$sys->reminder_subject;
$start_date = isset($date)?date_MYSQL_JS($date):date_MYSQL_JS(date("Y-m-d"));

$repeat_types = array(
    "-1" => lang("no_repeat"),
    "0"  => lang("weekly"),
    "1"  => lang("every")." 2 ".lang("weeks"),
    "4"  => lang("every")." 3 ".lang("weeks"),
    "2"  => lang("monthly"),
    "6"  => lang("yearly"),
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
<hr />
<?php echo form_open("/calendar/add", array('class' => 'form-horizontal'));?>


<div class="bordered_tabs">
    <ul class="nav nav-tabs" id="create_reminder">
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#basic_informations"><?php echo lang('basic_informations') ?></a></li>
        <li class="nav-item"><a class="nav-link" tabindex="-1" href="#contact_informations"><?php echo lang('email') ?></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane form-horizontal" id="basic_informations">
            <div class="form-group row required">
                <label class="form-control-label col-md-3"><?php echo lang ( "name" ) ?></label>
                <div class="col-md-7">
                    <input type="text" name="event[name]" value="<?php echo $reminder_name ?>" id="add_show_name" class="form-control" placeholder="<?php echo lang("name") ?>">
                </div>
            </div>
            <div class="form-group row required">
                <label class="form-control-label col-md-3"><?php echo lang ( "date" ) ?></label>
                <div class="col-md-7">
                    <input type="text" name="event[start_date]" id="start_date" class="form-control" value="<?php echo $start_date ?>"/>
                </div>
            </div>
            <div class="form-group row required">
                <label class="form-control-label col-md-3"><?php echo lang ( "repeat" ) ?></label>
                <div class="col-md-7">
                    <?php echo form_dropdown('event[repeat_type]', $repeat_types, "-1", 'class="form-control input_select"'); ?>
                </div>
            </div>
            <div class="form-group row" id="add_show_day_check" style="display: none">
                <label class="form-control-label col-md-3"><?php echo lang ( "repeat_every" ) ?></label>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row" id="add_show_end" style="display: none">
                <label class="form-control-label col-md-3"><?php echo lang ( "end_date" ) ?></label>
                <div class="col-md-4">
                    <input type="text" disabled="disabled" id="end_date" name="event[end_date]" class="form-control" />
                </div>
                <div class="col-md-5">
                    <div class="checkbox m-a-0">
                        <label for="chbx_d_no_end">
                            <input type="checkbox" id="chbx_d_no_end" name="add_show_no_end" value="0" checked>
                            <?php echo lang ( "no_end" ) ?> ?
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane form-horizontal" id="contact_informations">
            <div class="row">
              <div class="col-md-10 col-md-offset-1 p-a-0">
                <div class="form-group m-b-0 required">
                  <?php echo lang("email_to", "emails", array("class"=>"form-control-label")) ?>
                  <?php echo form_input('event[emails]', set_value('event[emails]', $emails_list), $emails); ?>
                </div>
                <div class="form-group required">
                  <?php echo lang("email_subject", "subject", array("class"=>"form-control-label")) ?>
                  <?php echo form_input('event[subject]', set_value('event[subject]', $email_subject), $subject); ?>
                </div>
                <div class="form-group m-b-0">
                  <textarea id="additional_content" name="event[additional_content]" class="form-control" rows="4" style="resize: none;"><?php echo $sys->reminder_content ?></textarea>
                  <div class="attachments">
                    <ul>
                      <li></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('create'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script src="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"); ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"); ?>">
<script type="text/javascript">
    $('#create_reminder a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#create_reminder a[href="#basic_informations"]').tab('show');


    /* DATES */
    $.fn.datepicker.defaults.language = globalLang["lang"];
    $("#start_date, #end_date").mask(MASK_DATE,{placeholder:JS_DATE});

    $("#start_date").datepicker({
        "todayHighlight": true,
        "format": DATEPICKER_FORMAT
    })
    .on("changeDate", function(){
        $("#end_date").datepicker("setStartDate", $("#start_date").datepicker("getDate"));
    })
    .on("change", function(){
        if( $(this).datepicker("getDate") != null ){
            $('input[name="event[start_date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="event[start_date]"]').val("");
        }
    });

    $("#end_date").datepicker({
        "todayHighlight": true,
        "clearBtn": true,
        "format": DATEPICKER_FORMAT
    })
    .on("changeDate", function(){
        $("#start_date").datepicker("setEndDate", $("#end_date").datepicker("getDate"));
    })
    .on("change", function(){
        if( $(this).datepicker("getDate") != null ){
            $('input[name="event[end_date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="event[end_date]"]').val("");
        }
    });
    if( $('input[name="event[start_date]"]').val() != "" ){
        $("#start_date").datepicker("setDate",date_locale($('input[name="event[start_date]"]').val(), "en", globalLang["lang"]));
    }else{
        $("#start_date").trigger("changeDate");
    }

    $('select[name="event[repeat_type]"]').on("change", function(){
        selected = $('select[name="event[repeat_type]"]').val();
        if( selected == "-1" ){ // no repeat
            $('#add_show_day_check').hide();
            $('#add_show_end').hide();
        }else if( selected == "2" || selected == "6" ){ // monthly
            $('#add_show_day_check').hide();
            $('#add_show_end').show();
        }else{
            $('#add_show_day_check').show();
            $('#add_show_end').show();
        }
    }).trigger("change");

    $("#chbx_d_no_end").on("change", function(){
        if( $("#chbx_d_no_end").is(':checked') ){
            $('#end_date').attr("disabled", "disabled");
        }else{
            $('#end_date').removeAttr("disabled");
        }
    }).trigger("change");

    $('#emails').tagsinput();
    $.attachments = {
        add: function(file){
          var index = Math.floor(Math.random() * 9999999) + 1000000 ;
          var self = this;
          var item = $('<li></li>');
          $('<span class="label label-default label-bill">'+file.extension.substring(1)+'</span> ').appendTo(item);
          $('<b> '+file.filename+file.extension+' </b>').appendTo(item);
          $('<i> ('+Format_size(file.size*1024)+') </i>').appendTo(item);
          $('<input name="event[attachments][]" value="'+file.id+'" type="hidden">').appendTo(item);
          var quickMenu = $('<span class="quickMenu"></span>');
          $('<a href="'+SITE_URL+'/files/download/'+file.link+'"><i class="fa fa-download"></i></a>').appendTo(quickMenu);
          $('<a href="#" class="remove_attachement"><i class="fa fa-trash"></i></a>').appendTo(quickMenu);
          $(quickMenu).appendTo(item);

          $(item).appendTo($(".attachments ul"));
          $(item).find(".remove_attachement").click(function(){
              self.remove(item);
              return false;
          });
          return item;
        },
        remove : function(item){
            $(item).remove();
        },
    }
    <?php
    if (isset($attached_files)){
        foreach ($attached_files as $file){
            echo "$.attachments.add(".json_encode($file).");";
        }
    }
    ?>
    for (var day_key = 0; day_key < 7; day_key++) {
        m = new moment(day_key, "e", "en");
        day_name = m.locale("<?php echo LANG ?>").format("dddd");
        var day = $('<div class="checkbox-inline"></div>');
        var label = $('<label for="chbx_d_0'+day_key+'"><input type="checkbox" id="chbx_d_0'+day_key+'" name="event[repeat_days]['+day_key+']" value="'+day_key+'" /> '+day_name+'</label>');
        $(day).append(label);
        $('#add_show_day_check > div').append(day);
    }

    tinymce.remove("#additional_content");
    tinymce.init(Object.assign({}, tinymce_init_mini, {
        selector: '#additional_content',
        toolbar: tinymce_init_mini.toolbar+' | attach_file',
        setup: function(editor) {
            editor.addButton('attach_file', {
                type: 'button',
                text: globalLang["add_attached_file"],
                icon: "insert",
                onclick: function() {
                    $(document).sis_modal({
                        url: SITE_URL+"/files/select",
                        is_big: true,
                        callback: function(data){
                          if( data != undefined ){
                            for (var i = 0; i < data.length; i++) {
                              $.attachments.add(data[i]);
                            }
                          }
                        }
                    });
                }
            });
        },
    }));
</script>
