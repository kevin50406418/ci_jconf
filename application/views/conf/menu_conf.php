<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable"><?php echo lang('conf_dashboard')?></h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("dashboard",$conf_id,"setting")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-tachometer fa-4x"></i><br><?php echo lang('dashboard_setting')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"website")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-home fa-4x"></i><br><?php echo lang('dashboard_website')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-archive fa-4x"></i><br><?php echo lang('dashboard_topic')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"user")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-user fa-4x"></i><br><?php echo lang('dashboard_user')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"news")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-bullhorn fa-4x"></i><br><?php echo lang('dashboard_news')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"filter")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-filter fa-4x"></i><br><?php echo lang('dashboard_filter')?></a>
			<!--<a href="<?php echo get_url("dashboard",$conf_id,"modules")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-cogs fa-4x"></i><br>模組管理</a>-->
			<a href="<?php echo get_url("dashboard",$conf_id,"email")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-newspaper-o fa-4x"></i><br><?php echo lang('dashboard_email')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"submit")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-list fa-4x"></i><br><?php echo lang('dashboard_submit')?></a>
			<?php if($conf_config['conf_most'] == 1 ){?><a href="<?php echo get_url("dashboard",$conf_id,"most")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-university fa-4x"></i><br>科技部成果發表</a><?php }?>
			<!-- <a href="<?php echo get_url("dashboard",$conf_id,"export")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-download fa-4x"></i><br>資料匯出</a> -->
			<a href="<?php echo get_url("dashboard",$conf_id,"logs")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-shield fa-4x"></i><br><?php echo lang('dashboard_logs')?></a>
			<!--<a href="<?php echo get_url("dashboard",$conf_id,"register")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-sign-in fa-4x"></i><br><?php echo lang('dashboard_signup')?></a>
			<a href="<?php echo get_url("dashboard",$conf_id,"report")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-line-chart fa-4x"></i><br><?php echo lang('dashboard_report')?></a>-->
		</div>
	</div>
</div>