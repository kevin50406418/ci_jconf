<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<h3 class="modal-title">餐點新增</h3>
	</div>
	<div class="modal-body repeat">
		<?php echo form_open(get_url("dashboard",$conf_id,"register","meal"),array('class'=>"form-horizontal"))?>
			<?php echo form_hidden('opt', 'add');?>
			<table class="table table-bordered" id="meal">
				<thead>
					<tr>
						<td colspan="2"><span class="add ui green button"><i class="fa fa-plus"></i></span></td>
					</tr>
					<tr>
						<th>餐點名稱</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr class="template trow">
						<td>
							<input type="text" class="form-control" name="meal_name[]">
						</td>
						<td class="text-center">
							<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
							<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
						</td>
					</tr>
					<tr class="trow">
						<td>
							<input type="text" class="form-control" name="meal_name[]">
						</td>
						<td class="text-center">
							<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
							<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="text-center">
				<button type="submit" class="ui blue button">新增</button>
			</div>
		<?php echo form_close()?>
	</div>
</div>
<script>
$(function() {
	$('.repeat').each(function() {
		$(this).repeatable_fields({
			wrapper: 'table#meal',
			row: '.trow',
			container: 'tbody',
			add: '.add',
			remove: '.remove',
			move: '.move',
		});
	});
});
</script>
