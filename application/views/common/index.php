<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

	<?php if(is_array($confs)){?>
	<?php foreach ($confs as $key => $conf) {?>
	<?php if( !in_array($conf->conf_id,$test_conf)){?>
	
		<div class="ui segment teal">
			<h3 class="text-bold">
				<?php if( $this->user->is_sysop() ){?>
					<?php if( $conf->conf_staus == 1 ){?>
					<span class="ui basic label pink">隱藏</span>
					<?php }?>
				<?php }?>
				<?php echo $conf->conf_name?>
			</h3>
			<p>
				<?php echo mb_substr( $conf->conf_desc,0,150,"utf-8")?><?php if(mb_strlen($conf->conf_desc)>150){?>...<?php }?>
			</p>
			<?php if( !empty($conf->conf_place) ){?><p><i class="fa fa-map-marker"></i> <?php echo $conf->conf_place?></p><?php }?>
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<a class="btn btn-primary btn-lg" href="<?php echo get_url("index",$conf->conf_id);?>"><i class="fa fa-home icon fa-lg"></i> 研討會首頁</a>
				</div>
				<div class="btn-group" role="group">
					<a class="btn btn-navy btn-lg" href="<?php echo get_url("main",$conf->conf_id);?>"><i class="fa fa-pencil-square-o icon fa-lg"></i> 研討會系統</a>
				</div>
				<div class="btn-group" role="group">
					<a class="btn btn-danger btn-lg" href="<?php echo get_url("news",$conf->conf_id);?>"><i class="fa fa-bullhorn icon fa-lg"></i> 最新消息</a>
				</div>
				<?php if($this->user->is_login()){?>
				<?php if($this->user->is_conf($conf->conf_id)){?>
				<div class="btn-group" role="group">
					<a class="btn btn-success btn-lg" href="<?php echo get_url("dashboard",$conf->conf_id);?>"><i class="fa fa-tachometer fa-lg"></i> 網站編輯</a>
				</div>
				<?php }?>
				<?php }?>
			</div>
		</div>
	
	<?php }?>
	<?php }?>
	<?php }?>

</div>
