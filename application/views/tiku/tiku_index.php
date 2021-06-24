<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<title><?= date("Y", time()); ?>年教师资格证考试_教师资格考试真题与答案</title>
<meta name="keywords" content="教师资格考试,教师资格考试真题,教师资格证考试,教师资格证,教师考试试题,<?= date("Y", time()); ?>年教师资格考" />
<meta name="description" content="<?= date("Y", time()); ?>年教师资格证考试网，免费提供历年教师资格考试真题与模拟题，及时分享<?= date("Y", time()); ?>年教师资格考试时间与教师资格考试报名信息等，是您考教师资格证的好帮手。" />
<div class="main index">
    <div id="playBox">
        <div class="p_box">
            <div class="pre"></div>
            <div class="next"></div>
        </div>
        <div class="smalltitle">
            <ul>
                <li class="thistitle"></li>
                <li></li>
            </ul>
        </div>
        <ul class="oUlplay">
            <li><a href="/tiku/login" target="_self"><img src="<?= VIEW_PATH; ?>tiku/images/banner_bg1.jpg"/></a></li>
            <li><a href="/tiku/order" target="_self"><img src="<?= VIEW_PATH; ?>tiku/images/banner_bg2.jpg"/></a></li>
        </ul>
    </div>

    <div class="main_box">

        <div class="floora">
            <p class="f_title">题库&nbsp;·&nbsp;每日一练</p>
            <div class="f_content">
                <?php foreach ($test as $t): ?>
                    <div class="left">
                        <p class="title"><?= $t['parent']['name'] ?></p>
                        <div class="list">
                            <ul>
                                <?php foreach ($t['son'] as $s): ?>
                                    <li>
                                        <div class="top">
                                            <i></i>
                                            <a href="/tiku_<?= $t['parent']['short_name'] ?>/<?= $s['index']['id'] ?>" class="index" title="<?= $s['name'] ?>"><?= $s['name'] ?></a>
                                            <a href="/tiku_<?= $t['parent']['short_name'] ?>/<?= $s['index']['id'] ?>" class="right" title="<?= $s['name'] ?>">练一练</a>
                                        </div>
                                        <p class="bottom">已有<?= $s['index']['do_num'] ?>人参加</p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!--
        <div class="floora">
            <div class="code_content">
                <a href="javascript:void(0);"></a>
            </div>
        </div>
        -->
        <div class="floorb">
            <p class="f_title">题库&nbsp;·&nbsp;VIP八大特权</p>
            <div class="list">
                <ul>
                    <li>
                        <a title="历年真题详解" class="ico" href="#"><img alt="历年真题详解" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico1.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="历年真题详解" href="#">历年真题详解</a>
                        </p>
                        <p class="des">全国各地历年考试真题与答案详解考教师必备资料。</p>
                    </li>
                    <li>
                        <a title="名师解析" class="ico" href="#"><img alt="名师解析" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico2.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="名师解析" href="#">名师解析</a>
                        </p>
                        <p class="des">名师点拨重点试题，分享不同类型的应答策略。</p>
                    </li>
                    <li>
                        <a title="考点配套习题" class="ico" href="#"><img alt="考点配套习题" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico3.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="考点配套习题" href="#">考点配套习题</a>
                        </p>
                        <p class="des">每一个考点都有配套的试题，协助开展系统训练。</p>
                    </li>
                    <li>
                        <a title="逐个击破难点" class="ico" href="#"><img alt="逐个击破难点" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico4.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="逐个击破难点" href="#">逐个击破难点</a>
                        </p>
                        <p class="des">综合归类难点、易错点，每日一练，各个击破。</p>
                    </li>
                    <li>
                        <a title="我的错题集" class="ico" href="#"><img alt="我的错题集" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico5.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="我的错题集" href="#">我的错题集</a>
                        </p>
                        <p class="des">有错就改才能进步，错题集是复习的重要内容。</p>
                    </li>
                    <li>
                        <a title="智能组卷测试" class="ico" href="#"><img alt="智能组卷测试" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico6.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="智能组卷测试" href="#">智能组卷测试</a>
                        </p>
                        <p class="des">根据练习历史、错题记录，为您量身定制，组合试卷。</p>
                    </li>
                    <li>
                        <a title="备考全攻略" class="ico" href="#"><img alt="备考全攻略" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico7.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="备考全攻略" href="#">备考全攻略</a>
                        </p>
                        <p class="des">根据最新考试政策，推送考试指南、面试技巧。</p>
                    </li>
                    <li>
                        <a title="微信端同步" class="ico" href="#"><img alt="微信端同步" src="<?= VIEW_PATH; ?>tiku/images/index_fb_ico8.png" width="124" height="124" /></a>
                        <p class="title">
                            <a title="微信端同步" href="#">微信端同步</a>
                        </p>
                        <p class="des">微信端实时同步，合理运用碎片时间，为考试加分。</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="floorc">
            <a href="#"><img src="<?= VIEW_PATH; ?>tiku/images/floorc_ad.jpg" /></a>
        </div>
    </div>
</div>
<!-- 微信端 begin -->
<div class="code_html" style="display: none;">
    <style>
        *{ margin:0; padding:0; list-style:none; text-decoration:none; font-size:12px; font-family:"微软雅黑","Arial",sans-serif; border:none; -webkit-appearance: none; border-radius: 0;}
        div.code_bg{ width:100%; height:100%; position:fixed; top:0; left:0; background:#000; opacity:0.8; z-index:999;}
        div.code_box{ width:380px; height:450px; position:fixed; top:50%; left:50%; z-index:1000; margin-left: -210px; margin-top: -250px; background:#fff; border:1px solid #333; border-radius:10px;}
        div.code_box img{ margin:35px 0 0 60px;}
        div.code_box span{ display:block; width:380px; font-size:20px; color:#333; margin:20px 0px 0px 0px; text-align:center;}
        div.code_box p{ width:380px; font-size:24px; color:#333; margin:20px 0px 0px 0px; text-align:center;}
        div.code_box a{ position:absolute; display:block; width:32px; height:32px; background:url(<?= VIEW_PATH; ?>tiku/images/close.png) no-repeat; top:-15px; right:-15px;}
    </style>
    <div class="code_box">
        <img src="<?= VIEW_PATH; ?>tiku/images/tmp_code.png" width="260" height="260" />
        <span>试卷都准备好了，扫吧！</span>
        <p>全新升级，请您移步至手机端</p>
        <a title="关闭" href="javascript:close_it();"></a>
    </div>
    <div class="code_bg"></div>
    <script>
        function close_it() {
            $("div.code_html").hide();
            $('body').css('overflow', 'auto');
        }
    </script>
</div>
<!-- 微信端 end -->
<script>
    /*
     $('div.index a').click(function(){
     $('div.code_html').show();
     $('body').css('overflow', 'hidden');
     return false;
     })
     $('div.header div.bottom a').click(function(){
     $('div.code_html').show();
     $('body').css('overflow', 'hidden');
     return false;
     })
     */
</script>
<!-- 系统提示弹窗 end -->
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index_banner.js"></script>