<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		/*$CI = & get_instance();
		$CI->load->vars($data);*/
	}
	
	public function index($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config($user_sysop);
			$data['test_conf'] = in_array($this->user_login,$this->config->item("tester"))?array():$this->config->item("test_conf");
			
			$this->cinfo['show_confinfo'] = false;
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer',$data);
		}else{
			$data['spage']=$this->config->item('spage');
			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id,$user_sysop);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);
				$data['conf_news'] = $this->conf->get_news($conf_id);
				$data['content']=$this->conf->get_content($this->conf_id,"index",$this->_lang);
				$data['conf_id'] = $conf_id;
				$conf_col=$data['conf_config']['conf_col'];
				$conf_template=$data['conf_config']['conf_template'];
				$template_dir = "template/".$conf_template."/";
				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $data['conf_config']['conf_keywords'], "name");

				$schedule = $this->conf->get_schedules($this->conf_id);
				$data['schedule'] = $schedule;
				
				if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
					$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
				}
				if($this->user->is_reviewer($conf_id) || $this->user->is_sysop()){
					$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);
				}

				if( $conf_template == "default"){
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('conf/index');
					$this->load->view('conf/conf_nav',$data);
					//$this->load->view('conf/conf_schedule',$data);
					
					$data['col_index'] = array("index","news");
					$data['col_sidebar_1'] = array("schedule");
					$data['col_sidebar_2'] = array("");

					$this->load->view($template_dir."col-".$conf_col,$data);

					$this->load->view('common/footer',$data);
				}else{
					$data['col_index'] = array("index");// 
					$data['col_sidebar_1'] = array("schedule","news");
					$data['col_sidebar_2'] = array("");
					
					$this->load->view($template_dir.'header',$data);
					$this->load->view($template_dir."col-".$conf_col,$data);
					$this->load->view($template_dir.'footer',$data);
				}
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function news($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config($user_sysop);
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer',$data);
		}else{
			$data['spage']=$this->config->item('spage');
			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id,$user_sysop);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);
				$data['conf_news'] = $this->conf->get_news($conf_id);
				$conf_col=$data['conf_config']['conf_col'];
				$conf_template=$data['conf_config']['conf_template'];
				$template_dir = "template/".$conf_template."/";
				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $data['conf_config']['conf_keywords'], "name");
				
				$schedule = $this->conf->get_schedules($this->conf_id);
				$data['schedule'] = $schedule;
				if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
					$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
				}
				if($this->user->is_reviewer($conf_id) || $this->user->is_sysop()){
					$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);
				}
				if( $conf_template == "default"){
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('conf/index');
					$this->load->view('conf/conf_nav',$data);
					//$this->load->view('conf/conf_schedule',$data);
					
					$data['col_index'] = array("index","news");
					$data['col_sidebar_1'] = array("schedule");
					$data['col_sidebar_2'] = array("");

					$this->load->view('conf/news',$data);

					$this->load->view('common/footer',$data);
				}else{
					$data['col_index'] = array("news");// 
					$data['col_sidebar_1'] = array("schedule");
					$data['col_sidebar_2'] = array("");
					
					$this->load->view($template_dir.'header',$data);
					$this->load->view($template_dir."col-".$conf_col,$data);
					$this->load->view($template_dir.'footer',$data);
				}
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function main($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if(empty($conf_id)){
			$data['confs']=$this->conf->all_conf_config($user_sysop);
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer',$data);
		}else{
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$data['spage']=$this->config->item('spage');
			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id,$user_sysop);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);

				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $data['conf_config']['conf_keywords'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');
				$data['schedule'] = $this->conf->get_schedules($this->conf_id);
				
				if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
					$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
				}
				if($this->user->is_reviewer($conf_id) || $this->user->is_sysop()){
					$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);
				}
		
				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				
				$this->load->view('conf/menu_submit',$data);
				if($this->user->is_conf($conf_id) || $this->user->is_sysop()){
					$this->load->view('conf/menu_conf',$data);
				}
				if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
					$this->load->view('conf/menu_topic',$data);
				}
				if($this->user->is_reviewer($conf_id) || $this->user->is_sysop()){
					$this->load->view('conf/menu_reviewer',$data);
				}
				
				$this->load->view('common/footer',$data);
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function about($conf_id='',$page_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $conf_id;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if(empty($conf_id) || empty($page_id)){
			$data['confs']=$this->conf->all_conf_config($user_sysop);
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('common/index',$data);
			$this->load->view('common/footer',$data);
		}else{
			$spage = $this->config->item('spage');
			$data['spage'] = $spage;
			if(in_array($page_id,$spage)){
				redirect($conf_id."/".$page_id,'location',301);
			}
			if( $this->conf->confid_exists($conf_id,$user_sysop) ){
				$data['conf_config']=$this->conf->conf_config($conf_id,$user_sysop);
				//$data['schedule']=$this->conf->conf_schedule($conf_id);
				$data['conf_content']=$this->conf->conf_content($conf_id);
				$data['content']=$this->conf->get_content($conf_id,$page_id,$this->_lang);
				$data['conf_news'] = $this->conf->get_news($conf_id);
				$schedule = $this->conf->get_schedules($this->conf_id);
				$data['schedule'] = $schedule;
				$conf_col=$data['conf_config']['conf_col'];
				$conf_template=$data['conf_config']['conf_template'];
				$template_dir = "template/".$conf_template."/";
				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $data['conf_config']['conf_keywords'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				if($this->user->is_topic($conf_id) || $this->user->is_sysop()){
					$data['topic_pedding'] = $this->topic->count_pedding_paper($conf_id,$this->user_login);
				}
				if($this->user->is_reviewer($conf_id) || $this->user->is_sysop()){
					$data['reviewer_pedding'] = $this->reviewer->count_review($conf_id,$this->user_login);
				}

				if( $conf_template == "default"){
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('conf/index');
					$this->load->view('conf/conf_nav',$data);
					//$this->load->view('conf/conf_schedule',$data);
					
					$data['col_index'] = array("index","news");
					$data['col_sidebar_1'] = array("schedule");
					$data['col_sidebar_2'] = array("");

					if($data['content']->page_show == 1){
						$this->load->view('conf/about',$data);
					}else{
						$this->cinfo['show_confinfo'] = false;
						$this->conf->show_404conf();
					}
					$this->load->view('common/footer',$data);
				}else{
					$this->load->view($template_dir.'header',$data);
					$this->load->view($template_dir.'about',$data);
					$this->load->view($template_dir.'footer',$data);
				}
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}

	public function change_lang($lang='zhtw'){
		if ( $this->input->is_ajax_request() ){
			switch($lang){
				case "zhtw":
				case "zh-tw":
				case "tw":
				case "zh":
					$lang = "zhtw";
				break;
				default:
				case "en-us":
				case "en":
					$lang = "en";
				break;
			}
			$this->_lang = $lang;
			$this->session->set_userdata('lang', $lang);
			$this->alert->js_refresh();
		}else{
			$this->alert->js("No direct script access allowed",site_url());
		}
	}
	public function page404($conf_id=''){
		$data['body_class'] = $this->body_class;
		$data['conf_id'] = $this->conf_id;
		$this->cinfo['show_confinfo'] = false;
		$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !empty($this->conf_id) ){
			if( $this->conf->confid_exists($this->conf_id,$user_sysop) ){
				redirect(get_url("index",$this->conf_id), 'location', 301);
			}else{
				$this->conf->show_404conf();
			}
		}else{
			$this->conf->show_404conf();
		}
	}
	
}
