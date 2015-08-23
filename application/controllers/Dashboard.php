<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Conference {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		
	}

	public function index($conf_id=''){
		$data['conf_id'] = $conf_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($conf_id,$user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}else{
			$data['spage']=$this->config->item('spage');
			$data['conf_config']=$this->conf->conf_config($conf_id);
			$data['schedule']=$this->conf->conf_schedule($conf_id);
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
			$this->load->view('conf/conf_schedule',$data);

			$this->load->view('conf/menu_conf',$data);
			$this->load->view('conf/setting',$data);
			$this->load->view('common/footer');
		}
	}
	public function setting($conf_id=''){
		$this->index($conf_id);
	}
}