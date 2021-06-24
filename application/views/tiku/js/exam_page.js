$(window).scroll(function() {
    var left_box = $('div.list_box ul.left_box');
    var currTop = $(document).scrollTop();
    var paperTitle = $('div.right_box p.top_title');
    var item_title_box = $('div.right_box div.item_title_box');
    //左侧菜单跟随
    if (left_box.length > 0 && currTop >= paperTitle.offset().top) {
        left_box.addClass("flow");
    } else {
        left_box.removeClass("flow");
    }

    //顶部题目类型导航跟随
    if (item_title_box.length > 0 && currTop >= item_title_box.offset().top) {
        item_title_box.find('ul').addClass("flow");
    } else {
        item_title_box.find('ul').removeClass("flow");
    }
});

//倒计时
var timer = null;
function set_time() {
    var time_box = $('div.list_box ul.left_box li.time_box p');
    var time_pause = parseInt(time_box.attr('time-pause'));
    var time_elapsed = parseInt(time_box.attr('time-elapsed'));
    //是否暂停中
    if (time_pause == 0) {
        var time_data = parseInt(time_box.attr('time-data'));
        var time_str = "";
        var time_tmp = time_data;

        if (time_tmp == 0) {
            //到时警告
            alert('该交卷了！');
        } else if (time_tmp < 0) {
            //超时继续计时
            time_tmp = time_data * -1;
            time_str = "-";
        }
        var minutes = Math.floor(time_tmp / 60) < 10 ? "0" + Math.floor(time_tmp / 60) : Math.floor(time_tmp / 60);
        var second = Math.floor(time_tmp % 60) < 10 ? "0" + Math.floor(time_tmp % 60) : Math.floor(time_tmp % 60);
        time_str = time_str + minutes + ":" + second;
        time_box.html(time_str);
        time_data = time_data - 1;
        time_box.attr('time-data', time_data);
    }
    //记录用户总用时
    time_elapsed = time_elapsed + 1;
    time_box.attr('time-elapsed', time_elapsed);
}
//顺计时
function set_time2() {
    var time_box = $('div.list_box ul.left_box li.time_box p');
    var time_pause = parseInt(time_box.attr('time-pause'));
    var time_elapsed = parseInt(time_box.attr('time-elapsed'));
    //是否暂停中
    if (time_pause == 0) {
        var time_data = parseInt(time_box.attr('time-data'));
        var time_str = "";
        var time_tmp = time_data;
        var minutes = Math.floor(time_tmp / 60) < 10 ? "0" + Math.floor(time_tmp / 60) : Math.floor(time_tmp / 60);
        var second = Math.floor(time_tmp % 60) < 10 ? "0" + Math.floor(time_tmp % 60) : Math.floor(time_tmp % 60);
        time_str = time_str + minutes + ":" + second;
        time_box.html(time_str);
        time_data = time_data + 1;
        time_box.attr('time-data', time_data);
    }
    //记录用户总用时
    time_elapsed = time_elapsed + 1;
    time_box.attr('time-elapsed', time_elapsed);
}
var time_box = $('div.list_box ul.left_box li.time_box p');
var time_init = parseInt(time_box.attr('time-data'));
if (time_init > 0) {
    set_time();
    if ($('input#usetime').length > 0) {
        var usetime = $('input#usetime').attr('value');
        time_box.attr('time-data', time_init - usetime);
    }
    timer = window.setInterval(set_time, 1000);
} else {
    set_time2();
    if ($('input#usetime').length > 0) {
        var usetime = $('input#usetime').attr('value');
        time_box.attr('time-data', time_init + usetime);
    }
    timer = window.setInterval(set_time2, 1000);
}

//暂停按钮
$('div.list_box ul.left_box li a.time_pause').click(function() {
    $('div.list_box ul.left_box li.time_box p').attr('time-pause', 1);
    $('div.black_bg').show();
    $('div.time_pause_box').show();
})

//继续做题
$('div.time_pause_box a').click(function() {
    $('div.list_box ul.left_box li.time_box p').attr('time-pause', 0);
    $('div.black_bg').hide();
    $('div.time_pause_box').hide();
})


//下次再做
$('div.list_box ul.left_box li a.next_time').click(function() {
    var a = 0;
    var answer_str = "";
    $('div.item_box').each(function(){
        var question_id = $(this).find('div.answers').find('a').attr('favor-id');
        var question_score = $(this).attr('score');
        answer_str += question_id + "-" + $(this).attr('user-answer') + "-" + question_score + "##";
    })
    $('form#submit_form').find($("[name='answer_str']")).attr('value', answer_str);
    $('form#submit_form').find($("[name='is_complete']")).attr('value', 1);
    $('form#submit_form').find($("[name='complete_question']")).attr('value', parseInt(a));
    var usetime = $('li.time_box').find('p').attr('time-elapsed');
    $('form#submit_form').find($("[name='usetime']")).attr('value', parseInt(usetime));
    $('form#submit_form').submit();
})

