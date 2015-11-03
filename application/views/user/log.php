<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<div class="modal-header">
		<h2 class="modal-title"><?php echo lang('user_log_recent')?></h2>
	</div>
	<div class="modal-body">
		<table class="table table-bordered table-hover datatable_logs">
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
				<td >
					<div>
						<?php if( $log->login_staus == 1){?>
							<i class="fa fa-check-square"></i> <?php echo lang('user_log_success')?>
						<?php }elseif( $log->login_staus == 0){?>
							<strong class="text-danger"><i class="fa fa-exclamation-triangle fa-2x"></i> <?php echo lang('user_log_fail')?></strong>
						<?php }elseif( $log->login_staus == 2){?>
							<i class="fa fa-cog fa-2x"></i> <?php echo lang('user_log_change')?>
						<?php }elseif( $log->login_staus == 3){?>
							<i class="fa fa-history"></i> <?php echo lang('user_log_reset')?>
						<?php }elseif( $log->login_staus == -3){?>	
							<i class="fa fa-envelope"></i> <?php echo lang('user_log_lostpwd')?>
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
<script>
$(document).ready(function() {
	$('.datatable_logs').dataTable( {
		"order": [[ 1, "desc" ]],
		stateSave: true,
        "language": {
            "lengthMenu": "每頁顯示 _MENU_ 筆資料",
            "zeroRecords": "找不到使用者",
            "info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "目前尚無任何使用者",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "使用者資料搜尋：",
			"paginate": {
				"first":      "首頁",
				"last":       "最後一頁",
				"next":       "下一頁",
				"previous":   "上一頁"
			},
        }
    } );
} );
</script>