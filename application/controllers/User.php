<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.1.0
 * @date	2016/3/2 
 */
class User extends MY_Controller {
	public function __construct() {        
	    parent::__construct();
	    $this->lang->load("user",$this->_lang);
	    $this->data['body_class'] = $this->body_class;
	}

	public function index(){
		$this->assets->set_title(lang('nav_user_edit'));

		if(!$this->user->is_login()){
			redirect('/user/login', 'location', 301);
		}else{
			$this->data['user_login'] = $this->user_login;
			$this->data['user'] = $this->user->get_user_info($this->user_login);
			$this->data['user']->user_phone_o  = explode(",", $this->data['user']->user_phone_o);
			$this->data['user']->user_postaddr = explode("|", $this->data['user']->user_postaddr);
			$country_list = config_item('country_list');
			$this->data['country_list'] = $country_list[$this->_lang];

			$this->assets->add_css(asset_url().'style/chosen.css');
			$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
			$this->assets->add_js(asset_url().'js/chosen.jquery.js');

			$this->load->view('common/header',$this->data);
			$this->load->view('common/nav',$this->data);
			$this->user->updateuser_valid();
			if ($this->form_validation->run()){
				$old_email       = $this->data['user']->user_email;
				$user_email      = $this->input->post('user_email');
				$user_firstname  = $this->input->post('user_firstname');
				$user_middlename = $this->input->post('user_middlename');
				$user_lastname   = $this->input->post('user_lastname');
				$user_gender     = $this->input->post('user_gender');
				$user_org        = $this->input->post('user_org');
				$user_title      = $this->input->post('user_title');
				$user_phoneO     = $this->input->post('user_phoneO');
				$user_phoneext   = $this->input->post('user_phoneext');
				$user_postcode   = $this->input->post('user_postcode');
				$user_addcounty  = $this->input->post('user_addcounty');
				$user_area       = $this->input->post('user_area');
				$user_postaddr   = $this->input->post('user_postadd');
				$user_country    = $this->input->post('user_country');
				$user_research   = $this->input->post('user_research');
				$user_cellphone  = $this->input->post('user_cellphone');
				$user_fax        = $this->input->post('user_fax');
				$user_lang       = $this->_lang;

		    	$user_phone_o = $user_phoneO.",".$user_phoneext;
		    	$user_postaddr = $user_addcounty."|".$user_area."|".$user_postaddr;

				$res = $this->user->updateuser($this->user_login,$user_email,$user_firstname,$user_middlename,$user_lastname,$user_gender,$user_org,$user_title,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research,$old_email);
		    	if( $res['status'] ){
		    		$this->alert->show("s",lang('update_profile_success'),site_url("user/index"));
		    		$this->alert->refresh(2);
		    	}else{
		    		$this->alert->js($res['error']);
		    	}
		    }
			$this->load->view('user/edit',$this->data);
			$this->load->view('js/edit');
			$this->load->view('common/footer',$this->data);
		}
		
	}

