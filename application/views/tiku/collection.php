<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box exercise">
        <div class="list_box favorite">
            <ul class="top" id="navLink">
                <li class="">
                    <a title="练习历史" href="/tiku/show_history">练习历史</a>
                    <span></span>
                </li>
                <li class="cur">
                    <a title="我的收藏本" href="/tiku/show_collection">我的收藏本</a>
                    <span></span>
                </li>
                <li class="">
                    <a title="错题集" href="/tiku/show_error">错题集</a>
                    <span></span>
                </li>
            </ul>
            <div class="content">
                <?php if ($total > 0): ?>
                    <p class="total">共<?= $total ?>条收藏</p>
                    <?php foreach ($exam_house as $e): ?>
                        <p class="house_name"><?= $e['name'] ?></p>
                        <ul>
                            <?php foreach ($user_collect as $u): ?>
                                <?php if ($u['info']['parent_id'] == 0 && $u['info']['exam_house_id'] == $e['id']): ?>
                                    <li class="level1" data-id="<?= $u['info']['id'] ?>" parent-id="0">
                                        <p>
                                            <span class="sprite-expand open"></span>
                                            <?= $u['info']['name'] ?>（共<?= $u['question_num'] ?>道题）
                                        </p>
                                        <div class="right">
                                            <a  title="<?= $u['info']['name'] ?>" href="/tiku/show_collection?id=<?= $u['info']['id'] ?>-<?= trim($u['question_id'], ",") ?>">查看题目</a>
                                        </div>
                                    </li>
                                    <?php foreach ($user_collect as $u2): ?>
                                        <?php if ($u2['info']['parent_id'] == $u['info']['id']): ?>
                                            <li class="level2" data-id="<?= $u2['info']['id'] ?>" parent-id="<?= $u2['info']['parent_id'] ?>">
                                                <p>
                                                    <span class="sprite-expand open"></span>
                                                    <?= $u2['info']['name'] ?>（共<?= $u2['question_num'] ?>道题）
                                                </p>
                                                <div class="right">
                                                    <a title="<?= $u['info']['name'] ?>" href="/tiku/show_collection?id=<?= $u2['info']['id'] ?>-<?= trim($u2['question_id'], ",") ?>">查看题目</a>
                                                </div>
                                            </li>
                                            <?php foreach ($user_collect as $u3): ?>
                                                <?php if ($u3['info']['parent_id'] == $u2['info']['id']): ?>
                                                    <li class="level3" data-id="<?= $u3['info']['id'] ?>" parent-id="<?= $u3['info']['parent_id'] ?>">
                                                        <p>
                                                            <?= $u3['info']['name'] ?>（共<?= $u3['question_num'] ?>道题）
                                                        </p>
                                                        <div class="right">
                                                            <a title="<?= $u['info']['name'] ?>" href="/tiku/show_collection?id=<?= $u3['info']['id'] ?>-<?= trim($u3['question_id'], ",") ?>">查看题目</a>
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
                    <p class="tips">还没有自己的收藏本？&nbsp;<a title="马上打造您的专属练习本！" target="_self" href="/">点击这里</a>&nbsp;，马上打造您的专属练习本！</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a title="回到顶部" class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>