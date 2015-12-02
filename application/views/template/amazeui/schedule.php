<h2 class="ui center aligned segment attached orange inverted">
	重要時程
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