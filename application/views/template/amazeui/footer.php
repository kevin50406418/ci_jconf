<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</div>
</div>
<div class="am-modal am-modal-no-btn" tabindex="-1" id="schedule">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">重要時程
			<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
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
<footer class="footer">
	<p>地址：<?php echo $conf_config['conf_address']?> │ 聯絡電話：<?php echo $conf_config['conf_phone']?></p>
	<p>E-Mail：<?php echo $conf_config['conf_email']?> │ Copyright © 2015 <?php echo $conf_config['conf_host']?> All right reserved</p>
</footer>
<!-- <footer class="ui inverted vertical footer segment">
	<div class="container-fluid">
		<h3 class="ui inverted header"></h3>
		<div class="ui stackable inverted divided grid">
	        <div class="four wide column">
				<p>主辦單位：<?php echo $conf_config['conf_host']?></p>
				
				<p>聯絡電話：<?php echo $conf_config['conf_phone']?></p>
				<p></p>
				<p><i class="fa fa-map-marker fa-lg"></i> 大會地點：<?php echo $conf_config['conf_place']?></p>
	        </div>
	    </div>
	</div>
</footer> -->
</body>
</html>