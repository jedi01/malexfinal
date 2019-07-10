$(document).ready(function($){
  $(".tip").tooltip();

  $(document).on("click", "[sis-modal]", function(e){
    var url = $(this).attr('href');
    var title = $(this).attr("title");
    if( title == undefined ){
      title = $(this).data("original-title");
    }
    var is_big = $(this).is(".large-modal");
    var table = $(this).attr('sis-modal');
    var button = this;
    $("#"+table).sis_modal({
      title : title,
      url   : url,
      is_big: is_big,
      button: button
    });
    e.preventDefault();
    return false;
  });

  $(document).on("click", "[export-format]", function(e){
    var format = $(this).attr('export-format');
    var table = $(this).closest(".download-list").attr('export-table');
    if( format != undefined && table != undefined ){
      export_data(table, format);
    }
    e.preventDefault();
    return false;
  });

  $('body').on('click', function (e) {
    if ( $(e.target).data('toggle') !== 'popover'
          && $(e.target).parents('[data-toggle="popover"]').length === 0
          && $('.popover.in').length !== 0 ) {
      $('[data-toggle="popover"]').popover('hide');
    }
  });

  $(document).on("show.bs.modal", ".modal", function(e){
    if( $(e.target).is(".modal") ){
      $('body, html').addClass("overflow-hidden");
    }
  }).on("hide.bs.modal", ".modal", function(e){
    if( $(e.target).is(".modal") ){
      $('body, html').removeClass("overflow-hidden");
    }
  });

  function updateDataTableSelectAllCtrl(table){
     var $chkbox_all        = $(table).find('tbody input[type="checkbox"]');
     var $chkbox_checked    = $(table).find('tbody input[type="checkbox"]:checked');
     var chkbox_select_all  = $(table).find('thead input[name="select_all"]').get(0);

     // If none of the checkboxes are checked
     if($chkbox_checked.length === 0){
        chkbox_select_all.checked = false;
        if('indeterminate' in chkbox_select_all){
           chkbox_select_all.indeterminate = false;
        }
     // If all of the checkboxes are checked
     } else if ($chkbox_checked.length === $chkbox_all.length){
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
           chkbox_select_all.indeterminate = false;
        }
     // If some of the checkboxes are checked
     } else {
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
           chkbox_select_all.indeterminate = true;
        }
     }
     $(table).data("select-count", $(table).find('tbody input[type="checkbox"]:checked').length);
     $(table).trigger("select-count");
  }
  var rows_selected = [];
  var from_select_all = false;
  $('.checkable_datatable tbody').on("click", 'input[type="checkbox"]', function(e){
    var $row = $(this).closest('tr');
    if( (this.checked)){
      $row.addClass('row_selected');
    } else {
      $row.removeClass('row_selected');
    }
    var table = $(this).closest('table');

    if( !from_select_all ){
      updateDataTableSelectAllCtrl(table);
    }
    e.stopPropagation();
  });

  $('.checkable_datatable').on('click', 'tbody td, thead th:first-child', function(e){
    if( !$(e.target).is(".btn, a") && !$(e.target.parentElement).is(".btn, a") ){
      if( !$(e.target).is('input[type="checkbox"]') ){
        $(this).parent().find('input[type="checkbox"]').trigger('click');
      }
    }
  });

  $('.checkable_datatable thead').on('click', 'input[name="select_all"]', function(e){
    from_select_all = true;
    var table = $(this).closest('table');
    if(this.checked){
      $(table).find('input[type="checkbox"]:not(:checked)').trigger('click');
    } else {
      $(table).find('input[type="checkbox"]:checked').trigger('click');
    }
    from_select_all = false;
    $(table).data("select-count", $(table).find('tbody input[type="checkbox"]:checked').length);
    $(table).trigger("select-count");
    e.stopPropagation();
  });


  $('.checkable_datatable').on('unselect_all', function(){
    var table = $(this);
    var chkbox_checked     = $(table).find('tbody input[type="checkbox"]:checked');
    var chkbox_select_all  = $(table).find('thead input[name="select_all"]').get(0);

    chkbox_checked.click();
    chkbox_select_all.checked = false;
        chkbox_select_all.indeterminate = false;
    $(table).find('.row_selected').removeClass('row_selected');

    $(table).data("select-count", $(table).find('tbody input[type="checkbox"]:checked').length);
    $(table).trigger("select-count");
  });

  $('.checkable_datatable').on("select-count", function(){
    var select_count = $(this).data('select-count');
    var actions = $(this).data('actions')==undefined?"":$(this).data('actions')+" ";
    $(actions+'.btn-select-one').addClass("disabled").attr("disabled", "disabled");
    $(actions+'.btn-select-multi').addClass("disabled").attr("disabled", "disabled");

    if( select_count == 1 ){
      $(actions+'.btn-select-one').removeClass("disabled").removeAttr("disabled");
    }
    if( select_count > 0 ){
      $(actions+'.btn-select-multi').removeClass("disabled").removeAttr("disabled");
    }
  });

  if( $('form').size() > 0 ){
    $.fn.ask_for_exit = function(){
      var unloadform = this;
      $(unloadform).data('serialize',$(unloadform).serialize());
      $(window).bind('beforeunload', function(e){
        if($(unloadform).serialize()!=$(unloadform).data('serialize')){
          return true;
        }else{
          e=null;
        }
      });
      $(unloadform).submit(function() {
        $(window).unbind('beforeunload');
      });
    }
    $("form").ask_for_exit();
  }

  if(isMobile()){
    // scroll to element
    $(document).on("focus", "input:not(:submit)", function(event){
      if( $(event.target).parents(".modal").size() > 0 ){
        var modal = $(event.target).closest(".modal");
        var top = $(event.target).offset().top - $(modal).find(".modal-dialog").offset().top;
        $(modal).find(".modal-dialog").css({"margin-bottom":($(window).height()/2)+"px"});
        $(modal).scrollTop(top + 10);
      }else{
        $('html, body').scrollTop($(event.target).offset().top + 10);
      }
    });
  }
  $(document).responsiveNavTabs();
});

