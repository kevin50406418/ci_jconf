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