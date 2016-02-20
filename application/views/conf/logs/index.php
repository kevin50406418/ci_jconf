<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped datatable">
		<thead>
			<tr>
				<th>時間</th>
				<th>使用者</th>
				<th>IP</th>
				<th>分類</th>
				<th>動作</th>
				<th>資訊</th>
			</tr>
		</thead>
		<?php foreach ($conf_logs as $key => $log) {?>
		<tr>
			<td>
				<?php echo date("Y-m-d H:i:s",$log->log_time)?>
			</td>
			<td><?php echo $log->login_user?></td>
			<td><?php echo $log->log_ip?></td>
			<td><?php echo lang('log_'.$log->log_type)?></td>
			<td>
				<?php 
					$template = lang($log->log_act);
					$data = json_decode($log->log_to);
				?>
				<?php echo $template;?>
				<!-- <?php echo $log->log_act?> -->
			</td>
			<td>
				<div class="text-center">
					<button type="button" class="ui button blue" data-toggle="modal" data-target="#modal<?php echo $log->log_id?>">
						更多資訊
					</button>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="modal<?php echo $log->log_id?>" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="modalLabel">日誌資訊</h4>
							</div>
							<div class="modal-body">
								<pre><?php echo htmlentities(print_r($data, true));?></pre>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php }?>
	</table>
	</div>
</div>
<script>
$(document).ready(function() {
	$('.datatable').dataTable( {
		"order": [[ 0, "desc" ]],
		//stateSave: true,
		columnDefs: [
			{ orderable: false, "targets": -1 },
		],
		dom: 'Bfrtip',
		buttons: [
            'excelHtml5',
            'csvHtml5'
		],
        "language": {
            "lengthMenu": "每頁顯示 _MENU_ 筆資料",
            "zeroRecords": "找不到日誌",
            "info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "目前尚無任何日誌",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "日誌資料搜尋：",
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
<?php
//in english
// $lang['unread_messages'] = "You have %1$s unread messages, %2$s";

// //in another language
// $lang['unread_messages'] = "Hi %2$s, You have %1$s unread messages";

// $message = sprintf($this->lang->line(‘unread_messages’), $number, $name);
?>