<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box exercise">
        <div class="list_box incorrect">
            <ul class="top" id="navLink">
                <li class="">
                    <a title="练习历史" href="/tiku/show_history">练习历史</a>
                    <span></span>
                </li>
                <li>
                    <a title="我的收藏本" href="/tiku/show_collection">我的收藏本</a>
                    <span></span>
                </li>
                <li  class="cur">
                    <a title="错题集" href="/tiku/show_error">错题集</a>
                    <span></span>
                </li>
            </ul>
            <div class="content">
                <?php if (!empty($user_error)): ?>
                    <?php foreach ($exam_house as $e): ?>
                        <p class="house_name"><?= $e['name'] ?></p>
                        <ul>
                            <?php foreach ($user_error as $u): ?>
                                <?php if (isset($u['info']['parent_id'])&&$u['info']['parent_id'] == 0 && !empty($u['info']['exam_house_id']) && $u['info']['exam_house_id'] == $e['id']): ?>
                                    <li class="level1" parent-id="0" data-id="<?= $u['info']['id'] ?>">
                                        <p>
                                            <span class="sprite-expand open"></span>
                                            <?= $u['info']['name'] ?>（共<?= $u['question_num'] ?>道题）
                                        </p>
                                        <div class="right">
                                            <?php if ($u['question_num'] > 0): ?>
                                                <a title="查看题目" href="/tiku/show_error?id=<?= $u['info']['id'] . "-" . trim($u['question_id'], ",") ?>">查看题目</a>
                                            <?php endif; ?>
                                            <a title="<?= $u['info']['name'] ?>" href="/tiku_<?= $u['info']['house']['short_name'] . "/" . $u['info']['index']['id'] . "_" . $u['info']['id'] ?>" class="exercise_bt <?php if ($u['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                        </div>
                                    </li>
                                    <?php foreach ($user_error as $u2): ?>
                                        <?php if (!empty($u2['info']['parent_id']) && ($u2['info']['parent_id'] == $u['info']['id'])): ?>
                                            <li class="level2" parent-id="<?= $u2['info']['parent_id'] ?>" data-id="<?= $u2['info']['id'] ?>">
                                                <p>
                                                    <span class="sprite-expand open"></span>
                                                    <?= $u2['info']['name'] ?>（共<?= $u2['question_num'] ?>道题）
                                                </p>
                                                <div class="right">
                                                    <?php if ($u2['question_num'] > 0): ?>
                                                        <a title="查看题目" href="/tiku/show_error?id=<?= $u2['info']['id'] . "-" . trim($u2['question_id'], ",") ?>">查看题目</a>
                                                    <?php endif; ?>
                                                    <a title="<?= $u2['info']['name'] ?>" href="/tiku_<?= $u2['info']['house']['short_name'] . "/" . $u2['info']['index']['id'] . "_" . $u2['info']['id'] ?>" class="exercise_bt <?php if ($u2['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                                </div>
                                            </li>
                                            <?php foreach ($user_error as $u3): ?>
                                                <?php if (!empty($u3['info']['parent_id']) && ($u3['info']['parent_id'] == $u2['info']['id'])): ?>
                                                    <li class="level3" parent-id="<?= $u3['info']['parent_id'] ?>" data-id="<?= $u3['info']['id'] ?>">
                                                        <p>
                                                            <span class="sprite-expand open"></span>
                                                            <?= $u3['info']['name'] ?>（共<?= $u3['question_num'] ?>道题）
                                                        </p>
                                                        <div class="right">
                                                            <?php if ($u3['question_num'] > 0): ?>
                                                                <a title="查看题目" href="/tiku/show_error?id=<?= $u3['info']['id'] . "-" . trim($u3['question_id'], ",") ?>">查看题目</a>
                                                            <?php endif; ?>
                                                            <a title="<?= $u3['info']['name'] ?>" href="/tiku_<?= $u3['info']['house']['short_name'] . "/" . $u3['info']['index']['id'] . "_" . $u3['info']['id'] ?>" class="exercise_bt <?php if ($u3['question_num'] < 1): ?>grey<?php endif; ?>">来15道题</a>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="tips">赞！还没有错误试题！&nbsp;<a title="马上寻找自己不足之处！" target="_self" href="/">点击这里</a>&nbsp;，马上寻找自己不足之处！</p>
                <?php endif; ?>
            </div>
        </div>
        <a class="back-to-top" href="javascript:void(0);"><span></span></a>
    </div>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>