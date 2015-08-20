<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sysop extends MY_Sysop {
	public function __construct(){
		parent::__construct();
	}

	public function index(){

	}

	public function conf($type="all",$conf_id=""){
		if( !empty($conf_id) ){
			switch($type){
				default:
				case "all": // Conference Admin index

				break;
				case "add": // New Conference
					
				break;
			}
		}else{
			switch($type){
				default:
				case "view": // View Conference information

				break;
				case "edit": // Edit Conference information
					
				break;
				case "admin": // auth Conference administrator
					
				break;
			}
		}
	}

	public function user($do="all",$user_login=""){
		if( !empty($user_login) ){
			switch($do){
				default:
				case "view": // view user

				break;
				case "edit": // edit user

				break;
				case "reset": // reset user password

				break;
			}
		}else{
			switch($do){
				case "add":

				break;
				default:
				case "all": // view all users

				break;
			}
		}
	}

	public function login(){
		
	}
}