<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Submit_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function show_mypaper($user_login){
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('paper_author.user_login', $user_login);
        $this->db->order_by('paper.sub_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function sub_status($submit_staus,$style=false){
    	$html_class="";
    	$staus_text="";
    	$desc="";
    	switch($submit_staus){
    		case -4:
    			$staus_text="撤稿中";
    			$html_class="brown";
    			$desc="稿件撤稿中(待主編確認中)";
    		break;
    		case -3:
    			$staus_text="刪除";
    			$html_class="grey";
    			$desc="稿件被作者撤稿(將不被作為研討會審查稿件)";
    		break;
    		case -2:
    			$staus_text="拒絕";
    			$html_class="red";
    			$desc="稿件被主編及審查人拒絕";
    		break;
    		case -1:
    			$staus_text="編輯中";
    			$html_class="purple";
    			$desc="稿件目前尚在編輯中";
    		break;
    		case 1:
    			$staus_text="投稿完成";
    			$html_class="teal";
    			$desc="稿件完成投稿，待主題主編分派審查人";
    		break;
    		case 2:
    			$staus_text="大會待決";
    			$html_class="yellow";
    			$desc="搞件將於大會時決議";
    		break;
    		case 3:
    			$staus_text="審查中";
    			$html_class="orange";
    			$desc="搞件進入審查";
    		break;
    		case 4:
    			$staus_text="接受";
    			$html_class="green";
    			$desc="研討會接受本篇稿件投稿";
    		break;
    		case 5:
    			$staus_text="完稿";
    			$html_class="blue";
    			$desc="完成搞件最後上傳資料";
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
    
    function add_paper($sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor,$conf_id){
        $paper = array(
            "sub_title"   =>$sub_title,
            "sub_summary" =>$sub_summary,
            "sub_keyword" =>$sub_keyword,
            "sub_topic"   =>$sub_topic,
            "sub_lang"    =>$sub_lang,
            "sub_sponsor" =>$sub_sponsor,
            "sub_status"  =>-1,
            "sub_time"    =>time(),
            "conf_id"     =>$conf_id
        );
        if( $this->db->insert('paper', $paper) ){
            $this->session->set_userdata($conf_id.'_insert_id', $this->db->insert_id());
            $expire = config_item('insert_id_expire')*60;
            $this->session->mark_as_temp($conf_id.'_insert_id', $expire);
            return true;
        }else{
            return false;
        }
    }

    function update_paper($paper_id,$conf_id,$sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor){
        $paper = array(
            "sub_title"   =>$sub_title,
            "sub_summary" =>$sub_summary,
            "sub_keyword" =>$sub_keyword,
            "sub_topic"   =>$sub_topic,
            "sub_lang"    =>$sub_lang,
            "sub_sponsor" =>$sub_sponsor,
            "sub_time"    =>time(),
        );
        sp($paper);
        $this->db->where('sub_id', $paper_id);
        $this->db->where('conf_id', $conf_id);
        if( $this->db->update('paper', $paper) ){
            return true;
        }else{
            return false;
        }
    }

    function add_time($conf_id,$insert_id){
        $this->session->set_userdata($conf_id.'_insert_id', $insert_id);
        $expire = config_item('insert_id_expire')*60;
        $this->session->mark_as_temp($conf_id.'_insert_id', $expire);
    }
    
    function add_author($paper_id,$user_login,$user_first_name,$user_last_name,$user_email,$user_org,$user_country,$main_contract,$author_order){
        $author = array(
            "paper_id"        =>$paper_id,
            "user_login"      =>$user_login,
            "user_first_name" =>$user_first_name,
            "user_last_name"  =>$user_last_name,
            "user_email"      =>$user_email,
            "user_org"        =>$user_org,
            "user_country"    =>$user_country,
            "main_contract"   =>$main_contract,
            "author_order"    =>$author_order
        );
        if( $this->db->insert('paper_author', $author) ){
            return true;
        }else{
            return false;
        }
    }

    function del_author($paper_id){
        $this->db->where('paper_id', $paper_id);
        if( $this->db->delete('paper_author') ){
            return true;
        }else{
            return false;
        }
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
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('user_login', $user_login);
        $this->db->where("sub_id",$paper_id);
        if( $this->db->count_all_results() ==1 ){
            return true;
        }else{
            return false;
        }
    }

    function get_paperinfo($paper_id, $user_login){
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('user_login', $user_login);
        $this->db->where("sub_id",$paper_id);
        $query = $this->db->get();
        return $query->row();
    }

    

    function add_file($conf_id,$paper_id,$file_name,$file_system,$file_type){
        $paper_file = array(
            "paper_id"=>$paper_id,
            "file_name"=>$file_name,
            "file_system"=>$file_system,
            "file_type"=>$file_type
        ); 
        if( $this->db->insert('paper_file', $paper_file) ){
            $this->session->set_userdata($conf_id.'_file_id', $this->db->insert_id());
            $expire = config_item('insert_id_expire')*60;
            $this->session->mark_as_temp($conf_id.'_file_id', $expire);
            return true;
        }else{
            return false;
        }
    }

    function update_file($conf_id,$paper_id,$fid,$file_name,$file_system){
        $paper_file = array(
            "file_name"=>$file_name,
            "file_system"=>$file_system,
        ); 
        $this->db->where("fid",$fid);
        $this->db->where("paper_id",$paper_id);
        $this->db->update('paper_file', $paper_file);
    }

    function get_otherfile($paper_id){
        $this->db->select('*');
        $this->db->from('paper_file');
        $this->db->where('file_type', "F");
        $this->db->where('paper_id', $paper_id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_otherfiles($paper_id){
        $this->db->select('*');
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
        if(!empty($otherfile)){
           return true;
        }else{
            return false;
        }
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

    function paper_to_review($conf_id,$paper_id){
        $paper = array(
            "sub_status"=>3
        );
        $this->db->where("conf_id",$conf_id);
        $this->db->where("sub_id",$paper_id);
        return $this->db->update('paper', $paper);
    }

    function is_editable($paper_id, $user_login){
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('user_login', $user_login);
        $this->db->where("sub_id",$paper_id);
        $this->db->where("sub_status",-1);
        if( $this->db->count_all_results() ==1 ){
            return false;
        }else{
            return true;
        }
    }
}
