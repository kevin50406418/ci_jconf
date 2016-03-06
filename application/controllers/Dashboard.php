<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.1.0
 * @date	2016/3/4
 */

class Dashboard extends MY_Conference {
	public function __construct(){
		parent::__construct();
		$this->lang->load("dashboard",$this->_lang);
		$this->cinfo['show_confinfo'] = true;
		$this->user_sysop = $this->is_sysop?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($this->conf_id,$this->user->is_conf($this->conf_id)) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		$this->is_sysop    = $this->user_sysop;
		$this->is_conf     = $this->user->is_conf($this->conf_id);
		$this->is_topic    = $this->user->is_topic($this->conf_id);
		$this->is_reviewer = $this->user->is_reviewer($this->conf_id);
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->is_conf);
		$this->data['conf_id']     = $this->conf_id;
		$this->data['body_class']  = $this->body_class;
		$this->data['conf_config'] = $this->conf_config;

		if( !$this->is_conf && !$this->user_sysop ){
			$this->conf->show_permission_deny($this->data);
		}
		$this->assets->set_title_separator(" | ");
		$this->assets->set_site_name($this->conf_config['conf_name']);

		$this->data['spage']        = $this->config->item('spage');
		$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);
		$this->data['schedules']    = $this->conf->get_schedules($this->conf_id);
		$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);

		if( $this->is_topic || $this->is_sysop ){
			$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
		}
		if( $this->is_reviewer || $this->is_sysop ){
			$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
		}
	}

	public function index($conf_id=''){
		$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
		$this->assets->add_css(asset_url().'style/datepicker.css');
		$this->assets->add_js(asset_url().'js/bootstrap-datepicker.js');
		$this->assets->add_js(asset_url().'js/locales/bootstrap-datepicker.zh-TW.js');
		$this->assets->add_js(asset_url().'js/repeatable-fields.js');
		$this->assets->set_title(lang('dashboard_setting'));

		$schedule = $this->conf->get_schedules($this->conf_id);
		$this->data['schedule'] = $schedule;
		$this->data['styles'] = $this->conf->get_style();

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);

		if( !is_null($this->input->post("do")) ){
			$do = $this->input->post("do");
			switch($do){
				case "status":
					$this->form_validation->set_rules('conf_staus', lang('conf_staus'), 'required');
					if ($this->form_validation->run()){
						$conf_staus = $this->input->post('conf_staus');
						$valid_status = array(0,1);
						if( in_array($conf_staus,$valid_status) ){
							if( $this->conf->update_status($this->conf_id,$conf_staus) ){
								$this->alert->js(lang('update_success'));
							}else{
								$this->alert->js(lang('update_fail'));
							}
							$this->alert->refresh(0);
						}else{
							$this->alert->js(lang('conf_staus_setting_fail'));
						}
					}
				break;
				case "style":
					$this->form_validation->set_rules('style', lang('conf_style'), 'required');
					if ($this->form_validation->run()){
						$style = $this->input->post('style');
						if( $this->conf->update_confstyle($this->conf_id,$style) ){
							$this->alert->js(lang('conf_style').lang('update_success'));
						}else{
							$this->alert->js(lang('conf_style').lang('update_fail'));
						}
						$this->alert->refresh(0);
					}
				break;
				case "config":
					$this->form_validation->set_rules('conf_name', lang('conf_name'), 'required');
					$this->form_validation->set_rules('conf_master', lang('conf_master'), 'required');
					$this->form_validation->set_rules('conf_email', lang('conf_email'), 'required');
					$this->form_validation->set_rules('conf_phone', lang('conf_phone'), 'required');
					$this->form_validation->set_rules('conf_address', lang('conf_address'), 'required');
					$this->form_validation->set_rules('conf_host', lang('conf_host'), 'required');
					$this->form_validation->set_rules('conf_place', lang('conf_place'), 'required');
					$this->form_validation->set_rules('conf_desc', lang('conf_desc'), 'required');
					$this->form_validation->set_rules('conf_keywords', lang('conf_keywords'), 'required');
					if ($this->form_validation->run()){
						$conf_name    = $this->input->post('conf_name');
						$conf_master  = $this->input->post('conf_master');
						$conf_email   = $this->input->post('conf_email');
						$conf_phone   = $this->input->post('conf_phone');
						$conf_host    = $this->input->post('conf_host');
						$conf_fax     = $this->input->post('conf_fax');
						$conf_address = $this->input->post('conf_address');
						$conf_place   = $this->input->post('conf_place');
						$conf_desc    = $this->input->post('conf_desc');
						$conf_keywords= $this->input->post('conf_keywords');
						if( $this->conf->update_confinfo($this->conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_fax,$conf_address,$conf_host,$conf_place,$conf_keywords,$conf_desc) ){
							$this->alert->js(lang('update_success'));
						}else{
							$this->alert->js(lang('update_fail'));
						}
						$this->alert->refresh(1);
					}
				break;
				case "func":
					$this->form_validation->set_rules('conf_col', lang('home_layout'), 'required');
					$this->form_validation->set_rules('conf_most', lang('conf_most'), 'required');
					$this->form_validation->set_rules('topic_assign', "主編設置審查人", 'required');
					if ($this->form_validation->run()){
						$conf_col     = $this->input->post('conf_col');
						$conf_most    = $this->input->post('conf_most');
						$topic_assign = $this->input->post('topic_assign');
						if( $this->conf->update_confcol($this->conf_id,$conf_col) ){
							$this->alert->show("s",lang('home_layout').lang('update_success'));
						}else{
							$this->alert->show("d",lang('home_layout').lang('update_fail'));
						}
						if( $this->conf->update_confmost($this->conf_id,$conf_most) ){
							$this->alert->show("s",lang('conf_most').lang('update_success'));
						}else{
							$this->alert->show("d",lang('conf_most').lang('update_fail'));
						}
						if( $this->conf->update_topic_assign($this->conf_id,$topic_assign) ){
							$this->alert->show("s",lang('conf_topic_assign').lang('update_success'));
						}else{
							$this->alert->show("d",lang('conf_topic_assign').lang('update_fail'));
						}
						$this->alert->refresh(1);
					}
				break;
				case "schedule":
					$this->form_validation->set_rules('do', "do", 'required');
					if ($this->form_validation->run()){
						$sc = $this->input->post("sc");
						if( $this->conf->update_schedules($this->conf_id,$sc) ){
							$this->alert->js("更新成功");
						}else{
							$this->alert->js("更新失敗");
						}
						$this->alert->refresh(2);
					}
				break;
			}
		}
		$this->load->view('conf/setting',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function setting($conf_id=''){
		$this->index($this->conf_id);
	}

	public function topic($conf_id='',$type=''){
		$this->data['count_editor'] = $this->conf->count_editor($this->conf_id);

		if( !is_null( $this->input->get('id', TRUE)) && $type =="assign" ){
			$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
			$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
			$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		}

		if( $type == "all" || empty($type) ){
			$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
			$this->assets->add_js(asset_url().'js/repeatable.js',true);
		}

		$this->assets->set_title(lang('dashboard_topic'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		
		if( is_null( $this->input->get('id', TRUE)) ){
			switch($type){
				default:
				case "all":
					$this->form_validation->set_rules('topic_id[]', '研討會主題', 'required');
					if ($this->form_validation->run()){
						$topic_array = $this->input->post("topic_id");
						if( $this->conf->sort_topic($this->conf_id,$topic_array) ){
							$this->alert->show("s","研討會主題順序調整成功");
						}else{
							$this->alert->show("d","研討會主題順序調整失敗");
						}
						$this->alert->refresh(2);
					}
					$this->data['topics'] = $this->conf->get_topic($this->conf_id);
					$this->load->view('conf/topic/all',$this->data);
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
						if( $this->conf->add_topic($this->conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng) ){
							$this->alert->show("s","成功加入研討會主題: '".$topic_name."(".$topic_name_eng.")'");
							$this->alert->refresh(2);
						}else{
							$this->alert->show("d","無法加入研討會主題: '".$topic_name."(".$topic_name_eng.")'");
						}
					}
					$this->load->view('conf/topic/add',$this->data);
				break;
			}
		}else{
			$topic_id=$this->input->get('id', TRUE);
			switch($type){
				case "remove":
					$topic_array = $this->conf->get_topic_info($this->conf_id,$topic_id);
					if(is_array($topic_array)){
						switch( $this->conf->del_topic($this->conf_id,$topic_id) ){
							case "0":
								$this->alert->js("主題刪除失敗");
							break;
							case "1":
								$this->alert->js("主題刪除成功");
							break;
							case "2":
								$this->alert->js("主題刪除失敗(失敗資訊：存在投稿資料)");
							break;
						}
					}else{
						$this->alert->js("查無此主題");
					}
					$this->alert->refresh(1,get_url("dashboard",$this->conf_id,"topic"));
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
						if( $this->conf->update_topic($topic_id,$this->conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng) ){
							$this->alert->show("s","成功更改研討會主題: '".$topic_name."(".$topic_name_eng.")'");
						}else{
							$this->alert->show("d","無法更改研討會主題: '".$topic_name."(".$topic_name_eng.")'");
						}
						$this->alert->refresh(2);
					}
					$this->data["topic"] = $this->conf->get_topic_info($this->conf_id,$topic_id);
					$this->load->view('conf/topic/edit',$this->data);
				break;
				case "assign":
					$this->data['users'] = $this->user->get_all_users(0);
					$this->data["topic"] = $this->conf->get_topic_info($this->conf_id,$topic_id);
					if( !empty($this->data["topic"]) ){
						$this->data["topic_users"] = $this->conf->get_editor($topic_id,$this->conf_id);
						$auth_users = array();
						foreach ($this->data["topic_users"] as $key => $user) {
							array_push($auth_users, $user->user_login);
						}
						$this->data['auth_users'] = $auth_users;
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
											if( $this->conf->add_assign_topic($topic_id,$this->conf_id,$user_login) ){
												$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 設為 <strong>".$this->data["topic"]["topic_name"]."(".$this->data["topic"]["topic_name_eng"].")</strong> 主編");
											}else{
												$this->alert->show("d","無法將使用者 <strong>".$user_login."</strong> 設為 <strong>".$this->data["topic"]["topic_name"]."(".$this->data["topic"]["topic_name_eng"].")</strong> 主編");
											}
										}
									break;
									case "del":
										foreach ($user_logins as $key => $user_login) {
											if( $this->conf->del_assign_topic($topic_id,$this->conf_id,$user_login) ){
												$this->alert->show("s","已將使用者 <strong>".$user_login."</strong> 取消 <strong>".$this->data["topic"]["topic_name"]."(".$this->data["topic"]["topic_name_eng"].")</strong> 主編");
											}else{
												$this->alert->show("d","無法將使用者 <strong>".$user_login."</strong> 取消 <strong>".$this->data["topic"]["topic_name"]."(".$this->data["topic"]["topic_name_eng"].")</strong> 主編");
											}
										}
									break;
								}
								$this->alert->refresh(2);
							}
						}
						$this->load->view('conf/topic/assign',$this->data);
					}else{
						$this->alert->show("d","研討會主題不存在",get_url("dashboard",$this->conf_id,"topic"));
					}
				break;
			}
		}
		$this->load->view('common/footer',$this->data);
	}

	public function website($conf_id='',$do='all'){
		$this->data['conf_lang']    = explode(",", $this->conf_config['conf_lang']);

		if( $do=="all"){
			$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
			$this->assets->add_js(asset_url().'js/repeatable.js',true);
		}

		if( $do=="edit" || $do=="add" ){
			$this->assets->add_js(base_url().'tinymce/tinymce.min.js');
		}

		$this->assets->set_title(lang('dashboard_website'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		if( is_null( $this->input->get('id', TRUE)) ){
			switch($do){
				default:
				case "all":
					$show_alert = true;
					if(in_array("zhtw",$this->data['conf_lang'])){
						$this->form_validation->set_rules('zhtw[]', '', 'required');
						$this->data['contents']['zhtw'] = $this->conf->get_contents($this->conf_id,"zhtw");
						
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
								if( !$this->conf->update_contents($this->conf_id,$page_id,'zhtw',$page_order,$page_show) ){
									$this->alert->show("d","更新".$page_id."順序及狀態失敗(".$text.")");
								}
							}
							if($show_alert){
								$this->alert->js("更新成功");
								$show_alert = false;
								$this->alert->refresh(2);
							}
						}
					}
					if(in_array("eng",$this->data['conf_lang'])){
						$this->form_validation->set_rules('eng[]', '', 'required');
						$this->data['contents']['eng'] = $this->conf->get_contents($this->conf_id,"en");
						
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
								if( !$this->conf->update_contents($this->conf_id,$page_id,'eng',$page_order,$page_show) ){
									$this->alert->show("d","更新".$page_id."順序及狀態失敗(".$text.")");
								}
							}
							if($show_alert){
								$this->alert->js("更新成功");
								$show_alert = false;
								$this->alert->refresh(2);
							}
						}
					}
					$this->load->view('conf/content/all',$this->data);
				break;
				case "add":
					$this->form_validation->set_rules('page_title[]', '標題', 'required');
					$this->form_validation->set_rules('page_id', '網頁簡稱', 'required|alpha_numeric_spaces');
					// $this->form_validation->set_rules('page_content[]', '網頁內容', 'required');
					if($this->form_validation->run()){
						$page_title   =$this->input->post('page_title');
						$page_id      =$this->input->post('page_id');
						$page_content =$this->input->post('page_content',false);

						if(in_array("zhtw",$this->data['conf_lang'])){
							if( $this->conf->add_content($this->conf_id,$page_id,$page_title['zhtw'],$page_content['zhtw'],'zhtw') ){
								$this->alert->show("s","成功新增".$page_id."[中文]網頁內容");
							}else{
								$this->alert->show("d","新增".$page_id."[中文]網頁內容失敗");
							}
						}

						if(in_array("eng",$this->data['conf_lang'])){
							if( $this->conf->add_content($this->conf_id,$page_id,$page_title['en'],$page_content['en'],'en') ){
								$this->alert->show("s","成功新增".$page_id."[英文]網頁內容");
							}else{
								$this->alert->show("d","新增".$page_id."[英文]網頁內容失敗");
							}
						}
						$this->alert->refresh(2);
					}
					$this->load->view('common/tinymce',$this->data);
					$this->load->view('conf/content/add',$this->data);
				break;
			}
		}else{
			$page_id   = $this->input->get('id', TRUE);
			$page_lang = $this->input->get('lang', TRUE);
			switch($do){
				case "edit":
					$spage=$this->config->item('spage');
					$this->data['spage']=$spage;
					$this->data['page_id']=$page_id;
					$this->data['content']=$this->conf->get_content($this->conf_id,$page_id,$page_lang);
					if( !empty($this->data['content']) ){
						$this->form_validation->set_rules('page_title', '標題', 'required');
						if($this->form_validation->run()){
							$page_title   = $this->input->post('page_title');
							$page_content = $this->input->post('page_content',false);
							if( $this->conf->update_content($this->conf_id,$page_id,$page_lang,$page_title,$page_content) ){
								$this->alert->show("s","成功更新".$page_id."網頁內容");
							}else{
								$this->alert->show("d","更新".$page_id."網頁內容失敗");
							}
							$this->alert->refresh(2);
						}
					}
					$this->load->view('common/tinymce',$this->data);
					$this->load->view('conf/content/edit',$this->data);
				break;
				case "del":
					if( $this->conf->del_contents($this->conf_id,$page_id) ){
						$this->alert->js("成功刪除".$page_id."網頁內容",get_url("dashboard",$this->conf_id,"website"));
					}else{
						$this->alert->js("刪除".$page_id."網頁內容失敗",get_url("dashboard",$this->conf_id,"website"));
					}
				break;
			}			
		}
		$this->load->view('common/footer',$this->data);
	}

	public function filter($conf_id='',$type=''){
		$this->assets->set_title(lang('dashboard_filter'));
		$this->assets->add_js(base_url('ckeditor/ckeditor.js'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		if( is_null( $this->input->get('id', TRUE)) ){
			switch($type){
				default:
				case "all":
					$this->data['filters']=$this->conf->get_filter($this->conf_id);
					$this->load->view('conf/filter/all',$this->data);
				break;
				case "add":
					$this->form_validation->set_rules('content', '檢核清單內容', 'required');
					$this->form_validation->set_rules('econtent', '檢核清單內容(英)', 'required');
					
					if ($this->form_validation->run()){
						$filter_content     = $this->input->post('content',false);
						$filter_content_eng = $this->input->post('econtent',false);
						if( $this->conf->add_filter($this->conf_id,$filter_content,$filter_content_eng) ){
							$this->alert->show("s","成功建立投稿檢核清單",get_url("dashboard",$this->conf_id,"filter","add"));
						}else{
							$this->alert->show("d","無法建立投稿檢核清單");
						}
					}
					$this->load->view('conf/filter/add',$this->data);
				break;
			}
		}else{
			$filter_id = $this->input->get('id', TRUE);
			switch($type){
				case "edit":
					$this->data['filter']=$this->conf->get_filter_info($this->conf_id,$filter_id);
					if( !empty($this->data['filter']) ){
						$this->form_validation->set_rules('content', '檢核清單內容', 'required');
						$this->form_validation->set_rules('econtent', '檢核清單內容(英)', 'required');
						if ($this->form_validation->run()){
							$filter_content     = $this->input->post('content',false);
							$filter_content_eng = $this->input->post('econtent',false);
							if( $this->conf->update_filter($this->conf_id,$filter_id,$filter_content,$filter_content_eng) ){
								$this->alert->show("s","成功更新投稿檢核清單",get_url("dashboard",$this->conf_id,"filter","edit")."?id=".$filter_id);
							}else{
								$this->alert->show("d","無法更新投稿檢核清單");
							}
						}

						$this->load->view('conf/filter/edit',$this->data);
					}else{
						$this->alert->show("d","查無投稿檢核清單",get_url("dashboard",$this->conf_id,"filter"));
					}
				break;
				case "del":
					if( $this->conf->del_filter($this->conf_id,$filter_id) ){
						$this->alert->js("刪除投稿檢核清單成功",get_url("dashboard",$this->conf_id,"filter"));
					}else{
						$this->alert->js("刪除投稿檢核清單失敗",get_url("dashboard",$this->conf_id,"filter"));
					}
				break;
			}
		}
		$this->load->view('common/footer',$this->data);
	}


	public function user($conf_id='',$do="all",$user_login=""){
		$this->lang->load("user",$this->_lang);
		
		$this->data['do']           = $do;
		$this->data['topics']       = $this->conf->get_topic($this->conf_id);

		$this->assets->set_title(lang('dashboard_user'));

		if(  !empty($user_login) && $do== "edit"  ){
			$country_list = config_item('country_list');
			$this->data['country_list'] = $country_list[$this->_lang];

			$this->assets->add_css(asset_url().'style/chosen.css');

			$this->assets->add_js(asset_url().'js/pwstrength-bootstrap-1.2.3.min.js');
			$this->assets->add_js(asset_url().'js/pwstrength-setting.js');
			$this->assets->add_js(asset_url().'js/jquery.validate.min.js');
			$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
			$this->assets->add_js(asset_url().'js/chosen.jquery.js');
		}
		if( $do== "add" ){
			$country_list = config_item('country_list');
			$this->data['country_list'] = $country_list[$this->_lang];
			$this->assets->add_js(asset_url().'js/repeatable-addusers.js');
			$this->assets->add_js(asset_url().'js/jquery.twzipcode.min.js');
		}
		if( ( empty($user_login) && $do=="all" ) ){
			$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
			$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
			$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		}
		if( !$this->input->is_ajax_request() ){
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('conf/conf_nav',$this->data);
			$this->load->view('conf/menu_conf',$this->data);
		}
		if( empty($user_login) ){
			switch($do){
				case "add":
					$this->user->users_valid();
				    if ($this->form_validation->run()){
				    	$user_login = $this->input->post('user_id');
				    	$user_email = $this->input->post('user_email');
				    	$user_title = $this->input->post('user_title');
				    	$user_firstname = $this->input->post('user_firstname');
				    	$user_lastname = $this->input->post('user_lastname');
				    	$user_gender = $this->input->post('user_gender');
				    	$user_org = $this->input->post('user_org');
				    	$user_phoneO_1 = $this->input->post('user_phoneO_1');
				    	$user_phoneO_2 = $this->input->post('user_phoneO_2');
				    	$user_phoneO_3 = $this->input->post('user_phoneO_3');
				    	$user_phoneO_3 = $this->input->post('user_phoneO_3');
				    	$user_postcode = $this->input->post('user_postcode');
				    	$user_addcounty = $this->input->post('user_addcounty');
				    	$user_area = $this->input->post('user_area');
				    	$user_postaddr = $this->input->post('user_postadd');
				    	$user_country = $this->input->post('user_country');
				    	$user_research = $this->input->post('user_research');
						foreach ($user_login as $key => $login) {
							$user_phone_o = $user_phoneO_1[$key].",".$user_phoneO_2[$key].",".$user_phoneO_3[$key];
				    		$user_postaddr = $user_addcounty[$key]."|".$user_area[$key]."|".$user_postaddr[$key];
				    		$user_pass = $this->user->generator_password(8);
				    		$res = $this->user->adduser($user_login[$key],$user_pass,$user_title[$key],$user_email[$key],$user_firstname[$key],$user_lastname[$key],$user_gender[$key],$user_org[$key],$user_phone_o,"","",$user_postcode[$key],$user_postaddr,$user_country[$key],"zhtw",$user_research[$key]);
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
				    $this->load->view('conf/user/add',$this->data);
				break;
				default:
				case "all": // view all users
					$this->data['users']=$this->user->get_all_users(10);
					$this->data['confs']=$this->user->get_conf_array($this->conf_id);
					$this->data['reviewers']=$this->user->get_reviewer_array($this->conf_id);
					
					if( $this->input->is_ajax_request() ){
						$this->form_validation->set_rules('type', '操作', 'required');
						$this->form_validation->set_rules('user_login[]', '帳號', 'required');
					    if ($this->form_validation->run()){
					    	$type = $this->input->post('type');
					    	$user_logins = $this->input->post('user_login');
					    	switch($type){
					    		case "add_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->add_conf($this->conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 設為研討會管理員失敗");
					    				}
					    			}
					    		break;
					    		case "del_admin":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->del_conf($this->conf_id,$user_login) ){
					    					$this->alert->show("s","將使用者 <strong>".$user_login."</strong> 取消設為研討會管理員");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 取消研討會管理員失敗");
					    				}
					    			}
					    		break;
					    		case "add_review":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->add_reviewer($this->conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 設為審查人");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 設為審查人失敗");
					    				}
					    			}
					    		break;
					    		case "del_review":
					    			foreach ($user_logins as $key => $user_login) {
					    				if( $this->user->del_reviewer($this->conf_id,$user_login) ){
					    					$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 取消設為審查人");
					    				}else{
					    					$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 取消審查人失敗");
					    				}
					    			}
					    		break;
					    		case "add_topic":
					    			$topic = $this->input->post('topic');
					    			// foreach ($user_logins as $key => $user_login) {
					    			// 	if( $this->user->del_reviewer($this->conf_id,$user_login) ){
					    			// 		$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 取消設為審查人");
					    			// 	}else{
					    			// 		$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 取消審查人失敗");
					    			// 	}
					    			// }
					    		break;
					    	}
					    	$this->alert->refresh(2);
					    }
					}else{
						$this->load->view('conf/user/all',$this->data);
					}
				break;
			}
		}else{
			if($this->user->username_exists($user_login)){
				$this->data['user'] = $this->user->get_user_info($user_login);
				$this->data['user']->user_phone_o=explode(",", $this->data['user']->user_phone_o);
				$this->data['user']->user_postaddr=explode("|", $this->data['user']->user_postaddr);
				$country_list = config_item('country_list');
				$this->data['country_list'] = $country_list[$this->_lang];

				switch($do){
					case "edit":
						$this->user->updateuser_valid();
						if ($this->form_validation->run()){
					    	$user_email = $this->input->post('user_email');
					    	$user_title = $this->input->post('user_title');
					    	$user_firstname = $this->input->post('user_firstname');
					    	$user_lastname = $this->input->post('user_lastname');
					    	$user_gender = $this->input->post('user_gender');
					    	$user_org = $this->input->post('user_org');
					    	$user_phoneO_1 = $this->input->post('user_phoneO_1');
					    	$user_phoneO_2 = $this->input->post('user_phoneO_2');
					    	$user_phoneO_3 = $this->input->post('user_phoneO_3');
					    	$user_phoneO_3 = $this->input->post('user_phoneO_3');
					    	$user_cellphone = $this->input->post('user_cellphone');
					    	$user_fax = $this->input->post('user_fax');
					    	$user_postcode = $this->input->post('user_postcode');
					    	$user_addcounty = $this->input->post('user_addcounty');
					    	$user_area = $this->input->post('user_area');
					    	$user_postaddr = $this->input->post('user_postadd');
					    	$user_country = $this->input->post('user_country');
					    	$user_lang = $this->input->post('user_lang');
					    	$user_research = $this->input->post('user_research');

					    	$user_phone_o = $user_phoneO_1.",".$user_phoneO_2.",".$user_phoneO_3;
					    	$user_postaddr = $user_addcounty."|".$user_area."|".$user_postaddr;

							$res = $this->user->updateuser($user_login,$user_title,$user_email,$user_firstname,$user_lastname,$user_gender,$user_org,$user_phone_o,$user_cellphone,$user_fax,$user_postcode,$user_postaddr,$user_country,$user_lang,$user_research);
					    	if( $res['status'] ){
					    		$this->alert->js("Edit Success");
					    	}else{
					    		$this->alert->js($res['error']);
					    	}
					    }
						$this->load->view('js/edit',$this->data);
						$this->load->view('conf/user/edit',$this->data);
					break;
				}
			}
		}
		if( !$this->input->is_ajax_request() ){
			$this->load->view('common/footer',$this->data);
		}
		
	}

	public function news($conf_id='',$type=''){
		$this->assets->set_title(lang('dashboard_news'));
		$this->assets->add_js(base_url('ckeditor/ckeditor.js'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		if( is_null( $this->input->get('id', TRUE)) ){
			switch($type){
				default:
				case "all":
					$this->data['news']=$this->conf->get_news($this->conf_id);
					$this->load->view('conf/news/all',$this->data);
				break;
				case "add":
					$conf_lang = explode(",", $this->conf_config['conf_lang']);
					if( in_array("zhtw",$conf_lang) ){
						$this->form_validation->set_rules('news_title', '公告標題', 'required');
						$this->form_validation->set_rules('news_content', '公告內容', 'required');
					}
					if( in_array("eng",$conf_lang) ){
						$this->form_validation->set_rules('news_title_eng', '公告標題(英)', 'required');
						$this->form_validation->set_rules('news_content_eng', '公告內容(英)', 'required');
					}
					if ($this->form_validation->run()){
						$news_title       = in_array("zhtw",$conf_lang)?$this->input->post('news_title'):"";
						$news_content     = in_array("zhtw",$conf_lang)?$this->input->post('news_content',false):"";
						$news_title_eng   = in_array("eng",$conf_lang)?$this->input->post('news_title_eng'):"";
						$news_content_eng = in_array("eng",$conf_lang)?$this->input->post('news_content_eng',false):"";
						if( $this->conf->add_news($this->conf_id,$news_title,$news_content,$news_title_eng,$news_content_eng) ){
							$this->alert->show("s","成功建立公告",get_url("dashboard",$this->conf_id,"news","add"));
						}else{
							$this->alert->show("d","無法建立公告");
						}
					}
					$this->load->view('conf/news/add',$this->data);
				break;
			}
		}else{
			$news_id = $this->input->get('id', TRUE);
			switch($type){
				case "edit":
					$this->data['news']=$this->conf->get_news_info($this->conf_id,$news_id);
					if( !empty($this->data['news']) ){
						$conf_lang = explode(",", $this->conf_config["conf_lang"]);
						if( in_array("zhtw",$conf_lang) ){
							$this->form_validation->set_rules('news_title', '公告標題', 'required');
							$this->form_validation->set_rules('news_content', '公告內容', 'required');
						}
						if( in_array("eng",$conf_lang) ){
							$this->form_validation->set_rules('news_title_eng', '公告標題(英)', 'required');
							$this->form_validation->set_rules('news_content_eng', '公告內容(英)', 'required');
						}
						
						if ($this->form_validation->run()){
							$news_title       = $this->input->post('news_title');
							$news_content     = $this->input->post('news_content',false);
							$news_title_eng   = $this->input->post('news_title_eng');
							$news_content_eng = $this->input->post('news_content_eng',false);
							if( $this->conf->update_news($this->conf_id,$news_id,$news_title,$news_content,$news_title_eng,$news_content_eng) ){
								$this->alert->show("s","成功更新公告",get_url("dashboard",$this->conf_id,"news","edit")."?id=".$news_id);
							}else{
								$this->alert->show("d","無法更新公告");
							}
						}

						$this->load->view('conf/news/edit',$this->data);
					}else{
						$this->alert->show("d","查無公告",get_url("dashboard",$this->conf_id,"news"));
					}
				break;
				case "del":
					if( $this->conf->del_news($this->conf_id,$news_id) ){
						$this->alert->js("刪除公告成功",get_url("dashboard",$this->conf_id,"news"));
					}else{
						$this->alert->js("刪除公告失敗",get_url("dashboard",$this->conf_id,"news"));
					}
				break;
			}
		}
		$this->load->view('common/footer',$this->data);
		
	}

	public function email($conf_id='',$act='all'){
		$this->assets->set_title(lang('dashboard_email'));
		$this->assets->add_js(base_url().'tinymce/tinymce.min.js');
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		
		switch($act){
			default:
			case "all":
				$this->data['mail_templates'] = $this->conf->get_mail_templates($this->conf_id);
				$this->load->view('conf/email/list',$this->data);
			break;
			case "edit":
				$email_key = $this->input->get("key");
				if($this->data['template'] = $this->conf->get_mail_template($this->conf_id,$email_key,$this->_lang)){
					$this->form_validation->set_rules('subject_zhtw', '中文信件主旨', 'required');
					$this->form_validation->set_rules('body_zhtw', '中文信件內容', 'required');
					$this->form_validation->set_rules('subject_eng', '英文信件主旨', 'required');
					$this->form_validation->set_rules('body_eng', '英文信件內容', 'required');
					if ($this->form_validation->run()){
						$subject_zhtw = $this->input->post('subject_zhtw');
						$body_zhtw    = $this->input->post('body_zhtw',false);
						$subject_eng  = $this->input->post('subject_eng');
						$body_eng     = $this->input->post('body_eng',false);
						if( $this->conf->update_mail_template($email_key,$this->conf_id,$subject_zhtw,$body_zhtw,$subject_eng,$body_eng) ){
							$this->alert->show("s","電子郵件樣版更新成功");
						}else{
							$this->alert->js("電子郵件樣版更新失敗");
						}
						$this->alert->refresh(2);
					}
					$this->load->view('common/tinymce',$this->data);
					$this->load->view('conf/email/edit',$this->data);
				}else{
					$this->alert->js("找不到信件樣版",get_url("dashboard",$this->conf_id,"email"));
				}
			break;
		}
		$this->load->view('common/footer',$this->data);
	}

	public function submit($conf_id='',$act='',$paper_id=''){
		$this->assets->set_title(lang('dashboard_submit'));
		$this->assets->add_css(asset_url().'style/chosen.css');
		$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
		$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
		$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		$this->assets->add_js(asset_url().'js/dataTables.buttons.min.js',true);
		$this->assets->add_js(asset_url().'js/jszip.min.js',true);
		$this->assets->add_js(asset_url().'js/buttons.html5.min.js',true);
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		if( empty($paper_id) ){
			$topic_id = $this->input->get('topic_id', TRUE);
			$status = $this->input->get('status', TRUE);
			if( empty($topic_id) ){$topic_id=null;}
			if( empty($status) ){$status=null;}
			
			$this->data['topic_id'] = $topic_id;
			$this->data['status'] = $status;
			$this->data['papers']=$this->submit->get_allpaper($this->conf_id,$topic_id,$status);
			$this->data['topics']=$this->topic->get_topic($this->conf_id,$this->user_login);

			switch($act){
				case "list":
				default:
					$this->load->view('conf/submit/list',$this->data);
				break;
			}
		}else{
			$paper = $this->conf->get_paper($this->conf_id,$paper_id);
			$this->data['paper'] = $paper;
			if(!empty($paper)){
				$this->data['paper_id']   = $paper_id;
				$this->data['authors']    = $this->submit->get_author($paper_id);
				$this->data['otherfile']  = $this->submit->get_otherfile($paper_id);
				$this->data['otherfiles'] = $this->submit->get_otherfiles($paper_id);
				$this->data['reviewers']  = $this->topic->get_reviewer($paper_id);
				$this->data['finishfile'] = $this->submit->get_finishfile($paper_id);
				$this->data['finishother'] = $this->submit->get_finishother($paper_id);
				switch($act){
					case "detail":
					default:
						$this->form_validation->set_rules('sub_status', '稿件狀態', 'required');
						if ($this->form_validation->run()){
							$paper_status = $this->input->post("sub_status");
							if( $this->submit->change_paper_status($paper->sub_status,$paper_status,$this->conf_id,$paper_id) ){
								$this->alert->js("更改稿件狀態成功");
							}else{
								$this->alert->js("更改稿件狀態失敗");
							}
							$this->alert->refresh(2);
						}
						$this->load->view('conf/submit/detail',$this->data);
					break;
					case "remove":
						if( $paper->sub_status == -5 ){
							$this->alert->js("本篇稿件已刪除",get_url("dashboard",$this->conf_id,"submit","detail",$paper_id));
						}else{
							if( $this->submit->paper_to_remove($this->conf_id,$paper_id,$paper->sub_status) ){
								$this->alert->js("刪除成功",get_url("dashboard",$this->conf_id,"submit","detail",$paper_id));
							}else{
								$this->alert->js("刪除失敗",get_url("dashboard",$this->conf_id,"submit","detail",$paper_id));
							}
						}
					break;
					case "edit":
						$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
						$this->assets->add_js(asset_url().'js/repeatable.js',true);
						$this->assets->add_js(asset_url().'js/chosen.jquery.js',true);
						$this->data['topics'] = $this->conf->get_topic($this->conf_id);
						$this->data['paper']->sub_summary = str_replace("<br>",PHP_EOL,$this->data['paper']->sub_summary);
						$country_list = config_item('country_list');
						$this->data['country_list'] = $country_list[$this->_lang];
						$update = $this->input->post("update");
						switch ($update) {
							case "info":
								$this->form_validation->set_rules('sub_title', '題目', 'required');
								$this->form_validation->set_rules('sub_summary', '摘要', 'required');
								$this->form_validation->set_rules('sub_lang', '語言', 'required');
								$this->form_validation->set_rules('sub_keywords', '關鍵字', 'trim|required|min_length[1]',array('required'   => '您必須填寫%s.','min_length' => '至少輸入一組%s'));
								
								if ($this->form_validation->run()){
									$sub_title    = $this->input->post('sub_title');
									$sub_summary  = str_replace(PHP_EOL,"<br>",$this->input->post('sub_summary'));
									$sub_keyword  = $this->input->post('sub_keywords');
									$sub_topic    = in_array($paper->sub_status,array(-1,1))?$this->input->post('sub_topic'):$paper->topic_id;
									$sub_lang     = $this->input->post('sub_lang');
									$sub_sponsor  = $this->input->post('sub_sponsor');
									if( $this->submit->update_paper($paper_id,$this->conf_id,$sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor) ){
										$this->alert->show("s",$sub_topic ."稿件資訊更新成功");
									}else{
										$this->alert->show("d","稿件資訊更新失敗");
									}
									$this->alert->refresh(2);
								}
							break;
							case "author":
								$this->form_validation->set_rules('main_contact', '主要聯絡人', 'required');
								$this->form_validation->set_rules('user_fname[]', '名字', 'required');
								$this->form_validation->set_rules('user_lname[]', '姓氏', 'required');
								$this->form_validation->set_rules('user_email[]', '電子信箱', 'required|valid_email');
								$this->form_validation->set_rules('user_org[]', '所屬機構', 'required');
								$this->form_validation->set_rules('user_country[]', '國別', 'required');
								if ($this->form_validation->run()){
									$main_contact = $this->input->post('main_contact');
									$user_fname   = $this->input->post('user_fname');
									$user_lname   = $this->input->post('user_lname');
									$user_email   = $this->input->post('user_email');
									$user_org     = $this->input->post('user_org');
									$user_country = $this->input->post('user_country');

									$this->submit->del_author($paper_id);
									foreach ($user_fname as $key => $value) {
			            				$contact_author = 0;
			            				$user_login = NULL;
			            				if($main_contact == $key){
			            					$contact_author = 1;
			            				}
			            				$user_info = $this->user->email_find($user_email[$key]);
			            				if( is_array($user_info) ){
			            					$user_login = $user_info['user_login'];
			            				}
			            				if( $this->submit->add_author($paper_id,$user_login,$user_fname[$key],$user_lname[$key],$user_email[$key],$user_org[$key],$user_country[$key],$contact_author,$key+1) ){
			            					$this->alert->show("s","更新作者 <strong>".$user_fname[$key]." ".$user_lname[$key]."</strong> 成功");
			            				}else{
											$this->alert->show("d","更新作者 <strong>".$user_fname[$key]." ".$user_lname[$key]."</strong> 失敗");
										}
			            			}
									$this->alert->refresh(2);
								}
							break;
							case "delfile":
								$this->form_validation->set_rules('del_file[]', '檔案', 'required');
								if ($this->form_validation->run()){
									$del_files = $this->input->post('del_file');
									if(is_array($del_files)){
										$files = array();
										foreach ($this->data['otherfiles'] as $key => $otherfile) {
											array_push($files,$otherfile->fid);
										}
										foreach ($del_files as $key => $del_file) {
											if( in_array($del_file,$files) ){
												if( $this->submit->del_file($this->conf_id,$paper_id,$del_file) ){
													$this->alert->show("s","成功刪除檔案");
												}else{
													$this->alert->show("d","刪除檔案失敗");
												}
											}else{
												$this->alert->show("s","無法刪除檔案編號 ".$del_file."(非本篇稿件檔案)");
											}
										}
										$this->alert->refresh(2);
									}
								}
							break;
							case "file":
								$config['upload_path']= $this->conf->get_paperdir($this->conf_id);
				                $config['allowed_types']= 'pdf';
				                $config['encrypt_name']= true;

				                $this->load->library('upload', $config);
				                
				                if ( $this->upload->do_upload('paper_file')){
			                        $upload_data = $this->upload->data();
			                        $this->data['upload_data'] = $upload_data;
			                        $arrayLevel = arrayLevel($upload_data);
			                        if( $arrayLevel >1 ){
			                        	$this->alert->js("投稿檔案僅限一份");
			                        }
			                        if(empty($this->data['otherfile'])){
			                       		if( $this->submit->add_file($this->conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"F") ){
			                       			$this->alert->show("s","上傳投稿檔案成功");
			                       		}else{
			                       			$this->alert->show("d","上傳投稿檔案失敗");
			                       		}
			                    	}else{
			                    		delete_files($this->conf->get_paperdir($this->conf_id).$this->data['otherfile']->file_system);
			                    		if( $this->submit->update_file($this->conf_id,$paper_id,$this->data['otherfile']->fid,$upload_data['client_name'],$upload_data['file_name']) ){
			                    			$this->alert->show("s","更新投稿檔案成功");
			                    		}else{
			                    			$this->alert->show("d","更新投稿檔案失敗");
			                    		}
			                    	}
				                }else{
				                	$this->alert->js("投稿檔案上傳失敗");
				                }
				                $this->alert->refresh(2);
							break;
							case "otherfile":
								$config['upload_path']= $this->conf->get_paperdir($this->conf_id);
				                $config['allowed_types']= 'pdf';
				                $config['encrypt_name']= true;

				                $this->load->library('upload', $config);
				                if ( $this->upload->do_upload('paper_file')){
			                        $upload_datas = $this->upload->data();
			                        $arrayLevel = arrayLevel($upload_datas);
			                        if( $arrayLevel ==1 ){
				                       	if( $this->submit->add_file($this->conf_id,$paper_id,$upload_datas['client_name'],$upload_datas['file_name'],"O") ){
				                       		$this->alert->show("s","成功新增補充資料：".$upload_datas['client_name']);
				                       	}else{
				                       		$this->alert->show("d","新增補充資料失敗：".$upload_datas['client_name']);
				                       	}
			                        }else if($arrayLevel == 2){
			                        	foreach ($upload_datas as $key => $upload_data) {
				                       		if( $this->submit->add_file($this->conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"O") ){
				                       			$this->alert->show("s","成功新增補充資料：".$upload_data['client_name']);
				                       		}else{
				                       			$this->alert->show("d","新增補充資料失敗：".$upload_data['client_name']);
				                       		}
				                        }
			                        }
			                        $this->alert->refresh(2);
			                    }
							break;
						}
						$this->load->view('conf/submit/edit',$this->data);
					break;
				}
			}else{
				$this->alert->js("查無本篇稿件",get_url("dashboard",$this->conf_id,"submit"));
			}
		}
		$this->load->view('common/footer',$this->data);
	}

	public function register($conf_id='',$act='',$do=''){
		$this->assets->set_title(lang('dashboard_signup'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		switch ($act) {
			case "price": // 價格管理
			break;
			case "meal":
				$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
				$this->assets->add_js(asset_url().'js/repeatable-fields.js',true);
				switch($do){
					default:
						$this->data['register_meals'] = $this->conf->get_register_meals($this->conf_id);
						$opt = $this->input->post("opt");

						if(!empty($this->input->get("id"))){
							$id = $this->input->get("id");
							$meal = $this->conf->get_register_meal($this->conf_id,$id);
						}
						switch($opt){
							case "add":
								$this->form_validation->set_rules('meal_name[]', '餐點名稱', 'required');
								if ($this->form_validation->run()){
									$meal_name = $this->input->post('meal_name');
									foreach ($meal_name as $key => $name) {
										if( $this->conf->add_register_meal($this->conf_id,$name) ){
											$this->alert->show("s","成功新增：<strong>".$name."</strong>");
										}else{
											$this->alert->show("d","新增失敗：<strong>".$name."</strong>");
										}
									}
									$this->alert->refresh(2);
								}
							break;
							case "update":
								if(!empty($meal)){
									$this->form_validation->set_rules('meal_name', '餐點名稱', 'required');
									if ($this->form_validation->run()){
										$meal_name = $this->input->post('meal_name');
										if( $this->conf->update_register_meal($this->conf_id,$id,$meal_name) ){
											$this->alert->show("s","成功更新：<strong>".$meal_name."</strong>",get_url("dashboard",$this->conf_id,"register","meal"));
										}else{
											$this->alert->show("d","更新失敗：<strong>".$meal_name."</strong>",get_url("dashboard",$this->conf_id,"register","meal"));
										}
									}
								}else{
									$this->alert->show("d","更新失敗：查無此餐點",get_url("dashboard",$this->conf_id,"register","meal"));
								}
							break;
							case "del":
								$this->form_validation->set_rules('meal_id[]', '餐點', 'required');
								if ($this->form_validation->run()){
									$meal_ids = $this->input->post('meal_id');
									foreach ($meal_ids as $key => $meal_id) {
										if( $this->conf->del_register_meal($this->conf_id,$meal_id) ){
											$this->alert->show("s","成功刪除：<strong>餐點#".$meal_id."</strong>");
										}else{
											$this->alert->show("d","刪除失敗：<strong>餐點#".$meal_id."</strong>");
										}
									}
									$this->alert->refresh(2);
								}
							break;
						}
						$this->load->view('conf/register/meal_list',$this->data);
						if(!empty($meal)){
							$this->data['meal'] = $meal;
							$this->load->view('conf/register/meal_edit',$this->data);
						}
						$this->load->view('conf/register/meal_add',$this->data);
					break;
				}
			break;
			default:
				$this->load->view('conf/register/list',$this->data);
			break;
		}
		$this->load->view('common/footer',$this->data);
	}

	public function report($conf_id=''){
		$this->assets->set_title(lang('dashboard_report'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('common/footer',$this->data);
		
	}

	public function logs($conf_id=''){
		$this->data['conf_logs']    = $this->conf->get_logs($this->conf_id);

		$this->assets->set_title(lang('dashboard_logs'));
		$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
		$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
		$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		$this->assets->add_css(asset_url().'style/buttons.dataTables.min.css');
		$this->assets->add_js(asset_url().'js/dataTables.buttons.min.js',true);
		$this->assets->add_js(asset_url().'js/jszip.min.js',true);
		$this->assets->add_js(asset_url().'js/buttons.html5.min.js',true);
		
		$this->lang->load("conf_log",$this->_lang);
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('conf/logs/index',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function most($conf_id='',$act=''){
		$hold = $this->conf->get_schedule($this->conf_id,"hold");
		$day = ($hold->end_value - $hold->start_value)/86400;
		$hold_day = array();
		for($i=0; $i<=$day; $i++){
			array_push($hold_day,date("m-d",strtotime("+".$i." day",$hold->start_value)));
		}
		$this->data['hold_day'] = $hold_day;
		array_push($hold_day,array("S","P"));

		$this->assets->set_title(lang('dashboard_most'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		
		switch($act){
			case "edit":
				if( !empty( $this->input->get('id') ) ){
					$most_id = $this->input->get('id');
					$most = $this->conf->get_most($this->conf_id,$most_id);
					if( !empty($most) ){
						$this->data['most'] = $most;
						$report = $this->submit->get_most_report($most_id);
						$mostfile = $this->submit->get_most_file($this->conf_id,$most_id);
						$this->data['report'] = $report;
						$this->data['most_file'] = $mostfile;
						$do = $this->input->get('do');
						$can_empty = array("most_status");
						switch($do){
							case "submit":
								foreach ($most as $key => $m) {
									if( !in_array($key,$can_empty) ){
										if( empty($m) ){$this->alert->show("d","計畫資料不齊全",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);$this->output->_display();exit;}
									}
								}
								foreach ($report as $key => $r) {
									if( empty($r) ){$this->alert->show("d","發表者資料不齊全",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);$this->output->_display();exit;}
								}
								if( empty($mostfile->most_auth) ){
									$this->alert->show("d","授權同意書未上傳",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
									$this->output->_display();
									exit;
								}
								if( empty($mostfile->most_result) ){
									$this->alert->show("d","成果資料表未上傳",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
									$this->output->_display();
									exit;
								}
								if( $most->most_method == "P" ){
									if( empty($mostfile->most_poster) ){
										$this->alert->show("d","成果海報電子檔未上傳",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
										$this->output->_display();
										exit;
									}
								}
								if( $this->submit->submit_most($this->conf_id,$most_id,$this->user_login) ){
									$this->alert->js("成功送出資料",get_url("dashboard",$this->conf_id,"most"));
				                }else{
									$this->alert->js("送出資料失敗",get_url("dashboard",$this->conf_id,"most"));
								}
								
							break;
							case "info":
								$this->submit->most_valid();
								if ($this->form_validation->run()){
									$most_method     = $this->input->post('most_method');
									$most_number     = $this->input->post('most_number');
									$most_name       = $this->input->post('most_name');
									$most_name_eng   = $this->input->post('most_name_eng');
									$most_uni        = $this->input->post('most_uni');
									$most_dept       = $this->input->post('most_dept');
									$most_host       = $this->input->post('most_host');

									$report_name     = $this->input->post('report_name');
									$report_uni      = $this->input->post('report_uni');
									$report_dept     = $this->input->post('report_dept');
									$report_title    = $this->input->post('report_title');
									$report_email    = $this->input->post('report_email');
									$report_phone    = $this->input->post('report_phone');
									$report_meal     = $this->input->post('report_meal');
									$report_mealtype = $this->input->post('report_mealtype');
									
									if( in_array($report_mealtype,$hold_day) ){
										$update_most = $this->submit->update_most($this->conf_id,$this->user_login,$most_id,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept);
										$update_most_report = $this->submit->update_most_report($most_id,$report_name,$report_uni,$report_dept,$report_title,$report_email,$report_phone,$report_meal,$report_mealtype);
										if( $update_most && $update_most_report){
											$this->alert->js("更新成功",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
										}else{
											$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
										}
									}else{
										$this->alert->show("d","請填寫正確的餐券時間");
									}
								}
							break;
							case "file":
								$config['upload_path']= $this->conf->get_mostdir($this->conf_id);
								$config['allowed_types']= 'pdf|doc|docx';
				                $config['encrypt_name']= true;
				                $this->load->library('upload', $config);

				                $file = $this->input->post('file');
				                switch($file){
				                	case "auth":
				                		if ( $this->upload->do_upload('most_auth')){
							                $most_file  = $this->upload->data();
							                if( $this->conf->update_most_file($most_id,"auth",$most_file['file_name'],$most_file['client_name']) ){
												$this->alert->js("更新成功",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							                }else{
												$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
											}
							            }else{
											$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							            }
						            break;
						            case "result":
						            	if ( $this->upload->do_upload('most_result')){
							            	$most_file  = $this->upload->data();
							            	if( $this->submit->update_most_file($most_id,"result",$most_file['file_name'],$most_file['client_name']) ){
												$this->alert->js("更新成功",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							                }else{
												$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
											}
							            }else{
											$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							            }
						            break;
						            case "poster":
						            	if ( $this->upload->do_upload('most_poster')){
							                $most_file  = $this->upload->data();
							                if( $this->submit->update_most_file($most_id,"poster",$most_file['file_name'],$most_file['client_name']) ){
												$this->alert->js("更新成功",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							                }else{
												$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
											}
							            }else{
											$this->alert->js("更新失敗",get_url("dashboard",$this->conf_id,"most","edit")."?id=".$most->most_id);
							            }
						            break;
				                }
							break;
						}
						$this->load->view("conf/most/edit",$this->data);
					}
				}else{
					$this->alert->js("找不到上傳資料");
				}
			break;
			case "detail":
				$most_id = $this->input->get('id');
				$most = $this->conf->get_most($this->conf_id,$most_id);
				if( !empty($most) ){
					$this->data['most'] = $most;
					$this->data['most_file'] = $this->submit->get_most_file($this->conf_id,$most_id);
					$this->data['report'] = $this->submit->get_most_report($most_id);
					if( $most->most_status == 1 ){
						$this->form_validation->set_rules('options', '操作選項', 'required');
						if ($this->form_validation->run()){
							$options = $this->input->post('options');
							if( $options == 1 ){
								if( $this->conf->most_review($this->conf_id,$most_id,2) ){
									$this->alert->js("操作成功，接受本報名資料");
								}else{
									$this->alert->js("操作失敗，無法接受本報名資料");
								}
							}else if( $options == 0 ){
								if( $this->conf->most_review($this->conf_id,$most_id,-1) ){
									$this->alert->js("操作成功，拒絕本報名資料");
								}else{
									$this->alert->js("操作失敗，無法拒絕本報名資料");
								}
							}else{
								$this->alert->js("無效操作");
							}
							$this->alert->refresh(1);
						}
						$this->load->view("conf/most/reviewer",$this->data);
					}
					$this->load->view("conf/most/detail",$this->data);
				}
			break;
			case "list":
			default:
				$this->data['mosts'] = $this->conf->get_mosts($this->conf_id);
				$this->load->view('conf/most/list',$this->data);
			break;
		}
		$this->load->view('common/footer',$this->data);
	}

	public function menu($conf_id=''){
		$this->data['pages']=$this->conf->conf_content($this->conf_id);

		$this->assets->add_css(asset_url().'style/nestable.css');
		$this->assets->add_js(asset_url().'js/jquery.nestable.js');

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('nestable',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function export_download($conf_id=''){
		$this->form_validation->set_rules('type', '', 'required');
		if ($this->form_validation->run()){
			$type = $this->input->post("type");
			switch( $type ){
				case "paperlist":
					$topic    = $this->input->post("topic");
					$status   = $this->input->post("status");
					$format   = $this->input->post("format");
					$filename = $this->input->post("filename");
					$this->exportdata->paperlist($topic,$status,$format,$this->conf_id,$filename);
				break;
				case "finishfiles":
					$filename = $this->input->post("filename");
					$this->exportdata->finishfiles($conf_id,$filename);
				break;
			}
		}
	}

	public function export($conf_id=''){
		$this->assets->set_title(lang('dashboard_export'));
		$this->data['topics'] = $this->conf->get_topic($this->conf_id);
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('conf/export/index',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function review($conf_id='',$act='all'){
		$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
		$this->assets->add_js(asset_url().'js/repeatable-fields.js');
		$this->assets->set_title("審查表單");
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);

		switch($act){
			default:
			case "all":
				$this->data["review_forms"]    = $this->conf->get_review_forms($this->conf_id);
				$this->data["form_elements"]   = $this->conf->get_review_form_elements($this->conf_id);
				$this->data["recommend_forms"] = $this->conf->get_recommend_forms($this->conf_id);
				switch( $this->input->post("do") ){
					case "addform":
						$this->form_validation->set_rules('review_form_title[]', '審查項目', 'required');
						$this->form_validation->set_rules('element_name[]', '元素', 'required');
						$this->form_validation->set_rules('element_value[]', '分數', 'required');
						if ($this->form_validation->run()){
							$review_form_title = $this->input->post("review_form_title");
							$element_name      = $this->input->post("element_name");
							$element_value     = $this->input->post("element_value");

							$add = $this->conf->add_review_form($this->conf_id,$review_form_title,$element_name,$element_value);
							if( !$add["status"] ){
								$this->alert->show("d",$add["message"]);
							}
						}
					break;
					case "sortform":
						$this->form_validation->set_rules('review_form_id[]', '', 'required');
						if ( $this->form_validation->run() ){
							$review_form_id = $this->input->post("review_form_id");
							if( $this->conf->update_review_form_sort($review_form_id,$this->conf_id) ){
								$this->alert->show("s","更新審查表單排序成功");
							}else{
								$this->alert->show("d","更新審查表單排序失敗");
							}
							$this->alert->refresh(2);
						}
					break;
					case "updaterecommend":
						$this->form_validation->set_rules('recommend_form_title[]', '推薦項目', 'required');
						$this->form_validation->set_rules('recommend_form_name[]', '', 'required');
						if ( $this->form_validation->run() ){
							$recommend_form_title = $this->input->post("recommend_form_title");
							$recommend_form_name = $this->input->post("recommend_form_name");
							if( $this->conf->update_recommend_form_sort($this->conf_id,$recommend_form_title,$recommend_form_name) ){
								$this->alert->show("s","更新推薦項目成功");
							}else{
								$this->alert->show("d","更新推薦項目失敗");
							}
							$this->alert->refresh(2);
						}

					break;
					case "addrecommend":
						$this->form_validation->set_rules('recommend_form_title[]', '推薦項目', 'required');
						if ($this->form_validation->run()){
							$recommend_form_title = $this->input->post("recommend_form_title");
							if( $this->conf->add_recommend_forms($this->conf_id,$recommend_form_title) ){
								$this->alert->show("s","新增推薦項目成功");
							}else{
								$this->alert->show("d","新增推薦項目失敗");
							}
							$this->alert->refresh(1);
						}
					break;
				}
				$this->load->view('conf/review/index',$this->data);
			break;
			case "edit_form":
				$id = $this->input->get("id");
				$this->data["review_form"] = $this->conf->get_review_form($this->conf_id,$id);
				$this->data["form_element"] = $this->conf->get_review_form_element($this->conf_id,$id);
				switch( $this->input->post("do") ){
					case "update":
						$this->form_validation->set_rules('form_title', '審查項目', 'required');
						$this->form_validation->set_rules('element_name[]', '元素', 'required');
						$this->form_validation->set_rules('element_value[]', '分數', 'required');
						if ($this->form_validation->run()){
							$form_title  = $this->input->post("form_title");
							$element_names  = $this->input->post("element_name");
							$element_values = $this->input->post("element_value");
							if( $this->conf->update_review_form($this->conf_id,$id,$form_title) ){
								$this->alert->show("s","更新審查項目名稱成功");
							}else{
								$this->alert->show("d","更新審查項目名稱失敗");
							}
							if( $this->conf->update_review_element($id,$element_names,$element_values) ){
								$this->alert->show("s","更新評分項目成功");
							}else{
								$this->alert->show("d","更新評分項目失敗");
							}
							$this->alert->refresh(1);
						}
					break;
					case "add":
						$this->form_validation->set_rules('element_name[]', '元素', 'required');
						$this->form_validation->set_rules('element_value[]', '分數', 'required');
						if ($this->form_validation->run()){
							$element_names  = $this->input->post("element_name");
							$element_values = $this->input->post("element_value");

							if( $this->conf->add_review_form_elements($id,$element_names,$element_values) ){
								$this->alert->js("新增成功");
							}else{
								$this->alert->js("新增失敗");
							}
							$this->alert->refresh(1);
						}
					break;
				}
				$this->load->view('conf/review/form_edit',$this->data);
			break;
			case "del_form":
				$id = $this->input->get("id");
				if( $this->conf->get_review_form($this->conf_id,$id) ){
					if( $this->conf->del_review_form($this->conf_id,$id) ){
						$this->alert->js("刪除審查項目成功",get_url("dashboard",$this->conf_id,"review"));
					}else{
						$this->alert->js("刪除審查項目失敗",get_url("dashboard",$this->conf_id,"review"));
					}
				}else{
					$this->alert->js("找不到此審查項目",get_url("dashboard",$this->conf_id,"review"));
				}
			break;
			case "del_element":
				$id = $this->input->get("id");
				$element_id = $this->input->get("element_id");
				if( $this->conf->get_review_element($this->conf_id,$id,$element_id) ){
					if( $this->conf->del_review_element($id,$element_id) ){
						$this->alert->js("刪除元素成功",get_url("dashboard",$this->conf_id,"review","edit_form")."?id=".$id);
					}else{
						$this->alert->js("刪除元素失敗",get_url("dashboard",$this->conf_id,"review","edit_form")."?id=".$id);
					}
				}else{
					$this->alert->js("找不到此項目",get_url("dashboard",$this->conf_id,"review"));
				}
			break;
		}
		$this->load->view('common/footer',$this->data);
	}

	public function widget($conf_id=''){
		$this->assets->set_title(lang('dashboard_report'));
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	// Template
	private function _temp($conf_id=''){
		$this->assets->set_title(lang('dashboard_report'));

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_conf',$this->data);
		$this->load->view('common/footer',$this->data);
	}
}