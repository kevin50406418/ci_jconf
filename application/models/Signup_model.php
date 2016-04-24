<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Signup_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function get_prices($conf_id){
		$this->db->from("signup_price");
		$this->db->join("signup_type","signup_price.type_id = signup_type.type_id");
		$this->db->where("signup_price.conf_id",$conf_id);
		return $this->db->get()->result();
	}

	function get_price_types($conf_id){
		$this->db->from("signup_type");
		$this->db->where("conf_id",$conf_id);
		return $this->db->get()->result();
	}

	function add_signup($conf_id,$signup){
		$defaults = array(
			"conf_id"         => $conf_id,
			"user_name"       => "",
			"user_gender"     => "",
			"user_food"       => "",
			"user_org"        => "",
			"user_title"      => "",
			"user_phone"      => "",
			"user_email"      => "",
			"receipt_header"  => "",
			"signup_type"     => "",
			"price_id"        => "",
			"price_type"      => "",
			"paper_title"     => "",
			"paper_id"        => "",
			"user_pass"       => "",
			"user_note"       => "",
			"signup_price"    => "",
			"signup_status"   => 0,
			"signup_time"     => time(),
			"signup_filename" => "",
			"signup_filetime" => 0
		);
		$signup = parse_args($signup, $defaults);
		$signup['user_pass']       = hash('sha256',$signup['user_pass']);
		$signup['paper_id']        = empty($signup['paper_id'])?NULL:$signup['paper_id'];
		return $this->db->insert('conf_signup', $signup);
	}

	function signup_valid($reg_paper=0,$prices){
		$prices_list = array();
		foreach ($prices as $key => $price) {
			array_push($prices_list,$price->type_id."|".$price->price_id."|o");
			array_push($prices_list,$price->type_id."|".$price->price_id."|t");
			array_push($prices_list,$price->type_id."|".$price->price_id."|s");
		}
		$valid_prices_list = implode(',',$prices_list);
		$this->form_validation->set_rules("user_name", "姓名", 'required');
		$this->form_validation->set_rules("user_gender", "性別", 'required|in_list[0,1]',array('in_list' => '請填寫正確的性別'));
		$this->form_validation->set_rules("user_food", "飲食習慣", 'required|in_list[0,1]',array('in_list' => '請填寫正確的飲食習慣'));
		$this->form_validation->set_rules("user_org", "服務單位", 'required');
		$this->form_validation->set_rules("user_title", "身分職稱", 'required');
		$this->form_validation->set_rules("user_phone", "聯絡電話", 'required');
		$this->form_validation->set_rules("user_email", "E-Mail", 'required|valid_email');
		$this->form_validation->set_rules("receipt_header", "收據抬頭", 'required');
		$this->form_validation->set_rules("price_type", "註冊類型", 'required|in_list['.$valid_prices_list.']',array('in_list' => '請選擇以下註冊類型'));
		$this->form_validation->set_rules("reg_paper", "是否註冊論文?", 'required');
		if( $reg_paper ){
			$this->form_validation->set_rules("paper_id", "論文編號", 'required|is_natural',array('is_natural' => '請輸入正確的論文編號'));
			$this->form_validation->set_rules("paper_title", "論文標題", 'required');
		}
		// $this->form_validation->set_rules("dinner_num", "晚宴卷", 'required|is_natural',array('is_natural' => '請輸入正確的晚宴卷數量'));
		if( $this->user->is_login() ){
			$this->form_validation->set_rules("user_pass", "密碼", 'required');
			$this->form_validation->set_rules("user_pass2", "驗證密碼", 'required|matches[user_pass]');
		}
	}

	function update_signup_valid($prices){
		$prices_list = array();
		foreach ($prices as $key => $price) {
			array_push($prices_list,$price->type_id."|".$price->price_id."|o");
			array_push($prices_list,$price->type_id."|".$price->price_id."|t");
			array_push($prices_list,$price->type_id."|".$price->price_id."|s");
		}
		$valid_prices_list = implode(',',$prices_list);
		$this->form_validation->set_rules("user_name", "姓名", 'required');
		$this->form_validation->set_rules("user_gender", "性別", 'required|in_list[0,1]',array('in_list' => '請填寫正確的性別'));
		$this->form_validation->set_rules("user_food", "飲食習慣", 'required|in_list[0,1]',array('in_list' => '請填寫正確的飲食習慣'));
		$this->form_validation->set_rules("user_org", "服務單位", 'required');
		$this->form_validation->set_rules("user_title", "身分職稱", 'required');
		$this->form_validation->set_rules("user_phone", "聯絡電話", 'required');
		$this->form_validation->set_rules("user_email", "E-Mail", 'required|valid_email');
		$this->form_validation->set_rules("receipt_header", "收據抬頭", 'required');
		$this->form_validation->set_rules("price_type", "註冊類型", 'required|in_list['.$valid_prices_list.']',array('in_list' => '請選擇以下註冊類型'));
		
	}

	function cal_signup_price($conf_id,$price_type,$signup=NULL){
		$prices        = $this->signup->get_prices($conf_id);
		$table         = array();
		$now           = time();
		$early_bird    = $this->conf->get_schedule($conf_id,"early_bird");
		$is_early_bird = false;
		if( is_null($signup) ){
			if( $this->is_early_bird($early_bird->start_value,$early_bird->end_value,$now)){
				$is_early_bird = true;
			}
		}else{
			if( $this->is_early_bird($early_bird->start_value,$early_bird->end_value,$signup->signup_time)){
				$is_early_bird = true;
			}
		}
		foreach ($prices as $key => $price) {
			$table[$price->type_id."|".$price->price_id."|o"] = $is_early_bird?$price->early_other:$price->other_price;
			$table[$price->type_id."|".$price->price_id."|t"] = $is_early_bird?$price->early_teacher:$price->teacher_price;
			$table[$price->type_id."|".$price->price_id."|s"] = $is_early_bird?$price->early_student:$price->student_price;
		}
		return element($price_type, $table, 0);
	}

	function login($conf_id,$user_email,$user_pass){
		$this->db->from('conf_signup');
		$this->db->where('user_email', $user_email);
		$this->db->where('user_pass', hash('sha256',$user_pass));
		if( $this->db->get()->num_rows() > 1 ){
			$this->session->set_tempdata('signup_email_'.$conf_id, $user_email, 900);
			$this->session->set_tempdata('signup_pass_'.$conf_id, hash('sha256',$user_pass), 900);
			return true;
		}else{
			return false;
		}
	}

	function is_login($conf_id){
		if( $this->user->is_login() ){
			if( !$this->session->has_userdata('signup_email_'.$conf_id) ){
				$user = $this->user->get_user_info($this->user_login);
				$this->session->set_tempdata('signup_email_'.$conf_id, $user->user_email, 900);
				return true;
			}else{
				return $this->session->has_userdata('signup_email_'.$conf_id);
			}
		}else{
			return $this->session->has_userdata('signup_email_'.$conf_id) && $this->session->has_userdata('signup_pass_'.$conf_id);
		}
	}

	function logout($conf_id){
		$this->session->unset_userdata('signup_email_'.$conf_id);
		$this->session->unset_userdata('signup_pass_'.$conf_id);
	}

	function get_lists($conf_id){
		$user_email = $this->session->userdata('signup_email_'.$conf_id);
		$user_pass  = $this->session->userdata('signup_pass_'.$conf_id);
		$this->db->from('conf_signup');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_email', $user_email);
		if( !$this->user->is_login() ){
			$this->db->where('user_pass', $user_pass);
		}
		return $this->db->get()->result();
	}

	function signup_status($status,$text_mode=false){
		$class = "";
		$text  = "";
		switch($status){
			case 0:
				$class = "orange";
				$text  = "繳費記錄上傳中";
			break;
			case 1:
				$class = "blue";
				$text  = "繳費記錄已上傳";
			break;
			case 2:
				$class = "gray";
				$text  = "註冊失敗";
			break;
			case 3:
				$class = "green";
				$text  = "註冊成功";
			break;
		}
		if( !$text_mode ){
			return '<div class="ui '.$class.' horizontal label">'.$text.'</div>';
		}else{
			return $text;
		}
	}

	function signup_type($type,$text_mode=false){
		$text  = "";
		switch($type){
			case "s":
				$text  = "學生";
			break;
			case "t":
				$text  = "教師";
			break;
			case "o":
				$text  = "一般人士";
			break;
		}
		if( !$text_mode ){
			return '<div class="ui gray horizontal label">'.$text.'</div>';
		}else{
			return $text;
		}
	}

	function is_early_bird($start,$end,$time){
		return ($time >= $start && $time < ($end+86400));
	}

	function update_signup_file($conf_id,$signup_id,$filename){
		$user_email = $this->session->userdata('signup_email_'.$conf_id);
		$user_pass = $this->session->userdata('signup_pass_'.$conf_id);
		$signup = array(
			"signup_filename" => $filename,
			"signup_filetime" => time(),
			"signup_status"   => 1
		);
		$this->db->where('signup_id', $signup_id);
		$this->db->where('user_email', $user_email);
		if( $this->user->is_login() ){
			$this->db->where('user_pass', $user_pass);
		}
		$this->db->where('signup_status', 0);
		$this->db->where('conf_id', $conf_id);
		return $this->db->update('conf_signup', $signup);
	}

	function update_signup($conf_id,$signup_id,$signup){
		$defaults = array(
			"user_name"       => "",
			"user_gender"     => "",
			"user_food"       => "",
			"user_org"        => "",
			"user_title"      => "",
			"user_phone"      => "",
			"user_email"      => "",
			"receipt_header"  => "",
			"signup_type"     => "",
			"price_id"        => "",
			"price_type"      => "",
			"paper_title"     => "",
			"paper_id"        => "",
			"signup_price"    => ""
		);
		$signup = parse_args($signup, $defaults);
		$signup['paper_id']        = empty($signup['paper_id'])?NULL:$signup['paper_id'];
		$signup['signup_memberid'] = empty($signup['signup_memberid'])?NULL:$signup['signup_memberid'];
		$this->db->where('signup_id', $signup_id);
		$this->db->where('conf_id', $conf_id);

		if( $this->db->update('conf_signup', $signup) ){
			$signup['signup_id'] = $signup_id;
			$this->conf->add_log("conf","update_signup",$conf_id,$signup);
			return true;
		}else{
			return false;
		}
	}

	function update_signup_passwd($conf_id,$signup_id,$passwd){
		$signup = array(
			"user_pass" => hash('sha256',$passwd)
		);
		$this->db->where('signup_id', $signup_id);
		$this->db->where('conf_id', $conf_id);
		if( $this->db->update('conf_signup', $signup) ){
			$signup['signup_id'] = $signup_id;
			$this->conf->add_log("conf","update_signup_passwd",$conf_id,$signup);
			return true;
		}else{
			return false;
		}
	}

	function update_signup_status($conf_id,$signup_id,$signup_status){
		$signup = array(
			"signup_status" => $signup_status
		);
		$this->db->where('signup_id', $signup_id);
		$this->db->where('conf_id', $conf_id);
		if( $this->db->update('conf_signup', $signup) ){
			$signup['signup_id'] = $signup_id;
			$this->conf->add_log("conf","update_signup_status",$conf_id,$signup);
			return true;
		}else{
			return false;
		}
	}

	function add_signup_type($conf_id,$type_name){
		$signup_type = array(
			"conf_id"   => $conf_id,
			"type_name" => $type_name,
		);
		if( $this->db->insert('signup_type', $signup_type) ){
			$this->conf->add_log("conf","add_signup_type",$conf_id,$signup_type);
			return true;
		}else{
			return false;
		}
	}

	function add_signup_price($conf_id,$signup_price){
		$defaults = array(
			"conf_id"       => $conf_id,
			"type_id"       => "",
			"other_price"   => 0,
			"teacher_price" => 0,
			"student_price" => 0,
			"early_other"   => 0,
			"early_teacher" => 0,
			"early_student" => 0
		);
		$signup_price = parse_args($signup_price, $defaults);
		if( $this->db->insert('signup_price', $signup_price) ){
			$this->conf->add_log("conf","add_signup_price",$conf_id,$signup_price);
			return true;
		}else{
			return false;
		}
	}

	function update_signup_price($conf_id,$type_id,$other_price,$teacher_price,$student_price,$early_other,$early_teacher,$early_student){
		foreach ($teacher_price as $price_id => $teacher) {
			$signup_price = array(
				"type_id"       => $type_id[$price_id],
				"other_price"   => $other_price[$price_id],
				"teacher_price" => $teacher_price[$price_id],
				"student_price" => $student_price[$price_id],
				"early_other"   => $early_other[$price_id],
				"early_teacher" => $early_teacher[$price_id],
				"early_student" => $early_student[$price_id]
			);
			$this->db->where('price_id', $price_id);
			$this->db->where('conf_id', $conf_id);
			if( !$this->db->update('signup_price', $signup_price) ){
				return false;
			}
		}
		return true;
	}

	function update_signup_type($conf_id,$type_name){
		foreach ($type_name as $type_id => $name) {
			$signup_type = array(
				"type_name" => $name
			);
			$this->db->where('type_id', $type_id);
			$this->db->where('conf_id', $conf_id);
			if( !$this->db->update('signup_type', $signup_type) ){
				return false;
			}
		}
		return true;
	}

}