<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo validation_errors();?>
<div class="ui segment blue">
<ul class="nav nav-tabs nav-justified" role="tablist">
	<li class="active"><a href="#item" role="tab" data-toggle="tab">繳費項目</a></li>
	<li><a href="#type" role="tab" data-toggle="tab">繳費分類</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="item">
		<div class="page-header">
			<h2>繳費項目</h2>
		</div>
		<?php echo form_open(get_url("dashboard",$this->conf_id,"price"))?>
		<?php echo form_hidden('do', 'update_item');?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2" class="col-md-1 text-center">#</th>
					<th rowspan="2" class="col-md-2 text-center">分類</th>
					<th colspan="3" class="col-md-4 text-center">早鳥</th>
					<th colspan="3" class="col-md-4 text-center">一般</th>
					<th rowspan="2" class="col-md-1 text-center">操作</th>
				</tr>
				<tr>
					<th class="text-center">一般人士</th>
					<th class="text-center">教師</th>
					<th class="text-center">學生</th>
					<th class="text-center">一般人士</th>
					<th class="text-center">教師</th>
					<th class="text-center">學生</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($prices as $key => $price) {?>
				<tr>
					<td class="text-center">
						<?php echo $price->price_id?>
					</td>
					<td>
						<select name="type_id[<?php echo $price->price_id?>]" class="form-control">
							<?php foreach ($price_types as $type_key => $type) {?>
							<option value="<?php echo $type->type_id?>"<?php if($type->type_id==$price->type_id){?> selected<?php }?>><?php echo $type->type_name?></option>
							<?php }?>
						</select>
					</td>
					<td>
						<input class="form-control" type="text" name="early_other[<?php echo $price->price_id?>]" value="<?php echo $price->early_other?>">
					</td>
					<td>
						<input class="form-control" type="text" name="early_teacher[<?php echo $price->price_id?>]" value="<?php echo $price->early_teacher?>">
					</td>
					<td>
						<input class="form-control" type="text" name="early_student[<?php echo $price->price_id?>]" value="<?php echo $price->early_student?>">
					</td>
					<td>
						<input class="form-control" type="text" name="other_price[<?php echo $price->price_id?>]" value="<?php echo $price->other_price?>">
					</td>
					<td>
						<input class="form-control" type="text" name="teacher_price[<?php echo $price->price_id?>]" value="<?php echo $price->teacher_price?>">
					</td>
					<td>
						<input class="form-control" type="text" name="student_price[<?php echo $price->price_id?>]" value="<?php echo $price->student_price?>">
					</td>
					
					<td class="text-center">
						<span class="btn btn-danger btn-sm disabled" onclick="return confirm('是否刪除?刪除後會影響使用者註冊資訊')">刪除</span>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<div class="text-center">
			<button class="ui button teal huge">更新</button>
		</div>
		<?php echo form_close()?>
		<div class="page-header">
			<h2>新增繳費項目</h2>
		</div>
		<?php echo form_open(get_url("dashboard",$this->conf_id,"price"))?>
		<?php echo form_hidden('do', 'add_item');?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2" class="col-md-2 text-center">分類</th>
					<th colspan="3" class="col-md-5 text-center">早鳥</th>
					<th colspan="3" class="col-md-5 text-center">一般</th>
				</tr>
				<tr>
					<th class="text-center">一般人士</th>
					<th class="text-center">教師</th>
					<th class="text-center">學生</th>
					<th class="text-center">一般人士</th>
					<th class="text-center">教師</th>
					<th class="text-center">學生</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<select name="type_id" class="form-control">
							<?php foreach ($price_types as $type_key => $type) {?>
							<option value="<?php echo $type->type_id?>"><?php echo $type->type_name?></option>
							<?php }?>
						</select>
					</td>
					<td>
						<input class="form-control" type="text" name="other_price" value="">
					</td>
					<td>
						<input class="form-control" type="text" name="teacher_price" value="">
					</td>
					<td>
						<input class="form-control" type="text" name="student_price" value="">
					</td>
					<td>
						<input class="form-control" type="text" name="early_other" value="">
					</td>
					<td>
						<input class="form-control" type="text" name="early_teacher" value="">
					</td>
					<td>
						<input class="form-control" type="text" name="early_student" value="">
					</td>
				</tr>
			</tbody>
		</table>
		<div class="text-center">
			<button class="ui button blue huge">新增</button>
		</div>
		<?php echo form_close()?>
	</div>
	<div role="tabpanel" class="tab-pane" id="type">
		<div class="page-header">
			<h2>繳費分類</h2>
		</div>
		<?php echo form_open(get_url("dashboard",$this->conf_id,"price"))?>
		<?php echo form_hidden('do', 'update_type');?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="col-md-2 text-center">#</th>
					<th class="col-md-10 text-center">分類名稱</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($price_types as $type_key => $type) {?>
				<tr>
					<td class="text-center"><?php echo $type->type_id?></td>
					<td>
						<input class="form-control" type="text" name="type_name[<?php echo $type->type_id?>]" value="<?php echo $type->type_name?>">
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<div class="text-center">
			<button class="ui button teal huge">更新</button>
		</div>
		<?php echo form_close()?>
		<div class="page-header">
			<h2>繳費分類</h2>
		</div>
		<?php echo form_open(get_url("dashboard",$this->conf_id,"price"))?>
		<?php echo form_hidden('do', 'add_type');?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center">分類名稱</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input class="form-control" type="text" name="type_name">
					</td>
				</tr>
			</tbody>
		</table>
		<div class="text-center">
			<button class="ui button blue huge">新增</button>
		</div>
		<?php echo form_close()?>
	</div>
</div>

</div>
<script>
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('conf_price_<?php echo $this->conf_id?>', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('conf_price_<?php echo $this->conf_id?>');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	};
});
</script>