	public function login($conf_id=""){
		$this->data['redirect'] = $this->session->redirected;
		$this->assets->set_title(lang('nav_login'));

		if(!$this->user->is_login()){
			$this->form_validation->set_rules('user_login', lang('account'), 'required');
		    $this->form_validation->set_rules('user_pass', lang('password'), 'required');
		    if ( $this->form_validation->run() ){
				$user_login = $this->input->post('user_login');
				$user_pwd   = $this->input->post('user_pass');
				$redirect   = $this->input->post('redirect');
		    	$result = $this->user->login($user_login, $user_pwd);
		    	if($result){
		    		if( preg_match('/(favicon|clang|assets|upload|tinymce|rss|piwik|ajax)/i',$redirect) ){
						$redirect = "";
					}
					redirect(site_url($redirect), 'location', 301);
		    	}else{
		    		$this->alert->js(lang('login_fail'));
		    	}
		    }
		}else{
			redirect('/', 'location', 301);
		}

		$this->load->view('common/header',$this->data);
		$this->load->view('common/nav',$this->data);
		$this->load->view('user/login',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function logout($conf_id=""){
		$this->assets->set_title(lang('nav_user_logout'));

		if($this->user->is_login()){
			$user_logout = array('user_login', 'user_sysop');
			$this->session->unset_userdata($user_logout);

			$this->load->view('common/header',$this->data);
			$this->load->view('common/nav',$this->data);
			$this->load->view('user/logout');
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function log(){
		$this->assets->set_title(lang('nav_user_log'));
		$this->lang->load("user_login_log",$this->_lang);
		if($this->user->is_login()){
			$user = $this->user->get_user_info($this->user_login);
			$this->data['logs'] = $this->user->get_login_log($this->user_login,$user->user_email);
			$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
			$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
			$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);

			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('user/log',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}
	
	public function paper(){
		$this->assets->set_title(lang('nav_user_paper'));
		if($this->user->is_login()){
			$this->data['papers'] = $this->submit->get_mypapers($this->user_login);
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('user/paper',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function apply(){
		if($this->user->is_login()){
			$this->data['user']=$this->user->get_user_info($this->user_login);
			
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);

			$this->form_validation->set_rules('conf_id', "研討會ID", 'required|max_length[15]');
			$this->form_validation->set_rules('conf_name', "研討會名稱", 'required');
			$this->form_validation->set_rules('conf_master', "主要聯絡人", 'required');
			$this->form_validation->set_rules('conf_email', "聯絡信箱", 'required');
			$this->form_validation->set_rules('conf_phone', "聯絡電話", 'required');
			$this->form_validation->set_rules('conf_address', "通訊地址", 'required');
			$this->form_validation->set_rules('conf_host', "承辦單位", 'required');
			$this->form_validation->set_rules('conf_place', "大會地點", 'required');
			$this->form_validation->set_rules('conf_keywords', "關鍵字", 'required');
			$this->form_validation->set_rules('conf_staus', "開設後狀態", 'required');
			$this->form_validation->set_rules('conf_admin', "管理員設置", 'required');
		    if ( $this->form_validation->run() ){
				$conf_id       = $this->input->post('conf_id');
				$conf_name     = $this->input->post('conf_name');
				$conf_master   = $this->input->post('conf_master');
				$conf_email    = $this->input->post('conf_email');
				$conf_phone    = $this->input->post('conf_phone');
				$conf_address  = $this->input->post('conf_address');
				$conf_host     = $this->input->post('conf_host');
				$conf_place    = $this->input->post('conf_place');
				$conf_keywords = $this->input->post('conf_keywords');
				$conf_staus    = $this->input->post('conf_staus');
				$conf_admin    = $this->input->post('conf_admin');
				$apply_message = $this->input->post('apply_message');
				if( $this->conf->add_apply_conf($this->user_login,$conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_host,$conf_place,$conf_keywords,$conf_staus,$conf_admin,$apply_message) ){
					$this->alert->show("s","成功提出申請");
				}else{
					$this->alert->show("s","送出申請失敗");
				}
				$this->alert->refresh(2);
		    }

			$this->load->view('user/apply',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function applylist(){
		$this->data['body_class'] = $this->body_class;
		if($this->user->is_login()){
			$this->data['applies'] = $this->conf->get_apply_conf($this->user_login);
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('user/applylist',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function signup(){
		$this->data['body_class'] = $this->body_class;
		$this->assets->set_title(lang('nav_signup'));
		if(!$this->user->is_login()){
			$country_list = config_item('country_list');
			$this->data['country_list'] = $country_list[$this->_lang];
			$this->assets->add_css(asset_url().'style/chosen.css');
			$this->assets->add_js(asset_url().'js/pwstrength-bootstrap-1.2.3.min.js');
			$this->assets->add_js(asset_url().'js/pwstrength-setting.js');
			$this->assets->add_js(asset_url().'js/jquery.validate.min.js');
			if( $this->_lang == "en" ){
				$this->assets->add_js(asset_url().'js/jquery.twzipcode-en.js');
			}else{
				$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
			}
			$this->assets->add_js(asset_url().'js/chosen.jquery.js');

			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('js/signup');
			$this->user->user_valid();

		    if ( $this->form_validation->run() ){
				$user_login      = $this->input->post('user_id');
				$user_pass       = $this->input->post('user_pw');
				$user_email      = $this->input->post('user_email');
				$user_firstname  = $this->input->post('user_firstname');
				$user_middlename = $this->input->post('user_middlename');
				$user_lastname   = $this->input->post('user_lastname');
				$user_gender     = $this->input->post('user_gender');
				$user_org        = $this->input->post('user_org');
				$user_title      = $this->input->post('user_title');
				$user_phoneO     = $this->input->post('user_phoneO');
				$user_phoneext   = $this->input->post('user_phoneext');
				$user_cellphone  = $this->input->post('user_cellphone');
				$user_fax        = $this->input->post('user_fax');
				$user_postcode   = $this->input->post('user_postcode');
				$user_addcounty  = $this->input->post('user_addcounty');
				$user_area       = $this->input->post('user_area');
				$user_postaddr   = $this->input->post('user_postadd');
				$user_country    = $this->input->post('user_country');
				$user_lang       = $this->_lang;
				$user_research   = $this->input->post('user_research');

		    	$user_phone_o = $user_phoneO.",".$user_phoneext;
		    	$user_postaddr = $user_addcounty."|".$user_area."|".$user_postaddr;
		    	$res = $this->user->adduser($user_login,$user_pass,$user_email,$user_firstname,$user_middlename,$user_lastname,$user_gender,$user_title,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research);
		    	if( $res['status'] ){
		    		$this->user->send_sigup_mail($user_firstname,$user_lastname,$user_login,$user_email,$user_pass);
		    		$this->alert->show("s",lang('alert_signup_success'),site_url("user/login"));
		    	}else{
		    		$this->alert->show("d",lang('alert_signup_fail').$res['error']);
		    		$this->alert->js($res['error']);
		    	}
		    }

			$this->load->view('user/signup',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function passwd(){
		$this->assets->set_title(lang('reset_passwd'));
		if($this->user->is_login()){
			$this->data['user_login'] = $this->user_login;
			$user = $this->user->get_user_info($this->user_login);

			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);

			$this->form_validation->set_rules('old_pass', lang('old_pass'), 'required|min_length[6]');
		    $this->form_validation->set_rules('user_pass', lang('user_pass'), 'required|min_length[6]');
		    $this->form_validation->set_rules('user_pass2', lang('user_pass2'), 'required|matches[user_pass]|min_length[6]');
			if ( $this->form_validation->run() ){
				$old_pass   = $this->input->post('old_pass', TRUE);
				$user_pass  = $this->input->post('user_pass', TRUE);
				
				$pass  = $user->user_pass;
				$pass2 = hash('sha256',$old_pass);
				if( $pass != $pass2 ){
					$this->alert->show("d",lang('true_old_pass'));
				}else{
					if( $this->user->change_passwd($this->user_login,$user_pass) ){
						$this->alert->show("s",lang('success_password'));
						$this->alert->js(lang('success_password'));
					}else{
						$this->alert->show("d",lang('fail_password'));
						$this->alert->js(lang('fail_password'));
					}
				}
				$this->alert->refresh(2);
			}
			
			$this->load->view('user/passwd',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function lostpwd(){
		$this->assets->set_title(lang('lostpwd'));
		if($this->user->is_login()){
			redirect('/user/passwd', 'location', 301);
		}else{
			$this->load->view('common/header',$this->data);
			$this->load->view('common/nav',$this->data);
			$this->data["recaptcha_sitekey"] = $this->config->item('recaptcha_sitekey');
			$this->form_validation->set_rules('user_login', lang('account'), 'required');
		    $this->form_validation->set_rules('user_email', lang('user_email'), 'required|valid_email');
		    $this->form_validation->set_rules('g-recaptcha-response', 'Recaptcha', 'required');

		    if ( $this->form_validation->run() ){
		    	$user_login = $this->input->post('user_login');
		    	$user_email = $this->input->post('user_email');
		    	$g_recaptcha_response = $this->input->post('g-recaptcha-response');

		    	if( $this->user->passwd_reset($user_login,$user_email,$g_recaptcha_response) ){
		    		$this->alert->show("s",lang('send_lostpwd_mail'));
		    	}else{
		    		$this->alert->show("d",lang('user_notfound'));
		    	}
		    }
			
			$this->load->view('user/lostpwd',$this->data);
			$this->load->view('common/footer',$this->data);
		}
	}

	public function reset($user_login="",$reset_token=""){
		$this->assets->set_title(lang('reset_passwd'));

		if($this->user->is_login()){
			redirect('/user/passwd', 'location', 301);
		}else{
			if( empty($user_login) || empty($reset_token) ){
				redirect('/user/lostpwd', 'location', 301);
			}else{
				$reset_token = $this->user->get_reset_token($user_login,$reset_token);
				$this->load->view('common/header');
				$this->load->view('common/nav',$this->data);

				$this->data['reset_token'] = $reset_token;

				if( empty($reset_token) ){
					$this->alert->js(lang('invalid_password_reset_key'),site_url('/user/lostpwd'));
				}else{
					if( $reset_token->reset_staus == 0 && time() < $reset_token->reset_failtime ){
					    $this->form_validation->set_rules('user_pass', lang('user_pass'), 'required|min_length[6]');
					    $this->form_validation->set_rules('user_pass2', lang('user_pass2'), 'required|matches[user_pass]|min_length[6]');
						if ( $this->form_validation->run() ){
							$user_pass  = $this->input->post('user_pass', TRUE);
							if( $this->user->change_passwd($user_login,$user_pass,3) ){
								$this->user->set_reset_token($user_login,$reset_token->reset_token);
								$this->alert->js(lang('success_password'),site_url('/user/login'));
							}else{
								$this->alert->js(lang('fail_password'),site_url('/user/login'));
							}
						}

						$this->load->view('user/reset',$this->data);
					}else{
						$this->alert->js(lang('invalid_password_reset_key'),site_url('/user/lostpwd'));
					}
				}	
				$this->load->view('common/footer',$this->data);
			}
		}
	}

	public function review_confirm($type="",$review_token=""){
		$this->assets->set_title(lang('reset_passwd'));
		$check_review = $this->topic->get_check_review($review_token);
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		if( !in_array($type,array("accept","reject") ) ){
			$this->alert->js("連結無效",site_url());
		}else{
			if( !empty($check_review) ){
				switch( $type ){
					case "accept":
						if( $this->topic->review_confirm($review_token,1) ){
							$this->alert->show("s","感謝協助審查，系統將導向審查網址",get_url("reviewer",$check_review->conf_id,"detail",$check_review->sub_id));
						}
					break;
					case "reject":
						if( $this->topic->review_confirm($review_token,0) ){
							$this->alert->show("s","非常感謝你答覆審查意願",site_url());
						}
					break;
				}
			}else{
				$this->alert->js("連結無效",site_url());
			}
		}
		$this->load->view('common/footer',$this->data);
	}

	public function email(){
		$this->data['body_class'] = $this->body_class;
		$this->assets->set_title("郵件備份");
		if($this->user->is_login()){

			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			redirect('/user/login', 'location', 301);
		}
	}
}
