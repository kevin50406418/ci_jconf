<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="jumbotron ui green message huge massive text-center">
	<h1>登出成功</h1>
	<p>帳號已登出成功</p>
	<p>
		<a class="ui button blue huge" href="<?php echo site_url()?>" role="button"><i class="fa fa-home"></i> 返回首頁</a>
		<a class="ui brown button huge" href="<?php echo site_url('/user/login')?>" role="button"><i class="fa fa-user"></i>重新登入</a>
	</p>
	<!--<meta content="3; url=<?php echo site_url()?>" http-equiv="refresh">-->
</div>