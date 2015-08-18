<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable">研討會管理</h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("dashboard",$conf_id,"setting")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-tachometer fa-4x"></i><br>控制台</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"website")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-home fa-4x"></i><br>網頁管理</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-archive fa-4x"></i><br>主題管理</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"user")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-user fa-4x"></i><br>使用者管理</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"news")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-bullhorn fa-4x"></i><br>公告管理</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"filter")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-filter fa-4x"></i><br>投稿檢核清單</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"email")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-newspaper-o fa-4x"></i><br>電子郵件樣版</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"submit")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-list fa-4x"></i><br>所有稿件</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"signup")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-sign-in fa-4x"></i><br>註冊管理</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"report")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-line-chart fa-4x"></i><br>統計報告</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"logs")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-shield fa-4x"></i><br>日誌</a>
		</div>
	</div>
</div>