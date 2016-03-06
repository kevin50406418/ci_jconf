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

class Ajax extends MY_Conference {
	public function __construct(){
		parent::__construct();
		if( !$this->input->is_ajax_request() ){
			exit("permissions deny");
		}
	}

	public function paperlist($conf_id){
		if( !$this->user->is_conf($this->conf_id) ){
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
		if( !$this->user->is_conf($this->conf_id) ){
			exit("permissions deny");
		}
		$this->data['papers'] = $this->exportdata->get_finishpapers($conf_id);
		$this->data['files'] = $this->exportdata->get_finishfiles($conf_id);
		$this->load->view('exportdata/preview/finishpapers',$this->data);
	}
}