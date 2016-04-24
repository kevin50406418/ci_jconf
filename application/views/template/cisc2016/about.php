<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="am-article">
	<div class="am-article-hd">
		<h1 class="am-article-title"><i class="fa fa-user-secret"></i> <?php echo $content->page_title;?></h1>
		<?php if( $this->user->is_conf($this->conf_id) ){?>
		<a class="am-btn am-btn-primary am-btn-xs" href="<?php echo get_url("dashboard",$this->conf_id,"website","edit")?>?id=<?php echo $content->page_id?>&lang=<?php echo $content->page_lang?>"><i class="fa fa-pencil"></i> 編輯</a>
		<?php }?>
	</div>
	<div class="am-article-bd">
		<?php
			if(!empty($content)){
				echo $this->theme->replace_content($content->page_content);
			}
		?>

	</div>

</article>
