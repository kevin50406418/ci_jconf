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
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			//$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_topic',$data);
			$this->load->view('topic/list',$data);
			$this->load->view('common/footer');
		}
	}

	public function _tmp($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
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