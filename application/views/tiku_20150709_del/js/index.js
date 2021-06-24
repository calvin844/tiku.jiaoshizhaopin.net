/*练习与模考 begin*/
$('div.exam li.mobile_code_bt').mouseover(function() {
    $(this).find('div.mobile_code_box').show();
})
$('div.exam li.mobile_code_bt').mouseleave(function() {
    $(this).find('div.mobile_code_box').hide();
})
$('div.exam div.list_box ul li a.special_exam').live('click', function() {
    var url = $(this).attr('href');
    $.get("/tiku/check_vip", function(data) {
        if (data == "1") {
            $.get("/tiku/ajax_user_point_question", function(num_str) {
                var user_arr = new Array();
                var num_arr = num_str.split('#');
                for (var i = 0; i < num_arr.length; i++) {
                    var t = num_arr[i].split('-');
                    var d_li = $('[data-id="' + t[0] + '"]');
                    d_li.find('span#user_num').html(t[1]);
                    var user_num = d_li.find('span#user_num').html();
                    var total_num = d_li.find('span#total_num').html();
                    var p_width = d_li.find('div.progress_bg').width();
                    var p = (user_num / total_num) * p_width;
                    d_li.find('p.progress').width(p);
                    d_li.find('a').attr('href', url + "_" + t[0]);
                }
                $('div.black_bg').show();
                $('div.point_box').show();
            })
        } else if (data == "2") {
            $('div.dialog_html p.content').html("您还不是VIP，请购买后使用！");
            $('div.dialog_html').show();
            $('div.dialog_html a.go_bt').html("购买VIP");
            $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
            $('body').css('overflow', 'hidden');
        } else if (data == "3") {
            $('div.dialog_html p.content').html("您的VIP已过期，请充值后使用！");
            $('div.dialog_html').show();
            $('div.dialog_html a.go_bt').html("充值VIP");
            $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
            $('body').css('overflow', 'hidden');
        } else {
            window.location.href = data;
        }
    })
    return false;
})
$('div.exam div.list_box ul li a.real_exam').live('click', function() {
    var url = $(this).attr('href');
    $.get("/tiku/check_vip", function(data) {
        if (data == "1") {
            $('div.real_box ul li').each(function() {
                var p_id = $(this).attr('data-id');
                $(this).find('a').attr('href', url + "_" + p_id);
            })
            $('div.real_black_bg').show();
            $('div.real_box').show();
        } else if (data == "2") {
            $('div.dialog_html p.content').html("您还不是VIP，请购买后使用！");
            $('div.dialog_html').show();
            $('div.dialog_html a.go_bt').html("购买VIP");
            $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
            $('body').css('overflow', 'hidden');
        } else if (data == "3") {
            $('div.dialog_html p.content').html("您的VIP已过期，请充值后使用！");
            $('div.dialog_html').show();
            $('div.dialog_html a.go_bt').html("充值VIP");
            $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
            $('body').css('overflow', 'hidden');
        } else {
            window.location.href = data;
        }
    })
    return false;
})
/*练习与模考 end*/



/*练习与模考-专项练习 begin*/
set_menu('part', 'div.point_box ul li div.left', 'span.sprite-expand', 'parent-id', 'data-id', 'open', 'close');
$('div.point_box a.close').live('click', function() {
    $('div.point_box').hide();
    $('div.real_black_bg').hide();
    $('div.black_bg').hide();
})

/*练习与模考-专项练习 end*/


/*练习与模考-真题模考 begin*/
$('div.real_box a.close').live('click', function() {
    $('div.real_box').hide();
    $('div.real_black_bg').hide();
    $('div.black_bg').hide();
})
$('div.real_box div.page_box a').live('click', function() {
    $.get('/tiku/ajax_real_paper_list?page=' + $(this).html(), function(page_str) {
        var page_arr = page_str.split("#");
        var ul_str = "";
        for (var i = 0; i < page_arr.length; i++) {
            if (page_arr[i].indexOf("|") > 0) {
                var p_arr = page_arr[i].split("|");
                ul_str += '<li>';
                ul_str += '<div class="left">';
                ul_str += '<p class="name" title="' + p_arr[0] + '">' + p_arr[0] + '</p>';
                ul_str += '<span class="info">试卷难度 ' + p_arr[1] + ' ,已有 ' + p_arr[2] + ' 人模考，平均得分 ' + p_arr[3] + '</span>';
                ul_str += '</div>';
                ul_str += '<div class="right">';
                if (p_arr[4] > 0) {
                    ul_str += '<span>已完成' + p_arr[4] + '次</span>';
                    ul_str += '<a class="do" href="' + p_arr[5] + '">再做一次</a>';
                } else {
                    ul_str += '<a class="do" href="' + p_arr[5] + '">立即模考</a>';
                }
                ul_str += '</div>';
                ul_str += '</li>';
            } else {
                var total_page = $('div.page_box').attr('total');
                var total_page = parseInt(total_page);
                var page_s = "";
                for (var p = 1; p < total_page + 1; p++) {
                    page_s += '<a ';
                    if (p == page_arr[i]) {
                        page_s += 'class="cur"';
                    }
                    page_s += ' href="javascript:void(0);">' + p + '</a>';
                }
            }
        }
        $('div.real_box ul').html(ul_str);
        $('div.real_box div.page_box').html(page_s);
    })
    return false;
})
/*练习与模考-真题模考 end*/


