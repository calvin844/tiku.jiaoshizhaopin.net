<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="<?= VIEW_PATH; ?>tiku/css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/jquery.js"></script>
    </head>
    <style>
        body{ background: #f5f5f5;}
    </style>
    <body>
        <div class="main">
            <div class="main_box index">
                <a id="daily_exam" href="javascript:void(0);">每日测试</a>
                <ul>
                    <?php foreach ($news_list as $n): ?>
                        <li><a href="/tiku/news_list?type_id=<?= $n['type_id'] ?>">&nbsp;[<?= $n['type_cn'] ?>]&nbsp;</a><?php if ($n['top'] == 1): ?>[置顶]&nbsp;<?php endif; ?><a href="<?= $n['id'] ?>"><?= $n['title'] ?> ---  <?= date('Y-m-d H:i:s', $n['addtime']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <ul id="house_list" style="display: none;">
                    <?php foreach ($house_list as $h): ?>
                        <?php if ($h['parent_id'] > 0): ?>
                            <li><a href="/tiku/daily_exam?house_id=<?= $h['id'] ?>"><?= $h['name'] ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <a href="/tiku/news_list">更多</a>
                <script>
                    $('a#daily_exam').click(function() {
                        $.get('/tiku/daily_exam', function(data) {
                            if (data == 0) {
                                window.location.href = $('div.user_box a.login').attr('href');
                            } else if (data == 1) {
                                $('div.dialog_html p.content').html("客官，非VIP用户一天只能练习一次哦！");
                                $('div.dialog_html a.go_bt').html("购买VIP");
                                $('div.dialog_html a.go_bt').attr("href", "/tiku/order");
                                $('body').css('overflow', 'hidden');
                                $('div.dialog_html').show();
                            } else {
                                $('ul#house_list').show();
                            }
                        })
                    })
                </script>

            </div>
        </div>
        <!-- 系统提示弹窗 begin -->
        <div class="dialog_html" style="display: none;">
            <style>
                *{ margin:0; padding:0; list-style:none; text-decoration:none; font-size:12px; font-family:"微软雅黑","Arial",sans-serif; border:none; -webkit-appearance: none; border-radius: 0;}
                div.dialog_bg{ width:100%; height:100%; position:fixed; top:0; left:0; background:#000; opacity:0.6; z-index:999;}
                div.dialog_box{ width:340px; height:190px; position:fixed; top:50%; left:50%; background:#fff; z-index:1000; border: 5px solid rgba(0, 0, 0, 0.4); margin-left: -169px; margin-top: -93px;}
                div.dialog_box p.title{ color:#fff; background:#77b3eb; padding:0px 0px 0px 10px; font-size:16px; height:40px; line-height:40px; width:330px; overflow:hidden;}
                div.dialog_box p.content{ line-height:16px; text-align:center; margin:30px 10px 10px 10px; font-family:"宋体"; color:#333; font-size:14px; max-height:65px; overflow:hidden;}
                div.dialog_box a.go_bt{ width: 60px; background: none repeat scroll 0 0 #f60; border-radius: 5px; color: #fff; font-family: "宋体"; font-size: 14px; margin: 20px auto 20px auto; display: block; padding: 5px 20px; text-align: center;}
                div.dialog_box a.go_bt:hover{ opacity:0.8;}
                div.dialog_box a.close{ position:absolute; top:7px; right:7px; color:#e5e5e5; font-size:16px; padding:3px;}
            </style>
            <div class="dialog_box">
                <p class="title">系统提示</p>
                <p class="content"></p>
                <a class="go_bt" href="javascript:close_it();">关闭</a>
                <a class="close" title="关闭" href="javascript:close_it();">X</a>
            </div>
            <div class="dialog_bg"></div>
            <script>
                function close_it() {
                    $("div.dialog_html").hide();
                    $('body').css('overflow', 'auto');
                }
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
            </script>
        </div>
        <!-- 系统提示弹窗 end -->
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>