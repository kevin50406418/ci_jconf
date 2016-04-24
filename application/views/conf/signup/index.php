<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<div class="table-responsive">
	<table class="table table-bordered datatable">
		<thead>
			<tr>
				<th class="col-md-1 text-center">序號</th>
				<th class="col-md-2 text-center">註冊類型</th>
				<th class="col-md-1 text-center">註冊信箱</th>
				<th class="col-md-1 text-center">註冊費用</th>
				<th class="col-md-1 text-center">註冊狀態</th>
				<th class="col-md-1 text-center">填寫時間</th>
				<th class="col-md-1 text-center">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($signups as $key => $signup) {?>
			<tr>
				<td class="text-center">
					<?php echo $signup->signup_id?>
				</td>
				<td>
					<?php echo $signup->type_name?>
					<?php echo $this->signup->signup_type($signup->signup_type)?>
				</td>
				<td>
					<?php echo $signup->user_email?>
				</td>
				<td class="text-center">
					<?php echo $signup->signup_price?>
				</td>
				<td class="text-center">
					<?php echo $this->signup->signup_status($signup->signup_status)?>
				</td>
				<td class="text-center">
					<?php echo date("Y-m-d H:i:s",$signup->signup_time)?>
				</td>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							操作 <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="<?php echo get_url("dashboard",$this->conf_id,"signup","view")?>?id=<?php echo $signup->signup_id?>">查看</a></li>
							<li><a href="<?php echo get_url("dashboard",$this->conf_id,"signup","edit")?>?id=<?php echo $signup->signup_id?>">編輯</a></li>
							<li><a href="<?php echo get_url("dashboard",$this->conf_id,"signup","status")?>?id=<?php echo $signup->signup_id?>">編輯狀態</a></li>
							<li><a href="<?php echo get_url("dashboard",$this->conf_id,"signup","upload")?>?id=<?php echo $signup->signup_id?>">上傳繳費紀錄</a></li>
							<li><a href="<?php echo get_url("dashboard",$this->conf_id,"signup","passwd")?>?id=<?php echo $signup->signup_id?>">更改密碼</a></li>
						</ul>
					</div>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	</div>
</div>
<script>
$(function() {
	$('.datatable').dataTable( {
		"order": [[ 0, "desc" ]],
		columnDefs: [
			{ orderable: false, "targets": -1 },
		],
		dom: 'Bfrtip',
		buttons: [
			{
                extend: 'excelHtml5',
                text: '匯出 excel 檔',
                className: 'ui button green'
            },
            {
                extend: 'csvHtml5',
                text: '匯出 csv 檔',
                className: 'ui button teal'
            }
        ],
		stateSave: true,
        "language": {
            "lengthMenu": "每頁顯示 _MENU_ 筆資料",
            "zeroRecords": "找不到論文",
            "info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "目前尚無任何資料",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "資料搜尋：",
			"paginate": {
				"first":      "首頁",
				"last":       "最後一頁",
				"next":       "下一頁",
				"previous":   "上一頁"
			},
        }
    } );
});
</script>