<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="panel panel-info">
	<div class="panel-heading text-bold">重要時程</div>
	<ul class="list-group">
		<?php foreach ($schedule as $key => $v) {?>
		<li class="list-group-item">
			<span class="text-bold"><?php echo lang('schedule_'.$key)?></span>：
			<?php if( $v['start'] == $v['end']){?>
				<?php echo $v['end']?>
			<?php }else{?>
				<?php echo $v['start']?> ~ <?php echo $v['end']?>
			<?php }?>
		</li>
		<?php }?>
	</ul>
	
</div>