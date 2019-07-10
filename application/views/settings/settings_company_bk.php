<?php
$this->load->enqueue_style("assets/vendor/fileuploader/jquery.fileuploader.css", "custom");
$this->load->enqueue_script("assets/vendor/fileuploader/jquery.fileuploader.min.js");
echo $this->load->css("custom");

$name = array(
  'name'        => 'name',
  'id'          => 'name',
  'value'       => $company->name,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("name").' '.lang("is_required"),
  'autocomplete' => "off"
);
$email = array(
  'name'        => 'email',
  'id'          => 'email',
  'value'       => $company->email,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("email_address").' '.lang("is_required"),
  'autocomplete' => "off"
);
$address = array(
  'name'        => 'address',
  'id'          => 'address',
  'value'       => $company->address,
  'class'       => 'form-control',
  'required'  => 'required',
  "rows"        => "4",
  'data-error'  => lang("address").' '.lang("is_required"),
  'autocomplete' => "off"
);
$city = array(
  'name'        => 'city',
  'id'          => 'city',
  'value'       => $company->city,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("city").' '.lang("is_required"),
  'autocomplete' => "off"
);
$state = array(
  'name'     => 'state',
  'id'          => 'state',
  'value'       => $company->state,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("state").' '.lang("is_required"),
  'autocomplete' => "off"
);
$postal_code = array(
  'name'        => 'postal_code',
  'id'          => 'postal_code',
  'value'       => $company->postal_code,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("postal_code").' '.lang("is_required"),
  'autocomplete' => "off"
);
$country = array(
  'name'        => 'country',
  'id'          => 'country',
  'value'       => $company->country,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("country").' '.lang("is_required"),
  'autocomplete' => "off"
);
$phone = array(
  'name'        => 'phone',
  'id'          => 'phone',
  'value'       => $company->phone,
  'class'       => 'form-control',
  'required'  => 'required',
  'data-error'  => lang("phone").' '.lang("is_required"),
  'autocomplete' => "off"
);

$cfl1 = array(
  'name'         => 'cfl1',
  'id'           => 'cfl1',
  'value'        => set_value("cfl1", $company->cfl1),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_label")." 1",
  'autocomplete' => "off"
);
$cfv1 = array(
  'name'         => 'cfv1',
  'id'           => 'cfv1',
  'value'        => set_value("cfv1", $company->cfv1),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_value")." 1",
  'autocomplete' => "off"
);

$cfl2 = array(
  'name'         => 'cfl2',
  'id'           => 'cfl2',
  'value'        => set_value("cfl2", $company->cfl2),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_label")." 2",
  'autocomplete' => "off"
);
$cfv2 = array(
  'name'         => 'cfv2',
  'id'           => 'cfv2',
  'value'        => set_value("cfv2", $company->cfv2),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_value")." 2",
  'autocomplete' => "off"
);

$cfl3 = array(
  'name'         => 'cfl3',
  'id'           => 'cfl3',
  'value'        => set_value("cfl3", $company->cfl3),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_label")." 3",
  'autocomplete' => "off"
);
$cfv3 = array(
  'name'         => 'cfv3',
  'id'           => 'cfv3',
  'value'        => set_value("cfv3", $company->cfv3),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_value")." 3",
  'autocomplete' => "off"
);

$cfl4 = array(
  'name'         => 'cfl4',
  'id'           => 'cfl4',
  'value'        => set_value("cfl4", $company->cfl4),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_label")." 4",
  'autocomplete' => "off"
);
$cfv4 = array(
  'name'         => 'cfv4',
  'id'           => 'cfv4',
  'value'        => set_value("cfv4", $company->cfv4),
  'class'        => 'form-control',
  'placeholder'  => lang("custom_field_value")." 4",
  'autocomplete' => "off"
);

$attrib = array('class'=>'form-horizontal');
echo form_open("/settings/update_settings_company", $attrib);
?>
<!-- TITLE BAR -->
<div class="titlebar">
  <div class="row">
    <h3 class="title  col-md-6"><?php echo lang('configuration_company') ?></h3>
    <div class=" col-md-6 text-xs-right right-side">
      <button type="submit" class="btn btn-secondary btn-submit"><i class="icon-check"></i> <?php echo lang("update") ?></button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- TITLE BAR END -->
