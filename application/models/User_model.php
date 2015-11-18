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
			$this->get_auth($username);
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

	function is_conf($conf_id=''){
		if(empty($conf_id)){
			return false;
		}else{
			if(!$this->is_sysop()){
				$priv_conf = $this->session->priv_conf;
				return in_array($conf_id,$priv_conf);
			}else{
				return true;
			}
		}
	}

	function is_topic($conf_id=''){
		if(empty($conf_id)){
			return false;
		}else{
			if(!$this->is_sysop()){
				$priv_topic = $this->session->priv_topic;
				return in_array($conf_id,$priv_topic);
			}else{
				return true;
			}
		}
	}

	function is_reviewer($conf_id=''){
		if(empty($conf_id)){
			return false;
		}else{
			if(!$this->is_sysop()){
				$priv_reviewer = $this->session->priv_reviewer;
				return in_array($conf_id,$this->session->priv_reviewer);
			}else{
				return true;
			}
		}
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
			$this->db->where('user_staus', 2);
		}else if($user_staus == 10){
			$staus = array(0, 2);
			$this->db->where_in('user_staus', $staus);
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

	function add_conf($conf_id,$user_login){
		$admin = array(
			"conf_id"    =>$conf_id,
			"user_login" =>$user_login,
			"auth_time"  =>time()
		);
		if( $this->db->insert('auth_conf', $admin) ){
			$this->conf->add_log("conf","add_conf_admin",$conf_id,$admin);
			return true;
		}
		return false;
	}

	function del_conf($conf_id,$user_login){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		if( $this->db->delete('auth_conf') ){
			$this->conf->add_log("conf","del_conf_admin",$conf_id,array('user_login'=>$user_login));
			return true;
		}
		return false;
	}

	function add_reviewer($conf_id,$user_login){
		$reviewer = array(
			"conf_id"    =>$conf_id,
			"user_login" =>$user_login,
			"auth_time"  =>time()
		);
		if( $this->db->insert('auth_reviewer', $reviewer) ){
			$this->conf->add_log("conf","add_reviewer",$conf_id,$reviewer);
			return true;
		}
		return false;
	}

	function del_reviewer($conf_id,$user_login){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		if( $this->db->delete('auth_reviewer') ){
			$this->conf->add_log("conf","del_reviewer",$conf_id,array('user_login'=>$user_login));
			return true;
		}
		return false;
	}

	function get_conf($conf_id){
		$this->db->from('auth_conf');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_reviewer($conf_id){
		$this->db->from('auth_reviewer');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_conf_array($conf_id){
		$users_array = $this->get_conf($conf_id);
		$users = array();
		foreach ($users_array as $key => $user) {
			array_push($users,$user->user_login);
		}
		return $users;
	}

	function get_reviewer_array($conf_id){
		$users_array = $this->get_reviewer($conf_id);
		$users = array();
		foreach ($users_array as $key => $user) {
			array_push($users,$user->user_login);
		}
		return $users;
	}

	function user_valid(){
		$this->form_validation->set_rules('user_email', '電子信箱', 'required|valid_email');
	    $this->form_validation->set_rules('user_title', '稱謂', 'required');
	    $this->form_validation->set_rules('user_firstname', '名字', 'required');
	    $this->form_validation->set_rules('user_lastname', '姓氏', 'required');
	    $this->form_validation->set_rules('user_gender', '性別', 'required');
	    $this->form_validation->set_rules('user_org', '所屬機構', 'required');
	    $this->form_validation->set_rules('user_phoneO_1', '電話(公)', 'required');
	    $this->form_validation->set_rules('user_phoneO_2', '電話(公)', 'required');
	    $this->form_validation->set_rules('user_postcode', '郵遞區號', 'required');
	    $this->form_validation->set_rules('user_postadd', '聯絡地址', 'required');
	    $this->form_validation->set_rules('user_country', '國別', 'required');
	    $this->form_validation->set_rules('user_lang', '語言', 'required');
	    $this->form_validation->set_rules('user_title', '研究領域', 'required|min_length[1]');
	}

	function change_passwd($user_login,$user_pass,$login_staus=2){
		$user = array(
			"user_pass" => hash('sha256',$user_pass)
		);
		$this->db->where('user_login', $user_login);
		
		if( $this->db->update('users', $user) ){
			if( $login_staus==2 ){
				$this->add_login_log($user_login,2);
			}else if( $login_staus==3 ){
				$this->add_login_log($user_login,3);
			}
			return true;
		}else{
			return false;
		}
	}

	function generator_password($password_len){
		$password = '';
	    $word = 'abcdefghijkmnpqrstuvwxyz!@#$%^&*()-=ABCDEFGHIJKLMNPQRSTUVWXYZ<>;{}[]23456789';
	    $len = strlen($word);

	    for ($i = 0; $i < $password_len; $i++) {
	        $password.= $word[rand() % $len];
	    }
	    return $password;
	}

	function get_auth($user_login){
		$priv_conf = array();
		$priv_topic = array();
		$priv_reviewer = array();

		//auth_conf
		$this->db->from("auth_conf");
		$this->db->where("user_login",$user_login);
		$query = $this->db->get();
        $auth_confs = $query->result();
        if(is_array($auth_confs)){
	        foreach ($auth_confs as $key => $auth_conf) {
	        	if(!in_array($auth_conf->conf_id,$priv_conf)){
	        		array_push($priv_conf,$auth_conf->conf_id);
	        	}
	        }
        }

        //auth_topic
        $this->db->select("distinct(conf_id)");
        $this->db->from("auth_topic");
		$this->db->where("user_login",$user_login);
		$query = $this->db->get();
        $auth_topics = $query->result();
        if(is_array($auth_topics)){
	        foreach ($auth_topics as $key => $auth_topic) {
	        	if(!in_array($auth_topic->conf_id,$priv_topic)){
	        		array_push($priv_topic,$auth_topic->conf_id);
	        	}
	        }
        }

        //auth_reviewer
        $this->db->from("auth_reviewer");
		$this->db->where("user_login",$user_login);
		$query = $this->db->get();
        $auth_reviewers = $query->result();
        if(is_array($auth_reviewers)){
	        foreach ($auth_reviewers as $key => $auth_reviewer) {
	        	if(!in_array($auth_reviewer->conf_id,$priv_reviewer)){
	        		array_push($priv_reviewer,$auth_reviewer->conf_id);
	        	}
	        }
        }
		$_SESSION['priv_conf']     = $priv_conf;
		$_SESSION['priv_topic']    = $priv_topic;
		$_SESSION['priv_reviewer'] = $priv_reviewer;
        $this->session->mark_as_temp('priv_conf', 600);
        $this->session->mark_as_temp('priv_topic', 600);
        $this->session->mark_as_temp('priv_reviewer', 600);
	}

	function passwd_reset($user_login,$user_email,$g_recaptcha_response){
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lf-HgITAAAAAK8nwI1ZjVq_6IitifEueos00VUn&response=".$g_recaptcha_response);
		$response=json_decode($response);

		if($response->success){
			$this->db->from('users');
			$this->db->where('user_login', $user_login);
			$this->db->where('user_email', $user_email);
			$this->db->where('user_staus', 0);
			$this->db->limit(1);

			$query=$this->db->get();
			
			if($query->num_rows() == 1){
				$this->add_login_log($user_login,3);
				$reset_token = md5(uniqid());
				$this->add_reset_token($user_login,$reset_token);
				return $this->send_resetpwd_mail($user_login,$user_email,$reset_token);
			}else{
				return false;
			}
		}else{
			$this->alert->show("d","reCAPTCHA error");
		}
	}

	function add_reset_token($user_login,$reset_token){
		$reset_token = array(
			"user_login"     => $user_login,
			"reset_token"    => $reset_token,
			"reset_failtime" => time()+3600
		);
		return $this->db->insert('login_reset', $reset_token);
	}

	function send_resetpwd_mail($user_login,$user_email,$reset_token){
		$time = date("Y-m-d H:i:s",time());
		$site_name = $this->config->item('site_name');
    	$message = "會員 ".$user_login." 您好,<br><br>您於 ".$time." 送出重置密碼請求，重置訊息如下：<br>".base_url("user/reset/".$user_login."/".$reset_token)."<br>(若非本人所提出的請求，請忽略本信件)<br><br>".$site_name;
    	// sp("TO:".$user_email."\n".$message);
    	
    	$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($user_email);
		$this->email->subject('[重設密碼]'.$site_name.'重設密碼');
		$this->email->message($message);

		return $this->email->send();
	}

	function get_reset_token($user_login,$reset_token){
		$this->db->from('login_reset');
		$this->db->where('user_login', $user_login);
		$this->db->where('reset_token', $reset_token);
		$query=$this->db->get();
		return $query->row();
	}

	function set_reset_token($user_login,$reset_token){
		$login_reset = array(
			"reset_staus" => 1
		);
		$this->db->where('user_login', $user_login);
		$this->db->where('reset_token', $reset_token);
		return $this->db->update('login_reset', $login_reset);
	}

}
?>