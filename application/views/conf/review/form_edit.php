<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<?php echo form_open(get_url("dashboard",$conf_id,"review","edit_form")."?id=".$review_form->review_form_id)?>
	<?php echo form_hidden('do', 'update');?>
	<div class="form-group">
		<label>審查項目</label>
		<input name="form_title" type="text" class="form-control" value="<?php echo $review_form->review_form_title?>">
	</div>
	<div class="ui info message">
		<div class="header">
			分數排序，會依分數高低，由高到低排序
		</div>
	</div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th>元素</th>
				<th>分數</th>
				<th>操作</th>
			</tr>
		</tbody>
		<tbody>
			<?php foreach ($form_element as $key => $element) {?>
			<tr>
				<td>
					<input class="form-control" type="text" name="element_name[<?php echo $element["element_id"]?>]" value="<?php echo $element["element_name"]?>">
				</td>
				<td>
					<input class="form-control" type="text" name="element_value[<?php echo $element["element_id"]?>]" value="<?php echo $element["element_value"]?>">
				</td>
				<td>
					<a href="<?php echo get_url("dashboard",$conf_id,"review","del_element")?>?id=<?php echo $review_form->review_form_id?>&element_id=<?php echo $element["element_id"]?>" class="ui button red mini" onclick="return confirm('是否刪除?\n刪除後，將影響評分分數');">刪除</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<div class="text-center">
		<button type="submit" class="ui button blue">更新</button>
	</div>
	<?php echo form_close()?>
</div>
<div class="ui segment raised">
<?php echo form_open(get_url("dashboard",$conf_id,"review","edit_form")."?id=".$review_form->review_form_id)?>
	<?php echo form_hidden('do', 'add');?>
	<div class="repeat">
		<table class="table table-striped table-bordered" id="review_form">
			<thead>
				<tr>
					<td colspan="5"><span class="add btn btn-success">新增元素</span></td>
				</tr>
				<tr>
					<td></td>
					<td>元素</td>
					<td>分數</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<tr class="template">
					<td>
						<span class="move btn btn-info">移動</span>
					</td>
					<td>
						<input type="text" name="element_name[]" class="form-control" placeholder="元素">
					</td>
					<td>
						<input type="text" name="element_value[]" class="form-control" placeholder="分數">
					</td>
					<td>
						<span class="remove btn btn-danger">刪除</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="text-center">
		<button type="submit" class="ui button blue">新增</button>
	</div>
<?php echo form_close()?>
</div>
<script>
$(function() { 
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#review_form',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>