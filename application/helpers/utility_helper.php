<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function asset_url($dir = ""){
	return site_url().'assets/'.$dir;
}

function template_url($template,$script){
	return asset_url('template/'.$template."/".$script);
}

if ( ! function_exists('schedule_dates')){
	function schedule_dates($timestamp){
		return date("Y-m-d",$timestamp);
	}
}

function sp($text=""){
	echo '<pre>';
	print_r($text);
	echo '</pre>';
}

function get_url($page='',$conf_id='',$act='',$id='',$step=''){
	$url=array();
	$return="/";
	if(!empty($conf_id)){
		$url['conf_id']=$conf_id;
	}
	if(!empty($page)){
		$url['page']=$page;
	}
	if(!empty($act) && !empty($page)){
		$url['act']=$act;
	}
	
	if(!empty($id) && !empty($act) && !empty($page)){
		$url['id']=$id;
	}
	if(!empty($step) && !empty($id) && !empty($act) && !empty($page)){
		$url['step']=$step;
	}
	
	$i=0;
	foreach($url as $key =>$v){
		if($i>0){
			$return.="/";
		}
		$return.=$v;
		$i++;
	}
	return site_url($return);
}

function js_alert($text,$refresh=-1) {
	echo '<script>';
	echo 'alert("'.$text.'");';
	echo '</script>';
	if($refresh!=-1){
		echo '<meta http-equiv="refresh" content="0; url='.$refresh.'" />';
	}
}

function new_alert($type='i',$text,$refresh=-1) {
	$class="";
	switch($type){
		case 's':
			$class="positive";
		break;
		case 'd':
			$class="negative";
		break;
		case 'w':
			$class="warning";
		break;
		case 'bk':
			$class="black";
		break;
		case 'y':
			$class="yellow";
		break;
		case 'g':
			$class="green";
		break;
		case 'b':
			$class="blue";
		break;
		case 'o':
			$class="orange";
		break;
		case 'pp':
			$class="purple";
		break;
		case 'pk':
			$class="pink";
		break;
		case 't':
			$class="teal";
		break;
		case 'r':
			$class="red";
		break;
		default:
			$class="info";
		break;
	}
	echo '<div class="ui message '.$class.'">';
	echo $text;
	if($refresh>0){
		echo "<meta http-equiv=\"refresh\" content=\"".$refresh."\">";
	}
	echo "</div>";
	
}

function arrayLevel($arr){ 
	$al = array(0); 
	function aL($arr,&$al,$level=0){ 
		if(is_array($arr)){ 
			$level++; 
			$al[] = $level; 
			foreach($arr as $v){ 
				aL($v,$al,$level); 
			} 
		} 
	} 
	aL($arr,$al); 
	return max($al); 
} 

function active_confnav($now_page_id,$page_id,$active){
	$sys_submit = array("dashboard","main","submit","topic","reviewer");
	$sys_index = array("index");
	$sys_news = array("news");

	if( in_array($now_page_id, $sys_submit) ){
		foreach ($sys_submit as $key => $sys_submits) {
			if($page_id == "main"){return $active;}
		}
	}else if( in_array($now_page_id, $sys_index) ){
		foreach ($sys_index as $key => $sys_indexs) {
			if( $now_page_id == $page_id) return $active;
		}
	}else if( in_array($now_page_id, $sys_news) ){
		foreach ($sys_news as $key => $sys_newss) {
			if( $now_page_id == $page_id) return $active;
		}
	}else{
		if( $now_page_id == $page_id) return $active;
	}
}

function is_login(){
	$ci =&get_instance();
	return $ci->user->is_login();
}

function get_current_user_login(){
	$ci =&get_instance();
	return $ci->session->user_login;
}

function date_showmethod($showmethod,$start,$end,$sep="~"){
	$str = "";
	switch($showmethod){
		case 1: //顯示開始日期
			$str = $start;
		break;
		case 2: //顯示結束日期
			$str = $end;
		break;
		case 3: //顯示所有日期
			$str = $start.$sep.$end;
		break;
	}
	return $str;
}

