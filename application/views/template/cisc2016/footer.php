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
				<span class="text-bold"><?php echo lang('cisc2016_schedule_'.$key)?></span>：
					<?php echo $v['end']?>
			</li>
			<?php }?>
			<?php if( $this->user->is_conf($this->conf_id) ){?>
				<a class="am-btn am-btn-primary am-btn-xs" href="<?php echo get_url("dashboard",$conf_id,"setting")?>">
					<i class="fa fa-pencil"></i> 編輯重要時程
				</a>
			<?php }?>
		</div>
	</div>
</div>
<footer class="footer">
	<p>地址：<?php echo $conf_config['conf_address']?> │ 聯絡電話：<?php echo $conf_config['conf_phone']?></p>
	<p>E-Mail：<?php echo $conf_config['conf_email']?> │ Copyright © <?php echo date("Y")?> <?php echo $conf_config['conf_host']?> All right reserved</p>
</footer>
</body>
</html>