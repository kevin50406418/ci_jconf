<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Topic_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function get_paper($conf_id,$user_login,$topic_id=''){
    	$this->db->from('auth_topic');
		$this->db->join('topic', 'auth_topic.topic_id = topic.topic_id');
		$this->db->join('paper', 'paper.sub_topic = topic.topic_id');
		$this->db->where('user_login', $user_login);
		$this->db->where('auth_topic.conf_id', $conf_id);
		$this->db->where('sub_status !=', -1);
		if(!empty($topic_id)){
			$this->db->where('auth_topic.topic_id', $topic_id);
		}
		$query = $this->db->get();
		return $query->result();
    }

    function get_topic($conf_id,$user_login){
    	$this->db->from('auth_topic');
		$this->db->join('topic', 'auth_topic.topic_id = topic.topic_id');
		$this->db->where('user_login', $user_login);
		$this->db->where('auth_topic.conf_id', $conf_id);
		$query = $this->db->get();
		return $query->result();
    }

    function get_topic_paper($conf_id,$user_login){
    	$this->db->from('auth_topic');
		$this->db->join('topic', 'auth_topic.topic_id = topic.topic_id');
		$this->db->join('paper', 'paper.sub_topic = topic.topic_id');
		$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->where('paper_author.user_login', $user_login);
		$this->db->where('auth_topic.conf_id', $conf_id);
    }

    function get_paperinfo($paper_id, $conf_id){
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->where('paper.conf_id', $conf_id);
        $this->db->where("sub_id",$paper_id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_file($fid,$paper_id,$user_login){
    	$this->db->from("paper");
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->join('auth_topic', 'auth_topic.topic_id = topic.topic_id');
		$this->db->join('paper_file', 'paper.sub_id = paper_file.paper_id');
		$this->db->where('auth_topic.user_login', $user_login);
		$this->db->where("paper.sub_id",$paper_id);
		$this->db->where("fid",$fid);
		$query = $this->db->get();
		return $query->row();
    }

    function assign_reviewer_pedding($paper_id,$user_login){
		$reviewer = array(
			"paper_id"      => $paper_id,
			"user_login"   => $user_login
		);
		return $this->db->insert('paper_review_pedding', $reviewer);
	}

    function get_reviewer_pedding($conf_id,$paper_id){
		$staus = array(0, 2);
		
		$this->db->from('auth_reviewer');
		$this->db->join('users','users.user_login = auth_reviewer.user_login');
		$this->db->join('paper_review_pedding','paper_review_pedding.user_login = users.user_login');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('paper_id', $paper_id);
		$this->db->where_in('user_staus', $staus);
		$query = $this->db->get();
		return $query->result();
	}

	function del_reviewer_pedding($paper_id,$user_login){
		$this->db->where('user_login', $user_login);
		$this->db->where('paper_id', $paper_id);
		return $this->db->delete('paper_review_pedding');;
	}

	function assign_reviewer($paper_id,$user_login){
		$reviewer = array(
			"paper_id"      => $paper_id,
			"user_login"   => $user_login
		);
		return $this->db->insert('paper_review', $reviewer);
	}

	function get_reviewer($paper_id){
		$this->db->from('paper_review');
		$this->db->join('users','users.user_login = paper_review.user_login');
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function notice_reviewer($user_login,$user_email,$conf_name,$conf_id,$paper_name,$topic_name,$topic_name_eng,$topic_login){
		$site_name = $this->config->item('site_name');
    	$message = "審查者 ".$user_login." 您好,<br><br>目前尚有稿件尚未審查，請盡速審查稿件。<br><br>稿件名稱：".$paper_name."<br>稿件主題：".$topic_name."(".$topic_name_eng.")<br><br><a href=\"".get_url("reviewer",$conf_id,"index")."\">前往審查</a><br>* 若已審查該稿件，請忽略本通知<br><br>主編 ".$topic_login."@".$conf_name." - ".$site_name;
    	sp("TO:".$user_email."\n".$message);
    	
    	$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($user_email);
		$this->email->subject('[審查提醒]'.$conf_name.'稿件審查');
		$this->email->message($message);

		//return $this->email->send();
	}

	function count_reviewer($conf_id,$topic_id){
		$this->db->select('paper_id,count(*) as cnt');
		$this->db->from('paper_review');
		$this->db->join('paper','paper.sub_id = paper_review.paper_id');
		$this->db->where('conf_id', $conf_id);
		$this->db->where_in('sub_topic', $topic_id);
		$this->db->group_by("paper_id");
		$query = $this->db->get();
		return $query->result();
	}

	function count_had_review($conf_id,$topic_id){
		$this->db->select('paper_id,count(*) as cnt');
		$this->db->from('paper_review');
		$this->db->join('paper','paper.sub_id = paper_review.paper_id');
		$this->db->where('conf_id', $conf_id);
		$this->db->where_in('sub_topic', $topic_id);
		$this->db->where('review_time >', 0);
		$this->db->group_by("paper_id");
		$query = $this->db->get();
		return $query->result();
	}

	function topic_review($conf_id,$paper_id,$sub_status){
		$status = array(-2,2,4);
		if( in_array($sub_status,$status) ){
			$paper = array(
            	"sub_status"=> $sub_status
	        );
	        $this->db->where("conf_id",$conf_id);
	        $this->db->where("sub_id",$paper_id);
	        return $this->db->update('paper', $paper);
		}else{
			return false;
		}
	}
}