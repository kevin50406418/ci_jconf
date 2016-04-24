<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo form_open(get_url("dashboard",$conf_id,"user"),array("class"=>"ui segment"))?>
	<div class="ui inverted segment row">
		<a href="<?php echo get_url("dashboard",$conf_id,"user","add")?>" class="ui blue inverted button col-md-2">新增使用者</a>
		<div class="ui buttons col-md-3">
			<button class="ui teal button action" name="type" value="add_admin">設為研討會管理員</button>
			<button class="ui pink button action" name="type" value="del_admin">取消研討會管理員</button>
		</div>

		<div class="ui buttons col-md-3">
			<button class="ui orange button action" name="type" value="add_review">設為審查人</button>
			<button class="ui purple button action" name="type" value="del_review">取消審查人</button>
		</div>
	</div>
	<div id="alert"></div>
	<div class="table-responsive">
	<table class="table table-hover table-bordered datatable_users">
		<thead>
			<tr>
				<th class="col-md-1 text-center"> </th>
				<th class="col-md-4 text-center">帳號(姓名)</th>
				<th class="col-md-5 text-center">所屬機構</th>
				<th class="col-md-2 text-center">操作</th>
			</tr>
		</thead>
		<?php foreach ($users as $key => $user) {?>
		<tr>
			<td class="text-center">
				<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
			</td>
			<td>
				<img src="<?php echo $this->user->get_gravatar($user->user_email,20)?>" class="img-rounded">
				<?php echo $user->user_login?>
				(<?php echo $user->user_first_name?> <?php echo $user->user_middle_name?> <?php echo $user->user_last_name?>)
				<div class="pull-right">
				<?php if( in_array($user->user_login,$confs) ){?>
					<span class="ui teal mini label" title="研討會管理員">管</span>
				<?php }?>
				<?php if( in_array($user->user_login,$topics) ){?>
					<span class="ui green mini label" title="主題主編">主</span>
				<?php }?>
				<?php if( in_array($user->user_login,$reviewers) ){?>
					<span class="ui orange mini label" title="研討會審查人">審</span>
				<?php }?>
				<?php if($user->user_staus == 2){?>
					<span class="ui grey mini label">驗證中</span>
				<?php }?>
				</div>
			</td>
			<!-- <td><?php echo $user->user_email?></td> -->
			<td><?php echo $user->user_org?></td>
			<td>
				<a href="<?php echo get_url("dashboard",$conf_id,"user","edit",$user->user_login)?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> 編輯</a>
				<!--<a href="<?php echo get_url("dashboard",$conf_id,"user","mail",$user->user_login)?>" class="btn btn-success btn-sm"><i class="fa fa-envelope-o"></i> 寄信</a>
				<a href="#" class="ui button teal tiny">查看</a>
				<a href="#" class="ui button orange tiny">重設密碼</a>-->
			</td>
		</tr>
		<?php }?>
	</table>
	</div>
<?php echo form_close()?>
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
			url: "<?php echo get_url("dashboard",$conf_id,"user")?>",
			data: table.$('input').serialize()+"&type="+$(this).val()+"&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>" ,
			success: function(response){$("#alert").html(response);},
			error:function(xhr){$("#alert").html(data);},
		});
		return false;
	});
} );
</script>