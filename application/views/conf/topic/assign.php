<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
    } );
} );
</script>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="pull-right ui button orange"><?php echo lang('topic_all')?></a>
		<h4 class="modal-title"><?php echo lang('topic_assign_editor')?></h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"topic","assign")."?id=".$topic['topic_id'],array("class"=>"form-horizontal"))?>

			<table class="table table-hover table-striped table-bordered datatable_users">
				<thead>
					<tr>
						<th> </th>
						<th>帳號(姓名)</th>
						<th>所屬機構</th>
						<th>研究領域</th>
					</tr>
				</thead>
				<?php foreach ($users as $key => $user) {?>
				<?php if(!in_array($user->user_login,$auth_users)){?>
				<tr>
					<td class="text-center">
						<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
					</td>
					<td>
						<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
						<?php echo $user->user_login?>
						(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
					</td>
					<td><?php echo $user->user_org?></td>
					<td><?php echo $user->user_research?></td>
				</tr>
				<?php }?>
				<?php }?>
			</table>
			<div class="text-center">
				<button type="submit" name="submit" id="submit" value="add" class="ui button blue"><?php echo lang('add_editor')?></button>
			</div>
		<?php echo form_close()?>
	</div>
</div>
<?php if(!empty($topic_users)){?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="pull-right ui button orange"><?php echo lang('topic_all')?></a>
		<h4 class="modal-title"><strong><?php echo $topic["topic_name"]?>(<?php echo $topic["topic_name_eng"]?>) 主編</strong></h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"topic","assign")."?id=".$topic['topic_id'],array("class"=>"form-horizontal"))?>
			<table class="table table-hover table-striped table-bordered datatable_users">
				<thead>
					<tr>
						<th class="text-center">刪除</th>
						<th>帳號(姓名)</th>
						<th>所屬機構</th>
						<th>研究領域</th>
					</tr>
				</thead>
				<?php foreach ($topic_users as $key => $user) {?>
				<tr>
					<td class="text-center">
						<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
					</td>
					<td>
						<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
						<?php echo $user->user_login?>
						(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
					</td>
					<td><?php echo $user->user_org?></td>
					<td><?php echo $user->user_research?></td>
				</tr>
				<?php }?>
			</table>
			<div class="text-center">
				<button type="submit" name="submit" id="submit" value="del" class="ui button red"><?php echo lang('del_editor')?></button>
			</div>
		<?php echo form_close()?>
	</div>
</div>
<?php }else{?>
<?php echo $this->alert->show("i","<strong>".$topic["topic_name"]."(".$topic["topic_name_eng"].")</strong> 尚未指派主編");?>
<?php }?>