/*能力评估报告 begin*/
set_menu('all', 'div.assess table td.name', 'span', 'parent-id', 'data-id', 'open', 'close');
/*能力评估报告 end*/


/*我的练习-我的收藏 begin*/
set_menu('part', 'div.favorite ul p', 'span', 'parent-id', 'data-id', 'open', 'close');
/*我的练习-我的收藏 end*/


/*我的练习-错题集 begin*/
set_menu('part', 'div.incorrect ul p', 'span', 'parent-id', 'data-id', 'open', 'close');
/*我的练习-错题集 end*/

/*我的练习-我的笔记 begin*/
set_menu('part', 'div.note ul p', 'span', 'parent-id', 'data-id', 'open', 'close');
/*我的练习-我的笔记 end*/

/*充值/订单 begin*/
$('ul.package_list li div.item_box').live('click', function() {
    $(this).parent().find('input').click();
    get_pay_info();
})
$('ul.package_list li input').live('click', function() {
    get_pay_info();
})
$('ul.payment_list li div.left').click(function() {
    $('ul.payment_list').find("input[type=radio]").removeAttr("checked");
    $(this).find('input').attr("checked", '2');
})
$('ul.coupons_list li p').click(function() {
    $(this).parent().find('input').click();
    $('div.coupons_box div.tips input').attr("checked", 'checked');
    get_pay_info();
})
$('div.coupons_box div.tips input').click(function() {
    get_pay_info();
})
$('ul.coupons_list li input').click(function() {
    $('div.coupons_box div.tips input').attr("checked", 'checked');
    get_pay_info();
})
$('ul.package_list li div.item_box:first').click();
$('ul.payment_list li div.left:first').click();

function get_pay_info() {
    var total = $('ul.package_list li input:checked').parent().find('u').html();
    total = parseFloat(total);
    if ($('div.coupons_box div.tips input:checked').length > 0 && $('ul.coupons_list li input:checked').length > 0) {
        var cut = $('ul.coupons_list li input:checked').parent().find('span').find('span').html();
    } else {
        var cut = 0;
    }
    cut = parseFloat(cut);
    var t = total - cut;
    if (t < 0) {
        t = 0;
    }
    $('p.pay_info span.total_pay').html(t.toFixed(2));
    $('p.pay_info span.cut_pay').html(cut);
    if (cut > 0) {
        $('p.pay_info').show();
    } else {
        $('p.pay_info').hide();
    }
}

if ($('div.order_list').height() > 500) {
    $('div.order_list').css('height', '500px');
    $('div.order_list').css('overflow-y', 'scroll');
} else {
    $('div.order_list').removeAttr('style');
}

$('form#sure_order').submit(function() {
    var package_id = $(this).find('input#package_id').attr('value');
    var payment_id = $(this).find('ul.payment_list').find("input[type=radio][checked]").attr('value');
    if (package_id < 1) {
        alert('请选择套餐');
        return false;
    }
    if (typeof (payment_id) == "undefined") {
        alert('请选择支付方式');
        return false;
    }
})
$('a.close_order').live('click', function() {
    var id = $(this).attr('id');
    id = id.substr(2);
    $.get('/tiku/del_order?id=' + id, function(data) {
        if (data == "1") {
            $('a#o_' + id).parents('tr').remove();
        } else {
            alert('取消失败！');
        }
    })
})
/*充值/订单 end*/


/*测试题 begin*/
$('div.do_test ul li a').click(function() {
    $(this).parent().find('a').removeClass('cur');
    $(this).addClass('cur');
})
$('div.do_test div.left li.teacher a').live('click', function() {
    var id = $(this).attr('id');
    $('div.do_test div.left ul li.subjects').hide();
    $('div.do_test div.left ul li.subjects a').removeClass('cur');
    $('div.do_test div.left ul li').each(function() {
        if ($(this).hasClass(id)) {
            $(this).show();
            $(this).find('a:first').click();
        }
    })
})
$('div.do_test div.left ul li.subjects').each(function() {
    if ($(this).is(':visible')) {
        $(this).find('a:first').addClass('cur');
    }
})
$('div.do_test form').submit(function() {
    $(this).find('input#house_id').val($('div.do_test div.left ul li.subjects a.cur').attr('data'));
})
/*测试题 end*/



