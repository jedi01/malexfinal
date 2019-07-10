<?php
$this->load->enqueue_style("assets/vendor/jquery.autocomplete/easy-autocomplete.css", "custom");
$this->load->enqueue_script("assets/vendor/jquery.autocomplete/jquery.easy-autocomplete.js");
$this->load->enqueue_script("assets/js/libs/select2.min.js");
$this->load->enqueue_script("assets/vendor/jquery-ui/jquery-ui-sortable.js");
echo $this->load->css("custom");

$sys = $this->settings_model->SYS_Settings;
$label_params = array(
    "class" => "col-md-3 form-control-label"
);

$purchase_title = array(
    "id" => "title",
    "class" => "form-control",
    "placeholder" => lang("purchase_title"),
    "tabindex" => "0",
);

$purchase_status = array(
    "id" => "status",
    "class" => "form-control"
);
$purchase_date = array(
    "id" => "date",
    "class" => "form-control"
);
$purchase_date_due = array(
    "id" => "date_due",
    "class" => "form-control"
);
$purchase_reference = array(
    "id" => "reference",
    "class" => "form-control"
);


if( set_value("invoice_item", "") != "" ){
    $purchase_items = set_value("invoice_item", "");
}

if( isset($_POST['bill']) ){
    $biller_js = $_POST['bill'];
}
else if( isset($_GET["estimate_id"]) ){
    $biller_js = $estimate_biller;
}else{
    $biller_js = null;
}

if( set_value("purchase[due_date]", $purchase->date_due) == NULL ){
    $due_date_chooser = "null";
}else{
    $ts1 = strtotime($purchase->date);
    $ts2 = strtotime($purchase->date_due);
    $seconds_diff = $ts2 - $ts1;
    $days_diff = intval($seconds_diff/(3600*24));
    if( in_array($days_diff, array(7,15,30,45,60))){
        $due_date_chooser = $days_diff."";
    }else{
        $due_date_chooser = "-1";
    }
}
?>
<style type="text/css">
.input-group-addon{
    min-width:50px;
    padding:0px 4px;
    background:white;
    line-height: 33px;
}
.global_tax_item{
    width: 100%;
}
</style>
<?php
echo form_open($form_action, array('class' => 'form-horizontal', 'id'=>"form"));
echo form_hidden('id', $purchase->id);
echo form_input(array("type"=>"hidden", "name"=>"purchase[count]","value"=>$purchase->count,"id"=>"next_count"));
?>
<!-- Page Header -->
<ol class="breadcrumb pos-sticky">
	<div class="flip pull-left">
		<h1 class="h2 page-title"><?php echo $page_title;?></h1>
		<div class="text-muted page-desc"><?php echo $page_subheading;?></div>
	</div>
    <div class="flip pull-right" style="line-height: 64px;">
        <a href="<?php echo site_url("/".$this->router->fetch_class()) ?>" class="btn btn-link btn-sm" >
            <i class="icon-close h3 text-muted font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("cancel"); ?></small>
        </a>
        <button type="submit" class="btn btn-link btn-sm">
            <i class="icon-check h3 text-success font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("save"); ?></small>
        </button>
        <span class="divider-vertical"></span>
        <a href="#" class="btn btn-link btn-sm preview_invoice" id="preview" >
            <i class="icon-eye h3 font-weight-bold"></i>
            <small class="text-muted center-block"><?php echo lang("preview"); ?></small>
        </a>
    </div>
