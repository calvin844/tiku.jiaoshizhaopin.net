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
            <div class="main_box news_list">
                <a title="全部" href="/tiku/news_list">全部</a>
                <?php foreach ($news_type_list as $l): ?>
                    <a title="<?= $l['name'] ?>" class="<?= $l['id'] == $news_type_id ? "cur" : "" ?>" href="/tiku/news_list?type_id=<?= $l['id'] ?>"><?= $l['name'] ?></a>
                <?php endforeach; ?>
                <ul>
                    <?php foreach ($news_info as $i): ?>
                        <li><a title="<?= $i['type_cn'] ?>" href="/tiku/news_list?type_id=<?= $i['type_id'] ?>">&nbsp;[<?= $i['type_cn'] ?>]&nbsp;</a><a title="<?= $i['title'] ?>" href="/<?= $i['id'] ?>.html"><?= $i['title'] ?> --- <?= date('Y-m-d H:i:s', $i['addtime']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php for ($i = 1; $i <= $total_page; $i++): ?>
                    <a title="<?= $i ?>" class="<?= $i == $page ? "cur" : "" ?>" href="/tiku/news_list?type_id=<?= $news_type_id ?>&page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>

        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>