function alert(message, title){
  if( title == undefined ){
    bootbox.alert(message);
  }else{
    bootbox.dialog(message,
    [{
      "label" : globalLang["ok"],
      "class" : "btn-primary"
    }], {
      "header": title
    });
  }
}

function bconfirm(message, confirmCallback, cancelCallback){
  var bdialog = bootbox.dialog(message,
    [{
      "label" : globalLang["yes"],
      "class" : "btn-primary underline_first_letter",
      "attrs" : "tabindex='2'",
      "callback": function() {
        confirmCallback.call();
      }
    },{
      "label" : globalLang["no"],
      "class" : "btn-default underline_first_letter",
      "attrs" : "tabindex='1'",
      "callback": function() {
        if( cancelCallback != undefined ){
          cancelCallback.call();
        }
      }
    }], {
      "header": globalLang['confirmation'],
      "onEscape" :function(){
        if( cancelCallback != undefined ){
          cancelCallback.call();
        }
      }
    });

  bdialog.one('shown.bs.modal', function(){
    bdialog.find('.btn-primary').focus();
    bdialog.on('keyup', function(evv){
      var character = String.fromCharCode(evv.which).toLowerCase();
      if( character != "" ){
        if( bdialog.find('.btn-default').text().toLowerCase().charAt(0) == character ){
          bdialog.find('.btn-default').click();
        }
        else if( bdialog.find('.btn-primary').text().toLowerCase().charAt(0) == character ){
          bdialog.find('.btn-primary').click();
        }
      }
    });
    bdialog.on('focus', '.btn-default', function() {
      $(this).prop('tabindex', 1);
      bdialog.find('.btn-primary').prop('tabindex', 2);
    });
    bdialog.on('focus', '.btn-primary', function() {
      $(this).prop('tabindex', 1);
      bdialog.find('.btn-default').prop('tabindex', 2);
    });
  });
}

$.fn.load_ajax = function(url, type, adtitional_data, redirect, callback){
  var self = this;
  var ajax_data = {};
  ajax_data[CSRF_NAME] = CSRF_HASH;
  if( adtitional_data != undefined ){
    ajax_data = Object.assign({},ajax_data, adtitional_data);
  }
  $.ajax({
      type: type==undefined?'GET':type,
      url: url,
      data: ajax_data,
      dataType: "JSON",
      beforeSend: function(){
        hideToastr();
        $('.loading-backdrop').fadeIn();
      },
      success: function(data) {
        if( data.status == "error" ){
          showToastr("error", data.message);
        }

        else if( data.status == "success" ){
          showToastr("success", data.message);
          if( $(self).is("table") ){
            self.dataTable()._fnReDraw();
          }
          if( redirect != undefined ){
            location.href = redirect;
          }
          if( callback != undefined ){
            callback.call(data);
          }
        }

        else if( data.status == "redirect" ){
          location.href = data.message;
        }
      },
      complete: function(){
        $('.loading-backdrop').fadeOut();
      }
  });
}

