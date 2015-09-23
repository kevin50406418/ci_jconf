<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_nav;?>">
<nav class="navbar navbar-inverse sidebar">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">系統管理</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!--<li><a href="<?php echo base_url("sysop/setting");?>">系統設定</a></li>-->
				<li class="dropdown<?php if($active=="conf"){?> open<?php }?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-university pull-right"></i> 研討會 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li<?php if($active=="conf" && ( empty($do) || $do =="all")){?> class="active"<?php }?>><a href="<?php echo base_url("sysop/conf");?>">研討會管理</a></li>
						<li><a href="<?php echo base_url("sysop/conf/add");?>">新增研討會</a></li>
					</ul>
				</li>
				<li class="dropdown<?php if($active=="user"){?> open<?php }?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users pull-right"></i> 使用者 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url("sysop/user/all");?>">使用者管理</a></li>
						<li><a href="<?php echo base_url("sysop/user/add");?>">新增使用者</a></li>
						<li><a href="<?php echo base_url("sysop/user/import");?>">匯入使用者</a></li>
					</ul>
				</li>
				<li><a href="<?php echo base_url("sysop/logout");?>"><i class="fa fa-sign-out pull-right"></i> 登出</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
</div>