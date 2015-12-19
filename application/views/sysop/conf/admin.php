<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment blue">
	<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li> <a href="<?php echo site_url("sysop/conf/edit/".$conf_id)?>"> 研討會資訊 </a> </li>
			<li class="active"> <a href="<?php echo site_url("sysop/conf/admin/".$conf_id)?>"> 研討管理員 </a> </li>
			<!--<li> <a href="#tab_file" data-toggle="tab"> 研討會ID更換 </a> </li>
			<li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li>-->
		</ul>
		<?php echo form_open(site_url("sysop/conf/add_admin/".$conf_id),array("class"=>"tab-content"))?>
		<div class="ui inverted segment">
			<a href="<?php echo site_url("sysop/user/add")?>" class="ui blue inverted button">新增使用者</a>
			<div class="ui buttons">
				<button class="ui teal button action" name="type" value="add_admin">設為研討會管理員</button>
				<button class="ui pink button action" name="type" value="del_admin">取消研討會管理員</button>
			</div>
		</div>
		<div id="alert"></div>
		<table class="table table-hover table-bordered datatable_users">
			<thead>
				<tr>
					<th> </th>
					<th>帳號(姓名)</th>
					<th>信箱</th>
					<th>所屬機構</th>
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
					<?php if( in_array($user->user_login,$confs) ){?>
						<span class="ui teal label basic" title="研討會管理員">管</span>
					<?php }?>
					<?php if($user->user_staus == 2){?>
						<span class="ui grey label">驗證中</span>
					<?php }?>
					</div>
				</td>
				<td><?php echo $user->user_email?></td>
				<td><?php echo $user->user_org?></td>
			</tr>
			<?php }?>
		</table>
		<?php echo form_close()?>
		</div>
	</div>
</div>
</div>
<script>
$(document).ready(function() {
	$('.datatable_users').dataTable( {
		"order": [[ 1, "desc" ]],
		columnDefs: [
			{ orderable: false, "targets": 0 },
			{ orderable: false, "targets": -1 },
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
			"search":         "使用者資料搜尋：",
			"paginate": {
				"first":      "首頁",
				"last":       "最後一頁",
				"next":       "下一頁",
				"previous":   "上一頁"
			},
        }
    } );
    $(".action").click(function(e) {
		var table = $('.datatable_users').dataTable();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sysop/conf/add_admin/".$conf_id)?>",
			data: table.$('input').serialize()+"&type="+$(this).val()+"&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>" ,
			success: function(response){$("#alert").html(response);},
			error:function(xhr){$("#alert").html(data);},
		});
		return false;
	});
} );
</script>