$.fn.create_datatable_action = function(icon, link, title, open_window, confirm, is_modal, is_ajax){
  var table = this;
  var onclick = "";
  var classes = ["dropdown-item"], attrs = "";
  open_window = open_window != undefined ? open_window : false;
  is_modal = is_modal != undefined ? is_modal : false;
  confirm = confirm != undefined ? confirm : false;
  is_ajax = is_ajax != undefined ? is_ajax : false;
  confirmMsg = globalLang['alert_confirmation'];
  if( is_modal ){
    if( typeof is_modal === "object" ){
      classes.push("large-modal");
      attrs = 'sis-modal="'+$(table).attr("id")+'"';
    }else{
      attrs = 'sis-modal="'+$(table).attr("id")+'"';
    }
  }
  if( open_window ){
    onclick = "onClick=\"MyWindow=window.open('"+link+"', WINDDOW_NAME,WINDDOW_CONFIGURATION); return false;\"";
    link = "#";
  }
  if( confirm ){
    if( is_ajax ){
      onclick = "onClick=\"bconfirm('"+confirmMsg+"', function(){$('#"+$(table).attr("id")+"').load_ajax('"+link+"');}); return false;\"";
    }else{
      onclick = "onClick=\"bconfirm('"+confirmMsg+"', function(){location='"+link+"';}); return false;\"";
    }
    link = "#";
  }else{
    if( is_ajax ){
      onclick = "onClick=\"$('#"+$(table).attr("id")+"').load_ajax('"+link+"'); return false;\"";
      link = "#";
    }
  }
  return "<li><a href=\""+link+"\" "+onclick+" class=\""+classes.join(" ")+"\" "+attrs+"><i class=\"fa fa-"+icon+"\"></i> "+title+"</a></li>";
}

function Format_Datetime(date_str) {
  if( date_str == "0000-00-00 00:00:00" || date_str == undefined || date_str == null || date_str == "" ){
    return "";
  }
  if( JS_DATE == undefined ){
    JS_DATE = "DD-MM-YYYY";
  }
  var m = new moment(date_str);
  return m.format(JS_DATE+" HH:mm:ss");
}

function Format_Date(date_str, y, obj, z) {
  if( date_str == "0000-00-00" || date_str == undefined || date_str == null || date_str == "" ){
    return "";
  }
  if( JS_DATE == undefined ){
    JS_DATE = "DD-MM-YYYY";
  }
  var m = new moment(date_str);
  return  m.format(JS_DATE);
}

function date_locale(date, from, to, js_format) {
  if( JS_DATE == undefined ){
    if( js_format == undefined ){
      JS_DATE = "DD-MM-YYYY";
    }else{
      JS_DATE = js_format;
    }
  }
  var m = new moment(date, JS_DATE, from);
  return  m.locale(to).format(JS_DATE);
}

function Format_Datetimestamp(timestamp) {
  if( JS_DATE == undefined ){
    JS_DATE = "DD-MM-YYYY";
  }
  var m = new moment(timestamp);
  return m.format(JS_DATE);
}

function Format_float(number, fixed) {
  if( ROUND_NUMBER != 0 ){
    number = Math.ceil(parseFloat(number) / ROUND_NUMBER) * ROUND_NUMBER;
  }
  fixed = fixed==undefined?DECIMAL_PLACE:fixed;
  var x = parseFloat(number);
  if( isNaN(x)){
    return 0;
  }
  if( parseInt(x) == parseFloat(x) ){
    return Math.round(x);
  }
  return x.toFixed(fixed);
}

function Format_size(bytes) {
    var thresh = 1024;
    if(Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }
    var units = ['kB','MB','GB','TB','PB','EB','ZB','YB'];
    var u = -1;
    do {
        bytes /= thresh;
        ++u;
    } while(Math.abs(bytes) >= thresh && u < units.length - 1);
    return bytes.toFixed(1)+' '+units[u];
}

function getFormatedCurrency(currency){
  return FORMATTED_CURRENCIES[currency].symbol_native;
}

function Format_Currency(number, data, row) {
  if( ROUND_NUMBER != 0 ){
    number = Math.ceil(parseFloat(number) / ROUND_NUMBER) * ROUND_NUMBER;
  }
  number = parseFloat(number).toFixed(DECIMAL_PLACE);
  var parts = number.toString().split(".");
  var currency = CURRENCY_SYMBOL;
  if( row != undefined && row.currency != undefined ){
    if( CURRENCY_FORMAT == '1'){
      currency = row.currency;
    }else{
      currency = getFormatedCurrency(row.currency);
    }
  }

  if( NUMBER_FORMAT == '1' ){
    x = ","; y = ".";
  }else if( NUMBER_FORMAT == '2' ){
    x = "."; y = ",";
  }else if( NUMBER_FORMAT == '3' ){
    x = " "; y = ",";
  }else if( NUMBER_FORMAT == '4' ){
    x = " "; y = ".";
  }else if( NUMBER_FORMAT == '5' ){
    x = "\'"; y = ",";
  }else if( NUMBER_FORMAT == '6' ){
    x = "\'"; y = ".";
  }else if( NUMBER_FORMAT == '7' ){
    x = ""; y = ".";
  }else if( NUMBER_FORMAT == '8' ){
    x = ""; y = ",";
  }
  value = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, x);
  value += DECIMAL_PLACE>0?(parts[1] ? y + parts[1] : y+"0".repeat(DECIMAL_PLACE)):"";
  if( CURRENCY_PLACE == "left" ){
    if( data == undefined )
      return value;
    else if( data == true )
      return currency + " " + value;
    else
      return "<div class='text-md-right' dir='ltr'><b>"+currency+"</b> "+value+"</div>";
  }else{
    if( data == undefined )
      return value;
    else if( data == true )
      return value + " " + currency;
    else
      return "<div class='text-md-right' dir='ltr'>"+value+" <b>"+currency+"</b></div>";
  }

}

