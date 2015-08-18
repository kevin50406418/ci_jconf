<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function login($username, $password){
		$this->db->select('user_login, user_sysop');
		$this->db->from('users');
		$this->db->where('user_login', $username);
		$this->db->where('user_pass', MD5($password));
		$this->db->limit(1);

		$query=$this->db->get();
		
		if($query->num_rows() == 1){
			$result = $query->row_array();
			
			$this->session->set_userdata('user_login', $result['user_login']);
			$this->session->set_userdata('user_sysop', $result['user_sysop']);

			return true;
		}else{
			return false;
		}
	}


    function is_login(){
		if($this->session->has_userdata('user_login')){
			return true;
		}else{
			return false;
		}
	}

	function is_sysop(){
		if($this->session->has_userdata('user_sysop')){
			if( $this->session->user_sysop == 1 ){
				return true;
			}else{
				return false;
			}
			return true;
		}else{
			return false;
		}
	}

	function is_conf(){
		return false;
	}

	function is_topic(){
		return false;
	}

	function is_reviewer(){
		return false;
	}

	function username_exists( $user_login ){

	}

	function email_exists($user_email){

	}

	function adduser($user){

	}

	function get_user_info($user_login){
		$this->db->from('users');
		$this->db->where('user_login', $user_login);
		$query = $this->db->get();
		return $query->row();
	}

	function email_find($user_email){
		$this->db->select('user_login');
		$this->db->from('users');
		$this->db->where('user_email', $user_email);
		$query = $this->db->get();
		return $query->row_array();
	}

	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	    $url = '//s.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	
}
?>