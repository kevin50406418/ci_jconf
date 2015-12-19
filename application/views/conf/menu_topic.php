<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable"><?php echo lang('topic_dashboard')?></h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("topic",$conf_id,"index")?>" class="btn btn-lg btn-hover col-md-2 btn-olive"><i class="fa fa-archive fa-4x"></i><br><?php echo lang('topic_assign')?><div class="floating ui red label"><?php echo $topic_pedding?></div></a>
			<?php if($conf_config['topic_assign']){?><a href="<?php echo get_url("topic",$conf_id,"users")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-users fa-4x"></i><br><?php echo lang('topic_reviewer_assign')?></a><?php }?>
			<!--<a href="#" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-exclamation-circle fa-4x"></i><br>主題主編手冊</a>-->
		</div>
	</div>
</div>