<!DOCTYPE html>
<html lang="zh-CN">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="<?= VIEW_PATH; ?>tiku/css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/jquery.js"></script>
    </head>
    <style>
        body{ background: #f5f5f5;}
    </style>
    <body>
        <div class="main">
            <div class="main_box do_test">
                <img class="top_logo" src="<?= VIEW_PATH; ?>tiku/images/logo.png" />
                <div class="list_box">
                    <div class="left">
                        <p class="title">薄弱科目测试</p>
                        <p class="tip">选择您最薄弱得科目开始测试</p>
                        <ul>
                            <li class="teacher"><p>教师类型：</p><a id="t0" class="teacher cur" href="javascript:void(0);">幼儿</a><a id="t1" class="teacher" href="javascript:void(0);">小学</a><a id="t2" class="teacher" href="javascript:void(0);">中学</a></li>
                            <?php if (!empty($exam_house_list)): ?>
                                <?php foreach ($exam_house_list as $key => $value): ?>
                                    <li class="subjects t<?= $key; ?>"><p>考试科目：</p>
                                        <?php foreach ($value as $v): ?>
                                            <a data="<?= $v['id'] ?>" class="subjects" href="javascript:void(0);"><?= $v['name'] ?></a>
                                        <?php endforeach; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <form action="/tiku/do_test2" method="post">
                            <input type="hidden" id="house_id" name="house_id" value="0" />
                            <input class="submit" type="submit" value="开始弱点测试" />
                            <p>机会只留给早做准备的人，<a target="_blank" href="<?= MAIN_SITE_URL ?>subscribe/" title="订阅职位">订阅职位</a></p>
                        </form>
                    </div>
                    <div class="right">
                        <p class="title">轻松考教师</p>
                        <p class="item"><span>优势一：</span>历年真题，详细讲解；考点，难点各个击破</p>
                        <p class="item"><span>优势二：</span>多端同步，利用碎片时间完成每日练习</p>
                        <p class="item"><span>优势三：</span>为您建立教师知识模型，强化薄弱环节和面试技巧</p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>