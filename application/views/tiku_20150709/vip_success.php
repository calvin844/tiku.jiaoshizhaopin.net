<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <div class="main_box">
        <div class="list_box vip">
            <p class="title">充值</p>
            <div class="process_box">
                <p><b>1</b>填写订单</p>
                <p><b>2</b>确认订单</p>
                <p class="cur"><b>3</b>支付结果</p>
            </div>
            <div class="clear"></div>
            <?php if ($endtime != 0): ?>
                <p class="success_tips">充值成功！您当前服务的到期时间为<b><?= $endtime; ?></b></p>
                <a class="bt" href="/tiku_<?= $_SESSION['house_name'] ?>">马上去练习</a>
            <?php endif; ?>
        </div>
    </div>
    <a class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