//弹出交卷提示窗口
$('div.list_box ul.left_box li a.submit').click(function() {
    var no_do_num = $('div.answers_list a.answers_a').length;
    $('div.list_box ul.left_box li.time_box p').attr('time-pause', 1);
    if (no_do_num > 0) {
        $('div.submit_box p').html("还剩" + no_do_num + "道题未答完，确定要交卷吗？");
    } else {
        $('div.submit_box p').html("确定要交卷吗？");
    }
    $('div.black_bg').show();
    $('div.submit_box').show();
})

//点击交卷提示窗口的继续做题
$('div.submit_box a.cancel').click(function() {
    $('div.list_box ul.left_box li.time_box p').attr('time-pause', 0);
    $('div.black_bg').hide();
    $('div.submit_box').hide();
})
//点击交卷提示窗口的确认提交
$('div.submit_box a.sure').live('click', function() {
    var a = 0;
    var answer_str = "";
    $('div.item_box').each(function() {
        var answer_id = $(this).attr('user-answer');
        if (answer_id != 0) {
            a++;
            var question_id = $(this).attr('id');
            question_id = question_id.substr(9);
            var question_score = $(this).attr('score');
            answer_str += question_id + "-" + answer_id + "-" + question_score + "##";
        }
    });
    $('form#submit_form').find($("[name='answer_str']")).attr('value', answer_str);
    $('form#submit_form').find($("[name='is_complete']")).attr('value', 2);
    $('form#submit_form').find($("[name='complete_question']")).attr('value', parseInt(a));
    var usetime = $('li.time_box').find('p').attr('time-elapsed');
    $('form#submit_form').find($("[name='usetime']")).attr('value', parseInt(usetime));
    $('form#submit_form').submit();
})

//切换试题类型
$('div.list_box div.right_box div#part_1').show();
$('div.list_box div.right_box p#part_1').show();
$('div.list_box div.right_box div.item_title_box ul li a').live('click', function() {
    $('div.list_box div.right_box div.item_title_box ul li').removeClass('cur');
    $(this).parent().addClass('cur');
    var part_id = $(this).attr('id');
    $('div.list_box div.right_box div.question_list').hide();
    $('div.list_box div.right_box p.item_description_box').hide();
    $('div.list_box div.right_box div#' + part_id).show();
    $('div.list_box div.right_box p#' + part_id).show();
    $("html,body").animate({scrollTop: $('div.item_title_box').offset().top}, 500);
    answers_list_init()
});

//鼠标划过答案提示
$('div.right_box div.question_box div.answers ul li').live('mouseover', function() {
    var a_id = $(this).attr('id');
    $('div.right_box div.question_box div.options ul li#' + a_id).css('background', '#e8e8e8');
})
$('div.right_box div.question_box div.answers ul li').live('mouseleave', function() {
    var a_id = $(this).attr('id');
    $('div.right_box div.question_box div.options ul li#' + a_id).css('background', 'none');
})

//点击选择答案
$('div.right_box div.question_box div.answers ul li').live('click', function() {
    if ($(this).parent().hasClass('type_1')) {
        $(this).siblings().find('span.active').hide();
    }
    if ($(this).parent().hasClass('type_2')) {
        if ($(this).find('span.active').is(':visible')) {
            $(this).find('span.active').hide();
        } else {
            $(this).find('span.active').css('display', 'block');
        }
    } else {
        $(this).find('span.active').css('display', 'block');
    }
    var question_id = $(this).parents('div.item_box').attr('id');
    var a_str = "";
    $(this).parent().find('li').each(function() {
        if ($(this).find('span.active').is(':visible')) {
            a_str += $(this).attr('answer-id') + ",";
        }
    })
    a_str = a_str.substr(0, a_str.length - 1);
    $(this).parents('div.item_box').attr('user-answer', a_str);
    var part_id = $(this).parents('div.question_list').attr('id');
    var n = 0;
    $('div.answers_list a').each(function() {
        if ($(this).attr('question-data') == question_id) {
            $(this).removeClass('answers_a');
            $(this).addClass('over');
        }
        if ($(this).hasClass('over') && $(this).attr('part-data') == part_id) {
            n++;
        }
    })
    $('a#' + part_id + ' label.answer-count').html(n);

    var next = $(this).parents('div.item_box').next();
    var next_id = next.attr('id');
    if (typeof (next_id) == "undefined") {
        var next_part_id = part_id.substr(5);
        next_part_id = "part_" + (parseInt(next_part_id) + 1);
        next_id = $('div#' + next_part_id).find('div:first').attr('id');
        $('div.item_title_box ul li a#' + next_part_id).click();
    }
    if ($('div#' + next_id).length > 0 && $(this).parent().hasClass('type_1')) {
        $("html,body").animate({scrollTop: ($('div#' + next_id).offset().top - 50)}, 200);
    }
})

