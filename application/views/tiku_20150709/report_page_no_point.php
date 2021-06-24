<link href="<?= VIEW_PATH; ?>tiku/css/report_page.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box">
        <div class="list_box">
            <ul class="left_box">
                <li class="ico">
                    <i></i>
                </li>
                <li>
                    <a class="cur" target="_self" href="/tiku/exam_report/<?= $id ?>" title="查看报告">查看报告</a>
                </li>
                <li>
                    <a target="_self" href="/tiku/exam_parsing/<?= $id ?>" title="查看解析">查看解析</a>
                </li>
                <li class="code">
                    <p>轻松考教师就扫我！</p>
                    <img src="<?= VIEW_PATH; ?>tiku/images/jiaoshi_code.jpg" width="120" height="120" />
                    <p>教师招考通·题库</p>
                </li>
            </ul>
            <div class="right_box">
                <div class="title_box">
                    <p><?= $user_sheet_arr['name']; ?></p>
                    <span>交卷时间：<strong><?= date("Y-m-d H:i", $user_sheet_arr['submittime']); ?></strong></span>
                </div>
                <div class="content_box">
                    <div class="summary_1">
                        <div class="left">
                            <p>本次练习<?= $user_sheet_arr['total_question']; ?>道，你答对了</p>
                            <p class="score">
                                <span class="big"><?= $user_correct; ?></span>道
                            </p>
                            <p class="tip"><i class="true"></i><span>正确</span>&nbsp;<i class="false"></i><span>错误</span>&nbsp;<i class="none"></i><span>未答</span></p>
                        </div>
                        <ul class="answer_list">
                            <li>
                                <?php $l = 1; ?>
                                <?php foreach ($question_arr as $q): ?>
                                    <a data="<?= $q['question_id']; ?>" class="<?php if (!empty($user_question[$q['question_id']]) && $user_question[$q['question_id']] == 1): ?>true<?php elseif (!empty($user_question[$q['question_id']]) && $user_question[$q['question_id']] == 2): ?>false<?php else: ?>none<?php endif; ?>" href="/tiku/exam_parsing/<?= $id ?>?q_id=<?= $q['question_id']; ?>"><?= $l; ?></a>
                                    <?php if ($l % 5 == 0): ?>
                                    </li>
                                    <li>
                                    <?php endif; ?>
                                    <?php $l++; ?>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                        <div class="clear"></div>
                        <ul class="report_list">
                            <li>
                                <p>您的得分：</p>
                                <span><?= $user_sheet_arr['score']; ?> 分</span>
                            </li>
                            <li>
                                <p>全站平均得分：</p>
                                <span><?= sprintf("%.2f", $average_score); ?> 分</span>
                            </li>
                            <li>
                                <p>已击败考生：</p>
                                <span><?= sprintf("%.2f", $beyond_people); ?>%</span>
                            </li>
                            <li>
                                <p>答题时间：</p>
                                <span><?php if (!empty($usetime['m'])): ?><?= $usetime['m'] ?>分<?php endif; ?> <?= $usetime['s'] ?>秒</span>
                            </li>
                            <li>
                                <p>答题量：</p>
                                <span><?= $user_sheet_arr['complete_question']; ?>/<?= $user_sheet_arr['total_question']; ?> 道</span>
                            </li>
                            <li>
                                <p>总分：</p>
                                <span><?= $user_sheet_arr['total_score']; ?>分</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<div class="clear"></div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/summary.js"></script>
