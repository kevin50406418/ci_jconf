<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $pg_id = $this->uri->segment(2);?>
<h1 style="font-weight: bold;"><?php echo $conf_config['conf_name']?></h1>
<div class="navbar navbar-inverse" id="conf_nav">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#conf-nav-collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		</button>
	</div>
	<div class="collapse navbar-collapse" id="conf-nav-collapse">
		<ul class="nav navbar-nav">
			<?php foreach ($conf_content as $key => $content) {?>
				<?php if(in_array($content->page_id,$spage)){?>
				<li class="<?php echo active_confnav($pg_id,$content->page_id,"active")?>"><a href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a></li>
				<?php }else{?>
				<?php $pg_id = $this->uri->segment(3);?>
				<li class="<?php echo active_confnav($pg_id,$content->page_id,"active")?>"><a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a></li>
				<?php }?>
			<?php }?>
		</ul>
	</div>
</div>

<div id="conf_schedule" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<h2 class="ui center aligned segment attached orange inverted">
			重要日期
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</h2>
		<div class="ui segment attached">
			<?php foreach ($schedule as $key => $v) {?>
			<li>
				<span class="text-bold"><?php echo lang('schedule_'.$key)?></span>：
				<?php if( $v['start'] == $v['end']){?>
					<?php echo $v['end']?>
				<?php }else{?>
					<?php echo $v['start']?> ~ <?php echo $v['end']?>
				<?php }?>
			</li>
			<?php }?>
		</div>
	</div>
</div>
