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
            <a title="点击领取" id="get_coupons" class="right" href="#">点击领取</a>
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
                                    <a title="<?= $ei['button_name'] ?>" id="<?= $ei['id'] ?>" class="<?= $ei['index_function'] ?>" href="/tiku_<?= $_SESSION['house_name'] ?>/<?= $ei['id'] ?>" title=""><?= $ei['button_name'] ?></a>
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
                                <a title="继续练习" href="<?= $my_exam['url'] ?>" title="">继续练习</a>
                            <?php else: ?>
                                <a title="继续练习" class="grey" href="javascript:void(0)" title="">继续练习</a>
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
                <a title="关闭" class="close" href="javascript:void(0);"></a>
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
                                    <a title="来15道题" href="#">来15道题</a>
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
                                            <a title="来15道题" href="#">来15道题</a>
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
                                                    <a title="来15道题" href="#">来15道题</a>
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
                <a title="关闭" class="close" href="javascript:void(0);"></a>
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
                                <a title="<?= $r['do_num'] > 0 ? "再做一次" : "立即模考"; ?>" class="do" href="<?= $r['name']; ?>"><?= $r['do_num'] > 0 ? "再做一次" : "立即模考"; ?></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="page_box" total="<?= $real_paper_total_page; ?>">
                <?php for ($i = 1; $i < $real_paper_total_page + 1; $i++): ?>
                    <a title="<?= $i; ?>" <?php if ($i == 1): ?>class="cur"<?php endif; ?> href="javascript:void(0);"><?= $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="real_black_bg"></div>
<?php endif; ?>
<!--真题模考 end -->



<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
