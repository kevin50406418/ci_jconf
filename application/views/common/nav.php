<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container"> 
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<?php if($this->cinfo['show_confinfo']){?>
			<a class="navbar-brand" href="<?php echo base_url("main/".$conf_config['conf_id']);?>"><i class="fa fa-university"></i> <?php echo $conf_config['conf_name']?></a>
			<?php }else{?>
			<a class="navbar-brand" href="<?php echo base_url();?>">亞大研討會系統</a>
			<?php }?>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php if($this->user->is_login()){?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">您好，<?php echo $this->session->user_login;?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">編輯個人資料</a></li>
						<li><a href="#">個人登入紀錄</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url('user/logout');?>">登出</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<?php if($this->cinfo['show_confinfo']){?>
				<li><a href="<?php echo base_url();?>"><i class="fa fa-home fa-lg"></i> 首頁</a></li>
			<?php }?>
			<?php if($this->user->is_sysop()){?>
				<li><a href="<?php echo base_url("sysop");?>">系統管理</a></li>
			<?php }?>
			</ul>
			<?php }else{?>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo base_url('user/login');?>">登入</a></li>
				<li><a href="<?php echo base_url('user/signup');?>">註冊</a></li>
			</ul>
			<?php }?>
		</div>
	</div>
</nav>
<!---fluid-->
<div class="<?php echo $body_class?>">
	<div class="row">