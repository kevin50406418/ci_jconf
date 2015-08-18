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
		if($this->user->is_login()){
			$this->load->view('common/header');
			$this->load->view('common/nav');
			
			$this->load->view('common/footer');
		}else{
			redirect('/user/login', 'location', 301);
		}
	}
}
