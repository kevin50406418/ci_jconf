<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Module_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function get_module($conf_id,$module_position,$module_lang){
    	$this->db->from("module");
    	$this->db->where("conf_id",$conf_id);
    	$this->db->where("module_position",$module_position);
    	$this->db->order_by("module_order","DESC");
    	$query = $this->db->get();
        $modules = $query->result();
        foreach ($modules as $key => $module) {
            switch($module->module_type){
                case "news":
                    $this->module_news($conf_id,$module->module_title,$module->module_showtitle);
                break;
                case "text":
                    $this->module_text($conf_id,$module->module_title,$module->module_showtitle,$module->module_content);
                break;
            }
        }
    }

    function del_module($conf_id,$module_id){
        $this->db->where('conf_id', $conf_id);
        $this->db->where('module_id', $module_id);
        if( $this->db->delete('module') ){
            return true;
        }else{
            return false;
        }
    }

    function module_news($conf_id,$module_title,$module_showtitle){
    	$data['news'] = $this->conf->get_news($conf_id);
    	$data['module_title'] = $module_title;
    	$data['module_showtitle'] = $module_showtitle;
    	$this->load->view('module/news',$data);
    }

    function module_text($conf_id,$module_title,$module_showtitle,$module_content){
    	$data['module_title'] = $module_title;
    	$data['module_showtitle'] = $module_showtitle;
    	$data['module_content'] = $module_content;
    	$this->load->view('module/text',$data);
    }

    function add_text($conf_id,$module_title,$module_position,$module_showtitle,$module_lang,$module_content){
        $text = array(
            "conf_id"          => $conf_id,
            "module_title"     => $module_title,
            "module_position"  => $module_position,
            "module_type"      => "text",
            "module_showtitle" => $module_showtitle,
            "module_lang"      => $module_lang,
            "module_content"   => $module_content
        );
        return $this->db->insert('module', $text);
    }

    function update_text($conf_id,$module_id,$module_title,$module_position,$module_showtitle,$module_lang,$module_content){
        $text = array(
            "module_title"     => $module_title,
            "module_position"  => $module_position,
            "module_showtitle" => $module_showtitle,
            "module_lang"      => $module_lang,
            "module_content"   => $module_content
        );
        $this->db->where('module_type', "text");
        $this->db->where('module_id', $module_id);
        $this->db->where('conf_id', $conf_id);

        if( $this->db->update('module', $text) ){
            return true;
        }else{
            return false;
        }
    }
    
    function add_news($conf_id,$module_title,$module_position,$module_showtitle,$module_lang){
        $news = array(
            "conf_id"          => $conf_id,
            "module_title"     => $module_title,
            "module_position"  => $module_position,
            "module_type"      => "news",
            "module_showtitle" => $module_showtitle,
            "module_lang"      => $module_lang,
        );
        return $this->db->insert('module', $news);
    }

    function update_news($conf_id,$module_id,$module_title,$module_position,$module_showtitle,$module_lang){
        $news = array(
            "module_title"     => $module_title,
            "module_position"  => $module_position,
            "module_showtitle" => $module_showtitle,
            "module_lang"      => $module_lang,
        );
        $this->db->where('module_type', "news");
        $this->db->where('module_id', $module_id);
        $this->db->where('conf_id', $conf_id);

        if( $this->db->update('module', $text) ){
            return true;
        }else{
            return false;
        }
    }
}