function checkboxFormat(data, type, row, meta) {
  var html = '<div class="pure-checkbox"><input type="checkbox" data-id="'+row.id+'" class="row_checkbox" /><label></label></div>';
  return html;
}

function timeFormat(x) {
    var sec_num = parseInt(x, 10);
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}

function filter_format(html, filter, value, text) {
  return "<a href='#filter' class='text-inherit tip-datatable' data-text='"+text+"' title='"+globalLang["filter"]+"' data-filter='"+filter+"' data-value='"+value+"'>"+html+"</a>";
}

function str_replace(_search, _replace , _subject){
  if( _subject.search(_search) != -1 ){
    return str_replace(_search, _replace , _subject.replace(_search, _replace));
  }else{
    return _subject;
  }
}

function copy_text(text) {
  function selectElementText(element) {
    if (document.selection) {
      var range = document.body.createTextRange();
      range.moveToElementText(element);
      range.select();
    } else if (window.getSelection) {
      var range = document.createRange();
      range.selectNode(element);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
    }
  }
  var element = document.createElement('DIV');
  element.textContent = text;
  document.body.appendChild(element);
  selectElementText(element);
  document.execCommand('copy');
  element.remove();

  showToastr("success", globalLang["text_is_copied"]);
}

/* TOASTR PLUGIN OPTIONS */
if( toastr != undefined ){
  toastr.options = {
    "rtl" : globalLang["IS_RTL"],
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": globalLang["IS_RTL"]?"toast-top-left":"toast-top-right",
    "onclick": null,
    "showDuration": 500,
    "hideDuration": 200,
    "timeOut": "5000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  function showToastr(type, message){
    if( message == undefined ){
      message = type;
      type = "info";
    }
    message = str_replace("</p>", "", str_replace("<p>", "", message)).trim();
    if( message.indexOf("\n") != -1 )
      var messages = message.split("\n");
    else
      var messages = message.split("%n");
    for (var i = messages.length -1; i >= 0 ; i--) {
      if( type == "success" ){
        toastr.success(messages[i], globalLang["success"]);
      }
      else if( type == "error" ){
        toastr.error(messages[i], globalLang["error"]);
      }
      else{
        toastr.info(messages[i], globalLang["info"]);
      }
    }
  }

  function hideToastr(){
    toastr.remove();
  }
}


$.fn.show_errors = function(error_fields){
  var form = this;
  $(form).find(".form-group").removeClass("has-danger has-success");
  $(form).find(".nav-tabs li a").removeClass("text-danger");
  for (var field in error_fields) {
    $(form).find('*[name="'+field+'"]').parents(".form-group").addClass("has-danger");
    if( $(form).find('*[name="'+field+'"]').parents(".tab-pane").size() > 0 ){
      var tab = $(form).find('*[name="'+field+'"]').parents(".tab-pane").attr("id");
      $('[href="#'+tab+'"]').addClass("text-danger");
      if( $('[href="#'+tab+'"]').parents('.nav-item.dropdown').size() > 0 ){
        $('[href="#'+tab+'"]').parents('.nav-item.dropdown').find('a.dropdown-toggle').addClass('text-danger');
      }
    }
  }
  $(form).find(".form-group:not(.has-danger)").addClass("has-success");
  $(form).find(".nav-tabs li a:not(.text-danger)").addClass("text-success");
}


