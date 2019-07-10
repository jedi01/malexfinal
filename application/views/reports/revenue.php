<script src="<?php echo base_url("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/jquery.autocomplete/easy-autocomplete.css") ?>">
<!-- Page Header -->
<ol class="breadcrumb">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading ?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <a href="#" class="btn btn-link btn-sm" id="print_report" >
            <i class="icon-printer h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("print"); ?></small>
        </a>
        <a href="#" class="btn btn-link btn-sm" id="download_report">
            <i class="icon-cloud-download h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("tabletool_pdf"); ?></small>
        </a>
    </div>
</ol>
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><?php echo lang("filtering") ?></div>
        <div class="card-block form-vertical row p-y-0">
            <?php if (isset($filter_supplier) && $filter_supplier): ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo lang('filter_supplier', 'filter_supplier', array("class" => "form-control-label")); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="filter_supplier" class="form-control" placeholder="<?php echo lang("supplier_suggestion_placeholder") ?>">
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo lang('filter_customer', 'filter_customer', array("class" => "form-control-label")); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="filter_customer" class="form-control" placeholder="<?php echo lang("customer_suggestion_placeholder") ?>">
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo lang('daterange', 'reportrange', array("class" => "form-control-label")); ?>
                    <button type="button" id="reportrange" class="btn btn-secondary btn-block dropdown-toggle">
                        <i class="fa fa-calendar m-x-h"></i> <small></small>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo lang('currency', 'select_currency', array("class" => "form-control-label")); ?>
                    <div class="btn-group btn-block tip" id="select_currency">
                        <a class="btn btn-secondary btn-block dropdown-toggle" data-toggle="dropdown"><small></small> <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right select_currency">
                            <?php foreach ($currencies as $currency => $label): ?>
                                <li class="dropdown-item" data-currency="<?php echo $currency ?>"><?php echo $label ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="preview">

    </div>
<script type="text/javascript">
var shortcuts_list = [
    {"selector":"#print_report","keyChar":"CTRL+P","click":"#print_report","description":globalLang["print"], "group": globalLang["reports"]}
];
$(function(){
    function cb(start, end) {
        if( start == undefined && end == undefined ){
            start = this.startDate;
            end = this.endDate;
        }
        $('#reportrange small').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var ajax_data        = {};
        ajax_data[CSRF_NAME] = CSRF_HASH;
        ajax_data["start"]   = start.locale("en").format("YYYY-MM-DD");
        ajax_data["end"]     = end.locale("en").format("YYYY-MM-DD");
        ajax_data['currency']= $('#select_currency').data("value");
        if( selected_biller != null ){
            ajax_data['biller_id']= selected_biller.id;
        }
        if( selected_supplier != null ){
            ajax_data['supplier_id']= selected_supplier.id;
        }
        var url = "<?php echo $print_view ?>"+"/"+ajax_data["start"]+"/"+ajax_data["end"]+"/"+ajax_data["currency"];
        if( selected_biller != null ){
            url += "?biller_id="+selected_biller.id;
        }
        if( selected_supplier != null ){
            url += "?supplier_id="+selected_supplier.id;
        }
        $('#print_report').click(function(){
            var MyWindow = window.open(SITE_URL+"/reports/print_report/"+url, WINDDOW_NAME,WINDDOW_CONFIGURATION);
            return false;
        });
        $('#download_report').attr("href", SITE_URL+"/reports/pdf/"+url);
        $.ajax({
            type: "POST",
            url: "<?php echo $ajax_data_url ?>",
            data: ajax_data,
            dataType: "HTML",
            success: function(result) {
                $('#preview').html(result);
                setTimeout(function() {
                    scaleTemplate();
                }, 50);
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
    }
    $('#reportrange').daterangepicker(daterangepicker_init, cb).data('daterangepicker');

    $(document).on("click", ".select_currency li", function(){
        $('#select_currency').setCurrency($(this).data("currency"));
        return false;
    });

    var currency_row = {};
    var currencies = <?php echo json_encode($currencies) ?>;
    $.fn.setCurrency = function(currency){
        $('.select_currency li').removeClass("active");
        var item = $('.select_currency li[data-currency="'+currency+'"]');
        $(item).addClass('active');
        currency_row.currency = currency;
        $('#select_currency .dropdown-toggle small').text(currencies[currency]);
        $('#select_currency').data("value", currency);
        $('#select_currency').trigger("change");
        return $('#select_currency');
    }
    $('#select_currency')
        .on("change", function(){
            $('#reportrange').data('daterangepicker').callback();
        })
        .setCurrency('<?php echo CURRENCY_PREFIX ?>');


    /*
    *  BILLER (AUTOCOMPLETE)
    */
    var selected_biller = null;
    $('#filter_customer')
    .change(function(){
        if( $(this).val() == "" ){
            selected_biller = null;
        }
        $('#reportrange').data('daterangepicker').callback();
    })
    .blur(function(){
        if( selected_biller != null && $(this).val() != selected_biller.fullname ){
            $(this).val(selected_biller.fullname);
        }
    })
    .easyAutocomplete({
        url: function(phrase) {return SITE_URL+"/billers/suggestions?term=" + phrase;},
        ajaxSettings: {data: CSRF_DATA},
        getValue: "label",
        placeholder: globalLang["customer_suggestion_placeholder"],
        minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
        use_on_focus: true,
        list: {
            maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
            hideOnEmptyPhrase: false,
            onSelectItemEvent: function() {
                var data = $("#filter_customer").getSelectedItemData();
                $('.easy-autocomplete').css("width","inherit");
                selected_biller = data;
            }
        }
    });

    /*
    *  SUPPLIER (AUTOCOMPLETE)
    */
    var selected_supplier = null;
    $('#filter_supplier')
    .change(function(){
        if( $(this).val() == "" ){
            selected_supplier = null;
        }
        $('#reportrange').data('daterangepicker').callback();
    })
    .blur(function(){
        if( selected_supplier != null && $(this).val() != selected_supplier.fullname ){
            $(this).val(selected_supplier.fullname);
        }
    })
    .easyAutocomplete({
        url: function(phrase) {return SITE_URL+"/suppliers/suggestions?term=" + phrase;},
        ajaxSettings: {data: CSRF_DATA},
        getValue: "label",
        placeholder: globalLang["supplier_suggestion_placeholder"],
        minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
        use_on_focus: true,
        list: {
            maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
            hideOnEmptyPhrase: false,
            onSelectItemEvent: function() {
                var data = $("#filter_supplier").getSelectedItemData();
                $('.easy-autocomplete').css("width","inherit");
                selected_supplier = data;
            }
        }
    });
});
</script>
