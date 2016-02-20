<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(!empty($content)){?>
<article class="am-article">
	<?php if( $this->user->is_conf($this->conf_id) ){?>
		<a class="am-btn am-btn-primary am-btn-xs" href="<?php echo get_url("dashboard",$this->conf_id,"website","edit")?>?id=<?php echo $content->page_id?>&lang=<?php echo $content->page_lang?>"><i class="fa fa-pencil"></i> 編輯</a>
	<?php }?>
	<div class="am-article-bd">
		<?php echo $content->page_content;?>
	</div>
	
</article>
<?php }?>