</ol>
<div class="container-fluid">
	<div class="span12">

		<div class="card">
            <div class="card-header">
                <div class="col-sm-4 form-group m-a-0">
                    <?php echo form_input('purchase[title]', set_value('purchase[title]', $purchase->title), $purchase_title); ?>
                </div>
                <div class="col-md-4 form-group m-a-0">
                    <?php
                    echo '<select name="purchase[currency]" id="currency" class="form-control">';
                    foreach ($this->settings_model->getFormattedCurrencies() as $currency) {
                        echo "<option value='".$currency->value."' symbol_native='".$currency->symbol_native."' ".($currency->value==set_value("invoice[currency]", $purchase->currency)?"selected='selected'":"" ).">".$currency->label."</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="col-sm-4 form-group m-a-0">
                    <?php
                    $status = $this->settings_model->getInvoiceStatus();
                    if( $purchase->status != "paid" &&  $purchase->status != "partial" ){
                        unset($status['partial']);
                    }
                    /*if( $invoice->status != "canceled" ){
                        unset($status['canceled']);
                    }*/
                    if( $purchase->status != "panding" ){
                        unset($status['panding']);
                    }
                    if( $purchase->status != "overdue" ){
                        unset($status['overdue']);
                    }
                    echo form_dropdown('purchase[status]', $status, set_value("purchase[status]", $purchase->status), $purchase_status);
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="card-block">
                <div class="col-md-6">
                    <!-- REFERENCE -->
                    <div class="form-group row required">
                        <?php echo lang('reference', 'reference', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                <?php echo form_input('purchase[reference]', set_value('purchase[reference]', $purchase->reference), $purchase_reference); ?>
                                <span class="input-group-btn">
                                    <button type="button" id="generate_reference" class="btn btn-secondary tip" title="<?php echo lang("generate") ?>"><i class="fa fa-refresh"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- BILL TO -->
                    <div class="form-group row required">
                        <?php echo lang('supplier', 'supplier_id', $label_params); ?>
                        <?php echo form_hidden('purchase[supplier_id]', set_value('purchase[supplier_id]', $purchase_supplier->id)); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="supplier_id" value="<?php echo set_value("biller",$purchase_supplier->fullname) ?>" name="biller">
                                <span class="input-group-btn">
                                    <a href="<?php echo site_url("suppliers/create") ?>" sis-modal="" class="btn btn-secondary tip sis_modal" title="<?php echo lang("add") ?>" ><i class="fa fa-plus"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- DATE -->
                    <div class="form-group row required">
                        <?php echo lang('date', 'date', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php
                                echo form_input($purchase_date);
                                echo form_hidden('purchase[date]', set_value('purchase[date]', date_MYSQL_JS($purchase->date)));
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- DUE DATE -->
                    <div class="form-group row">
                        <?php echo lang('date_due', 'date_due', $label_params); ?>
                        <div class="col-md-9">
                            <?php
                            echo form_dropdown('due_date_chooser', $this->settings_model->getDueDates(), $due_date_chooser, 'class="form-control" id="due_date_chooser"');
                            ?>
                            <div class="input-group m-t-1">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php
                                echo form_input($purchase_date_due);
                                echo form_hidden('purchase[date_due]', set_value('purchase[date_due]', date_MYSQL_JS($purchase->date_due)));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            
                
                <div class="col-md-12 form-group required">
                    <?php echo form_hidden('items_count', count($purchase_items)); ?>
                    <table class="table table-striped table-hover" id="items">
                        <thead class="transparent">
                            <tr>
                                <th style="max-width:16px;"><i class="fa fa-arrows"></i></th>
                                <th style="min-width:250px;"><?php echo lang('name'); ?> <small><?php echo lang('description'); ?></small></th>
                                <th width="10%"><?php echo lang('quantity'); ?></th>
                                <th width="10%"><?php echo lang('unit_price'); ?></th>
                                <th width="10%"><?php echo lang('total'); ?></th>
                                <th><i class="fa fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button type="button" class="btn" id="add_row"><?php echo lang("add_row") ?></button>
                </div>
                <div class="col-lg-6 col-lg-offset-6">
                    
                   
        
                    <div class="form-group row">
                        <?php echo lang('total', 'total', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" readonly="readonly" value="0" class="form-control" id="total_shown" />
                                <input type="hidden" readonly="readonly" value="0" name="purchase[total]" id="total" />
                                <span class="input-group-addon symbol_native">$</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php echo lang('paid_amount', 'paid_amount', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" step="any" min="0" readonly="readonly" value="<?php echo $purchase->total-$purchase->total_due ?>" class="form-control" id="paid_amount" />
                                <span class="input-group-addon symbol_native" >$</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php echo lang('amount_due', 'total_due', $label_params); ?>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" readonly="readonly" value="0" class="form-control" id="total_due" />
                                <input type="hidden" readonly="readonly" value="0" name="purchase[total_due]" />
                                <span class="input-group-addon symbol_native" >$</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label"><?php echo lang("invoice_note"); ?></label>
                            <textarea class="form-control" rows="3" name="purchase[note]" id="editor_note"><?php echo set_value("purchase[note]", $purchase->note) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

			</div>
            <div class="card-footer text-md-right">
                <a href="<?php echo site_url("/purchases") ?>" class="btn btn-secondary"><?php echo lang("cancel") ?></a>
                <a href="#" class="btn btn-secondary preview_invoice" id="preview"><i class="fa fa-print"></i> <?php echo lang("preview") ?></a>
                <?php echo form_submit('submit', lang('edit'), array('class' => 'btn btn-primary'));?>
            </div>
		</div>
        <?php echo form_close(); ?>
	</div>

    <!-- Preview -->
    <div class="card card-secondary-outline" style="display: none">
        <div class="card-header">
            <?php echo lang("preview") ?>
        </div>
        <div class="card-block" id="preview_page">
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function() {
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
            $('input[name="purchase[date]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="purchase[date]"]').val("");
        }
        $('#due_date_chooser').trigger("change");
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
            $('input[name="purchase[date_due]"]').val(date_locale($(this).datepicker("getDate"), globalLang["lang"], "en"));
        }else{
            $('input[name="purchase[date_due]"]').val("");
        }
    });

    if( $('input[name="purchase[date]"]').val() != "" ){
        $("#date").datepicker("setDate",date_locale($('input[name="purchase[date]"]').val(), "en", globalLang["lang"]));
    }else{
        $("#date").trigger("changeDate");
    }
    if( $('input[name="purchase[date_due]"]').val() != "" ){
        $("#date_due").datepicker("setDate",date_locale($('input[name="purchase[date_due]"]').val(), "en", globalLang["lang"]));
    }else{
        $("#date_due").trigger("changeDate");
    }

    $('#due_date_chooser').on("change", function(){
        var value = $(this).val();
        if( value == "null" ){
            $('#date_due').parent(".input-group").hide();
            $("#date_due").datepicker("setDate", "");
        }
        else if( value == "-1" ){
            $('#date_due').parent(".input-group").show();
        }
        else{
            $('#date_due').parent(".input-group").hide();
            days = parseInt(value);
            start_date = $("#date").datepicker("getDate");
            start_date.setDate(start_date.getDate()+days);
            m = new moment(start_date, JS_DATE);
            $("#date_due").datepicker("setDate",m.locale(globalLang["lang"]).format(JS_DATE));
        }
    }).trigger("change");

    /* REFERENCE */
    function get_next_reference(refresh){
        reference_type = <?php echo REFERENCE_TYPE ?>;
        YEAR =  <?php echo date("y") ?>;
        if( $('#date').datepicker('getDate') != null ){
            YEAR = $('#date').datepicker('getDate').getYear()-100;
        }
        dataJson = {
            "c": <?php echo $purchase->count ?>,
            "y": YEAR
        };
        if( refresh ){
            $.get(
                SITE_URL+"/purchases/get_next_reference",
                dataJson,
                function(data){
                    $("#reference").val(data.reference);
                },
                "JSON"
            );
        }else{
            switch(reference_type){
                case 0: ref_mask = false; ref_placeholder = ""; break;
                case 1: ref_mask = "9?99999"; ref_placeholder = "______"; break;
                case 2: ref_mask = PURCHASE_PREFIX+"9?99999"; ref_placeholder = PURCHASE_PREFIX+"______"; break;
                case 3: ref_mask = "9?99999"+INVOICE_PREFIX; ref_placeholder = "______"+PURCHASE_PREFIX; break;
                case 4: ref_mask = PURCHASE_PREFIX+YEAR+"9?999"; ref_placeholder = PURCHASE_PREFIX+YEAR+"____"; break;
                case 5: ref_mask = "*?*****"; ref_placeholder = "______"; break;
                case 6: ref_mask = PURCHASE_PREFIX+"*?*****"; ref_placeholder = PURCHASE_PREFIX+"______"; break;
            }
            $("#reference").mask(ref_mask,{placeholder:ref_placeholder});
        }
    }
    get_next_reference();
    $('#generate_reference').click(function(){
        get_next_reference(true);
    });



    tinymce.remove("#editor_note, #editor_terms");
    tinymce.init(
        Object.assign({}, tinymce_init, {
            selector: '#editor_note, #editor_terms',
            height: 150,
        })
    );

    /*
     *  BILLER (AUTOCOMPLETE)
     */
    var selected_biller = <?php echo json_encode($biller_js); ?>;
    $('#supplier_id')
    .change(function(){
        if( $(this).val() == "" ){
            selected_biller = null;
            $('input[name="purchase[supplier_id]"]').val("");
        }
    })
    .blur(function(){
        if( selected_biller != null && $(this).val() != selected_biller.fullname ){
            $('input[name="purchase[supplier_id]"]').val(selected_biller.id);
            $(this).val(selected_biller.fullname);
        }
    })
    .easyAutocomplete({
        url: function(phrase) {return SITE_URL+"/suppliers/suggestions?term=" + phrase;},
        ajaxSettings: {data: CSRF_DATA},
        getValue: "label",
        placeholder: globalLang["customer_suggestion_placeholder"],
        minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
        use_on_focus: true,
        template: {
            type: "custom",
            method: function(value, item) {
                var actions = "<div class='actions flip pull-right'>";
                actions += "<a href='#' class='delete_biller btn btn-sm btn-secondary' data-id='" + item.id + "'><i class='fa fa-trash'></i></a>";
                actions += "<a href='" + SITE_URL + "/suppliers/edit?id=" + item.id + "' sis-modal='' class='sis_modal btn btn-sm btn-secondary'><i class='fa fa-pencil'></i></a>";
                actions += "</div>";
                return actions +  value;
            }
        },
        list: {
            maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
            hideOnEmptyPhrase: false,
            onSelectItemEvent: function() {
                var data = $("#supplier_id").getSelectedItemData();
                $('input[name="purchase[supplier_id]"]').val(data.id).trigger("change");
                $('.easy-autocomplete').css("width","inherit");
                selected_biller = data;
            },
            onShowListEvent: function() {
                $('.delete_biller').unbind("click").on("click", function(ev){
                    var id = $(this).data("id");
                    bconfirm(globalLang['alert_confirmation'], function(){
                        $(document).load_ajax(SITE_URL+"/suppliers/delete?id="+id);
                        $('#inv_bill_to').val("").get(0).focus();
                    });
                    ev.preventDefault();
                    return false;
                });
            }
        }
    });

    /*
     * ITEMS MANAGE
     */

    $.items = {
        /* CREATE ITEM */
        create : function(name, description, quantity, unit_price, tax, tax_type, discount, discount_type, item_id){
            var self = this;
            description = str_replace("<br>", "\n", description);

            var item = $('<tr class="item"></tr>');
            // sortable td
            $('<td class="dragger"></td>').appendTo(item);
            // name & description
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="text" class="form-control item_name text-xs-left" name="purchase_item[][name]" placeholder="'+globalLang["name"]+'" value="'+name+'" autocomplete="off" />'+
                    '<input type="hidden" class="item_id" name="purchase_item[][item_id]" value="'+item_id+'" />'+
                    '<span class="input-group-addon"><a href="#" class="item_show_description" title="'+globalLang["show_description"]+'"><i class="fa fa-align-center"></i></a></span>'+
                '</div>'+
                '<textarea rows="1" class="form-control item_description" name="purchase_item[][description]" placeholder="'+globalLang["description"]+'" style="display: none;">'+description+'</textarea>'+
            '</td>').appendTo(item);
            // quantity
            $('<td class="td-input">'+
                '<input type="number" step="any" min="0" name="purchase_item[][quantity]" class="form-control item_qty" value="'+quantity+'" />'+
            '</td>').appendTo(item);
            // unit_price
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+unit_price+'" name="purchase_item[][unit_price]" class="form-control item_price" />'+
                    '<span class="input-group-addon symbol_native">$</span>'+
                '</div>'+
            '</td>').appendTo(item);
            // tax
            <?php if (ITEM_TAX==2): ?>
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+tax+'" name="purchase_item[][tax]" class="form-control item_tax" />'+
                    '<span class="input-group-btn">'+
                        '<select class="btn item_tax_type" >'+
                            '<option value="0" '+(tax_type=="0"?"selected='selected'":"")+'>%</option>'+
                            '<option value="1" class="symbol_native" '+(tax_type=="1"?"selected='selected'":"")+'>$</option>'+
                        '</select>'+
                    '</span>'+
                '</div>'+
            '</td>').appendTo(item);
            <?php endif ?>
            // discount
            <?php if (ITEM_DISCOUNT==2): ?>
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="number" step="any" min="0" value="'+discount+'" name="purchase_item[][discount]" class="form-control item_discount" />'+
                    '<span class="input-group-btn">'+
                        '<select class="btn item_discount_type" >'+
                            '<option value="0" '+(discount_type=="0"?"selected='selected'":"")+'>%</option>'+
                            '<option value="1" class="symbol_native" '+(discount_type=="1"?"selected='selected'":"")+'>$</option>'+
                        '</select>'+
                    '</span>'+
                '</div>'+
            '</td>').appendTo(item);
            <?php endif ?>
            // total
            $('<td class="td-input">'+
                '<div class="form-group input-group">'+
                    '<input type="text" readonly="readonly" value="0" class="form-control item_total_shown" />'+
                    '<input type="hidden" readonly="readonly" value="0" name="purchase_item[][total]" class="item_total" />'+
                    '<span class="input-group-addon symbol_native">$</span>'+
                '</div>'+
            '</td>').appendTo(item);
            // delete item
            $('<td class="td-input">'+
                '<button type="button" class="btn btn-link text-danger item_delete tip" title="'+globalLang["delete"]+'"><i class="fa fa-trash"></i></button>'+
            '</td>').appendTo(item);

            $("#items tbody").append(item);

            $(item).find("input[type=number], select").on("change keyup", function(){
                if( $(this).is("input[type=number]") ){
                    if( $(this).val() == "" ){
                        $(this).val("0");
                    }else{
                        $(this).extendWidth();
                    }
                }
                self.calculate();
                self.set_items_count();
            });

            $.each($(item).find("input[type=number]"), function(i, input){
                $(input).css({"min-width": $(input).width()});
            });
            $(item).find(".item_name").change(function(){
                self.set_items_count();
            });
            $(item).find(".item_show_description").click(function(){
                $(item).find(".item_description").slideToggle();
                return false;
            });
            $(item).find(".item_delete").click(function(){
                self.delete(item);
                return false;
            });

            $(item).find('.item_name').easyAutocomplete({
                url: function(phrase) {return SITE_URL+"/items/suggestions?term=" + phrase + "&currency="+$("select#currency").val();},
                ajaxSettings: {data: CSRF_DATA},
                getValue: "name",
                placeholder: globalLang["item_suggestion_placeholder"],
                minCharNumber: <?php echo SUGGESTION_LENGTH ?>,
                use_on_focus: true,
                list: {
                    maxNumberOfElements: <?php echo SUGGESTION_MAX ?>,
                    hideOnEmptyPhrase: false,
                    onSelectItemEvent: function() {
                        var data = $(item).find('.item_name').getSelectedItemData();
                        $(item).find('.item_id').val(data.id);
                        $(item).find('.item_name').val(data.name);
                        $(item).find('.item_description').val(data.description);
                        $(item).find('.item_price').val(data.price).trigger("change");
                        $(item).find('.item_tax').val(data.tax).trigger("change");
                        $(item).find('.item_tax_type').val(data.tax_type).trigger("change");
                        $(item).find('.item_discount').val(data.discount).trigger("change");
                        $(item).find('.item_discount_type').val(data.discount_type).trigger("change");
                        $('.easy-autocomplete').css("width","inherit");
                    },
                    onLoadEvent: function(){
                        $(item).find('.item_id').val("0");
                        $(item).find('.item_description').val("");
                        $(item).find('.item_price').val("0").trigger("change");
                        $(item).find('.item_tax').val("0").trigger("change");
                        $(item).find('.item_tax_type').val("0").trigger("change");
                        $(item).find('.item_discount').val("0").trigger("change");
                        $(item).find('.item_discount_type').val("0").trigger("change");
                    }
                }
            });
            this.calculate();
            this.reset_count();
            setCurrency();
            if( PAGE_IS_LOADED ){
                $(item).find(".item_name").get(0).focus();
            }
        },
        /* DELETE ITEM */
        delete : function(item){
            $(item).remove();
            this.calculate();
            this.reset_count();
        },
        /* CALCULATE TOTALS */
        calculate: function(){
            var subtotal = 0, total_tax = 0, total_discount = 0;
            $.each($("#items tbody tr.item"), function(i, item){
                if( $(item).find(".item_name").val() == "" ){
                    return true;
                }
                item_qty = $(item).find(".item_qty").val();
                item_price = $(item).find(".item_price").val();

                item_total = parseFloat(item_qty)*parseFloat(item_price);

                item_discount = 0;
                <?php if (ITEM_DISCOUNT==2): ?>
                item_discount = $(item).find(".item_discount").val();
                item_discount_type = $(item).find(".item_discount_type").val();
                if( item_discount_type+"" == "0" ){ // percent %
                    item_discount = item_total * (parseFloat(item_discount)/100);
                }
                <?php endif ?>
                item_total = item_total-parseFloat(item_discount);

                item_tax = 0;
                <?php if (ITEM_TAX==2): ?>
                item_tax = $(item).find(".item_tax").val();
                item_tax_type = $(item).find(".item_tax_type").val();
                if( item_tax_type+"" == "0" ){ // percent %
                    item_tax = item_total * (parseFloat(item_tax)/100);
                }
                <?php endif ?>

                item_total = item_total+parseFloat(item_tax);
                subtotal += item_total;
                total_tax += parseFloat(item_tax);
                total_discount += parseFloat(item_discount);
                $(item).find(".item_total").val(item_total);
                $(item).find(".item_total_shown").val(Format_Currency(item_total)).extendWidth();
            });

            $('#subtotal').val(subtotal);
            $('#subtotal_shown').val(Format_Currency(subtotal));


            global_discount = 0;
            subtotal = subtotal-parseFloat(global_discount);

            check_conditional_taxes(subtotal);
            global_tax = 0;
            total_tax += parseFloat(global_tax);
            total_discount += parseFloat(global_discount);

            shipping = 0;
            total = subtotal+parseFloat(global_tax)+shipping;
            total_due = total;
            if( $('#status').val() == 'paid' ){
                total_due = 0;
            }
            if( $('#status').val() == 'partial' ){
                total_due = total - parseFloat($('#paid_amount').val());
            }
            $('#total_due').val(Format_Currency(total_due));      
            $('input[name="purchase[total_due]"]').val(total_due);
            $('#total').val(total);
            $('#total_shown').val(Format_Currency(total));
        },
        /* RESET ITEM INDEXES */
        reset_count: function(){
            $.each($("#items tbody tr.item"), function(index, item){
                if( index == 0 ){
                    $(item).find(".item_delete").attr("disabled", "disabled");
                }else{
                    $(item).find(".item_delete").removeAttr("disabled");
                }
                $(item).find(".item_name").attr("name", "purchase_item["+index+"][name]");
                $(item).find(".item_id").attr("name", "purchase_item["+index+"][item_id]");
                $(item).find(".item_description").attr("name", "purchase_item["+index+"][description]");
                $(item).find(".item_qty").attr("name", "purchase_item["+index+"][quantity]");
                $(item).find(".item_price").attr("name", "purchase_item["+index+"][unit_price]");
                $(item).find(".item_tax").attr("name", "purchase_item["+index+"][tax]");
                $(item).find(".item_tax_type").attr("name", "purchase_item["+index+"][tax_type]");
                $(item).find(".item_discount").attr("name", "purchase_item["+index+"][discount]");
                $(item).find(".item_discount_type").attr("name", "purchase_item["+index+"][discount_type]");
                $(item).find(".item_total").attr("name", "purchase_item["+index+"][total]");
            });
            this.set_items_count();
        },
        /* RESET ITEM INDEXES */
        set_items_count: function(){
            var count = 0;
            $.each($("#items tbody tr.item"), function(index, item){
                if( $(item).find(".item_name").val() != "" ){
                    count++;
                }
            });
            $('input[name=items_count]').val(count);
        }
    }

    $('#items tbody').sortable({
        placeholder: "dragger_tr",
        handle: ".dragger",
        start: function (event, ui) {
            ui.placeholder.html('<td colspan="10">&nbsp;</td>');
            console.log(ui);
            $(ui.item).find('td:first-child').get(0).focus();
            $('#items .item_name').blur();
        },
        update: function(){
            $.items.reset_count();
        },
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }
    });

    function check_conditional_taxes(subtotal){
        $('.tax_conditional').remove();
        var tax_conditional = <?php echo json_encode($this->settings_model->SYS_Settings->tax_conditional) ?>;
        if (tax_conditional.enable) {
            has_condition = false;
            switch(tax_conditional.condition){
                case "<":  has_condition = (parseFloat(subtotal)<parseFloat(tax_conditional.amount)); break;
                case ">":  has_condition = (parseFloat(subtotal)>parseFloat(tax_conditional.amount)); break;
                case "=":  has_condition = (parseFloat(subtotal)==parseFloat(tax_conditional.amount)); break;
                case "<=": has_condition = (parseFloat(subtotal)<=parseFloat(tax_conditional.amount)); break;
                case ">=": has_condition = (parseFloat(subtotal)>=parseFloat(tax_conditional.amount)); break;
            }
            if( has_condition ){ // add conditional tax
                var conditional_item = $.tax.addGlobal(tax_conditional.tax_rate_id, false, true);
            }
        }
    }

    $('#add_row').click(function(){
        $.items.create("","",1,0,0,0,0,0);
    });

    $('#form').submit(function(){
        $.each($("#items tbody tr.item"), function(count, item){
            if( $(item).find(".item_name").val() == ""
                && $(item).find(".item_description").val() == ""
                && $(item).find(".item_qty").val() == "1"
                && $(item).find(".item_price").val() == "0"
                && $(item).find(".item_total").val() == "0" ){
                $(item).addClass("removed");
            }
        });
        $("#items tbody tr.removed").remove();
    });

    <?php
    if (empty($purchase_items)){
        echo "$.items.create('','',1,0,0,0,0,0,0);\n";
    }else{
        foreach ($purchase_items as $key => $item){
            $item['description'] = str_replace("\r\n", "<br>", $item['description']);
            if( ITEM_TAX==2 && ITEM_DISCOUNT==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",".$item['tax'].",".$item['tax_type'].",".$item['discount'].",".$item['discount_type'].",".$item['item_id'].");\n";
            }
            elseif( ITEM_TAX==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",".$item['tax'].",".$item['tax_type'].",0,0,".$item['item_id'].");\n";
            }
            elseif( ITEM_DISCOUNT==2 ){
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",0,0,".$item['discount'].",".$item['discount_type'].",".$item['item_id'].");\n";
            }else{
                echo "$.items.create('".$item['name']."','".$item['description']."',".$item['quantity'].",".$item['unit_price'].",0,0,0,0,".$item['item_id'].");\n";
            }
        }
    }

    ?>

    $('#paid_amount').trigger("change");


    $('.preview_invoice').click(function(){
        var data = $('#form').serialize();
        if( $('input[name="invoice[date]"]').val() == ""
            || $('input[name="invoice[bill_to_id]"]').val() == "" ){
            showToastr("error", globalLang["preview_invoice_error"]);
            return false;
        }
        $.ajax({
            url:SITE_URL+"/purchases/preview",
            data: data,
            type: "POST",
            success: function(x, y, z){
                $('#preview_page').parents(".card").slideDown(function(){
                    $('#preview_page').html(x);

                    $('html, body').animate({
                        scrollTop: ($("#preview_page").offset().top) -250
                    }, 'slow');
                });
            }

        });
        return false;
    });

    $('#status').change(function(){
        if( $(this).val() == 'partial' ){
            $('#paid_amount').parents('.form-group').show();
        }else{
            $('#paid_amount').parents('.form-group').hide();
        }
    }).trigger("change");




    /* CURRENCIES */
    $('#currency').select2();
    $('#currency').on("change", function(){
        setCurrency();
    });
    function setCurrency(){
        if( $('#currency').size() > 0 ){
            symbol_native = $("#currency").find('option:selected').attr("symbol_native");
            $('.symbol_native').text(symbol_native);
        }
    }
    setCurrency();

    $('#title').get(0).focus();
});