//材料题窗口操作
//最小化
$('div.right_box div.material_box div.title_box a.m_xiao').live('click', function() {
    $(this).parents('div.material_box').find('div.content_box').slideUp(500);
    $(this).hide();
    $(this).parent().find('a.m_show').css('display', 'inline-block');
    answers_list_init()
})
//恢复大小
$('div.right_box div.material_box div.title_box a.m_show').live('click', function() {
    $(this).parents('div.material_box').find('div.content_box').slideDown(500);
    $(this).hide();
    $(this).parent().find('a.m_xiao').css('display', 'inline-block');
    answers_list_init()
})
//全屏
$('div.right_box div.material_box div.title_box a.m_quan').live('click', function() {
    var html_str = $(this).parents('div.material_box').find('div.content_box div.content_overflow').html();
    $('body').css('overflow', 'hidden');
    $('div.big_material_box div.content_box').html(html_str);
    $('div.big_material_box').show();
})
//关闭全屏
$('div.big_material_box a.m_close').live('click', function() {
    $('div.main').show();
    $('body').css('overflow', 'auto');
    $('div.big_material_box div.content_box').html("");
    $('div.big_material_box').hide();
})

//点击进入下一部分
$('a.next_part').live('click', function() {
    var part_id = $(this).parent().attr('id');
    var part_num = part_id.substr(5);
    if ($('div.item_title_box ul li a#part_' + (parseInt(part_num) + 1)).length > 0) {
        $('div.item_title_box ul li a#part_' + (parseInt(part_num) + 1)).click();
    }
    answers_list_init()
})

//点击答题卡跟随
var list_height = $('div.answers_list').height();
var title_height = $('div.answers_list div.title').height();
var list_width = $('div.answers_list').width();
$('div.answers_box').height(list_height);
$('div.answers_box').width(list_width);
var list_top = $('div.answers_box').offset().top;
var title_bottom = list_top + title_height;
$('div.answers_list').find('ul').hide();
$(window).scroll(function() {
    var list_top = $('div.answers_box').offset().top;
    var title_bottom = list_top + title_height;
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
})

//收起和展开答题卡
$('div.answers_list div.title').live('click', function() {
    if ($(this).find('span').hasClass('up')) {
        if (!$(this).parent().hasClass('absolute')) {
            $(this).find('span').removeClass('up');
            $(this).find('span').addClass('down');
            $(this).find('p').html('收起答题卡');
            $('div.answers_list').find('ul').show();
        }
    } else {
        if (!$(this).parent().hasClass('absolute')) {
            $(this).find('span').removeClass('down');
            $(this).find('span').addClass('up');
            $(this).find('p').html('展开答题卡');
            $('div.answers_list').find('ul').hide();
        }
    }
})



//答题卡点击滚动跳转
$('div.answers_list ul li a').live('click', function() {
    var part_id = $(this).attr('part-data');
    var question_id = $(this).attr('question-data');
    if ($('div.item_title_box ul li a#' + part_id).length > 0) {
        if (!$('div#' + part_id).is(':visible')) {
            $('div.item_title_box ul li a#' + part_id).click();
        }
        $("html,body").animate({scrollTop: ($('div#' + question_id).offset().top - 50)}, 100);
    }
})

//点击收藏题目
$('div.right_box div.question_box div.answers a.favor').live('click', function() {
    var f_id = $(this).attr('favor-id');
    $.get('/tiku/ajax_favor?type=add&id=' + f_id, function(data) {
        if (parseInt(data) > 0) {
            $('[favor-id="' + f_id + '"]').removeClass('favor');
            $('[favor-id="' + f_id + '"]').addClass('cancel_favor');
            $('[favor-id="' + f_id + '"]').attr('title', '取消收藏');
            $('[favor-id="' + f_id + '"]').html('<i></i>取消收藏');
        } else {
            alert('收藏失败！');
        }
    })
})

//点击取消收藏
$('div.right_box div.question_box div.answers a.cancel_favor').live('click', function() {
    var f_id = $(this).attr('favor-id');
    $.get('/tiku/ajax_favor?type=del&id=' + f_id, function(data) {
        if (parseInt(data) > 0) {
            alert('取消失败！');
        } else {
            $('[favor-id="' + f_id + '"]').addClass('favor');
            $('[favor-id="' + f_id + '"]').removeClass('cancel_favor');
            $('[favor-id="' + f_id + '"]').attr('title', '收藏本题');
            $('[favor-id="' + f_id + '"]').html('<i></i>收藏本题');
        }
    })
})

//继续做题填充答案
if ($('input#user_answer').length > 0) {
    var answer_id_arr = $('input#user_answer').attr('value').split(',');
    for (var i = 0; i < answer_id_arr.length; i++) {
        $("[answer-id='" + answer_id_arr[i] + "']").click();
    }
}