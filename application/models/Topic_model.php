<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Topic_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function get_paper($conf_id,$user_login,$topic_id=null,$sub_status=null){
    	$this->db->from('auth_topic');
		$this->db->join('topic', 'auth_topic.topic_id = topic.topic_id');
		$this->db->join('paper', 'paper.sub_topic = topic.topic_id');
		$this->db->where('user_login', $user_login);
		$this->db->where('auth_topic.conf_id', $conf_id);
		if( is_null($sub_status) ){
			$filter = array(-1, -3);
			$this->db->where_not_in('sub_status', $filter);
		}else{
			$this->db->where('sub_status', $sub_status);
		}
		
		if( !is_null($topic_id) ){
			$this->db->where('auth_topic.topic_id', $topic_id);
		}
		$this->db->order_by('sub_id', 'ASC');
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
    	$filter = array(-1, -3);
    	
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->where('paper.conf_id', $conf_id);
        $this->db->where("sub_id",$paper_id);
		$this->db->where_not_in('sub_status', $filter);
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
		// $this->db->where("topic.topic_id",$topic_id);
		$this->db->where("fid",$fid);
		$query = $this->db->get();
		return $query->row();
    }

    function del_pedding_reviewer($paper_id,$conf_id){
    	$this->db->where('paper_id', $paper_id);
		return $this->db->delete('paper_review_pedding');
    }
    
    function assign_reviewer_pedding($paper_id,$user_login,$conf_id,$review_timeout){
		$reviewer = array(
			"paper_id"       => $paper_id,
			"user_login"     => $user_login,
			"conf_id"        => $conf_id,
			"review_timeout" => $review_timeout
		);
		if( $this->db->insert('paper_review_pedding', $reviewer) ){
			$this->conf->add_log("topic","assign_reviewer_pedding",$conf_id,$reviewer);
			return true;
		}else{
			return false;
		}
	}

	function update_reviewer_pedding_timeout($paper_id,$user_login,$conf_id,$review_timeout){
		$reviewer = array(
			"review_timeout" => $review_timeout
		);
		$this->db->where("paper_id",$paper_id);
		$this->db->where("user_login",$user_login);
		$this->db->where("conf_id",$conf_id);
		if( $this->db->update('paper_review_pedding', $reviewer) ){
			$this->conf->add_log("topic","update_pedding_timeout",$conf_id,$reviewer);
			return true;
		}else{
			return false;
		}
	}

    function get_reviewer_pedding($conf_id,$paper_id){
		$staus = array(0, 2);
		
		$this->db->from('auth_reviewer');
		$this->db->join('users','users.user_login = auth_reviewer.user_login');
		$this->db->join('paper_review_pedding','paper_review_pedding.user_login = users.user_login');
		$this->db->where('auth_reviewer.conf_id', $conf_id);
		$this->db->where('paper_id', $paper_id);
		$this->db->where_in('user_staus', $staus);
		$query = $this->db->get();
		return $query->result();
	}

	function del_reviewer_pedding($paper_id,$user_login,$conf_id){
		$this->db->where('user_login', $user_login);
		$this->db->where('paper_id', $paper_id);
		if( $this->db->delete('paper_review_pedding') ){
			$this->conf->add_log("topic","del_reviewer_pedding",$conf_id,array("user_login"=>$user_login,"paper_id"=>$paper_id));
			return true;
		}else{
			return false;
		}
	}

	function assign_reviewer($paper_id,$user_login,$conf_id,$review_timeout,$subject,$message,$user_name,$user_email){
		$review_token = hash('sha1',uniqid(rand(),true));
		$reviewer = array(
			"paper_id"       => $paper_id,
			"user_login"     => $user_login,
			"review_timeout" => $review_timeout,
			"review_confirm" => -1,
			"review_token"   => $review_token
		);
		if( $this->db->insert('paper_review', $reviewer) ){
			$this->conf->add_log("topic","assign_reviewer",$conf_id,$reviewer);
			$this->sendmail_notice_reviewer($paper_id,$user_login,$conf_id,$review_timeout,$review_token,$subject,$message,$user_name,$user_email);
			return true;
		}else{
			return false;
		}
	}

	function mail_get_paper($conf_id,$paper_id){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->join('conf', 'paper.conf_id = conf.conf_id');
		$this->db->where('main_contract', 1);
		$this->db->where("sub_id",$paper_id);
		$this->db->where("paper.conf_id",$conf_id);
		return $this->db->get()->row();
	}

	function sendmail_notice_reviewer($paper_id,$user_login,$conf_id,$review_timeout,$review_token,$subject,$message,$user_name,$user_email){
		$user_info = $this->user->get_user_info($user_login);
		$paper     = $this->mail_get_paper($conf_id,$paper_id);

		$reviewer_email    = $user_info->user_email;
		$reviewer_name     = preg_match("/[\x{4e00}-\x{9fa5}]/u", $user_info->user_last_name)?$user_info->user_last_name.$user_info->user_first_name:$user_info->user_first_name." ".$user_info->user_last_name;
		$reviewer          = $user_login;
		$paper_title       = $paper->sub_title;
		$paper_summary     = $paper->sub_summary;
		$conf_name         = $paper->conf_name;
		$conf_link         = site_url($conf_id);
		$review_accept     = site_url("review_confirm/accept/".$review_token);
		$review_reject     = site_url("review_confirm/reject/".$review_token);
		$review_deadline   = date("Y-m-d H:i:s",$review_timeout);
		$password_reseturl = site_url("user/lostpwd");
		$review_url        = get_url("reviewer",$conf_id,"detail",$paper_id);
		$conf_email        = $paper->conf_email;

		$search = array("{reviewer_name}","{reviewer}","{paper_title}","{paper_summary}","{conf_name}","{conf_link}","{review_accept}","{review_reject}","{review_deadline}","{password_reseturl}","{review_url}","{user_name}","{user_email}");
        $replace = array($reviewer_name,$reviewer,$paper_title,$paper_summary,$conf_name,$conf_link,$review_accept,$review_reject,$review_deadline,$password_reseturl,$review_url,$user_name,$user_email);
		
        $mail_subject = str_replace($search,$replace,$subject);
        $mail_content = str_replace($search,$replace,$message);

        $subject = $mail_subject;
		$to      = $reviewer_email;
		$message = $mail_content;

		$this->email->from($conf_email, $conf_name);
		$this->email->reply_to($user_email, $user_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->conf->addmail($to,$subject,$message,$user_login,$conf_id);
		return $this->email->send();
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
    	//sp("TO:".$user_email."\n".$message);
    	/* TODO: SQL 化 */
    	$this->email->from('ccs@asia.edu.tw', $site_name);
		$this->email->to($user_email);
		$this->email->subject('[審查提醒]'.$conf_name.'稿件審查');
		$this->email->message($message);
		
		if( $this->email->send() ){
			$this->conf->add_log("topic","notice_reviewer",$conf_id,array("user_login" =>$user_login));
			return true;
		}else{
			return false;
		}
	}

	function count_reviewer($conf_id,$topic_id){
		if(empty($topic_id)){
			return ;
		}
		$this->db->select('paper_id,count(*) as cnt');
		$this->db->from('paper_review');
		$this->db->join('paper','paper.sub_id = paper_review.paper_id');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('review_confirm', 1);
		$this->db->where('topic_review', 0);
		$this->db->where_in('sub_topic', $topic_id);
		$this->db->group_by("paper_id");
		$query = $this->db->get();
		return $query->result();
	}

	function count_had_review($conf_id,$topic_id){
		if(empty($topic_id)){
			return ;
		}
		$this->db->select('paper_id,count(*) as cnt');
		$this->db->from('paper_review');
		$this->db->join('paper','paper.sub_id = paper_review.paper_id');
		$this->db->where('topic_review', 0);
		$this->db->where('conf_id', $conf_id);
		$this->db->where_in('sub_topic', $topic_id);
		$this->db->where('review_time >', 0);
		$this->db->where('review_confirm', 1);
		$this->db->where('topic_review', 0);
		
		$this->db->group_by("paper_id");
		$query = $this->db->get();
		return $query->result();
	}

	function topic_review($conf_id,$paper_id,$sub_status){
		//send result mail
		$status = array(-2,0,2,4);
		if( in_array($sub_status,$status) ){
			$paper = array(
            	"sub_status" => $sub_status
	        );
	        $this->db->where("conf_id",$conf_id);
	        $this->db->where("sub_id",$paper_id);
	        if( $this->db->update('paper', $paper) ){
	        	$this->finish_review($paper_id);
	        	$this->submit->add_status_history($paper_id,$sub_status);
	        	$this->conf->add_log("topic","topic_review",$conf_id,$paper);
	        	$template_name = "";
	        	switch($sub_status){
	        		case 4:
	        			$template_name = "review_result_accept";
	        		break;
	        		case 0:
	        			$template_name = "review_result_edit";
	        		break;
	        		case 2:
	        			$template_name = "review_result_pending";
	        		break;
	        		case -2:
	        			$template_name = "review_result_reject";
	        		break;
	        	}
	        	$this->notice_author($conf_id,$paper_id,$template_name);
				return true;
	        }
		}
		return false;
		
	}

	function notice_author($conf_id,$paper_id,$template_name){
		$mail_template = $this->conf->mail_get_template($conf_id,$template_name);
		$authors = $this->submit->get_contactauthor($conf_id,$paper_id);
		$conf = $this->conf->get_conf($conf_id);
		foreach ($authors as $key => $author) {
			$author_name_zhtw = $author->user_last_name.$author->user_first_name;
			$author_name_en   = $author->user_first_name." ".$author->user_middle_name." ".$author->user_last_name;
			$paper_title      = $author->sub_title;
			$paper_summary    = $author->sub_summary;
			$conf_email       = $conf->conf_email;
			$conf_name        = $conf->conf_name;
			$conf_link        = site_url($conf_id);
			$paper_link       = get_url("submit",$conf_id,"detail",$paper_id);
			$user_login       = $author->sub_user;
			$search = array("{author_name}","{paper_title}","{paper_summary}","{conf_name}","{conf_link}","{paper_link}");
			$replace_zhtw = array($author_name_zhtw,$paper_title,$paper_summary,$conf_name,$conf_link,$paper_link);
			$replace_en   = array($author_name_en,$paper_title,$paper_summary,$conf_name,$conf_link,$paper_link);

			$mail_subject_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_subject_zhtw);
			$mail_subject_en   = str_replace($search,$replace_en,$mail_template->email_subject_eng);
			$mail_content_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_body_zhtw);
			$mail_content_en   = str_replace($search,$replace_en,$mail_template->email_body_eng);

			$subject = $mail_subject_zhtw." ".$mail_subject_en;
			$to      = $author->user_email;
			$message = $mail_content_zhtw."<br><br><hr>".$mail_content_en;

			$this->email->from($conf_email, $conf_name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->conf->addmail($to,$subject,$message,$user_login,$conf_id);
			return $this->email->send();
		}
	}

	function finish_review($paper_id){
		$review = array(
        	"topic_review"=> 1
        );
        $this->db->where("paper_id",$paper_id);
		$this->db->update('paper_review', $review);
	}

	function count_paper($conf_id,$topic_id){
		if(empty($topic_id)){
			return ;
		}
		$this->db->select('count(*) as cnt');
		$this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->where_in('sub_topic', $topic_id);
		$this->db->where('paper.conf_id', $conf_id);
		$query = $this->db->get();
		return $query->row();
	}

	function mail_get_topic($conf_id,$paper_id){
		$this->db->select("users.user_login,users.user_email,users.user_first_name,users.user_last_name,conf.conf_name,conf.conf_email,paper.sub_title,paper.sub_summary");
		$this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('auth_topic', 'auth_topic.topic_id = topic.topic_id');
        $this->db->join('users', 'users.user_login = auth_topic.user_login');
        $this->db->join('conf', 'conf.conf_id = paper.conf_id');
        $this->db->where('paper.conf_id', $conf_id);
        $this->db->where('sub_id', $paper_id);
        $query = $this->db->get();
		return $query->result();
	}

	function notice_editor($conf_id,$paper_id){
		$editors = $this->mail_get_topic($conf_id,$paper_id);
		$mail_template = $this->conf->mail_get_template($conf_id,"editor_paper_assign");
		foreach ($editors as $key => $editor) {
			$topic_name_zhtw = $editor->user_last_name.$editor->user_first_name;
			$topic_name_en   = $editor->user_first_name." ".$editor->user_last_name;
			
			$user_login    = $editor->user_login;
			$conf_name     = $editor->conf_name;
			$paper_title   = $editor->sub_title; 
			$paper_summary = $editor->sub_summary; 
			$user_email    = $editor->user_email;
			$conf_email    = $editor->conf_email;
			$topic_link    = get_url("topic",$conf_id,"index");
			$conf_link     = site_url($conf_id);

			$search = array("{editor_name}","{editor}","{paper_title}","{paper_summary}","{conf_name}","{conf_link}","{topic_link}");
			$replace_zhtw = array($topic_name_zhtw,$user_login,$paper_title,$paper_summary,$conf_name,$conf_link,$topic_link);
			$replace_en   = array($topic_name_en,$user_login,$paper_title,$paper_summary,$conf_name,$conf_link,$topic_link);

			$mail_subject_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_subject_zhtw);
			$mail_subject_en   = str_replace($search,$replace_en,$mail_template->email_subject_eng);
			$mail_content_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_body_zhtw);
			$mail_content_en   = str_replace($search,$replace_en,$mail_template->email_body_eng);

			$subject = $mail_subject_zhtw." ".$mail_subject_en;
			$to      = $user_email;
			$message = $mail_content_zhtw."<br><br><hr>".$mail_content_en;
			
			$this->email->from($conf_email, $conf_name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			$this->conf->addmail($to,$subject,$message,$user_login,$conf_id);
			return $this->email->send();
		}
	}

	function get_check_review($review_token){
		$this->db->from('paper');
		$this->db->join('paper_review',"paper.sub_id = paper_review.paper_id");
        $this->db->where("review_token",$review_token);
        $this->db->where("review_confirm",-1);
        $query = $this->db->get();
        return $query->row();
	}

	function review_confirm($review_token,$review_confirm){
		$review = array(
			"review_confirm" => $review_confirm
		);
		$this->db->where('review_token', $review_token);
		return $this->db->update('paper_review', $review);
	}

	function count_pedding_paper($conf_id,$user_login){
		$papers=$this->topic->get_paper($conf_id,$user_login,null,1); // need to review paper
		$paper_author_array=$this->submit->show_mypaper($user_login,$conf_id); // user submit paper
		$paper_author = array();
		if(is_array($paper_author_array)){
			foreach ($paper_author_array as $key => $pa) {
				array_push($paper_author,$pa->sub_id);
			}
		}
		$pedding_review = array();
		foreach ($papers as $key => $paper) {
			if(!in_array($paper->sub_id,$paper_author)){
				array_push($pedding_review,$paper->sub_id);
			}
		}
		return count($pedding_review);
	}

	function uptate_review_timeout($review_timeout,$paper_id){
		$cnt = 0;
		foreach ($review_timeout as $user_login => $timeout) {
			$review = array(
				"review_timeout" => strtotime($timeout)
			);
			
			$this->db->where('user_login', $user_login);
			$this->db->where('review_status', 0);
			$this->db->where('topic_review', 0);
			$this->db->where('paper_id', $paper_id);
			if( $this->db->update('paper_review', $review) ){
				$cnt++;
			}
		}
		return $cnt>0;
	}
}