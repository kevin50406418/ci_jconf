<?php defined('BASEPATH') OR exit('No direct script access allowed.');
class Alert_model extends CI_Model {
	function __construct(){
		parent::__construct();
    }

    function show($type='i',$text,$refresh=-1){
		$data['class']   = "";
		$data['text']    = $text;
		$data['refresh'] = $refresh;
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
		$this->load->view('common/alert',$data);
    }

    function js($text,$refresh=-1){
    	$data['refresh'] = $refresh;
		$data['text']    = $text;
		$this->load->view('common/js_alert',$data);
    }

    function refresh($refresh){
    	$data['refresh'] = $refresh;
    	$this->load->view('common/refresh',$data);
    }
}