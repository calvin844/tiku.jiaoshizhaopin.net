<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<div class="main">
    <input type="hidden" value="<?php var_dump($test); ?>">
    <div class="main_box">
        <div class="list_box vip">
            <p class="title">我的VIP</p>
            <?php if ($endtime > 0): ?>
                <p class="deadline">尊敬的题库VIP用户，您的VIP有效期至<b><?= $endtime; ?></b>。</p>
            <?php elseif ($endtime < 0): ?>
                <p class="deadline">您的VIP已过期，为了顺利通过考试，请立即续期。</p>
            <?php else: ?>
                <p class="deadline">开通VIP，享有<b>320</b>套精编试题（含答案与解析），每套低至<b>5分</b>钱，考教师笔试无忧。</p>
            <?php endif; ?>
            <ul class="ad_box">
                <li>
                    <i></i><span>历年真题详解</span>
                </li>
                <li>
                    <i></i><span>必考点配套习题</span>
                </li>
                <li>
                    <i></i><span>错题集专供薄弱环节</span>
                </li>
                <li>
                    <i></i><span>热门职位优先推荐</span>
                </li>
                <li>
                    <i></i><span>考点名师点拨</span>
                </li>
                <li>
                    <i></i><span>难点、重点逐个击破</span>
                </li>
                <li>
                    <i></i><span>考试指南、面试技巧</span>
                </li>
                <li>
                    <i></i><span>微信端同步数据</span>
                </li>
            </ul>
            <div class="process_box">
                <p class="cur"><b>1</b>填写订单</p>
                <p><b>2</b>确认订单</p>
                <p><b>3</b>支付结果</p>
            </div>
            <div class="clear"></div>
            <form id="sure_order" action="/tiku/save_order" method="post">
                <?php if (!empty($package_list)): ?>
                    <p class="left">VIP套餐</p>
                    <ul class="package_list">
                        <?php foreach ($package_list as $p): ?>
                            <li>
                                <input type="radio" name="package_id" value="<?= $p['id']; ?>" />
                                <div class="item_box">
                                    <?php if ($p['price'] > 0): ?>
                                        <p class="discount"><b><?= sprintf("%.1f", ($p['price'] / $p['expense']) * 10); ?></b>折</p>
                                    <?php else: ?>
                                        <p class="discount"><b>0</b>折</p>
                                    <?php endif; ?>
                                    <div class="info">
                                        <p class="days">时长：<?= $p['show_time']; ?></p>
                                        <p class="value">
                                            <span class="expense"><?= $p['expense']; ?>元</span>
                                            <span class="price"><u><?= $p['price']; ?></u>元</span>
                                        </p>
                                    </div>
                                </div>
                                <!--
                                <p class="tip">已有50%用户选择此套餐</p>
                                -->
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p class="left">支付方式</p>
                <ul class="payment_list">
                    <?php foreach ($alipay as $a): ?>
                        <li>
                            <div class="left">
                                <input type="radio" name="payment_id" value="<?= $a['id']; ?>" />
                                <img src="<?= VIEW_PATH; ?>tiku/images/<?= $a['type_name']; ?>.gif" />
                            </div>	
                        </li>
                    <?php endforeach; ?>
                    <?php foreach ($wxpay as $w): ?>
                        <li>
                            <div class="left">
                                <input type="radio" name="payment_id" value="<?= $w['id']; ?>" />
                                <img src="<?= VIEW_PATH; ?>tiku/images/<?= $w['type_name']; ?>.gif" />
                            </div>	
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <?php foreach ($alipayapi as $a_api): ?>
                            <div class="left">
                                <input type="radio" name="payment_id" value="<?= $a_api['id']; ?>" />
                                <img src="<?= VIEW_PATH; ?>tiku/images/<?= $a_api['type_name']; ?>.gif" />
                            </div>	
                        <?php endforeach; ?>
                    </li>
                </ul>
                <?php if (!empty($coupons)): ?>
                    <div class="coupons_box">
                        <div class="tips">
                            <input type="checkbox" name="use_coupons" value="1"/><p>使用优惠卷</p><span>（一次支付只能使用一个优惠码，可抵面额范围内金额，余额不退）</span>
                        </div>
                        <ul class="coupons_list">
                            <?php foreach ($coupons as $c): ?>
                                <li>
                                    <input type="radio" name="coupons_id" value="<?= $c['id'] ?>" />
                                    <p><?= $c['code'] ?></p>
                                    <span>（可抵<span><?= $c['value'] ?></span>元，不可兑现）</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <p class="pay_info">实际支付&nbsp;<span class="total_pay">44</span>&nbsp;元，已为您节省&nbsp;<span class="cut_pay">0</span>&nbsp;元</p>
                <input type="submit" class="sure_order" value="确认订单" />
            </form>
        </div>
        <?php if (!empty($user_order_list)): ?>
            <div class="list_box vip">
                <p class="title">订单</p>
                <ul class="title">
                    <li style="width:200px;">订单号</li>
                    <li style="width:50px;">时间</li>
                    <li style="width:80px;">金额</li>
                    <li style="width:100px;">支付方式</li>
                    <li style="width:80px;">状态</li>
                    <li style="width:200px;">创建时间</li>
                    <!--<li style="width:50px;">备注</li>-->
                    <li style="width:190px;">操作</li>
                </ul>
                <div class="order_list">
                    <table class="table" width="900" border="0" cellspacing="0" cellpadding="0">
                        <tr class="title">
                            <th width="200"></th>
                            <th width="50"></th>
                            <th width="80"></th>
                            <th width="100"></th>
                            <th width="80"></th>
                            <th width="200"></th>
                            <!--<th width="50"></th>-->
                            <th width="190"></th>
                        </tr>
                        <?php foreach ($user_order_list as $u): ?>
                            <tr>
                                <td><?= $u['order_id']; ?></td>
                                <td><?= $u['show_time']; ?></td>
                                <td><?= $u['amount']; ?>元</td>
                                <td><?= $u['payment_name']; ?></td>
                                <td><?= $u['is_paid'] == 0 ? "待付款" : "已完成" ?></td>
                                <td><?= date('Y-m-d H:i:s', $u['addtime']); ?></td>
                                <!--<td><a class="note" href="javascript:void(0);" title="<?= $u['note']; ?>"></a></td>-->
                                <td>
                                    <?php if ($u['is_paid'] == 0): ?>
                                        <a title="支付" href="/tiku/sure_order?order_id=<?= $u['id']; ?>">支付</a><a title="取消" class="close_order" id="o_<?= $u['id']; ?>"  href="javascript:void(0);">取消</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <a title="回到顶部" class="back-to-top" href="javascript:void(0);"><span></span></a>
</div>
<script>
</script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
