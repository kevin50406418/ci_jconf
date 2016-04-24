<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="table-responsive repeat">
	<table class="table table-bordered author">
		<thead>
			<tr>
				<td colspan="6"><span class="add ui green button"><i class="fa fa-plus"></i></span></td>
			</tr>
			<tr>
				<th>主要 <span class="text-danger">*</span></th>
				<th>姓名 <span class="text-danger">*</span></th>
				<th>電子信箱 <span class="text-danger">*</span></th>
				<th>所屬機構 <span class="text-danger">*</span></th>
				<th>國別 <span class="text-danger">*</span></th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<tr class="template trow">
				<td class="text-center">
					
				</td>
				<td>
					<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="">
					<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="">
				</td>
				<td>
					<input name="user_email[]" type="email" required class="form-control" id="user_email" value="">
				</td>
				<td>
					<textarea name="user_org[]" maxlength="40" required class="form-control" id="user_org"></textarea>
				</td>
				<td><?php echo form_dropdown('user_country[]', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?></td>
				<td class="text-center">
					<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
					<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
				</td>
			</tr>
			<?php if(!empty($authors)){?>
			<?php foreach ($authors as $key => $author) {?>
			<tr class="trow">
				<td class="text-center">
					<label><input name="main_contact[]" type="checkbox" id="main_contact" value="<?php echo $key?>"<?php if($author->main_contract == 1){?> checked<?php }?>>通訊作者</label>
				</td>
				<td>
					<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="<?php echo $author->user_first_name?>">
					<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="<?php echo $author->user_last_name?>">
				</td>
				<td>
					<input name="user_email[]" type="email" required class="form-control" id="user_email" value="<?php echo $author->user_email?>">
				</td>
				<td>
					<textarea name="user_org[]" maxlength="40" required class="form-control" id="user_org"><?php echo $author->user_org?></textarea>
				</td>
				<td><?php echo form_dropdown('user_country[]', $country_list, $author->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?></td>
				<td class="text-center">
					<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
					<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
				</td>
			</tr>
			<?php }?>
			<?php }?>
		</tbody>
	</table>
</div>