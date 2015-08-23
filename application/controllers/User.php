<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function index(){
		$this->load->view('common/header');
		$this->load->view('common/nav');
		if(!$this->user->is_login()){
			redirect('/user/login', 'location', 301);
		}
		$this->load->view('common/footer');
	}

	public function login($conf_id=""){
		if(!$this->user->is_login()){
			$this->form_validation->set_rules('user_login', '帳號', 'required');
		    $this->form_validation->set_rules('user_pass', '密碼', 'required');
		    if ($this->form_validation->run() === FALSE){

		    }else{
		    	$user_login = $this->input->post('user_login', TRUE);
		    	$user_pwd = $this->input->post('user_pass', TRUE);
		    	$redirect = $this->input->post('redirect', TRUE);

		    	$result = $this->user->login($user_login, $user_pwd);
		    	if($result){
		    		$this->form_validation->set_message('login_success', 'Login Success');
		    		redirect($redirect, 'refresh');
		    	}
		    }
		}else{
			redirect('/', 'location', 301);
		}

		if(empty($conf_id)){
			$data['redirect'] = "/";
		}else{
			if($this->conf->confid_exists($conf_id)){
				$data['redirect'] = "/index/$conf_id";
			}else{
				$data['redirect'] = "/";
			}
		}

		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('user/login',$data);
		$this->load->view('common/footer');
	}

	public function logout($conf_id=""){
		if($this->user->is_login()){
			$user_logout = array('user_login', 'user_sysop');
			$this->session->unset_userdata($user_logout);

			$this->load->view('common/header');
			$this->load->view('common/nav');
			$this->load->view('user/logout');
			$this->load->view('common/footer');
		}else{
			redirect('/user/login', 'location', 301);
		}
	}

	public function signup(){
		if(!$this->user->is_login()){
			$country_list = config_item('country_list');
			$data['country_list'] = $country_list['zhtw'];

			$this->assets->add_css(asset_url().'style/chosen.css');

			$this->assets->add_js(asset_url().'js/pwstrength-bootstrap-1.2.3.min.js');
			$this->assets->add_js(asset_url().'js/pwstrength-setting.js');
			$this->assets->add_js(asset_url().'js/jquery.validate.min.js');
			$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
			$this->assets->add_js(asset_url().'js/chosen.jquery.js');

			$this->load->view('common/header');
			$this->load->view('common/nav');
			$this->load->view('js/signup');
			$this->form_validation->set_rules('user_id', '帳號', 'required');
		    $this->form_validation->set_rules('user_pw', '密碼', 'required|min_length[6]');
		    $this->form_validation->set_rules('user_pw2', '重覆輸入密碼', 'required|matches[user_pw]|min_length[6]');
		    $this->form_validation->set_rules('user_email', '電子信箱', 'required');
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
		    /*
		    $this->email->from('ccs@asia.edu.tw', '亞大研討會系統');
			$this->email->to('kevin50406418@gmail.com');
			$this->email->subject('Email Test');
			$this->email->message('Testing the email class.');
			if ( ! $this->email->send()){
				echo $this->email->print_debugger();
			}*/

		    if ($this->form_validation->run() === FALSE){

		    }else{
		    	$user_login = $this->input->post('user_id', TRUE);
		    	$user_pass = $this->input->post('user_pw', TRUE);
		    	$user_email = $this->input->post('user_email', TRUE);
		    	$user_title = $this->input->post('user_title', TRUE);
		    	$user_firstname = $this->input->post('user_firstname', TRUE);
		    	$user_lastname = $this->input->post('user_lastname', TRUE);
		    	$user_gender = $this->input->post('user_gender', TRUE);
		    	$user_org = $this->input->post('user_org', TRUE);
		    	$user_phoneO_1 = $this->input->post('user_phoneO_1', TRUE);
		    	$user_phoneO_2 = $this->input->post('user_phoneO_2', TRUE);
		    	$user_phoneO_3 = $this->input->post('user_phoneO_3', TRUE);
		    	$user_phoneO_3 = $this->input->post('user_phoneO_3', TRUE);
		    	$user_cellphone = $this->input->post('user_cellphone', TRUE);
		    	$user_fax = $this->input->post('user_fax', TRUE);
		    	$user_postcode = $this->input->post('user_postcode', TRUE);
		    	$user_addcounty = $this->input->post('user_addcounty', TRUE);
		    	$user_area = $this->input->post('user_area', TRUE);
		    	$user_postaddr = $this->input->post('user_postadd', TRUE);
		    	$user_country = $this->input->post('user_country', TRUE);
		    	$user_lang = $this->input->post('user_lang', TRUE);
		    	$user_research = $this->input->post('user_research', TRUE);

		    	$user_phone_o = $user_phoneO_1.",".$user_phoneO_2.",".$user_phoneO_3;
		    	$user_postaddr = $user_addcounty.",".$user_area.",".$user_postaddr;
		    	$res = $this->user->adduser($user_login,$user_pass,$user_title,$user_email,$user_firstname,$user_lastname,$user_gender,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research);
		    	if( $res['status'] ){
		    		$this->alert->js("Signup Success");
		    		$this->form_validation->set_message('signup_success', 'Signup Success');
		    		//redirect($redirect, 'refresh');
		    	}else{
		    		$this->alert->js($res['error']);
		    		$this->form_validation->set_message('signup_error', $res['error']);
		    	}
		    }

			
			$this->load->view('user/signup',$data);
			$this->load->view('common/footer');
		}else{
			redirect('/user/login', 'location', 301);
		}
	}
}
