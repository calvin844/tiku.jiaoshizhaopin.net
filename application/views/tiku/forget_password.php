<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>


<div class="main forget_password">
    <div class="main_box">
        <div class="title">
            <i></i>
            <p>师资格证考试</p>
            <span>忘记密码</span>
        </div>
       	<div class="content">
            <form action="" method="post">
                <ul>
                    <li class="tips">
                        <p>请填写以下信息重置密码</p>
                    </li>
                    <li class="phone">
                        <span class="i_name">手机号</span>
                        <input type="text" name="phone" class="phone" />
                        <span class="p_warnning">*</span>
                        <img class="phone_flag" src="<?= VIEW_PATH; ?>tiku/images/make_info_ture.png" />
                        <span class="phone_loading">检测中...</span>
                    </li>
                    <li class="code">
                        <span class="i_name">验证码</span>
                        <input type="text" name="code" class="code" />
                        <a title="发送验证码" class="send_code" href="javascript:void(0);">发送验证码</a>
                    </li>
                    <li class="password">
                        <span class="i_name">新密码</span>
                        <input type="text" name="pwd" class="pwd" />
                        <span class="w_warnning">*密码格式错误</span>
                        <div class="clear"></div>
                        <p class="tips">由6到16位的数字和字母组成</p>
                    </li>
                    <li class="submit">
                        <div class="clear">
                            <span class="warnning">*信息填写有误</span>
                        </div>
                        <input class="submit" type="submit" value="确定" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/common.js"></script>
<script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/index.js"></script>
