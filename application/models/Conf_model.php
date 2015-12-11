<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Conf_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function confid_exists( $conf_id , $staus=0){
    	// need fix error: when conf admin view, not only sysop
    	$this->db->select('*');
		$this->db->from('conf');
		$this->db->where('conf_id', $conf_id);
		if($staus==0){
			$this->db->where('conf_staus', 0);
		}
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}

    function conf_config($conf_id,$user_sysop=false){
    	if(!$user_sysop){
    		$user_sysop=0;
    	}else{
    		$user_sysop=1;
    	}
		if($this->conf->confid_exists( $conf_id , $user_sysop)){
			$this->db->from('conf');
			$this->db->where('conf_id', $conf_id);
			$query = $this->db->get();
			if ($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return "";
			}
		}
	}

	function update_status($conf_id,$conf_staus){
		if( $this->db->update('conf',array("conf_staus"=> $conf_staus),array("conf_id"=>$conf_id)) ){
			$this->add_log("conf","update_status",$conf_id,array("conf_staus"=> $conf_staus));
			return true;
		}
        return false;
	}

	function all_conf_config($sysop=false){
		$this->db->select('*');
		$this->db->from('conf');
		if(!$sysop){
			$this->db->where('conf_staus', 0);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function conf_schedule($conf_id){
		$this->db->select('*');
		$this->db->from('conf_schedule');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		$conf_schedule=$query->row_array();

		$schedule['conf']     =explode(",", $conf_schedule['time_conf']);
		$schedule['submit']   =explode(",", $conf_schedule['time_submit']);
		$schedule['invite']   =explode(",", $conf_schedule['time_invite']);
		$schedule['reviewer'] =explode(",", $conf_schedule['time_reviewer']);
		$schedule['finish']   =explode(",", $conf_schedule['time_finish']);
		$schedule['singup']   =explode(",", $conf_schedule['time_singup']);

		$schedule['conf']     =array_map("schedule_dates", $schedule['conf']);
		$schedule['submit']   =array_map("schedule_dates", $schedule['submit']);
		$schedule['invite']   =array_map("schedule_dates", $schedule['invite']);
		$schedule['reviewer'] =array_map("schedule_dates", $schedule['reviewer']);
		$schedule['finish']   =array_map("schedule_dates", $schedule['finish']);
		$schedule['singup']   =array_map("schedule_dates", $schedule['singup']);

		return $schedule;
	}

	function conf_content($conf_id){
		$this->db->select('page_id,page_title');
		$this->db->from('conf_content');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_show', 1);
		$this->db->where('page_lang', "zhtw");
		$this->db->order_by('page_order', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function show_404conf(){
		$data['body_class'] = "container";
		$this->output->set_status_header('404');
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		$this->load->view('common/conf_404');
		$this->load->view('common/footer');
		$this->output->_display();
		exit();
	}

	function show_permission_deny($data){
		$this->user->get_auth($this->user_login);
		$data['body_class'] = "container";
		$this->output->set_status_header('404');
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		//$this->alert->refresh(10);
		$this->load->view('common/permission_deny');
		$this->load->view('common/footer');
		$this->output->_display();
		exit();
	}
	
	function conf_hastopic($conf_id){
		$this->db->from('topic');
		$this->db->where('conf_id', $conf_id);
		return ( $this->db->count_all_results() > 0 );
	}

	function get_filter($conf_id){
		$this->db->from('filter');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_filter_count($conf_id){
		$this->db->from('filter');
		$this->db->where('conf_id', $conf_id);
		return $this->db->count_all_results();
	}

	function add_filter($conf_id,$filter_content,$filter_content_eng){
		$filter = array(
			"conf_id" => $conf_id,
			"filter_content" => $filter_content,
			"filter_content_eng" => $filter_content_eng
		);
		if( $this->db->insert('filter', $filter) ){
			$this->add_log("conf","add_filter",$conf_id,$filter);
			return true;
		}
		return false;
	}

	function update_filter($conf_id,$filter_id,$filter_content,$filter_content_eng){
		$filter = array(
			"filter_content" => $filter_content,
			"filter_content_eng" => $filter_content_eng
		);
        $this->db->where("filter_id", $filter_id);
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('filter', $filter) ){
        	$this->add_log("conf","update_filter",$conf_id,$filter);
        	return true;
        }
        return false;
	}

	function del_filter($conf_id,$filter_id){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('filter_id', $filter_id);
		if( $this->db->delete('filter') ){
			$this->add_log("conf","del_filter",$conf_id,array("filter_id"=>$filter_id));
			return true;
		}
		return false;
	}
	
	function get_filter_info($conf_id,$filter_id){
		$this->db->from('filter');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('filter_id', $filter_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_news($conf_id){
		$this->db->from('news');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function add_news($conf_id,$news_title,$news_content,$news_title_eng,$news_content_eng){
		$news = array(
			"conf_id" => $conf_id,
			"news_title" => $news_title,
			"news_content" => $news_content,
			"news_title_eng" => $news_title_eng,
			"news_content_eng" => $news_content_eng,
			"news_posted"=>time(),
			"news_poster"=>$this->session->user_login
		);
		if( $this->db->insert('news', $news) ){
			$this->add_log("conf","add_news",$conf_id,$news);
			return true;
        }
        return false;
	}

	function get_news_info($conf_id,$news_id){
		$this->db->from('news');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('news_id', $news_id);
		$query = $this->db->get();
		return $query->row();
	}

	function update_news($conf_id,$news_id,$news_title,$news_content,$news_title_eng,$news_content_eng){
		$news = array(
			"conf_id" => $conf_id,
			"news_title" => $news_title,
			"news_content" => $news_content,
			"news_title_eng" => $news_title_eng,
			"news_content_eng" => $news_content_eng,
			"news_posted"=>time(),
		);
        $this->db->where("news_id", $news_id);
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('news', $news) ){
        	$this->add_log("conf","update_news",$conf_id,$news);
        	return true;
        }
        return false;
	}
	
	function del_news($conf_id,$news_id){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('news_id', $news_id);
		if( $this->db->delete('news') ){
			$this->add_log("conf","del_news",$conf_id,array("news_id"=>$news_id));
			return true;
		}
		return false;
	}

	function update_confinfo($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_fax,$conf_address,$conf_host,$conf_place,$conf_keywords="",$conf_desc=''){
		$conf = array(
			"conf_name"    =>$conf_name,
			"conf_master"  =>$conf_master,
			"conf_email"   =>$conf_email,
			"conf_phone"   =>$conf_phone,
			"conf_fax"     =>$conf_fax,
			"conf_address" =>$conf_address,
			"conf_host"    =>$conf_host,
			"conf_place"   =>$conf_place,
			"conf_keywords"=>$conf_keywords,
			"conf_desc"    =>$conf_desc
        );
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('conf', $conf) ){
        	$this->add_log("conf","update_confinfo",$conf_id,$conf);
        	return true;
        }
        return false;
	}

	function sysop_updateconf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$conf_lang,$conf_host,$conf_place,$conf_fax,$conf_keywords="",$conf_desc=''){
		$conf_lang = implode(",",$conf_lang);
		$conf = array(
			"conf_name"    =>$conf_name,
			"conf_master"  =>$conf_master,
			"conf_email"   =>$conf_email,
			"conf_phone"   =>$conf_phone,
			"conf_fax"     =>$conf_fax,
			"conf_address" =>$conf_address,
			"conf_host"    =>$conf_host,
			"conf_place"   =>$conf_place,
			"conf_lang"    =>$conf_lang,
			"conf_staus"   =>$conf_staus,
			"conf_keywords"=>$conf_keywords,
			"conf_desc"    =>$conf_desc
        );
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('conf', $conf) ){
        	$this->add_log("conf","sysop_updateconf",$conf_id,$conf);
        	return true;
        }
        return false;
	}

	function update_confstyle($conf_id,$conf_template){
		$conf = array(
			"conf_template" => $conf_template
		);
		if( $this->db->update('conf', $conf) ){
			$this->add_log("conf","update_confstyle",$conf_id,$conf);
		 	return true;
		}
		return false;
	}

	function get_paperdir($conf_id){
		return './upload/paper/'.$conf_id.'/';
	}

	function get_regdir($conf_id){
		return './upload/registration/'.$conf_id.'/';
	}

	function get_mostdir($conf_id){
		return './upload/most/'.$conf_id.'/';
	}

	function mkconf_dir($conf_id){
		$return = array(
			"status" => false,
			"error" => ""
		);
		$data = "<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";

		if( !file_exists ( $this->get_paperdir($conf_id) ) ){
			mkdir($this->get_paperdir($conf_id), 0755);
			write_file($this->get_paperdir($conf_id)."index.html", $data);
		}else{
			$return = array(
				"status" => false,
				"error" => "Directory '".$this->get_paperdir($conf_id)."' exists."
			);
		}
		
		if( !file_exists ( $this->get_regdir($conf_id) ) ){
			mkdir($this->get_regdir($conf_id), 0755);
			write_file($this->get_regdir($conf_id)."index.html", $data);
		}else{
			$return = array(
				"status" => false,
				"error" => "Directory '".$this->get_regdir($conf_id)."' exists."
			);
		}

		if( !file_exists ( $this->get_mostdir($conf_id) ) ){
			mkdir($this->get_mostdir($conf_id), 0755);
			write_file($this->get_mostdir($conf_id)."index.html", $data);
		}else{
			$return = array(
				"status" => false,
				"error" => "Directory '".$this->get_mostdir($conf_id)."' exists."
			);
		}
		$return['status'] = true;
		return $return;
	}

	function add_conf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$conf_lang,$conf_host,$conf_place,$conf_fax="",$conf_keywords="",$conf_desc=""){
		$return = array(
			"status" => false,
			"error" => ""
		);
		$conf_lang = implode(",",$conf_lang);
		if( $this->confid_exists( $conf_id , 1) ){
			$return["error"] = "研討會ID: '".$conf_id."' 已存在";
		}else{
			$mkdir = $this->mkconf_dir($conf_id);
			if(!$mkdir['status']){
				$return["error"] = $mkdir['error'];
			}else{
				$conf = array(
					"conf_id"      => $conf_id,
					"conf_name"    => $conf_name,
					"conf_master"  => $conf_master,
					"conf_email"   => $conf_email,
					"conf_phone"   => $conf_phone,
					"conf_address" => $conf_address,
					"conf_host"    => $conf_host,
					"conf_place"   => $conf_place,
					"conf_staus"   => $conf_staus,
					"conf_lang"    => $conf_lang,
					"conf_fax"     => $conf_fax,
					"conf_desc"    => $conf_desc
				);
				if( $this->db->insert('conf', $conf) ){
					$return = array(
						"status" => true,
						"error" => "Success Add New Conference"
					);
		        }else{
		           $return = array(
						"status" => false,
						"error" => "Database error! Contact System Adminstritor."
					);
		        }
		        
				if( $this->init_conf_date($conf_id) ){
					$return = array(
						"status" => true,
						"error" => "Success Add Conference Schedule"
					);
		        }else{
		           $return = array(
						"status" => false,
						"error" => "Database error! Contact System Adminstritor.(Schedule)"
					);
		        }

		        
				if( $this->init_conf_content($conf_id) ){
					$return = array(
						"status" => true,
						"error" => "Success Add Conference Website Content"
					);
		        }else{
		           $return = array(
						"status" => false,
						"error" => "Database error! Contact System Adminstritor.(Website Content)"
					);
		        }
		        if( $this->add_all_template($conf_id) ){
		        	$return = array(
						"status" => true,
						"error" => "Success Add Conference Mail Template"
					);
		        }else{
		        	$return = array(
						"status" => false,
						"error" => "Database error! Contact System Adminstritor.(Mail Template)"
					);
		        }
			}
		}

		return $return;
	}

	function init_conf_date($conf_id){
		$now = time();
        $date = array(
	        array('conf_id' => $conf_id,'date_type' => 'hold','start_value' => $now,'end_value' => $now),
	        array('conf_id' => $conf_id,'date_type' => 'submit','start_value' => $now,'end_value' => $now),
	        array('conf_id' => $conf_id,'date_type' => 'early_bird','start_value' => $now,'end_value' => $now),
	        array('conf_id' => $conf_id,'date_type' => 'register','start_value' => $now,'end_value' => $now),
	        array('conf_id' => $conf_id,'date_type' => 'finish','start_value' => $now,'end_value' => $now),
	        array('conf_id' => $conf_id,'date_type' => 'most','start_value' => $now,'end_value' => $now)
		);
		return $this->db->insert_batch('conf_date',$date);
	}

	function init_conf_content($conf_id){
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
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
				'page_lang'   => "en",
				'page_show'   => 0,
				"page_order"  => 6,
				"page_edit"   => 1,
				"page_hidden" => 1,
				"page_del"    => 1
	        ),
	    );
		return $this->db->insert_batch('conf_content',$conf_content);
	}

	public function change_dir($new_id,$old_id){
		$return = array(
			"status" => false,
			"error" => ""
		);
		$new_paperdir = $this->get_paperdir($new_id);
		$old_paperdir = $this->get_paperdir($old_id);
		if( file_exists($new_paperdir) ){
			$return["status"] = false;
			$return["error"] = "Directory: '".$old_id."' is exists";
		}else{
			if( rename($old_paperdir, $new_paperdir) ){
				$return["status"] = true;
			}else{
				$return["status"] = false;
				$return["error"] = "change paper directory error.";
			}
		}
		$new_regdir = $this->get_regdir($new_id);
		$old_regdir = $this->get_regdir($old_id);
		if( file_exists($new_regdir) ){
			$return["status"] = false;
			$return["error"] = "Directory: '".$old_id."' is exists";
		}else{
			if( rename($old_paperdir, $new_paperdir) ){
				$return["status"] = true;
			}else{
				$return["status"] = false;
				$return["error"] = "change registration directory error.";
			}
		}
		return $return;
	}

	function get_topic($conf_id){
		$this->db->from('topic');
		$this->db->where('conf_id', $conf_id);
		$this->db->order_by('topic_order', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_topic_info($conf_id,$topic_id){
		$this->db->select('*');
		$this->db->from('topic');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('topic_id', $topic_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function add_topic($conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng){
		$topic = array(
			"topic_id"       =>$conf_id."_".$topic_abbr,
			"conf_id"        =>$conf_id,
			"topic_name"     =>$topic_name,
			"topic_abbr"     =>$topic_abbr,
			"topic_info"     =>$topic_info,
			"topic_name_eng" =>$topic_name_eng
		);
		if( $this->db->insert('topic', $topic) ){
			$this->add_log("conf","add_topic",$conf_id,$topic);
			return true;
		}
		return false;
	}

	function del_topic($conf_id,$topic_id){
		$count_paper = $this->topic->count_paper($conf_id,$topic_id);
		if( $count_paper->cnt > 0){
			return 2;
		}
		$this->db->where('topic_id', $topic_id);
		$this->db->where('conf_id', $conf_id);
		if( $this->db->delete('topic') ){
			$this->add_log("conf","del_topic",$conf_id,array("topic_id"=>$topic_id));
			return true;
		}
		return false;
	}

	function update_topic($topic_id,$conf_id,$topic_name,$topic_abbr,$topic_info,$topic_name_eng){
		$topic = array(
			"conf_id"        => $conf_id,
			"topic_name"     => $topic_name,
			"topic_abbr"     => $topic_abbr,
			"topic_info"     => $topic_info,
			"topic_name_eng" => $topic_name_eng
		);
		$this->db->where('topic_id', $topic_id);
		if( $this->db->update('topic', $topic) ){
			$this->add_log("conf","update_topic",$conf_id,array("topic_id"=>$topic_id));
			return true;
		}
		return false;
	}

	function add_assign_topic($topic_id,$conf_id,$user_login){
		$auth_topic = array(
			"conf_id"     => $conf_id,
			"user_login"  => $user_login,
			"topic_id"    => $topic_id,
			"topic_level" => 0,
			"auth_time"   => time()
		);
		if( $this->db->insert('auth_topic', $auth_topic) ){
			$this->add_log("conf","add_assign_topic",$conf_id,$auth_topic);
			return true;
		}
		return false;
	}

	function del_assign_topic($topic_id,$conf_id,$user_login){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('topic_id', $topic_id);
		if( $this->db->delete('auth_topic') ){
			$this->add_log("conf","del_assign_topic",$conf_id,array("user_login"=>$user_login,"topic_id"=>$topic_id));
			return true;
		}
		return false;
	}

	function get_editor($topic_id,$conf_id){
		$this->db->from('auth_topic');
		$this->db->join('users','auth_topic.user_login = users.user_login');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('topic_id', $topic_id);
		$query = $this->db->get();
		return $query->result();
	}

	function count_editor($conf_id){
		$this->db->select('topic_id,count(*) as cnt');
		$this->db->from('auth_topic');
		$this->db->where('conf_id', $conf_id);
		$this->db->group_by('topic_id');
		$query = $this->db->get();
		$count=$query->result();
		$count_editor = array();
		foreach ($count as $key => $v) {
			$count_editor[$v->topic_id]=$v->cnt;
		}
		return $count_editor;
	}

	function get_contents($conf_id,$page_lang){
		$this->db->from('conf_content');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_lang', $page_lang);
		$this->db->order_by("page_show","DESC");
		$this->db->order_by("page_order","ASC");
		$query = $this->db->get();
		return $query->result();
	}

	function get_content($conf_id,$page_id,$page_lang){
		$this->db->from('conf_content');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_lang', $page_lang);
		$this->db->where('page_id', $page_id);
		$query = $this->db->get();
		return $query->row();
	}

	function add_content($conf_id,$page_id,$page_title,$page_content,$page_lang){
		if( !in_array($page_lang,array("zhtw","en")) ){
			return false;
		}
		$page_id = str_replace(" ","_",strtolower($page_id));
		$content = array(
			"conf_id"      => $conf_id,
			"page_id"      => $page_id,
			"page_title"   => $page_title,
			"page_content" => $page_content,
			"page_lang"    => $page_lang,
			"page_order"   => 99,
			"page_show"    => 0
		);
		if( $this->db->insert('conf_content', $content) ){
			$this->add_log("conf","add_content",$conf_id,$content);
			return true;
		}
		return false;
	}

	function update_contents($conf_id,$page_id,$page_lang,$page_order,$page_show){
		$contents = array(
			"page_order" => $page_order,
			"page_show"  => $page_show
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_id', $page_id);
		$this->db->where('page_lang', $page_lang);
		if( $this->db->update('conf_content', $contents) ){
			$this->add_log("conf","update_contents",$conf_id,$contents);
			return true;
		}
		return false;
	}

	function update_content($conf_id,$page_id,$page_lang,$page_title,$page_content){
		$content = array(
			"page_title" => $page_title,
			"page_content"  => $page_content
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_id', $page_id);
		$this->db->where('page_lang', $page_lang);
		$this->db->where('page_edit', 1);
		if( $this->db->update('conf_content', $content) ){
			$this->add_log("conf","update_content",$conf_id,$content);
			return true;
		}
		return false;
	}

	function del_contents($conf_id,$page_id){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('page_id', $page_id);
		$this->db->where('page_del', 1);
		
		if( $this->db->delete('conf_content') ){
			$this->add_log("conf","del_contents",$conf_id,array("page_id"=>$page_id));
			return true;
		}
		return false;
	}

	function get_reviewer($conf_id){
		$staus = array(0, 2);
		
		$this->db->from('auth_reviewer');
		$this->db->join('users','users.user_login = auth_reviewer.user_login');
		$this->db->where('conf_id', $conf_id);
		$this->db->where_in('user_staus', $staus);
		$query = $this->db->get();
		return $query->result();
	}

	function update_confcol($conf_id,$conf_col){
		$conf_col = array(
			"conf_col" => $conf_col
		);
		$this->db->where('conf_id', $conf_id);
		if( $this->db->update('conf', $conf_col) ){
			$this->add_log("conf","update_confcol",$conf_id,$conf_col);
			return true;
		}
		return false;
	}

	function update_confmost($conf_id,$conf_most){
		$conf_col = array(
			"conf_most" => $conf_most
		);
		$this->db->where('conf_id', $conf_id);
		if( $this->db->update('conf', $conf_col) ){
			$this->add_log("conf","update_confmost",$conf_id,$conf_col);
			return true;
		}
		return false;
	}

	function get_modules($conf_id,$module_lang){
		$this->db->from('module');
		$this->db->where('module_lang', $module_lang);
		$this->db->where('conf_id', $conf_id);
		$this->db->order_by("module_position","DESC");
		$this->db->order_by("module_order","DESC");
		$query = $this->db->get();
		return $query->result();
	}

	function get_module($conf_id,$module_id){
		$this->db->from('module');
		$this->db->where('module_id', $module_id);
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->row();
	}

	function update_schedule($conf_id,$date_type,$start_value,$end_value){
		$schedule = array(
			"start_value" => $start_value,
			"end_value" => $end_value
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('date_type', $date_type);
		
		if( $this->db->update('conf_date', $schedule) ){
			$this->add_log("conf","update_schedule",$conf_id,$schedule);
			return true;
		}
		return false;
	}

	function get_schedules($conf_id){
		$this->db->from('conf_date');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		$dates = $query->result();
		$schedule =array();
		foreach ($dates as $key => $date) {
			$schedule[$date->date_type] = array();
			$schedule[$date->date_type]['start'] = date("Y-m-d",$date->start_value);
			$schedule[$date->date_type]['end'] = date("Y-m-d",$date->end_value);
		}
		return $schedule;
	}

	function get_schedule($conf_id,$date_type){
		$this->db->from('conf_date');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('date_type', $date_type);
		$query = $this->db->get();
		return $query->row();
	}

	function get_mosts($conf_id){
        $this->db->from('most');
        $this->db->where('conf_id', $conf_id);
        $query = $this->db->get();
        return $query->result();
    }

    function most_review($conf_id,$most_id,$most_status){
    	$most  = array(
            "most_status" => $most_status
        );
        $this->db->where('conf_id', $conf_id);
        $this->db->where('most_id', $most_id);
        if( $this->db->update('most', $most) ){
			$this->add_log("conf","most_review",$conf_id,array("most_status" => $most_status,"most_id" => $most_id));
        	return true;
        }
        return false;
    }

    function get_most($conf_id,$most_id){
        $this->db->from('most');
        $this->db->where('conf_id', $conf_id);
        $this->db->where('most_id', $most_id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_most($conf_id,$most_id,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept){
        $most  = array(
            "most_method"   => $most_method,
            "most_number"   => $most_number,
            "most_name"     => $most_name,
            "most_name_eng" => $most_name_eng,
            "most_host"     => $most_host,
            "most_uni"      => $most_uni,
            "most_dept"     => $most_dept
        );
        $this->db->where('most_id', $most_id);
        $this->db->where('conf_id', $conf_id);
        if( $this->db->update('most', $most) ){
        	$this->add_log("conf","update_most",$conf_id,$most);
        	return true;
        }
        return false;
    }

    function module_form_valid($module_type){
    	$this->form_validation->set_rules('module_title', '標題', 'required');
		$this->form_validation->set_rules('module_position', '位置', 'required');
		$this->form_validation->set_rules('module_showtitle', '顯示/隱藏標題', 'required');
		$this->form_validation->set_rules('module_lang', '語言', 'required');
    	switch ($module_type) {
    		case "news":	
    		break;
    		case "text":
				$this->form_validation->set_rules('module_content', '內容', 'required');
    		break;
    	}
    }

    function get_paper($conf_id,$paper_id){
    	$this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        //$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where("sub_id",$paper_id);
        $this->db->where("paper.conf_id",$conf_id);
        $query = $this->db->get();
        return $query->row();
    }

    function add_register_meal($conf_id,$meal_name){
		$conf_meal = array(
			"conf_id"      => $conf_id,
			"meal_name"    => $meal_name
		);
		if( $this->db->insert('conf_meal', $conf_meal) ){
			$this->add_log("conf","add_register_meal",$conf_id,$conf_meal);
			return true;
		}
		return false;
	}

	function get_register_meals($conf_id){
		$this->db->from('conf_meal');
		$this->db->where("conf_id",$conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_register_meal($conf_id,$meal_id){
		$this->db->from('conf_meal');
		$this->db->where("conf_id",$conf_id);
		$this->db->where("meal_id",$meal_id);
		$query = $this->db->get();
		return $query->row();
	}

	function update_register_meal($conf_id,$meal_id,$meal_name){
		$conf_meal = array(
			"meal_name"    => $meal_name
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("meal_id",$meal_id);
		if( $this->db->update('conf_meal', $conf_meal) ){
			$this->add_log("conf","update_register_meal",$conf_id,$conf_meal);
			return true;
		}
		return false;
	}

	function del_register_meal($conf_id,$meal_id){
		$this->db->where("conf_id",$conf_id);
		$this->db->where("meal_id",$meal_id);
		if( $this->db->delete('conf_meal') ){
			$this->add_log("conf","del_register_meal",$conf_id,array("meal_id"=>$meal_id));
			return true;
		}
		return false;
	}

	function sort_topic($conf_id,$topic_array){
		if(!is_array($topic_array)) return false;
		foreach ($topic_array as $key => $topic_id) {
			$this->update_sort_topic($conf_id,$topic_id,$key);
		}
		return true;
	}

	function update_sort_topic($conf_id,$topic_id,$topic_order){
		$topic_order = array(
			"topic_order"    => $topic_order
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("topic_id",$topic_id);
		if( $this->db->update('topic', $topic_order) ){
			$this->add_log("conf","update_sort_topic",$conf_id,array("topic_id"=>$topic_id,"topic_order"=>$topic_order));
			return true;
		}else{
			return false;
		}
	}

	function add_log($log_type,$log_act,$log_conf,$log_to){
		$login_user = $this->session->userdata('user_login');

		$conf_log = array(
			"login_user" => $login_user,
			"log_type"   => $log_type,
			"log_act"    => $log_act,
			"log_time"   => time(),
			"log_ip"     => $this->input->ip_address(),
			"log_conf"   => $log_conf,
			"log_to"     => json_encode($log_to,JSON_UNESCAPED_UNICODE)
		);
		$this->db->insert('conf_log', $conf_log);
	}

	function get_logs($conf_id){
		$this->db->from('conf_log');
		$this->db->where("log_conf",$conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function add_mail_template($email_key,$conf_id,$subject_zhtw,$body_zhtw,$subject_eng,$body_eng){
		$template = array(
			"email_key"          => $email_key,
			"conf_id"            => $conf_id,
			"email_subject_zhtw" => $subject_zhtw,
			"email_body_zhtw"    => $body_zhtw,
			"email_subject_eng"  => $subject_eng,
			"email_body_eng"     => $body_eng
		);
		$this->db->insert('email_templates', $template);
	}

	function add_all_template($conf_id){
		$tmp = array();
		
		$templates = $this->sysop->get_all_mail_templates();
		
		foreach ($templates as $key => $template) {
			$tmp[$template->email_key][$template->email_lang]['default_subject'] = $template->default_subject;
			$tmp[$template->email_key][$template->email_lang]['default_body'] = $template->default_body;
		}
		foreach ($tmp as $key => $v) {
			$email_key = $key;
			$subject_zhtw = $v["zhtw"]['default_subject'];
			$body_zhtw    = $v["zhtw"]['default_body'];
			$subject_eng  = $v["eng"]['default_subject'];
			$body_eng     = $v["eng"]['default_body'];
			$this->conf->add_mail_template($email_key,$conf_id,$subject_zhtw,$body_zhtw,$subject_eng,$body_eng);
		}
	}

	function get_mail_templates($conf_id){
		$this->db->select('email_key,email_subject_zhtw,email_subject_eng');
		$this->db->from('email_templates');
    	$this->db->where('conf_id', $conf_id);
    	$query = $this->db->get();
		return $query->result();
	}

	function get_mail_template($conf_id,$email_key,$email_lang){
		switch($email_lang){
			default:
			case "zhtw":
			case "zh-tw":
			case "tw":
			case "zh":
				$email_lang = "zhtw";
			break;
			case "en-us":
			case "en":
				$email_lang = "eng";
			break;
		}
		$this->db->from('email_templates');
		$this->db->join('email_about',"email_about.email_key = email_templates.email_key");
    	$this->db->where('conf_id', $conf_id);
    	$this->db->where('email_templates.email_key', $email_key);
    	$this->db->where('email_about.email_lang', $email_lang);
    	$query = $this->db->get();
		return $query->row();
	}

	function update_mail_template($email_key,$conf_id,$email_subject_zhtw,$email_body_zhtw,$email_subject_eng,$email_body_eng){
    	$template = array(
    		"email_subject_zhtw" => $email_subject_zhtw,
    		"email_body_zhtw" => $email_body_zhtw,
    		"email_subject_eng" => $email_subject_eng,
    		"email_body_eng" => $email_body_eng
    	);
    	$this->db->where("email_key",$email_key);
        $this->db->where("conf_id",$conf_id);
		if( $this->db->update("email_templates", $template) ){
			array_push($template,array("email_key"=>$email_key));
			$this->add_log("conf","update_mail_template",$conf_id,$template);
			return true;
		}else{
			return false;
		}
    }

	function mail_get_template($conf_id,$email_key){
		$this->db->from('email_templates');
    	$this->db->where('conf_id', $conf_id);
    	$this->db->where('email_key', $email_key);
    	$query = $this->db->get();
		return $query->row();
	}

	function dw_paper($conf_id){
		// $this->load->library('zip');
	}

	function get_style(){
		$this->db->from('style');
    	$query = $this->db->get();
		return $query->result();
	}
}
