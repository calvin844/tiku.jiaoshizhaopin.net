<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box exercise">
        <div class="list_box history">
            <ul class="top" id="navLink">
                <li class="cur">
                    <a title="练习历史" href="/tiku/show_history">练习历史</a>
                    <span></span>
                </li>
                <li>
                    <a title="我的收藏本"  href="/tiku/show_collection">我的收藏本</a>
                    <span></span>
                </li>
                <li class="">
                    <a title="错题集" href="/tiku/show_error">错题集</a>
                    <span></span>
                </li>
            </ul>
            <?php if (!empty($user_sheet)): ?>
                <ul class="content">
                    <?php foreach ($user_sheet as $u): ?>
                        <li>
                            <div class="left">
                                <p class="title"><?= $u['sheet']['name']; ?></p>
                                <p class="info"> 练习时间: <?= date("Y年m月d日 H:i", $u['sheet']['submittime']); ?>
                                    <?php if ($u['sheet']['is_complete'] == 2): ?>
                                        &nbsp;答题情况: 做对&nbsp;<?= $u['correct_num']; ?>&nbsp;道/共&nbsp;<?= $u['sheet']['total_question']; ?>&nbsp;道&nbsp;
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="right">
                                <?php if ($u['sheet']['is_complete'] == 2): ?>
                                    <a title="查看报告" href="/tiku/exam_report/<?= $u['sheet']['id']; ?>">查看报告</a>
                                    <a title="查看解析" href="/tiku/exam_parsing/<?= $u['sheet']['id']; ?>">查看解析</a>
                                <?php else: ?>
                                    <p>未完成</p>
                                    <a title="继续做题" class="exercise_bt" href="/tiku/continue_exam/<?= $u['sheet']['id']; ?>">继续做题</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="tips">还没做过练习？&nbsp;<a title="马上提升自己" target="_self" href="/">点击这里</a>&nbsp;，马上提升自己！</p>
            <?php endif; ?>
            <div class="page_box">
                <?php for ($p = 1; $p < $page['total'] + 1; $p++): ?>
                    <a title="<?= $p; ?>" target="_self" class="<?php if ($p == $page['cur']): ?>cur<?php endif; ?>" href="/tiku/show_history?page=<?= $p; ?>"><?= $p; ?></a>
                <?php endfor; ?>
            </div>
        </div>
        <a title="回到顶部" class="back-to-top" href="javascript:void(0);"><span></span></a>
    </div>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
