<?php

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    /*
     * 名称：get_result
     * 功能：按条件获取数据表数据
     * 输入：$table：表名；$where：条件数组；$select：获取字段
     * 输出：数据表数据（多维数组）
     */

    public function get_result($table, $where = array(), $select = "") {
        if (!empty($select)) {
            $this->db->select($select);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        $result = $query->result_array();
        //var_dump($result);exit;
        return $result;
    }

    /*
     * 名称：get_row
     * 功能：按条件获取数据表数据
     * 输入：$table：表名；$where：条件数组；$select：获取字段
     * 输出：单条数据表数据（一维数组）
     */

    public function get_row($table, $where = array(), $select = "") {
        if (!empty($select)) {
            $this->db->select($select);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        $result = $query->row_array();
        //var_dump($result);exit;
        return $result;
    }

    /*
     * 名称：insert_one
     * 功能：数据插入数据表
     * 输入：$table：表名；$in_arr：插入数据数组；
     * 输出：插入成功后的自增ID
     */

    public function insert_one($in_arr = array(), $table = "") {
        $this->db->insert($table, $in_arr);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /*
     * 名称：update_one
     * 功能：更新数据表
     * 输入：$table：表名；$up_arr：更新数据数组；$where：更新条件
     * 输出：更新状态
     */

    public function update_one($table = "", $up_arr = array(), $where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
            return $this->db->update($table, $up_arr);
        }
    }

    /*
     * 名称：delete_one
     * 功能：删除数据表数据
     * 输入：$table：表名；$del_arr：删除条件数组；
     * 输出：删除失败返回数据组，成功返回true
     */

    public function delete_one($table = "", $del_arr = array()) {
        $this->db->delete($table, $del_arr);
        $has_id = $this->get_row($table, $del_arr);
        if (!empty($has_id)) {
            return $has_id;
        } else {
            return TRUE;
        }
    }

    /*
     * 名称：get_order_list_by_qsid
     * 功能：根据用户骑士ID获取订单列表
     * 输入：$qs_user_id:用户骑士ID；
     * 输出：相关用户订单记录
     */

    public function get_order_list_by_user_id($user_id) {
        $this->db->where(' user_id = ' . $user_id);
        $this->db->order_by("addtime", "desc");
        $query = $this->db->get("order");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_payment_by_id
     * 功能：根据支付方式ID获取支付方式数据
     * 输入：$payment_id:支付方式ID；
     * 输出：相关支付方式信息
     */

    public function get_payment_by_id($payment_id) {
        $return = $this->get_row("payment", array('id' => $payment_id));
        return $return;
    }

    /*
     * 名称：show_dialog
     * 功能：显示弹窗
     * 输入：$content：弹窗主体内容；$bt_str：按钮文字；$go_url：按钮链接；$close_back：点击关闭是否返回；$title：弹窗标题；
     * 输出：弹窗并中止程序
     */

    public function show_dialog($content = "", $bt_str = "关闭", $go_url = "javascript:close_it();", $close_back = 0, $title = "系统提示") {
        if ($close_back > 0) {
            $close_back = "javascript:history.go(-1);";
        } else {
            $close_back = "javascript:close_it();";
        }
        $dialog_html = '';
        $dialog_html .='<!DOCTYPE html>';
        $dialog_html .='<html lang="zh-CN">';
        $dialog_html .= '<script type="text/javascript" src="' . VIEW_PATH . 'tiku/js/jquery.js"></script>';
        $dialog_html .= '<div class="dialog_html">';
        $dialog_html .= '<style>';
        $dialog_html .= '*{ margin:0; padding:0; list-style:none; text-decoration:none; font-size:12px; font-family:"微软雅黑","Arial",sans-serif; border:none; -webkit-appearance: none; border-radius: 0;}';
        $dialog_html .= 'body{ width:100%; height:100%; overflow:hidden;}';
        $dialog_html .= 'div.dialog_bg{ width:100%; height:100%; position:fixed; top:0; left:0; background:#000; opacity:0.6; z-index:999;}';
        $dialog_html .= 'div.dialog_box{ width:340px; height:190px; position:fixed; top:50%; left:50%; background:#fff; z-index:1000; border: 5px solid rgba(0, 0, 0, 0.4); margin-left: -169px; margin-top: -93px;}';
        $dialog_html .= 'div.dialog_box p.title{ color:#fff; background:#77b3eb; padding:0px 0px 0px 10px; font-size:16px; height:40px; line-height:40px; width:330px; overflow:hidden;}';
        $dialog_html .= 'div.dialog_box p.content{ line-height:16px; text-align:center; margin:30px 10px 10px 10px; font-family:"宋体"; color:#333; font-size:14px; max-height:65px; overflow:hidden;}';
        $dialog_html .= 'div.dialog_box a.go_bt{ width: 60px; background: none repeat scroll 0 0 #f60; border-radius: 5px; color: #fff; font-family: "宋体"; font-size: 14px; margin: 20px auto 20px auto; display: block; padding: 5px 20px; text-align: center;}';
        $dialog_html .= 'div.dialog_box a.go_bt:hover{ opacity:0.8;}';
        $dialog_html .= 'div.dialog_box a.close{ position:absolute; top:7px; right:7px; color:#e5e5e5; font-size:16px; padding:3px;}';
        $dialog_html .= '</style>';
        $dialog_html .= '<div class="dialog_box">';
        $dialog_html .= '<p class="title">' . $title . '</p>';
        $dialog_html .= '<p class="content">' . $content . '</p>';
        $dialog_html .= '<a class="go_bt" href="' . $go_url . '">' . $bt_str . '</a>';
        $dialog_html .= '<a class="close" title="关闭" href="javascript:' . $close_back . '">X</a>';
        $dialog_html .= '</div>';
        $dialog_html .= '<div class="dialog_bg"></div>';
        $dialog_html .= '<script>';
        $dialog_html .= 'function close_it(){';
        $dialog_html .= '$("div.dialog_html").remove();';
        $dialog_html .= '}';
        $dialog_html .= '</script>';
        $dialog_html .= '</div>';
        $dialog_html .='</html>';
        echo $dialog_html;
        exit;
    }

    public function sms_window() {
        $sms_html = '';
        $sms_html .='<!DOCTYPE html>';
        $sms_html .='<html lang="zh-CN">';
        $sms_html .= '<script type="text/javascript" src="' . VIEW_PATH . 'tiku/js/jquery.js"></script>';
        $sms_html .='<style>';
        $sms_html .='*{ margin:0; padding:0; list-style:none; text-decoration:none; font-size:12px; font-family:"微软雅黑","Arial",sans-serif; border:none; -webkit-appearance: none; border-radius: 0;}';
        $sms_html .='div.phone_bg{ width:100%; height:100%; position:fixed; top:0; left:0; background:#000; opacity:0.8; z-index:999;}';
        $sms_html .='div.phone_box{ width:540px; height:270px; position:fixed; top:50%; left:50%; z-index:1000; margin-left: -280px; margin-top: -250px; background:url(' . VIEW_PATH . 'tiku/images/login_bg.png) no-repeat; border:1px solid #333; border-radius:10px;}';
        $sms_html .='div.phone_box div.clear{ clear:both; height:17px;}';
        $sms_html .='div.phone_box ul{ margin:100px 0 0 125px;}';
        $sms_html .='div.phone_box li{ margin:0px 0px 7px 0px; float:left;}';
        $sms_html .='div.phone_box input{ border:1px solid #d5d5d5; height:20px; line-height:20px; color:#999; width:175px; font-size:14px; padding:5px 10px 5px 10px; margin:0px 10px 0px 0px; float:left; border-radius:5px;}';
        $sms_html .='div.phone_box ul li.phone input{ width:265px;}';
        $sms_html .='div.phone_box ul li.code{ margin:0px 0px 2px 0px;}';
        $sms_html .='div.phone_box ul span.warning{ color:#ff6600; float:left; display:none;}';
        $sms_html .='div.phone_box ul li.code a{ color:#fff; background:#0099ff; width:80px; height:32px; line-height:32px; display:inline-block; float:left; text-align:center; border-radius:5px;}';
        $sms_html .='div.phone_box ul li.code a:hover{ background:#1a8eb2;}';
        $sms_html .='div.phone_box ul li input.sure{ color:#fff; background:#0099ff; width:290px; height:30px; line-height:28px; display:inline-block; float:left; text-align:center; margin:5px 0px 0px 0px; font-size:16px; border:none; padding:0; cursor:pointer;}';
        $sms_html .='div.phone_box ul li input.sure:hover{ background:#1a8eb2;}';
        $sms_html .='div.phone_box a.close_it{ position:absolute; display:block; width:32px; height:32px; background:url(' . VIEW_PATH . 'tiku/images/close.png) no-repeat; top:-15px; right:-15px;}';
        $sms_html .='</style>';
        $sms_html .='<body>';
        $sms_html .='<div class="phone_html">';
        $sms_html .='<div class="phone_box">';
        $sms_html .='<form action="/tiku/sms_login" method="post">';
        $sms_html .='<ul>';
        $sms_html .='<li class="phone"><input name="phone" class="phone" type="text" str="手机号" value="手机号" />';
        $sms_html .='<li class="code"><input name="code" class="code" type="text" str="验证码" value="验证码" /><a class="send_code" href="javascript:void(0);">发送验证码</a></li>';
        $sms_html .='<div class="clear">';
        $sms_html .='<span class="warning">*手机号码或验证码错误</span>';
        $sms_html .='</div>';
        $sms_html .='<li><input type="submit" class="sure" value="确定" /></li>';
        $sms_html .='</ul>';
        $sms_html .='</form>';
        $sms_html .='<a class="close_it" href="javascript:close_it();"></a>';
        $sms_html .='</div>';
        $sms_html .='<div class="phone_bg"></div>';
        $sms_html .='<script>';
        $sms_html .='$(\'div.phone_box input\').focus(function() {';
        $sms_html .='$(\'div.phone_box ul span.warning\').hide();';
        $sms_html .='if(!$(this).hasClass(\'sure\')){';
        $sms_html .='$(this).css(\'border-color\', "#3aa1ed");';
        $sms_html .='$(this).css(\'color\', "#333");';
        $sms_html .='}';
        $sms_html .='if ($(this).val() == $(this).attr(\'str\')) {';
        $sms_html .='$(this).val(\'\');';
        $sms_html .='};';
        $sms_html .='}).blur(function() {';
        $sms_html .='$(this).css(\'border-color\', "#d5d5d5");';
        $sms_html .='if ($(this).val() == "") {';
        $sms_html .='$(this).removeAttr(\'style\');';
        $sms_html .='$(this).val($(this).attr(\'str\'));';
        $sms_html .='};';
        $sms_html .='});';
        $sms_html .='$(\'a.send_code\').live(\'click\',function(){';
        $sms_html .='if($(this).html()==\'发送验证码\'){';
        $sms_html .='if(typeof(send_time)!="undefined"){';
        $sms_html .='clearInterval(send_time);	';
        $sms_html .='}';
        $sms_html .='var sCode = $(\'input.code\').attr(\'value\'); ';
        $sms_html .='var sMobile = $(\'input.phone\').attr(\'value\'); ';
        $sms_html .='if(!(/^1[0-9][0-9]\d{4,8}$/.test(sMobile)) || sCode == ""){';
        $sms_html .='$(\'div.phone_box ul span.warning\').html("*手机号错误");';
        $sms_html .='$(\'div.phone_box ul span.warning\').show();';
        $sms_html .='return false; ';
        $sms_html .='}else{';
        $sms_html .='$(\'div.phone_box ul li.phone span\').hide();';
        $sms_html .='$.get(\'/tiku/ajax_send_sms/\'+sMobile,function(data){';
        $sms_html .='if(data == 0){';
        $sms_html .='alert(\'发送失败！\');';
        $sms_html .='}else{';
        $sms_html .='$(\'a.send_code\').css(\'background\',\'#999\');';
        $sms_html .='$(\'a.send_code\').removeAttr(\'href\');';
        $sms_html .='$(\'a.send_code\').html(60);	';
        $sms_html .='var send_time = setInterval("cut_num()", 1000);';
        $sms_html .='if($(\'a.send_code\').html()==\'发送验证码\'){';
        $sms_html .='clearInterval(send_time);	';
        $sms_html .='}';
        $sms_html .='}';
        $sms_html .='})	';
        $sms_html .='}';
        $sms_html .='}';
        $sms_html .='});';
        $sms_html .='function cut_num(){';
        $sms_html .='var n = $(\'a.send_code\').html();';
        $sms_html .='n = parseInt(n);';
        $sms_html .='if(n>0){';
        $sms_html .='n--;';
        $sms_html .='$(\'a.send_code\').html(n);';
        $sms_html .='}else{';
        $sms_html .='$(\'a.send_code\').removeAttr(\'style\');';
        $sms_html .='$(\'a.send_code\').attr(\'href\',\'javascript:void(0);\');';
        $sms_html .='$(\'a.send_code\').html(\'发送验证码\');	';
        $sms_html .='}';
        $sms_html .='}';
        $sms_html .='function close_it() {';
        $sms_html .='window.location.href="/"';
        $sms_html .='}';
        $sms_html .='$(\'div.phone_box form\').submit(function(){';
	$sms_html .='var sCode = $(\'input.code\').attr(\'value\'); ';
	$sms_html .='var sMobile = $(\'input.phone\').attr(\'value\'); ';
	$sms_html .='if(!(/^1[0-9][0-9]\d{4,8}$/.test(sMobile)) ||!(/^\d{6}$/.test(sCode)) ){';
        $sms_html .='$(\'div.phone_box ul span.warning\').html("*手机号或验证码错误");';
	$sms_html .='$(\'div.phone_box ul span.warning\').show();';
	$sms_html .='return false; ';
	$sms_html .='}';
	$sms_html .='})';
        //$sms_html .='function close_it() {';
        //$sms_html .='$("div.phone_html").hide();';
        //$sms_html .='$(\'body\').css(\'overflow\', \'auto\');';
        //$sms_html .='}';
        $sms_html .='</script>';
        $sms_html .='</div>';
        $sms_html .='</body>';
        $sms_html .='</html>';
        echo $sms_html;
        exit;
    }

    /**
     * 在PHP 5.5.17 中测试通过。
     * 默认用通用接口(send)发送，若需使用模板接口(tpl_send),请自行将代码注释去掉。
     */
    //通用接口发送样例
    //模板接口样例（不推荐。需要测试请将注释去掉。)
    /* 以下代码块已被注释
      $apikey = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"; //请用自己的apikey代替
      $mobile = "xxxxxxxxxxx"; //请用自己的手机号代替
      $tpl_id = 1; //对应默认模板 【#company#】您的验证码是#code#
      $tpl_value = "#company#=云片网&#code#=1234";
      echo tpl_send_sms($apikey,$tpl_id, $tpl_value, $mobile);
     */

    /**
     * 通用接口发短信
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    function send_sms($text, $mobile) {
        $url = "http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode("$text");
        $apikey = "732be982abc9313b64561224601f70a3"; //请用自己的apikey代替
        $post_string = "apikey=$apikey&text=$encoded_text&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }

    /**
     * 模板接口发短信
     * apikey 为云片分配的apikey
     * tpl_id 为模板id
     * tpl_value 为模板值
     * mobile 为接受短信的手机号
     */
    function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile) {
        $url = "http://yunpian.com/v1/sms/tpl_send.json";
        $encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
        $post_string = "apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }

    /**
     * url 为服务的url地址
     * query 为请求串
     */
    function sock_post($url, $query) {
        $data = "";
        $info = parse_url($url);
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 30);
        if (!$fp) {
            return $data;
        }
        $head = "POST " . $info['path'] . " HTTP/1.0\r\n";
        $head.="Host: " . $info['host'] . "\r\n";
        $head.="Referer: http://" . $info['host'] . $info['path'] . "\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: " . strlen(trim($query)) . "\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write = fputs($fp, $head);
        $header = "";
        while ($str = trim(fgets($fp, 4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp, 4096);
        }
        return $data;
    }

}
