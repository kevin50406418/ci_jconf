<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model{
    public function __construct(){
		parent::__construct();
    }

    public function help(){

    }

    public function replace_content($content){
    	return $content;
    }
}
?>