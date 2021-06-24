<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if (!empty($page_title)): ?><title><?= $page_title; ?></title><?php endif; ?>
        <?php if (!empty($page_keywords)): ?><meta name="keywords" content="<?= $page_keywords; ?>" /><?php endif; ?>
        <?php if (!empty($page_description)): ?><meta name="description" content="<?= $page_description; ?>" /><?php endif; ?>
        <link href="<?= VIEW_PATH; ?>tiku/css/base.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/jquery.js"></script>
    </head>
    <body>
        <div class="header">
            <div class="top">
                <div class="main_box">
                    <div class="nav">
                        <ul class="left">
                            <li><a title="首页" href="<?= MAIN_SITE_URL; ?>">首页</a></li>
                            <li><a title="学校" href="<?= MAIN_SITE_URL; ?>company">学校</a></li>
                            <li><a title="教师" href="<?= MAIN_SITE_URL; ?>ProfileBank">教师</a></li>
                            <li><a title="职位" href="<?= MAIN_SITE_URL; ?>morejobs">职位</a></li>
                            <li><a title="简章" href="<?= MAIN_SITE_URL; ?>morejobs">简章</a></li>
                            <li><a title="题库" href="/">题库</a></li>
                            <li><a title="我的简历" href="<?= MAIN_SITE_URL; ?>user/login.php">我的简历</a></li>
                        </ul>
                    </div>
                    <div class="user_box">
                        <a title="充值中心" class="vip" href="/tiku/order">充值中心&nbsp;&nbsp;＞＞</a>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="main_box">
                    <div class="left">
                        <p><a title="教师资格考试" href="/">教师资格考试</a></p>
                        <span>题库</span>
                    </div>
                    <div class="right">
                        <input id="session_id" type="hidden" value="<?= !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>">
                        <ul>
                            <?php foreach ($exam_house_list as $e): ?>
                                <?php if ($e['parent_id'] == 0): ?>
                                    <li class="<?= !empty($_SESSION['history']) && $_SESSION['history'] == 1 && !empty($_SESSION['parent_house_name']) && $e['short_name'] == $_SESSION['parent_house_name'] ? 'hover' : ''; ?>"><a href="/<?= $e['short_name'] ?>" title="<?= $e['name'] ?>"><?= $e['name'] ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="<?php if (!empty($_SESSION['history']) && $_SESSION['history'] == 2): ?>hover<?php endif; ?>"><a title="我的练习" href="/tiku/show_history">我的练习</a></li>
                        </ul>
                        <div class="user_box">
                            <i></i>
                            <?php if (empty($_SESSION['user_name'])): ?>
                                <a title="登录" class="login" href="/tiku/login">登录</a>
                                <span>|</span>
                                <a title="注册" class="reg" href="/tiku/reg">注册</a>
                            <?php else: ?>
                                <a title="<?= $_SESSION['user_name'] ?>" class="user" href="/tiku/order"><?= $_SESSION['user_name'] ?></a>
                                <a title="退出" href="/tiku/logout"> &nbsp;&nbsp;[退出]</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
                <a title="关闭" class="go_bt" href="javascript:void(0);">关闭</a>
                <a class="close" title="关闭" href="javascript:void(0);">X</a>
            </div>
            <div class="dialog_bg"></div>
            <script>
                $('div.dialog_html a.close').click(function() {
                    $("div.dialog_html").hide();
                    $('body').css('overflow', 'auto');
                })
                $('div.dialog_html a.go_bt').click(function() {
                    $("div.dialog_html").hide();
                    $('body').css('overflow', 'auto');
                })
            </script>
        </div>
        <!-- 系统提示弹窗 end -->
        <div class="clear"></div>