<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.1.0
 * @date	2016/3/5
 */
class Reviewer extends MY_Conference {
	public $conf_config;
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;

		$this->user_sysop  = $this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
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
		$this->assets->set_title(lang('reviewer_paper'));
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
		$this->assets->set_title(lang('reviewer_paper'));
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
			$review_forms    = $this->conf->get_review_forms($this->conf_id);
			$form_elements   = $this->conf->get_review_form_elements($this->conf_id);
			$recommend_forms = $this->conf->get_recommend_forms($this->conf_id);
			$this->data["review_forms"]    = $review_forms;
			$this->data["form_elements"]   = $form_elements;
			$this->data["recommend_forms"] = $recommend_forms;
			$paper_is_review = $this->reviewer->is_review($paper_id,$this->user_login);
			if( !is_null($paper_is_review) ){
				$this->load->view('reviewer/detail',$this->data);

				if( $this->data['paper']->sub_status == 3 ){
					$this->data['review']  = $paper_is_review;
					if( !$paper_is_review->review_status ){ // 未審查表單
						foreach ($review_forms as $key => $form) {
							$this->form_validation->set_rules($form->review_form_name, $form->review_form_title, 'required|is_natural');
						}
						foreach ($recommend_forms as $key => $recommend) {
							$this->form_validation->set_rules($recommend->recommend_form_name, $recommend->recommend_form_title, 'required|is_natural');
						}

						if ( $this->form_validation->run() ){
							$element_value = array();
							$recommend_value = array();
							$review_score = 0;
							foreach ($review_forms as $key => $form) {
								$element_value[$form->review_form_name] = $this->input->post($form->review_form_name);
								$review_score += $this->input->post($form->review_form_name);
							}
							foreach ($recommend_forms as $key => $recommend) {
								$recommend_value[$recommend->recommend_form_name] = $this->input->post($recommend->recommend_form_name);
							}
							$review_comment = $this->input->post('review_comment');
							
							if( $this->reviewer->add_review_responses($this->conf_id,$paper_id,$user_reviewer->review_id,$element_value,$recommend_value) ){
								$this->reviewer->update_review($this->conf_id,$paper_id,$this->user_login,$review_comment,$review_score);
								$this->alert->js("成功送出審查表單，感謝您的審查");
							}else{
								$this->alert->js("審查表單送出失敗");
							}
						}
						$this->load->view('reviewer/reviewer',$this->data);
					}else{
						$this->data["review_responses"] = $this->reviewer->get_reviewform($user_reviewer->review_id,$paper_id,$this->conf_id);
						$this->data["review_recommends"] = $this->reviewer->get_recommendform($user_reviewer->review_id,$paper_id,$this->conf_id);
						$this->load->view('reviewer/review_forms',$this->data);
					}
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