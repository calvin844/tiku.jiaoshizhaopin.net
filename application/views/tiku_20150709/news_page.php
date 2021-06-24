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
            <div class="main_box news_page">
                <a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="/tiku/news_list?type_id=<?=$news['type_id']?>"><?=$news['type_cn']?></a>&nbsp;&nbsp;>&nbsp;&nbsp;<span><?= $news['title'] ?></span>
                <h1><?= $news['title'] ?></h1>
                <p>发布时间：<?= date('Y-m-d', $news['addtime']) ?>&nbsp;&nbsp;&nbsp;&nbsp;作者：中国教师招聘网</p>
                <div><?= $news['content'] ?></div>
            </div>
        </div>

        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>