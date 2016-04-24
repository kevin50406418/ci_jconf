<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @package	Jconf
 * @author	Jingxun Lai
 * @copyright	Copyright (c) 2015 - 2016, Jingxun Lai, Inc. (https://jconf.tw/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://jconf.tw
 * @since	Version 1.0.0
 * @date	2016/2/20 
 */

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		$this->data['body_class']     = $this->body_class;
		$this->data['conf_id']        = $this->conf_id;
		$this->data['spage']          = $this->config->item('spage');
		$this->user_sysop  = $this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		$this->is_sysop    = $this->user_sysop;
		$this->is_conf     = $this->user->is_conf($this->conf_id);
		$this->is_topic    = $this->user->is_topic($this->conf_id);
		$this->is_reviewer = $this->user->is_reviewer($this->conf_id);
	}
	public function index($conf_id=""){
		if( empty($conf_id) ){
			$this->data['confs']=$this->conf->all_conf_config(1);
			$this->assets->set_title_separator("");
			$this->cinfo['show_confinfo'] = false;
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('common/index',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
				$this->data['conf_config']=$this->conf->conf_config($this->conf_id,$this->is_conf);
				$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);
				$this->data['conf_news']    = $this->conf->get_news($this->conf_id);
				$this->data['content']      = $this->conf->get_content($this->conf_id,"index",$this->_lang);
				$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);

				$this->assets->set_title($this->data['content']->page_title);
				$this->assets->set_title_separator(" | ");
				$this->assets->set_site_name($this->data['conf_config']['conf_name']);
				$this->assets->add_meta_tag("description", $this->data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $this->data['conf_config']['conf_keywords'], "name");

				$conf_col      = $this->data['conf_config']['conf_col'];
				$conf_template = $this->data['conf_config']['conf_template'];
				$template_dir  = "template/".$conf_template."/";

				if( $this->is_topic || $this->is_sysop ){
					$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
				}
				if( $this->is_reviewer || $this->is_sysop ){
					$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
				}

				if( $conf_template == "default"){
					$this->data['col_index'] = array("index","news");
					$this->data['col_sidebar_1'] = array("schedule");
					$this->data['col_sidebar_2'] = array("");

					$this->load->view('common/header',$this->data);
					$this->load->view('common/nav',$this->data);
					$this->load->view('conf/index',$this->data);
					$this->load->view('conf/conf_nav',$this->data);
					$this->load->view($template_dir."col-".$conf_col,$this->data);
					$this->load->view('common/footer',$this->data);
				}else{
					$this->data['col_index'] = array("index");// 
					$this->data['col_sidebar_1'] = array("schedule","news");
					$this->data['col_sidebar_2'] = array("");
					
					$this->load->view($template_dir.'header',$this->data);
					$this->load->view($template_dir."col-".$conf_col,$this->data);
					$this->load->view($template_dir.'footer',$this->data);
				}
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}
	public function news($conf_id=""){
		if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
			$this->data['conf_config']  = $this->conf->conf_config($this->conf_id,$this->is_conf);
			$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);
			$this->data['conf_news']    = $this->conf->get_news($this->conf_id);
			$this->data['content']      = $this->conf->get_content($this->conf_id,"news",$this->_lang);
			$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);

			$this->assets->set_title($this->data['content']->page_title);
			$this->assets->set_title_separator(" | ");
			$this->assets->set_site_name($this->data['conf_config']['conf_name']);
			$this->assets->add_rss_feed(get_url("rss",$conf_id), $this->data['conf_config']['conf_name']);
			$this->assets->add_meta_tag("description", $this->data['conf_config']['conf_desc'], "name");
			$this->assets->add_meta_tag("keywords", $this->data['conf_config']['conf_keywords'], "name");

			$conf_col      = $this->data['conf_config']['conf_col'];
			$conf_template = $this->data['conf_config']['conf_template'];
			$template_dir  = "template/".$conf_template."/";

			if( $this->is_topic || $this->user_sysop ){
				$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
			}
			if( $this->is_reviewer || $this->user_sysop ){
				$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
			}
			if( $conf_template == "default"){
				$this->data['col_index'] = array("index","news");
				$this->data['col_sidebar_1'] = array("schedule");
				$this->data['col_sidebar_2'] = array();

				$this->load->view('common/header',$this->data);
				$this->load->view('common/nav',$this->data);
				$this->load->view('conf/index',$this->data);
				$this->load->view('conf/conf_nav',$this->data);
				$this->load->view('conf/news',$this->data);
				$this->load->view('common/footer',$this->data);
			}else{
				$this->data['col_index'] = array("news");// 
				$this->data['col_sidebar_1'] = array("schedule");
				$this->data['col_sidebar_2'] = array();
				
				$this->load->view($template_dir.'header',$this->data);
				$this->load->view($template_dir."col-".$conf_col,$this->data);
				$this->load->view($template_dir.'footer',$this->data);
			}
		}else{
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
	}
	public function main($conf_id=""){
		if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
			if( !$this->user->is_login() ){
				redirect('/user/login', 'location', 301);
			}
			$this->data['conf_config']  = $this->conf->conf_config($this->conf_id,$this->is_conf);
			$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);
			$this->data['content']      = $this->conf->get_content($this->conf_id,"main",$this->_lang);
			$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);

			$this->assets->set_title($this->data['content']->page_title);
			$this->assets->set_title_separator(" | ");
			$this->assets->set_site_name($this->data['conf_config']['conf_name']);
			$this->assets->add_meta_tag("description", $this->data['conf_config']['conf_desc'], "name");
			$this->assets->add_meta_tag("keywords", $this->data['conf_config']['conf_keywords'], "name");
			$this->assets->add_css(asset_url().'style/statistic.min.css');
			
			if( $this->is_topic || $this->is_sysop ){
				$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
			}
			if( $this->is_reviewer || $this->is_sysop ){
				$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
			}
	
			$this->load->view('common/header',$this->data);
			$this->load->view('common/nav',$this->data);
			$this->load->view('conf/index',$this->data);
			$this->load->view('conf/conf_nav',$this->data);
			
			$this->load->view('conf/menu_submit',$this->data);
			if( $this->is_conf || $this->is_sysop ){
				$this->load->view('conf/menu_conf',$this->data);
			}
			if( $this->is_topic || $this->is_sysop ){
				$this->load->view('conf/menu_topic',$this->data);
			}
			if( $this->is_reviewer || $this->is_sysop ){
				$this->load->view('conf/menu_reviewer',$this->data);
			}
			
			$this->load->view('common/footer',$this->data);
		}else{
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		
	}
	public function about($conf_id="",$page_id=""){
		$this->data['conf_id'] = $this->conf_id;
		
		if( empty($conf_id) || empty($page_id) ){
			$this->data['confs'] = $this->conf->all_conf_config($this->user_sysop);
			$this->load->view('common/header');
			$this->load->view('common/nav',$this->data);
			$this->load->view('common/index',$this->data);
			$this->load->view('common/footer',$this->data);
		}else{
			$spage = $this->config->item('spage');
			$this->data['spage'] = $spage;
			if( in_array($page_id,$spage) ){
				redirect($this->conf_id."/".$page_id,'location',301);
			}
			if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
				$this->data['conf_config']  = $this->conf->conf_config($this->conf_id,$this->is_conf);
				$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);
				$this->data['content']      = $this->conf->get_content($this->conf_id,$page_id,$this->_lang);
				$this->data['conf_news']    = $this->conf->get_news($this->conf_id);
				$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);
				
				$this->assets->set_title($this->data['content']->page_title);
				$this->assets->set_title_separator(" | ");
				$this->assets->set_site_name($this->data['conf_config']['conf_name']);
				$this->assets->add_meta_tag("description", $this->data['conf_config']['conf_desc'], "name");
				$this->assets->add_meta_tag("keywords", $this->data['conf_config']['conf_keywords'], "name");
				$this->assets->add_css(asset_url().'style/statistic.min.css');

				$conf_col      = $this->data['conf_config']['conf_col'];
				$conf_template = $this->data['conf_config']['conf_template'];
				$template_dir  = "template/".$conf_template."/";

				if( $this->is_topic || $this->is_sysop ){
					$this->data['topic_pedding'] = $this->topic->count_pedding_paper($this->conf_id,$this->user_login);
				}
				if( $this->is_reviewer || $this->is_sysop ){
					$this->data['reviewer_pedding'] = $this->reviewer->count_review($this->conf_id,$this->user_login);
				}

				$path = APPPATH.'models/template/';
				$template_function = $path.ucfirst($conf_template."_model.php");
				if( file_exists($template_function) && is_file($template_function) ){
					$template_model = $conf_template."_model";
					$this->load->model('template/'.$template_model,"theme");
				}

				if( $conf_template == "default"){
					$this->data['col_index'] = array("index","news");
					$this->data['col_sidebar_1'] = array("schedule");
					$this->data['col_sidebar_2'] = array("");

					$this->load->view('common/header');
					$this->load->view('common/nav',$this->data);
					$this->load->view('conf/index');
					$this->load->view('conf/conf_nav',$this->data);

					if( $this->data['content']->page_show == 1 ){
						$this->load->view('conf/about',$this->data);
					}else{
						$this->cinfo['show_confinfo'] = false;
						$this->conf->show_404conf();
					}
					$this->load->view('common/footer',$this->data);
				}else{
					$this->load->view($template_dir.'header',$this->data);
					$this->load->view($template_dir.'about',$this->data);
					$this->load->view($template_dir.'footer',$this->data);
				}
			}else{
				$this->cinfo['show_confinfo'] = false;
				$this->conf->show_404conf();
			}
		}
	}

	public function change_lang($lang="zhtw"){
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

	public function rss($conf_id=""){
		if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
			$this->load->helper('xml');
			$this->output->set_content_type('application/rss+xml', 'UTF-8');
			$this->data['conf_config'] = $this->conf->conf_config($this->conf_id,$this->is_conf);
			$this->data['conf_news']   = $this->conf->get_news($this->conf_id);

			$this->load->view('common/rss',$this->data);
		}else{
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		
	}
	public function signup($conf_id=""){
		if( $this->conf->confid_exists($this->conf_id,$this->is_conf) ){
			$this->data['conf_config']  = $this->conf->conf_config($this->conf_id,$this->is_conf);
			$this->data['conf_content'] = $this->conf->conf_content($this->conf_id);
			$this->data['content']      = $this->conf->get_content($this->conf_id,"main",$this->_lang);
			$this->data['schedule']     = $this->conf->get_schedules($this->conf_id);

			$this->assets->set_title("研討會註冊");
			$this->assets->set_title_separator(" | ");
			$this->assets->set_site_name($this->data['conf_config']['conf_name']);
			$this->assets->add_meta_tag("description", $this->data['conf_config']['conf_desc'], "name");
			$this->assets->add_meta_tag("keywords", $this->data['conf_config']['conf_keywords'], "name");
			
			$this->data['prices'] = $this->signup->get_prices($this->conf_id);
			$prices     = $this->data['prices'];
			$early_bird = $this->conf->get_schedule($this->conf_id,"early_bird");
			$register   = $this->conf->get_schedule($this->conf_id,"register");
			$now        = time();
			$this->load->view('common/header',$this->data);
			$this->load->view('common/nav',$this->data);
			$this->load->view('conf/index',$this->data);
			$this->load->view('conf/conf_nav',$this->data);

			
			if( $this->signup->is_early_bird($register->start_value,$register->end_value,$now) ){ // check register date
				$this->data['early_bird'] = $early_bird;
				
				$this->data['is_early_bird'] = false;
				if( $this->signup->is_early_bird($early_bird->start_value,$early_bird->end_value,$now)){
					$this->data['is_early_bird'] = true;
				}
				
				$do = $this->input->post("do");
				switch($do){
					case "form":
						$reg_paper = $this->input->post("reg_paper");
						$this->signup->signup_valid($reg_paper,$prices);
						if ($this->form_validation->run()){
							$user_name       = $this->input->post("user_name");
							$user_gender     = $this->input->post("user_gender");
							$user_food       = $this->input->post("user_food");
							$user_org        = $this->input->post("user_org");
							$user_title      = $this->input->post("user_title");
							$user_phone      = $this->input->post("user_phone");
							$user_email      = $this->input->post("user_email");
							$receipt_header  = $this->input->post("receipt_header");
							$price_type      = $this->input->post("price_type");
							$user_pass       = $this->input->post("user_pass");
							$paper_id        = $this->input->post("paper_id");
							$paper_title     = $this->input->post("paper_title");
							$comment         = $this->input->post("comment");
							
							$signup_price = $this->signup->cal_signup_price($this->conf_id,$price_type);
							$price_type = explode("|",$price_type);

							$signup = array(
								"user_name"       => $user_name,
								"user_gender"     => $user_gender,
								"user_food"       => $user_food,
								"user_org"        => $user_org,
								"user_title"      => $user_title,
								"user_phone"      => $user_phone,
								"user_email"      => $user_email,
								"receipt_header"  => $receipt_header,
								"signup_type"     => $price_type[2],
								"price_id"        => $price_type[1],
								"price_type"      => $price_type[0],
								"paper_title"     => $paper_title,
								"paper_id"        => $paper_id,
								"user_pass"       => $user_pass,
								"user_note"       => $comment,
								"signup_price"    => $signup_price
							);
							if( $this->signup->add_signup($this->conf_id,$signup) ){
								$this->alert->show("s","研討會報名成功");
								$this->alert->js("研討會報名成功");
								$this->alert->refresh(2);
							}else{
								sp($signup);
								$this->alert->show("d","研討會報名失敗");
							}
						}
					break;
					case "login":
						$this->form_validation->set_rules("user_email", "E-Mail", 'required|valid_email');
						$this->form_validation->set_rules("user_pass", "密碼", 'required');
						if ($this->form_validation->run()){
							$user_email = $this->input->post("user_email");
							$user_pass  = $this->input->post("user_pass");
							if( $this->signup->login($this->conf_id,$user_email,$user_pass) ){
								$this->alert->show("s","登入成功");
							}else{
								$this->alert->show("d","登入失敗");
							}
							$this->alert->refresh(2);
						}
					break;
					case "upload":
						if( $this->signup->is_login($this->conf_id) ){
							$config['upload_path']= $this->conf->get_regdir($this->conf_id);
							$config['allowed_types']= 'jpg|png|bmp|pdf';
							$config['encrypt_name']= true;
							$this->load->library('upload', $config);
							if ( $this->upload->do_upload('file')){
								$signup_id = $this->input->post("signup_id");
								if( $this->signup->update_signup_file($this->conf_id,$signup_id,$this->upload->data("file_name")) ){
									$this->alert->show("s","上傳繳費紀錄成功");
								}else{
									$this->alert->show("d","上傳繳費紀錄失敗");
								}
							}
						}else{
							$this->alert->js("請先登入");
							$this->alert->refresh(2);
						}
					break;
				}
				if( $this->signup->is_login($this->conf_id) ){
					$this->data['lists'] = $this->signup->get_lists($this->conf_id);
				}
				$this->data['user'] = $this->user->get_user_info($this->user_login);
				
				$this->load->view('signup/index',$this->data);
			}else{
				$do = $this->input->post("do");
				switch($do){
					case "login":
						$this->form_validation->set_rules("user_email", "E-Mail", 'required|valid_email');
						$this->form_validation->set_rules("user_pass", "密碼", 'required');
						if ($this->form_validation->run()){
							$user_email = $this->input->post("user_email");
							$user_pass  = $this->input->post("user_pass");
							if( $this->signup->login($this->conf_id,$user_email,$user_pass) ){
								$this->alert->show("s","登入成功");
							}else{
								$this->alert->show("d","登入失敗");
							}
							$this->alert->refresh(2);
						}
					break;
				}

				if( $this->signup->is_login($this->conf_id) ){
					$this->data['lists'] = $this->signup->get_lists($this->conf_id);
				}
				$this->data['early_bird'] = $early_bird;
				$this->data['is_early_bird'] = false;
				if( $this->signup->is_early_bird($early_bird->start_value,$early_bird->end_value,$now)){
					$this->data['is_early_bird'] = true;
				}
				$this->load->view('signup/timeup',$this->data);
			}
			$this->load->view('common/footer',$this->data);
		}else{
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		
	}
	public function page404($conf_id=""){
		$this->data['conf_id'] = $this->conf_id;
		$this->cinfo['show_confinfo'] = false;
		if( $this->conf->confid_exists($this->conf_id,$this->user_sysop) ){
			redirect(get_url("index",$this->conf_id), 'location', 301);
		}else{
			$this->conf->show_404conf();
		}
	}
}
