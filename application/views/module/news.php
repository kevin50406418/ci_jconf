<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui raised segments">
	<?php if($module_showtitle){?>
	<div class="ui segment">
		<h3 class="ui header"><?php echo $module_title?></h3>
	</div>
	<?php }?>
	<?php foreach ($news as $key => $new) {?>
	<div class="ui segment">
		<a data-toggle="collapse" href="#collapseExample<?php echo $new->news_id;?>" aria-expanded="false">
			<span class="pull-left"></span><?php echo date("Y-m-d",$new->news_posted);?> <?php echo $new->news_title;?>
		</a>
		<div class="collapse" id="collapseExample<?php echo $new->news_id;?>">
			<?php echo $new->news_content;?>
		</div>
	</div>
	<?php }?>
</div>

