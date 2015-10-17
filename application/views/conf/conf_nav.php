<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 style="font-weight: bold;"><?php echo $conf_config['conf_name']?></h1>
<div class="ui inverted segment">

<div class="ui inverted secondary pointing menu">
	<a class="item" href="<?php echo get_url("index",$conf_config['conf_id']);?>">
		首頁
	</a>
	<?php if( $this->user->is_login() ){?>
	<a class="item" href="<?php echo get_url("main",$conf_config['conf_id']);?>">
		<?php echo lang('submit_system')?>
	</a>
	<?php }?>
	<a class="item" href="<?php echo get_url("news",$conf_config['conf_id']);?>">
		<?php echo lang('submit_news')?>
	</a>
	<?php foreach ($conf_content as $key => $content) {?>
		<?php if(in_array($content->page_id,$spage)){?>
		<a class="item" href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a>
		<?php }else{?>
		<a class="item" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
		<?php }?>
	<?php }?>
	<div class="right menu">
		<div class="item">
		    <a class="ui red button" data-toggle="collapse" href="#collapseschedule" aria-expanded="false" aria-controls="collapseschedule">
				重要日期
			</a>
		</div>
	</div>
</div>
</div>