<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sysop extends MY_Sysop {
	public $col_nav;
	public $col_right;
	public function __construct(){
		parent::__construct();
		$this->assets->add_css(asset_url().'style/sysop-style.css');
		$this->col_nav = 3;
		$this->col_right = 12-$this->col_nav;
		//echo $this->router->method;
	}

	public function index(){
		if( !$this->sysop->is_sysop_login() ){
			redirect(base_url("sysop/login"), 'location', 301);
		}else{
			$this->sysop->add_sysop_time();
		}
		$data['col_nav'] = $this->col_nav;
		$data['col_right'] = $this->col_right;
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('sysop/nav',$data);
		$this->load->view('common/footer');
	}

	public function conf($type="all",$conf_id=""){
		if( !$this->sysop->is_sysop_login() ){
			redirect(base_url("sysop/login"), 'location', 301);
		}else{
			$this->sysop->add_sysop_time();
		}
		$data['col_nav'] = $this->col_nav;
		$data['col_right'] = $this->col_right;
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('sysop/nav',$data);
		if( empty($conf_id) ){
			switch($type){
				default:
				case "all": // Conference Admin index

				break;
				case "add": // New Conference
				break;
			}
		}else{
			switch($type){
				default:
				case "view": // View Conference information

				break;
				case "edit": // Edit Conference information
					
				break;
				case "admin": // auth Conference administrator
					
				break;
			}
		}
		$this->load->view('common/footer');
	}

	public function user($do="all",$user_login=""){
		if( !$this->sysop->is_sysop_login() ){
			redirect(base_url("sysop/login"), 'location', 301);
		}else{
			$this->sysop->add_sysop_time();
		}
		$data['col_nav'] = $this->col_nav;
		$data['col_right'] = $this->col_right;
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('sysop/nav',$data);
		if( !empty($user_login) ){
			switch($do){
				case "add":

				break;
				default:
				case "all": // view all users

				break;
			}
		}else{
			switch($do){
				default:
				case "view": // view user

				break;
				case "edit": // edit user

				break;
				case "reset": // reset user password

				break;
			}
		}
		$this->load->view('common/footer');
	}

	public function login(){
		if( $this->sysop->is_sysop_login() ){
			redirect(base_url("sysop"), 'location', 301);
		}
		$this->assets->add_css(asset_url().'style/sysop_login.css');
		$this->form_validation->set_rules('user_pass', '密碼', 'required');
		if ($this->form_validation->run() == TRUE){
			$user_pwd = $this->input->post('user_pass', TRUE);
			if( $this->sysop->sysop_login($user_pwd) ){
				js_alert("Login Success",base_url("sysop"));
			}else{
				js_alert("Login Error");
			}
		}

		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('sysop/login');
		$this->load->view('common/footer');
	}
}