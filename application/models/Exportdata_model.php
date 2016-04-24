<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Exportdata_model extends CI_Model {
	private $data = array();
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('zip');
		$this->load->helper('download');
    }

    function get_paperlist($topic,$status,$conf_id){
    	$this->db->from('paper');
		$this->db->join('topic','topic.topic_id = paper.sub_topic');
		$this->db->where_in('sub_topic', $topic);
		$this->db->where_in('sub_status', $status);
		$this->db->where('paper.conf_id', $conf_id);
		$papers = $this->db->get()->result();
		return $papers;
    }

    function paperlist($topic,$status,$format,$conf_id,$filename){
		$papers = $this->get_paperlist($topic,$status,$conf_id);
		$this->data['papers'] = $papers;
		if( empty($filename) ){
			$filename = "paperlist";
		}
		switch($format){
			case "csv":
				$this->output->set_content_type("csv");
				$output = $this->load->view('exportdata/csv/paperlist',$this->data,true);
				force_download($filename.".csv",$output);
			break;
			case "xls":
				$output = $this->load->view('exportdata/xls/paperlist',$this->data,true);
				$this->output->set_content_type("xls");
				$this->output->set_header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
				$this->output->set_output($output);
			break;
		}
    }

	function get_finishpapers($conf_id){
		$this->db->from('paper');
		$this->db->join('topic','topic.topic_id = paper.sub_topic');
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->where('paper.sub_status', 5);
		$papers = $this->db->get()->result();
		return $papers;
	}

	function get_finishfiles($conf_id){
    	$this->db->from('paper');
		$this->db->join('topic','topic.topic_id = paper.sub_topic');
		$this->db->join('paper_file','paper_file.paper_id = paper.sub_id');
		$this->db->where('paper.conf_id', $conf_id);
		$this->db->where('paper.sub_status', 5);
		$this->db->where_in('paper_file.file_type', array("FF","FO"));
		$tmp_papers = $this->db->get()->result();
		$papers = array();
		foreach ($tmp_papers as $key => $paper_file) {
			$papers[$paper_file->sub_id] = array();
		}
		foreach ($tmp_papers as $key => $paper_file) {
			array_push($papers[$paper_file->sub_id], $paper_file);
		}
		return $papers;
    }

    function finishfiles($conf_id,$filename){
		$papers   = $this->exportdata->get_finishpapers($conf_id);
		$files    = $this->exportdata->get_finishfiles($conf_id);
		$paperdir = $this->conf->dget_paperdir($conf_id);
		if( empty($filename) ){
			$filename = "finishfiles";
		}
		$data = array();
		foreach ($papers as $key => $paper) {
			foreach($files[$paper->sub_id] as $key => $file){
				$data[$paper->sub_id.'/'.mb_convert_encoding($file->file_name, "UTF-8")] = file_get_contents($paperdir.$file->file_system);
			}
		}
		$this->zip->add_data($data);
		$this->zip->download($filename.'.zip'); // error
    }

    function signup($conf_id,$format,$filename){
    	$this->data['signups'] = $this->conf->get_signups($conf_id);
    	if( empty($filename) ){
			$filename = "signuplist";
		}
		switch($format){
			case "csv":
				$this->output->set_content_type("csv");
				$output = $this->load->view('exportdata/csv/signuplist',$this->data,true);
				force_download($filename.".csv",$output);
			break;
			case "xls":
				$output = $this->load->view('exportdata/xls/signuplist',$this->data,true);
				$this->output->set_content_type("xls");
				$this->output->set_header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
				$this->output->set_output($output);
			break;
		}
    }

}