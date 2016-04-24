<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.0.0
 * @date	2016/3/11
 */

class File extends MY_Conference {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		$this->user_sysop = $this->is_sysop?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($this->conf_id,$this->user->is_conf($this->conf_id)) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		$this->is_sysop    = $this->user_sysop;
		$this->is_conf     = $this->user->is_conf($this->conf_id);
		$this->is_topic    = $this->user->is_topic($this->conf_id);
		$this->is_reviewer = $this->user->is_reviewer($this->conf_id);
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->is_conf);
		$this->data['conf_id']     = $this->conf_id;
		$this->data['body_class']  = $this->body_class;
		$this->data['conf_config'] = $this->conf_config;

		if( !$this->is_conf && !$this->user_sysop ){
			$this->conf->show_permission_deny($this->data);
		}
		$this->load->helper('number');
		$this->assets->add_css(asset_url().'style/file.css');
	}

	public function index($conf_id=''){
		$files = array();
		$white_list = array("pdf","docx","doc","txt","xlsx","xls","gif","png","jpg","zip","rar","txt");
		$white_liststr = implode(",*.",$white_list);
		 
		$directory = $this->conf->get_filesdir($this->conf_id);
		$maps = glob($directory. "{*.".$white_liststr."}", GLOB_BRACE);
		
		foreach ($maps as $key => $map) {
			$file = get_file_info($map);
			array_push($files, $file);
		}
		$this->data['files'] = $files;
		$this->load->view('common/header');
		$this->load->view('file/index',$this->data);
	}

	public function image($conf_id=''){
		$files = array();
		$white_list = array("gif","png","jpg");
		$white_liststr = implode(",*.",$white_list);
		 
		$directory = $this->conf->get_filesdir($this->conf_id);
		$maps = glob($directory. "{*.".$white_liststr."}", GLOB_BRACE);
		
		foreach ($maps as $key => $map) {
			$file = get_file_info($map);
			array_push($files, $file);
		}
		$this->data['files'] = $files;
		$this->load->view('common/header');
		$this->load->view('file/image',$this->data);
	}
}