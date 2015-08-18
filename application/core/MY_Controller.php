<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	public $cinfo = array();
    public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = false;
		$this->assets->global_header();
		$this->assets->add_css(asset_url().'style/statistic.min.css');
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



?>