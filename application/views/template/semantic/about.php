<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
	$old_replace = array(
		'<table',
		'class="table',
		'table-bordered',
		'table-hover'
	);
	$new_replace = array(
		'<table class="table celled"',
		'class="ui table',
		'celled',
		'selectable'
	);
	$content->page_content = str_replace($old_replace,$new_replace,strtolower($content->page_content)); 
?>
<div class="col-md-3">
	<h2 class="ui center aligned segment attached orange inverted">
		最新公告
	</h2>
	<?php foreach ($conf_news as $key => $news) {?>
	<div class="ui segment attached">
		<h4 class="ui header"><?php echo $news->news_title;?></h4>
		<p><?php echo $news->news_content;?></p>
	</div>
	<?php }?>
</div>
<div class="col-md-9">
	<h1 class="ui center aligned segment attached blue inverted">
		<?php echo $content->page_title;?>
	</h1>
	<div class="ui padded segment attached">
		<?php if(!empty($content)){echo $content->page_content;}?>
	</div>
</div>