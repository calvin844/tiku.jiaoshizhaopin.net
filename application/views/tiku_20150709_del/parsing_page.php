<link href="<?= VIEW_PATH; ?>tiku/css/parsing_page.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box">
        <div class="list_box parsing">
            <ul class="left_box">
                <li class="ico">
                    <i></i>
                </li>
                <?php if (!empty($id)): ?>
                    <li>
                        <a target="_self" href="/tiku/exam_report/<?= $id ?>" title="查看报告">查看报告</a>
                    </li>
                    <li>
                        <a class="cur" target="_self" href="/tiku/exam_parsing/<?= $id ?>" title="查看解析">查看解析</a>
                    </li>
                    <li class="only_error">
                        <input type="checkbox" /><span>只看错题</span>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="cur" target="_self" href="#" title="查看题目">查看题目</a>
                    </li>
                <?php endif; ?>
                <li class="code">
                    <p>轻松考教师就扫我！</p>
                    <img src="<?= VIEW_PATH; ?>tiku/images/jiaoshi_code.jpg" width="120" height="120" />
                    <p>教师招考通·题库</p>
                </li>
            </ul>
            <div class="right_box">
                <input type="hidden" id="q_id" value="<?= $q_id ?>" />
                <div class="top_title">
                    <p><?= $user_sheet_arr['name']; ?></p>
                    <?php if (!empty($id)): ?>
                        <span>交卷时间：<b><?= date("Y-m-d H:i", $user_sheet_arr['submittime']); ?></b></span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($id)): ?>
                    <div class="item_title_box">
                        <ul>
                            <!--循环试题类型选项卡 begin-->
                            <?php foreach ($exam_paper as $k => $v): ?>
                                <li <?php if ($k == 'part_1'): ?>class="cur"<?php endif; ?>>
                                    <a class="chapter-switch" href="javascript:void(0);" id="<?= $k ?>"><?= $v['name']; ?> [ <?= $v['question_num']; ?>道 ]</a>
                                    <span></span>
                                </li>
                            <?php endforeach; ?>
                            <!--循环试题类型选项卡 end-->
                        </ul>
                    </div>
                <?php endif; ?>

                <!--循环试题类型描述 begin-->
                <?php foreach ($exam_paper as $k => $v): ?>
                    <?php if (!empty($id)): ?>
                        <p id="<?= $k ?>" class="item_description_box" <?php if ($k == "part_1"): ?>style="display: block;"<?php endif; ?> ><?= $v['description']; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!--循环试题类型描述 end-->



                <?php $i = 0; ?>
                <?php foreach ($exam_paper as $k => $v): ?>
                    <div id="<?= $k ?>" class="question_list">
                        <?php foreach ($v['question_result'] as $q): ?>
                            <?php $i++; ?>
                            <div <?php if (!empty($id)): ?>score="<?= $v['question_points'] ?>"<?php endif; ?>  id="question_<?= $q['id'] ?>" class="item_box <?php if (empty($user_answer_arr[$q['id']]['user_answer']) || $user_answer_arr[$q['id']]['info']['is_correct'] == 2): ?>false<?php endif; ?>">
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
                                    <div class="answer">
                                        <p class="circle"><?= $i; ?></p>
                                        <p class="problem"><span class="type">(<?= $q['question_type_cn'] ?>)</span><?= $q['title'] ?></p>
                                        <?php if (!empty($v['answer_arr'][$q['id']])): ?>
                                            <ol>
                                                <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                    <li id="question_<?= $a_k ?>_<?= $a_v['id'] ?>" <?php if (!empty($user_answer_arr[$q['id']]['user_answer']) && in_array($a_v['id'], $user_answer_arr[$q['id']]['user_answer'])): ?>class="cur"<?php endif; ?>>
                                                        <span><?= substr($letter, $a_k, 1); ?>.</span>
                                                        <p><?= $a_v['content'] ?></p>
                                                    </li>
                                                <?php endforeach; ?>           
                                            </ol>
                                        <?php endif; ?>

                                        <div class="options">
                                            <?php if (strstr($q['correct'], "##")): ?>
                                                <p><span>正确答案是
                                                        <?php $quesetion_correct_arr = explode("##", trim($q['correct'], "##")); ?>
                                                        <?php $c_str = ""; ?>
                                                        <?php foreach ($quesetion_correct_arr as $qc): ?>
                                                            <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                                <?php if ($a_v['id'] == $qc): ?>
                                                                    <?php $c_str.=substr($letter, $a_k, 1) . "和"; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                        <?php $c_str = trim($c_str, "和"); ?>
                                                        <?= $c_str; ?>
                                                        ，</span>&nbsp;
                                                    <?php if (empty($user_answer_arr[$q['id']]['user_answer'])): ?>
                                                        您没有回答这道题目
                                                    <?php else: ?>
                                                        您的答案是
                                                        <?php $u_str = ""; ?>
                                                        <?php foreach ($user_answer_arr[$q['id']]['user_answer'] as $ua): ?>
                                                            <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                                <?php if ($a_v['id'] == $ua): ?>
                                                                    <?php $u_str.=substr($letter, $a_k, 1) . "和"; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                        <?php $u_str = trim($u_str, "和"); ?>
                                                        <?= $u_str; ?>
                                                    <?php endif; ?>
                                                <div class="operation">
                                                    <?php if (in_array($q['id'], $user_collection)): ?>
                                                        <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="取消收藏" class="cancel_favor"><i></i>取消收藏</a>
                                                    <?php else: ?>
                                                        <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="收藏本题" class="favor"><i></i>收藏本题</a>
                                                    <?php endif; ?>
                                                    <b></b>
                                                    <a href="javascript:void(0);" class="put"><i></i>收起解析</a>
                                                </div>
                                            <?php else: ?>
                                                <p><span>正确答案是</span></p>
                                                <div class="operation">
                                                    <?php if (in_array($q['id'], $user_collection)): ?>
                                                        <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="取消收藏" class="cancel_favor"><i></i>取消收藏</a>
                                                    <?php else: ?>
                                                        <a favor-id="<?= $q['id'] ?>" href="javascript:void(0);" title="收藏本题" class="favor"><i></i>收藏本题</a>
                                                    <?php endif; ?>
                                                    <b></b>
                                                    <a href="javascript:void(0);" class="put"><i></i>收起解析</a>
                                                </div>
                                                <div class="clear"></div>
                                                <p>
                                                    <?php if (!empty($q['answer'])): ?>
                                                        <?= $q['answer'] ?>
                                                    <?php else: ?>
                                                        <?= $q['description'] ?>
                                                    <?php endif; ?>
                                                </p>

                                            <?php endif; ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="resolve">
                                        <?php if ($q['question_type_id'] != "3" && $q['question_type_id'] != "4" && $q['question_type_id'] != "6" && $q['question_type_id'] != "7"): ?>
                                            <div class="count">
                                                <p class="circle">统计</p>
                                                <p>个人数据: 作答本题<?= !empty($user_answer_arr[$q['id']]['num']) ? $user_answer_arr[$q['id']]['num'] : 0 ?>次，答错<?= !empty($user_answer_arr[$q['id']]['error_num']) ? $user_answer_arr[$q['id']]['error_num'] : 0 ?>次</p>
                                                <p>全站数据: 本题共被作答<?= !empty($all_answer_arr[$q['id']]['num']) ? $all_answer_arr[$q['id']]['num'] : 0; ?>次，正确率为<?= !empty($all_answer_arr[$q['id']]['true_rate']) ? $all_answer_arr[$q['id']]['true_rate'] : 0; ?>%，易错项为 <span class="correct-answer">[
                                                        <?php if (!empty($all_answer_arr[$q['id']]['false_item'])): ?>
                                                            <?php foreach ($v['answer_arr'][$q['id']] as $a_k => $a_v): ?>
                                                                <?php if ($a_v['id'] == $all_answer_arr[$q['id']]['false_item']): ?>
                                                                    <?= substr($letter, $a_k, 1); ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>   
                                                        <?php endif; ?>
                                                        ]</span></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($q['description'])): ?>
                                            <div class="explain">
                                                <p class="circle">解析</p>
                                                <p><?= $q['description'] ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="test">
                                            <p class="circle">考点</p>
                                            <label class="keypoint-info"><?= $question_point_arr[$q['id']]['point']['name']; ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php $next_part = substr($k, 5); ?>
                        <?php $next_part = "part_" . ($next_part + 1); ?>
                        <?php if (!empty($exam_paper[$next_part])): ?>
                        <div class="next_part_box">
                            <a class="next_part" href="javascript:void(0);">点击进入下一部分 >></a>
                        </div>
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
                                            <a part-data="<?= $k ?>" question-data="question_<?= $v['id'] ?>" class="answers_a <?php if (empty($user_answer_arr[$v['id']]['info']['is_correct'])): ?>none<?php elseif ($user_answer_arr[$v['id']]['info']['is_correct'] != 1): ?>false<?php endif; ?>" href="javascript:void(0);"><?= $l; ?></a>
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
    <a class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<div class="clear"></div>
<!-- 材料题最大化 begin -->
<div class="big_material_box">
    <div class="big_material">
        <a class="close" href="javascript:void(0);"></a>
        <div class="content_box"></div>
    </div>
</div>
<!-- 材料题最大化 end -->

<div class="black_bg"></div>

<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/summary.js"></script>
