<?php

class Tiku_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    /*
     * 名称：get_exam_house
     * 功能：获取题库数据
     * 输入：$state：题库状态；$select：获取字段；$order：是否使用排序；
     * 输出：题库数据数组（多维数组）
     */

    public function get_exam_house($state = 1, $select = "", $order = true) {
        if (!empty($select)) {
            $this->db->select($select);
        }
        if ($state > 0) {
            $where = " state_flag = " . $state;
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by('order', "desc");
        }
        $query = $this->db->get("tiku_exam_house");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_exam_house_by_id
     * 功能：根据ID获取题库数据
     * 输入：$id：题库ID；
     * 输出：题库数据数组（一维数组）
     */

    public function get_exam_house_in_id($id = "") {
        if (!empty($id)) {
            $where = " id IN(" . $id . ") ";
            $this->db->where($where);
        } else {
            $this->db->select_min('id');
            $query = $this->db->get("tiku_exam_house");
            $min_id = $query->row_array();
            $where = " id = " . $min_id['id'];
            $this->db->where($where);
        }
        $query = $this->db->get("tiku_exam_house");
        if (strstr($id, ",")) {
            $result = $query->result_array();
        } else {
            $result = $query->row_array();
        }
        return $result;
    }

    /*
     * 名称：get_exam_house_by_short_name
     * 功能：根据题库简称获取题库数据
     * 输入：$short_name：题库简称；
     * 输出：题库数据数组（一维数组）
     */

    public function get_exam_house_by_short_name($short_name = "") {
        if (!empty($short_name)) {
            $where = " short_name = '" . $short_name . "'";
            $this->db->where($where);
        }
        $query = $this->db->get("tiku_exam_house");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_exam_house_by_parent_id
     * 功能：根据父级ID获取题库数据
     * 输入：$parent_id：父级ID；
     * 输出：题库数据数组（多维数组）
     */

    public function get_exam_house_by_parent_id($parent_id = 0, $select = "") {
        if (!empty($select)) {
            $this->db->select($select);
        }
        if ($parent_id > 0) {
            $where = " parent_id = '" . $parent_id . "'";
            $this->db->where($where);
        }
        $query = $this->db->get("tiku_exam_house");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_index_by_house_short_name
     * 功能：根据题库简称获取题库索引数据
     * 输入：$short_name：题库简称；
     * 输出：题库索引数据数组（多维数组）
     */

    public function get_index_by_house_short_name($short_name) {
        $this->db->select('id');
        $this->db->where(" short_name  = '" . $short_name . "'");
        $query = $this->db->get("tiku_exam_house");
        $house_result = $query->row_array();
        $this->db->where(" exam_house_id = '" . $house_result['id'] . "'");
        $this->db->where(" state_flag = 1");
        $this->db->where(" order > 0");
        $this->db->order_by("order", "desc");
        $query = $this->db->get("tiku_index");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_index_by_id
     * 功能：根据索引ID获取索引数据
     * 输入：$id：索引ID；
     * 输出：索引数据数组（一维数组）
     */

    public function get_index_in_id($id) {
        $this->db->where(" id  IN(" . $id . ")");
        $this->db->where(" order > 0");
        $query = $this->db->get("tiku_index");
        //echo $this->db->last_query();exit;
        if (strstr($id, ",")) {
            $result = $query->result_array();
        } else {
            $result = $query->row_array();
        }
        return $result;
    }

    /*
     * 名称：get_index_in_house_id
     * 功能：根据题库ID获取索引数据
     * 输入：$id：题库ID；
     * 输出：索引数据数组（多维数组）
     */

    public function get_index_in_house_id($id) {
        $this->db->where(" exam_house_id  IN(" . $id . ")");
        $this->db->where(" order > 0 ");
        $this->db->where(" state_flag = 1 ");
        $query = $this->db->get("tiku_index");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_index_by_function
     * 功能：根据题库ID和索引功能获取索引数据
     * 输入：$house_id：题库ID；$function：索引功能；
     * 输出：索引数据数组（一维数组）
     */

    public function get_index_by_function($house_id = 0, $function) {
        if ($house_id > 0) {
            $this->db->where(" exam_house_id  = '" . $house_id . "'");
        }
        $this->db->where(" index_function  = '" . $function . "'");
        $query = $this->db->get("tiku_index");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_real_by_id
     * 功能：根据真题ID获取真题数据
     * 输入：$id：真题ID；
     * 输出：真题数据数组（ID为0：多维维数组；ID大于0：一维数组）
     */

    public function get_real_by_id($id = 0) {
        if ($id > 0) {
            $this->db->where(" id  = '" . $id . "'");
        }
        //$this->db->where(" is_real  = 2");
        $query = $this->db->get("tiku_exam_paper");
        if ($id > 0) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    /*
     * 名称：get_vip_by_qsid
     * 功能：根据用户骑士ID获取VIP记录
     * 输入：$qs_user_id：用户骑士ID；
     * 输出：用户VIP数据数组（一维数组）
     */

    public function get_vip_by_user_id($user_id) {
        $this->db->where(" user_id  = '" . $user_id . "'");
        $query = $this->db->get("tiku_vip");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_coupons_by_qsid
     * 功能：根据用户骑士ID获取优惠卷记录
     * 输入：$qs_user_id：用户骑士ID；
     * 输出：用户优惠卷数据数组（多维数组）
     */

    public function get_coupons_by_user_id($user_id = 0) {
        $result = array();
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
            $this->db->where(" endtime > '" . time() . "'");
            $this->db->where(" state_flag  = 0");
            $query = $this->db->get("coupons");
            $result = $query->result_array();
        }
        return $result;
    }

    /*
     * 名称：get_coupons_by_id
     * 功能：根据ID获取优惠卷记录
     * 输入：$id：优惠卷ID；
     * 输出：优惠卷数据数组（一维数组）
     */

    public function get_coupons_by_id($id) {
        $this->db->where(" id  = '" . $id . "'");
        $query = $this->db->get("coupons");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_package_by_id
     * 功能：根据套餐ID获取VIP套餐数据
     * 输入：$package_id：VIP套餐ID；
     * 输出：VIP套餐数据数组（一维数组）
     */

    public function get_package_by_id($package_id) {
        $this->db->where(" id  = '" . $package_id . "'");
        $query = $this->db->get("tiku_vip_package");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_payment_by_id
     * 功能：根据支付方式ID获取支付方式数据
     * 输入：$payment_id：支付方式ID；
     * 输出：支付方式数据数组（一维数组）
     */

    public function get_payment_by_id($payment_id) {
        $this->db->where(" id  = '" . $payment_id . "'");
        $query = $this->db->get("payment");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_payment_by_name
     * 功能：根据支付方式类型名获取支付方式数据
     * 输入：$name：支付方式类型名；
     * 输出：支付方式数据数组（一维数组）
     */

    public function get_payment_by_name($name) {
        $this->db->where(" type_name  = '" . $name . "'");
        $query = $this->db->get("payment");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_package_list
     * 功能：获取所有VIP套餐数据
     * 输入：无
     * 输出：所有VIP数据数组（多维数组）
     */

    public function get_package_list() {
        $this->db->where(" state_flag  = 1 ");
        $query = $this->db->get("tiku_vip_package");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_payment_list
     * 功能：获取支付方式列表
     * 输入：无
     * 输出：支付方式列表（多维数组）
     */

    public function get_payment_list() {
        $this->db->where(" state_flag  = 1 ");
        $query = $this->db->get("payment");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_order_one
     * 功能：根据用户骑士ID和订单ID获取订单数据
     * 输入：$qs_user_id：用户骑士ID；$order_id：订单ID；
     * 输出：相关订单数据（一维数组）
     */

    public function get_order_one($user_id, $order_id) {
        $this->db->where(" user_id  = " . $user_id);
        $this->db->where(" id  = " . $order_id);
        $query = $this->db->get("order");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_order_by_userid
     * 功能：根据用户ID获取订单数据
     * 输入：$user_id：用户ID；
     * 输出：相关订单数据（一维数组）
     */

    public function get_order_by_userid($user_id) {
        $this->db->where(" user_id  = " . $user_id);
        $query = $this->db->get("order");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_order_by_orderid
     * 功能：根据订单编号获取订单数据
     * 输入：$order_id：订单编号；
     * 输出：相关订单数据（一维数组）
     */

    public function get_order_by_orderid($order_id) {
        $this->db->where(" order_id  = '" . $order_id . "'");
        $query = $this->db->get("order");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_order_by_id
     * 功能：根据订单ID获取订单数据
     * 输入：$order_id：订单ID；
     * 输出：相关订单数据（一维数组）
     */

    public function get_order_by_id($order_id) {
        $this->db->where(" id  = '" . $order_id . "'");
        $query = $this->db->get("order");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_section_by_pid
     * 功能：根据相关ID获取分段数据
     * 输入：$p_id：相关ID；$info_type：分段类型
     * 输出：相关分段数据（多维数组）
     */

    public function get_section_by_pid($p_id, $info_type = 1) {
        $this->db->where(" pid  = '" . $p_id . "'");
        $this->db->where(" info_type  = " . $info_type);
        $this->db->where(" state_flag  = 1");
        $this->db->order_by("order", "asc");
        $query = $this->db->get("tiku_section_info");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_rand_question
     * 功能：根据条件获取随机试题
     * 输入：$num：试题数量；$house_id：题库ID；$point_id：考点ID；$type_id：试题类型ID；
     * 输出：随机试题数据（多维数组）
     */

    public function get_rand_question($num = 1, $house_id = 0, $point_id = 0, $type_id = 0) {
        $where = " audit  = 2";
        if ($house_id > 0) {
            $where .= " and exam_house_id  = '" . $house_id . "'";
        }
        if ($point_id > 0) {
            $where .= " and (exam_point_id  = '" . $point_id . "' or parent_exam_point_id  = '" . $point_id . "' or top_exam_point_id  = '" . $point_id . "')";
        }
        if ($type_id > 0) {
            $where .= " and question_type_id  = '" . $type_id . "'";
        }
        $this->db->where($where);
        $query = $this->db->get("tiku_question");
        $return = $query->result_array();
        if (count($return) > $num) {
            $tmp = array_rand($return, intval($num));
            foreach ($tmp as $t) {
                $result[] = $return[$t];
            }
        } else {
            $result = $return;
        }
        return $result;
    }

    /*
     * 名称：get_material_by_question_id
     * 功能：根据试题ID获取试题材料
     * 输入：$id：试题ID；
     * 输出：试题材料数据（多维数组）
     */

    public function get_material_by_question_id($id) {
        $this->db->where(" question_id  = '" . $id . "'");
        $query = $this->db->get("tiku_question_material");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_answer_by_question_id
     * 功能：根据试题ID获取试题材料
     * 输入：$id：试题ID；
     * 输出：试题材料数据（多维数组）
     */

    public function get_answer_by_question_id($id = 0) {
        if ($id > 0) {
            $this->db->where(" question_id  = '" . $id . "'");
        }
        $this->db->order_by("order", "ASC");
        $query = $this->db->get("tiku_question_choice");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_question_type_by_id
     * 功能：根据试题类型ID获取试题类型数据
     * 输入：$id：试题类型ID；
     * 输出：试题类型数据（一维数组）
     */

    public function get_question_type_by_id($id) {
        $this->db->where(" id  = '" . $id . "'");
        $query = $this->db->get("tiku_question_type");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_question_by_id
     * 功能：根据试题ID获取试题数据
     * 输入：$id：试题ID；
     * 输出：试题数据（一维数组）
     */

    public function get_question_by_id($id) {
        $this->db->where(" id  = '" . $id . "'");
        $query = $this->db->get("tiku_question");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_question_in_id
     * 功能：根据试题ID数组获取试题数据
     * 输入：$id：试题ID数组；
     * 输出：试题数据（多维数组）
     */

    public function get_question_in_id($id = "") {
        if (!empty($id)) {
            $this->db->where_in(" id ", $id);
        }
        $query = $this->db->get("tiku_question");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_sheet_by_sheet_index_id
     * 功能：根据试题集ID和索引ID获取试题集数据
     * 输入：$sheet_id：试题集ID；$index_id：索引ID；
     * 输出：试题集数据（一维数组）
     */

    public function get_sheet_by_sheet_index_id($sheet_id, $index_id = 0) {
        $this->db->where(" id  = '" . $sheet_id . "'");
        if ($index_id > 0) {
            $this->db->where(" index_id  = '" . $index_id . "'");
        }
        $query = $this->db->get("tiku_sheet");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_sheet_question_by_sheet_id
     * 功能：根据试题集ID按照试题集内排序升序获取试题集试题数据
     * 输入：$sheet_id：试题集ID；
     * 输出：试题集试题数据（多维数组）
     */

    public function get_sheet_question_by_sheet_id($sheet_id) {
        $this->db->where(" sheet_id  = '" . $sheet_id . "'");
        $this->db->order_by("sheet_order", "asc");
        $query = $this->db->get("tiku_sheet_question");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_real_question_by_paper_id
     * 功能：根据试卷ID按照试题分段内排序升序和试卷内排序升序获取试题数据
     * 输入：$sheet_id：试卷ID；
     * 输出：试题数据（多维数组）
     */

    public function get_real_question_by_paper_id($paper_id) {
        $this->db->where(" exam_paper_id  = '" . $paper_id . "'");
        $this->db->order_by("section_info_id", "asc");
        $this->db->order_by("order", "asc");
        $query = $this->db->get("tiku_question");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_point_by_house_id
     * 功能：根据题库ID按照排序升序获取考点数据
     * 输入：$house_id：题库ID；
     * 输出：考点数据（多维数组）
     */

    public function get_point_by_house_id($house_id) {
        $this->db->where(" exam_house_id  = '" . $house_id . "'");
        $this->db->where(" state_flag  = 1");
        $this->db->order_by("order", "desc");
        $query = $this->db->get("tiku_exam_point");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_point_by_id
     * 功能：根据考点ID获取考点数据
     * 输入：$id：考点ID；
     * 输出：考点数据（一维数组）
     */

    public function get_point_by_id($id) {
        $this->db->where(" id  = '" . $id . "'");
        $this->db->where(" state_flag  = 1");
        $query = $this->db->get("tiku_exam_point");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_question_num_by_point_id
     * 功能：根据考点ID获取试题数量
     * 输入：$point_id：考点ID；
     * 输出：相关试题数量（整型）
     */

    public function get_question_num_by_point_id($point_id, $real = 0) {
        $this->db->where(" audit  = 2 and (exam_point_id  = '" . $point_id . "' or parent_exam_point_id  = '" . $point_id . "' or top_exam_point_id  = '" . $point_id . "')");
        $query = $this->db->get("tiku_question");
        $result = $query->result_array();
        return count($result);
    }

    /*
     * 名称：get_question_num_by_point_id
     * 功能：根据试卷ID数组获取试题数据
     * 输入：$id_arr：试卷ID数组；
     * 输出：相关试题数据（多维数组）
     */

    public function get_question_in_paper_id($id_arr, $select = "") {
        if (!is_array($id_arr)) {
            $id_arr = array($id_arr);
        }
        $this->db->where_in('exam_paper_id', $id_arr);
        if (!empty($select)) {
            $this->db->select($select);
        }
        $query = $this->db->get("tiku_question");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_point_question_by_qs_user_id
     * 功能：根据用户骑士ID和考点ID获取试题数据
     * 输入：$qs_user_id：用户骑士ID；$point_id：考点ID；$group_by：分组字段；
     * 输出：相关试题数据（多维数组）
     */

    public function get_point_question_by_user_id($user_id, $point_id = 0, $group_by = "") {
        if ($point_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "' and (exam_point_id  = '" . $point_id . "' or parent_exam_point_id  = '" . $point_id . "' or top_exam_point_id  = '" . $point_id . "')");
        } else {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        $query = $this->db->get("tiku_user_sheet_info");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_real_by_house_id
     * 功能：根据题库ID获取试卷分页数据
     * 输入：$house_id：题库ID；$limit：数量；$offset：偏移量；
     * 输出：试卷分页数据（多维数组）
     */

    public function get_paper_in_house_id($house_id = "", $type_id = 0, $limit = 0, $offset = 0) {
        if (!empty($house_id)) {
            $this->db->where(" exam_house_id  IN(" . $house_id . ")");
        }
        $this->db->where(" state_flag  = 1");
        $this->db->where(" audit  = 2");
        if ($type_id > 0) {
            $this->db->where(" is_real  = " . $type_id);
        }
        $this->db->order_by("order", "asc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get("tiku_exam_paper");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_paper_in_id
     * 功能：根据ID获取试卷数据
     * 输入：$id：ID；
     * 输出：试卷数据（多维数组）
     */

    public function get_paper_in_id($id = "") {
        $this->db->where(" id  IN( " . $id . ")");
        $this->db->where(" state_flag  = 1");
        $this->db->where(" audit  = 2");
        $this->db->order_by("order", "desc");
        $query = $this->db->get("tiku_exam_paper");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_real_by_house_id
     * 功能：根据题库ID获取试卷分页数据
     * 输入：$house_id：题库ID；$limit：数量；$offset：偏移量；
     * 输出：试卷分页数据（多维数组）
     */

    public function get_real_by_house_id($house_id, $limit = 0, $offset = 0) {
        $this->db->where(" exam_house_id  = '" . $house_id . "'");
        $this->db->where(" is_real  = 2");
        $this->db->where(" state_flag  = 1");
        $this->db->where(" audit  = 2");
        $this->db->order_by("order", "desc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get("tiku_exam_paper");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_real_total_by_house_id
     * 功能：根据题库ID获取试卷总数
     * 输入：$house_id：题库ID；
     * 输出：试卷总数（整型）
     */

    public function get_real_total_by_house_id($house_id) {
        $this->db->where(" exam_house_id  = '" . $house_id . "'");
        $this->db->where(" is_real  = 2");
        $this->db->where(" audit  = 2");
        $this->db->where(" state_flag  = 1");
        $this->db->order_by("order", "desc");
        return $this->db->count_all_results("tiku_exam_paper");
    }

    /*
     * 名称：get_user_by_paper_id
     * 功能：根据试题集ID和用户骑士ID获取用户试题集数据
     * 输入：$sheet_id：试题集ID；$qs_user_id：用户骑士ID；
     * 输出：用户试题集数据（多维数组）
     */

    public function get_user_by_paper_id($sheet_id, $user_id = 0) {
        $this->db->where(" sheet_id  = '" . $sheet_id . "'");
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        $query = $this->db->get("tiku_user_sheet");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_collection_by_user_id
     * 功能：根据用户骑士ID获取用户收藏数据
     * 输入：$qs_user_id：用户骑士ID；
     * 输出：用户收藏数据（多维数组）
     */

    public function get_user_collection_by_user_id($user_id = 0) {
        $result = array();
        if ($user_id > 0) {
            $this->db->select("question_id");
            $this->db->where(" user_id  = '" . $user_id . "'");
            $query = $this->db->get("tiku_user_collection");
            $arr = $query->result_array();
            if (!empty($arr)) {
                foreach ($arr as $a) {
                    $result[] = $a['question_id'];
                }
            } else {
                $result = $arr;
            }
        }
        return $result;
    }

    /*
     * 名称：get_user_sheet_by_id
     * 功能：根据用户试题集ID获取用户试题集
     * 输入：$user_sheet_id：用户试题集ID；
     * 输出：用户试题集数据（一维数组）
     */

    public function get_user_sheet_by_id($user_sheet_id = 0, $user_id = 0) {
        if ($user_sheet_id > 0) {
            $this->db->where(" id  = '" . $user_sheet_id . "'");
        }
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        $query = $this->db->get("tiku_user_sheet");
        $result = $query->row_array();
        return $result;
    }

    /*
     * 名称：get_user_sheet_by_qs_id
     * 功能：根据用户骑士ID，题库ID，完成状态获取用户试题集分页数据
     * 输入：$qs_user_id：用户骑士ID；$house_id：题库；$is_complete：完成状态；$limit：数量；$offset：偏移量；
     * 输出：用户试题集分页数据（多维数组）
     */

    public function get_user_sheet_by_user_id($user_id = 0, $house_id = 0, $is_complete = 0, $limit = 0, $offset = 0) {
        $this->db->where(" user_id  = '" . $user_id . "'");
        if ($house_id > 0) {
            $this->db->where(" exam_house_id  = '" . $house_id . "'");
        }
        if ($is_complete > 0) {
            $this->db->where(" is_complete  = '" . $is_complete . "'");
        }
        $this->db->order_by("submittime", "desc");
        if ($limit > 0 || $offset > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get("tiku_user_sheet");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_sheet_by_sheet_id
     * 功能：根据试题集ID获取用户试题集数据
     * 输入：$sheet_id：试题集ID；
     * 输出：用户试题集数据（多维数组）
     */

    public function get_user_sheet_by_sheet_id($sheet_id) {
        $this->db->where(" sheet_id  = '" . $sheet_id . "'");
        $query = $this->db->get("tiku_user_sheet");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_sheet_by_index_id
     * 功能：根据索引ID获取用户试题集数据
     * 输入：$index_id：索引ID；
     * 输出：用户试题集数据（多维数组）
     */

    public function get_user_sheet_by_index_id($index_id, $select = "") {
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->where(" index_id  = '" . $index_id . "'");
        $query = $this->db->get("tiku_user_sheet");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_sheet_count_by_index_id
     * 功能：根据索引ID获取用户试题集总数
     * 输入：$index_id：索引ID；
     * 输出：用户试题集总数（整数）
     */

    public function get_user_sheet_count_by_index_id($index_id, $select = "") {
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->where(" index_id  = '" . $index_id . "'");
        return $this->db->count_all_results('tiku_user_sheet');
    }

    /*
     * 名称：get_user_sheet_info_by_user_id
     * 功能：根据用户骑士ID和用户试题集ID获取用户试题集信息数据
     * 输入：$qs_user_id：用户骑士ID；$sheet_id：用户试题集ID；
     * 输出：用户试题集信息数据（多维数组）
     */

    public function get_user_sheet_info_by_user_id($user_id = 0, $sheet_id = 0) {
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        if ($sheet_id > 0) {
            $this->db->where(" user_sheet_id  = '" . $sheet_id . "'");
        }
        $this->db->order_by("addtime", "asc");
        $query = $this->db->get("tiku_user_sheet_info");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_sheet_info_by_question_id
     * 功能：根据试题ID数组获取用户试题集信息数据
     * 输入：$question_id_arr：试题ID数组；
     * 输出：用户试题集信息数据（多维数组）
     */

    public function get_user_sheet_info_by_question_id($question_id_arr = array(), $select = "") {
        $result = FALSE;
        if (!empty($question_id_arr)) {
            if (!empty($select)) {
                $this->db->select($select);
            }
            $this->db->where_in('question_id', $question_id_arr);
            $query = $this->db->get("tiku_user_sheet_info");
            $result = $query->result_array();
        }
        return $result;
    }

    /*
     * 名称：get_user_error_by_qs_question_id
     * 功能：根据用户骑士ID，试题ID，题库ID获取用户错题数据
     * 输入：$qs_user_id：用户骑士ID；$question_id：试题ID；$house_id：题库ID；
     * 输出：用户错题数据（多维数组或一维数组）
     */

    public function get_user_error_by_question_id($user_id = 0, $question_id = 0, $house_id = 0) {
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        if ($question_id > 0) {
            $this->db->where(" question_id  = '" . $question_id . "'");
        }
        if ($house_id > 0) {
            $this->db->where(" exam_house_id  = '" . $house_id . "'");
        }
        $query = $this->db->get("tiku_error_question");
        if ($question_id > 0) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    /*
     * 名称：get_user_collect_by_qs_id
     * 功能：根据用户骑士ID，题库ID获取用户收藏数据
     * 输入：$qs_user_id：用户骑士ID；$house_id：题库ID；
     * 输出：用户收藏数据（多维数组）
     */

    public function get_user_collect_by_user_id($user_id, $house_id = 0) {
        if ($house_id > 0) {
            $this->db->where(" exam_house_id  = '" . $house_id . "'");
        }
        $this->db->where(" user_id  = '" . $user_id . "'");
        $query = $this->db->get("tiku_user_collection");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：is_login
     * 功能：cookie登录
     * 输入：无
     * 输出：用户信息数组
     */

    public function is_login() {
        if (!empty($_COOKIE['user_id']) && !empty($_COOKIE['user_name'])) {
            $this->session->set_userdata(array('user_id' => $_COOKIE['user_id']));
            $this->session->set_userdata(array('user_name' => $_COOKIE['user_name']));
        }
    }

    /*
     * 名称：get_login_info
     * 功能：登录
     * 输入：无
     * 输出：用户信息数组
     */

    public function get_login_info($key) {
        $login_info = FALSE;
        if (!empty($key)) {
            $mem = new Memcache;
            $mem->connect("localhost", 11111);
            $login_arr = $mem->get($key);
            if (!empty($login_arr['uid'])) {
                $login_info['qs_user_id'] = $login_arr['uid'];
                $login_info['user_name'] = $login_arr['username'];
            }
        }
        return $login_info;
    }

    /*
     * 名称：logout
     * 功能：退出登录
     * 输入：无
     * 输出：取消用户登录状态
     */

    public function logout() {
        
    }

    /*
     * 名称：check_login
     * 功能：检查登录状态
     * 输入：无
     * 输出：成功返回用户骑士ID，失败跳转登录页面
     */

    public function check_login() {
        if (!$this->session->userdata('qs_user_id')) {
            Header("Location:" . MAIN_SITE_URL . "user/login.php?tiku_key=" . time() . rand(100, 999) . "&tiku_index=" . $_SESSION['index_name']);
        } else {
            return $this->session->userdata('qs_user_id');
        }
    }

    /*
     * 名称：get_coupons_house
     * 功能：获取优惠卷库数据
     * 输入：$order_by：排序字符串；$state：优惠卷库状态；
     * 输出：优惠卷库数据（多维数组）
     */

    public function get_coupons_house($where = "", $state = 2, $limit = 0, $order_by = "") {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where(" state_flag  = '" . $state . "'");
        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }
        if ($limit > 0) {
            $this->db->limit($limit);
        }
        $query = $this->db->get("coupons_house");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_coupons_section
     * 功能：获取优惠卷库分段数据
     * 输入：$house_id：优惠卷库ID；
     * 输出：优惠卷库分段数据（多维数组）
     */

    public function get_coupons_section($house_id = 0) {
        if ($house_id > 0) {
            $this->db->where(" house_id  = '" . $house_id . "'");
        }
        $query = $this->db->get("coupons_section");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_user_coupons
     * 功能：获取用户优惠卷数据
     * 输入：$qs_id：用户骑士ID；
     * 输出：用户优惠卷数据（一维数组）
     */

    public function get_user_coupons($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where(" user_id  = '" . $user_id . "'");
        }
        $query = $this->db->get("coupons");
        $result = $query->result_array();
        return $result;
    }

    /*
     * 名称：get_news_type
     * 功能：根据分类ID获取分类数据
     * 输入：$id：文章分类ID；
     * 输出：分类数据（多维数组）
     */

    function get_news_type($id = 0) {
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('tiku_news_type');
        return $query->result_array();
    }

    /*
     * 名称：get_news_by_type_id
     * 功能：根据分类ID获取文章数据
     * 输入：$type_id：文章分类ID；$limit：条数；$offset：偏移量；
     * 输出：文章数据（多维数组）
     */

    function get_news_by_type_id($type_id = 0, $limit = 0, $offset = 0) {
        if ($type_id > 0) {
            $this->db->where('type_id', $type_id);
        }
        $this->db->order_by('top', 'desc');
        $this->db->order_by('addtime', 'desc');
        if ($limit > 0 || $offset > 0) {
            $this->db->limit($offset, $limit);
        }
        $query = $this->db->get('tiku_news_info');
        return $query->result_array();
    }

    /*
     * 名称：get_news_num
     * 功能：根据分类ID获取文章数量
     * 输入：$type_id：文章分类ID；
     * 输出：该分类下文章数量（数字）
     */

    function get_news_num($type_id = 0) {
        if ($type_id > 0) {
            $this->db->where('type_id', $type_id);
        }
        return $this->db->count_all_results('tiku_news_info');
    }

    /*
     * 名称：get_news
     * 功能：根据文章ID获取文章数据
     * 输入：$id：文章ID；
     * 输出：文章数据（多维数组）
     */

    function get_news($id = 0) {
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('tiku_news_info');
        return $query->result_array();
    }

    /*
     * 名称：get_add_user
     * 功能：根据条件查询用户数据，若没有提供查询条件即插入新数据并返回用户ID
     * 输入：$where：查询条件数组；
     * 输出：用户数据（一维数组）
     */

    function get_user($where = array()) {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
            $query = $this->db->get('user');
            return $query->row_array();
        }
    }

    function get_sms_verification($phone, $code) {
        $this->db->where('phone', $phone);
        $this->db->where('verification_code', $code);
        $query = $this->db->get('sms_verification');
        $time_arr = $query->row_array();
        $time = $time_arr['add_time'] + 60;
        if (time() < $time) {
            return $time_arr;
        } else {
            return "";
        }
    }

    public function get_wechat_verification($verification_code) {
        $this->db->where('verification_code', $verification_code);
        $query = $this->db->get('wechat_verification');
        return $query->row_array();
    }

}
