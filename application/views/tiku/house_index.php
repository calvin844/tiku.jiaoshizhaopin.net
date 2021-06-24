<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<?php if ($son_house_name == "all" || empty($son_house_name)): ?>
    <?php if ($paper_type == 0 || empty($paper_type)): ?>
        <title><?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试试题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试,教师资格考试" />
        <meta name="description" content="<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试真题与模拟试题大全。" />
    <?php elseif ($paper_type == 1): ?>
        <title><?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试模拟题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年教师资格考试,教师资格考试模拟题" />
        <meta name="description" content="<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试真题与模拟试题大全。" />
    <?php elseif ($paper_type == 2): ?>
        <title><?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试真题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年教师资格考试,教师资格考试真题,历年教师资格考试真题" />
        <meta name="description" content="<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试真题与模拟试题大全。" />
    <?php endif; ?>
<?php elseif (!empty($son_house_name)): ?>
    <?php if ($paper_type == 0 || empty($paper_type)): ?>
        <title><?= $son_house_cn; ?>_<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试试题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年教师资格考试,<?= $son_house_cn; ?>试题,<?= $son_house_cn; ?>考题" />
        <meta name="description" content="<?= date("Y", time()); ?>年幼儿教师资格证考试<?= $son_house_cn; ?>真题与模拟试题大全。" />
    <?php elseif ($paper_type == 1): ?>
        <title><?= $son_house_cn; ?>_<?= date("Y", time()); ?>年幼儿教师资格考试模拟题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年教师资格考试,<?= $son_house_cn; ?>模拟题" />
        <meta name="description" content="<?= date("Y", time()); ?>年幼儿教师资格证考试<?= $son_house_cn; ?>真题与模拟试题大全。" />
    <?php elseif ($paper_type == 2): ?>
        <title><?= $son_house_cn; ?>_<?= date("Y", time()); ?>年幼儿教师资格考试真题_教师招聘网</title>
        <meta name="keywords" content="<?= date("Y", time()); ?>年教师资格考试,<?= $son_house_cn; ?>真题" />
        <meta name="description" content="<?= date("Y", time()); ?>年<?= $_SESSION['house_name_cn'] ?>教师资格考试真题与模拟试题大全。" />
    <?php endif; ?>
