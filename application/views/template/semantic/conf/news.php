<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="ui center aligned segment attached orange inverted">
	最新公告
</h2>
<?php foreach ($conf_news as $key => $news) {?>
<div class="ui segment attached">
	
	<h4 class="ui header"><?php echo $news->news_title;?></h4>
	<div></div>
	<p><?php echo $news->news_content;?></p>
</div>
<?php }?>