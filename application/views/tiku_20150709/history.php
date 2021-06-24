<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box exercise">
        <div class="list_box history">
            <ul class="top" id="navLink">
                <li class="cur">
                    <a href="/tiku/show_history">练习历史</a>
                    <span></span>
                </li>
                <li>
                    <a href="/tiku/show_collection">我的收藏本</a>
                    <span></span>
                </li>
                <li class="">
                    <a href="/tiku/show_error">错题集</a>
                    <span></span>
                </li>
            </ul>
            <?php if (!empty($user_sheet)): ?>
                <ul class="content">
                    <?php foreach ($user_sheet as $u): ?>
                        <li>
                            <div class="left">
                                <p class="title"><?= $u['sheet']['name']; ?></p>
                                <p class="info"> 练习时间: <?= date("Y年m月d日 H:i", $u['sheet']['submittime']); ?>&nbsp;答题情况: 做对&nbsp;<?= $u['correct_num']; ?>&nbsp;道/共&nbsp;<?= $u['sheet']['total_question']; ?>&nbsp;道&nbsp;</p>
                            </div>
                            <div class="right">
                                <?php if ($u['sheet']['is_complete'] == 2): ?>
                                    <a href="/tiku/exam_report/<?= $u['sheet']['id']; ?>">查看报告</a>
                                    <a href="/tiku/exam_parsing/<?= $u['sheet']['id']; ?>">查看解析</a>
                                <?php else: ?>
                                    <p>未完成</p>
                                    <a class="exercise_bt" href="/tiku/continue_exam/<?= $u['sheet']['id']; ?>">继续做题</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="tips">还没做过练习？&nbsp;<a target="_self" href="/tiku_<?= $_SESSION['house_name'] ?>">点击这里</a>&nbsp;，马上提升自己！</p>
            <?php endif; ?>
            <div class="page_box">
                <?php for ($p = 1; $p < $page['total'] + 1; $p++): ?>
                    <a target="_self" class="<?php if ($p == $page['cur']): ?>cur<?php endif; ?>" href="/tiku/show_history?page=<?= $p; ?>"><?= $p; ?></a>
                <?php endfor; ?>
            </div>
        </div>
        <a class="back-to-top" href="javascript:void(0);"><span></span></a>
    </div>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
