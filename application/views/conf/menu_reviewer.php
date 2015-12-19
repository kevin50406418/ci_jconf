<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable"><?php echo lang('reviewer_dashboard')?></h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("reviewer",$conf_id,"index")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-list fa-4x"></i><br><?php echo lang('reviewer_paper')?><div class="floating ui red label"><?php echo $reviewer_pedding?></div></a>
			<!--<a href="#" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-exclamation-circle fa-4x"></i><br>審核人手冊</a>-->
		</div>
	</div>
</div>