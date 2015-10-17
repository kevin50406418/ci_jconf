<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable"><?php echo lang('submit_system')?></h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("submit",$conf_id,"add")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-pencil-square-o fa-4x"></i><br><?php echo lang('submit_add')?></a>
			<a href="<?php echo get_url("submit",$conf_id)?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-list fa-4x"></i><br><?php echo lang('submit_list')?></a>
			<?php if($conf_config['conf_most'] == 1 ){?><a href="<?php echo get_url("submit",$conf_id,"most")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-university fa-4x"></i><br>科技部成果發表</a><?php }?>
			<a href="<?php echo get_url("submit",$conf_id,"register")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-sign-in fa-4x"></i><br><?php echo lang('submit_signup')?></a>
			<a href="<?php echo get_url("news",$conf_id)?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-bullhorn fa-4x"></i><br><?php echo lang('submit_news')?></a>
		</div>
	</div>
</div>