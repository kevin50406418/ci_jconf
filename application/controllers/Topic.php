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
class Topic extends MY_Topic {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		$this->user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;

		if( !$this->conf->confid_exists($this->conf_id,$this->user->is_conf($this->conf_id)) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}

		$this->is_sysop    = $this->user_sysop;
		$this->is_conf     = $this->user->is_conf($this->conf_id);
		$this->is_topic    = $this->user->is_topic($this->conf_id);
		$this->is_reviewer = $this->user->is_reviewer($this->conf_id);
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->is_conf);
		
		$this->assets->set_title_separator(" | ");
		$this->assets->set_site_name($this->conf_config['conf_name']);

		$this->data['conf_id']       = $this->conf_id;
		$this->data['body_class']    = $this->body_class;
		$this->data['_lang']         = $this->_lang;
		$this->data['spage']         = $this->config->item('spage');
		$this->data['conf_config']   = $this->conf_config;
		$this->data['conf_content']  = $this->conf->conf_content($this->conf_id);
		$this->data['schedule']      = $this->conf->get_schedules($this->conf_id);
		$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
		if( $this->is_reviewer || $this->user_sysop ){
			$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
		}
		if( !$this->is_topic && !$this->user_sysop ){
			$this->conf->show_permission_deny($this->data);
		}
	}

	public function index($conf_id=''){
		$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
		$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
		$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
		$this->assets->add_js(asset_url().'js/dataTables.buttons.min.js',true);
		$this->assets->add_js(asset_url().'js/jszip.min.js',true);
		$this->assets->add_js(asset_url().'js/buttons.html5.min.js',true);
		if( !$this->conf->conf_hastopic($this->conf_id) ){
			$this->alert->js("尚未建立研討會主題，請洽研討會會議管理人員",get_url("main",$this->conf_id));
			$this->load->view('common/footer',$this->data);
			$this->output->_display();
			exit;
		}
		$this->assets->set_title(lang('topic_assign'));
		$topics = $this->topic->get_topic($this->conf_id,$this->user_login);
		$this->data['topics'] = $topics;
		$assign_topic = array();
		foreach ($topics as $key => $v) {
			array_push($assign_topic,$v->topic_id);
		}
		$assign_count = array();
		$tmp_count = $this->topic->count_reviewer($this->conf_id,$assign_topic);
		if( !empty($tmp_count) ){
			foreach ($tmp_count as $key => $v) {
				$assign_count[$v->paper_id] = $v->cnt;
			}
		}
		$had_count = array();
		$tmp_count = $this->topic->count_had_review($this->conf_id,$assign_topic);
		if( !empty($tmp_count) ){
			foreach ($tmp_count as $key => $v) {
				$had_count[$v->paper_id] = $v->cnt;
			}
		}
		$this->data['assign_count'] = $assign_count;
		$this->data['had_count']    = $had_count;

		$topic_id = $this->input->get('topic_id', TRUE);
		$status   = $this->input->get('status', TRUE);
		if( empty($topic_id) ){$topic_id=null;}
		if( empty($status) ){$status=null;}
		
		$this->data['topic_id'] = $topic_id;
		$this->data['status']   = $status;
		$this->data['papers']   = $this->topic->get_paper($this->conf_id,$this->user_login,$topic_id,$status);

		$paper_author=$this->submit->show_mypaper($this->user_login,$this->conf_id);
		$this->data['paper_author'] = array();
		// if(is_array($paper_author)){
		// 	foreach ($paper_author as $key => $pa) {
		// 		array_push($this->data['paper_author'],$pa->sub_id);
		// 	}
		// }
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		$this->load->view('topic/list',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function detail($conf_id='',$paper_id=''){
		if( empty($paper_id) ){
			$this->alert->js("稿件不存在",get_url("topic",$this->conf_id,"index"));
			$this->load->view('common/footer',$this->data);
			$this->output->_display();
			exit;
		}
		$this->data['paper_id'] = $paper_id;
		$this->assets->set_title(lang('topic_assign'));
		$this->assets->add_css(asset_url().'style/bootstrap-datetimepicker.min.css');
		$this->assets->add_js('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"');
		$this->assets->add_js(asset_url().'js/bootstrap-datetimepicker.min.js');
		$this->assets->add_js(base_url('ckeditor/ckeditor.js'));

		$user = $this->user->get_user_info($this->user_login);
		$paper_author = $this->submit->show_mypaper($this->user_login,$this->conf_id);
		$paper_array  = array();
		// if(is_array($paper_author)){
		// 	foreach ($paper_author as $key => $pa) {
		// 		array_push($paper_array,$pa->sub_id);
		// 	}
		// }
		
		$this->data['template'] = $this->conf->get_mail_template($this->conf_id,"confirm_review",$this->_lang);
		$search = array("{user_name}","{user_email}");
			$replace = array($user->user_last_name." ".$user->user_first_name,$user->user_email);
		$this->data['template']->email_subject_zhtw = str_replace($search,$replace,$this->data['template']->email_subject_zhtw);
		$this->data['template']->email_subject_eng  = str_replace($search,$replace,$this->data['template']->email_subject_eng);
		$this->data['template']->email_body_zhtw    = str_replace($search,$replace,$this->data['template']->email_body_zhtw);
		$this->data['template']->email_body_eng     = str_replace($search,$replace,$this->data['template']->email_body_eng);

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		if( !in_array($paper_id,$paper_array) ){
			$paper = $this->topic->get_paperinfo($paper_id,$this->conf_id);
			$this->data['paper'] = $paper;
			if(!empty($paper)){
				$this->data['reviewers']  = $this->conf->get_reviewer($this->conf_id);
				$this->data['authors']    = $this->submit->get_author($paper_id);
				$this->data['otherfile']  = $this->submit->get_otherfile($paper_id);
				$this->data['otherfiles'] = $this->submit->get_otherfiles($paper_id);
				$agrees       = $this->conf->get_agrees($this->conf_id);
				$this->data['agrees']       = $agrees;
				
				$agree_value_array = $this->submit->get_agree($this->conf_id,$paper_id);
				$agree_value = array();
				foreach ($agree_value_array as $key => $value) {
					$agree_value[$value->agree_token] = $value->agree_value;
				}
				$this->data['agree_value'] = $agree_value;
				

				if( $this->data['paper']->sub_status == 1 ){
					$pedding_reviewers = $this->topic->get_reviewer_pedding($this->conf_id,$paper_id);
					
					$is_pedding    = array(); //目前已被分派至審查帳號
					$not_reviewers = array(); //無法被分派審查帳號(作者群+審查人)
					foreach ($pedding_reviewers as $key => $v) {//審查人
						array_push($is_pedding,$v->user_login);
						array_push($not_reviewers,$v->user_login);
					}
					foreach ($this->data['authors'] as $key => $v) {//作者群
						array_push($not_reviewers,$v->user_login);
					}
					$this->data['pedding_reviewers'] = $pedding_reviewers;
					$this->data['not_reviewers']     = $not_reviewers;//無法被分派審查帳號(作者群+審查人)
					$this->data['pedding_count']     = count($this->data['pedding_reviewers']);
					if( $this->data['paper']->sub_status == 1 ){
						$this->form_validation->set_rules('type', '', 'required');
						$type = $this->input->post('type');

						if( $type == "time"){
							$this->form_validation->set_rules('review_timeout[]', '審查期限', 'required');
							$review_timeout = $this->input->post('review_timeout');
						}else{
							$this->form_validation->set_rules('user_login[]', '帳號', 'required');
							$this->user_logins = $this->input->post('user_login');
						}
						if( $type == "add" ){
							// $this->form_validation->set_rules('review_timeout', '審查期限', 'required');
							// $review_timeout = $this->input->post('review_timeout');
							// $review_timeout = strtotime($review_timeout);
						}
						if( $type == "confirm" ){
							$this->form_validation->set_rules('subject', '主旨', 'required');
							$this->form_validation->set_rules('message', '信件內容', 'required');
						}
						if ($this->form_validation->run()){
							switch($type){
								case "time":
									foreach ($review_timeout as $this->user_login => $timeout) {
										if( $this->topic->update_reviewer_pedding_timeout($paper_id,$this->user_login,$this->conf_id,$review_timeout) ){
											$this->alert->show("s","成功更新使用者 <strong>".$this->user_login."</strong>審查期限為:".date("Y-m-d",$review_timeout));
										}else{
											$this->alert->show("d","更新使用者 <strong>".$this->user_login."</strong> 審查期限失敗");
										}
									}
									$this->alert->refresh(2);
								break;
								case "add":
									$review_timeout = strtotime("+1 week");
									if( $this->data['pedding_count']+count($this->user_logins)<=5 ){
										foreach ($this->user_logins as $key => $this->user_login) {
											if( !in_array($this->user_login, $this->data['not_reviewers']) ){
												if( $this->topic->assign_reviewer_pedding($paper_id,$this->user_login,$this->conf_id,$review_timeout) ){
													$this->alert->show("s","成功將使用者 <strong>".$this->user_login."</strong> 加入本篇稿件審查");
												}else{
													$this->alert->show("d","將使用者 <strong>".$this->user_login."</strong> 加入本篇稿件審查失敗");
												}
											}else{
												$this->alert->show("d","使用者 <strong>".$this->user_login."</strong> 無法審查本篇稿件");
											}
										}
									}else{
										$this->alert->js("審查人最多5人");
									}
									$this->alert->refresh(2);
								break;
								case "confirm":
									$subject =$this->input->post('subject');
									$message =$this->input->post('message',false);
									if($this->data['pedding_count']<=5){
										if( $this->data['pedding_count']%2 == 1 ){
											$review_timeout = array();
											foreach ($pedding_reviewers as $key => $p_reviewer) {
												$review_timeout[$p_reviewer->user_login] = $p_reviewer->review_timeout;
											}
											
											foreach ($is_pedding as $key => $this->user_login) {
												if( !in_array($this->user_login, $this->data['not_reviewers']) ){
													$this->alert->show("d","使用者 <strong>".$this->user_login."</strong> 無法審查本篇稿件!!");
													$this->output->_display();
													exit;
												}
											}
											foreach ($is_pedding as $key => $this->user_login) {
												if( $this->topic->assign_reviewer($paper_id,$this->user_login,$this->conf_id,$review_timeout[$this->user_login],$subject,$message,$user->user_last_name." ".$user->user_first_name,$user->user_email) ){
													$this->submit->paper_to_reviewing($this->conf_id,$paper_id);
													$this->alert->show("s","成功將使用者 <strong>".$this->user_login."</strong> 加入本篇稿件審查");
												}else{
													$this->alert->show("d","將使用者 <strong>".$this->user_login."</strong> 加入本篇稿件審查失敗");
												}
											}
											$this->topic->del_pedding_reviewer($paper_id,$this->conf_id);
										}else{
											$this->alert->js("審查人必須為奇數個");
										}
									}else{
										$this->alert->js("審查人最多5人");
									}
									$this->alert->refresh(2);
								break;
								case "del":
									foreach ($this->user_logins as $key => $this->user_login) {
										if( $this->topic->del_reviewer_pedding($paper_id,$this->user_login,$this->conf_id) ){
											$this->alert->show("s","成功將使用者 <strong>".$this->user_login."</strong> 移除本篇稿件審查");
										}else{
											$this->alert->show("d","將使用者 <strong>".$this->user_login."</strong> 移除本篇稿件審查失敗");
										}
									}
									$this->alert->refresh(2);
								break;
							}
						}
						$this->load->view('topic/reviewers',$this->data);
						$this->load->view('topic/pedding_reviewers',$this->data);
					}
				}
				if( $this->data['paper']->sub_status >= 3 || $this->data['paper']->sub_status == -2 || $this->data['paper']->sub_status == 0){
					$reviewers = $this->topic->get_reviewer($paper_id);
					$this->data['reviewers'] = $reviewers;

					if( $this->data['paper']->sub_status == 3){
						$do = $this->input->post("do");
						switch($do){
							case "notice":
								$this->form_validation->set_rules('user_login[]', '審查人帳號', 'required');
						    	if ( $this->form_validation->run() ){
									$array_reviewer = array();
									foreach ($reviewers as $key => $reviewer) {
										array_push($array_reviewer,$reviewer->user_login);
									}
									
									$array_users = $this->user->get_all_users();
									$users = array();
									foreach ($array_users as $key => $array_user) {
										$users[$array_user->user_login] = $array_user->user_email;
									}
									$this->user_logins = $this->input->post('user_login');
									foreach ($this->user_logins as $key => $this->user_login) {
										if( in_array($this->user_login,$array_reviewer) ){
											$this->topic->notice_reviewer($this->user_login,$users[$this->user_login],$this->conf_config['conf_name'],$this->conf_id,$paper->sub_title,$paper->topic_name,$paper->topic_name_eng,$this->user_login);
										}
									}
								}
							break;
							case "topic":
								$this->form_validation->set_rules('status', '審查狀態', 'required');
								if ( $this->form_validation->run() ){
									$sub_status = $this->input->post("status");
									if( $this->topic->topic_review($this->conf_id,$paper_id,$sub_status) ){
										$this->alert->js("成功送出審查");
									}else{
										$this->alert->js("送出審查失敗");
									}
									$this->alert->refresh(2);
								}
							break;
							case "timeout":
								$this->form_validation->set_rules('review_timeout[]', '審查期限', 'required');
								if ( $this->form_validation->run() ){
									$review_timeout = $this->input->post("review_timeout");
									if( $this->topic->uptate_review_timeout($review_timeout,$paper_id) ){
										$this->alert->show("s","更新審查時間成功");
									}else{
										$this->alert->show("d","更新審查時間失敗");
									}
									$this->alert->refresh(2);
								}
							break;
							case "cancel":
							break;
						}
					}
				}
				$this->load->view('topic/detail',$this->data);
			}else{
				$this->alert->js("查不到本篇稿件!",get_url("topic",$this->conf_id,"index"));
			}
		}else{
			$this->alert->js("由於您為本篇稿件作者之一，無法分派本篇稿件",get_url("topic",$this->conf_id,"index"));
		}
		$this->load->view('common/footer',$this->data);
	}

	public function operating($conf_id='',$paper_id=''){
		$this->data['paper_id'] = $paper_id;

		if( empty($paper_id) ){
			$this->alert->js("稿件不存在",get_url("topic",$this->conf_id,"index"));
			$this->load->view('common/footer',$this->data);
			$this->output->_display();
			exit;
		}
		
		$paper_author = $this->submit->show_mypaper($this->user_login,$this->conf_id);
		$paper_array  = array();
		if(is_array($paper_author)){
			foreach ($paper_author as $key => $pa) {
				array_push($paper_array,$pa->sub_id);
			}
		}
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		
		if( !in_array($paper_id,$paper_array) ){
			$paper =  $this->topic->get_paperinfo($paper_id,$this->conf_id);
			$this->data['paper'] = $paper;
			if(!empty($paper)){
				$this->data['reviewers']  = $this->conf->get_reviewer($this->conf_id);
				$this->data['authors']    = $this->submit->get_author($paper_id);
				$this->data['otherfile']  = $this->submit->get_otherfile($paper_id);
				$this->data['otherfiles'] = $this->submit->get_otherfiles($paper_id);
			}
			if( $this->data['paper']->sub_status < 3 && $this->data['paper']->sub_status >= -1){
				$this->form_validation->set_rules('do', '操作', 'required');
	    		if ($this->form_validation->run()){
	    			$do = $this->input->post('do');
	    			if( in_array($do,array("remove","reject")) ){
	    				switch ($do) {
		    				case "remove":
		    					$sub_status = -3;
		    				break;
		    				case "reject":
		    					$sub_status = -2;
		    				break;
		    			}
		    			if( $this->topic->topic_review($this->conf_id,$paper_id,$sub_status) ){
		    				$this->alert->js("操作成功",get_url("topic",$this->conf_id,"detail",$paper->sub_id));
		    			}else{
		    				$this->alert->js("操作失敗",get_url("topic",$this->conf_id,"detail",$paper->sub_id));
		    			}
	    			}
	    		}
			}else{
				$this->alert->js("操作失敗",get_url("topic",$this->conf_id,"detailg",$paper->sub_id));
			}
		}else{
			$this->alert->js("由於您為本篇稿件作者之一，無法分派本篇稿件",get_url("topic",$this->conf_id,"index"));
		}
	}

	public function files($conf_id='',$paper_id=''){
		if( empty($this->conf_id) || empty($paper_id) ){
			$this->alert->file_notfound(get_url("topic",$this->conf_id));
		}

		if( is_null($this->input->get("fid") ) ){
			$this->alert->file_notfound(get_url("topic",$this->conf_id));
		}else{
			$fid  = $this->input->get("fid");
			$file = $this->topic->get_file($fid,$paper_id,$this->user_login);

			if(empty($file)){
				$this->alert->file_notfound(get_url("topic",$this->conf_id));
			}
			$this->load->helper('download');
			$do = $this->input->get("do");
			switch($do){
				case "download":
					force_download($file->file_name,file_get_contents($this->conf->get_paperdir($this->conf_id).$file->file_system));
				break;
				default:
				case "view":
					$this->output
						->set_content_type('pdf')
						->set_header("Content-Disposition: inline; filename=\"".$paper_id."-".$file->fid."-".$file->file_name."\"")
						->set_output(file_get_contents($this->conf->get_paperdir($this->conf_id).$file->file_system));
				break;
			}
		}
		
	}

	public function users($conf_id=''){
		$this->data['users']     = $this->user->get_all_users(10);
		$this->data['confs']     = $this->user->get_conf_array($this->conf_id);
		$this->data['reviewers'] = $this->user->get_reviewer_array($this->conf_id);
		$this->data['topics']    = $this->user->get_topic_array($this->conf_id);
		if( $this->conf_config["topic_assign"] ){
			$this->assets->add_css(asset_url().'style/jquery.dataTables.css');
			$this->assets->add_js(asset_url().'js/jquery.dataTables.min.js',true);
			$this->assets->add_js(asset_url().'js/dataTables.bootstrap.js',true);
			$this->assets->set_title(lang('topic_reviewer_assign'));
			if( $this->input->is_ajax_request() ){
				$this->form_validation->set_rules('type', '操作', 'required');
				$this->form_validation->set_rules('user_login[]', '帳號', 'required');
			    if ($this->form_validation->run()){
			    	$type = $this->input->post('type');
			    	$this->user_logins = $this->input->post('user_login');
			    	if(is_array($this->user_logins)){
			    		switch($type){
				    		case "add_review":
				    			foreach ($this->user_logins as $key => $this->user_login) {
				    				if( $this->user->add_reviewer($this->conf_id,$this->user_login) ){
				    					$this->alert->show("s","成功將使用者 <strong>".$this->user_login."</strong> 設為審查人");
				    				}else{
				    					$this->alert->show("d","將使用者 <strong>".$this->user_login."</strong> 設為審查人失敗");
				    				}
				    			}
				    		break;
				    		case "del_review":
				    			foreach ($this->user_logins as $key => $this->user_login) {
				    				if( $this->user->del_reviewer($this->conf_id,$this->user_login) ){
				    					$this->alert->show("s","成功將使用者 <strong>".$this->user_login."</strong> 取消設為審查人");
				    				}else{
				    					$this->alert->show("d","將使用者 <strong>".$this->user_login."</strong> 取消審查人失敗");
				    				}
				    			}
				    		break;
				    	}
				    	$this->alert->refresh(2);
			    	}else{
			    		$this->alert->js("請選擇使用者帳號");
			    	}
			    }
			}else{
				$this->load->view('common/header');
				$this->load->view('common/nav',$this->data);
				$this->load->view('conf/conf_nav',$this->data);
				$this->load->view('conf/menu_topic',$this->data);
				$this->load->view('topic/all_user',$this->data);
				$this->load->view('common/footer',$this->data);
			}
		}else{
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('conf/conf_nav',$this->data);
			$this->load->view('conf/menu_topic',$this->data);
			$this->alert->show("d","研討會為開啟主編審查人設置功能");
			$this->load->view('common/footer',$this->data);
		}
		
	}

	public function edit($conf_id='',$paper_id=''){
		$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
		$this->assets->add_js(asset_url().'js/repeatable.js',true);
		$this->assets->add_js(asset_url().'js/chosen.jquery.js',true);

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		if( $this->conf_config['topic_edit'] ){
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

				$this->data['topics'] = $this->conf->get_topic($this->conf_id);
				$this->data['paper']->sub_summary = str_replace("<br>",PHP_EOL,$this->data['paper']->sub_summary);
				$agrees = $this->conf->get_agrees($this->conf_id);
				$this->data['agrees'] = $agrees;
				$agree_value_array = $this->submit->get_agree($this->conf_id,$paper_id);
				$agree_value = array();
				foreach ($agree_value_array as $key => $value) {
					$agree_value[$value->agree_token] = $value->agree_value;
				}
				$this->data['agree_value'] = $agree_value;
						
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
								$this->alert->show("s","稿件資訊更新成功");
							}else{
								$this->alert->show("d","稿件資訊更新失敗");
							}
							$this->alert->refresh(2);
						}
					break;
					case "author":
						$this->form_validation->set_rules('user_fname[]', '名字', 'required');
						$this->form_validation->set_rules('user_lname[]', '姓氏', 'required');
						$this->form_validation->set_rules('user_email[]', '電子信箱', 'required|valid_email');
						$this->form_validation->set_rules('user_org[]', '所屬機構', 'required');
						$this->form_validation->set_rules('user_country[]', '國別', 'required');
						if ($this->form_validation->run()){
							$main_contact = $this->input->post('main_contact');
							$user_fname   = $this->input->post('user_fname');
							$user_mname   = $this->input->post('user_mname');
							$user_lname   = $this->input->post('user_lname');
							$user_email   = $this->input->post('user_email');
							$user_org     = $this->input->post('user_org');
							$user_country = $this->input->post('user_country');

							if( $this->submit->add_authors($paper_id,$user_fname,$user_mname,$user_lname,$user_email,$user_org,$user_country,$main_contact) ){
								$this->alert->show("s","作者資訊更新成功");
							}else{
								$this->alert->show("s","更新作者失敗");
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
				$this->load->view('topic/edit',$this->data);
			}else{
				$this->alert->js("查無本篇稿件",get_url("topic",$this->conf_id));
			}
		}else{
			$this->alert->show("d","本研討會尚未啟用這功能，請洽會議管理者",get_url("topic",$this->conf_id));
		}
		$this->load->view('common/footer',$this->data);
	}

	public function email($conf_id='',$paper_id=''){
		if( empty($paper_id) ){
			$this->alert->js("稿件不存在",get_url("topic",$this->conf_id,"index"));
			$this->load->view('common/footer',$this->data);
			$this->output->_display();
			exit;
		}
		$this->data['paper_id'] = $paper_id;
		$this->assets->set_title(lang('topic_assign'));
		$this->assets->add_js(base_url('ckeditor/ckeditor.js'));

		$paper_author = $this->submit->show_mypaper($this->user_login,$this->conf_id);
		$paper_array  = array();
		if(is_array($paper_author)){
			foreach ($paper_author as $key => $pa) {
				array_push($paper_array,$pa->sub_id);
			}
		}

		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		if( !in_array($paper_id,$paper_array) ){
			$paper = $this->topic->get_paperinfo($paper_id,$this->conf_id);
			$this->data['paper'] = $paper;
			if(!empty($paper)){
				$this->data['authors']    = $this->submit->get_author($paper_id);
				$authors = $this->data['authors'];
			}
			$this->form_validation->set_rules('subject', '主旨', 'required');
			$this->form_validation->set_rules('message', '內容', 'required');
			if ( $this->form_validation->run() ){
				$author_emails = array();
				if(!empty($authors)){
					foreach ($authors as $key => $author) {
						if( $author->main_contract ){
							array_push($author_emails,$author->user_email);
						}
					}
				}
				$subject = $this->input->post("subject");
				$message = $this->input->post("message",false);
				$message.= "<br><br>".$this->conf_config['conf_name'].'<br><a href="'.get_url($conf_id).'">'.get_url($conf_id).'</a>';
				if( $this->conf->sendmail($this->conf_id,$author_emails,$subject,$message,$this->user_login) ){
					$this->alert->js("寄送信件成功");
				}else{
					$this->alert->js("寄送信件失敗");
				}
				
			}
			$this->load->view('topic/email',$this->data);
		}else{
			$this->alert->js("由於您為本篇稿件作者之一，無法使用連絡作者功能",get_url("topic",$this->conf_id,"index"));
		}
		$this->load->view('common/footer',$this->data);
	}

	public function emails($conf_id=''){
		//連絡多篇連絡人
	}

	public function _tmp($conf_id=''){
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_topic',$this->data);
		$this->load->view('common/footer',$this->data);
	}
}