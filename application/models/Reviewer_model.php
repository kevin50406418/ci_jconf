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
		$this->db->where('sub_status', 3);
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

	function update_review($conf_id,$paper_id,$user_login,$review_comment,$review_score){
		$review = array(
			"review_time"    => time(),
			"review_status"  => 1,
			"review_comment" => $review_comment,
			"review_score"   => $review_score
		);
		$this->db->where('paper_id', $paper_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('review_confirm', 1);
		$this->db->where('review_status', 0);
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
		$this->db->where('review_status', 0);
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

	function add_review_responses($conf_id,$paper_id,$review_id,$element_value,$recommend_value){
		$form_response = array();
		$recommend_response = array();
		foreach ($element_value as $key => $value) {
			$tmp_response = array(
				"paper_id"         => $paper_id,
				"review_form_name" => $key,
				"review_id"        => $review_id,
				"element_value"    => $value,
				"conf_id"          => $conf_id
			);
			array_push($form_response,$tmp_response);
		}
		foreach ($recommend_value as $key => $value) {
			$tmp_response = array(
				"recommend_form_name" => $key,
				"paper_id"            => $paper_id,
				"review_id"           => $review_id,
				"response_value"      => $value,
				"conf_id"             => $conf_id
			);
			array_push($recommend_response,$tmp_response);
		}
		return ( $this->db->insert_batch("review_responses", $form_response) && $this->db->insert_batch("recommend_responses", $recommend_response) );
	}

	function review_status($status){
		$class = "";
		$status_str = "";
		switch($status){
			case 0:
				$class = "orange";
				$status_str = "尚未審查";
			break;
			case 1:
				$class = "green";
				$status_str = "審查完畢";
			break;
		}
		echo '<span class="ui label '.$class.'">'.$status_str.'</span>';
	}

	function review_wishes($status){
		$class = "";
		$status_str = "";
		switch($status){
			case -1:
				$class = "orange";
				$status_str = "確認中";
			break;
			case 0:
				$class = "orange";
				$status_str = "無意願";
			break;
			case 1:
				$class = "green";
				$status_str = "接受";
			break;
		}
		echo '<span class="ui label '.$class.'">'.$status_str.'</span>';
	}

	function get_reviewform($review_id,$paper_id,$conf_id){
		$this->db->from("review_forms");
		$this->db->join('review_responses', 'review_forms.review_form_name = review_responses.review_form_name');
		$this->db->where('review_id', $review_id);
		$this->db->where("paper_id",$paper_id);
		$this->db->where("review_responses.conf_id",$conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_recommendform($review_id,$paper_id,$conf_id){
		$this->db->from("recommend_forms");
		$this->db->join('recommend_responses', 'recommend_forms.recommend_form_name = recommend_responses.recommend_form_name');
		$this->db->where('review_id', $review_id);
		$this->db->where("paper_id",$paper_id);
		$this->db->where("recommend_responses.conf_id",$conf_id);
		$query = $this->db->get();
		return $query->result();
	}
}
?>