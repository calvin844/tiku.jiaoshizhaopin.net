<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<div class="main reg">
	<div class="main_box">
    	<div class="title">
        	<i></i>
            <p>师资格证考试</p>
            <span>注册</span>
        </div>
        <div class="content">
            <img src="<?= $ticket ?>" width="200" height="200"/>
            <i></i>
            <p>微信扫码开始注册</p>
        </div>
    </div>
</div>

<script>
    var timer = setInterval("check_wechat_verification()", 2000);
    function check_wechat_verification() {
        $.post("/tiku/check_wechat_verification", {'verification_code': '<?= $verification_code ?>'}, function(result) {
            if (result == 'overdue') {
                window.location.reload();
            } else if (result != 'waiting') {
                clearInterval(timer);
                window.location.href = result;
            }
        });
    }
</script>

<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
