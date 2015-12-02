<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Alert_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function show($type='i',$text,$refresh=-1,$header="",$class=""){
		$data['class']   = "";
		$data['text']    = $text;
		$data['refresh'] = $refresh;
		$data['header'] = $header;

		switch($type){
			case 's':
				$data['class']="positive";
			break;
			case 'd':
				$data['class']="negative";
			break;
			case 'w':
				$data['class']="warning";
			break;
			case 'bk':
				$data['class']="black";
			break;
			case 'y':
				$data['class']="yellow";
			break;
			case 'g':
				$data['class']="green";
			break;
			case 'b':
				$data['class']="blue";
			break;
			case 'o':
				$data['class']="orange";
			break;
			case 'pp':
				$data['class']="purple";
			break;
			case 'pk':
				$data['class']="pink";
			break;
			case 't':
				$data['class']="teal";
			break;
			case 'r':
				$data['class']="red";
			break;
			default:
				$data['class']="info";
			break;
		}
		$data['class'].= $class;
		$this->load->view('common/alert',$data);
    }

    function js($text,$refresh=-1){
    	$data['refresh'] = $refresh;
		$data['text']    = $text;
		$this->load->view('common/js_alert',$data);
    }

    function refresh($refresh,$to =''){
    	$data['refresh'] = $refresh;
    	$data['to'] = $to;
    	$this->load->view('common/refresh',$data);
    }

    function file_notfound($refresh){
    	$this->js("找不到檔案",$refresh);
		$this->output->_display();
		exit;
    }

    function js_refresh(){
    	$this->load->view('common/js_refresh');
    }

    function message($header="",$text,$type='i',$refresh=-1,$icon="-",$class=""){
		$data['class']   = "";
		$data['text']    = $text;
		$data['refresh'] = $refresh;
		$data['header']  = $header;
		$data['icon']    = $icon;

		switch($type){
			case 'g':
				$data['class']="green";
			break;
			case 's':
				$data['class']="positive";
			break;
			case 'r':
				$data['class']="red";
			break;
			case 'd':
				$data['class']="negative";
			break;
			case 'w':
				$data['class']="warning";
			break;
			case 'bk':
				$data['class']="black";
			break;
			case 'y':
				$data['class']="yellow";
			break;
			case 'b':
				$data['class']="blue";
			break;
			case 'o':
				$data['class']="orange";
			break;
			case 'pp':
				$data['class']="purple";
			break;
			case 'pk':
				$data['class']="pink";
			break;
			case 't':
				$data['class']="teal";
			break;
			default:
				$data['class']="info";
			break;
		}
		$data['class'].= " ".$class;
		$this->load->view('common/message',$data);
    }
}