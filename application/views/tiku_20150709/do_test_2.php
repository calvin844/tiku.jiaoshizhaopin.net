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
            <div class="main_box do_test_2">
                <img class="top_logo" src="<?= VIEW_PATH; ?>tiku/images/logo.png" />
                <div class="list_box">
                    <div class="left">
                        <p class="title">弱点测试</p>
                        <div class="top_box">
                            <div class="left">
                                <p><?= $user_sheet_arr['score']; ?><span>分</span></p>
                                <span>击败<?= sprintf("%.0f", $beyond_people); ?>%的教师</span>
                            </div>
                            <?php if ($user_sheet_arr['score'] > 0 && $user_sheet_arr['score'] < 20): ?>
                                <p class="left">恭喜您获得&nbsp;&nbsp;<b>学渣</b>&nbsp;&nbsp;称号，<a href="#">点击扫描</a>在朋友圈得瑟一下。</p>
                                <span class="describe">渣渣逆袭就会形成沙渣暴哦~~给你试题三千，飞吧！</span>
                            <?php elseif ($user_sheet_arr['score'] > 19 && $user_sheet_arr['score'] < 40): ?>
                                <p class="left">恭喜您获得&nbsp;&nbsp;<b>学沫</b>&nbsp;&nbsp;称号，<a href="#">点击扫描</a>在朋友圈得瑟一下。</p>
                                <span class="describe">敏而不学，风花雪月......欠下的题要一道道补回来。</span>
                            <?php elseif ($user_sheet_arr['score'] > 39 && $user_sheet_arr['score'] < 60): ?>
                                <p class="left">恭喜您获得&nbsp;&nbsp;<b>学酥</b>&nbsp;&nbsp;称号，<a href="#">点击扫描</a>在朋友圈得瑟一下。</p>
                                <span class="describe">退一步成渣，进一步制霸……题就在这里，看你志向。</span>
                            <?php elseif ($user_sheet_arr['score'] > 59 && $user_sheet_arr['score'] < 80): ?>
                                <p class="left">恭喜您获得&nbsp;&nbsp;<b>学霸</b>&nbsp;&nbsp;称号，<a href="#">点击扫描</a>在朋友圈得瑟一下。</p>
                                <span class="describe">色而不淫，嗜学成霸……学海无涯，试卷作舟。</span>
                            <?php elseif ($user_sheet_arr['score'] > 79 && $user_sheet_arr['score'] < 100): ?>
                                <p class="left">恭喜您获得&nbsp;&nbsp;<b>学神</b>&nbsp;&nbsp;称号，<a href="#">点击扫描</a>在朋友圈得瑟一下。</p>
                                <span class="describe">阅遍天下，故而封神……然，学无止境，还需继续做题 。</span>
                            <?php endif; ?>
                            <span class="describe">不服？<a href="/tiku/do_test">再来一次！</a></span>
                        </div>
                        <div class="middle_box">
                            <p class="top">根据测试结果评估，您需要完成以下练习：</p>

                            <?php if ($user_sheet_arr['score'] > 0 && $user_sheet_arr['score'] < 20): ?>
                                <ul>
                                    <li><b>每日一练：</b><span>100次</span></li>
                                    <li><b>历年真题：</b><span>50次</span></li>
                                    <li><b>模拟组卷：</b><span>100次</span></li>
                                </ul>
                                <p class="bottom">以上试题，市场价格：<strong>850元</strong>，教师招考通VIP&nbsp;<b>免费</b>&nbsp;享有</p>
                            <?php elseif ($user_sheet_arr['score'] > 19 && $user_sheet_arr['score'] < 40): ?>
                                <ul>
                                    <li><b>每日一练：</b><span>80次</span></li>
                                    <li><b>历年真题：</b><span>40次</span></li>
                                    <li><b>模拟组卷：</b><span>80次</span></li>
                                </ul>
                                <p class="bottom">以上试题，市场价格：<strong>680元</strong>，教师招考通VIP&nbsp;<b>免费</b>&nbsp;享有</p>
                            <?php elseif ($user_sheet_arr['score'] > 39 && $user_sheet_arr['score'] < 60): ?>
                                <ul>
                                    <li><b>每日一练：</b><span>60次</span></li>
                                    <li><b>历年真题：</b><span>30次</span></li>
                                    <li><b>模拟组卷：</b><span>60次</span></li>
                                </ul>
                                <p class="bottom">以上试题，市场价格：<strong>510元</strong>，教师招考通VIP&nbsp;<b>免费</b>&nbsp;享有</p>
                            <?php elseif ($user_sheet_arr['score'] > 59 && $user_sheet_arr['score'] < 80): ?>
                                <ul>
                                    <li><b>每日一练：</b><span>40次</span></li>
                                    <li><b>历年真题：</b><span>20次</span></li>
                                    <li><b>模拟组卷：</b><span>40次</span></li>
                                </ul>
                                <p class="bottom">以上试题，市场价格：<strong>340元</strong>，教师招考通VIP&nbsp;<b>免费</b>&nbsp;享有</p>
                            <?php elseif ($user_sheet_arr['score'] > 79 && $user_sheet_arr['score'] < 100): ?>
                                <ul>
                                    <li><b>每日一练：</b><span>20次</span></li>
                                    <li><b>历年真题：</b><span>10次</span></li>
                                    <li><b>模拟组卷：</b><span>15次</span></li>
                                </ul>
                                <p class="bottom">以上试题，市场价格：<strong>145元</strong>，教师招考通VIP&nbsp;<b>免费</b>&nbsp;享有</p>
                            <?php endif; ?>
                        </div>
                        <div class="clear"></div>
                        <form action="/tiku" method="post">
                            <input class="submit" type="submit" value="进入题库" />
                            <p>机会只留给早做准备的人，<a target="_blank" href="<?= MAIN_SITE_URL ?>subscribe/" title="订阅职位">订阅职位</a></p>
                        </form>
                    </div>
                    <div class="right">
                        <p class="title">轻松考教师</p>
                        <p class="item"><span>优势一：</span>历年真题，详细讲解；考点，难点各个击破</p>
                        <p class="item"><span>优势二：</span>多端同步，利用碎片时间完成每日练习</p>
                        <p class="item"><span>优势三：</span>为您建立教师知识模型，强化薄弱环节和面试技巧</p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>