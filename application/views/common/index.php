<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
<div class="row">
	<?php if(is_array($confs)){?>
	<?php foreach ($confs as $key => $conf) {?>
	<div class="col-xs-12 col-md-6">
		<div class="ui segment">
			<h3 class="text-bold">
				<?php if( $this->user->is_sysop() ){?>
					<?php if( $conf->conf_staus == 1 ){?>
					<span class="ui basic label pink">隱藏</span>
					<?php }?>
				<?php }?>
				<?php echo $conf->conf_name?>
			</h3>
			<p>
				<?php echo mb_substr( $conf->conf_desc,0,135,"utf-8")?><?php if(mb_strlen($conf->conf_desc)>135){?>...<?php }?>
			</p>
			<?php if( !empty($conf->conf_place) ){?><p><i class="fa fa-map-marker"></i> <?php echo $conf->conf_place?></p><?php }?>
			<div class="ui fluid item menu teal large">
				<a class="item" href="<?php echo get_url("index",$conf->conf_id);?>"><i class="fa fa-home icon fa-lg"></i> 研討會首頁</a>
				<a class="item" href="<?php echo get_url("main",$conf->conf_id);?>"><i class="fa fa-pencil-square-o icon fa-lg"></i> 研討會系統</a>
				<a class="item" href="<?php echo get_url("news",$conf->conf_id);?>"><i class="fa fa-bullhorn icon fa-lg"></i> 最新消息</a>
				<?php if($this->user->is_conf($conf_id) || $this->user->is_sysop()){?>
				<a class="item" href="<?php echo get_url("dashboard",$conf->conf_id);?>"> 網站編輯</a>
				<?php }?>
			</div>
		</div>
	</div>
	<?php }?>
	<?php }?>
</div>
</div>
