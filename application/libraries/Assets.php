<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Assets{
	protected $CI;
	protected $_meta_tags = array();
	protected $_styles = array();
	protected $_scripts_header = array();
    protected $_scripts_footer = array();
	protected $head_add = '';
	protected $_title = '';
    protected $_title_separator = '-';
    protected $site_name = '亞大研討會系統';
	
    function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('utility');
		
		log_message('debug', 'HTML Class Initialized');
	}

    public function set_title($title){
        $this->_title = $title;

    }

	public function add_css($href = NULL, $media = 'screen'){
        $link = array(
            'href' => $href,
            'rel' => 'stylesheet',
            'type' => 'text/css'
        );

        if (!empty($media)) {
            $link['media'] = $media;
        }

        $this->_styles[] = link_tag($link);
    }

    public function add_js($src, $is_footer = FALSE){
        if (!$is_footer) {
            $this->_scripts_header[] = $this->script_tag($src);
        } else {
            $this->_scripts_footer[] = $this->script_tag($src);
        }
    }

    private function script_tag($src = NULL){
        if (isset($src) and !empty($src)) {
            return '<script src="' . $src . '" type="text/javascript"></script>';
        }

        return "";
    }

    private function get_title(){
        return $this->_title.$this->_title_separator.$this->site_name;
    }

    public function add_meta_tag($name, $value, $key = "name"){
        if ($name == 'canonical') {
            $this->_meta_tags[] = '<link rel="canonical" href="' . $value . '" />';
        } else {
            $this->_meta_tags[] = '<meta ' . $key . '="' . $name . '" content="' . $value . '" />';
        }

        return $this;
    }

    public function show_css(){
    	foreach ($this->_styles as $key => $value) {
    		echo $value;
    	}
    }

    public function show_js($is_footer = FALSE){
    	if (!$is_footer) {
    		foreach ($this->_scripts_header as $key => $value) {
	    		echo $value."\n";
	    	}
        } else {
        	foreach ($this->_scripts_footer as $key => $value) {
	    		echo $value."\n";
	    	}
        }
    }

    public function show_meta(){
    	foreach ($this->_meta_tags as $key => $value) {
    		echo $value."\n";
    	}
    }

    public function show_title(){
        echo "<title>";
        echo $this->get_title();
        echo "</title>";
    }
}