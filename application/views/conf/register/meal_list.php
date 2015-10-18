<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<!--<a href="<?php echo get_url("dashboard",$conf_id,"register","price")?>" class="pull-right ui button teal"><i class="fa fa-2x fa-credit-card"></i> 註冊費用</a>-->
		<a href="<?php echo get_url("dashboard",$conf_id,"register")?>" class="pull-right ui button brown"><i class="fa fa-2x fa-list-alt"></i> 註冊列表</a>
		<h3 class="modal-title">餐點管理</h3>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"register","meal"),array('class'=>"form-horizontal"))?>
		<?php echo form_hidden('opt', 'del');?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center col-md-1"></th>
					<th class="text-center col-md-9">餐點名稱</th>
					<th class="text-center col-md-2">操作</th>
				</tr>
			</thead>
			<?php foreach ($register_meals as $key => $register_meal) {?>
			<tr>
				<td class="text-center">
					<input type="checkbox" name="meal_id[]" value="<?php echo $register_meal->meal_id;?>">
				</td>
				<td><?php echo $register_meal->meal_name;?></td>
				<td>
					<a href="<?php echo get_url("dashboard",$conf_id,"register","meal")?>?id=<?php echo $register_meal->meal_id;?>" class="ui button blue">編輯</a>
				</td>
			</tr>
			<?php }?>
		</table>
		<div class="text-center">
			<button class="ui button red" type="submit">刪除</button>
		</div>
		<?php echo form_close()?>
	</div>
</div>