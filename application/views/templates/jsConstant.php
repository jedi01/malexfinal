<?php if ($show_in == "head"): ?>
var PAGE_IS_LOADED = false;
var APP_NAME = "<?php echo APP_NAME ?>";
var APP_DESCRIPTION = "<?php echo APP_DESCRIPTION ?>";
var APP_VER = "<?php echo VERSION ?>";
var globalLang = <?php echo json_encode($this->lang->language); ?>;
var SITE_URL = "<?php echo site_url('')?>";
var BASE_URL = "<?php echo base_url('')?>";
var JS_DATE = "<?php echo JS_DATE ?>";
var MASK_DATE = "<?php echo MASK_DATE ?>";
var DATEPICKER_FORMAT = "<?php echo DATEPICKER_FORMAT ?>";
var SUGGESTION_LENGTH = <?php echo SUGGESTION_LENGTH ?>;
var NUMBER_FORMAT = "<?php echo NUMBER_FORMAT ?>";
var ROUND_NUMBER = "<?php echo ROUND_NUMBER ?>";
var CURRENCY_FORMAT = "<?php echo CURRENCY_FORMAT ?>";
var CURRENCY_PLACE = "<?php echo CURRENCY_PLACE ?>";
var FORMATTED_CURRENCIES = <?php echo json_encode($this->settings_model->getFormattedCurrencies()); ?>;
var DECIMAL_PLACE = "<?php echo DECIMAL_PLACE ?>";
var CURRENCY_PREFIX = "<?php echo CURRENCY_PREFIX ?>";
var CURRENCY_SYMBOL = "<?php echo CURRENCY_SYMBOL ?>";
var INVOICE_PREFIX = "<?php echo INVOICE_PREFIX ?>";
var CSRF_NAME = "<?php echo $this->security->get_csrf_token_name(); ?>";
var CSRF_HASH = "<?php echo $this->security->get_csrf_hash() ?>";
var WINDDOW_NAME = "<?php echo WINDDOW_NAME ?>";
var WINDDOW_CONFIGURATION = "<?php echo WINDDOW_CONFIGURATION ?>";
var OPENAPI_KEY = '<?php echo EXCHANGE_API_KEY ?>';
var CSRF_DATA = {};
CSRF_DATA[CSRF_NAME] = CSRF_HASH;
<?php endif ?>


<?php if ($show_in == "footer"): ?>
var tinymce_init = {
    language: '<?php echo MIN_LANG ?>',
    directionality: '<?php echo lang("IS_RTL")?"rtl":"ltr" ?>',
    plugins: [
      'advlist autolink link image lists charmap preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
      'save table contextmenu directionality paste textcolor'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview code fullscreen',
};
var tinymce_init_mini = {
    language: '<?php echo MIN_LANG ?>',
    directionality: '<?php echo lang("IS_RTL")?"rtl":"ltr" ?>',
    plugins: [
      'advlist autolink link image lists charmap preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
      'save table contextmenu directionality paste textcolor'
    ],
    menubar: false,
    toolbar: 'bold italic | alignleft aligncenter alignright',
};

var reportranges = {};
reportranges[globalLang['daterange_today']] =[moment(), moment()];
reportranges[globalLang['daterange_last_7_days']] =[moment().subtract(6, 'days'), moment()];
reportranges[globalLang['daterange_last_30_days']] = [moment().subtract(29, 'days'), moment()];
reportranges[globalLang['daterange_this_month']] = [moment().startOf('month'), moment().endOf('month')];
reportranges[globalLang['daterange_last_month']] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
reportranges[globalLang['daterange_this_year']] = [moment().startOf('year'), moment().endOf('year')];
var daterangepicker_init = {
    opens: '<?php echo lang("IS_RTL")?"right":"left" ?>',
    startDate: moment().startOf('year'),
    endDate: moment().endOf('year'),
    ranges: reportranges,
    "locale": {
        "format": JS_DATE,//"DD/MM/YYYY",
        "applyLabel": globalLang['ok'],
        "cancelLabel": globalLang['cancel'],
        "fromLabel": globalLang["from"],
        "toLabel": globalLang["to"],
        "customRangeLabel": globalLang['daterange_custom'],
    }
};

var UploaderCaptions = {
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
var MK_configuration = {
    "theme":"black",
    "hint":<?php echo json_encode(!lang("IS_RTL")) ?>,
    "keyboard_shortcut":true,
    "is_rtl":<?php echo json_encode(lang("IS_RTL")) ?>,
    "always_on_top":true
};

if( shortcuts_list == undefined ){
    var shortcuts_list = [];
}
var navmenu_shortcut_list = [
    {"selector":"a[href=\"#show_shortcut_help\"]","keyChar":"SHIFT+F1","click":"a[href=\"#show_shortcut_help\"]","description":globalLang["shortcut_help"]},

    {"selector":"a[href=\""+SITE_URL+"/invoices/create\"]","keyChar":"CTRL+SHIFT+O","click":"a[href=\""+SITE_URL+"/invoices/create\"]","description":globalLang["create_invoice"]},

    {"selector":"a[href=\""+SITE_URL+"/invoices\"]","keyChar":"CTRL+O","click":"a[href=\""+SITE_URL+"/invoices\"]","description":globalLang["invoices"]},

    {"selector":"a[href=\""+SITE_URL+"/items/create\"]","keyChar":"CTRL+SHIFT+I","click":"a[href=\""+SITE_URL+"/items/create\"]","description":globalLang["create_item"]},

    {"selector":"a[href=\""+SITE_URL+"/items\"]","keyChar":"CTRL+I","click":"a[href=\""+SITE_URL+"/items\"]","description":globalLang["items"]},

    {"selector":"a[href=\""+SITE_URL+"/estimates/create\"]","keyChar":"CTRL+SHIFT+E","click":"a[href=\""+SITE_URL+"/estimates/create\"]","description":globalLang["create_estimate"]},

    {"selector":"a[href=\""+SITE_URL+"/estimates\"]","keyChar":"CTRL+E","click":"a[href=\""+SITE_URL+"/estimates\"]","description":globalLang["estimates"]},

    {"selector":"a[href=\""+SITE_URL+"/receipts/create\"]","keyChar":"CTRL+SHIFT+R","click":"a[href=\""+SITE_URL+"/receipts/create\"]","description":globalLang["create_receipt"]},

    {"selector":"a[href=\""+SITE_URL+"/receipts\"]","keyChar":"CTRL+R","click":"a[href=\""+SITE_URL+"/receipts\"]","description":globalLang["receipts"]},

    {"selector":"a[href=\""+SITE_URL+"/billers/create\"]","keyChar":"CTRL+SHIFT+B","click":"a[href=\""+SITE_URL+"/billers/create\"]","description":globalLang["create_customer"]},

    {"selector":"a[href=\""+SITE_URL+"/billers\"]","keyChar":"CTRL+B","click":"a[href=\""+SITE_URL+"/billers\"]","description":globalLang["customers"]},

    {"selector":"a[href=\""+SITE_URL+"/auth\"]","keyChar":"CTRL+U","click":"a[href=\""+SITE_URL+"/auth\"]","description":globalLang["users"]},

    {"selector":"a[href=\"<?=base_url("/docs") ?>\"]","keyChar":"CTRL+F1","click":"a[href=\"<?=base_url("/docs") ?>\"]","description":globalLang["documentations"]}
];
shortcuts_list = $.merge( shortcuts_list, navmenu_shortcut_list );
<?php endif ?>
