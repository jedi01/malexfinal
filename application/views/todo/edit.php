<?php
$label_params = array(
  "class" => "form-control-label"
);
$subject = array(
  'name'         => 'todo[subject]',
  'id'           => 'subject',
  'value'        => set_value("todo[subject]", $todo->subject),
  'class'        => "form-control",
  'placeholder'  => lang("subject"),
  'tabindex'     => "1",
  'autocomplete' => "off"
);
$date = array(
  "id"           => "date",
  "class"        => "form-control"
);
$date_hidden = array(
  'type'         => 'hidden',
  'name'         => 'todo[date]',
  'value'        => set_value("todo[date]", date_MYSQL_JS($todo->date)),
);
$date_due = array(
  "id"           => "date_due",
  "class"        => "form-control"
);
$date_due_hidden = array(
  'type'         => 'hidden',
  'name'         => 'todo[date_due]',
  'value'        => set_value("todo[date_due]", date_MYSQL_JS($todo->date_due)),
);
?>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<?php echo form_open("todo/edit/".$todo->id, array('class' => 'form-horizontal'));?>
<?php echo form_hidden('id', $todo->id); ?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="todo_tabs">
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_basic"><?php echo lang('basic_informations') ?></a></li>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="#tab_attachments"><?php echo lang('attachments') ?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane form-horizontal" id="tab_basic">
      <div class="row">
        <div class="col-md-6">
          <!-- SUBJECT -->
          <div class="m-a-0 form-group required">
            <?php echo lang('subject', 'subject', $label_params); ?>
            <?php echo form_input($subject); ?>
          </div>
        </div>
        <div class="col-md-6">
          <!-- PRIORITY -->
          <div class="form-group m-a-0 required">
            <?php echo lang('priority', 'priority', $label_params); ?>
            <?php echo form_dropdown('todo[priority]', $this->settings_model->getPriorities(), $todo->priority, 'class="form-control"'); ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <!-- DATE -->
          <div class="form-group required">
              <?php echo lang('date', 'date', $label_params); ?><br>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <?php
                  echo form_input($date);
                  echo form_input($date_hidden);
                ?>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <!-- DUE DATE -->
          <div class="form-group">
              <?php echo lang('date_due', 'date_due', $label_params); ?><br>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <?php
                  echo form_input($date_due);
                  echo form_input($date_due_hidden);
                ?>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <textarea class="form-control m-a-0" rows="3" name="todo[description]" id="editor_description"><?php echo $todo->description ?></textarea>
        </div>
      </div>
    </div>

    <div class="tab-pane form-horizontal" id="tab_attachments">
      <a class="btn btn-secondary attach_file" ><i class="fa fa-paperclip"></i> <?php echo lang("add_attached_file") ?></a>
      <div class="form-group m-b-0">
        <div class="attachments">
          <ul></ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>


<script type="text/javascript">
  $('#todo_tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#todo_tabs a[href="#tab_basic"]').tab('show');
  /* DATES */
  $.fn.datepicker.defaults.language = globalLang["lang"];
  $("#date, #date_due").mask(MASK_DATE,{placeholder:JS_DATE});

  $("#date").datepicker({
      "todayHighlight": true,
      "format": DATEPICKER_FORMAT
  })
  .on("changeDate", function(){
      $("#date_due").datepicker("setStartDate", $("#date").datepicker("getDate"));
  })
  .on("change", function(){
      if( $(this).datepicker("getDate") != null ){
          $('input[name="todo[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="todo[date]"]').val("");
      }
  });

  $("#date_due").datepicker({
      "todayHighlight": true,
      "clearBtn": true,
      "format": DATEPICKER_FORMAT
  })
  .on("changeDate", function(){
      $("#date").datepicker("setEndDate", $("#date_due").datepicker("getDate"));
  })
  .on("change", function(){
      if( $(this).datepicker("getDate") != null ){
          $('input[name="todo[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
      }else{
          $('input[name="todo[date_due]"]').val("");
      }
  });
  if( $('input[name="todo[date]"]').val() != "" ){
      $("#date").datepicker("setDate",date_locale($('input[name="todo[date]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#date").trigger("changeDate");
  }
  if( $('input[name="todo[date_due]"]').val() != "" ){
      $("#date_due").datepicker("setDate",date_locale($('input[name="todo[date_due]"]').val(), "en", globalLang["lang"]));
  }else{
      $("#date_due").trigger("changeDate");
  }

  // description
  tinymce.remove("#editor_description");
  tinymce.init(
    Object.assign({}, tinymce_init, {
      selector: '#editor_description',
      height: 150,
    })
  );

  // attachments
  $('.attach_file').click(function(e){
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
    e.preventDefault();
    return false;
  });
  $.attachments = {
    add: function(file){
      var index = Math.floor(Math.random() * 9999999) + 1000000 ;
      var self = this;
      var item = $('<li></li>');
      $('<span class="label label-default label-bill">'+file.extension.substring(1)+'</span> ').appendTo(item);
      $('<b> '+file.filename+file.extension+' </b>').appendTo(item);
      $('<i> ('+Format_size(file.size*1024)+') </i>').appendTo(item);
      $('<input name="todo[attachments][]" value="'+file.id+'" type="hidden">').appendTo(item);
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

  $('#subject').focus();
</script>