function langabbr2str($abbr){
	switch($abbr){
		case "zhtw":
			echo "繁體中文(Traditional Chinese)";
		break;
		case "en":
			echo "英文(English)";
		break;
		default:
			echo "-";
	}
}

function get_fileicon($mime){
	$return = "";
	switch($mime){
		case "application/pdf":
			$return = "file-pdf-o";
		break;
		case 'application/vnd.ms-excel':
		case 'application/msexcel':
		case 'application/x-msexcel':
		case 'application/x-ms-excel':
		case 'application/x-excel':
		case 'application/x-dos_ms_excel':
		case 'application/xls':
		case 'application/x-xls':
		case 'application/excel':
		case 'application/vnd.ms-office':
		case 'application/vnd.ms-excel':
		case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
			$return = "file-excel-o";
		break;
		case 'application/msword':
		case 'application/vnd.ms-office':
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			$return = "file-word-o";
		break;
		case 'application/x-zip':
		case 'application/zip':
		case 'application/x-zip-compressed':
		case 'application/s-compressed':
		case 'multipart/x-zip':
		case 'application/x-rar':
		case 'application/rar':
		case 'application/x-rar-compressed':
		case 'application/x-compressed':
		case 'application/x-zip-compressed':
		case 'multipart/x-zip':
			$return = "file-archive-o";
		break;
		case 'image/bmp':
		case 'image/x-bmp':
		case 'image/x-bitmap':
		case 'image/x-xbitmap':
		case 'image/x-win-bitmap':
		case 'image/x-windows-bmp':
		case 'image/ms-bmp':
		case 'image/x-ms-bmp':
		case 'application/bmp':
		case 'application/x-bmp':
		case 'application/x-win-bitmap':
		case 'image/gif':
		case 'image/jpeg':
		case 'image/pjpeg':
		case 'image/png':
		case 'image/x-png':
			$return = "file-image-o";
		break;
		case 'text/plain':
		case 'text/x-log':
			$return = "file-text-o";
		break;
		default:
			$return = "file";
	}
	return $return;
}

define("EXCL", true);
define("BEFORE", true);
define("AFTER", false);    

function get_basename($filename){
	return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}

function split_string($string, $delineator, $desired, $type){
	$lc_str = strtolower($string);
	$marker = strtolower($delineator);
	
	if($desired == BEFORE){
		if($type == EXCL){
			$split_here = strpos($lc_str, $marker);
		}else{
			$split_here = strpos($lc_str, $marker)+strlen($marker);
		}
		
		$parsed_string = substr($string, 0, $split_here);
	}else{
		if($type==EXCL){
			$split_here = strpos($lc_str, $marker) + strlen($marker);
		}else{
			$split_here = strpos($lc_str, $marker) ;
		}
		
		$parsed_string =  substr($string, $split_here, strlen($string));
   }
	return $parsed_string;
}

function return_between($string, $start, $stop, $type=EXCL){
	$temp = split_string($string, $start, AFTER, $type);
	return split_string($temp, $stop, BEFORE, $type);
}

function parse_args( $args, $defaults = '' ) {
	if ( is_object( $args ) ){
		$r = get_object_vars( $args );
	}elseif ( is_array( $args ) ){
		$r =& $args;
	}else{
		parse_args( $args, $r );
	}

	if ( is_array( $defaults ) ){
		return array_merge( $defaults, $r );
	}
	return $r;
}

function file_type($file_type){
	$type_name = "";
	switch($file_type){
		case "FF":
			$type_name = "論文完稿";
		break;
		case "FO":
			$type_name = "完稿補充檔案";
		break;
		case "FC":
			$type_name = "Copyright Form";
		break;
		case "FA":
			$type_name = "論文摘要檔";
		break;
		case "F":
			$type_name = "投稿資料";
		break;
		case "O":
			$type_name = "補充資料";
		break;
	}
	return $type_name;
}