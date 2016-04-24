<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function login($username, $password){
		$this->db->select('user_login, user_sysop');
		$this->db->from('users');
		$this->db->where('user_login', $username);
		$this->db->or_where('user_email', $username);
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
		return $this->session->has_userdata('user_login');
	}

	function is_sysop(){
		if($this->session->has_userdata('user_sysop')){
			return $this->session->user_sysop;
		}else{
			return false;
		}
	}

	function is_conf($conf_id=''){
		if( !$this->is_login() )return false;
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
				if( !is_array($priv_topic) ){
					return false;
				}
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
				if( !is_array($priv_reviewer) ){
					return false;
				}
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

	function adduser($user_login,$user_pass,$user_email,$user_firstname,$user_middlename,$user_lastname,$user_gender,$user_title,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research){
		$return = array(
			"status" => false,
			"error"  => ""
		);
		$user = array(
			"user_login"       => $user_login,
			"user_pass"        => hash('sha256',$user_pass),
			"user_title"       => $user_title,
			"user_email"       => $user_email,
			"user_register"    => time(),
			"user_staus"       => 0,
			"user_first_name"  => $user_firstname,
			"user_middle_name" => $user_middlename,
			"user_last_name"   => $user_lastname,
			"user_gender"      => $user_gender,
			"user_org"         => $user_org,
			"user_title"       => $user_title,
			"user_phone_o"     => $user_phone_o,
			"user_cellphone"   => $user_cellphone,
			"user_fax"         => $user_fax,
			"user_postcode"    => $user_postcode,
			"user_postaddr"    => $user_postaddr,
			"user_country"     => $user_country,
			"user_lang"        => $user_lang,
			"user_research"    => $user_research,
			"user_sysop"       => 0		
		);
		
		if( $this->username_exists($user_login) ){
			$return["error"] = sprintf(lang('alert_username_exists'),$user_login);
			return $return;
		}

		if( $this->email_exists($user_email) ){
			$return["error"] = sprintf(lang('alert_email_exists'),$user_email);
			return $return;
		}

		if( $this->db->insert('users', $user) ){
			$return = array("status" => true,"error" => "");
        }else{
           $return = array(
				"status" => false,
				"error" => "Database error! Contact System Adminstritor."
			);
        }
        return $return;
	}

	function updateuser($user_login,$user_email,$user_first_name,$user_middle_name,$user_last_name,$user_gender,$user_org,$user_title,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research,$old_email){
		$return = array(
			"status" => false,
			"error"  => ""
		);
		$user = array(
			"user_login"      => $user_login,
			"user_title"      => $user_title,
			"user_email"      => $user_email,
			"user_first_name" => $user_first_name,
			"user_middle_name" => $user_middle_name,
			"user_last_name"  => $user_last_name,
			"user_gender"     => $user_gender,
			"user_org"        => $user_org,
			"user_title"      => $user_title,
			"user_phone_o"    => $user_phone_o,
			"user_cellphone"  => $user_cellphone,
			"user_fax"        => $user_fax,
			"user_postcode"   => $user_postcode,
			"user_postaddr"   => $user_postaddr,
			"user_country"    => $user_country,
			"user_lang"       => $user_lang,
			"user_research"   => $user_research	
		);

		if( $old_email != $user_email ){
			if($this->email_exists($user_email)){
				$return["error"] = lang('update_email_exists');
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

	function get_login_log($login_user,$user_email){
		$this->db->from('login_log');
		$this->db->where('login_user', $login_user);
		$this->db->or_where('login_user', $user_email);
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

	function get_topic($conf_id){
		$this->db->from('auth_topic');
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

	function get_topic_array($conf_id){
		$users_array = $this->get_topic($conf_id);
		$users = array();
		foreach ($users_array as $key => $user) {
			array_push($users,$user->user_login);
		}
		return $users;
	}

	function user_valid(){
		$this->form_validation->set_rules('user_id', lang('account'), 'required|min_length[6]');
		$this->form_validation->set_rules('user_pw', lang('password'), 'required|min_length[6]');
		$this->form_validation->set_rules('user_pw2', lang('confirm_password'), 'required|matches[user_pw]|min_length[6]');
		$this->form_validation->set_rules('user_email', lang('user_email'), 'required|valid_email');
		$this->form_validation->set_rules('user_firstname', lang('user_firstname'), 'required');
		$this->form_validation->set_rules('user_lastname', lang('user_lastname'), 'required');
		$this->form_validation->set_rules('user_gender', lang('user_gender'), 'required');
		$this->form_validation->set_rules('user_org', lang('user_org'), 'required');
		$this->form_validation->set_rules('user_title', lang('user_title'), 'required');
		$this->form_validation->set_rules('user_phoneO', lang('user_phoneO'), 'required');
		$this->form_validation->set_rules('user_postcode', lang('user_postcode'), 'required|is_natural');
		$this->form_validation->set_rules('user_postadd', lang('user_poststreetadd'), 'required');
		$this->form_validation->set_rules('user_country', lang('user_country'), 'required');
		$this->form_validation->set_rules('user_research', lang('user_research'), 'required|min_length[1]');
	}

	function updateuser_valid(){
		$this->form_validation->set_rules('user_email', lang('user_email'), 'required|valid_email');
		$this->form_validation->set_rules('user_firstname', lang('user_firstname'), 'required');
		$this->form_validation->set_rules('user_lastname', lang('user_lastname'), 'required');
		$this->form_validation->set_rules('user_gender', lang('user_gender'), 'required');
		$this->form_validation->set_rules('user_org', lang('user_org'), 'required');
		$this->form_validation->set_rules('user_title', lang('user_title'), 'required');
		$this->form_validation->set_rules('user_phoneO', lang('user_phoneO'), 'required');
		$this->form_validation->set_rules('user_postcode', lang('user_postcode'), 'required|is_natural');
		$this->form_validation->set_rules('user_postadd', lang('user_poststreetadd'), 'required');
		$this->form_validation->set_rules('user_country', lang('user_country'), 'required');
		$this->form_validation->set_rules('user_research', lang('user_research'), 'required|min_length[1]');
	}

	function users_valid(){
		$this->form_validation->set_rules('user_id[]', lang('account'), 'required');
		$this->form_validation->set_rules('user_email[]', lang('user_email'), 'required|valid_email');
		$this->form_validation->set_rules('user_firstname[]', lang('user_firstname'), 'required');
		$this->form_validation->set_rules('user_lastname[]', lang('user_lastname'), 'required');
		$this->form_validation->set_rules('user_gender[]', lang('user_gender'), 'required');
		$this->form_validation->set_rules('user_org[]', lang('user_org'), 'required');
		$this->form_validation->set_rules('user_title[]', lang('user_title'), 'required');
		$this->form_validation->set_rules('user_phoneO[]', lang('user_phoneO'), 'required');
		$this->form_validation->set_rules('user_postcode[]', lang('user_postcode'), 'required|is_natural');
		$this->form_validation->set_rules('user_postadd[]', lang('user_poststreetadd'), 'required');
		$this->form_validation->set_rules('user_country[]', lang('user_country'), 'required');
		$this->form_validation->set_rules('user_research[]', lang('user_research'), 'required|min_length[1]');
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
	    $word = 'abcdefghijkmnpqrstuvwxyz!@#$%^&*()-=ABCDEFGHIJKLMNPQRSTUVWXYZ;{}[]23456789';
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
		$recaptcha_secretkey = $this->config->item('recaptcha_secretkey');
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secretkey."&response=".$g_recaptcha_response);
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
		$reset_link = site_url("user/reset/".$user_login."/".$reset_token);
    	
    	$message = '嗨 '.$user_login.'，您好！<br><br>
			我們收到您在 '.$site_name.'的 "'.$user_login.'" 帳號的密碼重新設定的請求。<br><br>
			為了確認這個請求，並為您的帳號設定一個新密碼，請到下列網址：<br><br>
			<br>
			<a href="'.$reset_link.'">'.$reset_link.'</a><br>
			(這一鏈結只有在接收到重設請求之後 60 分鐘之內有效)<br><br><br>
			如果這密碼重設請求不是您提出來的，請不要做任何動作。<br><br><hr>
			Hi '.$user_login.',<br><br>
			A password reset was requested for your account "'.$user_login.'" at '.$site_name.'.<br><br>
			To confirm this request, and set a new password for your account, please go to the following web address:<br><br>
			<br>
			<a href="'.$reset_link.'">'.$reset_link.'</a><br>
			(This link is valid for 60 minutes from the time this reset was first requested)<br><br><br>
			If this password reset was not requested by you, no action is needed.<br>
		';

		$subject = $site_name.'密碼重設請求 Password reset request';
		$to      = $user_email;
		
		$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->conf->addmail($to,$subject,$message,$user_login);
		return $this->email->send();
	}

	function send_pwd_mail($user_firstname,$user_lastname,$user_login,$user_email,$user_pass){
		$time = date("Y-m-d H:i:s",time());
		$site_name = $this->config->item('site_name');
		$login_link = site_url("user/login");
    	$message = $user_lastname.' '.$user_firstname.'，您好<br><br>
    	您在“'.$site_name.'”的帳號已經建立，系統產生一個密碼給您。<br><br>
    	您目前的登入資訊如下：<br>
    	帳號：'.$user_login.'<br>
    	密碼：'.$user_pass.'<br><br>
    	要開始使用“'.$site_name.'”請透過連結登入：<br><a href="'.$login_link.'">'.$login_link.'</a><br><br>
    	在大部分的郵件軟體中，上面的網址應該會自動以連結格式呈現，您可以直接點選；如果沒有，您可以將上面網址直接貼到瀏覽器的網址列中。<br><br>
    	'.$site_name.'管理員<br><br><hr>
    	Hi '.$user_firstname.' '.$user_lastname.',<br><br>
		A new account has been created for you at "'.$site_name.'" and you have been issued with a new password.<br><br>
		Your current login information is now:<br>
		username: '.$user_login.'<br>
		password: '.$user_pass.'<br><br>
		Please go to this page to change your password:<br><a href="'.$login_link.'">'.$login_link.'</a><br><br>
		In most mail programs, this should appear as a blue link which you can just click on. If that doesn\'t work, then cut and paste the address into the address line at the top of your web browser window.<br><br>
		Cheers from the "'.$site_name.'" administrator';

		$subject = '新用戶帳號 New user account';
		$to      = $user_email;
		
		$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->conf->addmail($to,$subject,$message,$user_login);
		return $this->email->send();
	}

	function send_sigup_mail($user_firstname,$user_lastname,$user_login,$user_email,$user_pass){
		$time = date("Y-m-d H:i:s",time());
		$site_name = $this->config->item('site_name');
		$login_link = site_url("user/login");
    	$message = $user_lastname.' '.$user_firstname.'，您好<br><br>
    	您在“'.$site_name.'”的帳號已經建立。<br><br>
    	您目前的登入資訊如下：<br>
    	帳號：'.$user_login.'<br>
    	密碼：**********<br><br>
    	要開始使用“'.$site_name.'”請透過連結登入：<br><a href="'.$login_link.'">'.$login_link.'</a><br><br>
    	在大部分的郵件軟體中，上面的網址應該會自動以連結格式呈現，您可以直接點選；如果沒有，您可以將上面網址直接貼到瀏覽器的網址列中。<br><br>
    	'.$site_name.'管理員<br><br><hr>
    	Hi '.$user_firstname.' '.$user_lastname.',<br><br>
		A new account has been created for you at "'.$site_name.'".<br><br>
		Your current login information is now:<br>
		username: '.$user_login.'<br>
		password: **********<br><br>
		Please go to this page to change your password:<br><a href="'.$login_link.'">'.$login_link.'</a><br><br>
		In most mail programs, this should appear as a blue link which you can just click on. If that doesn\'t work, then cut and paste the address into the address line at the top of your web browser window.<br><br>
		Cheers from the "'.$site_name.'" administrator';

		$subject = '新用戶帳號 New user account';
		$to      = $user_email;
		
		$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->conf->addmail($to,$subject,$message,$user_login);
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

	function abbr2country($abbr){
		$country = config_item('country_list');
		$country_list = $country[$this->_lang];
		return $country_list[$abbr];
	}
}
?>