$.fn.sis_modal = function (params) {
  var defaults = {
    table: undefined,
    callback: undefined,
    dialog: null,
    is_big: false,
    title: "AJAX WINDOWS MODAL",
    button: undefined
  };
  var options = $.extend(defaults, params);
  var self = this;

  var methods = {
    init: function() {
      if( $(self).is("table") ){
        options.table = self;
      }
      if( options.button != undefined ){
        $(options.button).button("loading");
      }

      options.dialog = bootbox.dialog(
        '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> '+globalLang["loading"]+'</div>',
        {
          header: options.title
        }
      );

      if( options.is_big != undefined && options.is_big == true ){
        options.dialog.find('.modal-dialog').addClass("modal-lg");
      }

      $(options.dialog).keyup(function(ev){
        if( ev.keyCode == 27 ){
          $(this).modal("hide");
        }
      });

      $(options.dialog).click(function(ev) {
        if ( ev.target.className != "modal-content" && !$(ev.target).parents(".modal-content").size() ) {
          $(this).modal("hide");
        }
      });

      options.dialog.on("sis-callback", function(e, data){
        if( options.callback != undefined ){
          options.callback(data);
        }
        $(this).modal("hide");
      });
      options.dialog.find('.modal-footer').remove();
      methods.content();
    },
    content: function (){
      $.ajax({
          type: 'GET',
          url: options.url,
          data: { CSRF_NAME: CSRF_HASH },
          dataType: "HTML",
          //async: false,
          success: function(data, textStatus, jqXHR ) {
            try{
              var jsonObject = JSON.parse(data);
              //showToastr(jsonObject.status, jsonObject.message);
              if( jsonObject.status == "error" ){
                showToastr("error", jsonObject.message);
              }
              else if( jsonObject.status == "success" ){
                showToastr("success", jsonObject.message);
              }
              else if( jsonObject.status == "redirect" ){
                location.href = jsonObject.message;
                return false;
              }
              options.dialog.modal("hide");
              if( options.table != undefined ){
                options.table.dataTable()._fnReDraw();
              }
            }catch(e){
              methods.setcontent(data);
            }
          },
          complete: function(){
            if( options.button != undefined ){
              $(options.button).button("reset");
            }
          },
          error: function(){
            options.dialog.modal("hide");
            showToastr("error", "Communication with the server is lost!");
          }
      });
    },
    setcontent: function (htmlData){
      options.dialog.find('.modal-body').html(htmlData);
      if( options.dialog.find("form").size() > 0 ){

        options.dialog.on("shown.bs.modal", function(){
          if( $(this).find("form *[tabindex=1]").size() > 0 ){
            setTimeout(function(){
              options.dialog.find("form *[tabindex=1]").get(0).focus();
            }, 50);
            var inputs = $(this).find("form").find("input,select,textarea,button,a");
            tabindex = 2;
            $.each(inputs, function(i, input){
              if( $(input).attr("type") != "hidden" && !$(input).is("[tabindex]") ){
                $(input).attr("tabindex", tabindex++);
              }
            });
            options.dialog.find('.close').attr("tabindex", tabindex++);
          }
        });
        options.dialog.find("form").submit(function(ev){
          var form = this;
          var formData = $(this).serialize();
          $.ajax({
              type: 'POST',
              url: this.action,
              data: formData,
              dataType: "HTML",
              beforeSend: function(){
                $(form).find(':submit').button('loading');
                hideToastr();
              },
              success: function(data) {
                try{
                  var data = JSON.parse(data);
                  if( data.status == "error" ){
                    showToastr("error", data.message);
                  }
                  else if( data.status == "success" ){
                    showToastr("success", data.message);
                    $(form).closest(".modal").modal("hide");
                    if( options.table != undefined ){
                      options.table.dataTable()._fnReDraw();
                    }
                  }
                  else if( data.status == "redirect" ){
                    $(form).closest(".modal").modal("hide");
                    location.href = data.message;
                  }

                  if( data.fields != undefined ){
                    $(form).show_errors(data.fields);
                  }

                  if( options.callback != undefined ){
                    options.callback.call(data);
                  }
                }catch(e){
                  methods.setcontent(data);
                }

              },
              complete: function(){
                $(form).find(':submit').button('reset');
              },
              error: function(){
                options.dialog.modal("hide");
                showToastr("error", "Communication with the server is lost!");
              }
          });
          ev.preventDefault();
          return false;
        });

      } // endif
      setTimeout(function() {
        options.dialog.find('.modal-body').responsiveNavTabs();
      }, 150);
    }
  };
  methods.init();
}

