<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container"> 
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user_nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<?php if($this->cinfo['show_confinfo']){?>
			<a class="navbar-brand" href="<?php echo get_url("main",$conf_config['conf_id']);?>"><i class="fa fa-bookmark"></i> <?php echo $conf_config['conf_name']?></a>
			<?php }else{?>
			<a class="navbar-brand" href="<?php echo site_url();?>">亞大研討會系統</a>
			<?php }?>
		</div>
		<div class="collapse navbar-collapse" id="user_nav">
			<?php if($this->cinfo['show_confinfo']){?>
			<a class="btn btn-danger navbar-btn" data-toggle="modal" data-target="#conf_schedule">重要日期</a>
			<?php }?>
			<?php if($this->user->is_login()){?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('hello_user')?><?php echo $this->session->user_login;?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo site_url('user/index');?>"><?php echo lang('nav_user_edit')?></a></li>
						<li><a href="<?php echo site_url('user/passwd');?>"><?php echo lang('nav_user_passwd')?></a></li>
						<li><a href="<?php echo site_url('user/log');?>"><?php echo lang('nav_user_log')?></a></li>
						<li><a href="<?php echo site_url('user/paper');?>"><?php echo lang('nav_user_paper')?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('user/logout');?>"><?php echo lang('nav_user_logout')?></a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<?php if($this->cinfo['show_confinfo']){?>
				<li><a href="<?php echo site_url();?>"><i class="fa fa-home fa-lg"></i> 所有研討會</a></li>
			<?php }?>
			<?php if($this->user->is_sysop()){?>
				<li><a href="<?php echo site_url("sysop");?>"><?php echo lang('nav_sysop')?></a></li>
			<?php }?>
			</ul>
			<?php }else{?>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo site_url('user/login');?>"><?php echo lang('nav_login')?></a></li>
				<li><a href="<?php echo site_url('user/signup');?>"><?php echo lang('nav_signup')?></a></li>
			</ul>
			<?php }?>
		</div>
	</div>
</nav>
<!---fluid-->
<div class="<?php echo $body_class?>">
	<div class="row">