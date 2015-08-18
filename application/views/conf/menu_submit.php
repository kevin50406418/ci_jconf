<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title clickable">投稿作業</h3>
	</div>
	<div class="panel-body">
		<div class="text-center row">
			<a href="<?php echo get_url("submit",$conf_id,"add")?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-pencil-square-o fa-4x"></i><br>投稿</a>
			<a href="<?php echo get_url("submit",$conf_id)?>" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-list fa-4x"></i><br>投稿清單</a>
			<a href="#" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-sign-in fa-4x"></i><br>研討會註冊</a>
			<a href="#" class="btn btn-lg btn-hover btn-olive col-md-2"><i class="fa fa-bullhorn fa-4x"></i><br>最新公告</a>
		</div>
	</div>
</div>