$.fn.get_dataTable_data = function(){
  var output = [];
  if( $(this).is("table") ){
    var oSettings = this.dataTable().fnSettings();
    var headerCols = {};
    for (var j = 0; j < oSettings.aoColumns.length; j++) {
      col = oSettings.aoColumns[j];
      if( col.bVisible && $(col.nTh).text().trim() != "" ){
        headerCols[col.sName] = col.sName;
      }
    }
    for (var i = 0; i < oSettings.aoData.length; i++) {
      var line = {}, index = 0;
      for (var j = 0; j < oSettings.aoColumns.length; j++) {
        col = oSettings.aoColumns[j];
        if( col.bVisible && headerCols[col.sName] != undefined ){
          if( oSettings.aoData[i]._aData[col.sName] != undefined ){
            line[index++] = $(oSettings.aoData[i].anCells[j]).text();
          }else{
            line[index++] = "";
          }
        }
      }
      output.push(line);
    }
  }
  return output;
}
$.fn.get_dataTable_header = function(){
  var header = {};
  if( $(this).is("table") ){
    var oSettings = this.dataTable().fnSettings();
    var headerCols = {}, index = 0;
    for (var j = 0; j < oSettings.aoColumns.length; j++) {
      col = oSettings.aoColumns[j];
      if( col.bVisible && $(col.nTh).text().trim() != "" ){
        header[index++] = $(col.nTh).text();
        headerCols[col.sName] = col.sName;
      }
    }
  }
  return header;
}

function download_link(filename, url){
  if( $("#link_downloader").size() == 0 ){
    var a = $('<a id="link_downloader"></a>');
    $('body').append($(a));
  }else{
    var a = $("#link_downloader");
  }
  var link = a.get(0);
  link.href=url;
  link.download=filename;
  link.target="_BLANK";
  link.click();
}

function export_data(table, format){
  var data = $("#"+table).get_dataTable_data();
  var header = $("#"+table).get_dataTable_header();
  var title = $("title").text().trim();
  if( title.toLowerCase().indexOf(APP_DESCRIPTION.toLowerCase()) != -1 ){
    title = title.substring(APP_DESCRIPTION.length);
    title = APP_NAME+title;
  }
  var ajax_data = {};
  ajax_data[CSRF_NAME] = CSRF_HASH;
  $.ajax({
      type: "POST",
      url: SITE_URL+"/export_data/"+format,
      data: Object.assign({},ajax_data, {
        'title': title,
        'data' : data,
        'header': header
      }),
      beforeSend: function(){
        hideToastr();
        $('.loading-backdrop').fadeIn();
      },
      success: function(data, textStatus, xhr) {
        try{
          var fileName = xhr.getResponseHeader("Content-Disposition");
          fileName = fileName.substring(fileName.indexOf("filename=")+10, fileName.length-1);
          var blob = new Blob([data], { type: xhr.getResponseHeader("Content-Type") });
          var url = window.URL.createObjectURL(blob);
          download_link(fileName, url);
        }catch(e){
          console.error(e);
          $('.loading-backdrop').fadeOut();
        }
      },
      complete: function(){
        $('.loading-backdrop').fadeOut();
      }
  });
}

// BREADCRUMB
function create_breadcrumb(){
  if( breadcrumbs != undefined ){
    var breadcrumbs_list = [];

    if( breadcrumbs['home'] == breadcrumbs["class_label"] ){
      if( breadcrumbs['method'] != "index" ){
        breadcrumbs_list.push(create_breadcrumb_item("", SITE_URL, "home", false));
        if( additional_breadcrumbs != undefined ){
          for (var i = 0; i < additional_breadcrumbs.length; i++) {
            ab = additional_breadcrumbs[i];
            breadcrumbs_list.push(create_breadcrumb_item(ab.label, ab.link, false, false));
          }
        }
        breadcrumbs_list.push(create_breadcrumb_item(breadcrumbs['title'], "#", false, true));
      }
    }else{
      breadcrumbs_list.push(create_breadcrumb_item("", SITE_URL, "home", false));
      if( additional_breadcrumbs != undefined ){
        for (var i = 0; i < additional_breadcrumbs.length; i++) {
          ab = additional_breadcrumbs[i];
          breadcrumbs_list.push(create_breadcrumb_item(ab.label, ab.link, false, false));
        }
      }
      if( breadcrumbs['method'] == "index" ){
        breadcrumbs_list.push(create_breadcrumb_item(breadcrumbs['title'], "#", false, true));
      }else{
        breadcrumbs_list.push(create_breadcrumb_item(globalLang[breadcrumbs['class_label']], SITE_URL+"/"+breadcrumbs["class"], false, false));
        breadcrumbs_list.push(create_breadcrumb_item(breadcrumbs['title'], "#", false, true));
      }
    }
    if( breadcrumbs_list.length > 0 ){
      var breadcrumbs_ol = $('<ol class="breadcrumb2"></ol>');
      for (var i = 0; i < breadcrumbs_list.length; i++) {
        breadcrumbs_ol.append($(breadcrumbs_list[i]));
      }
      if( $('.breadcrumb').size() != 0 ){
        $(breadcrumbs_ol).insertAfter($('.breadcrumb'));
        breadcrumbs_ol.slideDown();
      }
    }
    function create_breadcrumb_item(label, url, icon, active){
      var icon = (icon!=undefined&&icon)?'<i class="fa fa-'+icon+'"></i> ':'';
      var classes = (active)?'class="active"':"";
      var link = (url=="#")?icon+label:'<a href="'+url+'" >'+icon+label+'</a>';
      return '<li '+classes+'>'+link+'</li>';
    }
  }
}

