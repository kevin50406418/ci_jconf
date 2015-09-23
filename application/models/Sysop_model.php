<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Sysop_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }
    function is_sysop_login(){
    	if($this->session->has_userdata('sysop_login')){
			if( $this->session->sysop_login+900 > time() ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
    }

    function sysop_login($user_pass){
    	$user_login = $this->session->user_login;
		$this->db->from('users');
		$this->db->where('user_login', $user_login);
		$this->db->where('user_pass', hash('sha256',$user_pass));
		$this->db->where('user_sysop', 1);
		$this->db->limit(1);
		$query=$this->db->get();
		if($query->num_rows() == 1){
			$this->session->set_tempdata('sysop_login', time(), 900);
			return true;
		}else{
			return false;
		}
    }

    function add_sysop_time(){
    	$this->session->set_tempdata('sysop_login', time(), 900);
    }

    function logout(){
    	$this->session->set_tempdata('sysop_login', time()-900, 0);
    	$this->session->unset_tempdata('sysop_login');
    }

    function set_sysop($user_login,$set){
    	$user = array(
			"user_sysop" => $set
		);
    	$this->db->where('user_login', $user_login);
    	if( $this->db->update('users', $user) ){
			return true;
		}else{
			return false;
		}
    }

    function notice_passwd($user_login,$user_pass,$user_email){
    	$site_name = $this->config->item('site_name');
    	$message = "使用者 ".$user_login." 您好,<br><br>以下是由系統管理員由系統控制台操作變更之密碼，密碼變更資訊如下：<br><br><strong>".$user_pass."</strong><br><br>請藉由本密碼登入系統，並請登入後於系統中更改密碼。<br><br>".$site_name;

    	$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($user_email);
		$this->email->subject('[系統提醒]密碼變更');
		$this->email->message($message);

		return $this->email->send();
    }
}