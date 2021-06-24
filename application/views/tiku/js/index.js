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
        data = 1;
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
    $.get('/tiku/ajax_real_paper_list/' + $(this).attr('house_id') + '?page=' + $(this).html(), function(page_str) {
        var page_arr = page_str.split("#");
        var ul_str = "";
        for (var i = 3; i < page_arr.length; i++) {
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
                    ul_str += '<a class="do" href="/tiku_' + p_arr[6] + '/' + p_arr[7] + '_' + p_arr[5] + '">再做一次</a>';
                } else {
                    ul_str += '<a class="do" href="/tiku_' + p_arr[6] + '/' + p_arr[7] + '_' + p_arr[5] + '">立即模考</a>';
                }
                ul_str += '</div>';
                ul_str += '</li>';
            }
        }
        var total_page = parseInt(page_arr[1]);
        var page_s = "";
        for (var p = 1; p < total_page + 1; p++) {
            page_s += '<a ';
            if (p == page_arr[3]) {
                page_s += 'class="cur"';
            }
            page_s += ' house_id=' + page_arr[0] + '  href="javascript:void(0);">' + p + '</a>';
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

/*首页领取优惠卷按钮 begin*/
$('a#get_coupons').live('click', function() {
    $.get('/tiku/ajax_get_coupons', function(data) {
        $('div.dialog_html p.content').html(data);
        if (data.indexOf("登录") > -1) {
            $('div.dialog_html a.go_bt').html("登录");
            var login_url = $('div.user_box a.login').attr('href');
            $('div.dialog_html a.go_bt').attr("href", login_url);
        } else if (data.indexOf("恭喜") > -1) {
            $('div.dialog_html a.go_bt').html("立即使用");
            $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
        }
        $('div.dialog_html').show();
        $('body').css('overflow', 'hidden');
    });
})
/*首页领取优惠卷按钮 end*/


/*登录 begin*/
$('div.login input.text').focus(function() {
    $(this).hide();
    $('input.pwd').show();
    $('input.pwd').focus();
    $('input.pwd').css('color', "#333");
})
$('div.login input.pwd').blur(function() {
    if ($(this).val() == "") {
        $(this).hide();
        $(this).removeAttr('style');
        $('div.login input.text').removeAttr('style');
        $('div.login input.text').attr('value', $('input.text').attr('str'));
        $('div.login input.text').show();
    }
})
$('div.login input').focus(function() {
    if (!$(this).hasClass('submit')) {
        if ($(this).attr('value') == $(this).attr('str')) {
            $(this).attr('value', "");
        }
        $(this).css('border-color', "#3aa1ed");
        $(this).css('color', "#333");
    }
    if ($(this).val() == $(this).attr('str')) {
        $(this).val('');
    }
}).blur(function() {
    $(this).css('border-color', "#d5d5d5");
    if ($(this).val() == "") {
        $(this).removeAttr('style');
        $(this).val($(this).attr('str'));
    }
});
$('div.login li.remember span').click(function() {
    $(this).parent().find('input').click();
});
$('div.login input.submit').click(function() {
    var u_name = $('div.login input.user_name').attr('value');
    var pwd = $('div.login input.pwd').attr('value');
    $.get('/tiku/ajax_check_user?user_name=' + u_name + '&pwd=' + pwd, function(data) {
        if (data == 0) {
            $('div.login li.line span.warning').show();
        } else {
            $('div.login form#login_form').submit();
        }
    });
})
/*登录 end*/

/*完善信息 begin*/

$('div.make_info input.phone').focus(function() {
    $('div.make_info span.p_warnning').hide();
    $('div.make_info img.phone_flag').hide();
    $('div.make_info span.phone_loading').hide();
}).blur(function() {
    $('div.make_info span.phone_loading').show();
    if (!(/^1[0-9][0-9]\d{8}$/.test($('div.make_info input.phone').val()))) {
        $('div.make_info span.phone_loading').hide();
        $('div.make_info span.p_warnning').html('*手机格式错误');
        $('div.make_info span.p_warnning').show();
    } else {
        $('div.make_info span.phone_loading').hide();
        $('div.make_info img.phone_flag').show();
    }
})
$('div.make_info input.pwd').focus(function() {
    $('div.make_info span.w_warnning').hide();
}).blur(function() {
    if (!(/^[0-9a-zA-Z]{6,16}$/.test($(this).val()))) {
        $('div.make_info span.w_warnning').show();
    }
})
$('div.make_info input').focus(function() {
    $('div.make_info span.warnning').hide();
    if (!$(this).hasClass('submit')) {
        $(this).css('border-color', "#3aa1ed");
        $(this).css('color', "#333");
    }
}).blur(function() {
    $(this).css('border-color', "#d5d5d5");
});
$('div.make_info span.send_code').on('click', function() {
    $("#imgdiv img").attr("src", $("#imgdiv img").attr("src") + "?1");
    $(this).val("");
    alert('请正确填写图片验证码');
})
$('div.make_info a.send_code').on('click', function() {
    $("#imgdiv img").attr("src", $("#imgdiv img").attr("src") + "?1");
    $(this).val("");
    $('span.send_code').show();
    $('a.send_code').hide();
    if ($(this).html() == '发送验证码') {
        var sCode = $('div.make_info input.code').attr('value');
        var sMobile = $('div.make_info input.phone').attr('value');
        if (!(/^1[0-9][0-9]\d{8}$/.test(sMobile))) {
            $('div.make_info span.warnning').show();
            return false;
        } else {
            $('div.make_info span.warnning').hide();
            $.get('/tiku/ajax_send_sms/' + sMobile, function(data) {
                if (data == 0) {
                    alert('发送失败！');
                } else {
                    $('div.make_info a.send_code').css('background', '#999');
                    $('div.make_info a.send_code').removeAttr('href');
                    $('div.make_info a.send_code').html(60);
                    var send_time = setInterval(function() {
                        var n = $('div.make_info a.send_code').html();
                        n = parseInt(n);
                        if (n > 0) {
                            n--;
                            $('div.make_info a.send_code').html(n);
                        } else {
                            clearInterval(send_time);
                            $('div.make_info a.send_code').removeAttr('style');
                            $('div.make_info a.send_code').hide();
                            $('div.make_info a.send_code').attr('href', 'javascript:void(0);');
                            $('div.make_info a.send_code').html('发送验证码');
                        }
                    }, 1000);
                    if ($('div.make_info a.send_code').html() == '发送验证码') {
                        clearInterval(send_time);
                    }
                }
            })
        }
    }
});
$('div.make_info form').submit(function() {
    var sCode = $('input.code').attr('value');
    var sMobile = $('input.phone').attr('value');
    if (!(/^1[0-9][0-9]\d{8}$/.test(sMobile)) || !(/^\d{6}$/.test(sCode)) || $('span.p_warnning').is(':visible') || $('span.w_warnning').is(':visible')) {
        $('div.make_info span.warnning').show();
        return false;
    }
})
/*完善信息 end*/

/*忘记密码 begin*/
$('div.forget_password input.phone').focus(function() {
    $('div.forget_password span.p_warnning').hide();
    $('div.forget_password img.phone_flag').hide();
    $('div.forget_password span.phone_loading').hide();
}).blur(function() {
    $('div.forget_password span.phone_loading').show();
    if (!(/^1[0-9][0-9]\d{8}$/.test($('div.forget_password input.phone').val()))) {
        $('div.forget_password span.phone_loading').hide();
        $('div.forget_password span.p_warnning').html('*手机格式错误');
        $('div.forget_password span.p_warnning').show();
    } else {
        $('div.forget_password span.phone_loading').hide();
        $('div.forget_password img.phone_flag').show();
    }
})
$('div.forget_password input.pwd').focus(function() {
    $('div.forget_password span.w_warnning').hide();
}).blur(function() {
    if (!(/^[0-9a-zA-Z]{6,16}$/.test($(this).val()))) {
        $('div.forget_password span.w_warnning').show();
    }
})
$('div.forget_password input').focus(function() {
    $('div.forget_password span.warnning').hide();
    if (!$(this).hasClass('submit')) {
        $(this).css('border-color', "#3aa1ed");
        $(this).css('color', "#333");
    }
}).blur(function() {
    $(this).css('border-color', "#d5d5d5");
});
$('div.forget_password a.send_code').live('click', function() {
    if ($(this).html() == '发送验证码') {
        var sCode = $('div.forget_password input.code').attr('value');
        var sMobile = $('div.forget_password input.phone').attr('value');
        if (!(/^1[0-9][0-9]\d{8}$/.test(sMobile))) {
            $('div.forget_password span.warnning').show();
            return false;
        } else {
            $('div.forget_password span.warnning').hide();
            $.get('/tiku/ajax_send_sms/' + sMobile, function(data) {
                if (data == 0) {
                    alert('发送失败！');
                } else {
                    $('div.forget_password a.send_code').css('background', '#999');
                    $('div.forget_password a.send_code').removeAttr('href');
                    $('div.forget_password a.send_code').html(60);
                    var send_time = setInterval(function() {
                        var n = $('div.forget_password a.send_code').html();
                        n = parseInt(n);
                        if (n > 0) {
                            n--;
                            $('div.forget_password a.send_code').html(n);
                        } else {
                            clearInterval(send_time);
                            $('div.forget_password a.send_code').removeAttr('style');
                            $('div.forget_password a.send_code').attr('href', 'javascript:void(0);');
                            $('div.forget_password a.send_code').html('发送验证码');
                        }
                    }, 1000);
                    $('div.forget_password a.send_code').attr('set', 1);
                    if ($('div.forget_password a.send_code').html() == '发送验证码') {
                        clearInterval(send_time);
                    }
                }
            });
        }
    }
});

$('div.forget_password form').submit(function() {
    var sCode = $('input.code').attr('value');
    var sMobile = $('input.phone').attr('value');
    if (!(/^1[0-9][0-9]\d{8}$/.test(sMobile)) || !(/^\d{6}$/.test(sCode)) || $('span.p_warnning').is(':visible') || $('span.w_warnning').is(':visible')) {
        $('div.forget_password span.warnning').show();
        return false;
    }
})
/*忘记密码 end*/