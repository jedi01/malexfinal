<div class="chat" style="display: none;">
  <div class="chat-header clearfix">
    <div class="chat-about">
      <span class="chat-status"><i class="fa fa-circle"></i></span>
      <div class="chat-with"></div>
    </div>
    <span class="label label-danger label-pill" style="display: none;">0</span>
    <button type="button" class="pull-right btn btn-transparent btn-sm close-chat" title="<?php echo lang("close") ?>">
      <i class="fa fa-close"></i>
    </button>
    <?php if (USER_ID == $this->settings_model->SYS_Settings->chat_support_id): ?>
      <button type="button" class="pull-right btn btn-transparent btn-sm delete-conversation" title="<?php echo lang("delete_conversation") ?>">
        <i class="fa fa-trash"></i>
      </button>
    <?php endif ?>
  </div> <!-- end chat-header -->
  <div class="chat-content">
    <div class="chat-history">
      <ul></ul>
    </div> <!-- end chat-history -->
    <div class="chat-message clearfix">
      <textarea placeholder ="<?php echo lang("type_your_message") ?>" rows="1"></textarea>
      <button class="btn btn-default" id="send-btn"><i class="icon-paper-plane"></i></button>
    </div> <!-- end chat-message -->
  </div>
</div> <!-- end chat -->

<aside class="aside-menu">
  <div class="people-list" id="people-list">
      <div class="search" style="display: none;">
        <input type="text" placeholder="search" />
        <i class="fa fa-search"></i>
      </div>
      <ul class="list"></ul>
    </div>
</aside>

