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
		//echo '<pre>';
		//print_r($query->result());
		//echo '</pre>';
		//echo $query->num_rows();
		if ($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

    function conf_config($conf_id){
		$user_sysop=$this->session->has_userdata('user_sysop')?0:1;
		if($this->conf->confid_exists( $conf_id , $user_sysop)){
			$this->db->select('*');
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

	function all_conf_config(){
		$this->db->select('*');
		$this->db->from('conf');
		$this->db->where('conf_staus', 0);
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
		$data['body_class'] = "container";
		$this->output->set_status_header('404');
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		$this->load->view('common/permission_deny');
		$this->load->view('common/footer');
		$this->output->_display();
		exit();
	}

	function conf_hastopic($conf_id){
		$this->db->from('topic');
		$this->db->where('conf_id', $conf_id);
		if( $this->db->count_all_results() >0 ){
			return TRUE;
		}else{
			return FALSE;
		}
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
		return $this->db->insert('filter', $filter);
	}

	function update_filter($conf_id,$filter_id,$filter_content,$filter_content_eng){
		$filter = array(
			"filter_content" => $filter_content,
			"filter_content_eng" => $filter_content_eng
		);
        $this->db->where("filter_id", $filter_id);
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('filter', $filter) ){
            return true;
        }else{
            return false;
        }
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
		return $this->db->insert('news', $news);
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
            return true;
        }else{
            return false;
        }
	}
	
	function update_confinfo($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_fax,$conf_address,$conf_desc){
		$conf = array(
			"conf_name"    =>$conf_name,
			"conf_master"  =>$conf_master,
			"conf_email"   =>$conf_email,
			"conf_phone"   =>$conf_phone,
			"conf_fax"     =>$conf_fax,
			"conf_address" =>$conf_address,
			"conf_desc"    =>$conf_desc
        );
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('conf', $conf) ){
            return true;
        }else{
            return false;
        }
	}

	function sysop_updateconf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$default_lang,$conf_fax,$conf_desc){
		$conf = array(
			"conf_name"    =>$conf_name,
			"conf_master"  =>$conf_master,
			"conf_email"   =>$conf_email,
			"conf_phone"   =>$conf_phone,
			"conf_fax"     =>$conf_fax,
			"conf_address" =>$conf_address,
			"default_lang" =>$default_lang,
			"conf_staus"   =>$conf_staus,
			"conf_desc"    =>$conf_desc
        );
        $this->db->where("conf_id", $conf_id);
        if( $this->db->update('conf', $conf) ){
        	sp($conf_desc);
            return true;
        }else{
            return false;
        }
	}
	function get_paperdir($conf_id){
		return './upload/paper/'.$conf_id.'/';
	}

	function get_regdir($conf_id){
		return './upload/registration/'.$conf_id.'/';
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
		$return['status'] = true;
		return $return;
	}

	function add_conf($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_address,$conf_staus,$default_lang,$conf_fax="",$conf_desc=""){
		$return = array(
			"status" => false,
			"error" => ""
		);
		if( $this->confid_exists( $conf_id , 1) ){
			$return["error"] = "研討會ID: '".$conf_id."' 已存在";
		}else{
			$mkdir = $this->mkconf_dir($conf_id);
			if(!$mkdir['status']){
				$return["error"] = $mkdir['error'];
			}else{
				$conf = array(
					"conf_id" => $conf_id,
					"conf_name" => $conf_name,
					"conf_master" => $conf_master,
					"conf_email" => $conf_email,
					"conf_phone" => $conf_phone,
					"conf_address" => $conf_address,
					"conf_staus" => $conf_staus,
					"default_lang" => $default_lang,
					"conf_fax" => $conf_fax,
					"conf_desc" => $conf_desc
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
			}
		}
		return $return;
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
		return $this->db->insert('topic', $topic);
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
		return $this->db->update('topic', $topic);
	}

	function add_assign_topic($topic_id,$conf_id,$user_login){
		$auth_topic = array(
			"conf_id"     => $conf_id,
			"user_login"  => $user_login,
			"topic_id"    => $topic_id,
			"topic_level" => 0,
			"auth_time"   => time()
		);
		return $this->db->insert('auth_topic', $auth_topic);
	}

	function del_assign_topic($topic_id,$conf_id,$user_login){
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('topic_id', $topic_id);
		return $this->db->delete('auth_topic');;
	}

	function get_editor($topic_id,$conf_id){
		$this->db->from('auth_topic');
		$this->db->join('users','auth_topic.user_login = users.user_login');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('topic_id', $topic_id);
		$query = $this->db->get();
		return $query->result();
	}
}
