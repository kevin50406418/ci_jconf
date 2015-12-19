<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_right;?>">
	<div class="ui inverted segment row">
		<a href="<?php echo site_url("sysop/conf");?>" class="btn btn-lg btn-hover btn-primary col-md-3 ui header">
			<i class="fa fa-university fa-5x"></i>
			<br>研討會管理
		</a>
		<a href="<?php echo site_url("sysop/conf/add");?>" class="btn btn-lg btn-hover btn-primary col-md-3 ui header">
			<i class="fa fa-university fa-5x"></i><sup><i class="fa fa-plus-square-o fa-5x"></i></sup>
			<br>新增研討會
		</a>
		<a href="<?php echo site_url("sysop/user/all");?>" class="btn btn-lg btn-hover btn-primary col-md-3 ui header">
			<i class="fa fa-users fa-5x"></i>
			<br>使用者管理
		</a>
		<a href="<?php echo site_url("sysop/user/add");?>" class="btn btn-lg btn-hover btn-primary col-md-3 ui header">
			<i class="fa fa-user-plus fa-5x"></i>
			<br>新增使用者
		</a>
		<a href="<?php echo site_url("sysop/email");?>" class="btn btn-lg btn-hover btn-primary col-md-3 ui header">
			<i class="fa fa-newspaper-o fa-5x"></i>
			<br>電子郵件樣版
		</a>
		<a href="<?php echo site_url("sysop/logout");?>" class="btn btn-lg btn-hover btn-danger col-md-3 ui header">
			<i class="fa fa-sign-out fa-5x"></i>
			<br>登出
		</a>
		<div class="ui orange inverted statistic col-md-3 ui header btn-lg">
			<div class="value" id="ver">
				-
			</div>
			<div class="label">
				系統更新
			</div>
		</div>
	</div>
	<!-- <div class="ui inverted segment text-center">
		<div class="ui inverted yellow statistic">
			<div class="value">
				54
			</div>
			<div class="label">
				研討會正在進行
			</div>
		</div>
	</div>
	<div class="ui inverted segment text-center">
		<div class="ui inverted olive statistic">
			<div class="value">
				12,345
			</div>
			<div class="label">
				篇投稿
			</div>
		</div>
	</div>
	<div class="ui inverted segment text-center">
		<div class="ui inverted brown statistic">
			<div class="value">
				123
			</div>
			<div class="label">
				篇投稿正在審查
			</div>
		</div>
	</div> -->
</div>
<script>
$.getJSON('<?php echo site_url("sysop/version")?>', function(data) {
	$('#ver').html(data.desc+"");
});
</script>
