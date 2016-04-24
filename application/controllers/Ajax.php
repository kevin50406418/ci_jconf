<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.0.0
 * @date	2016/2/27
 */

class Ajax extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if( !$this->input->is_ajax_request() ){
			exit("permissions deny");
		}
	}

	public function paperlist($conf_id){
		if( !$this->conf->confid_exists($conf_id,$this->user->is_conf($conf_id)) ){
			exit("permissions deny");
		}
		if( !$this->user->is_conf($conf_id) ){
			exit("permissions deny");
		}
		$this->form_validation->set_rules('topic[]', '投稿主題', 'required');
		$this->form_validation->set_rules('status[]', '投稿狀態', 'required');
		
		if ($this->form_validation->run()){
			$topic  = $this->input->post("topic");
			$status = $this->input->post("status");
			
			$this->data['papers'] = $this->exportdata->get_paperlist($topic,$status,$conf_id);
			$this->load->view('exportdata/xls/paperlist',$this->data);
		}else{
			echo validation_errors('<div class="ui message red">', '</div>');
		}
	}

	public function finishpapers($conf_id){
		if( !$this->conf->confid_exists($conf_id,$this->user->is_conf($conf_id)) ){
			exit("permissions deny");
		}
		if( !$this->user->is_conf($this->conf_id) ){
			exit("permissions deny");
		}
		$this->data['papers'] = $this->exportdata->get_finishpapers($conf_id);
		$this->data['files'] = $this->exportdata->get_finishfiles($conf_id);
		$this->load->view('exportdata/preview/finishpapers',$this->data);
	}

	public function calsignup($conf_id){
		if( !$this->conf->confid_exists($conf_id,$this->user->is_conf($conf_id)) ){
			exit("permissions deny");
		}
		$price_type = $this->input->post("price_type");
		$signup_price = $this->signup->cal_signup_price($conf_id,$price_type);
		echo $signup_price;
	}

	public function conf_calsignup($conf_id,$signup_id){
		if( !$this->conf->confid_exists($conf_id,$this->user->is_conf($conf_id)) ){
			exit("permissions deny");
		}
		if( !$this->user->is_conf($this->conf_id) ){
			exit("permissions deny");
		}
		$signup = $this->conf->get_signup($conf_id,$signup_id);
		if( !empty($signup)){
			$price_type = $this->input->post("price_type");
			$signup_price = $this->signup->cal_signup_price($conf_id,$price_type,$signup);
			echo $signup_price;
		}
	}

	public function signuplist($conf_id){
		if( !$this->conf->confid_exists($conf_id,$this->user->is_conf($conf_id)) ){
			exit("permissions deny");
		}
		if( !$this->user->is_conf($this->conf_id) ){
			exit("permissions deny");
		}
		$this->data['signups'] = $this->conf->get_signups($conf_id);
		$this->load->view('exportdata/preview/signuplist',$this->data);
	}
}