<script type="text/javascript">
jQuery.fn.setConversation = function(args){
  var defaults = {
    'title': '',
    'user_id':'1',
    'my_id_user': '<?php echo USER_ID; ?>',
    'refreshTime' : 5000,
    'init': false,
    'page': 0,
    'sound' : true,
  };
  var options = $.extend(defaults,args);
  var chat_inner = $(this);
  var box = $(this).find('.chat-history');
  var title = $(chat_inner).find('.chat-with');
  var updateMessage, last_page_title, get_message_request, interval;

  var sound = $('<audio id="chatAudio"><source src="'+BASE_URL+'assets/media/chat-sound/notify.ogg" type="audio/ogg"><source src="'+BASE_URL+'assets/media/chat-sound/notify.mp3" type="audio/mpeg"><source src="'+BASE_URL+'assets/media/chat-sound/notify.wav" type="audio/wav"></audio>');

  function init(){
    $(title).html('<b>'+options.title+'</b> ');
    $(box).find('li').remove();

    updateMessage = true;
    last_page_title = $('title').text();
    options.page = 0;
    get_message_request = null;
  };

  $(chat_inner).on('init', function(e, args){
    options = $.extend(defaults,args);
    init();
  });

  $(chat_inner).on('close', function(){
    if(get_message_request != null){
      get_message_request.abort();
    }
    $(title).html('');
    $(box).find('li').remove();
    $('.people-list').trigger('removeSelected');
    $(chat_inner).find('.chat-message textarea').val("");
    $(chat_inner).hide();
  });

  $(chat_inner).on('delete_conversation', function(){
    bconfirm(globalLang['alert_confirmation'], function(){
      $(box).find('li').remove();
      var ajax_data = {
        'user_id' : options.user_id,
      };
      ajax_data[CSRF_NAME] = CSRF_HASH;
      $.ajax({
        type:'POST',
        url: SITE_URL+'/home/delete_conversation',
        data:ajax_data,
        dataType: 'json'
      });
    });
  });

  $(".chat-history").click(function(){
    $(".chat textarea").focus();
    return false;
  });

  var is_scroll = false; var last_scroll = -1;
  $(box).on("scroll",function(e){
    is_scroll = true;
  })
  .on("mouseup",function(e){
    if( is_scroll ){
      is_scroll = last_scroll != $(box).scrollTop();
    }
    if( is_scroll && $(box).scrollTop() == 0 ){
      e.preventDefault();
      $(box).getMessages(options.page+1);
    }
    last_scroll = $(box).scrollTop();
    is_scroll = false;
  });

  jQuery.fn.addMessage = function(message, ul){
    if( $(ul).find('li').size() == 0 ){
      var ul = $(this).find('ul');
    }
    var last_user = ul.find('li:last-child').attr('user_id');
    if( message.user_id == last_user ){
      var li = ul.find('li:last-child');
      var content = $(li).find('.message');

      msg2 = '<div class="clearfix header" message_id="message-'+message.id+'">';
      //msg2 += '<small class="message-time pull-right text-muted"><i class="fa fa-clock-o"></i></small>';
      msg2 += '</div>';
      msg2 += '<span class="tip" title="'+message.message_time+'">'+message.content+'</span>';

      content.append(msg2);
      $(box).scrollTop($(box).prop('scrollHeight'));
      last_scroll = $(box).scrollTop();
    }else{
      return $(this).createMessage(message);
    }
  };

  jQuery.fn.createMessage = function(message){
    message_postion = message.user_id==options.my_id_user?'right':'left';
    is_my = message.user_id==options.my_id_user?'other-message float-right':'my-message';
    user_name = message.user_id==options.my_id_user?message.user_name:options.title;

    li = '<li class="clearfix" user_id="'+message.user_id+'">'+
        '<div class="message-data align-'+message_postion+'">'+
          '<span class="message-data-name" >'+user_name+'</span>'+
        '</div>'+
        '<div class="message '+is_my+'">'+
          '<div class="clearfix header" message_id="message-'+message.id+'">'+
            '<span class="tip" title="'+message.message_time+'">'+message.content+'</span>'+
          '</div>'+
        '</div>'+
      '</li>';
    return $(li);
  };


  function refreshMessageList(messagesList, append_in){
    // add & update
    var ul = $('<ul></ul>');
    for (var i = messagesList.length - 1; i >= 0; i--) {
      message = messagesList[i];
      if( $(box).find('ul li .header[message_id=message-'+message.id+']').size() == 0 ){
        // ADD
        li = $(box).addMessage(message, ul);
        $(ul).append(li);
      }else{
        // UPDATE
        var span = $(box).find('ul li .header[message_id=message-'+message.id+'] .message-time');
        $(span).text(message.message_time);
      }
    };
    var before_height = $(box).prop('scrollHeight');
    if( append_in == 'top' ){
      $(box).find('ul').prepend($(ul).html());
    }else{
      $(box).find('ul').append($(ul).html());
    }

    if( append_in == 'bottom' && $(ul).html().trim().length != 0 ){
      $(box).scrollTop($(box).prop('scrollHeight'));
      last_scroll = $(box).scrollTop();
    }
    if( append_in == 'top' && $(ul).html().trim().length != 0 ){
      $(box).scrollTop(($(box).prop('scrollHeight')-before_height));
      last_scroll = $(box).scrollTop();
    }

    $('title').text(last_page_title);
  };

  var last_messagesList = undefined;
  jQuery.fn.notifNewMessage = function(messagesList){
    // notif New Message
    var there_new = false;
    var new_message_number = 0;
    for (var i = 0; i < messagesList.length; i++) {
      if( $(box).find('ul li .header[message_id=message-'+messagesList[i].id+']').size() == 0 ){
        new_message_number++;
        there_new = true;
        break;
      }
    };
    if( there_new && messagesList[i].id != last_messagesList ){
      if( options.sound ){
        sound.get(0).play();
      }
      $('.chat-header .label').show().text(new_message_number);
      $('title').text(globalLang['chat_new_message_from']+" : "+messagesList[i].user_name);
      last_messagesList = messagesList[i].id;
    }
  };

  $(chat_inner).on('document_focus', function(){
    $('title').text(last_page_title);
    $('.chat-header .label').hide().text(0);
    updateMessage = true;
  });

  $(chat_inner).on('document_blur', function(){
    updateMessage = false;
  });

  jQuery.fn.getMessages = function(page){
    if( page == undefined ){
      page = 0;
      append_in = 'bottom';
    }else{
      append_in = 'top';
    }
    if( !$(".chat-content").is(":visible") ){
      return false;
    }
    var self= $(this);
    var messagesList = new Array();

    var ajax_data = {
      'user_id' : options.user_id,
      'page' : page
    };
    ajax_data[CSRF_NAME] = CSRF_HASH;
    get_message_request = $.ajax({
      type:'POST',
      url: SITE_URL+'/home/getConversation_with_user',
      data:ajax_data,
      dataType: 'json',
      success:function(data) {
        $.each(data, function(i, message){
          messagesList.push(message);
        });
        if( data.length != 0 && page != 0 ){
          options.page = options.page+1;
        }
      },
      complete:function(data) {
        if( updateMessage == true ){
          refreshMessageList(messagesList, append_in);
        }else{
          $(box).notifNewMessage(messagesList);
        }
      }
    });
  };

  $(chat_inner).on('send_message', function(){
    textarea = $(chat_inner).find('.chat-message textarea');
    if( $(textarea).val().trim() == "" ){
      return false;
    }
    var message = new Object();
    message.content = $(textarea).val().trim();
    $(textarea).val('');
    message.to = options.user_id;
    var ajax_data = {
      'content' : message.content,
      'to' : message.to
    };
    ajax_data[CSRF_NAME] = CSRF_HASH;
    $.ajax({
      type:'POST',
      url:SITE_URL+'/home/send_message',
      data: ajax_data,
      success:function(data) {
        $(box).getMessages();
      }
    });
  });

  $(chat_inner).on('typing', function(){

  });


  if( options.init ){
    init();
  }

  // USERS LIST
  jQuery.fn.UserOnline = function(args){
    var bar_user_online = $(this);
    var userList = new Array();

    function addUser(user){
      is_active = user.online=="1"?"active":"";
      badge_display = user.new_message_number==0?" style='display:none' ":"";
      is_online = user.online=="1"?"online":"offline";
      tooltip = (user.online=="1"?globalLang["online"]:(user.last_message_old==""?globalLang['offline']:user.last_message_old));
      li = '<li id="'+user.id+'" status="'+user.online+'" class="clearfix user-tips '+is_active+'" title="'+tooltip+'" tabindex="-1">'+
            '<a class="about" href="#">'+
              '<i class="fa fa-circle '+is_online+'"></i> '+
              '<div class="name">'+user.name+'</div>'+
              '<small class="user-nmn chat-alert label label-danger label-pill pull-right" '+badge_display+'>'+user.new_message_number+'</small>'+
              '<small class="status text-muted">'+
                (user.online=="1"?globalLang["online"]:user.last_message_old)+
              '</small>'+
            '</a>'+
          '</li>';
      return $(li);
    };

    jQuery.fn.refreshUserList = function(new_user_List){
      if( bar_user_online.find("li").size() == 0 ){
        users_groups = <?php echo json_encode($this->ion_auth->groups()->result_array()); ?>;
        for (var i = 0; i < users_groups.length; i++) {
          if( users_groups[i].name != "supplier" && users_groups[i].name != "superadmin" ){
            bar_user_online.find(".list").append($('<li class="users_group text-xs-center text-muted" group-id="'+users_groups[i].id+'">'+globalLang["role_"+(users_groups[i].name.toLowerCase())]+'</li>'));
          }
        }
      }
      bar_user_online.find('li:not(.users_group)').each(function(){
        var id = $(this).attr('id');
        var status = $(this).attr('status');
        var exist = false;
        for (var i = 0; i < new_user_List.length; i++) {
          if( new_user_List[i].id == id ){
            exist = true;
            // change status
            if( new_user_List[i].online != status ){
              $(this).replaceWith(addUser(new_user_List[i]));
            }
          }
        };
        if( !exist ){
          $(this).remove();
        };
      });

      $.each( new_user_List , function(i, user){
        if( bar_user_online.find('li#'+user.id).size() == 0 ){
          addUser(user).insertAfter(bar_user_online.find(".list li.users_group[group-id='"+user.group_id+"']"));
        }else{
          current_user = bar_user_online.find('li#'+user.id);
          if( user.online ){
            $(current_user).addClass('active');
          }else{
            $(current_user).removeClass('active');
          }
          $(current_user).find('.last-message').html(user.last_message);
          $(current_user).find('.time').text(user.last_message_old);
          if( user.new_message_number != '0' && !current_user.is('.selected') ){
            $(current_user).find('.user-nmn').show().text(user.new_message_number);
          }else{
            $(current_user).find('.user-nmn').hide();
          }

        }
      });
      $('.user-tips').tooltip({placement:'left', container: 'body'});
    };

    jQuery.fn.getUsers = function(){
      var self= $(this);
      var current_user_List = new Array();
      $.ajax({
        type:'POST',
        url:SITE_URL+'/home/getUsersOnline',
        data: CSRF_DATA,
        dataType: 'json',
        success:function(data) {
          $.each(data, function(i, user){
            current_user_List.push(user);
            if( user.id == $(bar_user_online).find("li.selected").attr('id')  ){
              if( user.new_message_number > 0 ){
                $('.chat-header .label').show().text(user.new_message_number);
              }else{
                $('.chat-header .label').hide().text(0);
              }
              if( user.online == "1" ){
                $('.chat-header .chat-status').addClass('online').removeClass("offline");
              }else{
                $('.chat-header .chat-status').addClass('offline').removeClass("online");
              }
            }
          });
        },
        complete:function(data) {
          $(bar_user_online).refreshUserList(current_user_List);
        }
      });
    };

    $(bar_user_online).on('click', 'li:not(.users_group)', function(){
      $('.chat').trigger('close');
      var user = new Object();
      user.id = $(this).attr('id');
      user.name = $(this).find('.name').text();
      $('.chat').trigger('init',[{
        'user_id': user.id,
        'title' : user.name
      }]);
      $(bar_user_online).trigger('removeSelected');
      $(this).addClass('selected');
      $(this).find('.user-nmn').hide();
      $('.aside-menu').removeClass("open");
      $('.chat').show(function(){
        $(".chat-content").slideDown(function(){
          resizeChatWindow();
        });
        $(".chat textarea").focus();
      });
      return false;
    });

    $(bar_user_online).on('removeSelected', function(){
      $(this).find('li').removeClass('selected');
    });
  };

  // MESSAGES COUNTER
  jQuery.fn.getMessage_count = function(){
    var self= $(this);
    $.ajax({
      type:'POST',
      url:SITE_URL+'/home/getMessage_count',
      data: CSRF_DATA,
      dataType: 'json',
      success:function(data) {
        if( data > 0 ){
          $(self).show().text(data);
          $('.chat-toggler-btn .label').show().text(data);
        }else{
          $(self).hide().text('');
          $('.chat-toggler-btn .label').hide().text('');
        }
      }
    });
  };

  $(".chat-history").ready(function(){
    $(".chat-history").getMessages();
    $('.people-list').getUsers();
    $('.message-count').getMessage_count();
  });

  interval = setInterval(function(){
    $(".chat-history").getMessages();
    $('.people-list').getUsers();
    $('.message-count').getMessage_count();
  },options.refreshTime);

  $('.people-list').UserOnline();
};

