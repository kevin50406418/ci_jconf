<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(!empty($content)){?>
<article class="am-article">
	<div class="am-article-bd">
		<?php echo $content->page_content;?>
	</div>
</article>
<?php }?>