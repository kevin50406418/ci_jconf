<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
$pg_id = $this->uri->segment(2);
?>
<h1 style="font-weight: bold;"><?php echo $conf_config['conf_name']?></h1>
<div class="ui inverted segment">
<div class="ui inverted secondary pointing menu" id="conf_nav">
	<?php foreach ($conf_content as $key => $content) {?>
		<?php if(in_array($content->page_id,$spage)){?>
		<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a>
		<?php }else{?>
		<?php $pg_id = $this->uri->segment(3);?>
		<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
		<?php }?>
	<?php }?>
	<!--
	<div class="right menu">
		<div class="item">
		    <a class="ui red button" data-toggle="collapse" href="#collapseschedule" aria-expanded="false" aria-controls="collapseschedule">
				重要日期
			</a>
		</div>
	</div>
	-->
</div>
</div>