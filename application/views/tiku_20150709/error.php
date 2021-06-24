<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box exercise">
        <div class="list_box incorrect">
            <ul class="top" id="navLink">
                <li class="">
                    <a href="/tiku/show_history">练习历史</a>
                    <span></span>
                </li>
                <li>
                    <a href="/tiku/show_collection">我的收藏本</a>
                    <span></span>
                </li>
                <li  class="cur">
                    <a href="/tiku/show_error">错题集</a>
                    <span></span>
                </li>
            </ul>
            <div class="content">
                <?php if (!empty($user_error)): ?>
                    <ul>
                        <?php foreach ($user_error as $u): ?>
                            <?php if ($u['info']['parent_id'] == 0): ?>
                                <li class="level1" parent-id="0" data-id="<?= $u['info']['id'] ?>">
                                    <p>
                                        <span class="sprite-expand open"></span>
                                        <?= $u['info']['name'] ?>（共<?= $u['question_num'] ?>道题）
                                    </p>
                                    <div class="right">
                                        <?php if ($u['question_num'] > 0): ?>
                                            <a href="/tiku/show_error?id=<?= $u['info']['id'] . "-" . trim($u['question_id'], ",") ?>">查看题目</a>
                                        <?php endif; ?>
                                        <!--
                                        <a href="/tiku_<?= $_SESSION['house_name'] . "/" . $index . "_" . $u['info']['id'] ?>" class="exercise_bt <?php if ($u['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                        -->
                                    </div>
                                </li>
                                <?php foreach ($user_error as $u2): ?>
                                    <?php if ($u2['info']['parent_id'] == $u['info']['id']): ?>
                                        <li class="level2" parent-id="<?= $u2['info']['parent_id'] ?>" data-id="<?= $u2['info']['id'] ?>">
                                            <p>
                                                <span class="sprite-expand open"></span>
                                                <?= $u2['info']['name'] ?>（共<?= $u2['question_num'] ?>道题）
                                            </p>
                                            <div class="right">
                                                <?php if ($u2['question_num'] > 0): ?>
                                                    <a href="/tiku/show_error?id=<?= $u2['info']['id'] . "-" . trim($u2['question_id'], ",") ?>">查看题目</a>
                                                <?php endif; ?>
                                                <a href="/tiku_<?= $_SESSION['house_name'] . "/" . $index . "_" . $u2['info']['id'] ?>" class="exercise_bt <?php if ($u2['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                            </div>
                                        </li>
                                        <?php foreach ($user_error as $u3): ?>
                                            <?php if ($u3['info']['parent_id'] == $u2['info']['id']): ?>
                                                <li class="level3" parent-id="<?= $u3['info']['parent_id'] ?>" data-id="<?= $u3['info']['id'] ?>">
                                                    <p>
                                                        <span class="sprite-expand open"></span>
                                                        <?= $u3['info']['name'] ?>（共<?= $u3['question_num'] ?>道题）
                                                    </p>
                                                    <div class="right">
                                                        <?php if ($u3['question_num'] > 0): ?>
                                                            <a href="/tiku/show_error?id=<?= $u3['info']['id'] . "-" . trim($u3['question_id'], ",") ?>">查看题目</a>
                                                        <?php endif; ?>
                                                        <a href="/tiku_<?= $_SESSION['house_name'] . "/" . $index . "_" . $u3['info']['id'] ?>" class="exercise_bt <?php if ($u3['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="tips">赞！还没有错误试题！&nbsp;<a target="_self" href="/tiku_<?= $_SESSION['house_name'] ?>">点击这里</a>&nbsp;，马上寻找自己不足之处！</p>
                <?php endif; ?>
            </div>
        </div>
        <a class="back-to-top" href="javascript:void(0);"><span></span></a>
    </div>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>