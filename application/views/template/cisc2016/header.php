<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
$pg_id = $this->uri->segment(2);
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<!-- <title><?php echo $conf_config['conf_name']?></title> -->
<?php echo link_tag(get_url("rss",$conf_id), 'alternate', 'application/rss+xml', $conf_config['conf_name'].' RSS Feed')?>
<?php echo $this->assets->show_title()?>
<?php echo $this->assets->show_meta()?>
<?php echo link_tag(template_url('amazeui','amazeui.min.css'));?>
<?php echo link_tag(template_url('amazeui','style.css'));?>
<?php echo link_tag(asset_url().'style/font-awesome.min.css');?>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!--<![endif]-->
<script src="<?php echo template_url('amazeui','amazeui.min.js')?>" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>
<body>
<header class="am-topbar am-topbar-fixed-top am-topbar-inverse">
	<h1 class="am-topbar-brand">
		<a href="<?php echo site_url($conf_config['conf_id']);?>"><?php echo $conf_config['conf_name']?></a>
	</h1>
	<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only" data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">導航切換</span> <i class="fa fa-bars"></i></button>
	<div class="am-collapse am-topbar-collapse" id="collapse-head">
		<ul class="am-nav am-nav-pills am-topbar-nav">
			<?php foreach ($conf_content as $key => $content) {?>
			<?php if(in_array($content->page_id,$spage)){?>
			<li class="<?php echo active_confnav($pg_id,$content->page_id,"am-active")?>"><a href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a></li>
			<?php }else{?>
			<?php $pg_id = $this->uri->segment(3);?>
			<li class="<?php echo active_confnav($pg_id,$content->page_id,"am-active")?>"><a href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
			<?php }?>
			<?php }?>
		</ul>
		<div class="am-topbar-right">
			<a href="#" class="am-btn am-btn-danger am-topbar-btn am-btn-sm am-round" data-am-modal="{target: '#schedule', closeViaDimmer: 0, width: 400, height: 225}"><i class="fa fa-calendar"></i> 重要日期</a>
			<?php if( is_login() ){?>
			<div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
				<a class="am-btn am-btn-primary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>您好，<?php echo get_current_user_login()?> <i class="fa fa-caret-down"></i></a>
				<ul class="am-dropdown-content">
					<li><a href="<?php echo site_url('user/index');?>">編輯個人資料</a></li>
					<li><a href="<?php echo site_url('user/passwd');?>">更改密碼</a></li>
					<li><a href="<?php echo site_url('user/log');?>">個人登入紀錄</a></li>
					<li class="am-divider"></li>
					<li><a href="<?php echo site_url('user/logout');?>">登出</a></li>
				</ul>
			</div>
			<?php }else{?>
			<a href="<?php echo site_url("user/login")?>" class="am-btn am-btn-success am-topbar-btn am-btn-sm">登入</a>
			<?php }?>
		</div>
	</div>
</header>
<div class="get">
	<div class="am-g">
		<div class="am-u-lg-12">
			<h1 class="get-title"><?php echo $conf_config['conf_name']?></h1>
			<p class="time">
				<?php if( $schedule['hold']['start'] == $schedule['hold']['end']){?>
					<?php echo $schedule['hold']['end']?>
				<?php }else{?>
					<?php echo $schedule['hold']['start']?> ~ <?php echo $schedule['hold']['end']?>
				<?php }?>
			</p>
			<p class="place"><i class="fa fa-map-marker fa-lg"></i> 大會地點: <?php echo $conf_config['conf_place']?></p>
		</div>
	</div>
</div>
<div class="header-logo">
</div>
<div class="container">
	<div class="am-g">

