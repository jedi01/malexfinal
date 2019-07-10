$(document).ready(function(){
  $('.navbar-mainmenu .nav > li.dropdown').click(function(ev){
    if( $(ev.target).parent().is(".dropdown-submenu") ){
      return false;
    }
    if( !$(this).is('.open') ){
      x = MK_configuration.is_rtl?$(this).offset().right:$(this).offset().left;
      ul_w = $(this).find('ul:eq(0)').width();
      body_w = $('body').width();
      condition = ((x+ul_w)  >=  body_w);
      condition = (MK_configuration.is_rtl && !$(this).is(".right"))?!condition:condition;
      if( condition ){
        $(this).find('ul:eq(0)').css({'left':'inherit', 'right':'0'});
      }else{
        $(this).find('ul:eq(0)').css({'left':'0', 'right':'inherit'});
      }
    }
  });

  $('button[data-toggle="collapse"]').on('click',function(){
    if( $('#collapse-navbar').is(".in") )
      $('#collapse-navbar').removeClass("in");
    else
      $('#collapse-navbar').addClass("in");
    return false;
  })

  $('a[href="#about"]').click(function(){
    about = '<center>'+
      '<h5>'+APP_DESCRIPTION+' <small>v '+APP_VER+'</small>'+'</h5><br /><br />'+
      '<img src="'+BASE_URL+'/assets/img/logo.png" width="50%"><br /><br /><br />'+
      '<small><b>Smart Invoice System</b> is a simple and powerful web app based on PHP CodeIgniter framework manage invoices &copy; 2017.<br />Powered by <a href="mailto:bessemzitouni@gmail.com">Bessem Zitouni</a></small>'+
      '</center>';
    bootbox.alert(about);
    return false;
  });

  $('.navbar-mainmenu .nav > li li.dropdown-submenu:has(ul)').hover(function(){
    x = $(this).offset().left + $(this).width();
    submenu = $(this).find('ul:eq(0)');
    ww = $(submenu).width();
    body_w = $('body').width();
    if( (x+ww)  >=  body_w){
      $(submenu).css('left', -ww);
    }
  }).hover(function(){
    $(this).addClass('open');
  }, function(){
    $(this).removeClass('open');
  });;

  $.fn.Navbar_KeyBoard = function(options){
    var defaults = {
    };
    var settings = $.extend(defaults, options);
    var navbar = $(this);
    var NAVBAR_Current_Niveau = 0;
    var NAVBAR_Current_Cursors = [];

    var li_list = [];
    $.each($(navbar).find('ul'), function(i, ul){
      var list = [];
      $.each($(ul).children(), function(i, li){
        if( $(li).find('a').size() > 0 ){
          content = $(li).find('a').first().children('span').text().trim();
          index = $(navbar).find('li').index($(li));
          if( content != '' ){
            list.push({'index':index, 'content':content});
          }
        }
      });
      li_list.push(list);
    });
    $.each(li_list, function(i, list){
      hints = [];
      $.each(list, function(i, row){
        k = 0;
        if( row.content != undefined && row.content.length > 1 ){
          while(k<row.content.length && $.inArray(row.content[k].toLowerCase(), hints) != -1 ){
            k++;
          }
          hints.push(row.content[k].toLowerCase());
          new_content = row.content.substring(0, k)+'<span class="hint">'+row.content[k]+'</span><span class="nohint">'+row.content[k]+'</span>'+row.content.substring(k+1);
          new_html = $(navbar).find('li:eq('+row.index+') > a > span').html().replace(row.content, new_content);
          $(navbar).find('li:eq('+row.index+') > a > span').html(new_html);
        }
      });
    });

    $(navbar).find('.nav > li > a').focus(function(){
      NAVBAR_Current_Cursors[1] = $(this).parent('li');
      NAVBAR_Current_Cursors[0] = $(this).parent('li');
      NAVBAR_Current_Niveau = 1;
    })
    .click(function(){
      $(this).focus();
    });

    $(navbar).find('.nav > li > ul > li > a').focus(function(){
      NAVBAR_Current_Cursors[2] = $(this).parent('li');
      NAVBAR_Current_Cursors[0] = $(this).parent('li');
      NAVBAR_Current_Niveau = 2;
    })
    .hover(function(){
      $(this).focus();
    });

    $(navbar).find('.nav > li > ul > li > ul > li > a').focus(function(){
      NAVBAR_Current_Cursors[3] = $(this).parent('li');
      NAVBAR_Current_Cursors[0] = $(this).parent('li');
      NAVBAR_Current_Niveau = 3;
    })
    .hover(function(){
      $(this).focus();
    });


    function closeOthers(){
      if( NAVBAR_Current_Niveau == 1 ){
        $(navbar).find('.nav > li').removeClass('open');
      }else if( NAVBAR_Current_Niveau == 2 ){
        $(navbar).find('.nav > li > ul > li').removeClass('open');
      }else if( NAVBAR_Current_Niveau == 3 ){
        $(navbar).find('.nav > li > ul > li > ul > li').removeClass('open');
      }
    }

    function isFirst(){
      if( $(NAVBAR_Current_Cursors[0]).index() == 0 ){
        return true;
      }
      return false;
    }

    function selectFirst(){
      closeOthers();
      if( isFirst() ){
        close();
        return false;
      }
      var prev = $(NAVBAR_Current_Cursors[0]).parent().children('li:first-child');
      var times = 0;
      while( $(prev).find('a').first().size() == 0 && times < 5){
        prev = $(prev).prev('li');
        times++;
      }
      $(prev).find('a').first().focus();
    };

    function selectLast(){
      closeOthers();
      var next = $(NAVBAR_Current_Cursors[0]).parent().children('li:last-child');
      var times = 0;
      while( $(next).find('a').first().size() == 0 && times < 5){
        next = $(next).next('li');
        times++;
      }
      $(next).find('a').first().focus();
    };

    function selectNext(){
      closeOthers();
      var next = $(NAVBAR_Current_Cursors[0]).next('li');
      var times = 0;
      while( $(next).find('a').first().size() == 0 && times < 5){
        next = $(next).next('li');
        times++;
      }
      $(next).find('a').first().focus();
    };

    function selectPrevious(){
      closeOthers();
      if( isFirst() ){
        close();
        return false;
      }
      var prev = $(NAVBAR_Current_Cursors[0]).prev('li');
      var times = 0;
      while( $(prev).find('a').first().size() == 0 && times < 5){
        prev = $(prev).prev('li');
        times++;
      }
      $(prev).find('a').first().focus();
    };

    function open(){
      closeOthers();
      if( $(NAVBAR_Current_Cursors[0]).has('ul').size() == 1 && !$(NAVBAR_Current_Cursors[0]).is('.open') ){
        $(NAVBAR_Current_Cursors[0]).addClass('open');
        $(NAVBAR_Current_Cursors[0]).find('li:eq(0)').find('a').first().focus();
      }
    };

    function close(){
      if( NAVBAR_Current_Niveau-1 != 0 ){
        if( $(NAVBAR_Current_Cursors[NAVBAR_Current_Niveau-1]).is('.open') ){
          NAVBAR_Current_Cursors.pop(NAVBAR_Current_Niveau);
          $(NAVBAR_Current_Cursors[NAVBAR_Current_Niveau-1]).removeClass('open');
          $(NAVBAR_Current_Cursors[NAVBAR_Current_Niveau-1]).find('a').first().focus();
        }
      }else{
        $(NAVBAR_Current_Cursors[1]).find('a').first().blur();
        NAVBAR_Current_Niveau = 0;
      }
    };

    $(document).keydown(function(ev){
      if( ev.altKey && !ev.ctrlKey ){
        $(navbar).find('.nav > li').removeClass('open');
        $(navbar).find('.nav > li:eq(0) > a').first().focus();
        ev.preventDefault();
        return false;
      }
    });

    $(navbar).find('.nav li').keypress(function(ev){
      stop_event = false;
      //keypressed = String.fromCharCode(ev.keyCode);
      keypressed = ev.key;
      ul = $(NAVBAR_Current_Cursors[0]).parent('ul');
      hints_in = [];
      $.each($(ul).children(), function(i, li){
        hint = $(li).find('a').first().find('.hint').text().toLowerCase();
        content = $(li).find('a').first().find('.hint').text();
        index = $(navbar).find('li').index($(li));
        if( content != '' ){
          hints_in.push({'index':index, 'content':content.toLowerCase()});
          hints_in.push({'index':index, 'content':content.toUpperCase()});
        }
      });
      exist = false;
      $.each(hints_in, function(i, row){
        if( row.content == keypressed ){
          exist = row.index;
          return;
        }
      });
      if( exist != false ){
        if( $(navbar).find('li:eq('+exist+') > a').first().attr('href') == '#' ){
          $(navbar).find('li:eq('+exist+') > a').first().focus();
          var ev2 = jQuery.Event("keydown");
          ev2.which = 13;
          ev2.keyCode = 13;
          $(navbar).find('.nav li').trigger(ev2);
        }else{
          $(navbar).find('li:eq('+exist+') > a').first().get(0).click();
        }
        ev.preventDefault();
        return false;
      }
    });

    $(navbar).find('.nav a')
    .focus(function(){
        $(navbar).addClass('show_hint');
    })
    .blur(function(){
        $(navbar).removeClass('show_hint');
    });

    $(navbar).find('.nav li').keydown(function(ev){
      stop_event = false;
      if( ev.altKey && !ev.ctrlKey ){ // ALT
        $(navbar).find('.nav > li').removeClass('open');
        $(navbar).find('.nav > li:eq(0) > a').first().focus();
        stop_event = true;
      }
      else if( ev.keyCode == 27 ){ // ESC
        close();
        stop_event = true;
      }
      else if( ev.keyCode == 13 ){ // ENTER
        if( $(NAVBAR_Current_Cursors[0]).find('a').first().attr('href') == '#' ){
          open();
          stop_event = true;
        }
      }
      else if( ev.keyCode == 37 ){ // LEFT
        if( NAVBAR_Current_Niveau == 1 ){
          selectPrevious();
        }else{
          close();
        }
        stop_event = true;
      }
      else if( ev.keyCode == 39 ){ // RIGHT
        if( NAVBAR_Current_Niveau == 1 ){
          selectNext();
        }else{
          open();
        }
        stop_event = true;
      }
      else if( ev.keyCode == 38 ){ // UP
        if( NAVBAR_Current_Niveau == 1 ){
          close();
        }else{
          selectPrevious();
        }
        stop_event = true;
      }
      else if( ev.keyCode == 40 ){ // DOWN
        if( NAVBAR_Current_Niveau == 1 ){
          open();
        }else{
          selectNext();
        }
        stop_event = true;
      }
      else if( ev.keyCode == 35 ){ // END
        selectLast();
        stop_event = true;
      }
      else if( ev.keyCode == 36 ){ // HOME
        selectFirst();
        stop_event = true;
      }
      if( stop_event ){
        ev.preventDefault();
        return false;
      }
    });

  };

  if( MK_configuration.hint ){
    $('.navbar-mainmenu:not(.no_hint)').Navbar_KeyBoard({});
  } // end if Keyboard is enabled


  /*
   * Keyboard Shortcuts
   */

  if( MK_configuration.keyboard_shortcut ){
    var specialKeys = { 8: "backspace", 9: "tab", 10: "return", 13: "enter", 16: "shift", 17: "ctrl", 18: "alt", 19: "pause", 20: "capslock", 27: "esc", 32: "space", 33: "pageup", 34: "pagedown", 35: "end", 36: "home", 37: "left", 38: "up", 39: "right", 40: "down", 45: "insert", 46: "del", 59: ";", 61: "=", 96: "0", 97: "1", 98: "2", 99: "3", 100: "4", 101: "5", 102: "6", 103: "7", 104: "8", 105: "9", 106: "*", 107: "+", 109: "-", 110: ".", 111: "/", 112: "f1", 113: "f2", 114: "f3", 115: "f4", 116: "f5", 117: "f6", 118: "f7", 119: "f8", 120: "f9", 121: "f10", 122: "f11", 123: "f12", 144: "numlock", 145: "scroll", 173: "-", 186: ";", 187: "=", 188: ",", 189: "-", 190: ".", 191: "/", 192: "`", 219: "[", 220: "\\", 221: "]", 222: "'"};
    var shortcut_help = [];

    if( shortcuts_list == undefined ){
      shortcuts_list = [];
    }

    $.each(shortcuts_list, function(i, shortcut){
      if( $(shortcut.selector).length == 0){
        return;
      }
      if( shortcut.keyChar == undefined || shortcut.keyChar == "undefined" || shortcut.keyChar == "" ){
        return;
      }

      var temp_keys = shortcut.keyChar.toLowerCase().split(/[\s+]+/), item_key = undefined;
      shortcut.isCtrl = shortcut.isShift = shortcut.isAlt = false;

      $.each(temp_keys, function(ik, key){
        if( key == 'ctrl' ){ shortcut.isCtrl = true; }
        else if( key == 'shift' ){ shortcut.isShift = true; }
        else if( key == 'alt' ){ shortcut.isAlt = true; }
        else { item_key = key; }
      });
      if( item_key == undefined /*$(item_key).length > 1*/){
        return false;
      }
      if( shortcut.displaychar != undefined && shortcut.displaychar != null ){
        $(shortcut.displaychar).append(' <small>['+shortcut.keyChar+']</small>');
      }

      if( shortcut.group == undefined ){
        shortcut_group = globalLang["main_menu"]
      }else{
        shortcut_group = shortcut.group;
      }

      shortcut_help.push({key: shortcut.keyChar, description: shortcut.description, group: shortcut_group});

      $(document)
      .keydown(function(event){
        var special = specialKeys[event.which];
        special = special==undefined?String.fromCharCode(event.which):special;
        special = special.toLowerCase();
        if(item_key == special && event.ctrlKey == shortcut.isCtrl && event.shiftKey == shortcut.isShift && event.altKey == shortcut.isAlt){

          event.preventDefault();
        }
      })
      .keyup(function(event){
        var special = specialKeys[event.which];
        special = special==undefined?String.fromCharCode(event.which):special;
        special = special.toLowerCase();
        if(item_key == special && event.ctrlKey == shortcut.isCtrl && event.shiftKey == shortcut.isShift && event.altKey == shortcut.isAlt){
          if( shortcut.click != undefined && shortcut.click != null ){
            setTimeout(function() {
              $(shortcut.click).get(0).click();
            }, 0);
          }
          if( shortcut.focus != undefined && shortcut.focus != null ){
            setTimeout(function() {
              $(':focus').blur();
              $(shortcut.focus).focus();
            }, 10);
          }
        }
      });
    });

    if( shortcut_help.length > 0 ){
      var shortcut_help_table = $('<table class="table table-sm table-striped table-hover" style="display: table;"></table>');
      $(shortcut_help_table).append('<thead><tr><th>'+globalLang["description"]+'</th><th style="text-align:center; width:180px;">'+globalLang["shortcut"]+'</th></tr></thead>');


      var s_h_last_group = undefined;
      $.each(shortcut_help, function(i, row){
        if( row.group != s_h_last_group ){
          $(shortcut_help_table).append('<tr class="shortcut_group"><th colspan="2">'+row.group+'</th></tr>');
        }
        s_h_last_group = row.group;
        ks = "<kbd>"+(row.key).toLowerCase().split("+").join("</kbd> + <kbd>")+"</kbd>";
        $(shortcut_help_table).append('<tr><td class="text-md-left">'+row.description+'</td><td class="text-md-center"><b>'+ks+'</b></td></tr>');
      });

      var modal_shortcut_help = bootbox.dialog(
        $(shortcut_help_table).get(0).outerHTML,
        [{
          "class" : "btn-default",
          "label" : globalLang["ok"],
          "attrs" : 'data-dismiss="modal" aria-hidden="true"'
        }],
        {
          "header": globalLang["shortcut_help_title"],
          "show": false
        }
      );
      modal_shortcut_help.removeClass('bootbox');
      modal_shortcut_help.addClass('modal_shortcut_help');
      modal_shortcut_help.find('.modal-body').addClass("p-a-0");
      modal_shortcut_help.hide();
      $(modal_shortcut_help).keyup(function(ev){
        if( ev.keyCode == 27 ){
          $(this).modal("hide");
        }
      });

      $(modal_shortcut_help).click(function(ev) {
        if ( ev.target.className != "modal-content" && !$(ev.target).parents(".modal-content").size() ) {
          $(this).modal("hide");
        }
      });


      $('a[href="#show_shortcut_help"]').click(function(){
        modal_shortcut_help.modal('show');
        modal_shortcut_help.one('shown.bs.modal', function(){
          modal_shortcut_help.find('.btn-default').focus();
          modal_shortcut_help.one('keyup', function(evv){
            if( modal_shortcut_help.is(':visible') && evv.keyCode == 27 ){
              $(modal_shortcut_help).find('.btn-default').click();
            }
          });
        });
        modal_shortcut_help.one('keyup', '.btn-default', function(evv){
          if( evv.keyCode == 27 ){
            $(this).click();
          }
        });
        return false;
      });
    }else{
      $('a[href="#show_shortcut_help"]').remove();
    }
  } // end if Hint is enabled

});
