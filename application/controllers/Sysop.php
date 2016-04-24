<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.0.0
 * @date	2016/2/20 
 */
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
		$fetch_method = $this->router->fetch_method();
		$no_redirect = array("login","logout");
		$this->output->set_header('refresh:900');
		if( !in_array($fetch_method,$no_redirect) ){
			if( !$this->sysop->is_sysop_login() ){
				$this->session->set_tempdata('user_back', current_url(), 300);
				redirect(site_url("sysop/login"), 'location', 301);
			}else{
				$this->sysop->add_sysop_time();
			}
		}
	}

	public function index(){
		$this->data['col_right'] = 12;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = "container";
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('sysop/sysop',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function conf($type="all",$conf_id=""){
		$this->data['col_nav'] = $this->col_nav;
		$this->data['col_right'] = $this->col_right;
		$this->data['conf_id'] = $conf_id;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = $this->body_class;
		$this->data['do']=$type;

		if( $type=="admin" ){
			$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
			$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
			$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		}
		
		if( empty($conf_id) ){
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('sysop/nav',$this->data);

			switch($type){
				default:
				case "all": // Conference Admin index
					$this->data['test_conf'] = $this->config->item("test_conf");
					$this->data['confs']=$this->conf->all_conf_config(true);
					$this->load->view('sysop/conf/list',$this->data);
				break;
				case "add": // New Conference
					$this->form_validation->set_rules('conf_id', '研討會ID', 'required');
					$this->form_validation->set_rules('conf_name', '研討會名稱', 'required');
					$this->form_validation->set_rules('conf_master', '主要聯絡人', 'required');
					$this->form_validation->set_rules('conf_email', '聯絡信箱', 'required|valid_email');
					$this->form_validation->set_rules('conf_phone', '聯絡電話', 'required');
					$this->form_validation->set_rules('conf_address', '通訊地址', 'required');
					$this->form_validation->set_rules('conf_host', '主辦單位', 'required');
					$this->form_validation->set_rules('conf_staus', '顯示/隱藏', 'required');
					$this->form_validation->set_rules('conf_lang[]', '語言', 'required');
					$this->form_validation->set_rules('conf_place', '大會地點', 'required');
					$this->form_validation->set_rules('conf_keywords', '關鍵字', 'required');

					if ($this->form_validation->run()){
						$conf_id      = $this->input->post('conf_id');
						$conf_name    = $this->input->post('conf_name');
						$conf_master  = $this->input->post('conf_master');
						$conf_email   = $this->input->post('conf_email');
						$conf_phone   = $this->input->post('conf_phone');
						$conf_address = $this->input->post('conf_address');
						$conf_host    = $this->input->post('conf_host');
						$conf_place   = $this->input->post('conf_place');
						$conf_staus   = $this->input->post('conf_staus');
						$conf_lang    = $this->input->post('conf_lang');
						$conf_fax     = $this->input->post('conf_fax');
						$conf_desc    = $this->input->post('conf_desc');
						$conf_keywords= $this->input->post('conf_keywords');
						$next         = $this->input->post('next');

						$add = $this->conf->add_conf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$conf_lang,$conf_host,$conf_place,$conf_fax,$conf_keywords,$conf_desc);
						if( !is_null($next) ){
							if($add['status']){
								$this->alert->js($add['error'],site_url("sysop/conf/edit/".$conf_id));
							}else{
								$this->alert->js($add['error']);
							}
						}else{
							$this->alert->js($add['error']);
						}
					}
					$this->load->view('sysop/conf/add',$this->data);
				break;
			}
			$this->load->view('common/footer',$this->data);
		}else{
			switch($type){
				case "status": // Edit Conference information
					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					if( $this->conf->confid_exists( $conf_id , 1) ){
						$this->form_validation->set_rules('conf_staus', '顯示/隱藏', 'required');
						if ($this->form_validation->run()){
							$conf_staus   = $this->input->post('conf_staus', TRUE);
							$valid_status = array(0,1);
							if( in_array($conf_staus,$valid_status) ){
								if( $this->conf->update_status($conf_id,$conf_staus) ){
									$this->alert->js("更新成功",site_url("sysop/conf/"));
								}else{
									$this->alert->js("更新失敗",site_url("sysop/conf/"));
								}
							}else{
								$this->alert->js("無效設定，無法更改研討會顯示狀態",site_url("sysop/conf/"));
							}
						}
					}
					$this->load->view('common/footer',$this->data);
				break;
				case "change":
					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					if( $this->conf->confid_exists( $conf_id , 1) ){
						$conf_config = $this->conf->conf_config($conf_id,true);
						$this->data['conf_config'] = $conf_config;

						$this->form_validation->set_rules('new_id', '新研討會ID', 'required');
						if ($this->form_validation->run()){
							$new_id = $this->input->post('new_id');
							$return = $this->conf->change_confid($new_id,$conf_id);
							if( $return["status"] ){
								$this->alert->js($return["error"],site_url("sysop/conf/change/".$new_id));
							}else{
								$this->alert->js($return["error"],site_url("sysop/conf/change/".$conf_id));
							}
						}
						$this->load->view('sysop/conf/change',$this->data);
					}else{
						$this->alert->js("研討會不存在",site_url("sysop/conf"));
					}
					$this->load->view('common/footer',$this->data);
				break;
				case "edit": // Edit Conference information
					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					if( $this->conf->confid_exists( $conf_id , 1) ){
						$this->form_validation->set_rules('conf_id', '研討會ID', 'required');
						$this->form_validation->set_rules('conf_name', '研討會名稱', 'required');
						$this->form_validation->set_rules('conf_master', '主要聯絡人', 'required');
						$this->form_validation->set_rules('conf_email', '聯絡信箱', 'required|valid_email');
						$this->form_validation->set_rules('conf_phone', '聯絡電話', 'required');
						$this->form_validation->set_rules('conf_address', '通訊地址', 'required');
						$this->form_validation->set_rules('conf_staus', '顯示/隱藏', 'required');
						$this->form_validation->set_rules('conf_lang[]', '語言', 'required');
						$this->form_validation->set_rules('conf_host', '主辦單位', 'required');
						$this->form_validation->set_rules('conf_place', '大會地點', 'required');
						$this->form_validation->set_rules('conf_keywords', '關鍵字', 'required');

						if ( $this->form_validation->run() ){
							$conf_name    = $this->input->post('conf_name');
							$conf_master  = $this->input->post('conf_master');
							$conf_email   = $this->input->post('conf_email');
							$conf_phone   = $this->input->post('conf_phone');
							$conf_address = $this->input->post('conf_address');
							$conf_host    = $this->input->post('conf_host');
							$conf_place   = $this->input->post('conf_place');
							$conf_staus   = $this->input->post('conf_staus');
							$conf_lang    = $this->input->post('conf_lang');
							$conf_fax     = $this->input->post('conf_fax');
							$conf_desc    = $this->input->post('conf_desc');
							$conf_keywords= $this->input->post('conf_keywords');

							$update = $this->conf->sysop_updateconf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$conf_lang,$conf_host,$conf_place,$conf_fax,$conf_keywords,$conf_desc);
							if( $update ){
								$this->alert->js("更新成功",site_url("sysop/conf/edit/".$conf_id));
							}else{
								$this->alert->js("更新失敗",site_url("sysop/conf/edit/".$conf_id));
							}
						}
						
						$conf_config = $this->conf->conf_config($conf_id,true);
						$this->data['conf_config'] = $conf_config;
						$this->data['conf_lang'] = explode(",", $this->data['conf_config']['conf_lang']);
						$this->load->view('sysop/conf/edit',$this->data);
					}else{
						$this->alert->js("研討會不存在",site_url("sysop/conf"));
					}
					$this->load->view('common/footer',$this->data);
				break;
				case "admin": // auth Conference administrator
					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					if( $this->conf->confid_exists( $conf_id , 1) ){
						$this->data['conf_id'] = $conf_id;
						$this->data['users']=$this->user->get_all_users(10);
						$this->data['confs']=$this->user->get_conf_array($conf_id);

						$this->load->view('sysop/conf/admin',$this->data);
					}else{
						$this->alert->js("研討會不存在",site_url("sysop/conf"));
					}
					$this->load->view('common/footer',$this->data);
				break;
				case "add_admin": // auth Conference administrator
					$user_logins = $this->input->post('user_login');
					if( $this->input->is_ajax_request() ){
						$this->form_validation->set_rules('type', '操作', 'required');
						$this->form_validation->set_rules('user_login[]', '帳號', 'required');
					    if ($this->form_validation->run()){
					    	$type = $this->input->post('type');
					    	$user_logins = $this->input->post('user_login');
					    	switch($type){
					    		case "add_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->add_conf($conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 設為研討會管理員失敗");
					    				}
					    			}
					    		break;
					    		case "del_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->del_conf($conf_id,$user_login) ){
					    					$this->alert->show("s","將使用者 <strong>".$user_login."</strong> 取消設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 取消研討會管理員失敗");
					    				}
					    			}
					    		break;
					    	}
					    	$this->alert->refresh(2);
					    }
					}
				break;
			}
		}
	}

	public function user($do="all",$user_login=""){
		$this->data['col_nav'] = $this->col_nav;
		$this->data['col_right'] = $this->col_right;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = $this->body_class;
		$this->data['do']=$do;
		$this->lang->load("user",$this->_lang);
		
		if( empty($user_login) ){
			switch($do){
				case "add":
					$country_list = config_item('country_list');
					$this->data['country_list'] = $country_list[$this->_lang];
					$this->assets->add_js(asset_url().'js/repeatable-addusers.js');
					$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					$this->user->users_valid();
				    if ($this->form_validation->run()){
						$user_login      = $this->input->post('user_id');
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

						foreach ($user_login as $key => $login) {
							$user_phone_o = $user_phoneO[$key].",".$user_phoneext[$key];
				    		$user_postaddr = $user_addcounty[$key]."|".$user_area[$key]."|".$user_postaddr[$key];
				    		$user_pass = $this->user->generator_password(8);
				    		$res = $this->user->adduser($user_login[$key],$user_pass,$user_email[$key],$user_firstname[$key],$user_middlename[$key],$user_lastname[$key],$user_gender[$key],$user_title[$key],$user_org[$key],$user_phone_o,"","",$user_postcode[$key],$user_postaddr,$user_country[$key],"zhtw",$user_research[$key]);
				    		if( $res['status'] ){
					    		$this->alert->show("s","成功建立帳號:".$login."密碼為:".$user_pass);
					    		if( $this->user->send_pwd_mail($user_firstname[$key],$user_lastname[$key],$user_login[$key],$user_email[$key],$user_pass) ){
					    			$this->alert->show("s","已將登入資訊發送至".$user_email[$key]);
					    		}else{
					    			$this->alert->show("d","將登入資訊發送失敗，發送目標信箱：".$user_email[$key]);
					    		}
					    	}else{
					    		$this->alert->show("d","建立帳號:".$login."失敗，原因:".$res['error']);
					    	}
						}						    	
				    }
					$this->load->view('sysop/user/add',$this->data);
				break;
				default:
				case "all": // view all users
					$this->data['users']=$this->user->get_all_users();
					$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
					$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
					$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);

					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('sysop/nav',$this->data);
					$this->load->view('sysop/user/all',$this->data);
				break;
				case "manage":
					if ( $this->input->is_ajax_request() ) {
						$this->form_validation->set_rules('user_login[]', '帳號', 'required');
						$this->form_validation->set_rules('type', '操作', 'required');
						if ($this->form_validation->run()){
					    	$user_logins = $this->input->post('user_login', TRUE);
					    	$type = $this->input->post('type', TRUE);
					    	switch($type){
					    		case "sysop":
					    			$ban = $this->config->item('ban');
					    			foreach ($user_logins as $key => $user_login) {
					    				if( !in_array($user_login,$ban) ){
					    					if( $this->sysop->set_sysop($user_login,1) ){
					    						$this->alert->show("s","使用者 <strong>".$user_login."</strong> 成功設定為系統管理員身份");
					    					}else{
					    						$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法設定為系統管理員身份");
					    					}
					    				}else{
					    					$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法設定為系統管理員身份(請洽系統架設人員)");
					    				}
					    			}
					    			$this->alert->refresh(2);
					    			
					    		break;
					    		case "unsysop":
					    			$developer = $this->config->item('developer');
					    			foreach ($user_logins as $key => $user_login) {
					    				if( !in_array($user_login,$developer) ){
					    					if( $this->sysop->set_sysop($user_login,0) ){
					    						$this->alert->show("s","使用者 <strong>".$user_login."</strong> 成功取消系統管理員身份");
					    					}else{
					    						$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法取消系統管理員身份");
					    					}
					    				}else{
					    					$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法取消系統管理員身份(請洽系統架設人員)");
					    				}
					    			}
					    			$this->alert->refresh(2);
					    		break;
					    	}
					    }

					}
				break;
			}
		}else{
			$this->data['user_login'] = $user_login;
			
			if($this->user->username_exists($user_login)){
				$this->data['user']=$this->user->get_user_info($user_login);
				$this->data['user']->user_phone_o=explode(",", $this->data['user']->user_phone_o);
				$this->data['user']->user_postaddr=explode("|", $this->data['user']->user_postaddr);
				$country_list = config_item('country_list');
				$this->data['country_list'] = $country_list[$this->_lang];
				switch($do){
					default:
					case "view": // view user
						$this->lang->load("user_login_log",$this->_lang);
						$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
						$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js');
						$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js');
						$this->data['logs'] = $this->user->get_login_log($user_login,$this->data['user']->user_email);
						$this->load->view('common/header');
						$this->load->view('common/nav',$this->data);
						$this->load->view('sysop/nav',$this->data);
						$this->load->view('sysop/user/view',$this->data);
						$this->load->view('common/footer',$this->data);
					break;
					case "edit": // edit user
						$this->assets->add_css(asset_url().'style/chosen.css');
						$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
						$this->assets->add_js(asset_url().'js/chosen.jquery.js');

						$this->load->view('common/header');
						$this->load->view('common/nav',$this->data);
						$this->load->view('sysop/nav',$this->data);

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

							$res = $this->user->updateuser($user_login,$user_email,$user_firstname,$user_middlename,$user_lastname,$user_gender,$user_org,$user_title,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research,$old_email);
					    	if( $res['status'] ){
					    		$this->alert->show("s",lang('update_profile_success'));
					    		$this->alert->refresh(2);
					    	}else{
					    		$this->alert->js($res['error']);
					    		$this->alert->show("d",$res['error']);
					    	}
					    }
						$this->load->view('sysop/user/edit',$this->data);
						$this->load->view('js/edit');
						$this->load->view('common/footer',$this->data);
					break;
					case "reset": // reset user password
						$this->data['passwd'] = "";

						$this->load->view('common/header');
						$this->load->view('common/nav',$this->data);
						$this->load->view('sysop/nav',$this->data);

						$this->form_validation->set_rules('type', '', 'required');
						if ($this->form_validation->run()){
					    	$type = $this->input->post('type', TRUE);
					    	switch($type){
					    		case "get":
					    			$this->data['passwd'] = $this->user->generator_password(8);
					    		break;
					    		case "update":
					    			$user_pass = $this->input->post('user_pass', TRUE);
					    			if( $this->user->change_passwd($user_login,$user_pass) ){
					    				$this->sysop->notice_passwd($user_login,$user_pass,$this->data['user']->user_email);
					    				$this->alert->js("成功更新使用者 ".$user_login." 密碼");
					    			}else{
					    				$this->alert->show("d","更新使用者 ".$user_login." 密碼失敗");
					    			}
					    		break;
					    	}
					    }
						$this->load->view('sysop/user/reset',$this->data);
						$this->load->view('common/footer',$this->data);
					break;
					case "switch":
						$this->session->user_login = $user_login;
					break;
				}
			}else{
				$this->alert->js("The username is not exist.",site_url("sysop/user/all"));
			}
		}
		if( empty($user_login) && $do != "manage" ){
			$this->load->view('common/footer',$this->data);
		}
	}

	public function setting(){
		$this->data['col_nav'] = $this->col_nav;
		$this->data['col_right'] = $this->col_right;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = $this->body_class;
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('sysop/nav',$this->data);

		$this->form_validation->set_rules('site_name', '網站名稱', 'required');
	    if ($this->form_validation->run()){
	    	$site_name = $this->input->post('site_name', TRUE);
	    	if( $this->config->set_item('site_name', $site_name) ){
	    		$this->alert->show("s","成功更新網站名稱");
	    	}else{
	    		$this->alert->show("d","更新網站名稱失敗");
	    	}
	    }
		$this->load->view('sysop/setting/index',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function email($do="all"){
		$this->data['col_nav'] = $this->col_nav;
		$this->data['col_right'] = $this->col_right;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = $this->body_class;
		$this->data['do']=$do;
		
		switch($do){
			default:
			case "all":
				$this->data['template_zhtw'] = $this->sysop->get_mail_templates("zhtw");
				$this->data['template_eng']  = $this->sysop->get_mail_templates("eng");

				$this->load->view('common/header');
				$this->load->view('common/nav',$this->data);
				$this->load->view('sysop/nav',$this->data);
				$this->load->view('sysop/email/list',$this->data);
			break;
			case "add":
				$this->assets->add_js(base_url().'ckeditor/ckeditor.js');
				$this->load->view('common/header');
				$this->load->view('common/nav',$this->data);
				$this->load->view('sysop/nav',$this->data);

				$this->form_validation->set_rules('email_key', '電子郵件識別碼', 'required');
				$this->form_validation->set_rules('email_desc[]', '郵件樣版說明', 'required');
				$this->form_validation->set_rules('default_subject[]', '信件主旨', 'required');
				$this->form_validation->set_rules('default_body[]', '信件內容', 'required');
				if ($this->form_validation->run()){
					$email_key       = $this->input->post('email_key');
					$email_desc      = $this->input->post('email_desc', false);
					$default_subject = $this->input->post('default_subject');
					$default_body    = $this->input->post('default_body', false);
					if( $this->sysop->add_mail_template($email_key,$email_desc,$default_subject,$default_body) ){
						$this->alert->js("電子郵件樣版新增成功");
					}else{
						$this->alert->js("電子郵件樣版新增失敗");
					}
					$this->alert->refresh(0);
				}
				
				$this->load->view('sysop/email/add',$this->data);
			break;
			case "edit":
				$this->assets->add_js(base_url().'ckeditor/ckeditor.js');

				$this->load->view('common/header');
				$this->load->view('common/nav',$this->data);
				$this->load->view('sysop/nav',$this->data);
				
				$id = $this->input->get("id");
				if( empty($id) ){
					$this->alert->js("找不到電子郵件樣版",site_url("sysop/email"));
				}else{
					$mail_template = $this->sysop->get_mail_template($id);
					if( !empty($mail_template) ){
						$this->data['id'] = $id;
						$this->data['mail_template'] = $mail_template;
						$this->form_validation->set_rules('email_desc[]', '郵件樣版說明', 'required');
						$this->form_validation->set_rules('default_subject[]', '信件主旨', 'required');
						$this->form_validation->set_rules('default_body[]', '信件內容', 'required');
						if ($this->form_validation->run()){
							$email_desc      = $this->input->post('email_desc', false);
							$default_subject = $this->input->post('default_subject');
							$default_body    = $this->input->post('default_body', false);
							if( $this->sysop->update_mail_template($id,$email_desc,$default_subject,$default_body) ){
								$this->alert->js("電子郵件樣版更新成功");
							}else{
								$this->alert->js("電子郵件樣版更新失敗");
							}
							$this->alert->refresh(0);
						}

						$this->load->view('sysop/email/edit',$this->data);
					}else{
						$this->alert->js("找不到電子郵件樣版",site_url("sysop/email"));
					}
				}
			break;
		}

		$this->load->view('common/footer',$this->data);
	}

	public function file(){
		$this->data['col_nav'] = $this->col_nav;
		$this->data['col_right'] = $this->col_right;
		$this->data['active'] = $this->active;
		$this->data['body_class'] = $this->body_class;
		$this->load->view('common/footer',$this->data);
	}

	public function login(){
		if( $this->sysop->is_sysop_login() ){
			redirect(site_url("sysop"), 'location', 301);
		}
		$this->assets->add_css(asset_url().'style/sysop_login.css');
		$this->data['body_class'] = $this->body_class;
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->form_validation->set_rules('user_pass', '密碼', 'required');
		if ($this->form_validation->run() == TRUE){
			$user_pwd = $this->input->post('user_pass', TRUE);
			if( $this->sysop->sysop_login($user_pwd) ){
				$redirect = $this->session->has_userdata('user_back')?$this->session->user_back:site_url("sysop");
				$this->alert->show("i","Login Success",$redirect);
			}else{
				$this->alert->show("d","Login Error");
			}
		}
		$this->load->view('sysop/login');
		$this->load->view('common/footer',$this->data);
	}

	public function logout(){
		$this->data['body_class'] = $this->body_class;
		$this->sysop->logout();
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->alert->show("i","Logout Success",site_url("sysop/login"));
		$this->load->view('common/footer',$this->data);
	}

	public function version(){
		$out = array();
		$json = file_get_contents("https://raw.githubusercontent.com/kevin50406418/conf/version/version_conf?t=".time());
		$get = json_decode($json);
		$version = $this->config->item('version');
		if( $version < $get->version ){
			$out['upgrade'] = false;
			$out["desc"] = "需要更新為".$get->version;
		}else if( $version == $get->version ){
			$out['upgrade'] = true;
			$out["desc"] = "已是最新版本";
		}else{
			$out['upgrade'] = false;
			$out["desc"] = "ERROR:最新版本為".$get->version;
		}
		echo json_encode($out);
	}

	function upgrade(){
		
	}
}