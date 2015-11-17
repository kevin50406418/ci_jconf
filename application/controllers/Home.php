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

				$schedule = $this->conf->get_schedules($this->conf_id);
				$data['schedule'] = $schedule;
				
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
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				$schedule = $this->conf->get_schedules($this->conf_id);
				$data['schedule'] = $schedule;
				
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
				$this->assets->add_css(asset_url().'style/statistic.min.css');
				$data['schedule'] = $this->conf->get_schedules($this->conf_id);
				
				$this->load->view('common/header');
				$this->load->view('common/nav',$data);
				$this->load->view('conf/index');
				$this->load->view('conf/conf_nav',$data);
				//$this->load->view('conf/conf_schedule',$data);
				if($this->user->is_login()){
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
				$conf_col=$data['conf_config']['conf_col'];
				$conf_template=$data['conf_config']['conf_template'];
				$template_dir = "template/".$conf_template."/";
				$this->assets->add_meta_tag("description", $data['conf_config']['conf_desc'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

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
			$this->alert->js("No direct script access allowed",base_url());
		}
	}

	public function debug(){
		$data['body_class'] = $this->body_class;
		$this->cinfo['show_confinfo'] = false;
		if(!$this->user->is_sysop()){
			redirect('/', 'location', 301);
		}

		$conf_configs = $this->conf->all_conf_config(true);
		foreach ($conf_configs as $key => $conf_config) {
			$conf_id = $conf_config->conf_id;
				$conf_content = array(
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'index',
						'page_title'  => "首頁",
						'page_lang'   => "zhtw",
						'page_show'   => 1,
						"page_order"  => 0,
						"page_edit"   => 1,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'index',
						'page_title'  => "Home",
						'page_lang'   => "eng",
						'page_show'   => 1,
						"page_order"  => 0,
						"page_edit"   => 1,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'main',
						'page_title'  => "研討會系統",
						'page_lang'   => "zhtw",
						'page_show'   => 1,
						"page_order"  => 1,
						"page_edit"   => 0,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'main',
						'page_title'  => "Conference System",
						'page_lang'   => "eng",
						'page_show'   => 1,
						"page_order"  => 1,
						"page_edit"   => 0,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'news',
						'page_title'  => "最新公告",
						'page_lang'   => "zhtw",
						'page_show'   => 1,
						"page_order"  => 2,
						"page_edit"   => 0,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'news',
						'page_title'  => "News",
						'page_lang'   => "eng",
						'page_show'   => 1,
						"page_order"  => 2,
						"page_edit"   => 0,
						"page_hidden" => 0,
						"page_del"    => 0
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'program',
						'page_title'  => "會議議程",
						'page_lang'   => "zhtw",
						'page_show'   => 0,
						"page_order"  => 3,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'program',
						'page_title'  => "Program",
						'page_lang'   => "eng",
						'page_show'   => 0,
						"page_order"  => 3,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'submission',
						'page_title'  => "論文投稿",
						'page_lang'   => "zhtw",
						'page_show'   => 0,
						"page_order"  => 4,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'submission',
						'page_title'  => "Submission",
						'page_lang'   => "eng",
						'page_show'   => 0,
						"page_order"  => 4,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'org',
						'page_title'  => "大會組織",
						'page_lang'   => "zhtw",
						'page_show'   => 0,
						"page_order"  => 5,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'org',
						'page_title'  => "Organization",
						'page_lang'   => "eng",
						'page_show'   => 0,
						"page_order"  => 5,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'supplier',
						'page_title'  => "協辦及贊助單位",
						'page_lang'   => "zhtw",
						'page_show'   => 0,
						"page_order"  => 6,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),
			        array(
						'conf_id'     => $conf_id,
						'page_id'     => 'supplier',
						'page_title'  => "Supplier",
						'page_lang'   => "eng",
						'page_show'   => 0,
						"page_order"  => 6,
						"page_edit"   => 1,
						"page_hidden" => 1,
						"page_del"    => 1
			        ),

			    );
			foreach ($conf_content as $key => $conf_contents) {
				// $this->db->insert('conf_content',$conf_contents);
			}
		}

		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		
		$this->load->view('common/footer',$data);
	}

	public function _ckeditor(){
		$data['body_class'] = $this->body_class;
		$this->cinfo['show_confinfo'] = false;
		$this->assets->add_js(base_url().'tinymce/tinymce.min.js');
		//print_r($this->input->post(NULL,FALSE));
		if ($this->form_validation->run() == FALSE){
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('ckeditor');
			$this->load->view('common/footer',$data);
        }else{
           // $ckeditor1 = $this->input->post('ckeditor1', TRUE);
        }
	}
}
