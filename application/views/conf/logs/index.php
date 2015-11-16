<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>時間</th>
				<th>使用者</th>
				<th>分類</th>
				<th>動作</th>
				<th>資訊</th>
			</tr>
		</thead>
		<?php foreach ($conf_logs as $key => $log) {?>
		<tr>
			<td><?php echo date("Y-m-d H:i:s",$log->log_time)?></td>
			<td><?php echo $log->login_user?></td>
			<td><?php echo lang('log_'.$log->log_type)?></td>
			<td><?php echo $log->log_act?></td>
			<td>資訊</td>
		</tr>
		<?php }?>
	</table>
</div>
<?php
//in english
// $lang['unread_messages'] = "You have %1$s unread messages, %2$s";

// //in another language
// $lang['unread_messages'] = "Hi %2$s, You have %1$s unread messages";

// $message = sprintf($this->lang->line(‘unread_messages’), $number, $name);
?>