<div class="row-fluid column-seperation">
  <div class="col-md-6">
    <h4><i class="fa fa-info-circle"></i> <?php echo lang("basic_informations") ?></h4><hr>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="name"><?php echo lang("name"); ?></label>
      <div class="col-md-9"> <?php echo form_input($name);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="phone"><?php echo lang("phone"); ?></label>
      <div class="col-md-9"> <?php echo form_input($phone);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="email"><?php echo lang("email_address"); ?></label>
      <div class="col-md-9"> <?php echo form_input($email);?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="logo"><?php echo lang("logo"); ?></label>
      <div class="col-md-9">
        <input type="file" name="userfile">
        <?php
        echo form_hidden('logo', $company->logo);
        ?>
      </div>
    </div>
    <div class="row form-group">
      <label class="col-md-3 form-control-label" for="perview"><?php echo lang("perview"); ?></label>
      <div class="col-md-9">
        <img src="<?php echo base_url($company->logo) ?>" style="height:50px;" class="img-polaroid" id="perview">
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <h4><i class="fa fa-envelope"></i> <?php echo lang("contact_informations") ?></h4><hr>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="country"><?php echo lang("country"); ?></label>
      <div class="col-md-9"> <?php echo form_input($country);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="state"><?php echo lang("state"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_input('state', set_value('state', $company->state), 'class="form-control" id="state"');
        ?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="city"><?php echo lang("city"); ?></label>
      <div class="col-md-9">
        <?php
        echo form_input('city', set_value('city', $company->city), 'class="form-control" id="city"');
        ?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="postal_code"><?php echo lang("postal_code"); ?></label>
      <div class="col-md-9"> <?php echo form_input($postal_code);?>
      </div>
    </div>
    <div class="row form-group required">
      <label class="col-md-3 form-control-label" for="address"><?php echo lang("address"); ?></label>
      <div class="col-md-9"> <?php echo form_textarea($address);?>
      </div>
    </div>
  </div>
  <div class="row m-a-0">
    <h4><i class="fa fa-gears"></i> <?php echo lang("custom_fields") ?></h4><hr>
    <div class="col-md-6">
      <div class="row row-equal form-group">
        <div class="col-md-5"> <?php echo form_input($cfl1);?></div>
        <div class="col-md-7"> <?php echo form_input($cfv1);?></div>
      </div>
      <div class="row row-equal form-group">
        <div class="col-md-5"> <?php echo form_input($cfl2);?></div>
        <div class="col-md-7"> <?php echo form_input($cfv2);?></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row row-equal form-group">
        <div class="col-md-5"> <?php echo form_input($cfl3);?></div>
        <div class="col-md-7"> <?php echo form_input($cfv3);?></div>
      </div>
      <div class="row row-equal form-group">
        <div class="col-md-5"> <?php echo form_input($cfl4);?></div>
        <div class="col-md-7"> <?php echo form_input($cfv4);?></div>
      </div>
    </div>
  </div>
</div>
<?php echo form_close();?>
<script type="text/javascript">
  $(function() {
    var input = $('input[name="userfile"]').fileuploader({
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
          $('#perview').addClass('col-md-10');
          $('#perview').removeAttr("src");
          $('input[name="logo"]').val("");
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
            $('#perview').addClass('col-md-10');
            $('#perview').removeAttr("src");
            $('input[name="logo"]').val("");
            toastr.error(result.msg);
          }else{
            $('#perview').removeClass('col-md-10');
            $('#perview').attr("src", "<?php echo base_url(); ?>"+result.msg);
            $('input[name="logo"]').val(result.msg);
          }
          api.reset();
        },
      },
      captions: {
        button: function(options) { return globalLang['choose']+' ' + (options.limit == 1 ? globalLang['file'] : globalLang['files']); },
        feedback: function(options) { return globalLang['choose']+' ' + (options.limit == 1 ? globalLang['file'] : globalLang['files']) + ' '+globalLang['to_upload']; },
        feedback2: function(options) { return options.length + ' ' + (options.length > 1 ? globalLang['files_were'] : globalLang['file_was']) + ' '+globalLang['chosen']; },
        confirm: globalLang['confirm'],
        cancel: globalLang['cancel'],
        name: globalLang['filename'],
        type: globalLang['file_type'],
        size: globalLang['size'],
        dimensions: globalLang['dimensions'],
        duration: globalLang['duration'],
        crop: globalLang['crop'],
        rotate: globalLang['rotate'],
        close: globalLang['close'],
        download: globalLang['download'],
        remove: globalLang['remove'],
        drop: globalLang['drop_file'],
        paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> '+globalLang['paste_file'],
        removeConfirmation: globalLang["remove_confirmation"],
        errors: {
          filesLimit: globalLang["filesLimit"].replace("%s", "${limit}"),
          filesType: globalLang["filesType"].replace("%s", "${extensions}"),
          fileSize: "${name} "+globalLang["fileSize"].replace("%s", "${fileMaxSize}"),
          filesSizeAll: globalLang["filesSizeAll"].replace("%s", "${maxSize}"),
          fileName: globalLang["fileName"].replace("%s", "${name}") ,
          folderUpload: globalLang["folderUpload"]
        }
      }
    });
    // get API methods
    api = $.fileuploader.getInstance(input);
  });

</script>
