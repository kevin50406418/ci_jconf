<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui raised segments">
	<div class="modal-header">
		<h3 class="modal-title">最新公告</h3>
	</div>
	<?php foreach ($conf_news as $key => $news) {?>
	<div class="ui segment">
		<a data-toggle="collapse" href="#collapseExample<?php echo $news->news_id;?>" aria-expanded="false">
			<span class="pull-left"></span><?php echo date("Y-m-d",$news->news_posted);?> <?php echo $news->news_title;?>
		</a>
		<div class="collapse" id="collapseExample<?php echo $news->news_id;?>">
			<?php echo $news->news_content;?>
		</div>
	</div>
	<?php }?>
</div>
