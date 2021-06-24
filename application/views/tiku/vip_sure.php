<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/qrcode.js"></script>
<div class="main">
    <div class="main_box">
        <div class="list_box vip">
            <p class="title">我的VIP</p>
            <?php if ($endtime > 0): ?>
                <p class="deadline">您是教师招考通·题库VIP用户，到期时间为<b><?= $endtime; ?></b></p>
            <?php else: ?>
                <p class="deadline">加入VIP，轻松考教师，更多服务不断开通中</p>
            <?php endif; ?>
            <div class="process_box">
                <p><b>1</b>填写订单</p>
                <p class="cur"><b>2</b>确认订单</p>
                <p><b>3</b>支付结果</p>
            </div>
            <div class="clear"></div>
            <div class="info_box">
                <p>订单号：</p><span><?= $order_id; ?></span>
                <br/>
                <p>充值金额：</p><span class="red"><?= $amount; ?>元</span>
                <br/>
                <p>支付方式：</p><span><?= $payment_name; ?></span>
                <?php if($fee > 0):?>
                <br/>
                <p>手续费：</p><span class="red"><?= $fee; ?>元</span>
                <?php endif;?>
            </div>
            <?= $payment_form; ?>
        </div>
    </div>
    <a title="回到顶部" class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>