/*试卷报告 begin*/
set_menu('all', 'div.point_box table td.name', 'span', 'parent-id', 'data-id', 'open', 'close');
/*试卷报告 end*/

/*试卷解析 begin*/
$(window).scroll(function() {
    var left_box = $('div.parsing ul.left_box');
    var currTop = $(document).scrollTop();
    var paperTitle = $('div.parsing div.right_box div.top_title');
    var item_title_box = $('div.parsing div.right_box div.item_title_box');
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

//只看错题
$('div.parsing ul.left_box li.only_error input').attr('checked', false);
$('div.parsing ul.left_box li.only_error input').click(function() {
    if ($(this).is(":checked")) {
        $('div.parsing div.right_box div.item_box').each(function() {
            if (!$(this).hasClass('false')) {
                $(this).hide();
            }
        })
    } else {
        $('div.parsing div.right_box div.item_box').show()
    }
    answers_list_init()
});

//切换试题类型
$('div.parsing div.right_box div#part_1').show();
$('div.parsing div.right_box p#part_1').show();
$('div.parsing div.right_box div.item_title_box ul li a').live('click', function() {
    $('div.parsing div.right_box div.item_title_box ul li').removeClass('cur');
    $(this).parent().addClass('cur');
    var part_id = $(this).attr('id');
    $('div.parsing div.right_box div.question_list').hide();
    $('div.parsing div.right_box p.item_description_box').hide();
    $('div.parsing div.right_box div#' + part_id).show();
    $('div.parsing div.right_box p#' + part_id).show();
    $("html,body").animate({scrollTop: $('div.item_title_box').offset().top}, 500);
    answers_list_init()
});

//材料题窗口操作
//最小化
$('div.right_box div.material_box div.title_box a.m_xiao').live('click', function() {
    $(this).parents('div.material_box').find('div.content_box').slideUp(500);
    $(this).hide();
    $(this).parent().find('a.m_show').css('display', 'inline-block');
})
//恢复大小
$('div.right_box div.material_box div.title_box a.m_show').live('click', function() {
    $(this).parents('div.material_box').find('div.content_box').slideDown(500);
    $(this).hide();
    $(this).parent().find('a.m_xiao').css('display', 'inline-block');
})
//全屏
$('div.right_box div.material_box div.title_box a.m_quan').live('click', function() {
    var html_str = $(this).parents('div.material_box').find('div.content_box div.content_overflow').html();
    $('body').css('overflow', 'hidden');
    $('div.big_material_box div.content_box').html(html_str);
    $('div.big_material_box').show();
})
//关闭全屏
$('div.big_material_box a.close').live('click', function() {
    $('div.main').show();
    $('body').css('overflow', 'auto');
    $('div.big_material_box div.content_box').html("");
    $('div.big_material_box').hide();
})

//点击进入下一部分
$('a.next_part').live('click', function() {
    var part_id = $(this).parents('div.question_list').attr('id');
    var part_num = part_id.substr(5);
    if ($('div.item_title_box ul li a#part_' + (parseInt(part_num) + 1)).length > 0) {
        $('div.item_title_box ul li a#part_' + (parseInt(part_num) + 1)).click();
    }
})

//点击答题卡跟随
if ($('div.answers_box').length > 0) {
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
}

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
    }
    if (!$('div#' + question_id).is(':visible')) {
        $('div#' + question_id).show();
        $('div.parsing ul.left_box li.only_error input').attr('checked', false);
    }
    $("html,body").animate({scrollTop: ($('div#' + question_id).offset().top - 50)}, 100);
})

//收起解析
$('div.operation a.put').live('click', function() {
    $(this).parents('div.answer').css('border-left', '1px solid #fff')
    $(this).parents('div.question_box').find('div.resolve').hide();
    $(this).removeClass('put');
    $(this).addClass('down');
    $(this).html('<i></i>展开解析');
    answers_list_init()
})
//展开解析
$('div.operation a.down').live('click', function() {
    $(this).parents('div.answer').removeAttr('style')
    $(this).parents('div.question_box').find('div.resolve').show();
    $(this).removeClass('down');
    $(this).addClass('put');
    $(this).html('<i></i>收起解析');
    answers_list_init()
})
//初始化解析，收起回答正确题目的解析
$('div.item_box').each(function() {
    if (!$(this).hasClass('false')) {
        $(this).find('div.operation a.put').click();
    }
})
//显示考点介绍
$('label.keypoint-info').mouseover(function() {
    $(this).parent().find('div.box_bg').show()
})
$('div.test').mouseleave(function() {
    $(this).find('div.box_bg').hide()
})
//输入笔记
$('input.note_empty').focus(function() {
    $(this).hide();
    $(this).parent().find('div.note_edit_box').show();
    $(this).parent().find('div.note_edit_box').find('textarea')[0].focus();
})
//计算笔记字数
$('div.note_edit_box textarea').val('');
$('div.note_edit_box textarea').keyup(function() {
    var str_length = $(this).val().length;
    if (str_length > 500) {
        $(this).val($(this).val().substr(0, 500));
        str_length = 500;
    }
    $(this).parent().find('p.left').html('还可以输入' + (500 - str_length) + '字');
})
//确认笔记
$('div.edit_tips a.sure').live('click', function() {
    var str = $(this).parents('div.note_edit_box').find('textarea').val();
    $(this).parents('div.note_edit_box').find('textarea').val('');
    $(this).parents('div.note_edit_box').hide();
    $(this).parents('div.note').find('p.edit_text').html(str);
    $(this).parents('div.note').find('p.edit_text').show();
    $(this).parents('div.note').find('a.edit_note').css('display', 'block');
})
//取消笔记
$('div.edit_tips a.cancel').live('click', function() {
    $(this).parents('div.note_edit_box').find('textarea').val('');
    $(this).parents('div.note_edit_box').hide();
    $(this).parents('div.note').find('input.note_empty').show();
    $(this).parents('div.note').find('p.left').html('还可以输入500字');
})
//编辑笔记
$('a.edit_note').live('click', function() {
    var note_str = $(this).parent().find('p.edit_text').html();
    $(this).parents('div.note').find('div.note_edit_box').show();
    var t = $(this).parents('div.note').find('div.note_edit_box').find('textarea');
    t.val(note_str);
    var str_length = t.val().length;
    if (str_length > 500) {
        t.val(t.val().substr(0, 500));
        str_length = 500;
    }
    t.parent().find('p.left').html('还可以输入' + (500 - str_length) + '字');
    $(this).parent().find('p.edit_text').html('');
    $(this).parent().find('p.edit_text').hide();
    $(this).hide();
})

//直接跳转至问题ID锚点
if ($('input#q_id').attr('value') > 0) {
    var question_id = $('input#q_id').attr('value');
    var part_id = $('div#question_' + question_id).parent().attr('id');
    if ($('div.item_title_box ul li a#' + part_id).length > 0) {
        if (!$('div#' + part_id).is(':visible')) {
            $('div.item_title_box ul li a#' + part_id).click();
        }
    }
    if (!$('div#question_' + question_id).is(':visible')) {
        $('div#question_' + question_id).show();
        $('div.parsing ul.left_box li.only_error input').attr('checked', false);
    }
    $("html,body").animate({scrollTop: ($('div#question_' + question_id).offset().top - 50)}, 100);

}



//点击收藏题目
$('div.options div.operation a.favor').live('click', function() {
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
$('div.options div.operation a.cancel_favor').live('click', function() {
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
/*试卷解析 end*/
