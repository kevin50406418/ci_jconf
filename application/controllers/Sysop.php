<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sysop extends MY_Sysop {
	public $col_nav;
	public $col_right;
	public $active;
	public function __construct(){
		parent::__construct();
		$this->assets->add_css(asset_url().'style/sysop-style.css');
		$this->col_nav = 2;
		$this->col_right = 12-$this->col_nav;
		$this->active = $this->router->method;
	}

	public function index(){
		if( !$this->sysop->is_sysop_login() ){
			redirect(base_url("sysop/login"), 'location', 301);
		}else{
			$this->sysop->add_sysop_time();
		}
		$data['col_nav'] = $this->col_nav;
		$data['col_right'] = $this->col_right;
		$data['active'] = $this->active;
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
		$data['conf_id'] = $conf_id;
		$data['active'] = $this->active;
		$data['do']=$type;
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('sysop/nav',$data);
		if( empty($conf_id) ){
			switch($type){
				default:
				case "all": // Conference Admin index
					$data['confs']=$this->conf->all_conf_config();
					$this->load->view('sysop/conf/list',$data);
				break;
				case "add": // New Conference
					$this->form_validation->set_rules('conf_id', '研討會ID', 'required');
					$this->form_validation->set_rules('conf_name', '研討會名稱', 'required');
					$this->form_validation->set_rules('conf_master', '主要聯絡人', 'required');
					$this->form_validation->set_rules('conf_email', '聯絡信箱', 'required|valid_email');
					$this->form_validation->set_rules('conf_phone', '聯絡電話', 'required');
					$this->form_validation->set_rules('conf_address', '通訊地址', 'required');
					$this->form_validation->set_rules('conf_staus', '顯示/隱藏', 'required');
					$this->form_validation->set_rules('default_lang', '默認語言', 'required');
					if ($this->form_validation->run() == TRUE){
						$conf_id = $this->input->post('conf_id', TRUE);
						$conf_name = $this->input->post('conf_name', TRUE);
						$conf_master = $this->input->post('conf_master', TRUE);
						$conf_email = $this->input->post('conf_email', TRUE);
						$conf_phone = $this->input->post('conf_phone', TRUE);
						$conf_address = $this->input->post('conf_address', TRUE);
						$conf_staus = $this->input->post('conf_staus', TRUE);
						$default_lang = $this->input->post('default_lang', TRUE);
						$conf_fax = $this->input->post('conf_fax', TRUE);
						$conf_desc = $this->input->post('conf_desc', TRUE);
						$next = $this->input->post('next', TRUE);
						
						$add = $this->conf->add_conf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$default_lang,$conf_fax,$conf_desc);
						if( !is_null($next) ){
							if($add['status']){
								$this->alert->js($add['error'],base_url("sysop/conf/edit/".$conf_id));
							}else{
								$this->alert->js($add['error']);
							}
						}else{
							$this->alert->js($add['error']);
						}
						
					}
					$this->load->view('sysop/conf/add',$data);
				break;
			}
		}else{
			switch($type){
				default:
				case "view": // View Conference information

				break;
				case "edit": // Edit Conference information
					if( $this->conf->confid_exists( $conf_id , 1) ){
						$this->form_validation->set_rules('conf_id', '研討會ID', 'required');
						$this->form_validation->set_rules('conf_name', '研討會名稱', 'required');
						$this->form_validation->set_rules('conf_master', '主要聯絡人', 'required');
						$this->form_validation->set_rules('conf_email', '聯絡信箱', 'required|valid_email');
						$this->form_validation->set_rules('conf_phone', '聯絡電話', 'required');
						$this->form_validation->set_rules('conf_address', '通訊地址', 'required');
						$this->form_validation->set_rules('conf_staus', '顯示/隱藏', 'required');
						$this->form_validation->set_rules('default_lang', '默認語言', 'required');
						if ($this->form_validation->run() == TRUE){
							$conf_name = $this->input->post('conf_name', TRUE);
							$conf_master = $this->input->post('conf_master', TRUE);
							$conf_email = $this->input->post('conf_email', TRUE);
							$conf_phone = $this->input->post('conf_phone', TRUE);
							$conf_address = $this->input->post('conf_address', TRUE);
							$conf_staus = $this->input->post('conf_staus', TRUE);
							$default_lang = $this->input->post('default_lang', TRUE);
							$conf_fax = $this->input->post('conf_fax', TRUE);
							$conf_desc = $this->input->post('conf_desc', TRUE);

							$update = $this->conf->sysop_updateconf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$default_lang,$conf_fax,$conf_desc);
							if( $update ){
								$this->alert->js("更新成功",base_url("sysop/conf/edit/".$conf_id));
							}else{
								$this->alert->js("d","更新失敗",base_url("sysop/conf/edit/".$conf_id));
							}
						}
						
						$conf_config = $this->conf->conf_config($conf_id);
						$data['conf_config'] = $conf_config;
						$this->load->view('sysop/conf/edit',$data);
					}else{
						$this->alert->js("研討會不存在");
					}
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
		$data['conf_id'] = $conf_id;
		$data['active'] = $this->active;
		$data['do']=$do;
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

		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->form_validation->set_rules('user_pass', '密碼', 'required');
		if ($this->form_validation->run() == TRUE){
			$user_pwd = $this->input->post('user_pass', TRUE);
			if( $this->sysop->sysop_login($user_pwd) ){
				$this->alert->show("i","Login Success",base_url("sysop"));
			}else{
				$this->alert->show("d","Login Error");
			}
		}
		$this->load->view('sysop/login');
		$this->load->view('common/footer');
	}

	public function logout(){
		$this->sysop->logout();
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->alert->show("i","Logout Success",base_url("sysop/login"));
		$this->load->view('common/footer');
	}
}