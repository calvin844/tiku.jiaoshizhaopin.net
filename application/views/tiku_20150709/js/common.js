/*头部顶部菜单宽度自适应 begin
 var window_w = $(window).width();
 var top_w = window_w - 450;
 var old_w = 0;
 $('.header .top ul.left li').each(function(){
 old_w += $(this).width();
 })
 $('.header .top ul.left').css('max-width',top_w);
 if(old_w > top_w){
 var li_w = 0;
 var i = 0;
 $('.header .top ul.left li').each(function(){
 if(i < 5){
 li_w += $(this).width();
 i++;
 }
 })
 $('.header .top a.more').show();
 $('.header .top ul.left').css('max-width',li_w+5);
 $('.header .top ul.left').css('height','32px');
 $('.header .top ul.left').css('overflow','hidden');
 $('.header .top div.top_nav').mouseover(function(){
 $('.header .top a.more').hide();
 $('.header .top ul.left').css('max-width',top_w);
 $('.header .top ul.left').css('height','auto');
 $('.header .top ul.left').css('overflow','auto');
 $('.header .top ').css('height','auto');
 })
 $('.header .top div.top_nav').mouseleave(function(){
 $('.header .top a.more').show();
 $('.header .top ul.left').css('max-width',li_w+5);
 $('.header .top ul.left').css('height','32px');
 $('.header .top ul.left').css('overflow','hidden');
 $('.header .top ').css('height','32px');
 })
 }
 头部顶部菜单宽度自适应 end*/

/*头部用户菜单显示 begin*/
$('.header div.user_box').mouseover(function() {
    $('.header div.user_box ul').show();
});
$('.header div.user_box ul').mouseleave(function() {
    $('.header div.user_box ul').hide();
});
$('.header div.user_box').mouseleave(function() {
    $('.header div.user_box ul').hide();
});
/*头部用户菜单显示 end*/

/*考点菜单展开与隐藏 begin*/
//主方法
function set_menu(type, click_name, ico_name, parent_id_name, id_name, open_class, close_class) {
    $(click_name).live('click', function() {
        var level = $(this).parent().attr('class');
        var data_id = $(this).parent().attr(id_name);
        var data_arr = [level, data_id, ico_name, parent_id_name, id_name, open_class, close_class];
        var this_td = $(this);
        if (this_td.find(ico_name).hasClass(close_class)) {
            this_td.find(ico_name).removeClass(close_class);
            this_td.find(ico_name).addClass(open_class);
            while ($('.' + data_arr[0]).length > 0) {
                data_arr = hide_chidren(data_arr, type);
            }
        } else if (this_td.find(ico_name).hasClass(open_class)) {
            this_td.find(ico_name).removeClass(open_class);
            this_td.find(ico_name).addClass(close_class);
            if (type == 'all') {
                this_td.parent().nextAll().each(function() {
                    if ($(this).attr(parent_id_name) == data_id) {
                        $(this).find(ico_name).removeClass(close_class);
                        $(this).find(ico_name).addClass(open_class);
                        $(this).show();
                    }
                })
            } else if (type == 'part') {
                this_td.parent().nextAll().each(function() {
                    if ($(this).attr(parent_id_name) == data_id) {
                        $(this).attr('show', 1)
                    }
                })
                while ($('.' + data_arr[0]).length > 0) {
                    data_arr = show_chidren(data_arr);
                }
            }
        }

    })
}


//隐藏全部下级子菜单
function hide_chidren(data_arr, type) {
    if (data_arr[1].indexOf(',') > -1) {
        id_arr = data_arr[1].split(',');
    } else {
        id_arr = [data_arr[1]];
    }
    var num = parseInt(data_arr[0].substr(5));
    var chidren_level = "level" + (num + 1);
    var id_str = "";
    if ($('.' + chidren_level).length > 0) {
        for (var i = 0; i < id_arr.length; i++) {
            $('.' + chidren_level).each(function() {
                if ($(this).attr(data_arr[3]) == id_arr[i]) {
                    id_str += $(this).attr(data_arr[4]) + ",";
                    if (type == 'all') {
                        $(this).find(data_arr[2]).removeClass(data_arr[6]);
                        $(this).find(data_arr[2]).addClass(data_arr[5]);
                        $(this).attr('show', 0);
                    } else if (type == 'part') {
                        if ($(this).is(":visible")) {
                            $(this).attr('show', 1);
                        } else {
                            $(this).attr('show', 0);
                        }
                    }
                    $(this).hide();
                }
            })
        }
    }
    id_str = id_str.substr(0, id_str.length - 1);
    var return_arr = [chidren_level, id_str, data_arr[2], data_arr[3], data_arr[4], data_arr[5], data_arr[6]];
    return return_arr;
}

//按状态显示下级子菜单
function show_chidren(data_arr) {
    if (data_arr[1].indexOf(',') > -1) {
        id_arr = data_arr[1].split(',');
    } else {
        id_arr = [data_arr[1]];
    }
    var num = parseInt(data_arr[0].substr(5));
    var chidren_level = "level" + (num + 1);
    var id_str = "";
    if ($('.' + chidren_level).length > 0) {
        for (var i = 0; i < id_arr.length; i++) {
            $('.' + chidren_level).each(function() {
                if ($(this).attr(data_arr[3]) == id_arr[i]) {
                    id_str += $(this).attr(data_arr[4]) + ",";
                    if ($(this).attr('show') == 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            })
        }
    }
    id_str = id_str.substr(0, id_str.length - 1);
    var return_arr = [chidren_level, id_str, data_arr[2], data_arr[3], data_arr[4]];
    return return_arr;
}
/*考点菜单展开与隐藏 end*/

/*返回顶部 begin*/
$(function() {
    var returnop = $(".back-to-top");
    returnop.on("click", function() {
        $("html,body").animate({scrollTop: 0}, 100);
    });
    $(window).scroll(function() {
        var currTop = $(document).scrollTop();
        if (currTop <= 100) {
            returnop.hide();
        } else {
            returnop.show();
        }
    });
});
/*返回顶部 end*/

/*初始化答题卡跟随 begin*/
function answers_list_init() {
    var list_height = $('div.answers_list').height();
    var title_height = $('div.answers_list div.title').height();
    var list_width = $('div.answers_list').width();
    var list_top = $('div.answers_box').offset().top;
    var title_bottom = list_top + title_height;
    $('div.answers_list').find('ul').hide();
    var currBottom = $(document).scrollTop() + $(window).height();
    if (currBottom > title_bottom) {
        $('div.answers_list').addClass('absolute');
        $('div.answers_list').find('ul').removeAttr('style');
        $('div.answers_list').find('ul').show();
    } else {
        if ($('div.answers_list div.title span').hasClass('up')) {
            $('div.answers_list').find('ul').hide();
        }
        $('div.answers_list').removeClass('absolute');
    }
}
/*初始化答题卡跟随 end*/


/*设置页面标题 begin*/
var n1 = $('div.header div.nav_box ul.right li a.cur').html();
var n2 = $('div.header div.house_box a.cur').html();
var n3 = "";
if ($('div.exercise div.list_box ul li.cur').length > 0) {
    n3 = " - " + $('div.exercise div.list_box ul li.cur a').html();
} else if ($('div.list_box div.right_box p.top_title').length > 0) {
    n3 = " - " + $('div.list_box div.right_box p.top_title').html();
}
if (typeof(n1) == "undefined") {
    $('head title').html("教师能力测试");
} else {
    $('head title').html(n1 + " - " + n2 + n3);
}
/*设置页面标题 end*/