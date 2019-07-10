<!-- Page Header -->
<div class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading;?></div>
    </div>
    <div class="flip pull-right" style="line-height: 64px;">
        <a href="#create-reminder" class="btn btn-primary-outline tip" title="<?php echo lang("add"); ?>"> <i class="fa fa-plus"></i></a>
        <a href="#refresh-calendar" title="<?php echo lang("refresh"); ?>" class="btn btn-primary-outline tip"><i class="fa fa-refresh"></i></a>
    </div>
</div>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <div style="max-heights:550px;">
                    <div id="calendar-tile">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url("assets/vendor/fullcalendar/js/moment.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendor/fullcalendar/js/fullcalendar.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendor/fullcalendar/js/lang-all.js") ?>"></script>
<link rel=stylesheet href="<?php echo base_url("assets/vendor/fullcalendar/fullcalendar.css") ?>">
<script type="text/javascript">
function createFullCalendar(){
    var mainHeight = $(window).height() - 200 - 35;
    $('#calendar').fullCalendar({
        lang: '<?php echo MIN_LANG ?>',
        isRTL: globalLang['IS_RTL'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: false
        },
        defaultView: 'month',
        editable: true,
        allDaySlot: false,
        timeFormat: 'H:mm',
        lazyFetching: true,
        contentHeight: Math.max(550,mainHeight),
        events: getFullCalendarEvents,
        dayClick: dayClick,
        eventRender: eventRender,
        eventDrop: eventDrop,
        eventDragStart: eventDragStart,
        eventResize: false
    });
    if( globalLang['IS_RTL'] ){
        $('#calendar').removeClass('fc-ltr').addClass("fc-rtl");
    }
}

function scheduleRefetchEvents() {
    $("#calendar").fullCalendar('refetchEvents');
}

function dayClick(date, allDay, jsEvent, view){
    $(document).sis_modal({
        title : "",
        url   : SITE_URL+'/calendar/add?date='+date.locale("en").format("YYYY-MM-DD"),
        is_big: false,
        callback: function(data){
            scheduleRefetchEvents();
        }
    });
}

function eventRender(event, element, view) {
    $(element).addClass("fc-show-instance-"+event.id);
    $(element).data("event", event);
    if( event.editable ){
        $(element).addClass("editable");
    }
    if( event.repeat_type != -1 ){
        element[0].draggable  = false;
        element[0].ondragstart = function(){return false};
    }
    $(element).find(".fc-event-time").remove();
    $(element).find(".fc-event-title").before(' <i class="fa fa-refresh" /> ');
    if( event.editable ){
        $(element).popover({
            placement: 'bottom',
            template: '<div class="popover"><div class="arrow"></div><div class="popover-content"></div></div>',
            content:'<ul>'+
            '<a style="box-sizing: border-box;" data-id="'+event.id+'" class="edit_event text-inherit dropdown-item"><i class="fa fa-pencil"></i>'+globalLang["edit"]+'</a>'+
            '<a style="box-sizing: border-box;" data-id="'+event.id+'" class="dropdown-item delete_event text-inherit"><i class="fa fa-trash"></i>'+globalLang["delete"]+'</a>'+
            '</ul>',
            container: 'body',
            html:true,
        }).attr("data-toggle", "popover");
    }
}

function eventDragStart( event, jsEvent, ui, view ) {
    if( event.repeat_type != -1 ){
        return false;
    }
}

function eventDrop(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
    if( event.repeat_type != -1 ){
        return false;
    }
    var ajax_data = {
        day: dayDelta,
        id: event.id,
    };
    ajax_data[CSRF_NAME] = CSRF_HASH;
    $.ajax({
        url: SITE_URL+'/calendar/moveShow',
        data: ajax_data,
        dataType: 'JSON',
        type: 'POST',
        success: function(data){
            if( data.status == "success" ){
                scheduleRefetchEvents();
                closeAddShowForm(jsEvent);
            }else{
                console.error(data.message);
            }
        }
    });
}

function getFullCalendarEvents(start, end, timezone, callback) {
    var ajax_data = {
      start: start.locale("en").format("YYYY-MM-DD"),
      end: end.locale("en").format("YYYY-MM-DD")
    };
    ajax_data[CSRF_NAME] = CSRF_HASH;
    $.ajax({
        url: SITE_URL+'/calendar/eventsfeed',
        data: ajax_data,
        dataType: 'JSON',
        type: 'POST',
        success: function(json){
            callback(json);
        }
    });
    $(".fc-button").addClass("btn btn-success").removeClass('fc-button fc-state-default fc-corner-right btn-small');
    $(".fc-button-prev, .fc-button-next").addClass("btn-primary");
    $(".fc-button-prev").html("<i class='fa fa-chevron-left'></i>");
    $(".fc-button-next").html("<i class='fa fa-chevron-right'></i>");
}

$(document).ready(function() {
    $(document).on("click", '.delete_event', function(e){
        id = $(this).data("id");
        var data = {id: id};
        bconfirm(globalLang['alert_confirmation'], function(){
            $('#invoices_table').load_ajax(SITE_URL+"/calendar/delete", 'POST', data, undefined, function(data){
                scheduleRefetchEvents();
            });
        });
    });

    $(document).on("click", '.edit_event', function(e){
        id = $(this).data("id");
        $(document).sis_modal({
            title : "",
            url   : SITE_URL+'/calendar/edit/'+id,
            is_big: false,
            callback: function(data){
                scheduleRefetchEvents();
            }
        });
    });

    $('a[href="#create-reminder"]').on('click', function() {
        var button = this;
        $(document).sis_modal({
            title : "",
            url   : SITE_URL+'/calendar/add',
            is_big: false,
            button: button,
            callback: function(data){
                scheduleRefetchEvents();
            }
        });
        return false;
    });

    $('a[href="#refresh-calendar"]').on('click', function() {
        scheduleRefetchEvents();
        return false;
    });
    createFullCalendar();
});
</script>
