<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>使用者</th>
				<th>分類</th>
				<th>動作</th>
				<th>時間</th>
				<th>更多資訊</th>
			</tr>
		</thead>
		<?php foreach ($conf_logs as $key => $log) {?>
		<tr>
			<td><?php echo $log->login_user?></td>
			<td><?php echo lang('log_'.$log->log_type)?></td>
			<td><?php echo $log->log_act?></td>
			<td><?php echo date("Y-m-d H:i:s",$log->log_time)?></td>
			<td>更多資訊</td>
		</tr>
		<?php }?>
	</table>
</div>