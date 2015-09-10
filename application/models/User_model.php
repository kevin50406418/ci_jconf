<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function login($username, $password){
		$this->db->select('user_login, user_sysop');
		$this->db->from('users');
		$this->db->where('user_login', $username);
		$this->db->where('user_pass', hash('sha256',$password));
		$this->db->where('user_staus', 0);
		$this->db->limit(1);

		$query=$this->db->get();
		
		if($query->num_rows() == 1){
			$result = $query->row_array();
			$this->add_login_log($username,1);
			$this->session->set_userdata('user_login', $result['user_login']);
			$this->session->set_userdata('user_sysop', $result['user_sysop']);

			return true;
		}else{
			$this->add_login_log($username,0);
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

	function username_exists($user_login){
		$this->db->from('users');
		$this->db->where("user_login",$user_login);
		if( $this->db->count_all_results() >0 ){
            return true;
        }else{
            return false;
        }
	}

	function email_exists($user_email){
		$this->db->from('users');
		$this->db->where("user_email",$user_email);
		if( $this->db->count_all_results() >0 ){
            return true;
        }else{
            return false;
        }
	}

	function email_exists_userlogin($user_email,$user_login){
		$this->db->from('users');
		$this->db->where("user_login",$user_login);
		$this->db->where("user_email",$user_email);
		if( $this->db->count_all_results() >0 ){
            return true;
        }else{
            return false;
        }
	}

	function adduser($user_login,$user_pass,$user_title,$user_email,$user_first_name,$user_last_name,$user_gender,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research){
		$return = array(
			"status" => false,
			"error" => ""
		);
		$user = array(
			"user_login" => $user_login,
			"user_pass" => hash('sha256',$user_pass),
			"user_title" => $user_title,
			"user_email" => $user_email,
			"user_register" => time(),
			"user_staus" => 0,
			"user_first_name" => $user_first_name,
			"user_last_name" => $user_last_name,
			"user_gender" => $user_gender,
			"user_org" => $user_org,
			"user_phone_o" => $user_phone_o,
			"user_cellphone" => $user_cellphone,
			"user_fax" => $user_fax,
			"user_postcode" => $user_postcode,
			"user_postaddr" => $user_postaddr,
			"user_country" => $user_country,
			"user_lang" => $user_lang,
			"user_research" => $user_research,
			"user_sysop" => 0		
		);
		
		if( $this->username_exists($user_login) ){
			$return["error"] = "The account '".$user_login."' is exist.";
			return $return;
		}

		if( $this->email_exists($user_email) ){
			$return["error"] = "Email is exist. If you are not signup this email,please contact system administrator.";
			return $return;
		}

		if( $this->db->insert('users', $user) ){
			$return = array(
				"status" => true,
				"error" => ""
			);
        }else{
           $return = array(
				"status" => false,
				"error" => "Database error! Contact System Adminstritor."
			);
        }
        return $return;
	}

	function updateuser($user_login,$user_title,$user_email,$user_first_name,$user_last_name,$user_gender,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research){
		$return = array(
			"status" => false,
			"error" => ""
		);
		$user = array(
			"user_login" => $user_login,
			"user_title" => $user_title,
			"user_email" => $user_email,
			"user_first_name" => $user_first_name,
			"user_last_name" => $user_last_name,
			"user_gender" => $user_gender,
			"user_org" => $user_org,
			"user_phone_o" => $user_phone_o,
			"user_cellphone" => $user_cellphone,
			"user_fax" => $user_fax,
			"user_postcode" => $user_postcode,
			"user_postaddr" => $user_postaddr,
			"user_country" => $user_country,
			"user_lang" => $user_lang,
			"user_research" => $user_research,	
		);

		if( !$this->email_exists_userlogin($user_email,$user_login) ){
			if($this->email_exists($user_email)){
				$return["error"] = "Email is exist. If you are not signup this email,please contact system administrator.";
				return $return;
			}
		}
		$this->db->where('user_login', $user_login);
		if( $this->db->update('users', $user) ){
			$return = array(
				"status" => true,
				"error" => ""
			);
        }else{
           $return = array(
				"status" => false,
				"error" => "Database error! Contact System Adminstritor."
			);
        }
        return $return;
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

	function get_gravatar( $email, $s = 80, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
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

	function get_all_users($user_staus=-1){
		$this->db->from('users');
		if($user_staus == 0){//get can use users
			$this->db->where('user_staus', 0);
		}else if($user_staus == 1){//get banned users
			$this->db->where('user_staus', 1);
		}else if($user_staus == 2){//get check users
			$this->db->where('user_staus', 1);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function add_login_log($login_user,$staus){
		if ($this->agent->is_browser()){
	        $browser = $this->agent->browser().' '.$this->agent->version();
	        $agent = "pc";
		}elseif ($this->agent->is_robot()){
	        $browser = $this->agent->robot();
	        $agent = "ro";
		}elseif ($this->agent->is_mobile()){
	        $browser = $this->agent->mobile();
	        $agent = "mo";
		}else{
	        $browser = 'Unidentified User Agent';
	        $agent = "un";
		}
		$log=array(
			"login_user"     => $login_user,
			"login_time"     => time(),
			"login_staus"    => $staus,
			"login_ip"       => $this->input->ip_address(),
			"login_host"     => $this->input->server('HTTP_HOST'),
			"login_agent"    => $this->agent->agent_string(),
			"login_platform" => $this->agent->platform(),
			"login_browser"  => $browser,
			"login_agent"    => $agent,
			"sessions_id"    => session_id()
		);
		return $this->db->insert("login_log", $log);
	}

	function get_login_log($login_user){
		$this->db->from('login_log');
		$this->db->where('login_user', $login_user);
		$this->db->order_by('login_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function get_clang(){
		if( !$this->session->has_userdata('lang') ){
			$languages = $this->agent->languages();
			switch($languages[0]){
				case "zhtw":
				case "zh-tw":
				case "tw":
				case "zh":
					$lang = "zhtw";
				break;
				default:
				case "en-us":
				case "en":
					$lang = "en";
				break;
			}
			$this->session->set_userdata('lang', $lang);
			return $lang;
		}else{
			return $this->session->lang;
		}
	}

	function get_nowlang(){
		return $this->get_clang();
	}
}
?>