if( $('.actions-list').size() != 0 ){
  $(".actions-list").hide();
}

function actions_list(){
  if( $('.actions-list').size() == 0 ){
    return false;
  }
  $('.table').on("select-count", function(e){
      var table = $(this);
      var select_count = table.data("select-count");
      var selected_area = table.closest(".dataTables_wrapper").find('.select_area');
      if( select_count == 0 ){
        return false;
      }else if( select_count == 1 ){
        var list = $(table).find('tr.row_selected td:last-child ul').clone().html();
      }else{
        var list = $('.actions-list ul').clone().html();
      }
      var actions = $('<div class="btn-group"></div>');
      actions.append($('<a data-toggle="dropdown" class="btn btn-sm btn-secondary m-r-h dropdown-toggle"> <i class="fa fa-gear"></i></a>'));
      actions.append($('<ul class="dropdown-menu">'+list+'</ul>'));
      selected_area.prepend(actions);
      if( isMobile() ){
        $(actions).on("click", function(event){
          if( !$(this).is(".open") ){
            var header_title = "";
            if( $(this).attr("title") != undefined ){
              header_title = $(this).attr("title");
            }
            if( $(this).data("original-title") != undefined ){
              header_title = $(this).data("original-title");
            }
            $(this).find("ul").dropdownMobile(header_title);
          }
        });
      }
  });
}
function quick_actions(){
  if( isMobile() ){

  }
}

function datatable_contextmenu(){
  actions_list();
  quick_actions();
  $(".table tbody").on("contextmenu", "tr",function(e){
    e.stopPropagation();
    var tr = this;
    if( $(tr).find('td:last-child ul').size() == 0 ){
      return false;
    }
    if( $(tr).closest("table").data("select-count") == 0 ){
      $(tr).find('.pure-checkbox input[type=checkbox]').trigger("click");
    }else{
      if( !$(tr).is(".row_selected") ){
        $(tr).closest(".table").trigger("unselect_all");
        $(tr).find('.pure-checkbox input[type=checkbox]').trigger("click");
      }
    }

    if( $(tr).closest("table").data("select-count") > 1 ){
      if( $('.actions-list ul li').size() == 0 ){
        return false;
      }
      $('#sis_contextmenu').html($('.actions-list ul').clone().html());
    }else{
      $('#sis_contextmenu').html($(tr).find('td:last-child ul').clone().html());
    }
    var x = e.pageX, y = e.pageY;
    bodyW = $(document).width(); bodyH = $(document).height();
    contextW = $('#sis_contextmenu').width();
    contextH = $('#sis_contextmenu').height();
    if( x+contextW > bodyW ){
        x = bodyW-contextW-10;
    }

    if( x+contextW+200 > bodyW ){
        $('#sis_contextmenu').find('.dropdown-submenu').addClass('pull-right');
    }else{
        $('#sis_contextmenu').find('.dropdown-submenu').removeClass('pull-right');
    }

    if( y+contextH > bodyH ){
        y = bodyH-contextH-20;
    }

    if( isMobile() ) {
      $(this).find("ul").dropdownMobile();
    }else{
      $('#sis_contextmenu').css({
          'top': y,
          'left': x,
          'right': 'inherit',
          'position': 'absolute',
          'z-index': '9999',
      }).show();
    }
    return false;
  });

  var sis_contextmenu = $('<ul id="sis_contextmenu" class="dropdown-menu dropdown-menu-right"></ul>');
  $(sis_contextmenu).appendTo("body");

  $(document).bind("mouseup",function(e){
    $('#sis_contextmenu').hide();
  });
}

$(document).ready(function(){
  $(document).ajaxComplete(function(){
    showDropdownMobile();
  });
  showDropdownMobile();


  notificationsInterval = setInterval(function(){
    loadNotifications();
  },5000); // 5 seconds
  loadNotifications();
});

function showDropdownMobile(){
  if( !isMobile() ) {
    return false;
  }
  $(".dropdown-menu").closest(".btn-group").unbind("click");
  $(".dropdown-menu").closest(".btn-group").on("click", function(event){
    if( !$(this).is(".open") ){
      var header_title = "";
      if( $(this).attr("title") != undefined ){
        header_title = $(this).attr("title");
      }
      if( $(this).data("original-title") != undefined ){
        header_title = $(this).data("original-title");
      }
      $(this).find("ul").dropdownMobile(header_title);
    }
  });
}