var shortcuts_list = [
    {"selector":"#add_row","keyChar":"SHIFT+A","click":"#add_row","description":globalLang["add_row"], "group": globalLang["edit_invoice"]}
];
</script>

<?php if (isset($is_recurring) && $is_recurring): ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#every').on("change", function(){
            var text = globalLang["invoice_will_every"]+" ";
            var frequency = $('#frequency').val();
            var occurences = $('#occurences').val();
            var date = moment($('#date').datepicker("getDate").toISOString(), moment.ISO_8601);
            var every_text = $('#every option:selected').text();
            text += "<label for='every' onclick=\"$('#every').select2('open');\"><b>"+every_text+"</b></label> ";
            if( frequency == "weekly" ){
                text += globalLang["on"]+" <label for='inv_date'><b>"+date.format("dddd")+"</b></label> ";
            }else if( frequency == "monthly" ){
                text += globalLang["on_the"]+" <label for='inv_date'><b>"+date.format("Do")+"</b></label> ";
            }else if( frequency == "yearly" ){
                text += globalLang["on_the"]+" <label for='inv_date'><b>"+date.format("Do, MMMM")+"</b></label> ";
            }
            if( occurences == 0 ){
                text += "<label for='occurences'>"+globalLang["forever"]+"</label>";
            }else if( occurences == 1 ){
                text += globalLang["for"]+" <label for='occurences'><b>"+globalLang["occurence_time"]+"</b></label>";
            }else{
                text += globalLang["for"]+" <label for='occurences'><b>"+occurences+" "+globalLang["occurence_times"]+"</b></label>";
            }
            $("#recurring_frequency").html(text);
            $("#recurring_end").html(globalLang["recurring_effective"] +" <label for='inv_date'><b>"+date.format(JS_DATE)+"</b></label>");
        });

        $('#frequency').on("change", function(){
            $('#every_list optgroup').removeClass("selected");
            $('#every_list optgroup[label='+$(this).val()+']').addClass("selected");
            $('#every').html($('#every_list optgroup.selected').html());
            $('#every').val($('#every option:first-child').val()).trigger("change").trigger('change.select2');
        }).trigger("change");

        $('#date, #occurences').on("change", function(){
            $('#every').trigger("change");
        });

        $('#frequency, #every').select2({
            containerCss: function (element) {
                var visible = $(element).is(":visible");
                return {
                    display: visible
                };
            }
        });

        $('#every').val("<?php echo $rinvoice->number ?>").trigger("change");
    });
</script>
<?php endif ?>
