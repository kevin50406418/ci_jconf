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
<!-- <div class="col-md-3">
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
-->

<article class="am-article">
	<div class="am-article-hd">
		<h1 class="am-article-title"><i class="fa fa-user-secret"></i> <?php echo $content->page_title;?></h1>
		<?php if( $this->user->is_conf($this->conf_id) ){?>
		<a class="am-btn am-btn-primary am-btn-xs" href="<?php echo get_url("dashboard",$this->conf_id,"website","edit")?>?id=<?php echo $content->page_id?>&lang=<?php echo $content->page_lang?>"><i class="fa fa-pencil"></i> 編輯</a>
	<?php }?>
	</div>
	<div class="am-article-bd">
		<?php if(!empty($content)){echo $content->page_content;}?>
	</div>

</article>
