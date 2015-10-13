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
}