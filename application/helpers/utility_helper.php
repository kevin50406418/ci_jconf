<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function asset_url($dir = ""){
	return base_url().'assets/'.$dir;
}

function template_url($template,$script){
	return asset_url('template/'.$template."/".$script);
}

if ( ! function_exists('schedule_dates')){
	function schedule_dates($timestamp){
		return date("Y-m-d",$timestamp);
	}
}

function sp($text){
	echo '<pre>';
	print_r($text);
	echo '</pre>';
}

function get_url($page='',$conf_id='',$act='',$id='',$step=''){
	$url=array();
	$return="";
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
	return base_url($return);
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