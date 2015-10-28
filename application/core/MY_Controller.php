<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	public $cinfo = array();
	public $data = array();
	public $body_class;
	public $_lang;
	public $conf_id;
	public $pg_id;
	public $spage;
	public $user_login;
    public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = false;
		$this->body_class = "container";
		$this->spage = $this->config->item('spage');

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
		$this->lang->load("conf",$this->_lang);

		$this->conf_id = $this->uri->segment(1);
		$pg_id = $this->uri->segment(2);

		if( $this->user->is_login() ){
			$this->user_login = $this->session->userdata('user_login');
			$bool_conf     = $this->session->has_userdata('priv_conf');
			$bool_topic    = $this->session->has_userdata('priv_topic');
			$bool_reviewer = $this->session->has_userdata('priv_reviewer');
			
			if( !$bool_conf || !$bool_topic || !$bool_reviewer ){
				$this->user->get_auth($this->session->user_login);
			}
			/*switch( $this->router->fetch_method() ){
				default:
					$this->conf_id = $this->uri->segment(3);
				break;
				case "index":
					if( $this->uri->total_segments() == 2){
						$this->conf_id = $this->uri->segment(2);
					}else{
						$this->conf_id = $this->uri->segment(3);
					}
				break;
				case "main":
					$this->conf_id = $this->uri->segment(2);
				break;
			}*/
			
		}else{
			if( $this->conf_id != "user"){
				$tmp_url = $this->session->redirected;
				$this->session->set_userdata('redirected', uri_string(current_url()));
				$this->session->set_userdata('redirect', $tmp_url);
			}
		}
		
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
			if( $this->user->is_topic($this->conf_id) || $this->user->is_sysop()){
				
			}else{
				redirect(base_url(), 'location', 301);
			}
		}
    }
}
?>