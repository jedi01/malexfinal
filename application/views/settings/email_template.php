<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<div class="text-muted page-desc"><?php echo lang("template_name").": <b>".lang(substr($template_name, 0, strpos($template_name, ".tpl")))."</b>";?></div>
<hr />
<?php echo form_open("settings/update_email_template/$template_name", array('class' => 'form-horizontal'));?>
<div class="bordered_tabs">
  <ul class="nav nav-tabs" id="email_templates">
    <?php foreach ($languages as $language => $label): ?>
    <li class="nav-item"><a class="nav-link" tabindex="-1" href="<?php echo "#email_template_".$language ?>"><?php echo $label ?></a></li>
    <?php endforeach ?>
  </ul>
  <div class="tab-content">
    <?php foreach ($email_templates as $email_template): ?>
      <?php $language = $email_template['language']; ?>
      <div class="tab-pane form-horizontal p-b-0" id="<?php echo "email_template_".$language ?>">
        <div class="row form-group required">
          <label class="col-md-3 form-control-label" for="subject_<?=$language ?>"><?php echo lang('email_subject');?></label>
          <div class="col-md-9">
            <?php
              echo form_input(array(
                'name'         => "email_template[$language][subject]",
                'id'           => 'subject_'.$language,
                'value'        => $email_template['subject'],
                'placeholder'  => lang("email_subject"),
                'class'        => "form-control",
                'autocomplete' => "off"
              ));
            ?>
          </div>
        </div>
        <div class="row form-group required m-b-0">
          <div class="col-md-12" style="position: relative;">
            <?php
              echo form_textarea(array(
                'name'         => "email_template[$language][content]",
                'value'        => $email_template['content'],
                "placeholder"  => lang("email_content"),
                "class"        => "form-control email_content",
                "rows"         => 6,
                "style"        => "resize: none;"
              ));
            ?>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<div class="text-md-right">
  <hr />
  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo lang("cancel") ?></button>
  <?php echo form_submit('submit', lang('save'), array('class' => 'btn btn-primary'));?>
</div>
<?php echo form_close();?>

