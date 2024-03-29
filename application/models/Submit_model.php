<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Submit_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function show_mypaper($user_login,$conf_id){
		$this->db->select('distinct(paper.sub_id),sub_title,topic_info,topic_name,sub_status,sub_time');
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->where('paper_author.user_login', $user_login);
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->order_by('paper.sub_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function paper_list($user_login,$conf_id){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->where('paper.sub_user ', $user_login);
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->order_by('paper.sub_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function get_mypapers($user_login){
		$this->db->select('distinct(paper.sub_id),sub_title,topic_info,topic_name,sub_status,conf.conf_name');
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->join('conf', 'paper.conf_id = conf.conf_id');
		$this->db->where('paper_author.user_login', $user_login);
		$this->db->order_by('paper.sub_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function sub_status($submit_staus,$style=false,$is_topic = false,$class=""){
		$html_class="";
		$staus_text="";
		$desc="";
		switch($submit_staus){
			case -5:
				$staus_text="刪除";
				$html_class="red";
				$desc="稿件被刪除";
			break;
			case -4:
				$staus_text=$this->lang->line('status_removing');
				$html_class="brown";
				$desc="稿件撤稿中(待主編確認中)";
			break;
			case -3:
				$staus_text=$this->lang->line('status_delete');
				$html_class="grey";
				$desc="稿件被作者撤稿(將不被作為研討會審查稿件)";
			break;
			case -2:
				$staus_text=$this->lang->line('status_reject');
				$html_class="red";
				$desc="稿件被主編及審查人拒絕";
			break;
			case -1:
				$staus_text=$this->lang->line('status_editing');
				$html_class="purple";
				$desc="稿件目前尚在編輯中";
			break;
			case 0:
				$staus_text="修改後通過";
				$html_class="teal";
				$desc="稿件修改後通過";
			break;
			case 1:
				if( $is_topic ){
					$staus_text="待分派審查";
					$html_class="yellow";
					$desc="稿件待分派審查";  
				}else{
					$staus_text=$this->lang->line('status_review');
					$html_class="orange";
					$desc="稿件進入審查";
				}
			break;
			case 2:
				$staus_text=$this->lang->line('status_pending');
				$html_class="yellow";
				$desc="稿件將於大會時決議";
			break;
			case 3:
				$staus_text=$this->lang->line('status_review');
				$html_class="orange";
				$desc="稿件進入審查";
			break;
			case 4:
				$staus_text=$this->lang->line('status_accepte');
				$html_class="green";
				$desc="研討會接受本篇稿件投稿";
			break;
			case 5:
				$staus_text=$this->lang->line('status_complete');
				$html_class="blue";
				$desc="完成稿件最後上傳資料";
			break;
			default:
				$staus_text="-";
				$html_class="";
				$desc="未知問題";
			break;
		}

		if(!empty($class)){
			$html_class = $html_class." ".$class;
		}
		if($style){
			return '<span class="ui label '.$html_class.'" data-toggle="tooltip" data-placement="top" title="'.$desc.'">'.$staus_text.'</span>';
		}else{
			return $staus_text;
		}
	}
	
	function add_paper($sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor,$conf_id,$sub_user){
		$sub_keyword = str_replace("、",",",$sub_keyword);
		$paper = array(
			"sub_title"      => $sub_title,
			"sub_summary"    => $sub_summary,
			"sub_keyword"    => $sub_keyword,
			"sub_topic"      => $sub_topic,
			"sub_lang"       => $sub_lang,
			"sub_sponsor"    => $sub_sponsor,
			"sub_status"     => -1,
			"sub_time"       => time(),
			"conf_id"        => $conf_id,
			"sub_user"       => $sub_user,
			"sub_lastupdate" => time()
		);
		// $this->conf->add_log("submit","add_paper",$conf_id,$paper);
		if( $this->db->insert('paper', $paper) ){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function update_paper($paper_id,$conf_id,$sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor){
		$sub_keyword = str_replace("、",",",$sub_keyword);
		$paper = array(
			"sub_title"      =>$sub_title,
			"sub_summary"    =>$sub_summary,
			"sub_keyword"    =>$sub_keyword,
			"sub_topic"      =>$sub_topic,
			"sub_lang"       =>$sub_lang,
			"sub_sponsor"    =>$sub_sponsor,
			"sub_time"       =>time(),
			"sub_lastupdate" => time()
		);
		$this->db->where('sub_id', $paper_id);
		$this->db->where('conf_id', $conf_id);
		// $this->conf->add_log("submit","update_paper",$conf_id,$paper);
		return $this->db->update('paper', $paper);
	}

	function add_time($conf_id,$insert_id){
		$this->session->set_userdata($conf_id.'_insert_id', $insert_id);
		$expire = config_item('insert_id_expire')*60;
		$this->session->mark_as_temp($conf_id.'_insert_id', $expire);
	}
	
	function add_author($paper_id,$user_login,$user_first_name,$user_last_name,$user_email,$user_org,$user_country,$main_contract,$author_order){
		$author = array(
			"paper_id"        => $paper_id,
			"user_login"      => $user_login,
			"user_first_name" => $user_first_name,
			"user_last_name"  => $user_last_name,
			"user_email"      => $user_email,
			"user_org"        => $user_org,
			"user_country"    => $user_country,
			"main_contract"   => $main_contract,
			"author_order"    => $author_order,
			"author_time"     => time()
		);
		return $this->db->insert('paper_author', $author);
	}

	function add_authors($paper_id,$user_fname,$user_mname,$user_lname,$user_email,$user_org,$user_country,$main_contact){
		$this->del_author($paper_id);
		$authors = array();
		foreach ($user_fname as $key => $value) {
			$author = array();
			$user_login = NULL;
			$user_info = $this->user->email_find($user_email[$key]);
			if( is_array($user_info) ){
				$user_login = $user_info['user_login'];
			}
			$author = array(
				"paper_id"         => $paper_id,
				"user_login"       => $user_login,
				"user_first_name"  => $user_fname[$key],
				"user_middle_name" => $user_mname[$key],
				"user_last_name"   => $user_lname[$key],
				"user_email"       => $user_email[$key],
				"user_org"         => $user_org[$key],
				"user_country"     => $user_country[$key],
				"main_contract"    => isset($main_contact[$key])?1:0,
				"author_order"     => $key+1,
				"author_time"      => time()
			);
			array_push($authors,$author);
		}
		return $this->db->insert_batch('paper_author', $authors);
	}

	function del_author($paper_id){
		$this->db->where('paper_id', $paper_id);
		if( $this->db->delete('paper_author') ){
			return true;
		}
		return false;
	}

	function get_author($paper_id){
		$this->db->from('paper_author');
		$this->db->where("paper_id",$paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function is_author($paper_id, $user_login){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic_id');
		$this->db->where('paper.sub_user', $user_login);
		$this->db->where("sub_id",$paper_id);
		return ( $this->db->count_all_results() >= 1 );
	}

	function get_paperinfo($conf_id,$paper_id,$user_login){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->where('sub_user', $user_login);
		$this->db->where("sub_id",$paper_id);
		$this->db->where("paper.conf_id",$conf_id);
		$query = $this->db->get();
		return $query->row();
	}

	function add_file($conf_id,$paper_id,$file_name,$file_system,$file_type){
		$paper_file = array(
			"paper_id"    => $paper_id,
			"file_name"   => $file_name,
			"file_system" => $file_system,
			"file_type"   => $file_type,
			"file_time"   => time()
		); 
		
		if( $this->db->insert('paper_file', $paper_file) ){
			if($file_type == "F"){
				$this->session->set_flashdata($conf_id.'_file_id', $this->db->insert_id());
			}
			// $this->conf->add_log("submit","add_file",$conf_id,$paper_file);
			return true;
		}else{
			return false;
		}
	}

	function update_file($conf_id,$paper_id,$fid,$file_name,$file_system){
		$paper_file = array(
			"file_name"   => $file_name,
			"file_system" => $file_system,
			"file_time"   => time()
		); 
		$this->db->where("fid",$fid);
		$this->db->where("paper_id",$paper_id);
		if( $this->db->update('paper_file', $paper_file) ){
			// $this->conf->add_log("submit","update_file",$conf_id,$paper_file);
			return true;
		}
		return false;
	}

	function del_file($conf_id,$paper_id,$fid){
		$this->db->from('paper_file');
		$this->db->where("paper_id",$paper_id);
		$this->db->where("fid",$fid);
		$query = $this->db->get();
		$file = $query->row();
		if( empty($file) || !in_array($file->file_type, array("F","O"))){
			return false;
		}
		$this->db->where("fid",$fid);
		$this->db->where("paper_id",$paper_id);
		
		if( $this->db->delete('paper_file') ){
			delete_files($this->conf->get_paperdir($conf_id).$file->file_system);
			return true;
		}
		
		return false;
	}

	function get_otherfile($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "F");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_otherfiles($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "O");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function check_paper($paper){
		$return = array(
			"bool_paper"=>false,
			"need_paper"=>array()
		);
		if( empty($paper->sub_title) ){
			array_push($return['need_paper'], "題目");
		}

		if( empty($paper->sub_summary) ){
			array_push($return['need_paper'], "摘要");
		}

		if( empty($paper->topic_name) ){
			array_push($return['need_paper'], "主題");
		}

		if( empty($paper->sub_keyword) ){
			array_push($return['need_paper'], "關鍵字");
		}

		if( empty($paper->sub_lang) ){
			array_push($return['need_paper'], "語言");
		}

		if( count($return['need_paper']) ==0 ){
			$return['bool_paper'] = true;
		}else{
			$return['bool_paper'] = false;
		}
		return $return;
	}

	function check_otherfile($otherfile){
		return !empty($otherfile);
	}

	function check_authors($authors){
		$return = array(
			"bool_authors"=>false,
			"need_authors"=>array()
		);
		if(!empty($authors)){
			foreach ($authors as $key => $author) {
				if( empty($author->user_first_name) ){
					array_push($return['need_authors'], "<li>作者".$author->author_order."：姓</li>");
				}
				if( empty($author->user_last_name) ){
					array_push($return['need_authors'], "<li>作者".$author->author_order."：名</li>");
				}
				if( empty($author->user_email) ){
					array_push($return['need_authors'], "<li>作者".$author->author_order."：電子信箱</li>");
				}
				if( empty($author->user_org) ){
					array_push($return['need_authors'], "<li>作者".$author->author_order."：所屬機構</li>");
				}
				if( empty($author->user_country) ){
					array_push($return['need_authors'], "<li>作者".$author->author_order."：國別</li>");
				}
			}
			if( count($return['need_authors']) ==0 ){
				$return['bool_authors'] = true;
			}else{
				$return['bool_authors'] = false;
			}
		}else{
			$return['bool_authors'] = false;
			array_push($return['need_authors'], "無作者資料");
		}
		return $return;
	}

	function add_status_history($paper_id,$paper_status){
		$status_history  = array(
			"paper_id"     => $paper_id,
			"paper_status" => $paper_status,
			"history_time" => time()
		);
		return $this->db->insert('paper_status_history', $status_history);
	}

	function paper_to_review($conf_id,$paper_id){
		$paper = array(
			"sub_status" => 1,
			"sub_review" => time()
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("sub_id",$paper_id);
		if( $this->db->update('paper', $paper) ){
			$this->add_status_history($paper_id,1);
			$this->sendmail_submit_success($paper_id,$conf_id);
			$this->topic->notice_editor($conf_id,$paper_id);
			// $this->conf->add_log("submit","paper_to_review",$conf_id,$paper);
			return true;
		}else{
			return false;
		}
	}
	
	function paper_to_reviewing($conf_id,$paper_id){
		$paper = array(
			"sub_status" => 3
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("sub_id",$paper_id);
		
		if( $this->db->update('paper', $paper) ){
			$this->add_status_history($paper_id,3);
			$this->conf->add_log("submit","paper_to_reviewing",$conf_id,$paper);
			// $this->session->unset_userdata($conf_id.'_insert_id');
			return true;
		}else{
			return false;
		}
	}

	function is_editable($paper_id, $user_login){
		$this->db->from('paper');
		$this->db->where('sub_user', $user_login);
		$this->db->where("sub_id",$paper_id);
		$this->db->where_in("sub_status", array(-1,0));
		return ($this->db->count_all_results() > 0);
	}

	function get_allpaper($conf_id,$topic_id=null,$sub_status=null){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		//$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->order_by('paper.sub_id', 'ASC');

		if( !is_null($sub_status) ){
			$this->db->where('paper.sub_status', $sub_status);
		}
		
		if( !is_null($topic_id) ){
			$this->db->where('paper.sub_topic', $topic_id);
		}

		$query = $this->db->get();
		return $query->result();
	}

	function add_most($conf_id,$user_login,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept){
		$most  = array(
			"conf_id"       => $conf_id,
			"user_login"    => $user_login,
			"most_method"   => $most_method,
			"most_number"   => $most_number,
			"most_name"     => $most_name,
			"most_name_eng" => $most_name_eng,
			"most_host"     => $most_host,
			"most_uni"      => $most_uni,
			"most_dept"     => $most_dept
		);
		if( $this->db->insert('most', $most) ){
			$this->conf->add_log("submit","add_most",$conf_id,$most);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function add_most_report($most_id,$report_name,$report_uni,$report_dept,$report_title,$report_email,$report_phone,$report_meal,$report_mealtype){
		$most_report  = array(
			"most_id"         => $most_id,
			"report_name"     => $report_name,
			"report_uni"      => $report_uni,
			"report_dept"     => $report_dept,
			"report_title"    => $report_title,
			"report_email"    => $report_email,
			"report_phone"    => $report_phone,
			"report_meal"     => $report_meal,
			"report_mealtype" => $report_mealtype
		);
		if( $this->db->insert('most_report', $most_report) ){
			$this->conf->add_log("submit","add_most_report",$conf_id,$most_report);
			return true;
		}
		return false;
	}

	function add_most_file($most_id,$conf_id,$most_auth,$most_result,$most_poster,$most_auth_name,$most_result_name,$most_poster_name){
		$most_file  = array(
			"most_id"     => $most_id,
			"conf_id"     => $conf_id,
			"most_auth"   => $most_auth,
			"most_result" => $most_result,
			"most_poster" => $most_poster,
			"most_auth_name"   => $most_auth_name,
			"most_result_name" => $most_result_name,
			"most_poster_name" => $most_poster_name
		);
		
		
		if( $this->db->insert('most_file', $most_file) ){
			$this->conf->add_log("submit","add_most_file",$conf_id,$most_report);
			return true;
		}
		return false;
	}

	function get_mosts($conf_id,$user_login){
		$this->db->from('most');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$query = $this->db->get();
		return $query->result();
	}

	function get_most($conf_id,$user_login,$most_id){
		$this->db->from('most');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('most_id', $most_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_most_file($conf_id,$most_id){
		$this->db->from('most_file');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('most_id', $most_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_most_report($most_id){
		$this->db->from('most_report');
		$this->db->where('most_id', $most_id);
		$query = $this->db->get();
		return $query->row();
	}

	function most_status($most_staus,$style=false){
		$html_class="";
		$staus_text="";
		$desc="";
		switch($most_staus){
			case -1:
				$staus_text="拒絕";
				$html_class="red";
				$desc="拒絕";
			break;
			case 0:
				$staus_text="編輯中";
				$html_class="purple";
				$desc="尚在編輯中";
			break;
			case 1:
				$staus_text="審查中";
				$html_class="orange";
				$desc="資料完成上傳，待審查中";
			break;
			case 2:
				$staus_text="接受";
				$html_class="green";
				$desc="接受";
			break;
			default:
				$staus_text="-";
				$html_class="";
				$desc="未知問題";
			break;
		}

		if($style){
			return '<span class="ui label '.$html_class.'" data-toggle="tooltip" data-placement="top" title="'.$desc.'">'.$staus_text.'</span>';
		}else{
			return $staus_text;
		}
	}

	function most_method($most_method){
		$html_class="";
		$staus_text="";
		switch($most_method){
			case "O":
				$staus_text="口頭發表";
				$html_class="blue";
			break;
			case "P":
				$staus_text="海報發表";
				$html_class="pink";
			break;
			default:
				$staus_text="-";
				$html_class="";
			break;
		}
		return '<span class="ui label basic '.$html_class.'">'.$staus_text.'</span>';
	}

	function most_valid(){
		$this->form_validation->set_rules('most_method', '發表方式', 'required');
		$this->form_validation->set_rules('most_number', '計畫編號', 'required');
		$this->form_validation->set_rules('most_name', '計畫中文名稱', 'required');
		$this->form_validation->set_rules('most_name_eng', '計畫英文名稱', 'required');
		$this->form_validation->set_rules('most_uni', '單位(學校)', 'required');
		$this->form_validation->set_rules('most_dept', '部門(系所)', 'required');
		$this->form_validation->set_rules('most_host', '計畫主持人', 'required');

		$this->form_validation->set_rules('report_name', '發表者姓名', 'required');
		$this->form_validation->set_rules('report_uni', '發表者單位(學校)', 'required');
		$this->form_validation->set_rules('report_dept', '發表者部門(系所)', 'required');
		$this->form_validation->set_rules('report_title', '發表者職稱', 'required');
		$this->form_validation->set_rules('report_email', '發表者Email', 'required|valid_email');
		$this->form_validation->set_rules('report_phone', '發表者電話)', 'required');
		$this->form_validation->set_rules('report_meal', '用餐習慣', 'required');
		$this->form_validation->set_rules('report_mealtype', '餐券', 'required');
		$this->form_validation->set_rules('report_meal', '用餐習慣', 'required');
	}

	function update_most($conf_id,$user_login,$most_id,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept){
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
		$this->db->where('user_login', $user_login);
		$this->db->where('conf_id', $conf_id);
	   
		if( $this->db->update('most', $most) ){
			$this->conf->add_log("submit","update_most",$conf_id,$most);
			return true;
		}
		return false;
	}

	function update_most_report($most_id,$report_name,$report_uni,$report_dept,$report_title,$report_email,$report_phone,$report_meal,$report_mealtype){
		$most_report  = array(
			"report_name"     => $report_name,
			"report_uni"      => $report_uni,
			"report_dept"     => $report_dept,
			"report_title"    => $report_title,
			"report_email"    => $report_email,
			"report_phone"    => $report_phone,
			"report_meal"     => $report_meal,
			"report_mealtype" => $report_mealtype
		);
		$this->db->where('most_id', $most_id);
		
		if( $this->db->update('most_report', $most_report) ){
			$this->conf->add_log("submit","update_most_report",$conf_id,$most_report);
			return true;
		}
		return false;
	}

	function update_most_file($most_id,$key,$file,$file_name){
		$most_file = array();
		switch($key){
			case "auth":
				$most_file  = array(
					"most_auth"   => $file,
					"most_auth_name"   => $file_name
				);
			break;
			case "result":
				$most_file  = array(
					"most_result" => $file,
					"most_result_name" => $file_name
				);
			break;
			case "poster":
				$most_file  = array(
					"most_poster" => $file,
					"most_poster_name" => $file_name
				);
			break;
		}
		$this->db->where('most_id', $most_id);
		if( $this->db->update('most_file', $most_file) ){
			$this->conf->add_log("submit","update_most_file",$conf_id,array_merge(array("type"=>$key),$most_file));
			return true;
		}
		return false;
	}

	function submit_most($conf_id,$most_id,$user_login){
		$most  = array(
			"most_status" => 1
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('most_id', $most_id);
		$this->db->where('user_login', $user_login);
		
		if( $this->db->update('most', $most) ){
			$this->conf->add_log("submit","submit_most",$conf_id,$most);
			return true;
		}
		return false;

	}

	function get_registers($conf_id,$user_login){
		$this->db->from('register');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$query = $this->db->get();
		return $query->result();
	}

	function get_register($conf_id,$user_login,$register_id){
		$this->db->from('register');
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('register_id', $register_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_user_register_meal($register_id){
		$this->db->from('register_meal');
		$this->db->where('register_id', $register_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_user_register_paper($register_id,$user_login){
		$this->db->from('register_paper');
		$this->db->where('register_id', $register_id);
		$this->db->where('user_login', $user_login);
		$query = $this->db->get();
		return $query->result();
	}

	function add_register($conf_id,$user_login,$user_name,$user_org,$user_phone,$user_email,$pay_name,$pay_date,$pay_account,$pay_bill,$uniform_number){
		$register = array(
			"conf_id"        => $conf_id,
			"user_login"     => $user_login,
			"user_name"      => $user_name,
			"user_org"       => $user_org,
			"user_phone"     => $user_phone,
			"user_email"     => $user_email,
			"pay_name"       => $pay_name,
			"pay_date"       => $pay_date,
			"pay_account"    => $pay_account,
			"pay_bill"       => $pay_bill,
			"uniform_number" => $uniform_number,
			"register_time"  => time()
		);
		if( $this->db->insert('register', $register) ){
			$this->conf->add_log("submit","add_register",$conf_id,$register);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function add_register_meal($register_id,$meal_id,$meal_type){
		$register_meal = array(
			"register_id" => $register_id,
			"meal_id"     => $meal_id,
			"meal_type"   => $meal_type
		);
		if( $this->db->insert('register_meal', $register_meal) ){
			// $this->conf->add_log("submit","add_register_meal",$conf_id,$register_meal);
			return true;
		}
		return false;
	}

	function add_register_paper($user_login,$paper_id,$register_id){
		$register_paper = array(
			"register_id" => $register_id,
			"user_login"  => $user_login,
			"paper_id"   => $paper_id
		);
		if( $this->db->insert('register_paper', $register_paper) ){
			// $this->conf->add_log("submit","add_register_paper",$conf_id,$register_paper);
			return true;
		}
		return false;
	}

	function register_status($register_status,$style=false){
		$html_class="";
		$staus_text="";
		switch($register_status){
			case -1:
				$staus_text="尚未上傳收據";
				$html_class="grey";
			break;
			case 0:
				$staus_text="編輯中";
				$html_class="teal";
			break;
			case 1:
				$staus_text="核對中";
				$html_class="yellow";
			break;
			case 2:
				$staus_text="成功註冊";
				$html_class="green";
			break;
			case 3:
				$staus_text="註冊失敗";
				$html_class="red";
			break;
			default:
				$staus_text="-";
				$html_class="";
			break;
		}

		if($style){
			return '<span class="ui label '.$html_class.'">'.$staus_text.'</span>';
		}else{
			return $staus_text;
		}
	}

	function update_register_pay_bill($pay_bill,$conf_id,$user_login,$register_id){
		$pay = array(
			"pay_bill" => $pay_bill
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('user_login', $user_login);
		$this->db->where('register_id', $register_id);
		if( $this->db->update('register', $pay) ){
			// $this->conf->add_log("submit","update_register_pay_bill",$conf_id,$pay);
			return true;
		}
		return false;
	}

	function update_register_status($register_status,$conf_id,$register_id){
		$pay = array(
			"register_status" => $register_status,
			"register_time"   => time()
		);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('register_id', $register_id);
		
		return ;
		if( $this->db->update('register', $pay) ){
			$this->conf->add_log("submit","update_register_status",$conf_id,$pay);
			return true;
		}
		return false;
	}

	function mail_get_paper($conf_id,$paper_id){
		$this->db->from('paper');
		$this->db->join('topic', 'paper.sub_topic = topic.topic_id');
		$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
		$this->db->join('conf', 'paper.conf_id = conf.conf_id');
		$this->db->where('main_contract', 1);
		$this->db->where("sub_id",$paper_id);
		$this->db->where("paper.conf_id",$conf_id);
		$query = $this->db->get();
		return $query->result();
	}

	function sendmail_submit_success($paper_id,$conf_id){
		$papers = $this->mail_get_paper($conf_id,$paper_id);
		$send = 0;
		foreach ($papers as $key => $paper) {
			$author_name_zhtw = $paper->user_last_name.$paper->user_last_name.$paper->user_first_name;
			$author_name_en   = $paper->user_first_name." ".$paper->user_last_name;
			$author           = is_null($paper->user_login)?'<a href="'.site_url("user/signup").'">未註冊帳號,前往註冊帳號 / Unregistered Account,Go To Signup Account</a> )':$paper->user_login;
			$paper_title      = $paper->sub_title;
			$paper_summary    = $paper->sub_summary;
			$conf_name        = $paper->conf_name;
			$conf_link        = site_url($conf_id);
			$submit_link      = get_url("submit",$conf_id);
			$user_email       = $paper->user_email;
			$conf_email       = $paper->conf_email;

			$search = array("{author_name}","{author}","{paper_title}","{paper_summary}","{conf_name}","{conf_link}","{submit_link}");
			$replace_zhtw = array($author_name_zhtw,$author,$paper_title,$paper_summary,$conf_name,$conf_link,$submit_link);
			$replace_en = array($author_name_en,$author,$paper_title,$paper_summary,$conf_name,$conf_link,$submit_link);

			$mail_template     = $this->conf->mail_get_template($conf_id,"thank_submit");
			$mail_subject_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_subject_zhtw);
			$mail_subject_en   = str_replace($search,$replace_en,$mail_template->email_subject_eng);
			$mail_content_zhtw = str_replace($search,$replace_zhtw,$mail_template->email_body_zhtw);
			$mail_content_en   = str_replace($search,$replace_en,$mail_template->email_body_eng);
			
			$subject = $mail_subject_zhtw." ".$mail_subject_en;
			$message = $mail_content_zhtw."<br><br><hr>".$mail_content_en;
			$to      = $user_email;
			$user_login = $author;
			$this->email->from($conf_email, $conf_name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			$this->conf->addmail($to,$subject,$message,$paper->user_login,$conf_id);
			if( $this->email->send() ){
				$send++;
			}
		}
		return ($send>0);
	}


	function get_finishfile($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "FF");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_finishother($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "FO");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_finishcopyright($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "FC");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_finishabstract($paper_id){
		$this->db->from('paper_file');
		$this->db->where('file_type', "FA");
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_finish($paper_id){
		$this->db->from('paper_file');
		$this->db->where_in('file_type', array("FF","FO","FC","FA"));
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get();
		return $query->result();
	}

	function del_finishfile($conf_id,$paper_id,$fid){ // $fid array
		$this->db->from('paper_file');
		$this->db->where("paper_id",$paper_id);
		$this->db->where_in("fid",$fid);
		$this->db->where_in("file_type",array("FF","FO"));
		$query = $this->db->get();
		$files = $query->result();
		foreach ($files as $key => $file) {
			delete_files($this->conf->get_paperdir($conf_id).$file->file_system);
		}
		$this->db->where_in("fid",$fid);
		$this->db->where_in("file_type",array("FF","FO","FC","FA"));
		if( $this->db->delete('paper_file') ){
			return true;
		}
		return false;
	}

	function paper_to_finish($conf_id,$paper_id){
		$paper = array(
			"sub_status" => 5,
			"sub_time"   => time()
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("sub_id",$paper_id);
		if( $this->db->update('paper', $paper) ){
			$this->add_status_history($paper_id,5);
			// $this->sendmail_submit_success($paper_id,$conf_id);
			// $this->topic->notice_editor($conf_id,$paper_id);
			// $this->conf->add_log("submit","paper_to_review",$conf_id,$paper);
			return true;
		}else{
			return false;
		}
	}

	function count_pages($pdfname) {
		
		$output   = shell_exec("pdfinfo ".$pdfname);
		preg_match("/Title:\s*(.+)/i", $output, $pagetitlematches);
		preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
		preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
		// $num      = preg_match_all("/\/Page\W/", $pdftext, $dummy);
		// $pagesize = preg_match('~ Page size: ([0-9\.]+) x ([0-9\.]+) pts ~', $pdftext, $matches);
		
		$pdfinfo = array();
		$pdfinfo['pages'] = $pagecountmatches[1];
		$pdfinfo['width'] = round($pagesizematches[1]/2.83)/10;
		$pdfinfo['height'] = round($pagesizematches[2]/2.83)/10;
		return $pdfinfo;
	}

	function pdf_pages($pdfname) {
		$pdftext = file_get_contents($pdfname);
		return $pdftext;
	}

	function paper_to_remove($conf_id,$paper_id,$old_status){
		$paper = array(
			"sub_status" => -5
		);
		$this->db->where("conf_id",$conf_id);
		$this->db->where("sub_id",$paper_id);
		if( $this->db->update('paper', $paper) ){
			$this->add_status_history($paper_id,-5);
			$this->conf->add_log("conf","remove_paper",$conf_id,array("paper_id"=>$paper_id,"sub_status" => -5,"old_status"=>$old_status));
			return true;
		}else{
			return false;
		}
	}

	function get_paper_status_select($name,$selected){
		$options = array(
			'-3' => lang('status_delete'),
			'-2' => lang('status_reject'),
			'-1' => lang('status_editing'),
			'1'  => lang('status_submitcomplete'),
			'2'  => lang('status_pending')
		);
		echo form_dropdown($name, $options, $selected);
	}

	function change_paper_status($old_status,$paper_status,$conf_id,$paper_id){
		if( in_array($paper_status,array(-3,-2,-1,1,2)) ) {
			$paper = array(
				"sub_status" => $paper_status
			);
			$this->db->where("conf_id",$conf_id);
			$this->db->where("sub_id",$paper_id);
			if( $this->db->update('paper', $paper) ){
				$this->add_status_history($paper_id,$paper_status);
				$this->conf->add_log("submit","change_paper_status",$conf_id,array("old_status"=>$old_status,"paper_status"=>$paper_status,"paper_id"=>$paper_id));
				return true;
			}else{
				return false;
			}
		}
	}

	function add_agree($paper_id,$agree_value,$conf_id,$is_finish=0){
		$agree = array();
		$time  = time();
		foreach ($agree_value as $agree_token => $value) {
			$tmp_agree = array(
				"paper_id"    => $paper_id,
				"agree_token" => $agree_token,
				"agree_value" => $value,
				"conf_id"     => $conf_id,
				"agree_time"  => $time,
				"is_finish"   => $is_finish
			);
			array_push($agree,$tmp_agree);
		}
		return $this->db->insert_batch('paper_agree', $agree);
	}

	function update_agree($conf_id,$paper_id,$agree_value,$is_finish=0){
		$this->delete_agree($conf_id,$paper_id,$is_finish=0);
		return $this->add_agree($paper_id,$agree_value,$conf_id,$is_finish);
	}

	function delete_agree($conf_id,$paper_id,$is_finish=0){
		// $this->db->where('conf_id', $conf_id);
		// $this->db->where('paper_id', $paper_id);
		// return $this->db->delete('paper_agree');

		$paper_agree = array(
			"agree_valid" => 0
		);

		$this->db->where('paper_id', $paper_id);
		$this->db->where('conf_id', $conf_id);
		$this->db->where('is_finish', $is_finish);
		return $this->db->update('paper_agree', $paper_agree);
	}

	function get_agree($conf_id,$paper_id,$is_finish=0){
		$this->db->from("paper_agree");
		$this->db->where("conf_id",$conf_id);
		$this->db->where("paper_id",$paper_id);
		$this->db->where("agree_valid",1);
		$this->db->where("is_finish",$is_finish);
		return $this->db->get()->result();
	}

	function get_contactauthor($conf_id,$paper_id){
		$this->db->from("paper");
		$this->db->join("paper_author","paper.sub_id = paper_author.paper_id");
		$this->db->where("paper.conf_id",$conf_id);
		$this->db->where("paper.sub_id",$paper_id);
		$this->db->where("paper_author.main_contract",1);
		return $this->db->get()->result();
	}
}
