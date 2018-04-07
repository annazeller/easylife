jQuery(function($) {

    'use strict';

    var ULTRA_SETTINGS = window.ULTRA_SETTINGS || {};



    /*--------------------------------
         Window Based Layout
     --------------------------------*/
    ULTRA_SETTINGS.windowBasedLayout = function() {
        var width = window.innerWidth;
        //console.log(width);

        if ($("body").hasClass("chat-open") || $("body").hasClass("sidebar-collapse")) {

            ULTRA_SETTINGS.mainmenuCollapsed();

        } else if (width < 1025) {

            // small window
            $(".page-topbar").addClass("sidebar_shift").removeClass("chat_shift");
            $(".page-sidebar").addClass("collapseit").removeClass("expandit");
            $("#main-content").addClass("sidebar_shift").removeClass("chat_shift");
            $(".page-chatapi").removeClass("showit").addClass("hideit");
            $(".chatapi-windows").removeClass("showit").addClass("hideit");
            ULTRA_SETTINGS.mainmenuCollapsed();

        } else {

            // large window
            $(".page-topbar").removeClass("sidebar_shift chat_shift");
            $(".page-sidebar").removeClass("collapseit chat_shift");
            $("#main-content").removeClass("sidebar_shift chat_shift");
            ULTRA_SETTINGS.mainmenuScroll();
        }


    }



    /*--------------------------------
         Window Based Layout
     --------------------------------*/
    ULTRA_SETTINGS.onLoadTopBar = function() {
        
            $(".page-topbar .message-toggle-wrapper").addClass("showopacity");
            $(".page-topbar .notify-toggle-wrapper").addClass("showopacity");
            $(".page-topbar .searchform").addClass("showopacity");
            $(".page-topbar li.profile").addClass("showopacity");
    }



    /*--------------------------------
         CHAT API
     --------------------------------*/
    ULTRA_SETTINGS.chatAPI = function() {


        $('.page-topbar .toggle_chat').on('click', function() {
            var chatarea = $(".page-chatapi");
            var chatwindow = $(".chatapi-windows");
            var topbar = $(".page-topbar");
            var mainarea = $("#main-content");
            var menuarea = $(".page-sidebar");

            if (chatarea.hasClass("hideit")) {
                chatarea.addClass("showit").removeClass("hideit");
                chatwindow.addClass("showit").removeClass("hideit");
                topbar.addClass("chat_shift");
                mainarea.addClass("chat_shift");
                menuarea.addClass("chat_shift");
                ULTRA_SETTINGS.mainmenuCollapsed();
            } else {
                chatarea.addClass("hideit").removeClass("showit");
                chatwindow.addClass("hideit").removeClass("showit");
                topbar.removeClass("chat_shift");
                mainarea.removeClass("chat_shift");
                menuarea.removeClass("chat_shift");
                //ULTRA_SETTINGS.mainmenuScroll();
                ULTRA_SETTINGS.windowBasedLayout();
            }
        });

        $('.page-topbar .sidebar_toggle').on('click', function() {
            var chatarea = $(".page-chatapi");
            var chatwindow = $(".chatapi-windows");
            var topbar = $(".page-topbar");
            var mainarea = $("#main-content");
            var menuarea = $(".page-sidebar");

            if (menuarea.hasClass("collapseit") || menuarea.hasClass("chat_shift")) {
                menuarea.addClass("expandit").removeClass("collapseit").removeClass("chat_shift");
                topbar.removeClass("sidebar_shift").removeClass("chat_shift");
                mainarea.removeClass("sidebar_shift").removeClass("chat_shift");
                chatarea.addClass("hideit").removeClass("showit");
                chatwindow.addClass("hideit").removeClass("showit");
                ULTRA_SETTINGS.mainmenuScroll();
            } else {
                menuarea.addClass("collapseit").removeClass("expandit").removeClass("chat_shift");
                topbar.addClass("sidebar_shift").removeClass("chat_shift");
                mainarea.addClass("sidebar_shift").removeClass("chat_shift");
                ULTRA_SETTINGS.mainmenuCollapsed();
            }
        });

    };



    /*--------------------------------
         CHAT API window
     --------------------------------*/
    ULTRA_SETTINGS.chatApiWindow = function() {

        var chatarea = $(".page-chatapi");

        $('.page-chatapi .user-row').on('click', function() {

            var name = $(this).find(".user-info h4 a").html();
            var img = $(this).find(".user-img a img").attr("src");
            var id = $(this).attr("data-user-id");
            var status = $(this).find(".user-info .status").attr("data-status");

            if ($(this).hasClass("active")) {
                $(this).toggleClass("active");

                $(".chatapi-windows #user-window" + id).hide();

            } else {
                $(this).toggleClass("active");

                if ($(".chatapi-windows #user-window" + id).length) {

                    $(".chatapi-windows #user-window" + id).removeClass("minimizeit").show();

                } else {
                    var msg = chatformat_msg('Wow! What a Beautiful theme!', 'receive', name);
                    msg += chatformat_msg('Yes! Ultra Admin Theme ;)', 'sent', 'You');
                    var html = "<div class='user-window' id='user-window" + id + "' data-user-id='" + id + "'>";
                    html += "<div class='controlbar'><img src='" + img + "' data-user-id='" + id + "' rel='tooltip' data-animate='animated fadeIn' data-toggle='tooltip' data-original-title='" + name + "' data-placement='top' data-color-class='primary'><span class='status " + status + "'><i class='fa fa-circle'></i></span><span class='name'>" + name + "</span><span class='opts'><i class='fa fa-times closeit' data-user-id='" + id + "'></i><i class='fa fa-minus minimizeit' data-user-id='" + id + "'></i></span></div>";
                    html += "<div class='chatarea'>" + msg + "</div>";
                    html += "<div class='typearea'><input type='text' data-user-id='" + id + "' placeholder='Type & Enter' class='form-control'></div>";
                    html += "</div>";
                    $(".chatapi-windows").append(html);
                }
            }

        });

        $(document).on('click', ".chatapi-windows .user-window .controlbar .closeit", function(e) {
            var id = $(this).attr("data-user-id");
            $(".chatapi-windows #user-window" + id).hide();
            $(".page-chatapi .user-row#chat_user_" + id).removeClass("active");
        });

        $(document).on('click', ".chatapi-windows .user-window .controlbar img, .chatapi-windows .user-window .controlbar .minimizeit", function(e) {
            var id = $(this).attr("data-user-id");

            if (!$(".chatapi-windows #user-window" + id).hasClass("minimizeit")) {
                $(".chatapi-windows #user-window" + id).addClass("minimizeit");
                ULTRA_SETTINGS.tooltipsPopovers();
            } else {
                $(".chatapi-windows #user-window" + id).removeClass("minimizeit");
            }

        });

        $(document).on('keypress', ".chatapi-windows .user-window .typearea input", function(e) {
            if (e.keyCode == 13) {
                var id = $(this).attr("data-user-id");
                var msg = $(this).val();
                msg = chatformat_msg(msg, 'sent', 'You');
                $(".chatapi-windows #user-window" + id + " .chatarea").append(msg);
                $(this).val("");
                $(this).focus();
            }
            $(".chatapi-windows #user-window" + id + " .chatarea").perfectScrollbar({
                suppressScrollX: true
            });
        });

    };

    function chatformat_msg(msg, type, name) {
        var d = new Date();
        var h = d.getHours();
        var m = d.getMinutes();
        return "<div class='chatmsg msg_" + type + "'><span class='name'>" + name + "</span><span class='text'>" + msg + "</span><span class='ts'>" + h + ":" + m + "</span></div>";
    }



    /*--------------------------------
        Viewport Checker
     --------------------------------*/
    ULTRA_SETTINGS.viewportElement = function() {

        if ($.isFunction($.fn.viewportChecker)) {

            $('.inviewport').viewportChecker({
                callbackFunction: function(elem, action) {
                    //setTimeout(function(){
                    //elem.html((action == "add") ? 'Callback with 500ms timeout: added class' : 'Callback with 500ms timeout: removed class');
                    //},500);
                }
            });


            $('.number_counter').viewportChecker({
                classToAdd: 'start_timer',
                offset: 10,
                callbackFunction: function(elem) {
                    $('.start_timer:not(.counted)').each(count);
                    //$(elem).removeClass('number_counter');
                }
            });

        }

        // start count
        function count(options) {
            var $this = $(this);
            options = $.extend({}, options || {}, $this.data('countToOptions') || {});
            $this.countTo(options).addClass("counted");
        }
    };



    /*--------------------------------
         Breadcrumb autoHidden
     --------------------------------*/
    ULTRA_SETTINGS.breadcrumbAutoHidden = function() {

        $('.breadcrumb.auto-hidden a').on('mouseover', function() {
            $(this).removeClass("collapsed");
        });
        $('.breadcrumb.auto-hidden a').on('mouseout', function() {
            $(this).addClass("collapsed");
        });

    };



    /*--------------------------------
         Section Box Actions
     --------------------------------*/
    ULTRA_SETTINGS.sectionBoxActions = function() {

        $('section.box .actions .box_toggle').on('click', function() {

            var content = $(this).parent().parent().parent().find(".content-body");
            if (content.hasClass("collapsed")) {
                content.removeClass("collapsed").slideDown(500);
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            } else {
                content.addClass("collapsed").slideUp(500);
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            }

        });

        $('section.box .actions .box_close').on('click', function() {
            content = $(this).parent().parent().parent().remove();
        });



    };



    /*--------------------------------
         Main Menu Scroll
     --------------------------------*/
    ULTRA_SETTINGS.mainmenuScroll = function() {

        //console.log("expand scroll menu");

        var topbar = $(".page-topbar").height();
        var projectinfo = $(".project-info").innerHeight();

        var height = window.innerHeight - topbar - projectinfo;

        $('#main-menu-wrapper').height(height).perfectScrollbar({
            suppressScrollX: true
        });
        $("#main-menu-wrapper .wraplist").height('auto');


        /*show first sub menu of open menu item only - opened after closed*/
        // > in the selector is used to select only immediate elements and not the inner nested elements.
        $("li.open > .sub-menu").attr("style", "display:block;");


    };



    /*--------------------------------
         Collapsed Main Menu
     --------------------------------*/
    ULTRA_SETTINGS.mainmenuCollapsed = function() {

        if ($(".page-sidebar.chat_shift #main-menu-wrapper").length > 0 || $(".page-sidebar.collapseit #main-menu-wrapper").length > 0) {
            //console.log("collapse menu");
            var topbar = $(".page-topbar").height();
            var windowheight = window.innerHeight;
            var minheight = windowheight - topbar;
            var fullheight = $(".page-container #main-content .wrapper").height();

            var height = fullheight;

            if (fullheight < minheight) {
                height = minheight;
            }

            $('#main-menu-wrapper').perfectScrollbar('destroy');

            $('.page-sidebar.chat_shift #main-menu-wrapper .wraplist, .page-sidebar.collapseit #main-menu-wrapper .wraplist').height(height);

            /*hide sub menu of open menu item*/
            $("li.open .sub-menu").attr("style", "");

        }

    };



    /*--------------------------------
         Main Menu
     --------------------------------*/
    ULTRA_SETTINGS.mainMenu = function() {
        $('#main-menu-wrapper li a').click(function(e) {

            if ($(this).next().hasClass('sub-menu') === false) {
                return;
            }

            var parent = $(this).parent().parent();
            var sub = $(this).next();

            parent.children('li.open').children('.sub-menu').slideUp(200);
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li').removeClass('open');

            if (sub.is(":visible")) {
                $(this).find(".arrow").removeClass("open");
                sub.slideUp(200);
            } else {
                $(this).parent().addClass("open");
                $(this).find(".arrow").addClass("open");
                sub.slideDown(200);
            }

        });

        $("body").click(function(e) {
            $(".page-sidebar.collapseit .wraplist li.open .sub-menu").attr("style","");
            $(".page-sidebar.collapseit .wraplist li.open").removeClass("open");
            $(".page-sidebar.chat_shift .wraplist li.open .sub-menu").attr("style","");
            $(".page-sidebar.chat_shift .wraplist li.open").removeClass("open");
        });

    };



    /*--------------------------------
         Extra form settings
     --------------------------------*/
    ULTRA_SETTINGS.extraFormSettings = function() {

        // transparent input group focus/blur
        $('.input-group .form-control').focus(function(e) {
            $(this).parent().find(".input-group-addon").addClass("input-focus");
            $(this).parent().find(".input-group-btn").addClass("input-focus");
        });

        $('.input-group .form-control').blur(function(e) {
            $(this).parent().find(".input-group-addon").removeClass("input-focus");
            $(this).parent().find(".input-group-btn").removeClass("input-focus");
        });

    };



    /*--------------------------------
        Widgets
     --------------------------------*/
    ULTRA_SETTINGS.ultraWidgets = function() {

        /*notification widget*/
        var notif_widget = $(".notification-widget").height();
        $('.notification-widget').height(notif_widget).perfectScrollbar({
            suppressScrollX: true
        });

    };



    // Element Attribute Helper
    function getValue($el, data_var, default_val) {
        if (typeof $el.data(data_var) != 'undefined') {
            return $el.data(data_var);
        }

        return default_val;
    }

/*--------------------------------
         Login Page
     --------------------------------*/
    ULTRA_SETTINGS.loginPage = function() {

        var height = window.innerHeight;
        var formheight = $("#login").height();
        var newheight = (height - formheight) / 2;
        //console.log(height+" - "+ formheight + " / "+ newheight);
        $('#login').css('margin-top', +newheight + 'px');

        if ($('#login #user_login').length) {
            var d = document.getElementById('user_login');
            d.focus();
        }

    };


    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
        ULTRA_SETTINGS.windowBasedLayout();
        ULTRA_SETTINGS.mainmenuScroll();
        ULTRA_SETTINGS.mainMenu();
        ULTRA_SETTINGS.mainmenuCollapsed();
        ULTRA_SETTINGS.extraFormSettings();
        ULTRA_SETTINGS.breadcrumbAutoHidden();
        ULTRA_SETTINGS.chatAPI();
        ULTRA_SETTINGS.chatApiWindow();
        ULTRA_SETTINGS.ultraWidgets();
        ULTRA_SETTINGS.sectionBoxActions();
        ULTRA_SETTINGS.viewportElement();
        ULTRA_SETTINGS.onLoadTopBar();
   });

    $(window).resize(function() {
        ULTRA_SETTINGS.windowBasedLayout();
        ULTRA_SETTINGS.loginPage();
    });

    $(window).load(function() {
        ULTRA_SETTINGS.loginPage();
    });

});