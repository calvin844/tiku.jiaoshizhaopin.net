<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>设置密码</title>
        <script type="text/javascript" src="<?= VIEW_PATH; ?>tiku/js/jquery.js"></script>
    </head>
    <body>
        <style>
            *{ margin:0; padding:0; list-style:none; text-decoration:none; font-size:12px; font-family:"微软雅黑","Arial",sans-serif; border:none; -webkit-appearance: none; border-radius: 0;}
            div.clear{ clear:both;}
            div.pwd_bg{ width:100%; height:100%; position:fixed; top:0; left:0; background:#000; opacity:0.8; z-index:999;}
            div.pwd_box{ width:540px; height:270px; position:fixed; top:50%; left:50%; z-index:1000; margin-left: -280px; margin-top: -250px; background:url(<?= VIEW_PATH; ?>tiku/images/login_bg.png) no-repeat; border:1px solid #333; border-radius:10px;}
            div.pwd_box ul{ margin:100px 0 0 125px;}
            div.pwd_box ul li{ margin:0px 0px 7px 0px; float:left;}
            div.pwd_box input{ border: 1px solid #999; border-radius: 10px; color: #999; float: left; font-size: 14px; height: 30px; line-height: 30px; margin: 10px 0 0; padding: 5px 10px; width: 270px;}
            div.pwd_box ul li.pwd span.warning{ color:#F00 !important;}
            div.pwd_box ul li.pwd span.tips{ color:#999; float:left;  font-size:14px; line-height:30px;}
            div.pwd_box ul li input.sure{ color:#fff; background:#1a8eb2; width:290px; height:30px; line-height:28px; display:inline-block; float:left; text-align:center; margin:5px 0px 0px 0px; font-size:16px; border:none; padding:0; cursor:pointer;}
            div.pwd_box ul li input.sure:hover{ background:#0099ff;}
        </style>
        <div class="pwd_box">
            <form action="/tiku/sms_login" method="post">
                <ul>
                    <li class="pwd">
                        <input name="pwd" class="pwd" type="text" str="请填写密码" value="请填写密码" />
                        <div class="clear"></div>
                        <span class="tips">由6到16位以上的数字和字母组成</span>
                    </li>
                    <div class="clear"></div>
                    <li><input type="submit" class="sure" value="确定" /></li>
                </ul>
            </form>
        </div>
        <div class="pwd_bg"></div>
        <script>
            $('div.pwd_box input.pwd').focus(function() {
                $('span.tips').removeClass('warning');
                $('span.tips').html('由6到16位以上的数字和字母组成');
                $(this).css('color', "#333");
                if ($(this).val() == $(this).attr('str')) {
                    $(this).val('');
                }
            }).blur(function() {
                if ($(this).val() == "") {
                    $(this).removeAttr('style');
                    $(this).val($(this).attr('str'));
                }
            })
            $('form').submit(function() {
                var pwd = $('input.pwd').attr('value');
                if (!(/^[0-9A-z]{6,16}$/.test(pwd))) {
                    $('span.tips').addClass('warning');
                    $('span.tips').html('密码格式错误！');
                    return false;
                } else {
                    $('span.tips').removeClass('warning');
                }
            })
        </script>
    </body>
</html>
