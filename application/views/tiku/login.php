<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>

<div class="main login">
    <div class="main_box">
        <div class="title">
            <i></i>
            <p>师资格证考试</p>
            <span>登录</span>
        </div>
        <div class="content">
            <div class="left">
                <img src="<?= $ticket ?>" width="188" height="190" />
                <i></i>
                <p>微信扫码登录</p>
            </div>
            <div class="right">
                <p class="title">手机号登录</p>
                <form id="login_form" action="" method="post">
                    <ul>
                        <li>
                            <input class="user_name" name="user_name" type="text" str="手机号" value="手机号" />
                        </li>
                        <li>
                            <input class="password text" type="text" str="密码" value="密码" />
                            <input class="password pwd" name="pwd" type="password" value="" />
                        </li>
                        <li class="remember">
                            <input class="remember" type="checkbox" name="remember" value="1" /><span>记住手机号</span>
                        </li>
                        <li>
                            <input type="botton" readonly="readonly" class="submit" value="登录"/>
                        </li>
                        <li class="line">
                            <span class="warning">*手机号或密码错误</span>
                        </li>
                    </ul>
                </form>
                <a title="注册" class="go_reg" href="/tiku/reg/1">注册</a>
                <a title="忘记密码" class="forget_password" href="/tiku/forget_password">忘记密码？</a>
            </div>
        </div>
    </div>
</div>
<script>
    var timer = setInterval("check_wechat_verification()", 2000);
    /*登录 end*/
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
