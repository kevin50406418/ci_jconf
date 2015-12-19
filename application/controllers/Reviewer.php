<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviewer extends MY_Conference {
	public $conf_config;
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		$this->user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;

		if( !$this->conf->confid_exists($this->conf_id,$this->user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->user_sysop);
		if( $this->user->is_reviewer($this->conf_id) || $this->user_sysop ){
			
		}else{
			$data['conf_id'] = $this->conf_id;
			$data['body_class'] = $this->body_class;
			$data['conf_config']=$this->conf_config;
			$this->conf->show_permission_deny($data);
		}
	}

	public function index($conf_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['_lang'] = $this->_lang;
		$data['spage']=$this->config->item('spage');
		$data['conf_config']=$this->conf_config;
		$data['conf_content']=$this->conf->conf_content($conf_id);
		$data['schedule'] = $this->conf->get_schedules($this->conf_id);
		$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);
		
		if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
			$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
		}
		
		$data['papers']=$this->reviewer->get_paper($conf_id,$this->user_login);
		$data['time']=time();
		$paper_author=$this->Submit->show_mypaper($this->user_login,$conf_id);
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
		$this->load->view('conf/menu_reviewer',$data);
		$this->load->view('reviewer/list',$data);
		$this->load->view('common/footer',$data);
	}

	public function detail($conf_id='',$paper_id=''){
		$data['conf_id'] = $conf_id;
		$data['body_class'] = $this->body_class;
		$data['_lang'] = $this->_lang;
		$data['paper_id'] = $paper_id;
		$data['spage']=$this->config->item('spage');
		$data['conf_config']=$this->conf_config;
		$data['conf_content']=$this->conf->conf_content($conf_id);
		$data['schedule'] = $this->conf->get_schedules($this->conf_id);
		$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);

		if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
			$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
		}

		if( empty($paper_id) ){
			$this->alert->js("稿件不存在",get_url("topic",$conf_id,"index"));
			$this->load->view('common/footer',$data);
			$this->output->_display();
			exit;
		}
		$paper_author=$this->Submit->show_mypaper($this->user_login,$conf_id);
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
		$this->load->view('conf/menu_reviewer',$data);
		if( !in_array($paper_id,$paper_array) ){
			$data['paper'] = $this->topic->get_paperinfo($paper_id,$conf_id);
			if(!empty($data['paper'])){
				$data['authors']    = $this->Submit->get_author($paper_id);
				$data['otherfile']  = $this->Submit->get_otherfile($paper_id);
				$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);
				$data['reviewers']  = $this->reviewer->get_reviewer($paper_id);
				$user_reviewer=$this->reviewer->get_paper_reviewer($paper_id,$this->user_login);
			}
			
			$paper_is_review = $this->reviewer->is_review($paper_id,$this->user_login);
			if( !is_null($paper_is_review) ){
				$this->load->view('reviewer/detail',$data);

				if( $data['paper']->sub_status == 3 ){
					$data['review']  = $paper_is_review;
					$this->form_validation->set_rules('review_status', '審查狀態', 'required');
				    $this->form_validation->set_rules('review_comment', '審查建議', 'required');
				    if ( $this->form_validation->run() ){
						$review_status  = $this->input->post('review_status', TRUE);
						$review_comment = $this->input->post('review_comment', TRUE);
						if( in_array($review_status,array(-2,0,2,4)) ){
							if( $this->reviewer->update_review($this->conf_id,$paper_id,$this->user_login,$review_status,$review_comment) ){
								if( $paper_is_review->review_status == 3 ){
									$this->alert->js("成功送出審查意見");
								}else{
									$this->alert->js("成功更新審查意見");
								}
							}else{
								if( $paper_is_review->review_status == 3 ){
									$this->alert->js("審查意見送出失敗");
								}else{
									$this->alert->js("審查意見更新失敗");
								}
							}
						}else{
							$this->alert->js("請選擇正確審查狀態");
						}
						$this->alert->refresh(2);
				    }
					$this->load->view('reviewer/reviewer',$data);
				}
			}else{
				$this->alert->js("您無法審查本篇稿件",get_url("reviewer",$conf_id,"index"));
			}
		}else{
			$this->alert->js("由於您為本篇稿件作者之一，無法審查本篇稿件",get_url("reviewer",$conf_id,"index"));
		}
		$this->load->view('common/footer',$data);
	}

	public function files($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->file_notfound(get_url("reviewer",$conf_id));
		}
		$data['conf_id'] = $conf_id;
		
		if( is_null($this->input->get("fid") ) ){
			$this->alert->file_notfound(get_url("reviewer",$conf_id));
		}else{
			$fid = $this->input->get("fid");
			$file=$this->reviewer->get_file($fid,$paper_id,$this->user_login);
			if(empty($file)){
				$this->alert->file_notfound(get_url("reviewer",$conf_id));
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
?>