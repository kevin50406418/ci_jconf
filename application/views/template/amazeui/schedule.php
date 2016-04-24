<h2 class="ui center aligned segment attached orange inverted">
	重要時程
</h2>
<div class="ui segment attached">
	<?php foreach ($schedule as $key => $v) {?>
	<?php if($v['date_showmethod']>0){?>
	<li>
		<span class="text-bold">
		<?php if( empty( $v["date_title_".$this->_lang] ) ){?>
			<?php echo lang('schedule_'.$key)?>
		<?php }else{?>
			<?php echo $v["date_title_".$this->_lang]?>
		<?php }?>
		</span>：
		<?php echo date_showmethod($v['date_showmethod'],$v['start'],$v['end'])?>
	</li>
	<?php }?>
	<?php }?>
</div>