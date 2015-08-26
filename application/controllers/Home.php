<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
	}
	public function index($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config();
			$this->cinfo['show_confinfo'] = false;
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer');
		}else{
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$data['spage']=$this->config->item('spage');

			$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;

			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);

				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				

				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				$this->load->view('common/footer');
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function news($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer');
		}else{
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$data['spage']=$this->config->item('spage');

			$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);

				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				$this->load->view('common/footer');
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function main($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer');
		}else{
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$data['spage']=$this->config->item('spage');

			$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;

			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);

				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				if($this->user->is_login()){
					$this->load->view('conf/menu_submit',$data);
					if($this->user->is_conf() || $this->user->is_sysop()){
						$this->load->view('conf/menu_conf',$data);
					}
					if($this->user->is_topic() || $this->user->is_sysop()){
						$this->load->view('conf/menu_topic',$data);
					}
					if($this->user->is_reviewer() || $this->user->is_sysop()){
						$this->load->view('conf/menu_reviewer',$data);
					}
				}
				$this->load->view('common/footer');
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function about($conf_id='',$page_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		if(empty($conf_id) || empty($page_id)){
			$data['confs']=$this->conf->all_conf_config();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer');
		}else{
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$data['spage']=$this->config->item('spage');

			$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;

			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);

				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				$this->load->view('common/footer');
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}

	public function ckeditor(){
		$this->assets->add_js(asset_url().'ckeditor/ckeditor.js');
		//print_r($this->input->post(NULL,FALSE));
		if ($this->form_validation->run() == FALSE){
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			//$this->load->view('ckeditor');
			$this->load->view('common/footer');
        }else{
           // $ckeditor1 = $this->input->post('ckeditor1', TRUE);
        }
	}
}
