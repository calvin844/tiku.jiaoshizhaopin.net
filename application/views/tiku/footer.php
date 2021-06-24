<div class="clear"></div>
<div class="footer">
    <div class="main_box">
        <p class="nav">
            <a href="<?= MAIN_SITE_URL; ?>aboutus.htm" title="关于我们" target="_blank">关于我们</a>
            <a href="<?= MAIN_SITE_URL; ?>cooperation.htm" title="网站合作" target="_blank">网站合作</a>
            <a href="<?= MAIN_SITE_URL; ?>contactus.htm" title="联系我们" target="_blank">联系我们</a>
            <a href="<?= MAIN_SITE_URL; ?>charge.htm" title="收费标准" target="_blank">收费标准</a>
        </p>
        <p>Copyright 2007-2015 &copy; <a href="<?= MAIN_SITE_URL; ?>" title="中国教师招聘网">Jiaoshizhaopin.net</a>. All Rights Reserved.&nbsp;&nbsp;中国教师招聘网&nbsp;版权所有, 本站保留所有权利</p>
        <p><img src="<?= VIEW_PATH ?>tiku/images/copyright.gif">&nbsp;增值电信业务经营许可证：粤B2-20090053&nbsp;&nbsp;经营性ICP许可证 ICP备案：<a href="http://www.miibeian.gov.cn/">粤ICP备10085786号</a>
            <script src='http://s95.cnzz.com/stat.php?id=511743&web_id=511743' language='JavaScript' charset='gb2312'></script></p>

        <center>
            <span style="margin-left:0px;">
                <a target="_blank" href="http://www.gzaic.gov.cn/GZCX/WebUI/credit/ReadInfo.htm">
                    <img width="109" height="50" src="<?= VIEW_PATH ?>tiku/images/zhizhi1.gif" alt="经营性网站备案信息">
                </a>
            </span>
            <span style="margin-left:4px;">
                <a target="_blank" href="http://www.12377.cn/">
                    <img width="109" height="50" src="<?= VIEW_PATH ?>tiku/images/zhizhi2.gif" alt="不良信息举报中心">
                </a>
            </span>
            <span style="margin-left:4px;">
                <a target="_blank" href="http://210.76.65.188/newwebsite/index.htm">
                    <img width="105" height="50" src="<?= VIEW_PATH ?>tiku/images/zhizhi3.gif" alt="网络110报警服务">
                </a>
            </span>
            <span style="margin-left:4px;">
                <a target="_blank" href="http://netadreg.gzaic.gov.cn/ntmm/WebSear/WebLogoPub.aspx?logo=440106106022008042300152">
                    <img width="105" height="50" src="<?= VIEW_PATH ?>tiku/images/zhizhi4.gif" alt="工商网监">
                </a>
            </span>
        </center>
    </div>
</div>
<!--
<div class="phone_html">
    <div class="phone_box">
        <form action="/tiku/sms_login" method="post">
            <ul>
                <li class="phone"><input name="phone" class="phone" type="text" str="手机号" value="手机号" />
                <li class="code"><input name="code" class="code" type="text" str="验证码" value="验证码" /><a class="send_code" href="javascript:void(0);">发送验证码</a></li>
                <div class="clear">
                    <span class="warning">*手机号码或验证码错误</span>
                </div>
                <li><input type="submit" class="sure" value="确定" /></li>
            </ul>
        </form>
        <a class="close_it" href="javascript:close_it();"></a>
    </div>
    <div class="phone_bg"></div>
    <script type="text/javascript">
        $('div.phone_box input').focus(function() {
            $('div.phone_box ul span.warning').hide();
            if (!$(this).hasClass('sure')) {
                $(this).css('border-color', "#3aa1ed");
                $(this).css('color', "#333");
            }
            if ($(this).val() == $(this).attr('str')) {
                $(this).val('');
            }
        }).blur(function() {
            $(this).css('border-color', "#d5d5d5");
            if ($(this).val() == "") {
                $(this).removeAttr('style');
                $(this).val($(this).attr('str'));
            }
        });
        $('div.phone_box a.send_code').live('click', function() {
            if ($(this).html() == '发送验证码') {
                var sCode = $('input.code').attr('value');
                var sMobile = $('input.phone').attr('value');
                if (!(/^1[0-9][0-9]\d{4,8}$/.test(sMobile)) || sCode == "") {
                    $('div.phone_box ul span.warning').html("*手机号错误");
                    $('div.phone_box ul span.warning').show();
                    return false;
                } else {
                    $('div.phone_box ul li.phone span').hide();
                    $.get('/tiku/ajax_send_sms/' + sMobile, function(data) {
                        if (data == 0) {
                            alert('发送失败！');
                        } else {
                            $('div.phone_box a.send_code').css('background', '#999');
                            $('div.phone_box a.send_code').removeAttr('href');
                            $('div.phone_box a.send_code').html(60);
                            var send_time = setInterval("cut_num()", 1000);
                            if ($('div.phone_box a.send_code').html() == '发送验证码') {
                                clearInterval(send_time);
                            }
                        }
                    })
                }
            }
        });
        function cut_num() {
            var n = $('div.phone_box a.send_code').html();
            n = parseInt(n);
            if (n > 0) {
                n--;
                $('div.phone_box a.send_code').html(n);
            } else {
                clearInterval(send_time);
                $('div.phone_box a.send_code').removeAttr('style');
                $('div.phone_box a.send_code').attr('href', 'javascript:void(0);');
                $('div.phone_box a.send_code').html('发送验证码');
            }
        }
        function close_it() {
            $('div.phone_html').hide();
            //window.location.href = "/";
        }
        $('div.phone_box form').submit(function() {
            var sCode = $('input.code').attr('value');
            var sMobile = $('input.phone').attr('value');
            if (!(/^1[0-9][0-9]\d{4,8}$/.test(sMobile)) || !(/^\d{6}$/.test(sCode))) {
                $('div.phone_box ul span.warning').html("*手机号或验证码错误");
                $('div.phone_box ul span.warning').show();
                return false;
            }
        })
    </script>
</div>
-->
</body>
</html>