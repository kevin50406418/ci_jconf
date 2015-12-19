<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Reviewer_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function get_paper($conf_id,$user_login){
    	$this->db->from('paper_review');
    	$this->db->join('paper', 'paper.sub_id = paper_review.paper_id');
    	$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->where('user_login', $user_login);
		$this->db->where('paper.conf_id', $conf_id);
		//$this->db->where('sub_status', 3);
		$query = $this->db->get();
		return $query->result();
    }

    function get_reviewer($paper_id){
		$this->db->from('paper_review');
		$this->db->join('users','users.user_login = paper_review.user_login');
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function is_review($paper_id,$user_login){
		$this->db->from('paper_review');
		$this->db->where('user_login', $user_login);
		$this->db->where('review_confirm', 1);
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->row();
	}

	function update_review($conf_id,$paper_id,$user_login,$review_status,$review_comment){
		$review = array(
            "review_time"   =>time(),
            "review_status" =>$review_status,
            "review_comment" =>$review_comment
        );
        $this->db->where('paper_id', $paper_id);
        $this->db->where('user_login', $user_login);
        $this->db->where('review_confirm', 1);
        $this->db->where('review_status', 3);
        if( $this->db->update('paper_review', $review) ){
        	$this->conf->add_log("review","update_review",$conf_id,$review);
        	return true;
        }
        return false;
	}

	function count_review($conf_id,$user_login){
		$this->db->from('paper_review');
    	$this->db->join('paper', 'paper.sub_id = paper_review.paper_id');
    	$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->where('user_login', $user_login);
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->where('review_confirm', 1);
        $this->db->where('review_status', 3);
        $this->db->where('review_timeout >', time());
		$query = $this->db->get();
		return count($query->result());
	}

	function get_paper_reviewer($paper_id,$user_login){
		$this->db->from('paper_review');
		$this->db->where('paper_id', $paper_id);
		$this->db->where('user_login', $user_login);
		$query = $this->db->get();
		return $query->row();
	}

	function get_file($fid,$paper_id,$user_login){
    	$this->db->from("paper");
		$this->db->join('paper_review', 'paper.sub_id = paper_review.paper_id');
		$this->db->join('paper_file', 'paper.sub_id = paper_file.paper_id');
		$this->db->where('paper_review.user_login', $user_login);
		$this->db->where("paper.sub_id",$paper_id);
		$this->db->where("fid",$fid);
		$query = $this->db->get();
		return $query->row();
    }
}
?>