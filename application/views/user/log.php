<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<div class="modal-header">
		<h2 class="modal-title"><?php echo lang('user_log_recent')?></h2>
	</div>
	<div class="modal-body">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo lang('user_log_time')?></th>
					<th><?php echo lang('user_log_ip')?></th>
					<th><?php echo lang('user_log_device')?></th>
					<th><?php echo lang('user_log_action')?></th>
				</tr>
			</thead>
			<?php foreach($logs as $k => $log){?>
			<tr>
				<td><?php echo date("Y-m-d H:m:i",$log->login_time)?></td>
				<td><?php echo $log->login_ip?></td>
				<td>
					<?php echo $log->login_platform?> <?php echo $log->login_browser?>
				</td>
				<td>
					<div>
						<?php if( $log->login_staus == 1){?>
							<i class="fa fa-check-square fa-2x"></i> <?php echo lang('user_log_success')?>
						<?php }elseif( $log->login_staus == 0){?>
							<strong class="text-danger"><i class="fa fa-exclamation-triangle fa-2x"></i> <?php echo lang('user_log_fail')?></strong>
						<?php }?>
						<?php if( $log->sessions_id == session_id()){?>
							<span class="ui brown label"><?php echo lang('user_log_current')?></span>
						<?php }?>
					</div>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>