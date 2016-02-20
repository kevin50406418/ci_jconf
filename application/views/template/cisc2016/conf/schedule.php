<section class="am-panel am-panel-danger">
	<header class="am-panel-hd">
		<h3 class="am-panel-title">重要時程</h3>
	</header>
	<ul class="am-list am-list-static">
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
	</ul>
</section>