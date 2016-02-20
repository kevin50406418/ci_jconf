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
class Reviewer extends MY_Conference {
	public $conf_config;
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;

		$this->user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		$this->is_sysop    = $this->user_sysop;
		$this->is_conf     = $this->user->is_conf($this->conf_id);
		$this->is_topic    = $this->is_topic;
		$this->is_reviewer = $this->user->is_reviewer($this->conf_id);
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->is_conf);
		
		if( !$this->conf->confid_exists($this->conf_id,$this->user->is_conf($this->conf_id)) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		
		$this->assets->set_title_separator(" | ");
		$this->assets->set_site_name($this->conf_config['conf_name']);

		$this->data['conf_id']          = $this->conf_id;
		$this->data['body_class']       = $this->body_class;
		$this->data['_lang']            = $this->_lang;
		$this->data['spage']            = $this->config->item('spage');
		$this->data['conf_config']      = $this->conf_config;
		$this->data['conf_content']     = $this->conf->conf_content($this->conf_id);
		$this->data['schedule']         = $this->conf->get_schedules($this->conf_id);
		$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
		if( $this->is_topic || $this->is_sysop ){
			$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
		}

		if( !$this->is_reviewer || !$this->user_sysop ){
			$this->conf->show_permission_deny($this->data);
		}
	}

	public function index($conf_id=''){
		$this->data['papers']=$this->reviewer->get_paper($this->conf_id,$this->user_login);
		$this->data['time']=time();
		$paper_author=$this->submit->show_mypaper($this->user_login,$this->conf_id);
		$this->data['paper_author'] = array();
		if(is_array($paper_author)){
			foreach ($paper_author as $key => $pa) {
				array_push($this->data['paper_author'],$pa->sub_id);
			}
		}
		$this->load->view('common/header',$this->data);
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_reviewer',$this->data);
		$this->load->view('reviewer/list',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function detail($conf_id='',$paper_id=''){
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
		$this->data['paper_id'] = $paper_id;
		$this->load->view('common/header',$this->data);
		$this->load->view('common/nav',$this->data);
		$this->load->view('conf/conf_nav',$this->data);
		$this->load->view('conf/menu_reviewer',$this->data);
		if( !in_array($paper_id,$paper_array) ){
			$this->data['paper'] = $this->topic->get_paperinfo($paper_id,$this->conf_id);
			if(!empty($this->data['paper'])){
				$this->data['authors']    = $this->submit->get_author($paper_id);
				$this->data['otherfile']  = $this->submit->get_otherfile($paper_id);
				$this->data['otherfiles'] = $this->submit->get_otherfiles($paper_id);
				$this->data['reviewers']  = $this->reviewer->get_reviewer($paper_id);
				$user_reviewer=$this->reviewer->get_paper_reviewer($paper_id,$this->user_login);
			}
			
			$paper_is_review = $this->reviewer->is_review($paper_id,$this->user_login);
			if( !is_null($paper_is_review) ){
				$this->load->view('reviewer/detail',$this->data);

				if( $this->data['paper']->sub_status == 3 ){
					$this->data['review']  = $paper_is_review;
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
					$this->load->view('reviewer/reviewer',$this->data);
				}
			}else{
				$this->alert->js("您無法審查本篇稿件",get_url("reviewer",$this->conf_id,"index"));
			}
		}else{
			$this->alert->js("由於您為本篇稿件作者之一，無法審查本篇稿件",get_url("reviewer",$this->conf_id,"index"));
		}
		$this->load->view('common/footer',$this->data);
	}

	public function files($conf_id='',$paper_id=''){
		if( empty($this->conf_id) || empty($paper_id) ){
			$this->alert->file_notfound(get_url("reviewer",$this->conf_id));
		}
		if( is_null($this->input->get("fid") ) ){
			$this->alert->file_notfound(get_url("reviewer",$this->conf_id));
		}else{
			$fid  = $this->input->get("fid");
			$file = $this->reviewer->get_file($fid,$paper_id,$this->user_login);
			if(empty($file)){
				$this->alert->file_notfound(get_url("reviewer",$this->conf_id));
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
}
?>