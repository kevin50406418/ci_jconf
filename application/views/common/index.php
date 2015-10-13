<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
<div class="row">
	<?php if(is_array($confs)){?>
	<?php foreach ($confs as $key => $conf) {?>
	<div class="col-xs-12 col-md-6">
		<div class="ui segment">
			<a href="#collapse<?php echo $conf->conf_id?>" aria-expanded="false" data-toggle="collapse" class="pull-right ui icon button orange"><i class="fa fa-chevron-down fa-lg"></i></a>
			<h3><?php echo $conf->conf_name?></h3>
			<p>
				<?php echo mb_substr( $conf->conf_desc,0,120,"utf-8")?><?php if(mb_strlen($conf->conf_desc)>120){?>...<?php }?>
			</p>
			<div id="collapse<?php echo $conf->conf_id?>" class="collapse">
				<div class="ui fluid four item menu teal inverted large">
					<a class="item" href="<?php echo get_url("main",$conf->conf_id);?>"><i class="fa fa-pencil-square-o icon fa-lg"></i> 投稿系統</a>
					<a class="item" href="<?php echo get_url("index",$conf->conf_id);?>"><i class="fa fa-home icon fa-lg"></i> 首頁</a>
					<a class="item" href="<?php echo get_url("mews",$conf->conf_id);?>"><i class="fa fa-bullhorn icon fa-lg"></i> 最新消息</a>
					<a class="item" href="<?php echo get_url("about",$conf->conf_id,"program");?>"><i class="fa fa-calendar-o icon fa-lg"></i> 議程</a>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<?php }?>
</div>
</div>
