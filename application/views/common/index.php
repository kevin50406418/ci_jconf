<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<?php if(is_array($confs)) :?>
	<?php foreach ($confs as $key => $conf) :?>
	<?php if( $conf->conf_staus == 0 || $this->user->is_conf($conf->conf_id) ){?>
	<div class="col-sm-12">
		<div class="bs-component">
			<div class="card">
				<div class="card-content">
					<?php if($this->user->is_conf($conf->conf_id)){?>
					<div class="pull-right">
						<a href="<?php echo get_url("dashboard",$conf->conf_id);?>" class="btn btn-success"><i class="fa fa-tachometer"></i> 網站編輯</a>
					</div>
					<?php }?>
					<h2 class="card-header"><?php echo $conf->conf_name?></h2>
					<p class="card-description">
						<?php echo mb_substr( $conf->conf_desc,0,150,"utf-8")?><?php if(mb_strlen($conf->conf_desc)>150){?>...<?php }?>
					</p>
				</div>
				<div class="card-extra card-content">
					<div class="row-fluid card-btn text-center">
                        <a href="<?php echo get_url("index",$conf->conf_id);?>" class="col-xs-4 btn btn-inverted btn-primary">
                        	<i class="fa fa-home fa-2x"></i> 研討會首頁
                        </a>
                        <a href="<?php echo get_url("main",$conf->conf_id);?>" class="col-xs-4 btn btn-inverted btn-navy">
                        	<i class="fa fa-pencil-square-o fa-2x"></i> 研討會系統
                        </a>
                        <a href="<?php echo get_url("news",$conf->conf_id);?>" class="col-xs-4 btn btn-inverted btn-danger">
                        	<i class="fa fa-bullhorn fa-2x"></i> 最新消息
                        </a>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
