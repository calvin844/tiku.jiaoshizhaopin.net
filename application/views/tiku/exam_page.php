<link href="<?= VIEW_PATH; ?>tiku/css/exam_page.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box">
        <div class="list_box">
            <ul class="left_box">
                <li class="time_box">
                    <i></i><span>已用时</span>
                    <?php if (!empty($user_sheet['sheet']['usetime'])): ?>
                        <input type="hidden" id="usetime" value="<?= $user_sheet['sheet']['usetime'] ?>" />
                    <?php endif; ?>
                    <p time-data="<?= $total_time; ?>" time-elapsed="<?= !empty($user_sheet['sheet']['usetime']) ? $user_sheet['sheet']['usetime'] : 0; ?>" time-pause="0">00:00</p>
                </li>
                <li>
                    <a title="暂停" class="time_pause" href="javascript:void(0);" title="暂停">暂停</a>
                </li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li>
                        <a title="下次再做" class="next_time" href="javascript:void(0);" title="下次再做">下次再做</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a title="交卷" class="submit" href="javascript:void(0);" title="交卷">交卷</a>
                </li>
                <li class="code">
                    <p>轻松考教师就扫我！</p>
                    <img src="<?= VIEW_PATH; ?>tiku/images/jiaoshi_code.jpg" width="120" height="120" />
                    <p>教师招考通·题库</p>
                </li>
            </ul>
            <div class="right_box">
                <p class="top_title"><?= $index_name; ?></p>
                <div class="item_title_box">
                    <ul>
                        <!--循环试题类型选项卡 begin-->
                        <?php foreach ($exam_paper as $k => $v): ?>
                            <li <?php if ($k == 'part_1'): ?>class="cur"<?php endif; ?>>
                                <a title="<?= $v['name']; ?>" class="chapter-switch" href="javascript:void(0);" id="<?= $k ?>"><?= $v['name']; ?> [<label class="answer-count">0</label>/<?= $v['question_num']; ?>]</a>
                                <span></span>
                            </li>
                        <?php endforeach; ?>
                        <!--循环试题类型选项卡 end-->
                    </ul>
                </div>

                <!--循环试题类型描述 begin-->
                <?php foreach ($exam_paper as $k => $v): ?>
                    <p id="<?= $k ?>" class="item_description_box" <?php if ($k == "part_1"): ?>style="display: block;"<?php endif; ?> ><?= $v['description']; ?></p>
                <?php endforeach; ?>
                <!--循环试题类型描述 end-->


                <?php $i = 0; ?>
                <?php foreach ($exam_paper as $k => $v): ?>
                    <div id="<?= $k ?>" class="question_list">
                        <?php foreach ($v['question_result'] as $q): ?>
                            <?php $i++; ?>
                            <div score="<?= $v['question_points'] ?>"  id="question_<?= $q['id'] ?>" class="item_box" user-answer="0">
                                <?php if (!empty($v['material_arr'][$q['id']])): ?>
                                    <?php foreach ($v['material_arr'][$q['id']] as $m): ?>
                                        <div class="material_box">
                                            <div class="title_box">
                                                <p class="title">材料</p>
                                                <div class="bt_box">
                                                    <a class="m_show" href="javascript:void(0);" title="材料还原"></a>
                                                    <a class="m_xiao" href="javascript:void(0);" title="材料最小"></a>
                                                    <a class="m_quan" href="javascript:void(0);" title="材料全屏"></a>
                                                </div>
                                            </div>
                                            <div class="content_box">
                                                <div class="content_overflow">
                                                    <?php if (!empty($m['title'])): ?>
                                                        <p class="title"><?= $m['title'] ?></p>
                                                    <?php endif; ?>
                                                    <div class="content">
                                                        <?= $m['content'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="question_box">
                                    <div class="title">
                                        <p class="number"><?= $i; ?></p>
                                        <p class="problem"><span class="type">(<?= $q['question_type_cn'] ?>)</span><?= $q['title'] ?></p>
                                    </div>
                                    <?php if (!empty($v['answer_arr'][$q['id']])): ?>
                                        <div class="options">
                                            <ul>
                                                <?php $a = -1; ?>
                                                <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                    <?php $a++; ?>
                                                    <li id="question_<?= $a_k ?>_<?= $a_v['id'] ?>">
                                                        <span class="lbl"><?= substr($letter, $a, 1); ?>.</span>
                                                        <p><?= $a_v['content'] ?></p>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <div class="answers">
                                        <?php if (!empty($v['answer_arr'][$q['id']])): ?>
                                            <!--type_1是为了区分单选和多项效果，多项效果未做-->
                                            <ul class="<?= ($q['question_type_id'] == 4 || $q['question_type_id'] == 5) ? "type_2" : "type_1" ?>">
                                                <?php $b = -1; ?>
                                                <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                    <?php $b++; ?>
                                                    <li answer-id="<?= $a_v['id'] ?>" id="question_<?= $a_k ?>_<?= $a_v['id'] ?>">
                                                        <span class="answer radio">
                                                            <span class="active"></span>
                                                        </span>
                                                        <?= substr($letter, $b, 1); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="no_answers">本题不支持作答，可在交卷后核对答案并查看解析</p>
                                        <?php endif; ?>
                                        <?php if (!empty($_SESSION['user_id'])): ?>
                                            <?php if (in_array($q['id'], $user_collection)): ?>
                                                <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="取消收藏" class="cancel_favor"><i></i>取消收藏</a>
                                            <?php else: ?>
                                                <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="收藏本题" class="favor"><i></i>收藏本题</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php $next_part = substr($k, 5); ?>
                        <?php $next_part = "part_" . ($next_part + 1); ?>
                        <?php if (!empty($exam_paper[$next_part])): ?>
                            <a title="进入下一部分" class="next_part" href="javascript:void(0);">点击进入下一部分 >></a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <!--循环试题类型试题列表1 end-->

                <div class="answers_box">
                    <div class="answers_list">
                        <div class="title">
                            <p>展开答题卡</p>
                            <span class="arrow up"></span>
                        </div>
                        <ul>
                            <?php $l = 1; ?>
                            <li>
                                <?php foreach ($exam_paper as $k => $v): ?>
                                    <?php if (strstr($k, "part_")): ?>
                                        <?php foreach ($v['question_result'] as $v): ?>
                                            <a title="<?= $l; ?>" part-data="<?= $k ?>" question-data="question_<?= $v['id'] ?>" class="<?php if ($v['question_type_id'] != "3" && $v['question_type_id'] != "4" && $v['question_type_id'] != "6" && $v['question_type_id'] != "7" && $v['question_type_id'] != "8" && $v['question_type_id'] != "9"): ?>answers_a<?php endif; ?>" href="javascript:void(0);"><?= $l; ?></a>
                                            <?php if ($l % 5 == 0): ?>
                                            </li>
                                            <li>
                                            <?php endif; ?>
                                            <?php $l++; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a title="回到顶部" class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<div class="clear"></div>
<!-- 暂停倒时计窗口 begin -->
<div class="time_pause_box">
    <div class="bg">
        <a title="继续做题" href="javascript:void(0);">继续做题</a>
    </div>
</div>
<!-- 暂停倒时计窗口 end -->

<!-- 交卷提示窗口 begin -->
<div class="submit_box">
    <div class="bg">
        <p>确定要交卷吗？</p>
        <a title="确定交卷" class="sure" href="javascript:void(0)">确定交卷</a>
        <a title="谢谢提醒，继续做" class="cancel" href="javascript:void(0)">谢谢提醒，继续做</a>
    </div>
</div>
<!-- 交卷提示窗口 end -->

<!-- 材料题最大化 begin -->
<div class="big_material_box">
    <div class="big_material">
        <a title="关闭" class="m_close" href="javascript:void(0);"></a>
        <div class="content_box"></div>
    </div>
</div>
<!-- 材料题最大化 end -->

<form id="submit_form" method="post" action="/tiku/submit_exam">
    <input type="hidden" name="user_id" value="<?= !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>" />
    <input type="hidden" name="index_id" value="<?= $submit_info['index_id']; ?>" />
    <input type="hidden" name="exam_house_id" value="<?= $submit_info['exam_house_id']; ?>"  />
    <input type="hidden" name="sheet_id" value="<?= $submit_info['sheet_id']; ?>"  />
    <input type="hidden" name="name" value="<?= $submit_info['name']; ?>"  />
    <input type="hidden" name="is_complete" />
    <input type="hidden" name="complete_question" />
    <input type="hidden" name="total_score" value="<?= $submit_info['total_points']; ?>" />
    <input type="hidden" name="total_question" value="<?= $submit_info['total_question']; ?>"  />
    <input type="hidden" name="usetime" />
    <input type="hidden" name="answer_str" />
    <?php if (!empty($user_sheet)): ?>
        <input type="hidden" name="user_sheet_id"  value="<?= $user_sheet['sheet']['id']; ?>" />
        <input type="hidden" id="user_answer"  value="<?= $user_sheet['answer']; ?>" />
    <?php endif; ?>
</form>

<div class="black_bg"></div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/exam_page.js"></script>
