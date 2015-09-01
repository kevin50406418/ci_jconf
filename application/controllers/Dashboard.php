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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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

	public function website($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
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

	public function filter($conf_id='',$type=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
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

	public function user($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
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

	public function news($conf_id='',$type=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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

	public function signup($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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
			$data['conf_config']=$this->conf->conf_config($conf_id);
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