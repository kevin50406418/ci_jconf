<?php defined('BASEPATH') OR exit('No direct script access allowed.');

class Amazeui_model extends MY_Model {
	function __construct(){
		parent::__construct();
	}

	function replace_content($content){
		$old_replace = array(
			'class="table',
			'table-bordered',
			'table-hover',
			'{tabs}',
			'{/tabs}'
		);
		$new_replace = array(
			'class="am-table',
			'am-table-bordered',
			'am-table-hover',
			'',
			''
		);
		$content = str_replace($old_replace,$new_replace,strtolower($content)); 
		if( preg_match_all("/{tab=.+?}{tab=.+?}|{tab=.+?}|{\/tabs}/",$content,$matches, PREG_PATTERN_ORDER)>0 ){
			echo '<!-- start tab--><div class="am-tabs" data-am-tabs>'."\n";
				echo '<ul class="am-tabs-nav am-nav am-nav-tabs">'."\n";
				foreach ($matches[0] as $key => $matche) {
					$active = $key==0?' class="am-active"':"";
					echo '<li'.$active.'>';
					echo '<a href="#tab'.$key.'">'.return_between($matche, "{tab=", "}").'</a>';
					echo '</li>'."\n";
				}
				echo '</ul>'."\n";
				echo '<div class="am-tabs-bd">';
					foreach ($matches[0] as $key => $matche) {
						$active = $key==0?" am-in am-active":"";
						$content = str_replace($matche, '<div class="am-tab-panel am-fade'.$active.'" id="tab'.$key.'">'."\n", $content);
						$content = str_replace("{/tab}", '</div>'."\n", $content);
					}
				echo $content;
				echo '</div>';
			echo '</div><!-- end tab-->';
		}
		return $content;
	}

}