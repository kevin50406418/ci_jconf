<section class="am-panel am-panel-danger">
	<header class="am-panel-hd">
		<h3 class="am-panel-title">重要時程</h3>
	</header>
	<ul class="am-list am-list-static">
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
	</ul>
</section>