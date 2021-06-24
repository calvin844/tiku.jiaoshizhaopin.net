<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>教师招考通·题库</title>
        <link href="<?= VIEW_PATH; ?>tiku/css/base.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/jquery.js"></script>
    </head>
    <body>
        <div class="header">
            <div class="nav_box">
                <div class="main_box">
                    <div class="left">
                        <a class="logo" href="/tiku_<?= $_SESSION['house_name'] ?>" title="教师招考通·题库"><img src="<?= VIEW_PATH; ?>tiku/images/header_logo.png" width="46" height="44" /></a>
                        <a class="site_name" href="/tiku_<?= $_SESSION['house_name'] ?>" title="教师招考通·题库">教师招考通·题库</a>
                        <span class="house_name">[&nbsp;<font><?= $_SESSION['house_name_cn']; ?></font>&nbsp;]</span>
                    </div>
                    <div class="user_box">
                        <?php if (empty($_SESSION['qs_user_name'])): ?>
                            <p>
                                <a class="login" href="<?= MAIN_SITE_URL; ?>user/login.php?tiku_key=<?= time() . rand(100, 999); ?>&tiku_index=<?= $_SESSION['house_name']; ?>">登录</a>
                                <a class="reg" href="<?= MAIN_SITE_URL; ?>user/user_reg.php?tiku_key=<?= time() . rand(100, 999); ?>&tiku_index=<?= $_SESSION['house_name']; ?>">注册</a>
                            </p>
                        <?php else: ?>
                            <p><?= $_SESSION['qs_user_name']; ?></p>
                            <ul class="user_menu">
                                <li><a href="/tiku/show_history" title="我的练习">我的练习</a></li>
                                <li><a href="/tiku/order" title="我的VIP">我的VIP</a></li>
                                <li><a id="logout" href="/tiku/logout">退出登录</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <ul class="right">
                        <li><a target="_blank" href="<?= MAIN_SITE_URL; ?>" title="中国教师招聘网">招聘网</a></li>
                        <?php $nav = empty($_GET['nav']) ? 1 : intval($_GET['nav']); ?>
                        <li><a <?php if ($nav == 1): ?>class="cur"<?php endif; ?> href="/tiku_<?= $_SESSION['house_name'] ?>" title="练习与模考">练习与模考</a></li>
                        <li><a <?php if ($nav == 2): ?>class="cur"<?php endif; ?> href="/tiku/show_history" title="我的练习">我的练习</a></li>
                        <li><a <?php if ($nav == 3): ?>class="cur"<?php endif; ?> href="/tiku/order" title="我的VIP">我的VIP</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="house_bg">
                <div class="house_box">
                    <?php if (!empty($exam_house_list)): ?>
                        <ul>
                            <?php foreach ($exam_house_list as $e): ?>
                                <li><a class="<?= $e['short_name'] == $_SESSION['house_name'] ? 'cur' : ''; ?>" href="/tiku_<?= $e['short_name'] ?><?php if ($nav > 1): ?>_<?= $nav ?><?php endif; ?>" title="<?= $e['name'] ?>"><?= $e['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>