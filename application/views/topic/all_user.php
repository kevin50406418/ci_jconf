<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo form_open(get_url("topic",$conf_id,"users"),array("class"=>"ui segment"))?>
	<div class="ui inverted segment">
		<div class="ui buttons">
			<button class="ui orange button action" name="type" value="add_review">設為審查人</button>
			<button class="ui purple button action" name="type" value="del_review">取消審查人</button>
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
					<span class="ui teal label" title="研討會管理員">管</span>
				<?php }?>
				<?php if( in_array($user->user_login,$topics) ){?>
					<span class="ui green mini label" title="主題主編">主</span>
				<?php }?>
				<?php if( in_array($user->user_login,$reviewers) ){?>
					<span class="ui orange label" title="研討會審查人">審</span>
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
<script>
$(document).ready(function() {
	$('.datatable_users').dataTable( {
		"order": [[ 1, "desc" ]],
		columnDefs: [
			{ orderable: false, "targets": 0 },
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
			url: "<?php echo get_url("topic",$conf_id,"users")?>",
			data: table.$('input').serialize()+"&type="+$(this).val()+"&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>" ,
			success: function(response){$("#alert").html(response);},
			error:function(xhr){$("#alert").html(data);},
		});
		return false;
	});
} );
</script>