<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Submit_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function show_mypaper($user_login,$conf_id){
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('paper_author.user_login', $user_login);
        $this->db->where('paper.conf_id', $conf_id);
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
    		case 1:
    			$staus_text=$this->lang->line('status_submitcomplete');
    			$html_class="teal";
    			$desc="稿件完成投稿，待主題主編分派審查人";
    		break;
    		case 2:
    			$staus_text=$this->lang->line('status_pending');
    			$html_class="yellow";
    			$desc="搞件將於大會時決議";
    		break;
    		case 3:
    			$staus_text=$this->lang->line('status_review');
    			$html_class="orange";
    			$desc="搞件進入審查";
    		break;
    		case 4:
    			$staus_text=$this->lang->line('status_accepte');
    			$html_class="green";
    			$desc="研討會接受本篇稿件投稿";
    		break;
    		case 5:
    			$staus_text=$this->lang->line('status_complete');
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

    function get_paperinfo($conf_id,$paper_id, $user_login){
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('user_login', $user_login);
        $this->db->where("sub_id",$paper_id);
        $this->db->where("paper.conf_id",$conf_id);
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
            if($file_type == "F"){
                $this->session->set_flashdata($conf_id.'_file_id', $this->db->insert_id());
            }
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
            "sub_status"=>1
        );
        $this->db->where("conf_id",$conf_id);
        $this->db->where("sub_id",$paper_id);
        return $this->db->update('paper', $paper);
    }
    
    function paper_to_reviewing($conf_id,$paper_id){
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

    function get_allpaper($conf_id){
        $this->db->from('paper');
        $this->db->join('topic', 'paper.sub_topic = topic.topic_id');
        $this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
        $this->db->where('paper.conf_id', $conf_id);
        $this->db->order_by('paper.sub_id', 'ASC');
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
            return true;
        }else{
            return false;
        }
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
            return true;
        }else{
            return false;
        }
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
            return true;
        }else{
            return false;
        }
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
            return true;
        }else{
            return false;
        }
    }

    function update_most_file($most_id,$key,$file,$file_name){
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
            return true;
        }else{
            return false;
        }
    }

    function submit_most($conf_id,$most_id,$user_login){
        $most  = array(
            "most_status" => 1
        );
        $this->db->where('conf_id', $conf_id);
        $this->db->where('most_id', $most_id);
         $this->db->where('user_login', $user_login);
        if( $this->db->update('most', $most) ){
            return true;
        }else{
            return false;
        }
    }
}
