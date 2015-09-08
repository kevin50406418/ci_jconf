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
			$paper_author=$this->topic->get_paper($conf_id,$user_login);
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
			
			$paper_author=$this->topic->get_paper($conf_id,$user_login);
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
					$data['authors'] = $this->Submit->get_author($paper_id);
					$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
					$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);
				}
				$this->load->view('topic/detail',$data);
			}else{
				$this->alert->js("由於您為本篇稿件作者之一，無法分派本篇稿件",get_url("topic",$conf_id,"index"));
			}
			
			$this->load->view('common/footer');
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