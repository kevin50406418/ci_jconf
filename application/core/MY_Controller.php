<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	public $cinfo = array();
	public $body_class;
	public $_lang;
	public $data = array();
    public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = false;
		$this->body_class ="container";
		$this->assets->add_css(asset_url().'style/bootstrap.min.css');
		$this->assets->add_css(asset_url().'style/label.min.css');
		$this->assets->add_css(asset_url().'style/segment.min.css');
		$this->assets->add_css(asset_url().'style/menu.min.css');
		$this->assets->add_css(asset_url().'style/message.min.css');
		$this->assets->add_css(asset_url().'style/button.min.css');
		$this->assets->add_css(asset_url().'style/font-awesome.min.css');
		$this->assets->add_css(asset_url().'style/style.css');
		$this->assets->add_css(asset_url().'style/statistic.min.css');
		$this->_lang = $this->user->get_clang();
		$this->lang->load("conf_menu",$this->_lang);
		$this->lang->load("paper_status",$this->_lang);	
    }
}

class MY_Conference extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if( !$this->user->is_login() ){
			redirect('/user/login', 'location', 301);
		}
    }
}

class MY_Sysop extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if( !$this->user->is_login() ){
			redirect('/user/login', 'location', 301);
		}else{
			if( !$this->user->is_sysop() ){
				redirect(base_url(), 'location', 301);
			}
		}
    }
}

class MY_Topic extends MY_Controller{
    public function __construct(){
		parent::__construct();
		if( !$this->user->is_login() ){
			redirect('/user/login', 'location', 301);
			if( $this->user->is_topic() || $this->user->is_sysop()){
				
			}else{
				redirect(base_url(), 'location', 301);
			}
		}
    }
}
?>