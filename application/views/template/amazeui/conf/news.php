<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
	<a href="#" class="am-btn am-btn-warning am-fr am-btn-xs"><i class="fa fa-rss"></i></a>
	<h2><i class="fa fa-bullhorn"></i> 最新公告</h2>
</div>
<?php foreach ($conf_news as $key => $news) {?>
<section class="am-panel am-panel-primary" id="<?php echo $news->news_id;?>">
	<header class="am-panel-hd">
		<span class="am-fr">
			<span class="am-badge am-badge-warning">
				<i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i",$news->news_posted);?>
			</span>
			<a href="#<?php echo $news->news_id;?>" class="am-badge am-badge-success">
				<i class="fa fa-link"></i>
			</a>
		</span>
		<h3 class="am-panel-title">
			<?php echo $news->news_title;?>
		</h3>
	</header>
	<div class="am-panel-bd">
		<?php echo $news->news_content;?>
	</div>
</section>
<?php }?>