$.fn.dropdownMobile = function(title){
    var parent = $(this).parent();
    var ul = this;
    $(ul).hide();
    var dropdown_dialog = bootbox.dialog('', [], {header: title});
    dropdown_dialog.addClass("modal-dropdown-mobile");
    dropdown_dialog.find('.modal-body').append(ul);
    $('.tooltip').hide();

    $(dropdown_dialog).keyup(function(ev){
      if( ev.keyCode == 27 ){
        $(this).modal("hide");
      }
    });

    $(dropdown_dialog).click(function(ev) {
      if ( ev.target.className != "modal-content" && !$(ev.target).parents(".modal-content").size() ) {
        $(this).modal("hide");
      }
    });

    $(dropdown_dialog).on("hidden.bs.modal", function(){
      var content = $(this).find('.modal-body').children();
      $(parent).append($(content));
    });
}

function isMobile(){
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

$.fn.textWidth = function(text, font) {
    if (!$.fn.textWidth.fakeEl)
      $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
};
$.fn.extendWidth = function(){
  var inputWidth = $(this).textWidth();
  $(this).css({width: inputWidth});
}


function loadNotifications(){
  var ajax_data = {};
  ajax_data[CSRF_NAME] = CSRF_HASH;
  $.ajax({
    type:'POST',
    url:SITE_URL+'/home/getNotifications',
    data: ajax_data,
    dataType: 'json',
    success:function(notifications) {
      $('.sis-notifications ul li').remove();
      if( notifications.length == 0 ){
        $('.sis-notifications .label').hide();
        $('.sis-notifications ul').append('<li class="text-xs-center text-muted small">'+globalLang["no_notifications"]+'</li>');
      }else{
        $('.sis-notifications .label').show().text(notifications.length);
        $.each(notifications, function(i, notification){
          $('.sis-notifications ul').append('<li><a href="'+notification.link+'">'+notification.label+'</a></li>');
        });
      }
    },
    complete:function(data) {
    }
  });
}


$.fn.responsiveNav = function(){
  var nav = this;
  var ul_w = $(nav).width();
  var li_w = 0;
  var li_i = undefined;
  $(nav).find('li').each(function(i){
    if( (li_w + $(this).width()) > ul_w ){
      li_i = Math.max(i-1, 1);
      return false;
    }
    li_w += $(this).width();
  });

  if( li_i != undefined ){
    var more = $('<li class="nav-item dropdown"></li>');
    $(more).append('<a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">'+globalLang['more']+'</a>');
    $(more).append('<ul class="dropdown-menu dropdown-menu-right"></ul>');
    $(nav).find('li').each(function(i){
      if( i >= li_i ){
        $(this).removeClass('nav-item');
        $(this).find('a').addClass("dropdown-item");
        $(more).find('ul').append($(this));
      }
    });
    $(nav).append(more).addClass("nav-more");
  }
}

$.fn.responsiveNavTabs = function(){
  $.each($(this).find('.bordered_tabs ul.nav-tabs:not(.nav-more)'), function(i, nav){
    $(nav).responsiveNav();
  });
}


function exchange_amount(amount, from, to, callback_func){
  from = from.toUpperCase();
  to = to.toUpperCase();
  $.ajax({
    url: 'https://api.openapi.ro/api/exchange',
    beforeSend: function(xhr){
      xhr.setRequestHeader('x-api-key', OPENAPI_KEY)
    },
    success: function(data){
      var result = {status: "error", content: "&nbsp;"};
      if( data.rates != undefined && (data.rates[from] != undefined || from=="RON") && (data.rates[to] != undefined || to=="RON") ){
        var exchange = amount;
        if( from == "RON" ){
          exchange = parseFloat(amount) / parseFloat(data.rates[to]);
        }
        else if( to == "RON" ){
          exchange = parseFloat(amount) * parseFloat(data.rates[from]);
        }
        else{
          x1 = parseFloat(amount) * parseFloat(data.rates[from]);
          exchange = x1 / parseFloat(data.rates[to]);
        }
        result = {status: "success", content: exchange};
      }else{
        if( data.rates[from] == undefined){
          result = {status: "error", content: "<small>"+from+"</small> "+globalLang["not_supported"]};
        }else if( data.rates[to] == undefined ){
          result = {status: "error", content: "<small>"+to+"</small> "+globalLang["not_supported"]};
        }
      }
      callback_func(result);
    },
    error: function(data){
      showToastr("error", data.responseJSON.error.description);
    }
  });
}

function createCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}
