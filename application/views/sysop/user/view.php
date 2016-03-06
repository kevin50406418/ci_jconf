<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="col-xs-12 col-sm-12">
   		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">User: <?php echo $user->user_login?></h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 col-lg-3 text-center">
						<img src="<?php echo $this->user->get_gravatar($user->user_email,250)?>" class="img-rounded img-responsive">
					</div>
						<div class="col-md-9 col-lg-9"> 
						<table class="table table-user-information">
							<tr>
								<td>姓名:</td>
								<td>
									<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>
								</td>
							</tr>
							<tr>
								<td>電子信箱:</td>
								<td>
									<?php echo $user->user_email?>
								</td>
							</tr>
							<tr>
								<td>所屬機構:</td>
								<td>
									<?php echo $user->user_org?>
								</td>
							</tr>
							<tr>
								<td>性別:</td>
								<td>
									<?php if($user->user_gender=="M"){?>
										<i class="fa fa-mars"></i> 男
									<?php }else if($user->user_gender=="F"){?>
										<i class="fa fa-venus"></i> 女
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>電話(公):</td>
								<td>
									(<?php echo $user->user_phone_o[0]?>)-<?php echo $user->user_phone_o[1]?>
									<?php if(isset($user->user_phone_o[2])){?>分機：<?php echo $user->user_phone_o[2]?><?php }?>
								</td>
							</tr>
							<tr>
								<td>聯絡地址:</td>
								<td>
									<?php echo $user->user_postcode?>
									<?php
										foreach ($user->user_postaddr as $key => $v) {
											echo $v." ";
										}
									?>
								</td>
							</tr>
							<tr>
								<td>國別:</td>
								<td>
									<?php echo $country_list[$user->user_country]?>
								</td>
							</tr>
							<tr>
								<td>語言:</td>
								<td>
									<?php if($user->user_lang=="zhtw"){?>
										<i class="fa fa-mars"></i> 繁體中文(Traditional Chinese)
									<?php }else if($user->user_lang=="eng"){?>
										<i class="fa fa-venus"></i> 英文(English)
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>研究領域:</td>
								<td>
									<?php echo $user->user_research?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<a class="btn btn-sm btn-primary disabled"><i class="fa fa-envelope"></i> 寄信給 <?php echo $user->user_login?></a>
				<span class="pull-right">
					<a href="<?php echo site_url("sysop/user/edit/".$user->user_login)?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i>編輯使用者</a>
					<a href="<?php echo site_url("sysop/user/reset/".$user->user_login)?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>重置密碼</a>
				</span>
			</div>
		</div>
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

	</div>
</div>
<script>
$(document).ready(function() {
	$('.datatable_logs').dataTable( {
		"order": [[ 0, "desc" ]],
		stateSave: true,
		"language": {
			"lengthMenu": "每頁顯示 _MENU_ 筆資料",
			"zeroRecords": "找不到登入記錄",
			"info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
			"infoEmpty": "目前尚無任何登入記錄",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "登入記錄資料搜尋：",
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