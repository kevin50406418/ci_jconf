<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Conf_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function confid_exists( $conf_id , $staus=0){
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
		$this->output->set_status_header('404');
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('common/conf_404');
		$this->load->view('common/footer');
		$this->output->_display();
		exit();
	}

	function show_permission_deny($data){
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

	function get_topic($conf_id){
		$this->db->from('topic');
		$this->db->where('conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function update_confinfo($conf_id,$conf_name,$conf_master,$conf_email,$conf_phone,$conf_fax,$conf_address,$conf_desc){
		$paper = array(
            "name"   =>$conf_name,
            "master" =>$conf_master,
            "email" =>$conf_email,
            "phone"   =>$conf_phone,
            "fax"    =>$conf_fax,
            "address" =>$conf_address,
            "conf_desc"    =>$conf_desc
        );
        $this->db->where("id", $conf_id);
        if( $this->db->update('conf', $paper) ){
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
			write_file($this->get_paperdir($conf_id), $data);
		}else{
			$return = array(
				"status" => false,
				"error" => "Directory '".$this->get_paperdir($conf_id)."' exists."
			);
		}
		
		if( !file_exists ( $this->get_regdir($conf_id) ) ){
			mkdir($this->get_regdir($conf_id), 0755);
			write_file($this->get_regdir($conf_id), $data);
		}else{
			$return = array(
				"status" => false,
				"error" => "Directory '".$this->get_regdir($conf_id)."' exists."
			);
		}
		$return['status'] = true;
		return $return;
	}

	function lang(){
		if( !$this->session->has_userdata('lang') ){
			$languages = $this->agent->languages();
			switch($languages[0]){
				case "zh":
					$lang = "zhtw";
				break;
				case "en":
					$lang = "en";
				break;
			}
			$this->session->set_userdata('lang', $lang);
		}		
	}
}
