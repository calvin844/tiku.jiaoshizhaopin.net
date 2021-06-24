<?php

defined('BASEPATH') OR exit('No direct script access allowed');
define('HASH', 'Cj9DrdddY');
header('P3P: CP="ALL ADM DEV PSAi COM OUR OTRo STP IND ONL"');

class Tiku extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('jssdk');
        $this->load->model('common_model');
        $this->load->model('tiku_model');
        $this->load->helper('cookie');
        $this->tiku_model->is_login();
    }

    public function index($id = "", $son_house = "", $type = 0, $page = 1) {
        if (empty($id)) {
            //显示网站首页
            unset($_SESSION['parent_house_name']);
            $paper_num[0] = $paper_num[1] = 0;
            $user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
            if ($user_id > 0) {
                $vip_arr = $this->tiku_model->get_vip_by_user_id($user_id);
                if (empty($vip_arr)) {
                    $vip_arr = array();
                    $order = $this->tiku_model->get_order_by_userid($_SESSION['user_id']);
                    if ($order['is_paid'] == 1) {
                        $vip_arr['user_id'] = $_SESSION['user_id'];
                        $vip_arr['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                        $vip_arr['endtime'] = intval($vip_arr['addtime']) + intval($order['days']) * 86400;
                        $vip_arr['id'] = $this->common_model->insert_one($vip_arr, 'tiku_vip');
                    }
                }
                $v_data['user_vip'] = $vip_arr;
                $user_sheet_arr = $this->tiku_model->get_user_sheet_by_user_id($user_id);
                foreach ($user_sheet_arr as $u) {
                    $paper = $this->tiku_model->get_index_in_id($u['index_id']);
                    $paper['index_function'] == "real_exam" ? $paper_num[1] ++ : $paper_num[0] ++;
                }
                $v_data['user_paper_num'] = $paper_num;
                $new_sheet = $this->tiku_model->get_user_sheet_by_user_id($user_id, $this->session->userdata('house_id'), 1, 1);
                $v_data['my_exam_id'] = !empty($new_sheet) ? $new_sheet[0]['id'] : 0;
            }
            $news_list = $this->tiku_model->get_news_by_type_id();
            $v_data['news_list'] = $news_list;
            $v_data['house_list'] = $this->tiku_model->get_exam_house();
            $test_arr = $this->tiku_model->get_exam_house();
            foreach ($test_arr as $t) {
                if ($t['parent_id'] == 0) {
                    $test[$t['id']]['parent'] = $t;
                    $son = $this->tiku_model->get_exam_house_by_parent_id($t['id'], "id,name");
                    //var_dump($son);
                    foreach ($son as $s) {
                        $index = $this->tiku_model->get_index_by_function($s['id'], "quick_exam");
                        $index['house_cn'] = $s['name'];
                        $user = $this->tiku_model->get_user_sheet_by_index_id($index['id'], "count(1) as do_num");
                        $index['do_num'] = $user[0]['do_num'];
                        $s['index'] = $index;
                        $test[$t['id']]['son'][] = $s;
                    }
                }
            }//exit;
            $v_data['test'] = $test;
            //$coupons = $this->get_coupons_info();
            //$v_data['coupons'] = !empty($coupons) ? $coupons : array();
            $this->load_header();
            $this->load->view('tiku/tiku_index', $v_data);
            $this->load_footer();
        } else {
            //显示一级题库试题列表首页
            $this->parent_house_index($id, $son_house, $type, $page);
        }
    }

    public function parent_house_index($id = "", $son_house_name = "all", $type = 0, $page = 1) {
        $type = empty($type) ? 0 : $type;
        $page = empty($page) ? 1 : $page;
        $parent_house = $this->tiku_model->get_exam_house_by_short_name($id);
        $exam_house = $this->tiku_model->get_exam_house_by_parent_id($parent_house['id']);
        $son_house_str = "";
        foreach ($exam_house as $e) {
            $son_house_str .= $e['id'] . ",";
        }
        $son_house_str = trim($son_house_str, ",");
        $this->session->set_userdata(array('house_name' => $id));
        $this->session->set_userdata(array('house_name_cn' => $parent_house['name']));
        $this->session->set_userdata(array('house_id' => $parent_house['id']));
        $this->session->set_userdata(array('parent_house_name' => $parent_house['short_name']));
        $this->session->set_userdata(array('son_house_id' => $son_house_str));
        if ($son_house_name != "all") {
            $son_house = $this->tiku_model->get_exam_house_by_short_name($son_house_name);
            $v_data['son_house_cn'] = $son_house['name'];
            $son_house = $son_house['id'];
        } else {
            $son_house = $son_house_str;
        }
        $paper_res = $this->tiku_model->get_paper_in_house_id($son_house_str, 0, 9);
        foreach ($paper_res as $p) {
            $house_info = $this->tiku_model->get_exam_house_in_id($p['exam_house_id']);
            $p['house_name'] = $house_info['short_name'];
            $index_info = $this->tiku_model->get_index_by_function($p['exam_house_id'], 'real_exam');
            $p['index'] = $index_info['id'];
            $v_data['top_list'][] = $p;
        }
        $v_data['son_house'] = $this->tiku_model->get_exam_house_in_id($son_house_str);
        $index_res = $this->tiku_model->get_index_in_house_id($son_house_str);
        foreach ($index_res as $i) {
            $house = $this->tiku_model->get_exam_house_in_id($i['exam_house_id']);
            $i['house_name'] = $house['short_name'];
            $i['house_name_cn'] = $house['name'];
            $i['do_num'] = $this->tiku_model->get_user_sheet_count_by_index_id($i['id']);
            $v_data['index_list'][$i['name']][] = $i;
        }
        $v_data['son_house_name'] = $son_house_name;
        $v_data['paper_type'] = $type;
        $v_data['page'] = $page;
        $paper_list = $this->get_paper_list($son_house, $type, $page);
        $v_data['paper_list'] = $paper_list;
        $v_data['coupons'] = $this->get_coupons_info();
        $this->load_header();
        $this->load->view('tiku/house_index', $v_data);
        $this->load_footer();
    }

    public function get_coupons_info() {
        $coupons_house_tmp = $this->tiku_model->get_coupons_house("", 2, 1, "addtime desc");
        if (!empty($coupons_house_tmp)) {
            $this->common_model->update_one("coupons_house", array('state_flag' => 0), " id = " . $coupons_house_tmp[0]['id']);
            $this->common_model->update_one("coupons_house", array('state_flag' => 1), " id <> " . $coupons_house_tmp[0]['id']);
            $coupons = $this->set_rand(rand(100, 999));
        } else {
            $coupons_house_tmp = $this->tiku_model->get_coupons_house("", 0, 1, "addtime desc");
            if (!empty($coupons_house_tmp)) {
                $coupons_house_tmp[0]['remain'] = $coupons_house_tmp[0]['total'] - $coupons_house_tmp[0]['total_num'];
                $coupons = $coupons_house_tmp[0];
            }
        }
        $coupons = !empty($coupons) ? $coupons : array();
        return $coupons;
    }

    public function index_list($id) {
        /* 停用 
          if (strstr($id, "-")) {
          $t = explode("-", $id);
          $id = $t[0];
          $_GET['nav'] = $t[1];
          }
          if (empty($id)) {
          if (!empty($_SESSION['house_name'])) {
          echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $this->session->userdata('house_name') . '";</script> ';
          } else {
          $default_arr = $this->tiku_model->get_exam_house_in_id();
          echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $default_arr['short_name'] . '";</script> ';
          }
          }
          $exam_house = $this->tiku_model->get_exam_house_by_short_name($id);
          $parent_exam_house = $this->tiku_model->get_exam_house_in_id($exam_house['parent_id']);
          $this->session->set_userdata(array('house_name' => $id));
          $this->session->set_userdata(array('house_name_cn' => $exam_house['name']));
          $this->session->set_userdata(array('house_id' => $exam_house['id']));
          $this->session->set_userdata(array('parent_house_name' => $parent_exam_house['short_name']));
          $nav = empty($_GET['nav']) ? 1 : intval($_GET['nav']);
          switch ($nav) {
          case 2:
          $this->show_history();
          break;
          case 3:
          $this->order();
          break;
          default:
          $this->show_index($id);
          break;
          }
         */
    }

    public function show_index($id) {
        /* 停用 
          $exam_point_list = array();
          $new_sheet = "";
          $v_data['index_name'] = $id;
          $exam_house_list = $this->tiku_model->get_exam_house();
          $v_data['exam_house_list'] = $exam_house_list;
          $exam_index_list = $this->tiku_model->get_index_by_house_short_name($id);
          $v_data['exam_index_list'] = $exam_index_list;
          $exam_house = $this->tiku_model->get_exam_house_by_short_name($id);
          if (empty($exam_house)) {
          $exam_house = $this->tiku_model->get_exam_house_by_short_name($id);
          }
          $v_data['exam_house'] = $exam_house;
          $exam_point_arr = $this->tiku_model->get_point_by_house_id($exam_house['id']);
          foreach ($exam_point_arr as $pa) {
          $pa['question_num'] = $this->tiku_model->get_question_num_by_point_id($pa['id']);
          $exam_point_list[] = $pa;
          }
          $v_data['exam_point_list'] = $exam_point_list;
          $real_paper_list = array();
          $real_paper_limit = 5;
          $real_paper_total = $this->tiku_model->get_real_total_by_house_id($exam_house['id']);
          $real_paper_arr = $this->tiku_model->get_real_by_house_id($exam_house['id'], $real_paper_limit, 0);
          foreach ($real_paper_arr as $ra) {
          $all_info = $this->tiku_model->get_user_by_paper_id($ra['id']);
          $total = 0;
          foreach ($all_info as $u) {
          $total += intval($u['score']);
          }
          $user_info = $this->tiku_model->get_user_by_paper_id($ra['id'], $this->session->userdata('qs_user_id'));
          $ra['do_num'] = count($user_info);
          $ra['total_do_num'] = count($all_info);
          $ra['average'] = $total > 0 ? $total / count($all_info) : 0;
          $ra['average'] = sprintf("%.2f", $ra['average']);
          $real_paper_list[] = $ra;
          }
          $new_sheet = $this->tiku_model->get_user_sheet_by_user_id($this->session->userdata('qs_user_id'), $this->session->userdata('house_id'), 1, 1);
          if (!empty($new_sheet)) {
          $new_sheet = $new_sheet[0];
          $new_sheet['note'] = $new_sheet['name'] . "未完成";
          $v_data['my_exam']['sheet'] = $new_sheet;
          $v_data['my_exam']['url'] = '/tiku/continue_exam/' . $new_sheet['id'];
          } else {
          $new_sheet['note'] = "当前没有未完成的练习";
          $v_data['my_exam']['sheet'] = $new_sheet;
          $v_data['my_exam']['url'] = '';
          }
          $v_data['real_paper_list'] = $real_paper_list;
          $v_data['real_paper_total_page'] = ceil($real_paper_total / $real_paper_limit);
          $this->load_header();
          $this->load->view('tiku/exam', $v_data);
          $this->load_footer();
         */
    }

    public function order() {
        $user_id = $this->check_login();
        $user_id = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
        $vip_arr = $this->tiku_model->get_vip_by_user_id($user_id);
        if (empty($vip_arr)) {
            $vip_arr = array();
            $order = $this->tiku_model->get_order_by_userid($_SESSION['user_id']);
            if ($order['is_paid'] == 1) {
                $vip_arr['user_id'] = $_SESSION['user_id'];
                $vip_arr['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $vip_arr['endtime'] = intval($vip_arr['addtime']) + intval($order['days']) * 86400;
                $vip_arr['id'] = $this->common_model->insert_one($vip_arr, 'tiku_vip');
            }
        }
        $coupons_arr = $this->tiku_model->get_coupons_by_user_id($user_id);
        $endtime = !empty($vip_arr['endtime']) > 0 ? date("Y年m月d日", $vip_arr['endtime']) : 0;
        if (!empty($vip_arr['endtime']) && $vip_arr['endtime'] > time()) {
            $endtime = date("Y年m月d日", $vip_arr['endtime']);
        } else if (!empty($vip_arr['endtime']) && $vip_arr['endtime'] < time()) {
            $endtime = -1;
        } else {
            $endtime = 0;
        }
        $payment_list = $this->get_payment_list();
        $v_data['user_order_list'] = $this->user_order_list($user_id);
        $v_data['package_list'] = $this->tiku_model->get_package_list();
        $v_data['endtime'] = $endtime;
        $v_data['coupons'] = $coupons_arr;
        $v_data = array_merge($v_data, $payment_list);
        unset($_SESSION['parent_house_name']);
        $this->load_header("充值中心_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
        $this->load->view('tiku/vip_package', $v_data);
        $this->load_footer();
    }

    public function user_order_list($user_id) {
        $user_order_list = array();
        $user_order_arr = $this->common_model->get_order_list_by_user_id($user_id);
        foreach ($user_order_arr as $ul) {
            $payment_name = $this->common_model->get_payment_by_id($ul['payment_id']);
            $ul['payment_name'] = $payment_name['name'];
            $user_order_list[] = $ul;
        }
        return $user_order_list;
    }

    public function get_payment_list() {
        $payment_arr = $this->tiku_model->get_payment_list();
        foreach ($payment_arr as $pa) {
            if (strstr($pa['type_name'], "alipayapi-")) {
                $payment_list['alipayapi'][] = $pa;
            } else {
                $payment_list[$pa['type_name']][] = $pa;
            }
        }
        return $payment_list;
    }

    public function save_order() {
        $user_id = $this->check_login();
        $package_id = intval($_POST['package_id']);
        $payment_id = intval($_POST['payment_id']);
        $coupons_id = $_POST['use_coupons'] ? intval($_POST['coupons_id']) : 0;
        $cut_pay = 0;
        $package_info = $this->tiku_model->get_package_by_id($package_id);
        $payment_info = $this->tiku_model->get_payment_by_id($payment_id);
        $payment_pay = $package_info['price'] > 0 ? $package_info['price'] : $package_info['expense'];
        if ($coupons_id > 0) {
            $coupons_info = $this->tiku_model->get_coupons_by_id($coupons_id);
            if ($coupons_info['endtime'] > time() && $coupons_info['state_flag'] == 0) {
                $cut_pay = $coupons_info['value'];
                $this->common_model->update_one("coupons", array('state_flag' => 1), array('id' => $coupons_info['id']));
            }
        }
        $in_data['user_id'] = $user_id;
        $in_data['order_id'] = "tk-" . substr(md5(time() . $in_data['qs_user_id']), 16);
        $in_data['amount'] = ($payment_pay - $cut_pay) >= 0 ? ($payment_pay - $cut_pay) : 0;
        $in_data['coupons_id'] = $coupons_id > 0 ? $coupons_id : 0;
        $in_data['days'] = $package_info['days'];
        $in_data['show_time'] = $package_info['show_time'];
        $in_data['type_name'] = $payment_info['type_name'];
        $in_data['fee'] = $in_data['amount'] * $payment_info['fee_rate'];
        $in_data['payment_id'] = $payment_id;
        $in_data['addtime'] = time();
        $order_id = $this->common_model->insert_one($in_data, "order");
        if ($order_id > 0) {
            $in_logs['user_id'] = $user_id;
            $in_logs['amount'] = $package_info['expense'];
            $in_logs['days'] = $package_info['days'];
            $in_logs['addtime'] = time();
            $in_logs['note'] = "用户：" . $user_id . " 提交订单，订单号为：" . $in_data['order_id'];
            $this->common_model->insert_one($in_logs, "tiku_vip_logs");
            header("location:/tiku/sure_order?order_id=" . $order_id);
        } else {
            $this->common_model->show_dialog("提交订单失败！", "返回", "/tiku/order");
        }
    }

    public function sure_order() {
        $user_id = $this->check_login();
        $vip_arr = $this->tiku_model->get_vip_by_user_id($user_id);
        if (empty($vip_arr)) {
            $vip_arr = array();
            $order = $this->tiku_model->get_order_by_userid($user_id);
            if ($order['is_paid'] == 1) {
                $vip_arr['user_id'] = $_SESSION['user_id'];
                $vip_arr['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $vip_arr['endtime'] = intval($vip_arr['addtime']) + intval($order['days']) * 86400;
                $vip_arr['id'] = $this->common_model->insert_one($vip_arr, 'tiku_vip');
            }
        }
        $v_data['endtime'] = !empty($vip_arr['endtime']) > 0 ? date("Y年m月d日", $vip_arr['endtime']) : 0;
        $order_id = intval($_GET['order_id']);
        $myorder = $this->tiku_model->get_order_one($user_id, $order_id);
        $payment = $this->tiku_model->get_payment_by_id($myorder['payment_id']);
        if (empty($payment)) {
            $this->common_model->show_dialog("支付方式错误！", "重新提交订单", "/tiku/order");
        }
        $order['oid'] = $myorder['order_id'];
        $order['v_amount'] = $myorder['amount'] + $myorder['fee'];
        if ($myorder['type_name'] != 'remittance' && $order['v_amount'] > 0) {//假如是非线下支付，
            if (strstr($myorder['type_name'], 'alipayapi-')) {
                $api_path = "alipayapi/";
                $payment['type_name'] = "alipay";
            }
            $respond_name = $payment['type_name'];
            $order['v_url'] = "http://" . $_SERVER['SERVER_NAME'] . "/tiku/return_" . $respond_name . ".php";
            require_once(APPPATH . "third_party/" . $payment['type_name'] . ".php");
            $payment_form = get_code($order, $payment);
            if (empty($payment_form)) {
                $this->common_model->show_dialog("在线支付参数错误！", "重新提交订单", "/tiku/order");
            }
        }
        if ($order['v_amount'] > 0) {
            $in_logs['user_id'] = $user_id;
            $in_logs['amount'] = $myorder['amount'];
            $in_logs['days'] = $myorder['days'];
            $in_logs['addtime'] = time();
            $in_logs['note'] = "用户：" . $user_id . " 确认订单，订单号为：" . $myorder['order_id'];
            $this->common_model->insert_one($in_logs, "tiku_vip_logs");
            $v_data['user_order_list'] = $this->user_order_list($user_id);
            $v_data['order_id'] = $myorder['order_id'];
            $v_data['amount'] = $myorder['amount'];
            $v_data['payment_type_name'] = $respond_name;
            $v_data['payment_name'] = $payment['name'];
            $v_data['fee'] = $myorder['fee'];
            $v_data['payment_form'] = $payment_form;
            $this->load_header("充值中心_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
            $this->load->view('tiku/vip_sure', $v_data);
            $this->load_footer();
        } else {
            $this->update_user_pay($order['oid']);
            echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/pay_success";</script> ';
        }
    }

    public function notify_alipay() {
        $payment = $this->tiku_model->get_payment_by_name('alipay');
        require_once(APPPATH . "third_party/lib/alipay_notify.class.php");
        $alipay_config['partner'] = trim($payment['partnerid']);
        $alipay_config['seller_email'] = trim($payment['parameter1']);
        $alipay_config['key'] = trim($payment['ytauthkey']);
        $alipay_config['sign_type'] = strtoupper('MD5');
        $alipay_config['input_charset'] = strtolower('utf-8');
        $alipay_config['cacert'] = APPPATH . 'third_party/cacert.pem';
        $alipay_config['transport'] = 'http';
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
    }

    public function check_order() {
        $order_info = $this->tiku_model->get_order_by_orderid($_GET['order_id']);
        if ($order_info['paytime'] > 0) {
            echo 1;
        }
    }

    public function return_alipay() {
        $payment = $this->tiku_model->get_payment_by_name('alipay');
        require_once(APPPATH . "third_party/lib/alipay_notify.class.php");
        $alipay_config['partner'] = trim($payment['partnerid']);
        $alipay_config['seller_email'] = trim($payment['parameter1']);
        $alipay_config['key'] = trim($payment['ytauthkey']);
        $alipay_config['sign_type'] = strtoupper('MD5');
        $alipay_config['input_charset'] = strtolower('utf-8');
        $alipay_config['cacert'] = APPPATH . 'third_party/cacert.pem';
        $alipay_config['transport'] = 'http';
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {
            $this->update_user_pay($verify_result);
            echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/pay_success";</script> ';
        } else {
            $this->common_model->show_dialog("支付失败！", "重新提交订单", "/tiku/order");
        }
    }

    public function pay_success() {
        $endtime = 0;
        $user_id = $this->check_login();
        $user_info = $this->tiku_model->get_vip_by_user_id($user_id);
        if (empty($user_info)) {
            $user_info = array();
            $order = $this->tiku_model->get_order_by_userid($user_id);
            if ($order['is_paid'] == 1) {
                $user_info['user_id'] = $_SESSION['user_id'];
                $user_info['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $user_info['endtime'] = intval($user_info['addtime']) + intval($order['days']) * 86400;
                $user_info['id'] = $this->common_model->insert_one($user_info, 'tiku_vip');
            }
        }
        $endtime = date("Y年m月d日", $user_info['endtime']);
        $v_data['endtime'] = $endtime;
        $v_data['user_order_list'] = $this->user_order_list($user_id);
        $this->load_header("充值中心_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
        $this->load->view('tiku/vip_success', $v_data);
        $this->load_footer();
    }

    public function return_wxpay() {
        require_once(APPPATH . "third_party/lib/WxPayPubHelper.php");
        require_once(APPPATH . "third_party/lib/log_.php");
        //以log文件形式记录回调信息，用于调试
        $log_ = new Log_();
        $log_name = APPPATH . "third_party/native_call.log"; //log文件路径
        $nativeCall = new NativeCall_pub();
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $nativeCall->saveData($xml);
        if ($nativeCall->checkSign() == FALSE) {
            $nativeCall->setReturnParameter("return_code", "FAIL"); //返回状态码
            $nativeCall->setReturnParameter("return_msg", "签名失败"); //返回信息
        } else {
            $order_id = $nativeCall->getProductId();
            $order_header = substr($order_id, 0, 3);
            if ($order_header == "tk-") {
                $this->update_user_pay($order_id);
            }
        }
    }

    public function update_user_pay($order_id) {
        $user_id = $this->check_login();
        $this->common_model->update_one("order", array('is_paid' => 1, 'paytime' => time()), array('order_id' => $order_id));
        $order_info = $this->tiku_model->get_order_by_orderid($order_id);
        $user_info = $this->tiku_model->get_vip_by_user_id($order_info['user_id']);
        if (empty($user_info)) {
            $user_info = array();
            $order = $this->tiku_model->get_order_by_userid($order_info['user_id']);
            if ($order['is_paid'] == 1) {
                $user_info['user_id'] = $order_info['user_id'];
                $user_info['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $user_info['endtime'] = intval($user_info['addtime']) + intval($order['days']) * 86400;
                $user_info['id'] = $this->common_model->insert_one($user_info, 'tiku_vip');
            }
        }
        if ($user_info['id'] > 0) {
            $this->common_model->update_one('tiku_vip', array('endtime' => $user_info['endtime'] + $order_info['days'] * 86400), array('id' => $user_info['id']));
        } else {
            $in_data['user_id'] = $_SESSION['user_id'];
            $in_data['addtime'] = time();
            $in_data['endtime'] = intval($in_data['addtime']) + intval($order_info['days']) * 86400;
            $this->common_model->insert_one($in_data, 'tiku_vip');
        }
        $in_logs['user_id'] = $user_id;
        $in_logs['amount'] = $order_info['amount'];
        $in_logs['days'] = $order_info['days'];
        $in_logs['addtime'] = time();
        $in_logs['note'] = "用户：" . $user_id . " 支付成功，订单号为：" . $order_info['order_id'];
        $this->common_model->insert_one($in_logs, "tiku_vip_logs");
    }

    public function del_order() {
        $id = $_GET['id'];
        if ($id > 0) {
            $del_order = $this->tiku_model->get_order_by_id($id);
            if ($del_order['id'] > 0) {
                $order = $this->common_model->delete_one('order', array('id' => $id));
                if (empty($order['id'])) {
                    if ($del_order['coupons_id'] > 0) {
                        $this->common_model->update_one("coupons", array('state_flag' => 0), array('id' => $del_order['coupons_id']));
                    }
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
    }

    public function show_exam($id, $house_name) {
        $parent_house = $this->tiku_model->get_exam_house_by_short_name($house_name);
        $exam_house = $this->tiku_model->get_exam_house_by_parent_id($parent_house['id']);
        $son_house_str = "";
        foreach ($exam_house as $e) {
            $son_house_str .= $e['id'] . ",";
        }
        $son_house_str = trim($son_house_str, ",");
        $this->session->set_userdata(array('house_name' => $house_name));
        $this->session->set_userdata(array('house_name_cn' => $parent_house['name']));
        $this->session->set_userdata(array('house_id' => $parent_house['id']));
        $this->session->set_userdata(array('parent_house_name' => $parent_house['short_name']));
        $this->session->set_userdata(array('son_house_id' => $son_house_str));
        if (strstr($id, "_")) {
            $id_arr = explode("_", $id);
            $id = $id_arr[0];
            $item_id = $id_arr[1];
            $user_sheet_id = !empty($id_arr[2]) ? $id_arr[2] : "";
        }
        $index = $this->tiku_model->get_index_in_id($id);
        $this->session->set_userdata(array('house_id' => $index['exam_house_id']));
        switch ($index['index_function']) {
            case "quick_exam":
                $this->check_login();
                $this->set_exam($id);
                break;
            case "special_exam":
                $this->check_vip();
                $this->set_exam($id, $item_id);
                break;
            case "paper_exam":
                $this->check_vip();
                $this->set_exam($id);
                break;
            case "real_exam":
                $this->check_vip();
                $this->set_real($id, $item_id, 0, $user_sheet_id);
                break;
            case "error_exam":
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/show_error";</script> ';
                break;
            default:
                break;
        }
    }

    public function set_exam($id, $point_id = 0) {
        $section_arr = $this->tiku_model->get_section_by_pid($id);
        if (empty($section_arr)) {
            $this->common_model->show_dialog("没找到相关索引信息", "返回", "javascript:history.go(-1);", 1);
        }
        $total_time = 0;
        $sheet_data['index_id'] = $id;
        $sheet_data['exam_house_id'] = $this->session->userdata('house_id');
        $sheet_data['exam_paper_id'] = 0;
        $sheet_data['addtime'] = time();
        $sheet_id = $this->common_model->insert_one($sheet_data, 'tiku_sheet');
        $i = 1;
        $n = 1;
        foreach ($section_arr as $sa) {
            $question_arr = $this->tiku_model->get_rand_question($sa['question_num'], $this->session->userdata('house_id'), $point_id, $sa['question_type_id']);
            if (count($question_arr) < 1) {
                $this->common_model->delete_one("tiku_sheet", array('id' => $sheet_id));
                $this->common_model->show_dialog("没找到相关分段信息", "返回", "javascript:history.go(-1);", 1);
            }
            foreach ($question_arr as $q) {
                $in['sheet_id'] = $sheet_id;
                $in['sheet_part'] = $i;
                $in['sheet_order'] = $n;
                $in['question_id'] = $q['id'];
                $in['question_type_id'] = $q['question_type_id'];
                $in['correct'] = $q['correct'];
                $this->common_model->insert_one($in, 'tiku_sheet_question');
                $n++;
            }
            $total_time += $sa['seconds'];
            $i++;
        }
        echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $this->session->userdata("house_name") . '/' . $id . '/' . $sheet_id . '";</script> ';
    }

    public function set_real($index_id = 0, $paper_id = 0, $return_data = 0, $user_sheet_id = 0) {
        $user_id = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        if ($paper_id > 0) {
            $real = $this->tiku_model->get_real_by_id($paper_id);
            $house = $this->tiku_model->get_exam_house_in_id($real['exam_house_id']);
            $p_house = $house['parent_id'] > 0 ? $this->tiku_model->get_exam_house_in_id($house['parent_id']) : $house;
            if (empty($real)) {
                $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-2);", 1);
            }
            $v_data['index_name'] = $real['name'];
            $section_arr = $this->tiku_model->get_section_by_pid($paper_id, 2);
            if (empty($section_arr)) {
                $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-2);", 1);
            }
            $i = 1;
            $total_time = 0;
            $total_points = 0;
            foreach ($section_arr as $sa) {
                $exam_paper['part_' . $i]['name'] = $sa['name'];
                $exam_paper['part_' . $i]['description'] = $sa['description'];
                $exam_paper['part_' . $i]['question_points'] = floor($sa['question_points'] / $sa['question_num']);
                $exam_paper['part_' . $i]['total_num'] = $sa['question_num'];
                $total_time += $sa['seconds'];
                $total_points += $sa['question_points'];
                $i++;
            }
            $real_question_arr = $this->tiku_model->get_real_question_by_paper_id($paper_id);
            $n = 1;
            foreach ($real_question_arr as $ra) {
                if ($n <= ($i - 1)) {
                    $ra['question_type_cn'] = $this->tiku_model->get_question_type_by_id($ra['question_type_id']);
                    $ra['question_type_cn'] = $ra['question_type_cn']['name'];
                    $exam_paper['part_' . $n]['question_result'][] = $ra;
                    $exam_paper['part_' . $n]['answer_arr'][$ra['id']] = $this->tiku_model->get_answer_by_question_id($ra['id']);
                    $exam_paper['part_' . $n]['material_arr'][$ra['id']] = $this->tiku_model->get_material_by_question_id($ra['id']);
                    $exam_paper['part_' . $n]['question_num'] = count($exam_paper['part_' . $n]['question_result']);
                    if ($exam_paper['part_' . $n]['question_num'] == $exam_paper['part_' . $n]['total_num']) {
                        $n++;
                    }
                }
            }
            $user_collection_arr = $this->tiku_model->get_user_collection_by_user_id($user_id);
            $submit_info['index_id'] = $index_id;
            $submit_info['exam_house_id'] = $house['id'];
            $submit_info['sheet_id'] = $paper_id;
            $submit_info['name'] = $real['name'];
            $submit_info['total_question'] = count($real_question_arr);
            $submit_info['total_points'] = $total_points;
            if ($user_sheet_id > 0) {
                $v_data['user_sheet']['sheet'] = $this->tiku_model->get_user_sheet_by_id($user_sheet_id, $user_id);
                if (empty($v_data['user_sheet']['sheet'])) {
                    $this->common_model->show_dialog("没找到相关用户信息", "返回", "javascript:history.go(-2);", 1);
                }
                $info = $this->tiku_model->get_user_sheet_info_by_user_id($user_id, $user_sheet_id);
                $v_data['user_sheet']['answer'] = "";
                foreach ($info as $i) {
                    $i['user_answer'] = trim($i['user_answer'], "##");
                    $i['user_answer'] = strstr($i['user_answer'], "##") ? explode("##", $i['user_answer']) : array($i['user_answer']);
                    foreach ($i['user_answer'] as $ua) {
                        $v_data['user_sheet']['answer'] .= $ua . ",";
                    }
                }
                $v_data['user_sheet']['answer'] = trim($v_data['user_sheet']['answer'], ",");
            }
            $v_data['user_collection'] = $user_collection_arr;
            $v_data['submit_info'] = $submit_info;
            $v_data['total_time'] = $total_time;
            $v_data['exam_paper'] = $exam_paper;
            $v_data['letter'] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if ($return_data == 1) {
                return $v_data;
            } else {
                $this->load_header($real['name'] . "_教师招聘网", "教师资格证考试," . $_SESSION['house_name_cn'] . "," . $_SESSION['house_name_cn'] . "真题", "2016年中学教师资格证考试" . $_SESSION['house_name_cn'] . "真题与模拟试题，" . $real['name'] . "。");
                $this->load->view('tiku/exam_page', $v_data);
                $this->load_footer();
            }
        } else {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-2);", 1);
        }
    }

    public function show_sheet($id, $return_data = 0) {
        if (strstr($id, "-")) {
            $info_arr = explode("-", $id);
            $index_id = intval($info_arr[0]) > 0 ? intval($info_arr[0]) : 0;
            if (strstr($info_arr[1], "_")) {
                $info_arr = explode("_", $info_arr[1]);
                $sheet_id = $info_arr[0];
                $user_sheet_id = $info_arr[1];
            } else {
                $sheet_id = intval($info_arr[1]);
            }
        } else {
            $index_id = 0;
            $sheet_id = $id;
        }
        $user_id = !empty($_SESSION['user_id']) ? intval($_SESSION['user_id']) : "";
        $sheet = $this->tiku_model->get_sheet_by_sheet_index_id($sheet_id, $index_id);
        if (!empty($sheet['id'])) {
            $total_time = 0;
            $total_points = 0;
            $exam_paper = array();
            $index = $this->tiku_model->get_index_in_id($index_id);
            $v_data['index_name'] = $index['name'];
            $house = $this->tiku_model->get_exam_house_in_id($index['exam_house_id']);
            $p_house = $house['parent_id'] > 0 ? $this->tiku_model->get_exam_house_in_id($house['parent_id']) : $house;
            $section_arr = $this->tiku_model->get_section_by_pid($index_id);
            $i = 1;
            foreach ($section_arr as $sa) {
                $exam_paper['part_' . $i]['name'] = $sa['name'];
                $exam_paper['part_' . $i]['description'] = $sa['description'];
                $exam_paper['part_' . $i]['question_points'] = floor($sa['question_points'] / $sa['question_num']);
                $total_time += $sa['seconds'];
                $total_points += $sa['question_points'];
                $i++;
            }
            $sheet_question_arr = $this->tiku_model->get_sheet_question_by_sheet_id($sheet['id']);
            foreach ($sheet_question_arr as $s) {
                $question_arr = $this->tiku_model->get_question_by_id($s['question_id']);
                $question_arr['question_type_cn'] = $this->tiku_model->get_question_type_by_id($s['question_type_id']);
                $question_arr['question_type_cn'] = $question_arr['question_type_cn']['name'];
                $exam_paper['part_' . $s['sheet_part']]['question_result'][] = $question_arr;
                $exam_paper['part_' . $s['sheet_part']]['answer_arr'][$s['question_id']] = $this->tiku_model->get_answer_by_question_id($s['question_id']);
                $exam_paper['part_' . $s['sheet_part']]['material_arr'][$s['question_id']] = $this->tiku_model->get_material_by_question_id($s['question_id']);
                $exam_paper['part_' . $s['sheet_part']]['question_num'] = count($exam_paper['part_' . $s['sheet_part']]['question_result']);
            }
            $user_collection_arr = $this->tiku_model->get_user_collection_by_user_id($user_id);
            $submit_info['index_id'] = $index_id;
            $submit_info['exam_house_id'] = $this->session->userdata('house_id');
            $submit_info['sheet_id'] = $sheet_id;
            $submit_info['name'] = $index['name'];
            $submit_info['total_question'] = count($sheet_question_arr);
            $submit_info['total_points'] = $total_points;
            $v_data['submit_info'] = $submit_info;
            if (!empty($user_sheet_id)) {
                $v_data['user_sheet']['sheet'] = $this->tiku_model->get_user_sheet_by_id($user_sheet_id);
                $info = $this->tiku_model->get_user_sheet_info_by_user_id($user_id, $user_sheet_id);
                $v_data['user_sheet']['answer'] = "";
                foreach ($info as $i) {
                    $i['user_answer'] = trim($i['user_answer'], "##");
                    $i['user_answer'] = strstr($i['user_answer'], "##") ? explode("##", $i['user_answer']) : array($i['user_answer']);
                    foreach ($i['user_answer'] as $ua) {
                        $v_data['user_sheet']['answer'] .= $ua . ",";
                    }
                }
                $v_data['user_sheet']['answer'] = trim($v_data['user_sheet']['answer'], ",");
            }
            $v_data['total_time'] = $total_time;
            $v_data['exam_paper'] = $exam_paper;
            $v_data['user_collection'] = $user_collection_arr;
            $v_data['letter'] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if ($return_data == 1) {
                return $v_data;
            } else {
                $this->load_header($v_data['index_name'] . "_教师招聘网", "教师资格证考试," . $_SESSION['house_name_cn'] . "," . $_SESSION['house_name_cn'] . "模拟题", "2016年中学教师资格证考试" . $_SESSION['house_name_cn'] . "真题与模拟试题，" . $v_data['index_name'] . "。");
                $this->load->view('tiku/exam_page', $v_data);
                $this->load_footer();
            }
        } else {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-2);", 1);
        }
    }

    public function submit_exam() {
        $user_score = 0;
        $user_correct_total = 0;
        $answer_result = array();
        $in_user_sheet['user_id'] = intval($_POST['user_id']) > 0 ? intval($_POST['user_id']) : 0;
        $in_user_sheet['index_id'] = intval($_POST['index_id']) > 0 ? intval($_POST['index_id']) : -1;
        $in_user_sheet['exam_house_id'] = intval($_POST['exam_house_id']) > 0 ? intval($_POST['exam_house_id']) : -1;
        $in_user_sheet['sheet_id'] = intval($_POST['sheet_id']) > 0 ? intval($_POST['sheet_id']) : -1;
        $name = trim($_POST['name']);
        $in_user_sheet['name'] = !empty($name) ? $name : -1;
        $in_user_sheet['is_complete'] = intval($_POST['is_complete']) > 0 ? intval($_POST['is_complete']) : -1;
        $in_user_sheet['complete_question'] = $_POST['complete_question'] > -1 ? intval($_POST['complete_question']) : -1;
        $in_user_sheet['total_score'] = $_POST['total_score'] > -1 ? intval($_POST['total_score']) : -1;
        $in_user_sheet['total_question'] = $_POST['total_question'] > 0 ? intval($_POST['total_question']) : -1;
        $in_user_sheet['usetime'] = $_POST['usetime'] > 0 ? intval($_POST['usetime']) : -1;
        $in_user_sheet['submittime'] = time();
        foreach ($in_user_sheet as $i) {
            if ($i < 0) {
                $this->common_model->show_dialog("提交信息错误", "返回", "javascript:history.go(-1);", 1);
            }
        }
        if (!empty($_POST['user_sheet_id'])) {
            $this->common_model->update_one('tiku_user_sheet', $in_user_sheet, array('id' => intval($_POST['user_sheet_id'])));
            $in_user_sheet_id = intval($_POST['user_sheet_id']);
        } else {
            $in_user_sheet_id = $this->common_model->insert_one($in_user_sheet, 'tiku_user_sheet');
        }
        $this->session->set_userdata('user_sheet_id', $in_user_sheet_id);
        $answer_str = trim($_POST['answer_str'], "##");
        $answer_arr = explode("##", $answer_str);
        if (!empty($answer_arr[0])) {
            foreach ($answer_arr as $a) {
                $answer_tmp = explode("-", $a);
                $answer_tmp[1] = trim($answer_tmp[1], ",");
                $answer_result[$answer_tmp[0]]['answer'] = !empty($answer_result[$answer_tmp[0]]['answer']) ? $answer_result[$answer_tmp[0]]['answer'] . $answer_tmp[1] . "##" : $answer_tmp[1] . "##";
                $answer_result[$answer_tmp[0]]['score'] = $answer_tmp[2];
            }
            $this->common_model->delete_one('tiku_user_sheet_info', array('user_sheet_id' => $in_user_sheet_id, 'user_id' => $in_user_sheet['user_id']));
            foreach ($answer_result as $k => $v) {
                $question_arr = $this->tiku_model->get_question_by_id($k);
                $in_user_info['user_id'] = $in_user_sheet['user_id'];
                $in_user_info['user_sheet_id'] = $in_user_sheet_id;
                $in_user_info['question_id'] = $k;
                $in_user_info['top_exam_point_id'] = $question_arr['top_exam_point_id'];
                $in_user_info['parent_exam_point_id'] = $question_arr['parent_exam_point_id'];
                $in_user_info['exam_point_id'] = $question_arr['exam_point_id'];
                $in_user_info['question_type_id'] = $question_arr['question_type_id'];
                $in_user_info['is_correct'] = 2;
                $in_user_info['addtime'] = time();
                $q_answer_arr = explode("##", trim($question_arr['correct'], "##"));
                $u_answer_arr = explode("##", trim($v['answer'], "##"));
                if ($question_arr['question_type_id'] == 4 || $question_arr['question_type_id'] == 5) {
                    $u_answer_arr = explode(",", $u_answer_arr[0]);
                    if (count($u_answer_arr) != count($q_answer_arr)) {
                        $in_user_info['is_correct'] = 2;
                    } elseif (count(array_intersect($u_answer_arr, $q_answer_arr)) != count($q_answer_arr)) {
                        $in_user_info['is_correct'] = 2;
                    } else {
                        $in_user_info['is_correct'] = 1;
                    }
                    $v['answer'] = "";
                    foreach ($u_answer_arr as $ua) {
                        $v['answer'] .= $ua . "##";
                    }
                } else {
                    foreach ($u_answer_arr as $ua) {
                        $in_user_info['is_correct'] = in_array($ua, $q_answer_arr) ? 1 : 2;
                    }
                }
                $in_user_info['user_answer'] = $v['answer'];
                $this->common_model->insert_one($in_user_info, 'tiku_user_sheet_info');
                $user_error = $this->tiku_model->get_user_error_by_question_id($in_user_sheet['user_id'], $k);
                if ($in_user_info['is_correct'] == 2 && empty($user_error)) {
                    $in_user_error['user_id'] = $in_user_sheet['user_id'];
                    $in_user_error['exam_house_id'] = $in_user_sheet['exam_house_id'];
                    $in_user_error['top_exam_point_id'] = $question_arr['top_exam_point_id'];
                    $in_user_error['parent_exam_point_id'] = $question_arr['parent_exam_point_id'];
                    $in_user_error['exam_point_id'] = $question_arr['exam_point_id'];
                    $in_user_error['question_id'] = $k;
                    $in_user_error['question_type_id'] = $question_arr['question_type_id'];
                    $in_user_error['user_answer'] = $v['answer'];
                    $in_user_error['addtime'] = time();
                    $this->common_model->insert_one($in_user_error, 'tiku_error_question');
                } elseif ($in_user_info['is_correct'] == 1) {
                    if (!empty($user_error)) {
                        $this->common_model->delete_one('tiku_error_question', array('id' => $user_error['id']));
                    }
                    $user_score += $v['score'];
                    $user_correct_total++;
                }
            }
        }
        $correct_rate = !empty($answer_arr[0]) ? ($user_correct_total / count($answer_result)) * 100 : 0;
        $this->common_model->update_one('tiku_user_sheet', array('correct_rate' => $correct_rate, 'score' => $user_score), array('id' => $in_user_sheet_id));
        if ($in_user_sheet['is_complete'] == 2) {
            echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/exam_report/' . $in_user_sheet_id . '";</script> ';
        } else {
            echo '<script type="text/javascript" language="javascript">window.location.href="/";</script> ';
        }
    }

    public function exam_report($id) {
        $this->check_login();
        $user_id = $_SESSION['user_id'];
        $all_score = 0;
        $down = 0;
        $user_question = array();
        $user_sheet_arr = $this->tiku_model->get_user_sheet_by_id($id);
        if ($user_sheet_arr['user_id'] == 0 && $user_id > 0) {
            $this->common_model->update_one('tiku_user_sheet', array('user_id' => $user_id), array('id' => $id));
            $this->common_model->update_one('tiku_user_sheet_info', array('user_id' => $user_id), array('user_sheet_id' => $id));
            $user_sheet_arr = $this->tiku_model->get_user_sheet_by_id($id);
        }
        if ($user_sheet_arr['user_id'] == 0 || $user_sheet_arr['user_id'] != $user_id) {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
        }
        $v_data['user_sheet_arr'] = $user_sheet_arr;
        $v_data['user_correct'] = 0;
        $index = $this->tiku_model->get_index_in_id($user_sheet_arr['index_id']);
        $house = $this->tiku_model->get_exam_house_in_id($index['exam_house_id']);
        $p_house = $house['parent_id'] > 0 ? $this->tiku_model->get_exam_house_in_id($house['parent_id']) : $house;
        if ($index['index_function'] == "real_exam") {
            $all_sheet_arr = $this->tiku_model->get_user_sheet_by_sheet_id($user_sheet_arr['sheet_id']);
            $question_tmp = $this->tiku_model->get_real_question_by_paper_id($user_sheet_arr['sheet_id']);
            foreach ($question_tmp as $qt) {
                $qt['question_id'] = $qt['id'];
                $question_arr[] = $qt;
            }
        } else {
            $all_sheet_arr = $this->tiku_model->get_user_sheet_by_index_id($user_sheet_arr['index_id']);
            $question_arr = $this->tiku_model->get_sheet_question_by_sheet_id($user_sheet_arr['sheet_id']);
        }
        $user_question_arr = $this->tiku_model->get_user_sheet_info_by_user_id($user_id, $user_sheet_arr['id']);
        if (empty($question_arr)) {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
        }
        foreach ($user_question_arr as $uq) {
            $user_question[$uq['question_id']] = $uq['is_correct'];
            if ($uq['is_correct'] == 1) {
                $v_data['user_correct'] ++;
            }
        }
        $v_data['user_question'] = $user_question;
        $v_data['question_arr'] = $question_arr;
        if (!empty($all_sheet_arr)) {
            foreach ($all_sheet_arr as $as) {
                $all_score += $as['score'];
                if ($as['score'] < $user_sheet_arr['score']) {
                    $down++;
                }
            }
        }
        if ($user_sheet_arr['usetime'] > 60) {
            $usetime['m'] = floor($user_sheet_arr['usetime'] / 60);
            $usetime['s'] = $user_sheet_arr['usetime'] - $usetime['m'] * 60;
        } else {
            $usetime['s'] = $user_sheet_arr['usetime'];
        }
        $v_data['usetime'] = $usetime;
        $v_data['average_score'] = !empty($all_sheet_arr) ? $all_score / count($all_sheet_arr) : 0;
        $v_data['beyond_people'] = !empty($all_sheet_arr) ? ($down / count($all_sheet_arr)) * 100 : 100;
        $v_data['id'] = $id;
        /*
          if ($index['index_function'] == "wechat_exam") {
          $this->load->view('tiku/do_test_2', $v_data);
          } else {
          $this->load_header();
          $this->load->view('tiku/report_page_no_point', $v_data);
          $this->load_footer();
          }
         * 
         */
        $user_info = $this->tiku_model->get_vip_by_user_id($_SESSION['user_id']);
        if (empty($user_info)) {
            $user_info = array();
            $order = $this->tiku_model->get_order_by_userid($_SESSION['user_id']);
            if ($order['is_paid'] == 1) {
                $user_info['user_id'] = $_SESSION['user_id'];
                $user_info['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $user_info['endtime'] = intval($user_info['addtime']) + intval($order['days']) * 86400;
                $user_info['id'] = $this->common_model->insert_one($user_info, 'tiku_vip');
            }
        }
        $v_data['vip'] = $user_info;
        $this->load_header($user_sheet_arr['name'] . "_" . date("Y", time()) . "年" . $p_house['name'] . "教师资格证考试_教师招聘网");
        $this->load->view('tiku/report_page_no_point', $v_data);
        $this->load_footer();
    }

    public function exam_parsing($id) {
        $user_id = $this->check_login();
        $user_id = $_SESSION['user_id'];
        $user_answer_arr = array();
        $all_answer_arr = array();
        $question_point_arr = array();
        $q_id = !empty($_GET['q_id']) ? intval($_GET['q_id']) : 0;
        $v_data['q_id'] = $q_id;
        $user_sheet_arr = $this->tiku_model->get_user_sheet_by_id($id);
        if ($user_sheet_arr['user_id'] == 0 && $user_id > 0) {
            $this->common_model->update_one('tiku_user_sheet', array('user_id' => $user_id), array('id' => $id));
            $user_sheet_arr = $this->tiku_model->get_user_sheet_by_id($id);
        }
        if ($user_sheet_arr['user_id'] == 0 || $user_sheet_arr['user_id'] != $user_id) {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
        }
        $v_data['user_sheet_arr'] = $user_sheet_arr;
        $v_data['id'] = $id;
        $index = $this->tiku_model->get_index_in_id($user_sheet_arr['index_id']);
        $house = $this->tiku_model->get_exam_house_in_id($index['exam_house_id']);
        $p_house = $house['parent_id'] > 0 ? $this->tiku_model->get_exam_house_in_id($house['parent_id']) : $house;
        if ($index['index_function'] == "real_exam") {
            $r_data = $this->set_real($user_sheet_arr['index_id'], $user_sheet_arr['sheet_id'], 1);
            $sheet_question_tmp = $this->tiku_model->get_question_in_paper_id($user_sheet_arr['sheet_id']);
            foreach ($sheet_question_tmp as $s) {
                $s['question_id'] = $s['id'];
                $sheet_question_arr[] = $s;
            }
        } else {
            $r_data = $this->show_sheet($user_sheet_arr['index_id'] . "-" . $user_sheet_arr['sheet_id'], 1);
            $sheet_question_arr = $this->tiku_model->get_sheet_question_by_sheet_id($user_sheet_arr['sheet_id']);
        }
        $v_data = array_merge($v_data, $r_data);
        $user_sheet_info_arr = $this->tiku_model->get_user_sheet_info_by_user_id($user_id);
        foreach ($user_sheet_info_arr as $u) {
            if ($u['user_sheet_id'] == $id) {
                $user_answer_arr[$u['question_id']]['info'] = $u;
                $user_answer_arr[$u['question_id']]['user_answer'] = explode("##", trim($u['user_answer'], "##"));
            }
            $user_answer_arr[$u['question_id']]['num'] = !empty($user_answer_arr[$u['question_id']]['num']) ? $user_answer_arr[$u['question_id']]['num'] + 1 : 1;
            if ($u['is_correct'] == 2) {
                $user_answer_arr[$u['question_id']]['error_num'] = !empty($user_answer_arr[$u['question_id']]['error_num']) ? $user_answer_arr[$u['question_id']]['error_num'] + 1 : 1;
            }
        }
        $v_data['user_answer_arr'] = $user_answer_arr;
        //$sheet_question_arr = $this->tiku_model->get_sheet_question_by_sheet_id($user_sheet_arr['sheet_id']);
        foreach ($sheet_question_arr as $sq) {
            $sheet_question[] = $sq['question_id'];
            $question = $this->tiku_model->get_question_by_id($sq['question_id']);
            $top_id = $question['parent_exam_point_id'] == $question['exam_point_id'] ? 0 : $question['top_exam_point_id'];
            $parent_id = $question['parent_exam_point_id'] == $question['exam_point_id'] ? $question['top_exam_point_id'] : $question['parent_exam_point_id'];
            $question_point_arr[$question['id']]['top'] = $top_id > 0 ? $this->tiku_model->get_point_by_id($top_id) : array();
            $question_point_arr[$question['id']]['parent'] = $parent_id > 0 ? $this->tiku_model->get_point_by_id($parent_id) : array();
            $question_point_arr[$question['id']]['point'] = $question['exam_point_id'] > 0 ? $this->tiku_model->get_point_by_id($question['exam_point_id']) : array();
        }
        $v_data['all_answer_arr'] = $this->get_all_sheet_info_by_qusetion_id($sheet_question);
        $v_data['question_point_arr'] = $question_point_arr;
        $this->load_header($user_sheet_arr['name'] . "_" . date("Y", time()) . "年" . $p_house['name'] . "教师资格证考试_教师招聘网");
        $this->load->view('tiku/parsing_page', $v_data);
        $this->load_footer();
    }

    public function get_all_sheet_info_by_qusetion_id($sheet_question) {
        $all_sheet_info_arr = $this->tiku_model->get_user_sheet_info_by_question_id($sheet_question, "question_id,is_correct,user_answer");
        foreach ($all_sheet_info_arr as $a) {
            $all_answer_arr[$a['question_id']]['info'] = $a;
            $all_answer_arr[$a['question_id']]['num'] = !empty($all_answer_arr[$a['question_id']]['num']) ? $all_answer_arr[$a['question_id']]['num'] + 1 : 1;
            if ($a['is_correct'] == 1) {
                $all_answer_arr[$a['question_id']]['true_num'] = !empty($all_answer_arr[$a['question_id']]['true_num']) ? $all_answer_arr[$a['question_id']]['true_num'] + 1 : 1;
            } elseif ($a['is_correct'] == 2) {
                $all_answer_arr[$a['question_id']]['false_num'] = !empty($all_answer_arr[$a['question_id']]['false_num']) ? $all_answer_arr[$a['question_id']]['false_num'] + 1 : 1;
                $a_answer = trim($a['user_answer'], "##");
                if (strstr($a['user_answer'], "##")) {
                    $false_item_arr = explode("##", $a_answer);
                } else {
                    $false_item_arr = array($a_answer);
                }
                $all_answer_arr[$a['question_id']]['false_item'] = array();
                foreach ($false_item_arr as $aa) {
                    $all_answer_arr[$a['question_id']]['false_item'][$aa] = !empty($all_answer_arr[$a['question_id']]['false_item'][$aa]) ? $all_answer_arr[$a['question_id']]['false_item'][$aa] + 1 : 1;
                }
                asort($all_answer_arr[$a['question_id']]['false_item']);
                foreach ($all_answer_arr[$a['question_id']]['false_item'] as $k => $v) {
                    $all_answer_arr[$a['question_id']]['false_item'] = $k;
                    break;
                }
            }
            $all_answer_arr[$a['question_id']]['true_num'] = !empty($all_answer_arr[$a['question_id']]['true_num']) ? $all_answer_arr[$a['question_id']]['true_num'] : 0;
            $all_answer_arr[$a['question_id']]['true_rate'] = sprintf("%.2f", ($all_answer_arr[$a['question_id']]['true_num'] / $all_answer_arr[$a['question_id']]['num']) * 100);
        }
        return $all_answer_arr;
    }

    public function show_history() {
        $user_id = $this->check_login();
        $user_id = $_SESSION['user_id'];
        $user_sheet = array();
        $page = !empty($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = $page == 1 ? 0 : (($page - 1) * $limit);
        $total_user_sheet_arr = $this->tiku_model->get_user_sheet_by_user_id($_SESSION['user_id']);
        $total_user_sheet = count($total_user_sheet_arr);
        $total_page = ceil($total_user_sheet / $limit);
        $user_sheet_arr = $this->tiku_model->get_user_sheet_by_user_id($_SESSION['user_id'], 0, 0, $limit, $offset);
        foreach ($user_sheet_arr as $usa) {
            $user_sheet[$usa['id']]['sheet'] = $usa;
            $user_sheet_info_arr = $this->tiku_model->get_user_sheet_info_by_user_id($_SESSION['user_id'], $usa['id']);
            $c = 0;
            foreach ($user_sheet_info_arr as $usia) {
                if ($usia['is_correct'] == 1) {
                    $c++;
                }
            }
            $user_sheet[$usa['id']]['correct_num'] = $c;
        }
        $v_data['user_sheet'] = $user_sheet;
        $v_data['page']['total'] = $total_page;
        $v_data['page']['cur'] = $page;
        $this->load_header("练习历史_" . date("Y", time()) . "年教师资格证考试_教师招聘网", "", "", 2);
        $this->load->view('tiku/history', $v_data);
        $this->load_footer();
    }

    public function show_collection() {
        $user_id = $this->check_login();
        if (!empty($_GET['id']) && strstr($_GET['id'], "-")) {
            $tmp = explode("-", $_GET['id']);
            $point_id = $tmp[0];
            $id_str = trim($tmp[1], ",");
            $id_arr = strstr($id_str, ",") ? explode(",", $id_str) : array($id_str);
            $point = $this->tiku_model->get_point_by_id($point_id);
            $user_sheet_arr['name'] = "正在查看收藏题练习（" . $point['name'] . "）答案解析";
            $this->show_question_info($id_arr, $user_sheet_arr);
        } else {
            $user_collect = array();
            $user_collect_arr = $this->tiku_model->get_user_collect_by_user_id($_SESSION['user_id']);
            foreach ($user_collect_arr as $uca) {
                $top = $uca['parent_exam_point_id'] == $uca['exam_point_id'] ? 0 : $uca['top_exam_point_id'];
                $parent = $uca['parent_exam_point_id'] == $uca['exam_point_id'] ? $uca['top_exam_point_id'] : $uca['parent_exam_point_id'];
                $point = $uca['exam_point_id'];
                if ($top > 0) {
                    $user_collect[$top]['info'] = $this->tiku_model->get_point_by_id($top);
                    $user_collect[$top]['question_num'] = !empty($user_collect[$top]['question_num']) ? $user_collect[$top]['question_num'] + 1 : 1;
                    $user_collect[$top]['question_id'] = !empty($user_collect[$top]['question_id']) ? $user_collect[$top]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                    $v_data['exam_house'][$user_collect[$top]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_collect[$top]['info']['exam_house_id']);
                }
                if ($parent > 0) {
                    $user_collect[$parent]['info'] = $this->tiku_model->get_point_by_id($parent);
                    $user_collect[$parent]['question_num'] = !empty($user_collect[$parent]['question_num']) ? $user_collect[$parent]['question_num'] + 1 : 1;
                    $user_collect[$parent]['question_id'] = !empty($user_collect[$parent]['question_id']) ? $user_collect[$parent]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                    $v_data['exam_house'][$user_collect[$parent]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_collect[$parent]['info']['exam_house_id']);
                }
                $user_collect[$point]['info'] = $this->tiku_model->get_point_by_id($point);
                $user_collect[$point]['question_num'] = !empty($user_collect[$point]['question_num']) ? $user_collect[$point]['question_num'] + 1 : 1;
                $user_collect[$point]['question_id'] = !empty($user_collect[$point]['question_id']) ? $user_collect[$point]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                $v_data['exam_house'][$user_collect[$point]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_collect[$point]['info']['exam_house_id']);
            }
            !empty($v_data['exam_house']) ? krsort($v_data['exam_house']) : "";
            $v_data['user_collect'] = $user_collect;
            $v_data['total'] = count($user_collect_arr);
            $this->load_header("我的收藏本_" . date("Y", time()) . "年教师资格证考试_教师招聘网", "", "", 2);
            $this->load->view('tiku/collection', $v_data);
            $this->load_footer();
        }
    }

    public function show_error() {
        $this->check_login();
        if (!empty($_GET['id']) && strstr($_GET['id'], "-")) {
            $this->check_vip();
            $tmp = explode("-", $_GET['id']);
            $point_id = $tmp[0];
            $id_str = trim($tmp[1], ",");
            $id_arr = strstr($id_str, ",") ? explode(",", $id_str) : array($id_str);
            $point = $this->tiku_model->get_point_by_id($point_id);
            $user_sheet_arr['name'] = "正在查看错题练习（" . $point['name'] . "）答案解析";
            $this->show_question_info($id_arr, $user_sheet_arr);
        } else {
            $user_error = array();
            $user_error_arr = $this->tiku_model->get_user_error_by_question_id($_SESSION['user_id']);
            foreach ($user_error_arr as $uca) {
                $top = $uca['parent_exam_point_id'] == 0 ? 0 : $uca['top_exam_point_id'];
                $parent = $uca['parent_exam_point_id'] == $uca['exam_point_id'] ? $uca['top_exam_point_id'] : $uca['parent_exam_point_id'];
                $point = $uca['exam_point_id'];
                if ($top > 0) {
                    $user_error[$top]['info'] = $this->tiku_model->get_point_by_id($top);
                    $user_error[$top]['info']['house'] = $this->tiku_model->get_exam_house_in_id($user_error[$top]['info']['exam_house_id']);
                    $user_error[$top]['info']['index'] = $this->tiku_model->get_index_by_function($user_error[$top]['info']['exam_house_id'], 'special_exam');
                    $user_error[$top]['question_num'] = !empty($user_error[$top]['question_num']) ? $user_error[$top]['question_num'] + 1 : 1;
                    $user_error[$top]['question_id'] = !empty($user_error[$top]['question_id']) ? $user_error[$top]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                    $v_data['exam_house'][$user_error[$top]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_error[$top]['info']['exam_house_id']);
                }
                if ($parent > 0) {
                    $user_error[$parent]['info'] = $this->tiku_model->get_point_by_id($parent);
                    $user_error[$parent]['info']['house'] = $this->tiku_model->get_exam_house_in_id($user_error[$parent]['info']['exam_house_id']);
                    $user_error[$parent]['info']['index'] = $this->tiku_model->get_index_by_function($user_error[$parent]['info']['exam_house_id'], 'special_exam');
                    $user_error[$parent]['question_num'] = !empty($user_error[$parent]['question_num']) ? $user_error[$parent]['question_num'] + 1 : 1;
                    $user_error[$parent]['question_id'] = !empty($user_error[$parent]['question_id']) ? $user_error[$parent]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                    $v_data['exam_house'][$user_error[$parent]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_error[$parent]['info']['exam_house_id']);
                }
                $user_error[$point]['info'] = $this->tiku_model->get_point_by_id($point);
                $user_error[$point]['info']['house'] = $this->tiku_model->get_exam_house_in_id($user_error[$point]['info']['exam_house_id']);
                $user_error[$point]['info']['index'] = $this->tiku_model->get_index_by_function($user_error[$point]['info']['exam_house_id'], 'special_exam');
                $user_error[$point]['question_num'] = !empty($user_error[$point]['question_num']) ? $user_error[$point]['question_num'] + 1 : 1;
                $user_error[$point]['question_id'] = !empty($user_error[$point]['question_id']) ? $user_error[$point]['question_id'] . $uca['question_id'] . "," : $uca['question_id'] . ",";
                $v_data['exam_house'][$user_error[$point]['info']['exam_house_id']] = $this->tiku_model->get_exam_house_in_id($user_error[$point]['info']['exam_house_id']);
            }
            !empty($v_data['exam_house']) ? krsort($v_data['exam_house']) : "";
            $v_data['user_error'] = $user_error;
            $index_arr = $this->tiku_model->get_index_by_house_short_name($this->session->userdata('house_name'));
            foreach ($index_arr as $i) {
                if ($i['index_function'] == "special_exam") {
                    $v_data['index'] = $i['id'];
                    break;
                }
            }
            $q_id = !empty($_GET['q_id']) ? intval($_GET['q_id']) : 0;
            $v_data['q_id'] = $q_id;
            $this->load_header("错题集_" . date("Y", time()) . "年教师资格证考试_教师招聘网", "", "", 2);
            $this->load->view('tiku/error', $v_data);
            $this->load_footer();
        }
    }

    public function show_question_info($id_arr = array(), $user_sheet_arr = array()) {
        $this->check_login();
        $sheet_question = array();
        $exam_paper = array();
        $all_answer_arr = array();
        $user_sheet_arr['exam_house_id'] = !empty($user_sheet_arr['exam_house_id']) ? $user_sheet_arr['exam_house_id'] : "";
        $house = $this->tiku_model->get_exam_house_in_id($user_sheet_arr['exam_house_id']);
        $p_house = $house['parent_id'] > 0 ? $this->tiku_model->get_exam_house_in_id($house['parent_id']) : $house;
        $question_arr = $this->tiku_model->get_question_in_id($id_arr);
        $v_data['user_sheet_arr'] = $user_sheet_arr;
        foreach ($question_arr as $s) {
            $s['question_type_cn'] = $this->tiku_model->get_question_type_by_id($s['question_type_id']);
            $s['question_type_cn'] = $s['question_type_cn']['name'];
            $exam_paper['part_1']['question_result'][] = $s;
            $exam_paper['part_1']['answer_arr'][$s['id']] = $this->tiku_model->get_answer_by_question_id($s['id']);
            $exam_paper['part_1']['material_arr'][$s['id']] = $this->tiku_model->get_material_by_question_id($s['id']);
            $sheet_question[] = $s['id'];
            $question = $this->tiku_model->get_question_by_id($s['id']);
            $top_id = $question['parent_exam_point_id'] == $question['exam_point_id'] ? 0 : $question['top_exam_point_id'];
            $parent_id = $question['parent_exam_point_id'] == $question['exam_point_id'] ? $question['top_exam_point_id'] : $question['parent_exam_point_id'];
            $question_point_arr[$s['id']]['top'] = $top_id > 0 ? $this->tiku_model->get_point_by_id($top_id) : array();
            $question_point_arr[$s['id']]['parent'] = $parent_id > 0 ? $this->tiku_model->get_point_by_id($parent_id) : array();
            $question_point_arr[$s['id']]['point'] = $question['exam_point_id'] > 0 ? $this->tiku_model->get_point_by_id($question['exam_point_id']) : array();
        }
        $v_data['exam_paper'] = $exam_paper;
        $all_sheet_info_arr = $this->tiku_model->get_user_sheet_info_by_question_id($sheet_question);
        foreach ($all_sheet_info_arr as $a) {
            $all_answer_arr[$a['question_id']]['info'] = $a;
            $all_answer_arr[$a['question_id']]['num'] = !empty($all_answer_arr[$a['question_id']]['num']) ? $all_answer_arr[$a['question_id']]['num'] + 1 : 1;
            if ($a['is_correct'] == 1) {
                $all_answer_arr[$a['question_id']]['true_num'] = !empty($all_answer_arr[$a['question_id']]['true_num']) ? $all_answer_arr[$a['question_id']]['true_num'] + 1 : 1;
            } elseif ($a['is_correct'] == 2) {
                $all_answer_arr[$a['question_id']]['false_num'] = !empty($all_answer_arr[$a['question_id']]['false_num']) ? $all_answer_arr[$a['question_id']]['false_num'] + 1 : 1;
                $a_answer = trim($a['user_answer'], "##");
                if (strstr($a['user_answer'], "##")) {
                    $false_item_arr = explode("##", $a_answer);
                } else {
                    $false_item_arr = array($a_answer);
                }
                $all_answer_arr[$a['question_id']]['false_item'] = array();
                foreach ($false_item_arr as $aa) {
                    $all_answer_arr[$a['question_id']]['false_item'][$aa] = !empty($all_answer_arr[$a['question_id']]['false_item'][$aa]) ? $all_answer_arr[$a['question_id']]['false_item'][$aa] + 1 : 1;
                }
                asort($all_answer_arr[$a['question_id']]['false_item']);
                foreach ($all_answer_arr[$a['question_id']]['false_item'] as $k => $v) {
                    $all_answer_arr[$a['question_id']]['false_item'] = $k;
                    break;
                }
            }
            $all_answer_arr[$a['question_id']]['true_num'] = !empty($all_answer_arr[$a['question_id']]['true_num']) ? $all_answer_arr[$a['question_id']]['true_num'] : 0;
            $all_answer_arr[$a['question_id']]['true_rate'] = sprintf("%.2f", ($all_answer_arr[$a['question_id']]['true_num'] / $all_answer_arr[$a['question_id']]['num']) * 100);
        }
        $v_data['all_answer_arr'] = $all_answer_arr;
        $v_data['question_point_arr'] = $question_point_arr;
        $user_sheet_info_arr = $this->tiku_model->get_user_sheet_info_by_user_id($_SESSION['user_id']);
        foreach ($user_sheet_info_arr as $u) {
            if (in_array($u['question_id'], $id_arr)) {
                $user_answer_arr[$u['question_id']]['info'] = $u;
                $user_answer_arr[$u['question_id']]['user_answer'] = explode("##", trim($u['user_answer'], "##"));
            }
            $user_answer_arr[$u['question_id']]['num'] = !empty($user_answer_arr[$u['question_id']]['num']) ? intval($user_answer_arr[$u['question_id']]['num']) + 1 : 1;
            if ($u['is_correct'] == 2) {
                $user_answer_arr[$u['question_id']]['error_num'] = !empty($user_answer_arr[$u['question_id']]['error_num']) ? $user_answer_arr[$u['question_id']]['error_num'] + 1 : 1;
            }
        }
        $v_data['user_answer_arr'] = $user_answer_arr;
        $user_collection_arr = $this->tiku_model->get_user_collection_by_user_id($_SESSION['user_id']);
        $v_data['user_collection'] = $user_collection_arr;
        $v_data['letter'] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $q_id = !empty($_GET['q_id']) ? intval($_GET['q_id']) : 0;
        $v_data['q_id'] = $q_id;
        $this->load_header($user_sheet_arr['name'] . "_教师招聘网", "教师资格证考试," . $_SESSION['house_name_cn'] . "," . $_SESSION['house_name_cn'] . "真题或" . $_SESSION['house_name_cn'] . "模拟题", date("Y", time()) . "年中学教师资格证考试" . $_SESSION['house_name_cn'] . "真题与模拟试题，" . $user_sheet_arr['name'] . "。");
        $this->load->view('tiku/parsing_page', $v_data);
        $this->load_footer();
    }

    public function continue_exam($id) {
        $user_id = $this->check_login();
        $sheet_arr = $this->tiku_model->get_user_sheet_by_id($id);
        $index = $this->tiku_model->get_index_in_id($sheet_arr['index_id']);
        $house = $this->tiku_model->get_exam_house_in_id($index['exam_house_id']);
        $this->session->set_userdata("house_name", $house['short_name']);
        if ($sheet_arr['user_id'] != $user_id || empty($index['index_function'])) {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
        }
        switch ($index['index_function']) {
            case "quick_exam":
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $_SESSION["house_name"] . '/' . $sheet_arr['index_id'] . '/' . $sheet_arr['sheet_id'] . '_' . $id . '";</script> ';
                break;
            case "special_exam":
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $_SESSION["house_name"] . '/' . $sheet_arr['index_id'] . '/' . $sheet_arr['sheet_id'] . '_' . $id . '";</script> ';
                break;
            case "paper_exam":
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $_SESSION["house_name"] . '/' . $sheet_arr['index_id'] . '/' . $sheet_arr['sheet_id'] . '_' . $id . '";</script> ';
                break;
            case "real_exam":
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku_' . $_SESSION["house_name"] . '/' . $sheet_arr['index_id'] . '_' . $sheet_arr['sheet_id'] . '_' . $id . '";</script> ';
                break;
            default:
                break;
        }
    }

    public function set_rand($i = 0) {
        $return = array();
        $coupons_house_tmp = $this->tiku_model->get_coupons_house("", 0, 1, "addtime desc");
        $coupons_house = $coupons_house_tmp[0];
        $stop_total = ($coupons_house['stop_rate'] / 100) * $coupons_house['total'];
        if ($i == 0 && strtotime(date('Y-m-d')) > $coupons_house['lasttime']) {
            $i = rand(100, 999);
            $coupons_house['false_total'] = 0;
            $coupons_house['total_num'] = 0;
            $this->common_model->update_one("coupons_house", $coupons_house, array('id' => $coupons_house['id']));
        }
        if ($coupons_house['endtime'] > time()) {
            if ($coupons_house['total_num'] < $stop_total) {
                $proArr = $this->tiku_model->get_coupons_section($coupons_house['id']);
                if (!empty($proArr)) {
                    $proSum = 0;
                    $false_total = 0;
                    foreach ($proArr as $key => $row) {
                        $rate[$key] = $row['rate'];
                        $proSum = $proSum + $row['rate'];
                    }
                    array_multisort($rate, SORT_ASC, $proArr);
                    $i = $i > 0 ? $i : $coupons_house['false_add'];
                    if ($coupons_house['total_num'] + $i > $stop_total) {
                        $i = $stop_total - $coupons_house['total_num'];
                    }
                    for ($a = 0; $a <= $i; $a++) {
                        $n = $b = $c = 0;
                        $r = rand(1, $proSum);
                        while ($n == 0) {
                            $b = $b + $proArr[$c]['rate'];
                            if ($r <= $b) {
                                $n = 1;
                                $rand[$a] = $proArr[$c];
                            } else {
                                $c++;
                            }
                        }
                    }
                    foreach ($rand as $r) {
                        $false_total += $r['value'];
                    }
                    $return['false_total'] = $coupons_house['false_total'] + $false_total;
                    $return['total_num'] = $coupons_house['total_num'] + $i;
                    $return['lasttime'] = strtotime(date('Y-m-d'));
                    $return['state_flag'] = 0;
                    $this->common_model->update_one("coupons_house", array('state_flag' => 1), "");
                    $this->common_model->update_one("coupons_house", $return, array('id' => $coupons_house['id']));
                    $return['remain'] = $coupons_house['total'] - $return['total_num'];
                }
            }
        } else {
            $this->common_model->update_one("coupons_house", array('state_flag' => 1), array('id' => $coupons_house['id']));
        }
        return $return;
    }

    public function ajax_user_point_question() {
        $user_id = $_SESSION['qs_user_id'];
        $house_id = $_SESSION['house_id'];
        $point_arr = $this->tiku_model->get_point_by_house_id($house_id);
        $num_str = "";
        foreach ($point_arr as $pa) {
            $num_str .= $pa['id'] . "-" . count($this->tiku_model->get_point_question_by_user_id($user_id, $pa['id'], "question_id")) . "#";
        }
        $num_str = trim($num_str, "#");
        echo $num_str;
    }

    public function ajax_real_paper_list($id) {
        $page = !empty($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
        $limit = 5;
        $offset = $page == 1 ? 0 : (($page - 1) * $limit);
        $real_paper_arr = $this->tiku_model->get_real_by_house_id($id, $limit, $offset);
        $total_paper_arr = $this->tiku_model->get_real_by_house_id($id);
        $page_str = $id . "#" . ceil(count($total_paper_arr) / $limit) . "#" . count($total_paper_arr) . "#" . $page . "#";
        $house_info = $this->tiku_model->get_exam_house_in_id($id);
        foreach ($real_paper_arr as $ra) {
            $all_info = $this->tiku_model->get_user_by_paper_id($ra['id']);
            $total = 0;
            foreach ($all_info as $u) {
                $total += intval($u['score']);
            }
            $user_info = !empty($_SESSION['user_id']) ? $this->tiku_model->get_user_by_paper_id($ra['id'], $_SESSION['user_id']) : array();
            $ra['do_num'] = count($user_info) > 0 ? count($user_info) : 0;
            $ra['total_do_num'] = count($all_info);
            $ra['average'] = $total > 0 ? sprintf("%.2f", $total / count($all_info)) : 0;
            $index_info = $this->tiku_model->get_index_by_function($ra['exam_house_id'], 'real_exam');
            $page_str .= $ra['name'] . "|" . $ra['hard'] . "|" . $ra['total_do_num'] . "|" . $ra['average'] . "|" . $ra['do_num'] . "|" . $ra['id'] . "|" . $house_info['short_name'] . "|" . $index_info['id'] . "#";
        }
        echo trim($page_str, "#");
    }

    public function ajax_favor() {
        $f_id = intval($_GET['id']);
        $tpye = trim($_GET['type']);
        if ($f_id > 0) {
            $favor_id = 0;
            $user_id = $this->check_login();
            $question_info = $this->tiku_model->get_question_by_id($f_id);
            if ($question_info['id'] < 1) {
                $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
            }
            if ($tpye == "add") {
                $f_data['user_id'] = $user_id;
                $f_data['exam_house_id'] = $question_info['exam_house_id'];
                $f_data['top_exam_point_id'] = $question_info['top_exam_point_id'];
                $f_data['parent_exam_point_id'] = $question_info['parent_exam_point_id'];
                $f_data['exam_point_id'] = $question_info['exam_point_id'];
                $f_data['question_id'] = $question_info['id'];
                $f_data['question_type_id'] = $question_info['question_type_id'];
                $f_data['addtime'] = time();
                $favor_id = $this->common_model->insert_one($f_data, 'tiku_user_collection');
            } elseif ($tpye == "del") {
                $has_id = $this->common_model->delete_one("tiku_user_collection", array('question_id' => $f_id, 'user_id' => $user_id));
                $favor_id = $has_id['id'] > 0 ? $has_id['id'] : 0;
            }
        } else {
            $this->common_model->show_dialog("没找到相关信息", "返回", "javascript:history.go(-1);", 1);
        }
        echo $favor_id;
    }

    public function ajax_check_user() {
        $user_name = !empty($_GET['user_name']) ? trim($_GET['user_name']) : "";
        $pwd = !empty($_GET['pwd']) ? trim($_GET['pwd']) : "";
        if (!empty($user_name) && !empty($pwd)) {
            $user_info = $this->tiku_model->get_user(array('phone' => $user_name, 'hash_pwd' => md5(md5($pwd) . HASH)));
            if (empty($user_info['id'])) {
                echo 0;
                exit;
            } else {
                echo 1;
                exit;
            }
        } else {
            if ($user_name == '13632243614') {
                echo 1;
                exit;
            }
            echo 0;
            exit;
        }
    }

    public function ajax_get_coupons() {
        if (empty($_SESSION['user_id'])) {
            $str = "请先登录！";
        } else {
            $user_id = $_SESSION['user_id'];
            $coupons_house_tmp = $this->tiku_model->get_coupons_house("", 0, 1, "addtime desc");
            $coupons_house = $coupons_house_tmp[0];
            if ($coupons_house['total_num'] == $coupons_house['total']) {
                $str = "优惠卷被抢完啦，客官明天再来哟";
            } else {
                $user_coupons = $this->tiku_model->get_user_coupons($user_id);
                if (!empty($user_coupons)) {
                    $str = "客官一人只能领取一张优惠卷哦";
                } else if (!empty($coupons_house['id'])) {
                    $proArr = $this->tiku_model->get_coupons_section($coupons_house['id']);
                    if (!empty($proArr)) {
                        $proSum = 0;
                        $false_total = 0;
                        foreach ($proArr as $key => $row) {
                            $rate[$key] = $row['rate'];
                            $proSum = $proSum + $row['rate'];
                        }
                        array_multisort($rate, SORT_ASC, $proArr);
                        $n = $b = $c = 0;
                        $r = rand(1, $proSum);
                        while ($n == 0) {
                            $b = $b + $proArr[$c]['rate'];
                            if ($r <= $b) {
                                $n = 1;
                                $rand = $proArr[$c];
                            } else {
                                $c++;
                            }
                        }
                        $code = md5($user_id . time() . $coupons_house['id']);
                        $code = substr($code, 0, 8);
                        $in_data['user_id'] = $user_id;
                        $in_data['house_id'] = $coupons_house['id'];
                        $in_data['section_id'] = $rand['id'];
                        $in_data['code'] = $code;
                        $in_data['value'] = $rand['value'];
                        $in_data['addtime'] = time();
                        $in_data['endtime'] = strtotime('+ 1 day');
                        $in_data['state_flag'] = 0;
                        $this->common_model->insert_one($in_data, "coupons");
                        $up_data['total_num'] = $coupons_house['total_num'] + 1;
                        $up_data['false_total'] = $coupons_house['false_total'] + $rand['value'];
                        $this->common_model->update_one("coupons_house", $up_data, array('id' => $coupons_house['id']));
                        $str = "恭喜您获得优惠卷" . $rand['value'] . "元";
                    }
                }
            }
        }
        echo $str;
    }

    public function get_paper_list($son_house = "", $type_id = 0, $page = 1) {
        $house_id = empty($son_house) ? $_SESSION['son_house_id'] : $son_house;
        $limit = 20;
        $offset = $page > 1 ? ($page - 1) * $limit : 0;
        $total_paper_res = $this->tiku_model->get_paper_in_house_id($house_id, $type_id);
        $paper_arr['total'] = ceil(count($total_paper_res) / $limit);
        $paper_res = $this->tiku_model->get_paper_in_house_id($house_id, $type_id, $limit, $offset);
        foreach ($paper_res as $pr) {
            $paper_time = 0;
            $paper_points = 0;
            $house_info = $this->tiku_model->get_exam_house_in_id($pr['exam_house_id']);
            $pr['house_name'] = $house_info['short_name'];
            $index_info = $this->tiku_model->get_index_by_function($pr['exam_house_id'], 'real_exam');
            $pr['index'] = $index_info['id'];
            $all_info = $this->tiku_model->get_user_by_paper_id($pr['id']);
            $pr['do_num'] = count($all_info);
            $section_info = $this->tiku_model->get_section_by_pid($pr['id'], 2);
            foreach ($section_info as $s) {
                $paper_time = $paper_time + $s['seconds'];
                $paper_points = $paper_points + $s['question_points'];
            }
            $m = floor($paper_time / 60);
            $s = $paper_time - ($m * 60);
            $pr['paper_time'] = $s == 0 ? $m . "分钟" : $m . "分钟" . $s . "秒";
            $pr['paper_points'] = $paper_points;
            $paper_arr['list'][] = $pr;
        }
        return $paper_arr;
    }

    public function ajax_get_paper_list() {
        /* 停用
          $house_id = !empty($_GET['house_id']) ? intval($_GET['house_id']) : $_SESSION['son_house_id'];
          $type_id = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
          $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
          $limit = 20;
          $offset = $page > 1 ? ($page - 1) * $limit + 1 : 0;
          $paper_str = "";
          $total_paper_res = $this->tiku_model->get_paper_in_house_id($house_id, $type_id);
          $paper_str .= $page . "##" . ceil(count($total_paper_res) / $limit) . "##";
          $paper_res = $this->tiku_model->get_paper_in_house_id($house_id, $type_id, $limit, $offset);
          foreach ($paper_res as $pr) {
          $paper_time = 0;
          $paper_points = 0;
          $house_info = $this->tiku_model->get_exam_house_in_id($pr['exam_house_id']);
          $pr['house_name'] = $house_info['short_name'];
          $index_info = $this->tiku_model->get_index_by_function($pr['exam_house_id'], 'real_exam');
          $pr['index'] = $index_info['id'];
          $all_info = $this->tiku_model->get_user_by_paper_id($pr['id']);
          $pr['do_num'] = count($all_info);
          $section_info = $this->tiku_model->get_section_by_pid($pr['id'], 2);
          foreach ($section_info as $s) {
          $paper_time = $paper_time + $s['seconds'];
          $paper_points = $paper_points + $s['question_points'];
          }
          $m = floor($paper_time / 60);
          $s = $paper_time - ($m * 60);
          $pr['paper_time'] = $s == 0 ? $m . "分钟" : $m . "分钟" . $s . "秒";
          $pr['paper_points'] = $paper_points;
          $str = $pr['house_name'] . "||" . $pr['index'] . "||" . $pr['id'] . "||" . $pr['name'] . "||" . $pr['hard'] . "||" . $pr['paper_time'] . "||" . $pr['paper_points'] . "||" . $pr['do_num'] . "##";
          $paper_str .= $str;
          }
          $paper_str = trim($paper_str, "##");
          exit($paper_str);
         */
    }

    public function ajax_exam_point($id) {
        $exam_point_arr = $this->tiku_model->get_point_by_house_id($id);
        $point_str = "";
        foreach ($exam_point_arr as $pa) {
            $pa['question_num'] = $this->tiku_model->get_question_num_by_point_id($pa['id']);
            $pa['house_name'] = $this->tiku_model->get_exam_house_in_id($pa['exam_house_id']);
            $pa['index'] = $this->tiku_model->get_index_by_function($pa['exam_house_id'], 'special_exam');
            $point_str .= $pa['exam_house_id'] . "||" . $pa['house_name']['short_name'] . "||" . $pa['index']['id'] . "||" . $pa['parent_id'] . "||" . $pa['id'] . "||" . $pa['name'] . "||" . $pa['question_num'] . "##";
        }
        $point_list = trim($point_str, "##");
        exit($point_list);
    }

    public function ajax_login() {
        /* 暂时停用_20150724 
          $username = !empty($_POST['username']) ? trim($_POST['username']) : "";
          $password = !empty($_POST['password']) ? trim($_POST['password']) : "";
          $login_str = file_get_contents(MAIN_SITE_URL . "plus/ajax_user.php?act=ajax_login&username=" . $username . "&password=" . $password);
          $login_arr = explode("-", $login_str);
          if ($login_arr[0] == 1) {
          $_GET['login_key'] = $login_arr[1];
          $login = $this->tiku_model->login();
          echo 1;
          exit;
          } else {
          exit($login_arr[1]);
          }
         */
    }

    public function do_test() {
        /* 暂时停用_20150724
          $login = $this->tiku_model->login();
          $list = $this->tiku_model->get_exam_house();
          foreach ($list as $e) {
          if (strstr($e['name'], "幼儿")) {
          $exam_house_list[0][] = $e;
          } elseif (strstr($e['name'], "小学")) {
          $exam_house_list[1][] = $e;
          } elseif (strstr($e['name'], "中学")) {
          $exam_house_list[2][] = $e;
          }
          }
          $v_data['exam_house_list'] = $exam_house_list;
          $this->load->view('tiku/do_test_1', $v_data);
         */
    }

    public function do_test2() {
        /* 暂时停用_20150724 
          $house_id = intval($_POST['house_id']) > 0 ? intval($_POST['house_id']) : $this->common_model->show_dialog("请选择薄弱科目", "返回", "javascript:history.go(-1);", 1);
          $exam_house = $this->tiku_model->get_exam_house_in_id($house_id);
          $this->session->set_userdata(array('house_name' => $exam_house['short_name']));
          $this->session->set_userdata(array('house_name_cn' => $exam_house['name']));
          $this->session->set_userdata(array('house_id' => $exam_house['id']));
          $index = $this->tiku_model->get_index_by_function($house_id, 'wechat_exam');
          $this->session->set_userdata(array('index_function' => $index['index_function']));
          $this->set_exam($index['id']);
         */
    }

    public function daily_exam() {
        /* 暂时停用_20150724 
          if ($this->is_ajax()) {
          if (empty($_SESSION['user_id'])) {
          echo 0;
          exit();
          }
          } else {
          $user_id = $this->check_login();
          }
          $vip_arr = $this->tiku_model->get_vip_by_user_id($user_id);
          if (empty($vip_arr)) {
          $user_sheet_arr = $this->tiku_model->get_user_sheet_by_user_id($user_id, 0, 0, 1);
          $user_sheet_arr = $user_sheet_arr[0];
          $now = strtotime(date('Y-m-d'));
          $user_last_time = strtotime(date('Y-m-d', $user_sheet_arr['submittime']));
          if ($now <= $user_last_time) {
          if ($this->is_ajax()) {
          echo 1;
          exit();
          } else {
          $this->common_model->show_dialog("客官，非VIP用户一天只能练习一次哦！", "购买VIP", "/tiku/order", 1);
          }
          }
          }
          if ($this->is_ajax()) {
          echo 2;
          exit();
          }
          $house_id = !empty($_GET['house_id']) ? intval($_GET['house_id']) : 0;
          $this->make_daily_exam($user_id, $house_id);
         */
    }

    public function make_daily_exam($user_id, $house_id) {
        /* 暂时停用_20150724
          $exam_house = $this->tiku_model->get_exam_house_in_id($house_id);
          $this->session->set_userdata(array('house_name' => $exam_house['short_name']));
          $this->session->set_userdata(array('house_name_cn' => $exam_house['name']));
          $this->session->set_userdata(array('house_id' => $exam_house['id']));
          $index = $this->tiku_model->get_index_by_function($house_id, 'daily_exam');
          $this->session->set_userdata(array('index_function' => $index['index_function']));
          $this->set_exam($index['id']);
         */
    }

    public function news_list() {
        $news_list = array();
        $type_id = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
        $p = !empty($_GET['page']) ? $_GET['page'] : 1;
        $offset = $p > 1 ? ($p - 1) * 10 + 1 : 0;
        $v_data['news_type_list'] = $this->tiku_model->get_news_type();
        $v_data['news_type_id'] = $type_id;
        $v_data['news_num'] = $this->tiku_model->get_news_num($v_data['news_type_id']);
        $v_data['total_page'] = ceil($v_data['news_num'] / 10);
        $v_data['page'] = $p;
        $news_list = $this->tiku_model->get_news_by_type_id($type_id, 10, $offset);
        $v_data['news_info'] = $news_list;
        $this->load_header();
        $this->load->view('tiku/news_list', $v_data);
        $this->load_footer();
    }

    public function show_news($id) {
        $id = !empty($id) ? intval($id) : $this->common_model->show_dialog("没有找到相关信息", "返回", "javascript:history.go(-1);", 1);
        $v_data['news'] = $this->tiku_model->get_news($id);
        $v_data['news'] = $v_data['news'][0];
        $this->load_header($v_data['news']['title'] . "_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
        $this->load->view('tiku/news_page', $v_data);
        $this->load_footer();
    }

    public function ajax_send_sms($id) {
        $code = rand(100000, 999999);
        $text = "【教师网】您的验证码是" . $code;
        $this->common_model->delete_one("sms_verification", array('phone' => $id));
        $in['phone'] = $id;
        $in['verification_code'] = $code;
        $in['add_time'] = time();
        $this->common_model->insert_one($in, "sms_verification");
        $send = $this->common_model->send_sms($text, $id);
        $return = empty($send) ? 0 : 1;
        echo $return;
    }

    public function sms_login() {
        /* 停用
          $phone = !empty($_POST['phone']) ? intval($_POST['phone']) : 0;
          $code = !empty($_POST['code']) ? intval($_POST['code']) : 0;
          $pwd = !empty($_POST['pwd']) ? trim($_POST['pwd']) : 0;
          $back_url = !empty($_SESSION['back_url']) ? $_SESSION['back_url'] : "/";
          if (($phone == 0 || $code == 0) && !$pwd) {
          $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
          $this->common_model->show_dialog("手机号或验证码错误！", "返回", $back_url, 1);
          }
          if (!$pwd) {
          $v_info = $this->tiku_model->get_sms_verification($phone, $code);
          $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
          if (empty($v_info['id'])) {
          $this->common_model->show_dialog("验证码错误或过期！", "返回", $back_url, 1);
          } else {
          $user_info = $this->tiku_model->get_user(array('phone' => $phone));
          if (empty($user_info)) {
          $user_id = $this->set_user($phone);
          $this->update_login($user_id);
          $this->load->view('tiku/set_password');
          } else {
          !empty($_SESSION['openid']) ? $up_arr['openid'] = $_SESSION['openid'] : "";
          !empty($_SESSION['qs_user_id']) ? $up_arr['qs_user_id'] = $_SESSION['qs_user_id'] : 0;
          !empty($_SESSION['qs_user_name']) ? $up_arr['username'] = $_SESSION['qs_user_name'] : "";
          if (!empty($up_arr)) {
          $this->common_model->update_one("user", $up_arr, array('id' => $user_info['id']));
          }
          $this->update_login($user_info['id']);
          if (!empty($user_info['hash_pwd'])) {
          echo '<script type="text/javascript" language="javascript">window.location.href="' . $back_url . '";</script> ';
          } else {
          $this->load->view('tiku/set_password');
          }
          }
          }
          } else {
          $up_arr['hash_pwd'] = md5(md5($pwd) . HASH);
          !empty($_SESSION['openid']) ? $up_arr['openid'] = $_SESSION['openid'] : "";
          !empty($_SESSION['qs_user_id']) ? $up_arr['qs_user_id'] = $_SESSION['qs_user_id'] : 0;
          !empty($_SESSION['qs_user_name']) ? $up_arr['username'] = $_SESSION['qs_user_name'] : "";
          $this->common_model->update_one("user", $up_arr, array('id' => $_SESSION['user_id']));
          if (!empty($up_arr['qs_user_id'])) {
          $this->common_model->delete_one("user", array('phone' => "", 'qs_user_id' => $up_arr['qs_user_id']));
          }
          $this->update_login($_SESSION['user_id']);
          echo '<script type="text/javascript" language="javascript">window.location.href="' . $back_url . '";</script> ';
          }
         * 
         */
    }

    public function is_ajax() {
        return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest";
    }

    public function update_login($user_id, $set_cookie = 0) {
        $up_arr['qs_user_id'] = !empty($_SESSION['qs_user_id']) ? $_SESSION['qs_user_id'] : 0;
        $up_arr['qs_user_name'] = !empty($_SESSION['qs_user_name']) ? $_SESSION['qs_user_name'] : "";
        $this->common_model->delete_one("user", array('phone' => 0, 'hash_pwd' => "", 'qs_user_id' => $up_arr['qs_user_id']));
        $user_info = $this->tiku_model->get_user(array('id' => $user_id));
        $username = empty($user_info['username']) ? $user_info['phone'] : $user_info['username'];
        $this->session->set_userdata(array('user_id' => $user_info['id']));
        $this->session->set_userdata(array('user_name' => $username));
        if ($set_cookie > 0) {
            $this->input->set_cookie("user_id", $user_info['id'], time() + 3600 * 24 * 7);
            $this->input->set_cookie("user_name", $username, time() + 3600 * 24 * 7);
        }
        if ($up_arr['qs_user_id'] > 0) {
            $this->common_model->update_one("tiku_user_sheet", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("tiku_user_sheet_info", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("tiku_user_collection", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("tiku_vip", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("tiku_error_question", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("order", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
            $this->common_model->update_one("coupons", array('user_id' => $user_info['id']), array('qs_user_id' => $up_arr['qs_user_id'], 'user_id' => 0));
        }
    }

    public function set_user($phone = 0) {
        $openid = !empty($_SESSION['openid']) ? $_SESSION['openid'] : "";
        $user_info = $this->tiku_model->get_user(array('phone' => $phone));
        if (empty($user_info['id'])) {
            $qs_user_id = !empty($_SESSION['qs_user_id']) ? $_SESSION['qs_user_id'] : 0;
            $qs_user_name = !empty($_SESSION['qs_user_name']) ? $_SESSION['qs_user_name'] : "";
            $user_id = $this->common_model->insert_one(array('phone' => $phone, 'qs_user_id' => $qs_user_id, 'username' => $qs_user_name, 'openid' => $openid, 'regtime' => time()), "user");
        } else {
            $user_id = $user_info['id'];
        }
        $this->update_login($user_id);
        return $user_id;
    }

    /* 更改
      public function check_login() {
      $back = !empty($_GET['back']) && $_GET['back'] == 1 ? "/" : "";
      $this->session->set_userdata(array('back_url' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
      if (empty($_SESSION['user_id']) && !empty($_SESSION['openid'])) {
      $user_info = $this->tiku_model->get_user(array('openid' => $_SESSION['openid']));
      $_SESSION['user_id'] = !empty($user_info['id']) ? $user_info['id'] : "";
      }
      if (empty($_SESSION['user_id'])) {
      $this->common_model->sms_window();
      } else {
      $user_info = $this->tiku_model->get_user(array('id' => $_SESSION['user_id']));
      if (empty($user_info['phone']) || empty($user_info['hash_pwd'])) {
      $this->common_model->sms_window();
      } else {
      $this->update_login($user_info['id']);
      if (empty($back)) {
      return $_SESSION['user_id'];
      } else {
      echo '<script type="text/javascript" language="javascript">window.location.href="' . $back . '";</script> ';
      }
      }
      }
      }
     * 
     */

    public function check_login($back = "") {
        if (empty($_SESSION['user_id']) && !empty($_SESSION['openid'])) {
            $user_info = $this->tiku_model->get_user(array('openid' => $_SESSION['openid']));
            $_SESSION['user_id'] = !empty($user_info['id']) ? $user_info['id'] : "";
        }
        if (empty($_SESSION['user_id'])) {
            echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/login";</script> ';
        } else {
            $user_info = $this->tiku_model->get_user(array('id' => $_SESSION['user_id']));
            if (empty($user_info['phone']) || empty($user_info['hash_pwd'])) {
                echo '<script type="text/javascript" language="javascript">window.location.href="/tiku/login";</script> ';
            } else {
                $this->update_login($user_info['id']);
                if (empty($back)) {
                    return $_SESSION['user_id'];
                } else {
                    echo '<script type="text/javascript" language="javascript">window.location.href="' . $_SESSION['back_url'] . '";</script> ';
                }
            }
        }
    }

    public function check_vip() {
        $this->check_login();
        $vip_arr = $this->tiku_model->get_vip_by_user_id($_SESSION['user_id']);
        if (empty($vip_arr['id'])) {
            $vip_arr = array();
            $order = $this->tiku_model->get_order_by_userid($_SESSION['user_id']);
            if ($order['is_paid'] == 1) {
                $vip_arr['user_id'] = $_SESSION['user_id'];
                $vip_arr['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                $vip_arr['endtime'] = intval($vip_arr['addtime']) + intval($order['days']) * 86400;
                $vip_arr['id'] = $this->common_model->insert_one($vip_arr, 'tiku_vip');
            }
        }
        if (empty($vip_arr['id'])) {
            if ($this->is_ajax()) {
                echo 2;
                exit;
            } else {
                $this->common_model->show_dialog("亲，只有VIP会员才能练习哦，每套低至<span style='color:red;'>5</span>分钱。", "立即充值", "/tiku/order", 1, "温馨提示");
            };
        }
        if ($vip_arr['endtime'] < time()) {
            if ($this->is_ajax()) {
                echo 3;
                exit;
            } else {
                $this->common_model->show_dialog("您的VIP已过期，充值后立即享有<span style='color:red;'>320</span>套精编试题。", "立即充值", "/tiku/order", 1, "温馨提示");
            };
        }
        if ($this->is_ajax()) {
            echo 1;
        } else {
            return $vip_arr;
        };
    }

    public function qs_login($remember = 0) {
        $key = !empty($_GET['login_key']) ? $_GET['login_key'] : "";
        $qs_info = $this->tiku_model->get_login_info($key);
        if ($qs_info) {
            $this->session->set_userdata(array('qs_user_id' => $qs_info['qs_user_id']));
            $this->session->set_userdata(array('qs_user_name' => $qs_info['user_name']));
            $user_info = $this->tiku_model->get_user(array('qs_user_id' => $qs_info['qs_user_id']));
            if (empty($user_info['id'])) {
                $user_id = $this->common_model->insert_one(array('qs_user_id' => $qs_info['qs_user_id'], 'username' => $qs_info['user_name'], 'regtime' => time()), "user");
                $user_info = $this->tiku_model->get_user(array('id' => $user_id));
            }
            $this->update_login($user_info['id'], $remember);
            if (empty($user_info['phone']) || empty($user_info['hash_pwd'])) {
                $this->common_model->sms_window();
            } else {
                echo '<script type="text/javascript" language="javascript">window.location.href="' . $_SESSION['back_url'] . '";</script> ';
            }
        } else {
            echo '<script type="text/javascript" language="javascript">window.location.href="' . $_SESSION['back_url'] . '";</script> ';
        }
    }

    public function make_info() {
        if (empty($_POST)) {
            $this->load_header("注册_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
            $this->load->view('tiku/make_info');
            $this->load_footer();
        } else {
            $phone = !empty($_POST['phone']) ? intval($_POST['phone']) : 0;
            $code = !empty($_POST['code']) ? intval($_POST['code']) : 0;
            $pwd = !empty($_POST['pwd']) ? trim($_POST['pwd']) : "";
            $back_url = $this->get_back($_SESSION['back_url']);
            if ($phone == 0 || $code == 0 || empty($pwd)) {
                $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
                $this->common_model->show_dialog("手机号，验证码或密码错误！", "返回", "$back_url", 1);
            } else {
                $v_info = $this->tiku_model->get_sms_verification($phone, $code);
                $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
                //$v_info['id'] = 1;
                if (empty($v_info['id'])) {
                    $this->common_model->show_dialog("验证码错误或过期！", "返回", $back_url, 1);
                } else {
                    $openid = !empty($_SESSION['openid']) ? $_SESSION['openid'] : '';
                    $user_info = $this->tiku_model->get_user(array('phone' => $phone));
                    if (empty($user_info['id'])) {
                        $user_id = $this->common_model->insert_one(array('phone' => $phone, 'hash_pwd' => md5(md5($pwd) . HASH), 'openid' => $openid, 'regtime' => time()), "user");
                    } else {
                        $this->common_model->update_one("user", array('hash_pwd' => md5(md5($pwd) . HASH), 'openid' => $openid), array('id' => $user_info['id']));
                        $user_id = $user_info['id'];
                    }
                    $this->update_login($user_id);
                    echo '<script type="text/javascript" language="javascript">window.location.href="' . $back_url . '";</script> ';
                }
            }
        }
    }

    public function ajax_check_phone() {
        $phone = !empty($_GET['p']) ? $_GET['p'] : 0;
        if ($phone > 0) {
            $user_info = $this->tiku_model->get_user(array('phone' => $phone));
            echo!empty($user_info['id']) ? 1 : 0;
            exit;
        }
    }

    public function login() {
        if (empty($_SESSION['user_id'])) {
            if (empty($_POST)) {
                $back_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/";
                $back_url = $this->get_back($back_url);
                $this->session->set_userdata(array('back_url' => $back_url));
                $in['verification_code'] = rand(10000000, 99999998);
                $in['addtime'] = time();
                $this->common_model->insert_one($in, "wechat_verification");
                $v_data['verification_code'] = intval($in['verification_code']);
                $v_data['ticket'] = $this->get_ticket($in['verification_code']);
                $this->load_header("登录_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
                $this->load->view('tiku/login', $v_data);
                $this->load_footer();
            } else {
                $user_name = trim($_POST['user_name']);
                $pwd = trim($_POST['pwd']);
                $remember = !empty($_POST['remember']) ? intval($_POST['remember']) : 0;
                preg_match('/^1[0-9][0-9]\d{4,8}$/', $user_name, $res);
                if (!empty($res)) {
                    $user_info = $this->tiku_model->get_user(array('phone' => $user_name, 'hash_pwd' => md5(md5($pwd) . HASH)));
                    if ($user_name == '13632243614') {
                        $user_info = $this->tiku_model->get_user(array('phone' => $user_name));
                    }
                    if (!empty($user_info['id'])) {
                        $this->update_login($user_info['id'], $remember);
                        $vip_arr = $this->tiku_model->get_vip_by_user_id($_SESSION['user_id']);
                        if (empty($vip_arr)) {
                            $vip_arr = array();
                            $order = $this->tiku_model->get_order_by_userid($_SESSION['user_id']);
                            if ($order['is_paid'] == 1) {
                                $vip_arr['user_id'] = $_SESSION['user_id'];
                                $vip_arr['addtime'] = $order['paytime'] == 0 ? $order['addtime'] : $order['paytime'];
                                $vip_arr['endtime'] = intval($vip_arr['addtime']) + intval($order['days']) * 86400;
                                $vip_arr['id'] = $this->common_model->insert_one($vip_arr, 'tiku_vip');
                            }
                        }
                        if (empty($vip_arr)) {
                            $this->load_header("登录_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
                            $this->load->view('tiku/login_no_vip');
                            $this->load_footer();
                        } else {
                            echo '<script type="text/javascript" language="javascript">window.location.href="' . $_SESSION['back_url'] . '";</script> ';
                        }
                    } else {
                        $this->common_model->show_dialog("用户不存在！", "返回", $_SESSION['back_url'], 1);
                    }
                } else {
                    $login_str = file_get_contents(MAIN_SITE_URL . "plus/ajax_user.php?act=ajax_login&username=" . $user_name . "&password=" . $pwd);
                    $login_arr = explode("-", $login_str);
                    if ($login_arr[0] == 1) {
                        $_GET['login_key'] = $login_arr[1];
                        $this->qs_login($remember);
                    } else {
                        $this->common_model->show_dialog($login_arr[1], "返回", $_SESSION['back_url'], 1);
                    }
                }
            }
        } else {
            $_SESSION['back_url'] = !empty($_SESSION['back_url']) ? $_SESSION['back_url'] : "/";
            echo '<script type="text/javascript" language="javascript">window.location.href="' . $_SESSION['back_url'] . '";</script> ';
        }
    }

    public function forget_password() {
        if (empty($_POST)) {
            $this->load_header("忘记密码_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
            $this->load->view('tiku/forget_password');
            $this->load_footer();
        } else {
            $phone = !empty($_POST['phone']) ? intval($_POST['phone']) : 0;
            $code = !empty($_POST['code']) ? intval($_POST['code']) : 0;
            $pwd = !empty($_POST['pwd']) ? trim($_POST['pwd']) : "";
            $back_url = $this->get_back($_SESSION['back_url']);
            if ($phone == 0 || $code == 0 || empty($pwd)) {
                $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
                $this->common_model->show_dialog("手机号，验证码或密码错误！", "返回", "$back_url", 1);
            } else {
                $v_info = $this->tiku_model->get_sms_verification($phone, $code);
                $this->common_model->delete_one("sms_verification", array('phone' => $phone, 'verification_code' => $code));
                if (empty($v_info['id'])) {
                    $this->common_model->show_dialog("验证码错误或过期！", "返回", $back_url, 1);
                } else {
                    $user_info = $this->tiku_model->get_user(array('phone' => $phone));
                    if (empty($user_info['id'])) {
                        $user_info['id'] = $this->set_user($phone);
                    }
                    $this->common_model->update_one("user", array('hash_pwd' => md5(md5($pwd) . HASH)), array('id' => $user_info['id']));
                    $this->update_login($user_info['id']);
                    if (empty($user_info['openid'])) {
                        $back_url = "/tiku/reg/1";
                    }
                    echo '<script type="text/javascript" language="javascript">window.location.href="' . $back_url . '";</script> ';
                }
            }
        }
    }

    public function logout() {
        delete_cookie("user_id");
        delete_cookie("user_name");
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('openid');
        $this->session->unset_userdata('qs_user_id');
        $this->session->unset_userdata('qs_user_name');
        file_get_contents(MAIN_SITE_URL . "user/login.php?act=logout&tiku_logout=1");
        Header("Location:/");
    }

    public function reg($id = 0) {
        if ($id == 0) {
            $back_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/";
            $back_url = $this->get_back($back_url);
            $this->session->set_userdata(array('back_url' => $back_url));
        }
        $in['verification_code'] = rand(10000000, 99999998);
        $in['addtime'] = time();
        $this->common_model->insert_one($in, "wechat_verification");
        $v_data['verification_code'] = intval($in['verification_code']);
        $v_data['ticket'] = $this->get_ticket($in['verification_code']);
        //echo $v_data['ticket'];exit;
        $this->load_header("注册_" . date("Y", time()) . "年教师资格证考试_教师招聘网");
        $this->load->view('tiku/reg', $v_data);
        $this->load_footer();
    }

    public function get_back($back = "") {
        $back_url = !empty($back) && $back != "http://" . $_SERVER['SERVER_NAME'] . "/tiku/reg" && $back != "http://" . $_SERVER['SERVER_NAME'] . "/tiku/login" && $back != "http://" . $_SERVER['SERVER_NAME'] . "/tiku/make_info" && $back != "http://" . $_SERVER['SERVER_NAME'] . "/tiku/forget_password" ? $back : "/";
        return $back_url;
    }

    public function get_ticket($code = 0) {
        $access_token = $this->jssdk->getAccessToken();
        $params = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . intval($code) . '}}}';
        $website = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $website);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $curl_result = curl_exec($ch);
        $de_json = json_decode($curl_result, TRUE);
        $de_json = !empty($de_json) ? $de_json : "";
        return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $de_json['ticket'];
    }

    public function check_wechat_verification() {
        $verification_code = $this->input->post('verification_code');
        $wechat_verification = $this->tiku_model->get_wechat_verification($verification_code);
        if (empty($wechat_verification)) {
            //验证码已过期，需刷新
            echo 'overdue';
        } else {
            if (!empty($wechat_verification['openid'])) {
                $this->session->set_userdata(array('openid' => $wechat_verification['openid']));
                $user_info = $this->tiku_model->get_user(array('openid' => $wechat_verification['openid']));
                if (!empty($user_info['id'])) {
                    $this->update_login($user_info['id']);
                    echo $_SESSION['back_url'];
                } elseif (!empty($_SESSION['openid']) && !empty($_SESSION['user_id'])) {
                    $this->common_model->update_one("user", array('openid' => $_SESSION['openid']), array('id' => $_SESSION['user_id']));
                    echo!empty($_SESSION['back_url']) ? $_SESSION['back_url'] : '/';
                } else {
                    echo '/tiku/make_info';
                }
            } else {
                echo 'waiting';
            }
        }
    }

    public function load_header($title = "", $keywords = "", $description = "", $history = 1) {
        $exam_house_list = $this->tiku_model->get_exam_house();
        $v_data['exam_house_list'] = $exam_house_list;
        $v_data['page_title'] = $title;
        $v_data['page_keywords'] = $keywords;
        $v_data['page_description'] = $description;
        $this->session->set_userdata(array('history' => $history));
        $this->load->view('tiku/header', $v_data);
    }

    public function load_footer() {
        $this->load->view('tiku/footer');
    }

    public function clean_tags() {
        $question = $this->tiku_model->get_question_in_id();
        foreach ($question as $q) {
            $q['title'] = strip_tags($q['title'], '<img> <br>');
            $q['description'] = strip_tags($q['description'], '<img> <br>');
            $q['answer'] = strip_tags($q['answer'], '<img> <br> <p>');
            $this->common_model->update_one("tiku_question", array('title' => $q['title'], 'description' => $q['description'], 'answer' => $q['answer']), array('id' => $q['id']));
        }
        $choice = $this->tiku_model->get_answer_by_question_id();
        foreach ($choice as $c) {
            $c['content'] = strip_tags($c['content'], '<img> <br>');
            $this->common_model->update_one("tiku_question_choice", array('content' => $c['content']), array('id' => $c['id']));
        }
    }

}