function resizeChatWindow(){
  if( isMobile() ){
    $('.chat-history').height($(window).height()-($(".chat").outerHeight()-$(".chat-history").height()));
  }
}

$(document).ready(function(){
  $(window).on('focus', function(){
    $('.chat').trigger('document_focus');
    $('.people-list').trigger('document_focus');
    $('.message-count').trigger('document_focus');
  });

  $(window).on('blur', function(){
    $('.chat').trigger('document_blur');
    $('.people-list').trigger('document_blur');
    $('.message-count').trigger('document_blur');
  });

  $('.chat-message #send-btn').on('click', function(){
    $('.chat').trigger('send_message');
  });

  $('.chat-message textarea').on('keypress', function(e){
    if( e.keyCode == 13 ){
      $('.chat-message #send-btn').click();
      e.preventDefault();
      return false;
    }else{
      $('.chat').trigger('typing');
    }
  });
  $('.chat-header').on('click', function(ev){
    if( $(ev.target).is(".chat-header") || $(ev.target).parents(".chat-about").size() != 0 ){
      $('.chat-content').slideToggle('fast');
    }
    else if( $(ev.target).is(".close-chat") || $(ev.target).parents(".close-chat").size() != 0 ){
      $('.chat').trigger('close');
    }
    else if( $(ev.target).is(".delete-conversation") || $(ev.target).parents(".delete-conversation").size() != 0 ){
      $('.chat').trigger('delete_conversation');
    }
  });

  $('.chat').setConversation();

  $('.chat-toggler-btn .aside-toggle').click(function(){
    <?php if (USER_ID == $this->settings_model->SYS_Settings->chat_support_id): ?>
    $('.aside-menu').toggleClass("open");
    <?php else: ?>
      $('.chat').trigger('init',[{
        'user_id': '<?php echo $this->settings_model->SYS_Settings->chat_support_id ?>',
        'title' : '<?php echo $this->settings_model->SYS_Settings->chat_support_label ?>'
      }]);
      $('.chat').show(function(){
        $(".chat-content").slideDown();
        $(".chat textarea").focus();
      });
    <?php endif ?>
  });
});
</script>
