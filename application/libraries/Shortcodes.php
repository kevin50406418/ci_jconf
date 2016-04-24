<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shortcodes{
	protected $CI;
	
    function __construct(){
		$this->CI =& get_instance();
		
		log_message('debug', 'Shortcodes Class Initialized');
	}

	public function parse($str){
		// check for existing shortcodes
		if( !strstr($str,$this->left_delimter.'jc:') ){
			return $str;
		}

		preg_match_all('/\[jc:(a-zA-Z0-9-_: |=\.)+]/',$str,$shortcodes);

		// Tidy up
		if( $shortcodes == NULL ){
			return $str;
		}

		foreach ($shortcodes[1] as $key => $shortcode) {
			if( strstr($shortcode,'') ){
				$code = substr($shortcode,0,strpos($shortcode,' '));
				$tmp = explode('|',str_replace($code.' ','',$shortcode));
				$params = array();
				if( count($tmp) ){
					foreach ($tmp as $param) {
						$pair = explode('=',$param);
						$params[$pair[0]] = $$pair[1];
					}
				}
				$array = array('code'=>$code,'params'=>$params);
			}else{
				$array = array('code'=>$shortcode,'params'=>array());
			}
			$shortcode_array[$shortcodes[0][$key]] = $array;
		}

		//replace shortcodes with HTML string
		if( count($shortcode_array)){
			$path = realpath(APPPATH.'models/shortcodes/').'/';

			foreach ($shortcode_array as $search => $shortcode) {
				$shortcode_model = $shortcode['code'];
				if( file_exists($path.$shortcode_model."_model.php") && is_file($path.$shortcode_model."_model.php") ){
					$shortcode_model = $shortcode_model."_model";
					$this->CI->load->model('shortcodes/'.$shortcode_model);
					$str = str_replace($search, $this->CI->$shortcode_model->run($shortcode['params']),$str);
				}
			}
		}
		return $str;
	}
}