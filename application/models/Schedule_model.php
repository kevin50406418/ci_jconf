<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Schedule_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function get_conf_schedule($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$query = $this->db->get();
        $schedule = $query->result();
    }

    function get_open_upload($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","ou");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_close_upload($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","cu");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_register($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","rg");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_reviewer_notice($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","rn");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_finish_upload($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","fu");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_early_payment($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","ep");
    	$row = $query->row();
    	return $row->date_value;
    }

    function get_meeting_date($conf_id){
    	$this->db->from("conf_date");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("date_type","md");
    	$row = $query->row();
    	return $row->date_value;
    }


}