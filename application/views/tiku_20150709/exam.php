<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="banner_box">
    <div class="main_box">
        <img src="<?= VIEW_PATH; ?>tiku/images/tiku_banner.jpg" />
    </div>
</div>
<div class="main">
    <?php if (!empty($coupons)): ?>
        <div class="main_box coupons">
            <div class="left">
                <div class="title">
                    <p>VIP</p>
                    <p>限时优惠</p>
                </div>
                <div class="description">
                    <p>百万优惠卷每日限量发送</p>
                    <span>每人仅限1次，当天使用，不可兑现</span>
                </div>
            </div>
            <p class="data">
                今日已发<b><?= $coupons['false_total'] ?></b>元，已有<b><?= $coupons['total_num'] ?></b>人领取，仅剩<b><?= $coupons['remain'] ?></b>张
            </p>
            <a id="get_coupons" class="right" href="#">点击领取</a>
        </div>
    <?php endif; ?>
    <div class="main_box exam">
        <div class="list_box">
            <?php if (!empty($exam_index_list)): ?>
                <ul>
                    <?php foreach ($exam_index_list as $ei) : ?>
                        <li>
                            <div class="left">
                                <img src="http://img.jiaoshizhaopin.net/<?= $ei['icon_path'] ?>" width="65" height="66" />
                            </div>
                            <div class="left">
                                <p class="index_name"><?= $ei['name'] ?></p>
                                <p class="index_description"><?= $ei['description'] ?></p>
                                <?php if (!empty($ei['button_name'])): ?>
                                    <a id="<?= $ei['id'] ?>" class="<?= $ei['index_function'] ?>" href="/tiku_<?= $_SESSION['house_name'] ?>/<?= $ei['id'] ?>" title=""><?= $ei['button_name'] ?></a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <div class="left">
                            <img src="<?= VIEW_PATH; ?>tiku/images/jixu_ico.png" width="65" height="66" />
                        </div>
                        <div class="left">
                            <p class="index_name">继续上次练习</p>
                            <p class="index_description"><?= $my_exam['sheet']['note'] ?></p>
                            <?php if (!empty($my_exam['url'])): ?>
                                <a href="<?= $my_exam['url'] ?>" title="">继续练习</a>
                            <?php else: ?>
                                <a class="grey" href="javascript:void(0)" title="">继续练习</a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
        <ul class="index_side">
            <li class="mobile_code_bt">
                <img src="<?= VIEW_PATH; ?>tiku/images/fuchuang.png" width="44" height="44" />
                <div class="mobile_code_box">
                    <p>轻松考教师就扫我！</p>
                    <img src="<?= VIEW_PATH; ?>tiku/images/jiaoshi_code.jpg" width="120" height="120" />
                    <p>教师招考通·题库</p>
                    <i></i>
                </div>
            </li>
            <li>
                <a target="_blank" title="点击QQ咨询" href="http://wpa.qq.com/msgrd?v=3&amp;uin=6210210&amp;site=qq&amp;menu=yes">
                    <img src="<?= VIEW_PATH; ?>tiku/images/qq.png" width="44" height="44" />
                </a>
            </li>
        </ul>
    </div>
</div>
<!--专项练习弹窗 begin -->
<?php if (!empty($exam_point_list)): ?>
    <div class="point_box">
        <div class="bg">
            <div class="title">
                <p>考点巩固</p>
                <a class="close" href="javascript:void(0);"></a>
            </div>
            <p class="tips"><?= $_SESSION['house_name_cn'] ?> 专项及考点</p>
            <div class="list_box">
                <ul>
                    <?php foreach ($exam_point_list as $e): ?>
                        <?php if ($e['parent_id'] == 0): ?>
                            <li class="level1" data-id="<?= $e['id'] ?>" parent-id="0">
                                <div class="left">
                                    <p class="title"><span class="sprite-expand open"></span><?= $e['name'] ?>（共<?= $e['question_num'] ?>道题）</p>
                                    <div class="clear"></div>
                                    <div class="progress_bg">
                                        <p class="progress"></p>
                                    </div>
                                    <p class="left"><span id="user_num">-</span>道/<span id="total_num"><?= $e['question_num'] ?></span>道</p>
                                </div>
                                <div class="right">
                                    <a href="#">来15道题</a>
                                </div>
                            </li>
                            <?php foreach ($exam_point_list as $e2): ?>
                                <?php if ($e2['parent_id'] == $e['id']): ?>
                                    <li class="level2" data-id="<?= $e2['id'] ?>" parent-id="<?= $e2['parent_id'] ?>">
                                        <div class="left">
                                            <p class="title"><span class="sprite-expand open"></span><?= $e2['name'] ?>（共<?= $e2['question_num'] ?>道题）</p>
                                            <div class="clear"></div>
                                            <div class="progress_bg">
                                                <p class="progress"></p>
                                            </div>
                                            <p class="left"><span id="user_num">-</span>道/<span id="total_num"><?= $e2['question_num'] ?></span>道</p>
                                        </div>
                                        <div class="right">
                                            <a href="#">来15道题</a>
                                        </div>
                                    </li>
                                    <?php foreach ($exam_point_list as $e3): ?>
                                        <?php if ($e3['parent_id'] == $e2['id']): ?>
                                            <li class="level3" data-id="<?= $e3['id'] ?>" parent-id="<?= $e3['parent_id'] ?>">
                                                <div class="left">
                                                    <p class="title"><span class="sprite-expand open"></span><?= $e3['name'] ?>（共<?= $e3['question_num'] ?>道题）</p>
                                                    <div class="clear"></div>
                                                    <div class="progress_bg">
                                                        <p class="progress"></p>
                                                    </div>
                                                    <p class="left"><span id="user_num">-</span>道/<span id="total_num"><?= $e3['question_num'] ?></span>道</p>
                                                </div>
                                                <div class="right">
                                                    <a href="#">来15道题</a>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="black_bg"></div>
<?php endif; ?>
<!--专项练习弹窗 end -->

<!--真题模考 begin -->
<?php if (!empty($real_paper_list)): ?>
    <div class="real_box">
        <div class="bg">
            <div class="title">
                <p>教师招考通·题库已收录<?= $_SESSION['house_name_cn']; ?>历年真题共<?= count($real_paper_list); ?>套</p>
                <a class="close" href="javascript:void(0);"></a>
            </div>
            <div class="list_box">
                <ul>
                    <?php foreach ($real_paper_list as $r): ?>
                        <li data-id="<?= $r['id']; ?>">
                            <div class="left">
                                <p class="name" title="<?= $r['name']; ?>"><?= $r['name']; ?></p>
                                <span class="info">试卷难度 <?= $r['hard']; ?> ,已有 <?= $r['total_do_num']; ?> 人模考，平均得分 <?= sprintf("%.2f", $r['average']); ?></span>
                            </div>
                            <div class="right">
                                <?php if ($r['do_num'] > 0): ?>
                                    <span>已完成<?= $r['do_num']; ?>次</span>
                                <?php endif; ?>
                                <a class="do" href="<?= $r['name']; ?>"><?= $r['do_num'] > 0 ? "再做一次" : "立即模考"; ?></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="page_box" total="<?= $real_paper_total_page; ?>">
                <?php for ($i = 1; $i < $real_paper_total_page + 1; $i++): ?>
                    <a <?php if ($i == 1): ?>class="cur"<?php endif; ?> href="javascript:void(0);"><?= $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="real_black_bg"></div>
<?php endif; ?>
<!--真题模考 end -->

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
                }else if(data.indexOf("恭喜") > -1){
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
