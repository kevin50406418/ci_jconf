<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Conference {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
	}

	public function index($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			if( !is_null($this->input->post("do")) ){
				$do = $this->input->post("do");
				switch($do){
					case "config":
						$this->form_validation->set_rules('conf_name', '研討會名稱', 'required');
						$this->form_validation->set_rules('conf_master', '主要聯絡人', 'required');
						$this->form_validation->set_rules('conf_email', '聯絡信箱', 'required');
						$this->form_validation->set_rules('conf_phone', '聯絡電話', 'required');
						$this->form_validation->set_rules('conf_address', '通訊地址', 'required');
						$this->form_validation->set_rules('conf_desc', '簡介', 'required');
						
						if ($this->form_validation->run()){
							$conf_name    = $this->input->post('conf_name');
							$conf_master  = $this->input->post('conf_master');
							$conf_email   = $this->input->post('conf_email');
							$conf_phone   = $this->input->post('conf_phone');
							$conf_fax     = $this->input->post('conf_fax');
							$conf_address = $this->input->post('conf_address');
							$conf_desc    = $this->input->post('conf_desc');
							if( $this->conf->update_confinfo($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_fax,$conf_address,$conf_desc) ){
								$this->alert->js("更新成功");
							}
						}
					break;
					case "func":
						$this->form_validation->set_rules('conf_col', '首頁排版', 'required');
						if ($this->form_validation->run()){
							$conf_col    = $this->input->post('conf_col');
							if( $this->conf->update_confcol($conf_id,$conf_col) ){
								$this->alert->js("更新成功");
								$this->alert->refresh(0);
							}
						}
					break;
				}
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_conf',$data);
			$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}

	

	public function setting($conf_id=''){
		$this->index($conf_id);
	}

	public function topic($conf_id='',$type=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			$data['count_editor']=$this->conf->count_editor($conf_id);

			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			if( !is_null( $this->input->get('id', TRUE)) && $type =="assign" ){
				$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
				$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
				$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			
			if( is_null( $this->input->get('id', TRUE)) ){
				switch($type){
					default:
					case "all":
						$data['topics'] = $this->conf->get_topic($conf_id);
						$this->load->view('conf/topic/all',$data);
					break;
					case "add":
						$this->form_validation->set_rules('topic_name', '主題名稱(中)', 'required');
						$this->form_validation->set_rules('topic_ename', '主題名稱(英)', 'required');
						$this->form_validation->set_rules('topic_abbr', '主題簡稱', 'required');
						$this->form_validation->set_rules('topic_info', '主題說明', 'required');
						
						if ($this->form_validation->run()){
							$topic_name     = $this->input->post('topic_name');
							$topic_name_eng = $this->input->post('topic_ename');
							$topic_abbr     = $this->input->post('topic_abbr');
							$topic_info     = $this->input->post('topic_info');
							if( $this->conf->add_topic($conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng) ){
								$this->alert->show("s","成功加入研討會主題: '".$topic_name."(".$topic_name_eng.")'");
							}else{
								$this->alert->show("d","無法加入研討會主題: '".$topic_name."(".$topic_name_eng.")'");
							}
						}
						$this->load->view('conf/topic/add',$data);
					break;
				}
			}else{
				$topic_id=$this->input->get('id', TRUE);
				switch($type){
					case "remove":

					break;
					case "edit":
						$this->form_validation->set_rules('topic_name', '主題名稱(中)', 'required');
						$this->form_validation->set_rules('topic_ename', '主題名稱(英)', 'required');
						$this->form_validation->set_rules('topic_abbr', '主題簡稱', 'required');
						$this->form_validation->set_rules('topic_info', '主題說明', 'required');
						
						if ($this->form_validation->run()){
							$topic_name     = $this->input->post('topic_name');
							$topic_name_eng = $this->input->post('topic_ename');
							$topic_abbr     = $this->input->post('topic_abbr');
							$topic_info     = $this->input->post('topic_info');
							if( $this->conf->update_topic($topic_id,$conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng) ){
								$this->alert->show("s","成功更改研討會主題: '".$topic_name."(".$topic_name_eng.")'");
							}else{
								$this->alert->show("d","無法更改研討會主題: '".$topic_name."(".$topic_name_eng.")'");
							}
						}
						$data["topic"] = $this->conf->get_topic_info($conf_id,$topic_id);
						$this->load->view('conf/topic/edit',$data);
					break;
					case "assign":
						$data['users']=$this->user->get_all_users(0);
						$data["topic"] = $this->conf->get_topic_info($conf_id,$topic_id);
						if( !empty($data["topic"]) ){
							$data["topic_users"] = $this->conf->get_editor($topic_id,$conf_id);
							$auth_users = array();
							foreach ($data["topic_users"] as $key => $user) {
								array_push($auth_users, $user->user_login);
							}
							$data['auth_users'] = $auth_users;
							$this->form_validation->set_rules(
						        'submit', '送出',
						        'required',
						        array(
									'required'   => '請透過表單送出'
						        )
							);
							if ($this->form_validation->run()){
								$user_logins = $this->input->post('user_login[]');
								$submit = $this->input->post('submit');
								if( is_array($user_logins) ){
									switch($submit){
										case "add":
											foreach ($user_logins as $key => $user_login) {
												if( $this->conf->add_assign_topic($topic_id,$conf_id,$user_login) ){
													$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 設為 <strong>".$data["topic"]["topic_name"]."(".$data["topic"]["topic_name_eng"].")</strong> 主編");
												}else{
													$this->alert->show("d","無法將使用者 <strong>".$user_login."</strong> 設為 <strong>".$data["topic"]["topic_name"]."(".$data["topic"]["topic_name_eng"].")</strong> 主編");
												}
											}
										break;
										case "del":
											foreach ($user_logins as $key => $user_login) {
												if( $this->conf->del_assign_topic($topic_id,$conf_id,$user_login) ){
													$this->alert->show("s","已將使用者 <strong>".$user_login."</strong> 取消 <strong>".$data["topic"]["topic_name"]."(".$data["topic"]["topic_name_eng"].")</strong> 主編");
												}else{
													$this->alert->show("d","無法將使用者 <strong>".$user_login."</strong> 取消 <strong>".$data["topic"]["topic_name"]."(".$data["topic"]["topic_name_eng"].")</strong> 主編");
												}
											}
										break;
									}
								}
							}
							$this->load->view('conf/topic/assign',$data);
						}else{
							$this->alert->show("d","研討會主題不存在",get_url("dashboard",$conf_id,"topic"));
						}
					break;
				}
			}
			
			$this->load->view('common/footer');
		}
	}

	public function website($conf_id='',$do='all'){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			$data['conf_lang'] = explode(",", $conf_config['conf_lang']);
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}

			if( is_null( $this->input->get('id', TRUE)) && $do=="all"){
				$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
				$this->assets->add_js(asset_url().'js/repeatable.js',true);
			}

			if( $do=="edit" || $do=="add" ){
				$this->assets->add_js(base_url('ckeditor/ckeditor.js'));
			}

			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			if( is_null( $this->input->get('id', TRUE)) ){
				switch($do){
					default:
					case "all":
						if(in_array("zhtw",$data['conf_lang'])){
							$this->form_validation->set_rules('zhtw[]', '', 'required');
							$data['contents']['zhtw'] = $this->conf->get_contents($conf_id,"zhtw");
							
							if($this->form_validation->run()){
								$zhtw=$this->input->post('zhtw');
								foreach($zhtw['page_id'] as $key => $page_id){
									$page_order = $key+1;
									if( array_key_exists($page_id, $zhtw['show']) ){
										$page_show  = 1;
										$text = "公開";
									}else{
										$page_show  = 0;
										$text = "隱藏";
									}
									if( $this->conf->update_contents($conf_id,$page_id,'zhtw',$page_order,$page_show) ){
										$this->alert->show("s","成功更新".$page_id."順序及狀態(".$text.")");
									}else{
										$this->alert->show("d","更新".$page_id."順序及狀態失敗(".$text.")");
									}
								}
								$this->alert->refresh(2);
							}
						}
						if(in_array("eng",$data['conf_lang'])){
							$this->form_validation->set_rules('eng[]', '', 'required');
							$data['contents']['eng'] = $this->conf->get_contents($conf_id,"eng");
							
							if($this->form_validation->run()){
								$eng=$this->input->post('eng');
								foreach($eng['page_id'] as $key => $page_id){
									$page_order = $key+1;
									if( array_key_exists($page_id, $eng['show']) ){
										$page_show  = 1;
										$text = "公開";
									}else{
										$page_show  = 0;
										$text = "隱藏";
									}
									if( $this->conf->update_contents($conf_id,$page_id,'eng',$page_order,$page_show) ){
										$this->alert->show("s","成功更新".$page_id."順序及狀態(".$text.")");
									}else{
										$this->alert->show("d","更新".$page_id."順序及狀態失敗(".$text.")");
									}
								}
								//$this->alert->refresh(2);
							}
						}
						
						$this->load->view('conf/content/all',$data);
					break;
					case "add":
						$this->form_validation->set_rules('page_title[]', '標題', 'required');
						$this->form_validation->set_rules('page_id', '網頁簡稱', 'required');
						$this->form_validation->set_rules('page_content[]', '網頁內容', 'required');
						if($this->form_validation->run()){
							$page_title   =$this->input->post('page_title');
							$page_id      =$this->input->post('page_id');
							$page_content =$this->input->post('page_content',false);
							if(in_array("zhtw",$data['conf_lang'])){
								if( $this->conf->add_content($conf_id,$page_id,$page_title['zhtw'],$page_content['zhtw'],'zhtw') ){
									$this->alert->show("s","成功新增".$page_id."網頁內容");
								}else{
									$this->alert->show("d","新增".$page_id."網頁內容失敗");
								}
							}
							if(in_array("eng",$data['conf_lang'])){
								if( $this->conf->add_content($conf_id,$page_id,$page_title['eng'],$page_content['eng'],'eng') ){
									$this->alert->show("s","成功新增".$page_id."網頁內容");
								}else{
									$this->alert->show("d","新增".$page_id."網頁內容失敗");
								}
							}
							$this->alert->refresh(2);
						}
						$this->load->view('conf/content/add',$data);
					break;
				}
			}else{
				$page_id   = $this->input->get('id', TRUE);
				$page_lang = $this->input->get('lang', TRUE);
				switch($do){
					case "edit":
						$data['page_id']=$page_id;
						$data['content']=$this->conf->get_content($conf_id,$page_id,$page_lang);
						if( !empty($data['content']) ){
							$this->form_validation->set_rules('page_title', '標題', 'required');
							$this->form_validation->set_rules('page_content', '網頁內容', 'required');
							if($this->form_validation->run()){
								$page_title   =$this->input->post('page_title');
								$page_content =$this->input->post('page_content',false);
								if( $this->conf->update_content($conf_id,$page_id,$page_lang,$page_title,$page_content) ){
									$this->alert->show("s","成功更新".$page_id."網頁內容");
								}else{
									$this->alert->show("d","更新".$page_id."網頁內容失敗");
								}
								$this->alert->refresh(2);
							}
						}
						$this->load->view('conf/content/edit',$data);
					break;
					case "del":
						if( $this->conf->del_contents($conf_id,$page_id) ){
							$this->alert->js("成功刪除".$page_id."網頁內容",get_url("dashboard",$conf_id,"website"));
						}else{
							$this->alert->js("刪除".$page_id."網頁內容失敗",get_url("dashboard",$conf_id,"website"));
						}
					break;
				}
			}
			$this->load->view('common/footer');
		}
	}

	public function filter($conf_id='',$type=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->assets->add_js(base_url('ckeditor/ckeditor.js'));
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			if( is_null( $this->input->get('id', TRUE)) ){
				switch($type){
					default:
					case "all":
						$data['filters']=$this->conf->get_filter($conf_id);
						$this->load->view('conf/filter/all',$data);
					break;
					case "add":
						$this->form_validation->set_rules('content', '檢核清單內容', 'required');
						$this->form_validation->set_rules('econtent', '檢核清單內容(英)', 'required');
						
						if ($this->form_validation->run()){
							$filter_content     = $this->input->post('content',false);
							$filter_content_eng = $this->input->post('econtent',false);
							if( $this->conf->add_filter($conf_id,$filter_content,$filter_content_eng) ){
								$this->alert->show("s","成功建立投稿檢核清單",get_url("dashboard",$conf_id,"filter","add"));
							}else{
								$this->alert->show("d","無法建立投稿檢核清單");
							}
						}
						$this->load->view('conf/filter/add',$data);
					break;
				}
			}else{
				$filter_id = $this->input->get('id', TRUE);
				switch($type){
					case "edit":
						$data['filter']=$this->conf->get_filter_info($conf_id,$filter_id);
						if( !empty($data['filter']) ){
							$this->form_validation->set_rules('content', '檢核清單內容', 'required');
							$this->form_validation->set_rules('econtent', '檢核清單內容(英)', 'required');
							if ($this->form_validation->run()){
								$filter_content     = $this->input->post('content',false);
								$filter_content_eng = $this->input->post('econtent',false);
								if( $this->conf->update_filter($conf_id,$filter_id,$filter_content,$filter_content_eng) ){
									$this->alert->show("s","成功更新投稿檢核清單",get_url("dashboard",$conf_id,"filter","edit")."?id=".$filter_id);
								}else{
									$this->alert->show("d","無法更新投稿檢核清單");
								}
							}

							$this->load->view('conf/filter/edit',$data);
						}else{
							$this->alert->show("d","查無投稿檢核清單",get_url("dashboard",$conf_id,"filter"));
						}
					break;
				}
			}
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}


	public function user($conf_id='',$do="all",$user_login=""){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['do']=$do;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			if( ( empty($user_login) && $do=="add" ) || ( !empty($user_login) && $do=="edit" ) ){
				$country_list = config_item('country_list');
				$data['country_list'] = $country_list['zhtw'];

				$this->assets->add_css(asset_url().'style/chosen.css');

				$this->assets->add_js(asset_url().'js/pwstrength-bootstrap-1.2.3.min.js');
				$this->assets->add_js(asset_url().'js/pwstrength-setting.js');
				$this->assets->add_js(asset_url().'js/jquery.validate.min.js');
				$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
				$this->assets->add_js(asset_url().'js/chosen.jquery.js');
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_conf',$data);

			if( empty($user_login) ){
				switch($do){
					case "add":
						$this->load->view('js/signup');
						$this->user->user_valid();
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
					    	$user_postaddr = $user_addcounty."|".$user_area."|".$user_postaddr;
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
					    $this->load->view('conf/user/add',$data);
					break;
					default:
					case "all": // view all users
						$data['users']=$this->user->get_all_users(10);
						$data['confs']=$this->user->get_conf_array($conf_id);
						$data['reviewers']=$this->user->get_reviewer_array($conf_id);
						
						$this->form_validation->set_rules('type', '操作', 'required');
						$this->form_validation->set_rules('user_login[]', '帳號', 'required');
					    if ($this->form_validation->run()){
					    	$type = $this->input->post('type');
					    	$user_logins = $this->input->post('user_login');
					    	switch($type){
					    		case "add_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->add_conf($conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."<strong> 設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."<strong> 設為研討會管理員失敗");
					    				}
					    			}
					    		break;
					    		case "del_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->del_conf($conf_id,$user_login) ){
					    					$this->alert->show("s","將使用者 <strong>".$user_login."<strong> 取消設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."<strong> 取消研討會管理員失敗");
					    				}
					    			}
					    		break;
					    		case "add_review":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->add_reviewer($conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."<strong> 設為審查人");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."<strong> 設為審查人失敗");
					    				}
					    			}
					    		break;
					    		case "del_review":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->del_reviewer($conf_id,$user_login) ){
					    					$this->alert->show("s","將使用者 <strong>".$user_login."<strong> 取消設為審查人失敗");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."<strong> 取消審查人失敗");
					    				}
					    			}
					    		break;
					    	}
					    	$this->alert->refresh(2);
					    }
						$this->load->view('conf/user/all',$data);
					break;
					case "import":
						
						
					break;
				}
			}else{
				if($this->user->username_exists($user_login)){
					$data['user']=$this->user->get_user_info($user_login);
					$data['user']->user_phone_o=explode(",", $data['user']->user_phone_o);
					$data['user']->user_postaddr=explode("|", $data['user']->user_postaddr);
					$country_list = config_item('country_list');
					$data['country_list'] = $country_list['zhtw'];

					switch($do){
						case "edit":
							$this->user->user_valid();
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
						    		$this->alert->js("Edit Success");
						    	}else{
						    		$this->alert->js($res['error']);
						    		$this->form_validation->set_message('signup_error', $res['error']);
						    	}
						    }
							$this->load->view('js/signup');
							$this->load->view('conf/user/edit',$data);
						break;
					}
				}
			}
			$this->load->view('common/footer');
		}
	}

	public function news($conf_id='',$type=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->assets->add_js(base_url('ckeditor/ckeditor.js'));
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			if( is_null( $this->input->get('id', TRUE)) ){
				switch($type){
					default:
					case "all":
						$data['news']=$this->conf->get_news($conf_id);
						$this->load->view('conf/news/all',$data);
					break;
					case "add":
						switch ($data['conf_config']['default_lang']) {
							default:
							case 'zhtw':
								$this->form_validation->set_rules('news_title', '公告標題', 'required');
								$this->form_validation->set_rules('news_content', '公告內容', 'required');
							break;
							case 'eng':
								$this->form_validation->set_rules('news_title_eng', '公告標題(英)', 'required');
								$this->form_validation->set_rules('news_content_eng', '公告內容(英)', 'required');
							break;
						}
						
						if ($this->form_validation->run()){
							$news_title       = $this->input->post('news_title');
							$news_content     = $this->input->post('news_content',false);
							$news_title_eng   = $this->input->post('news_title_eng');
							$news_content_eng = $this->input->post('news_content_eng',false);
							if( $this->conf->add_news($conf_id,$news_title,$news_content,$news_title_eng,$news_content_eng) ){
								$this->alert->show("s","成功建立公告",get_url("dashboard",$conf_id,"news","add"));
							}else{
								$this->alert->show("d","無法建立公告");
							}
						}
						$this->load->view('conf/news/add',$data);
					break;
				}
			}else{
				$news_id = $this->input->get('id', TRUE);
				switch($type){
					case "edit":
						$data['news']=$this->conf->get_news_info($conf_id,$news_id);
						if( !empty($data['news']) ){
							switch ($data['conf_config']['default_lang']) {
								default:
								case 'zhtw':
									$this->form_validation->set_rules('news_title', '公告標題', 'required');
									$this->form_validation->set_rules('news_content', '公告內容', 'required');
								break;
								case 'eng':
									$this->form_validation->set_rules('news_title_eng', '公告標題(英)', 'required');
									$this->form_validation->set_rules('news_content_eng', '公告內容(英)', 'required');
								break;
							}
							
							if ($this->form_validation->run()){
								$news_title       = $this->input->post('news_title');
								$news_content     = $this->input->post('news_content',false);
								$news_title_eng   = $this->input->post('news_title_eng');
								$news_content_eng = $this->input->post('news_content_eng',false);
								if( $this->conf->update_news($conf_id,$news_id,$news_title,$news_content,$news_title_eng,$news_content_eng) ){
									$this->alert->show("s","成功更新公告",get_url("dashboard",$conf_id,"news","add"));
								}else{
									$this->alert->show("d","無法更新公告");
								}
							}

							$this->load->view('conf/news/edit',$data);
						}else{
							$this->alert->show("d","查無公告",get_url("dashboard",$conf_id,"filter"));
						}
					break;
				}
			}
			$this->load->view('common/footer');
		}
	}

	public function email($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}

	public function submit($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$data['papers']=$this->Submit->get_allpaper($conf_id);
			
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			$this->load->view('conf/submit/list',$data);
			$this->load->view('common/footer');
		}
	}

	public function signup($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}

	public function report($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}

	public function logs($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}

	public function modules($conf_id='',$do="all",$module_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			
			$this->load->view('conf/menu_conf',$data);
			
			if( empty($module_id) ){
				switch($do){
					case "all":
						$data['module_zhtw'] = $this->conf->get_module($conf_id,"zhtw");
						$data['module_eng'] = $this->conf->get_module($conf_id,"eng");
						$this->load->view('conf/module/all',$data);
					break;
					case "add":
						$module = $this->input->get('module');
						switch ($module) {
							case "news":
								$this->form_validation->set_rules('module_title', '標題', 'required');
								$this->form_validation->set_rules('module_position', '位置', 'required');
								$this->form_validation->set_rules('module_showtitle', '顯示/隱藏標題', 'required');
								$this->form_validation->set_rules('module_lang', '語言', 'required');
								if($this->form_validation->run()){
									$module_title = $this->input->post("module_title");
									$module_position = $this->input->post("module_position");
									$module_showtitle = $this->input->post("module_showtitle");
									$module_lang = $this->input->post("module_lang");
									if( $this->module->add_news($conf_id,$module_title,$module_position,$module_showtitle,$module_lang) ){
										$this->alert->show("s","成功新增文字模組");
									}else{
										$this->alert->show("d","新增文字模組失敗");
									}
									$this->alert->refresh(2);
								}
								$this->load->view('conf/module/add_news',$data);
							break;
							case "text":
							default:
								$this->form_validation->set_rules('module_title', '標題', 'required');
								$this->form_validation->set_rules('module_position', '位置', 'required');
								$this->form_validation->set_rules('module_showtitle', '顯示/隱藏標題', 'required');
								$this->form_validation->set_rules('module_lang', '語言', 'required');
								$this->form_validation->set_rules('module_content', '內容', 'required');
								if($this->form_validation->run()){
									$module_title = $this->input->post("module_title");
									$module_position = $this->input->post("module_position");
									$module_showtitle = $this->input->post("module_showtitle");
									$module_lang = $this->input->post("module_lang");
									$module_content = $this->input->post("module_content",false);
									if( $this->module->add_text($conf_id,$module_title,$module_position,$module_showtitle,$module_lang,$module_content) ){
										$this->alert->show("s","成功新增文字模組");
									}else{
										$this->alert->show("d","新增文字模組失敗");
									}
									//$this->alert->refresh(2);
								}
								$this->assets->add_js(base_url('ckeditor/ckeditor.js'),true);
								$this->load->view('conf/module/add_text',$data);
							break;
						}
					break;
				}
			}
			$this->load->view('common/footer');
		}
	}
	// Template
	private function _temp($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$conf_config=$this->conf->conf_config($conf_id,$user_sysop);
			$data['conf_config']=$conf_config;
			//$data['schedule']=$this->conf->conf_schedule($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);
			
			if( !$this->user->is_conf() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			//$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}
}