<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<?php echo form_open(site_url("sysop/user/all"),array("class"=>"ui segment","id"=>"users"))?>
	<p>
		<a href="<?php echo site_url("sysop/user/add")?>" class="ui button green">批量新增使用者</a>
		<button value="sysop" name="type" class="ui button blue basic" id="sysop">設為系統管理員</button>
		<button value="unsysop" name="type" class="ui button red basic" id="unsysop">取消系統管理員</button>
	</p>
	<div id="alert"></div>
	<table class="table table-hover table-bordered datatable_users">
		<thead>
			<tr>
				<th></th>
				<th>帳號(姓名)</th>
				<th>所屬機構</th>
				<th>操作</th>
			</tr>
		</thead>
		<?php foreach ($users as $key => $user) {?>
		<tr>
			<td class="text-center">
				<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
			</td>
			<td>
				<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
				<?php echo $user->user_login?>
				(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
				<div class="pull-right">
				<?php if($user->user_sysop == 1){?>
					<span class="ui red label">系統管理員</span>
				<?php }?>
				<?php if($user->user_staus == 1){?>
					<span class="ui black label">停用</span>
				<?php }else if($user->user_staus == 2){?>
					<span class="ui grey label">驗證中</span>
				<?php }?>
				</div>
			</td>
			<td>
				<?php echo $user->user_org?>
			</td>
			<td>
				<a href="<?php echo site_url("sysop/user/edit/".$user->user_login)?>" class="ui button blue tiny basic"><i class="fa fa-pencil-square-o"></i> 編輯</a>
				<a href="<?php echo site_url("sysop/user/view/".$user->user_login)?>" class="ui button teal tiny basic">查看</a>
				<!-- <?php if($user->user_staus == 1){?><a href="#" class="ui button green tiny basic">啟用</a><?php }?>-->
				<a href="<?php echo site_url("sysop/user/reset/".$user->user_login)?>" class="ui button orange tiny basic">重設密碼</a>
				<a href="<?php echo site_url("sysop/user/switch/".$user->user_login)?>" class="ui button yellow tiny basic">切換使用者</a>
			</td>
		</tr>
		<?php }?>
	</table>
<?php echo form_close()?>
</div>
<script>
$(document).ready(function() {
	$('.datatable_users').dataTable( {
		"order": [[ 1, "desc" ]],
		columnDefs: [
			{ orderable: false, "targets": 0 },
			{ orderable: false, "targets": -1 }
		],
		stateSave: true,
        "language": {
            "lengthMenu": "每頁顯示 _MENU_ 筆資料",
            "zeroRecords": "找不到使用者",
            "info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "目前尚無任何使用者",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "搜尋：",
			"paginate": {
				"first":      "首頁",
				"last":       "最後一頁",
				"next":       "下一頁",
				"previous":   "上一頁"
			},
        }
    });
    $("#sysop").click(function(e) {
		var table = $('.datatable_users').dataTable();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sysop/user/manage")?>",
			data: table.$('input').serialize()+"&type=sysop&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>" ,
			success: function(response){$("#alert").html(response);},
			error:function(xhr){$("#alert").html(data);},
		});
		return false;
	});
	$("#unsysop").click(function(e) {
		var table = $('.datatable_users').dataTable();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sysop/user/manage")?>",
			data: table.$('input').serialize()+"&type=unsysop&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>" ,
			success: function(response){$("#alert").html(response);},
			error:function(xhr){$("#alert").html(data);},
		});
		return false;
	});
} );
</script>
