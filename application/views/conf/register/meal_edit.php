<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment black">
	<div class="modal-header">
		<h3 class="modal-title">餐點編輯</h3>
	</div>
	<div class="modal-body repeat">
		<?php echo form_open(get_url("dashboard",$conf_id,"register","meal")."?id=".$meal->meal_id,array('class'=>"form-horizontal"))?>
			<?php echo form_hidden('opt', 'update');?>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>餐點名稱</th>
						<td>
							<input type="text" class="form-control" name="meal_name" value="<?php echo $meal->meal_name?>">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="text-center">
				<button type="submit" class="ui teal button">更新</button>
			</div>
		<?php echo form_close()?>
	</div>
</div>