<script type="text/javascript">
  $('#email_templates a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  $('#email_templates a[href="#email_template_<?php echo LANGUAGE ?>"]').tab('show');

  tinymce.remove(".email_content");
  tinymce.init(
    Object.assign({}, tinymce_init_mini, {
      selector: '.email_content',
      height: 250,
      toolbar: tinymce_init_mini.toolbar+' | forecolor backcolor | <?php echo str_replace("|", " ", $email_templates[0]['data']) ?>',
      setup: function(editor) {

        editor.addButton('company', {
          type: 'menubutton',
          text: globalLang['company'],
          icon: false,
          menu: [
            { text: globalLang['name'],        onclick: function() {editor.insertContent('&nbsp;{{company_name}}&nbsp;');} },
            { text: globalLang['address'],     onclick: function() {editor.insertContent('&nbsp;{{company_address}}&nbsp;');} },
            { text: globalLang['city'],        onclick: function() {editor.insertContent('&nbsp;{{company_city}}&nbsp;');} },
            { text: globalLang['state'],       onclick: function() {editor.insertContent('&nbsp;{{company_state}}&nbsp;');} },
            { text: globalLang['postal_code'], onclick: function() {editor.insertContent('&nbsp;{{company_postal_code}}&nbsp;');} },
            { text: globalLang['country'],     onclick: function() {editor.insertContent('&nbsp;{{company_country}}&nbsp;');} },
            { text: globalLang['phone'],       onclick: function() {editor.insertContent('&nbsp;{{company_phone}}&nbsp;');} },
            { text: globalLang['email'],       onclick: function() {editor.insertContent('&nbsp;{{company_email}}&nbsp;');} },
          ]
        });

        editor.addButton('invoice', {
          type: 'menubutton',
          text: globalLang['invoice'],
          icon: false,
          menu: [
            { text: globalLang['reference'],    onclick: function() {editor.insertContent('&nbsp;{{invoice_reference}}&nbsp;');} },
            { text: globalLang['date'],         onclick: function() {editor.insertContent('&nbsp;{{invoice_date}}&nbsp;');} },
            { text: globalLang['date_due'],     onclick: function() {editor.insertContent('&nbsp;{{invoice_date_due}}&nbsp;');} },
            { text: globalLang['status'],       onclick: function() {editor.insertContent('&nbsp;{{invoice_status}}&nbsp;');} },
            { text: globalLang['total'],        onclick: function() {editor.insertContent('&nbsp;{{invoice_total}}&nbsp;');} },
            { text: globalLang['payments'],     onclick: function() {editor.insertContent('&nbsp;{{invoice_total_payments}}&nbsp;');} },
            { text: globalLang['total_due'],    onclick: function() {editor.insertContent('&nbsp;{{invoice_total_due}}&nbsp;');} },
            { text: globalLang['link'],         onclick: function() {editor.insertContent('&nbsp;{{invoice_link}}&nbsp;');} },
            { text: globalLang['overdue_days'], onclick: function() {editor.insertContent('&nbsp;{{invoice_overdue_days}}&nbsp;');} },
          ]
        });

        editor.addButton('estimate', {
          type: 'menubutton',
          text: globalLang['estimate'],
          icon: false,
          menu: [
            { text: globalLang['reference'],    onclick: function() {editor.insertContent('&nbsp;{{estimate_reference}}&nbsp;');} },
            { text: globalLang['date'],         onclick: function() {editor.insertContent('&nbsp;{{estimate_date}}&nbsp;');} },
            { text: globalLang['date_due'],     onclick: function() {editor.insertContent('&nbsp;{{estimate_date_due}}&nbsp;');} },
            { text: globalLang['status'],       onclick: function() {editor.insertContent('&nbsp;{{estimate_status}}&nbsp;');} },
            { text: globalLang['total'],        onclick: function() {editor.insertContent('&nbsp;{{estimate_total}}&nbsp;');} },
            { text: globalLang['link'],         onclick: function() {editor.insertContent('&nbsp;{{estimate_link}}&nbsp;');} },
          ]
        });

        editor.addButton('customer', {
          type: 'menubutton',
          text: globalLang['customer'],
          icon: false,
          menu: [
            { text: globalLang['company'],    onclick: function() {editor.insertContent('&nbsp;{{customer_company}}&nbsp;');} },
            { text: globalLang['fullname'],   onclick: function() {editor.insertContent('&nbsp;{{customer_fullname}}&nbsp;');} },
            { text: globalLang['phone'],      onclick: function() {editor.insertContent('&nbsp;{{customer_phone}}&nbsp;');} },
            { text: globalLang['email'],      onclick: function() {editor.insertContent('&nbsp;{{customer_email}}&nbsp;');} },
            { text: globalLang['address'],    onclick: function() {editor.insertContent('&nbsp;{{customer_address}}&nbsp;');} },
            { text: globalLang['vat_number'], onclick: function() {editor.insertContent('&nbsp;{{customer_vat_number}}&nbsp;');} },
            { text: globalLang['website'],    onclick: function() {editor.insertContent('&nbsp;{{customer_website}}&nbsp;');} },
          ]
        });

        editor.addButton('contract', {
          type: 'menubutton',
          text: globalLang['contract'],
          icon: false,
          menu: [
            { text: globalLang['subject'],       onclick: function() {editor.insertContent('&nbsp;{{contract_subject}}&nbsp;');} },
            { text: globalLang['date'],          onclick: function() {editor.insertContent('&nbsp;{{contract_date}}&nbsp;');} },
            { text: globalLang['date_due'],      onclick: function() {editor.insertContent('&nbsp;{{contract_date_due}}&nbsp;');} },
            { text: globalLang['contract_type'], onclick: function() {editor.insertContent('&nbsp;{{contract_type}}&nbsp;');} },
            { text: globalLang['description'],   onclick: function() {editor.insertContent('&nbsp;{{contract_description}}&nbsp;');} },
            { text: globalLang['reference'],     onclick: function() {editor.insertContent('&nbsp;{{contract_reference}}&nbsp;');} },
            { text: globalLang['amount'],        onclick: function() {editor.insertContent('&nbsp;{{contract_amount}}&nbsp;');} },
          ]
        });

        editor.addButton('user', {
          type: 'menubutton',
          text: globalLang['user'],
          icon: false,
          menu: [
            { text: globalLang['username'],                onclick: function() {editor.insertContent('&nbsp;{{user_username}}&nbsp;');} },
            { text: globalLang['email'],                   onclick: function() {editor.insertContent('&nbsp;{{user_email}}&nbsp;');} },
            { text: globalLang['activation_code'],         onclick: function() {editor.insertContent('&nbsp;{{user_activation_code}}&nbsp;');} },
            { text: globalLang['forgotten_password_code'], onclick: function() {editor.insertContent('&nbsp;{{user_forgotten_password_code}}&nbsp;');} },
            { text: globalLang['index_fname_th'],          onclick: function() {editor.insertContent('&nbsp;{{user_first_name}}&nbsp;');} },
            { text: globalLang['index_lname_th'],          onclick: function() {editor.insertContent('&nbsp;{{user_last_name}}&nbsp;');} },
            { text: globalLang['phone'],                   onclick: function() {editor.insertContent('&nbsp;{{user_phone}}&nbsp;');} },
            { text: globalLang['company'],                 onclick: function() {editor.insertContent('&nbsp;{{user_company}}&nbsp;');} },
          ]
        });

      },
    })
  );
</script>