<?php endif; ?>
<div class="main house_index">
    <div class="main_box">

        <!--
        <div class="banner_box">
            <img src="<?= VIEW_PATH; ?>tiku/images/house_banner.jpg" />
        </div>
        <?php if (!empty($top_list)): ?>
                                                            <div class="top_box">
                                                                <div class="title_box">
                                                                    <p><?= $_SESSION['house_name_cn'] ?>教师资格证考试&nbsp;·&nbsp;考试攻略</p>
                                                                    <a href="#content_box">更多</a>
                                                                </div>
                                                                <ul>
            <?php foreach ($top_list as $p): ?>
                                                                                                                        <li><i></i><a href="/tiku_<?= $p['house_name'] ?>/<?= $p['index'] ?>_<?= $p['id'] ?>"><?= $p['name'] ?></a></li>
            <?php endforeach; ?>
                                                                </ul>
                                                            </div>
        <?php endif; ?>
        -->

        <div id="content_box" class="content_box">
            <div class="title_box">
                <p><?= $_SESSION['house_name_cn'] ?>教师资格证考试&nbsp;·&nbsp;历年真题与模拟试卷</p>
            </div>
            <div class="left">
                <!--
                <input type="hidden" class="house_id" value="0"/>
                <input type="hidden" class="type_id" value="0"/>
                <input type="hidden" class="page" value="1"/>
                -->
                <div class="title">
                    <div class="nav">
                        <ul>
                            <li><a title="全部" house_id="0" class="<?= $son_house_name == "all" ? 'hover' : ''; ?>" href="/<?= $_SESSION['house_name'] ?>/all">全部</a></li>
                            <?php foreach ($son_house as $s): ?>
                                <li><a title="<?= $s['name'] ?>" house_id="<?= $s['id'] ?>" class="<?= $s['short_name'] == $son_house_name ? 'hover' : ''; ?>" href="/<?= $_SESSION['house_name'] ?>/<?= $s['short_name'] ?>/<?= $paper_type ?>"><?= $s['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="type">
                        <p>类型：</p>
                        <a title="全部" class="<?= $paper_type == 0 ? 'hover' : '' ?>" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/0">全部</a>
                        <a title="模拟题" class="<?= $paper_type == 1 ? 'hover' : '' ?>" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/1">模拟题</a>
                        <a title="真题" class="<?= $paper_type == 2 ? 'hover' : '' ?>" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/2">真题</a>
                    </div>
                </div>
                <script>
                    /*停用 异步获取试卷列表
                     $('div.house_index div.left div.nav a').click(function() {
                     $('div.left div.nav a').removeClass('hover');
                     $(this).addClass('hover');
                     $('div.left input.house_id').attr('value', $(this).attr('house_id'));
                     $('div.left div.type a').each(function() {
                     if ($(this).hasClass('hover')) {
                     $('div.left input.type_id').attr('value', $(this).attr('type_id'));
                     }
                     });
                     $('div.left div.page_box a').each(function() {
                     if ($(this).hasClass('hover')) {
                     $('div.left input.page').attr('value', 1);
                     }
                     });
                     update_list();
                     })
                     $('div.house_index div.left div.type a').click(function() {
                     $('div.left div.type a').removeClass('hover');
                     $(this).addClass('hover');
                     $('div.left input.type_id').attr('value', $(this).attr('type_id'));
                     $('div.left div.nav a').each(function() {
                     if ($(this).hasClass('hover')) {
                     $('div.left input.house_id').attr('value', $(this).attr('house_id'));
                     }
                     });
                     $('div.left div.page_box a').each(function() {
                     if ($(this).hasClass('hover')) {
                     $('div.left input.page').attr('value', 1);
                     }
                     });
                     update_list();
                     })
                     $('div.house_index div.left div.page_box a').live('click', function() {
                     if ($(this).hasClass('page')) {
                     $('div.left div.page a').removeClass('hover');
                     $(this).addClass('hover');
                     }
                     $('div.left input.page').attr('value', $(this).attr('p_data'));
                     update_list();
                     })
                     function update_list() {
                     $.get('/tiku/ajax_get_paper_list?house_id=' + $('div.left input.house_id').attr('value') + '&type_id=' + $('div.left input.type_id').attr('value') + '&page=' + $('div.left input.page').attr('value'), function(data) {
                     var arr = data.split('##');
                     var ul_str = "";
                     for (var i = 2; i <= arr.length - 1; i++) {
                     var page_arr = arr[i].split('||');
                     ul_str += '<li>';
                     ul_str += '<div class="left">';
                     ul_str += '<i></i>';
                     ul_str += '<a href="/tiku_' + page_arr[0] + '/' + page_arr[1] + '_' + page_arr[2] + '">' + page_arr[3] + '</a>';
                     ul_str += '<div class="clear"></div>';
                     ul_str += '<p>试题难度：' + page_arr[4] + '&nbsp;&nbsp;考试时间：' + page_arr[5] + '&nbsp;&nbsp;总分：' + page_arr[6] + '分</p>';
                     ul_str += '</div>';
                     ul_str += '<div class="right">';
                     ul_str += '<a href="/tiku_' + page_arr[0] + '/' + page_arr[1] + '_' + page_arr[2] + '">开始测试</a>';
                     ul_str += '<div class="clear"></div>';
                     ul_str += '<p>已有' + page_arr[7] + '人参加</p>';
                     ul_str += '</div>';
                     ul_str += '</li>';
                     }
                     $('div.left ul.list').html(ul_str);
                     if (arr[1] > 0) {
                     var page_str = '<a p_data ="1" href="javascript:void(0);">首页</a>';
                     if ((parseInt(arr[0]) - 1) < 1) {
                     var per_page = 1;
                     } else {
                     var per_page = (parseInt(arr[0]) - 1);
                     }
                     page_str += '<a p_data ="' + per_page + '" href="javascript:void(0);">上一页</a>';
                     for (var i = 1; i <= arr[1]; i++) {
                     if (i == arr[0]) {
                     var c = "page hover";
                     } else {
                     var c = "page";
                     }
                     page_str += '<a p_data ="' + i + '" class="' + c + '" href="javascript:void(0);">' + i + '</a>';
                     }
                     if ((parseInt(arr[0]) + 1) > arr[1]) {
                     var next_page = arr[1];
                     } else {
                     var next_page = (parseInt(arr[0]) + 1);
                     }
                     page_str += '<a p_data ="' + next_page + '" href="javascript:void(0);">下一页</a>';
                     page_str += '<a p_data ="' + arr[1] + '" href="javascript:void(0);">尾页</a>';
                     page_str += '<span>' + arr[0] + '/' + arr[1] + '页</span>';
                     $('div.left div.page_box').html(page_str);
                     } else {
                     $('div.left div.page_box').html("");
                     }
                     });
                     }
                     $('div.house_index div.left div.nav a.hover').click();
                     */
                </script>
                <ul class="list">
                    <?php foreach ($paper_list['list'] as $p): ?>
                        <li>
                            <div class="left">
                                <i></i>
                                <a title="<?= $p['name'] ?>" href="/tiku_<?= $p['house_name'] ?>/<?= $p['index'] ?>_<?= $p['id'] ?>"><?= $p['name'] ?></a>
                                <div class="clear"></div>
                                <p>试题难度：<?= $p['hard'] ?>&nbsp;&nbsp;考试时间：<?= $p['paper_time'] ?>&nbsp;&nbsp;总分：<?= $p['paper_points'] ?>分</p>
                            </div>
                            <div class="right">
                                <a title="开始测试" href="/tiku_<?= $p['house_name'] ?>/<?= $p['index'] ?>_<?= $p['id'] ?>">开始测试</a>
                                <div class="clear"></div>
                                <p>已有<?= $p['do_num'] ?>人参加</p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="page_box">
                    <a title="首页" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/<?= $paper_type ?>/1">首页</a>
                    <a title="上一页" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/<?= $paper_type ?>/<?= $page - 1 > 0 ? $page - 1 : 1; ?>">上一页</a>
                    <?php for ($i = 1; $i <= $paper_list['total']; $i++): ?>
                        <a title="<?= $i ?>" class="<?= $i == $page ? 'hover' : ''; ?>" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/<?= $paper_type ?>/<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <a title="下一页" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/<?= $paper_type ?>/<?= $page + 1 > $paper_list['total'] ? $paper_list['total'] : $page + 1; ?>">下一页</a>
                    <a title="尾页" href="/<?= $_SESSION['house_name'] ?>/<?= $son_house_name ?>/<?= $paper_type ?>/<?= $paper_list['total'] ?>">尾页</a>
                    <span><?= $page ?>/<?= $paper_list['total'] ?>页</span>

                </div>
            </div>
            <div class="right">
                <img class="free" src="<?= VIEW_PATH; ?>tiku/images/free.png" />
                <?php if (!empty($index_list)): ?>
                    <?php foreach ($index_list as $k => $v): ?>
                        <div class="item_box">
                            <p class="title"><?= $k ?></p>
                            <div class="list">
                                <ul>
                                    <?php foreach ($v as $v): ?>
                                        <li>
                                            <div class="top">
                                                <i></i>
                                                <?php if ($v['index_function'] == "quick_exam" && $v['index_function'] == "paper_exam"): ?>
                                                    <a title="<?= $v['house_name_cn'] ?>" class="index" href="/tiku_<?= $v['house_name'] ?>/<?= $v['id'] ?>"><?= $v['house_name_cn'] ?></a>
                                                    <a title="<?= $v['house_name_cn'] ?>" class="right" href="/tiku_<?= $v['house_name'] ?>/<?= $v['id'] ?>">练一练</a>
                                                <?php elseif ($v['index_function'] == "special_exam"): ?>
                                                    <a title="<?= $v['house_name_cn'] ?>" id="special_exam" house_id="<?= $v['exam_house_id'] ?>" class="index" href="javascript:void(0);"><?= $v['house_name_cn'] ?></a>                                            
                                                    <a title="<?= $v['house_name_cn'] ?>" id="special_exam" house_id="<?= $v['exam_house_id'] ?>" class="right" href="javascript:void(0);">练一练</a>
                                                <?php elseif ($v['index_function'] == "real_exam"): ?>
                                                    <a title="<?= $v['house_name_cn'] ?>" id="real_exam" house_id="<?= $v['exam_house_id'] ?>" class="index" href="javascript:void(0);"><?= $v['house_name_cn'] ?></a>                                            
                                                    <a title="<?= $v['house_name_cn'] ?>" id="real_exam" house_id="<?= $v['exam_house_id'] ?>" class="right" href="javascript:void(0);">练一练</a>
                                                <?php else: ?>
                                                    <a title="<?= $v['house_name_cn'] ?>" class="index" href="/tiku_<?= $v['house_name'] ?>/<?= $v['id'] ?>"><?= $v['house_name_cn'] ?></a>                                            
                                                    <a title="<?= $v['house_name_cn'] ?>" class="right" href="#">练一练</a>
                                                <?php endif; ?>
                                            </div>
                                            <p class="bottom">已有<?= $v['do_num'] ?>人参加</p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <script>
                    $('div.house_index a#special_exam').live('click', function() {
                        $.get('/tiku/ajax_exam_point/' + $(this).attr('house_id'), function(data) {
                            var point_arr = data.split('##');
                            var point_str = "";
                            for (var i = 0; i <= point_arr.length - 1; i++) {
                                var point = point_arr[i].split('||');
                                if (point[3] == 0) {
                                    point_str += '<li class="level1" data-id="' + point[4] + '" parent-id="0">';
                                    point_str += '<div class="left">';
                                    point_str += '<p class="title"><span class="sprite-expand open"></span>' + point[5] + '（共' + point[6] + '道题）</p>';
                                    point_str += '</div>';
                                    point_str += '<div class="right">';
                                    point_str += '<a title="来15道题" href="/tiku_' + point[1] + '/' + point[2] + '_' + point[4] + '">来15道题</a>';
                                    point_str += '</div>';
                                    point_str += '</li>';
                                    for (var i2 = 0; i2 <= point_arr.length - 1; i2++) {
                                        var point2 = point_arr[i2].split('||');
                                        if (point2[3] == point[4]) {
                                            point_str += '<li class="level2" data-id="' + point2[4] + '" parent-id="' + point[4] + '">';
                                            point_str += '<div class="left">';
                                            point_str += '<p class="title"><span class="sprite-expand open"></span>' + point2[5] + '（共' + point2[6] + '道题）</p>';
                                            point_str += '</div>';
                                            point_str += '<div class="right">';
                                            point_str += '<a title="来15道题" href="/tiku_' + point2[1] + '/' + point2[2] + '_' + point2[4] + '">来15道题</a>';
                                            point_str += '</div>';
                                            point_str += '</li>';
                                            for (var i3 = 0; i3 <= point_arr.length - 1; i3++) {
                                                var point3 = point_arr[i3].split('||');
                                                if (point3[3] == point2[4]) {
                                                    point_str += '<li class="level3" data-id="' + point3[4] + '" parent-id="' + point2[4] + '">';
                                                    point_str += '<div class="left">';
                                                    point_str += '<p class="title"><span class="sprite-expand open"></span>' + point3[5] + '（共' + point3[6] + '道题）</p>';
                                                    point_str += '</div>';
                                                    point_str += '<div class="right">';
                                                    point_str += '<a title="来15道题" href="/tiku_' + point3[1] + '/' + point3[2] + '_' + point3[4] + '">来15道题</a>';
                                                    point_str += '</div>';
                                                    point_str += '</li>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $('div.point_box div.list_box ul').html(point_str);
                        })
                        var t_name = $(this).parent().find('a.index').html();
                        $('div.point_box p.tips').html(t_name + " 专项及考点");
                        $('div.black_bg').show();
                        $('div.point_box').show();
                    })
                    $('div.house_index a#real_exam').live('click', function() {
                        $.get('/tiku/ajax_real_paper_list/' + $(this).attr('house_id'), function(page_str) {
                            var page_arr = page_str.split("#");
                            var ul_str = "";
                            for (var i = 3; i < page_arr.length; i++) {
                                if (page_arr[i].indexOf("|") > 0) {
                                    var p_arr = page_arr[i].split("|");
                                    ul_str += '<li>';
                                    ul_str += '<div class="left">';
                                    ul_str += '<p class="name" title="' + p_arr[0] + '">' + p_arr[0] + '</p>';
                                    ul_str += '<span class="info">试卷难度 ' + p_arr[1] + ' ,已有 ' + p_arr[2] + ' 人模考，平均得分 ' + p_arr[3] + '</span>';
                                    ul_str += '</div>';
                                    ul_str += '<div class="right">';
                                    if (p_arr[4] > 0) {
                                        ul_str += '<span>已完成' + p_arr[4] + '次</span>';
                                        ul_str += '<a title="再做一次" class="do" href="/tiku_' + p_arr[6] + '/' + p_arr[7] + '_' + p_arr[5] + '">再做一次</a>';
                                    } else {
                                        ul_str += '<a title="立即模考" class="do" href="/tiku_' + p_arr[6] + '/' + p_arr[7] + '_' + p_arr[5] + '">立即模考</a>';
                                    }
                                    ul_str += '</div>';
                                    ul_str += '</li>';
                                }
                            }
                            var total_page = parseInt(page_arr[1]);
                            var page_s = "";
                            for (var p = 1; p < total_page + 1; p++) {
                                page_s += '<a ';
                                if (p == page_arr[3]) {
                                    page_s += 'class="cur"';
                                }
                                page_s += ' house_id=' + page_arr[0] + '  href="javascript:void(0);">' + p + '</a>';
                            }
                            var o_title = $('div.real_box div.title p').html();
                            $('div.real_box div.title p').html(o_title + '历年真题共' + page_arr[2] + '套');
                            $('div.real_box ul').html(ul_str);
                            $('div.real_box div.page_box').html(page_s);
                        })
                        var t_name = $(this).parent().find('a.index').html();
                        $('div.real_box div.title p').html('教师招考通·题库已收录' + t_name);
                        $('div.real_black_bg').show();
                        $('div.real_box').show();
                    })
                </script>
                <div class="wechat_box">
                    <img src="<?= VIEW_PATH; ?>tiku/images/wechat_code.jpg" width="160" height="160" />
                    <p>扫描测试</p>
                </div>
            </div>
        </div>
        <a href="#"><img src="<?= VIEW_PATH; ?>tiku/images/floorc_ad.jpg" /></a>
    </div>
</div>

<!--专项练习弹窗 begin -->
<div class="point_box">
    <div class="bg">
        <div class="title">
            <p>考点巩固</p>
            <a title="关闭" class="close" href="javascript:void(0);"></a>
        </div>
        <p class="tips"></p>
        <div class="list_box">
            <ul></ul>
        </div>
    </div>
</div>
<div class="black_bg"></div>
<!--专项练习弹窗 end -->

<!--真题模考 begin -->
<div class="real_box">
    <div class="bg">
        <div class="title">
            <p></p>
            <a title="关闭" class="close" href="javascript:void(0);"></a>
        </div>
        <div class="list_box">
            <ul></ul>
        </div>
        <div class="page_box" total=""></div>
    </div>
</div>
<div class="real_black_bg"></div>
<!--真题模考 end -->
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>