<link href="<?= VIEW_PATH; ?>tiku/css/index.css" type="text/css" rel="stylesheet"/>


<div class="main make_info">
    <div class="main_box">
        <div class="title">
            <i></i>
            <p>师资格证考试</p>
            <span>完善信息</span>
        </div>
       	<div class="content">
            <form action="" method="post">
                <ul>
                    <li class="tips">
                        <i></i><p>您已通过微信验证，完善信息保障您的安全</p>
                    </li>
                    <li class="phone">
                        <span class="i_name">手机号</span>
                        <input type="text" name="phone" class="phone" />
                        <span class="p_warnning">*</span>
                        <img class="phone_flag" src="<?= VIEW_PATH; ?>tiku/images/make_info_ture.png" />
                        <span class="phone_loading">检测中...</span>
                    </li>
                    <li class="img">
                        <span class="i_name">图片验证码</span>
                        <div id="imgdiv"></div>
                        <input id="postcaptcha" type="text" value="点击获取验证码" style="color:#999999"/>
                    </li>
                    <li class="code">
                        <span class="i_name">手机验证码</span>
                        <input type="text" name="code" class="code" />
                        <span class="send_code">发送验证码</span>
                        <a style="display: none;" title="发送验证码" class="send_code" href="javascript:void(0);">发送验证码</a>
                    </li>
                    <li class="password">
                        <span class="i_name">密码</span>
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
<script src="<?= VIEW_PATH; ?>tiku/js/jquery.validate.min.js" type='text/javascript' language="javascript"></script>
<script>
    $("input#postcaptcha").focus(function() {
        $('span.send_code').show();
        $('a.send_code').hide();
    });
    $("input#postcaptcha").change(function() {
        $.post("<?= VIEW_PATH; ?>tiku/plus/imagecaptcha.php", {"act": "verify", "postcaptcha": $(this).val()}, function(result) {
            if (result == 'true') {
                $("#imgdiv img").attr("src", $("#imgdiv img").attr("src") + "?1");
                $(this).val("");
                $('span.send_code').hide();
                $('a.send_code').show();
            } else {
                $("#imgdiv img").attr("src", $("#imgdiv img").attr("src") + "?1");
                $(this).val("");
                $('span.send_code').show();
                $('a.send_code').hide();
            }
        });
    });
    jQuery.validator.addMethod("IScaptchastr", function(value, element) {
        var str = "点击获取验证码";
        var flag = true;
        if (str == value) {
            flag = false;
        }
        return  flag || this.optional(element);
    }, "请填写验证码");
    function imgcaptcha(inputID, imgdiv) {
        $(inputID).focus(function() {
            if ($(inputID).val() == "点击获取验证码") {
                $(inputID).val("");
                $(inputID).css("color", "#333333");
            }
            $(inputID).parent("div").css("position", "relative");
            //设置验证码DIV
            $(imgdiv).css({position: "absolute", left: "355px", "bottom": "12px", "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid", "display": "none", "margin-left": "15px"});
            $(imgdiv).show();
            if ($(imgdiv).html() == '') {
                $(imgdiv).append("<img src='<?= VIEW_PATH; ?>tiku/plus/imagecaptcha.php' id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px;\" title=\"看不请验证码？点击更换一张\"  border=\"0\"/>");
            }
            $(imgdiv + " img").click(function() {
                $(imgdiv + " img").attr("src", $(imgdiv + " img").attr("src") + "?1");
                $(inputID).val("");
                //$("#Form1").validate().element("#postcaptcha");
            });
            $(document).unbind().click(function(event) {
                var clickid = $(event.target).attr("id");
                if (clickid != "getcode" && clickid != "postcaptcha")
                {
                    $(imgdiv).hide();
                    $(inputID).parent("div").css("position", "");
                    $(document).unbind();
                }
            });
        });
    }
    imgcaptcha("#postcaptcha", "#imgdiv");
</script>
