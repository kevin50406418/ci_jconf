<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Help extends MY_Controller {
	public function __construct() {        
	    parent::__construct();
	    $this->assets->set_title("幫助中心");
		$this->data['body_class'] = $this->body_class;
	}

	public function index(){
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('help/index',$this->data);
		$this->load->view('common/footer',$this->data);
	}

	public function support(){
		$this->load->view('common/header');
		$this->load->view('common/nav',$this->data);
		$this->load->view('help/support',$this->data);
		$this->load->view('common/footer',$this->data);
	}
}
?>