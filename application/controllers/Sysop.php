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
		$this->body_class ="container-fluid";
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
		$data['body_class'] = $this->body_class;
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
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
		$data['body_class'] = $this->body_class;
		$data['do']=$type;
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
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
						$this->alert->js("研討會不存在",base_url("sysop/conf/"));
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
		$data['active'] = $this->active;
		$data['body_class'] = $this->body_class;
		$data['do']=$do;
		
		if( empty($user_login) ){
			switch($do){
				case "add":
					$country_list = config_item('country_list');
					$data['country_list'] = $country_list['zhtw'];

					$this->assets->add_css(asset_url().'style/chosen.css');

					$this->assets->add_js(asset_url().'js/pwstrength-bootstrap-1.2.3.min.js');
					$this->assets->add_js(asset_url().'js/pwstrength-setting.js');
					$this->assets->add_js(asset_url().'js/jquery.validate.min.js');
					$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
					$this->assets->add_js(asset_url().'js/chosen.jquery.js');

					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('sysop/nav',$data);
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
				    if ($this->form_validation->run()){
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
				    		$this->alert->js("Add User Success");
				    		$this->form_validation->set_message('signup_success', 'Signup Success');
				    		//redirect($redirect, 'refresh');
				    	}else{
				    		$this->alert->js($res['error']);
				    		$this->form_validation->set_message('signup_error', $res['error']);
				    	}
				    }
				    $this->load->view('sysop/user/add',$data);
				break;
				default:
				case "all": // view all users
					$data['users']=$this->user->get_all_users();
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('sysop/nav',$data);
					$this->load->view('sysop/user/all',$data);
				break;
				case "import":
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('sysop/nav',$data);
				break;
			}
		}else{
			$data['user_login']=$user_login;
			
			if($this->user->username_exists($user_login)){
				$data['user']=$this->user->get_user_info($user_login);
				$data['user']->user_phone_o=explode(",", $data['user']->user_phone_o);
				$data['user']->user_postaddr=explode("|", $data['user']->user_postaddr);
				$country_list = config_item('country_list');
				$data['country_list'] = $country_list['zhtw'];
				//sp($data['user']);
				switch($do){
					default:
					case "view": // view user
						$this->load->view('common/header');
						$this->load->view('common/nav',$data);
						$this->load->view('sysop/nav',$data);
						$this->load->view('sysop/user/view',$data);
					break;
					case "edit": // edit user
						$this->assets->add_css(asset_url().'style/chosen.css');
						$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
						$this->assets->add_js(asset_url().'js/chosen.jquery.js');

						$this->load->view('common/header');
						$this->load->view('common/nav',$data);
						$this->load->view('sysop/nav',$data);

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

						if ($this->form_validation->run()){
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
					    	$user_postaddr = $user_addcounty."|".$user_area."|".$user_postaddr;

							$res = $this->user->updateuser($user_login,$user_title,$user_email,$user_firstname,$user_lastname,$user_gender,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research);
					    	if( $res['status'] ){
					    		$this->alert->js("Signup Success",base_url("sysop/user/edit/".$user_login));
					    		//redirect($redirect, 'refresh');
					    	}else{
					    		$this->alert->js($res['error']);
					    		$this->form_validation->set_message('signup_error', $res['error']);
					    	}
					    }
						$this->load->view('sysop/user/edit',$data);
						$this->load->view('js/edit');
					break;
					case "reset": // reset user password
						$this->load->view('common/header');
						$this->load->view('common/nav',$data);
						$this->load->view('sysop/nav',$data);
						$this->load->view('sysop/user/reset',$data);
					break;
				}
			}else{
				$this->alert->js("The username is not exist.",base_url("sysop/user/all"));
			}
		}
		$this->load->view('common/footer');
	}

	public function login(){
		if( $this->sysop->is_sysop_login() ){
			redirect(base_url("sysop"), 'location', 301);
		}
		$this->assets->add_css(asset_url().'style/sysop_login.css');
		$data['body_class'] = $this->body_class;
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
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
		$data['body_class'] = $this->body_class;
		$this->sysop->logout();
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		$this->alert->show("i","Logout Success",base_url("sysop/login"));
		$this->load->view('common/footer');
	}
}