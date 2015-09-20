<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends MY_Topic {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		
	}

	public function index($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['_lang'] = $this->_lang;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);

			if( !$this->user->is_topic() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			$user_login = $this->session->userdata('user_login');
			$data['topics']=$this->topic->get_topic($conf_id,$user_login);
			if( is_null( $this->input->get('id', TRUE) ) ){
				$data['papers']=$this->topic->get_paper($conf_id,$user_login);
			}else{
				$topic_id = $this->input->get('id', TRUE);
				$data['papers']=$this->topic->get_paper($conf_id,$user_login,$topic_id);
			}
			$paper_author=$this->Submit->show_mypaper($user_login,$conf_id);
			$data['paper_author'] = array();
			if(is_array($paper_author)){
				foreach ($paper_author as $key => $pa) {
					array_push($data['paper_author'],$pa->sub_id);
				}
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_topic',$data);
			$this->load->view('topic/list',$data);
			$this->load->view('common/footer');
		}
	}

	public function detail($conf_id='',$paper_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['_lang'] = $this->_lang;
		$data['paper_id'] = $paper_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);

			if( !$this->user->is_topic() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			if( empty($paper_id) ){
				$this->alert->js("稿件不存在",get_url("topic",$conf_id,"index"));
				$this->load->view('common/footer');
				$this->output->_display();
				exit;
			}
			$user_login = $this->session->userdata('user_login');
			
			$paper_author=$this->Submit->show_mypaper($user_login,$conf_id);
			$paper_array = array();
			if(is_array($paper_author)){
				foreach ($paper_author as $key => $pa) {
					array_push($paper_array,$pa->sub_id);
				}
			}
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_topic',$data);
			if( !in_array($paper_id,$paper_array) ){
				$data['paper'] = $this->topic->get_paperinfo($paper_id,$conf_id);
				if(!empty($data['paper'])){
					$data['reviewers']=$this->conf->get_reviewer($conf_id);
					$data['authors'] = $this->Submit->get_author($paper_id);
					$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
					$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);

					if( $data['paper']->sub_status == 1 ){
						$pedding_reviewers=$this->topic->get_reviewer_pedding($conf_id,$paper_id);
						
						$is_pedding = array(); //目前已被分派至審查帳號
						$not_reviewers = array(); //無法被分派審查帳號(作者群+審查人)
						foreach ($pedding_reviewers as $key => $v) {//審查人
							array_push($is_pedding,$v->user_login);
							array_push($not_reviewers,$v->user_login);
						}

						foreach ($data['authors'] as $key => $v) {//作者群
							array_push($not_reviewers,$v->user_login);
						}
						$data['pedding_reviewers'] = $pedding_reviewers;
						$data['not_reviewers'] = $not_reviewers;//無法被分派審查帳號(作者群+審查人)
						$data['pedding_count'] = count($data['pedding_reviewers']);
						if( $data['paper']->sub_status == 1 ){
							$this->form_validation->set_rules('user_login[]', '帳號', 'required');
							$this->form_validation->set_rules('type', '', 'required');
							if ($this->form_validation->run()){
								$type = $this->input->post('type');
								$user_logins = $this->input->post('user_login');
								switch($type){
									case "add":
										if( $data['pedding_count']+count($user_logins)<=5 ){
											foreach ($user_logins as $key => $user_login) {
												if( !in_array($user_login, $data['not_reviewers']) ){
													if( $this->topic->assign_reviewer_pedding($paper_id,$user_login) ){
														$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 加入本篇稿件審查");
													}else{
														$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 加入本篇稿件審查失敗");
													}
												}else{
													$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法審查本篇稿件");
												}
											}
										}else{
											$this->alert->js("審查人最多5人");
										}
										$this->alert->refresh(2);
									break;
									case "confirm":
										if($data['pedding_count']<=5){
											if( $data['pedding_count']%2 == 1 ){
												foreach ($is_pedding as $key => $user_login) {
													if( !in_array($user_login, $data['not_reviewers']) ){
														$this->alert->show("d","使用者 <strong>".$user_login."</strong> 無法審查本篇稿件!!");
														$this->output->_display();
														exit;
													}
												}
												foreach ($is_pedding as $key => $user_login) {
													if( $this->topic->assign_reviewer($paper_id,$user_login) ){
														$this->Submit->paper_to_reviewing($conf_id,$paper_id);
														$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 加入本篇稿件審查");
													}else{
														$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 加入本篇稿件審查失敗");
													}
												}
											}else{
												$this->alert->js("審查人必須為奇數個");
											}
										}else{
											$this->alert->js("審查人最多5人");
										}
										$this->alert->refresh(2);
									break;
									case "del":
										foreach ($user_logins as $key => $user_login) {
											if( $this->topic->del_reviewer_pedding($paper_id,$user_login) ){
												$this->alert->show("s","成功將使用者 <strong>".$user_login."</strong> 移除本篇稿件審查");
											}else{
												$this->alert->show("d","將使用者 <strong>".$user_login."</strong> 移除本篇稿件審查失敗");
											}
											
										}
										$this->alert->refresh(2);
									break;
								}
							}
							$this->load->view('topic/reviewers',$data);
							$this->load->view('topic/pedding_reviewers',$data);
						}
					}
					if( $data['paper']->sub_status >= 3 ){
						$data['reviewers'] = $this->topic->get_reviewer($paper_id);
						
					}
					$this->load->view('topic/detail',$data);
				}
			}else{
				$this->alert->js("由於您為本篇稿件作者之一，無法分派本篇稿件",get_url("topic",$conf_id,"index"));
			}
			
			$this->load->view('common/footer');
		}
	}

	public function files($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
		}
		$data['conf_id'] = $conf_id;

		$user_login = $this->session->userdata('user_login');
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			if( is_null($this->input->get("fid") ) ){
				$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
				$this->load->view('common/footer');
				$this->output->_display();
				exit;
			}else{
				$fid = $this->input->get("fid");
				$file=$this->topic->get_file($fid,$paper_id,$user_login);
				if(empty($file)){
					$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
					$this->load->view('common/footer');
					$this->output->_display();
					exit;
				}
				$this->load->helper('download');
				$do = $this->input->get("do");
				switch($do){
					case "download":
						force_download($file->file_name,file_get_contents($this->conf->get_paperdir($conf_id).$file->file_system));
					break;
					default:
					case "view":
						$this->output
							->set_content_type('pdf')
							->set_header("Content-Disposition: inline; filename=\"".$paper_id."-".$file->fid."-".$file->file_name."\"")
							->set_output(file_get_contents($this->conf->get_paperdir($conf_id).$file->file_system));
					break;
				}
			}
		}
	}

	public function _tmp($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['_lang'] = $this->_lang;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
			$data['conf_content']=$this->conf->conf_content($conf_id);

			if( !$this->user->is_topic() && !$this->user->is_sysop() ){
				$this->conf->show_permission_deny($data);
			}
			
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_topic',$data);
			
			$this->load->view('common/footer');
		}
	}
}