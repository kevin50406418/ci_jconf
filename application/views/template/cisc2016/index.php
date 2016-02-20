<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
	$old_replace = array(
		'class="table',
		'table-bordered',
		'table-hover'
	);
	$new_replace = array(
		'class="am-table',
		'am-table-bordered',
		'am-table-hover'
	);
	$content->page_content = str_replace($old_replace,$new_replace,strtolower($content->page_content)); 
?>

<?php if(!empty($content)){echo $content->page_content;}?>

