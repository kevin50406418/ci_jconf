<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment orange">
<h2>密碼設定</h2>
<?php echo form_open(get_url("dashboard",$this->conf_id,"signup","passwd")."?id=".$signup->signup_id)?>
<table class="table table-bordered">
	<tr>
		<th>註冊信箱</th>
		<td>
			<?php echo $signup->user_email; ?>
		</td>
	</tr>
	<tr>
		<th>密碼 <span class="text-danger">*</span></th>
		<td>
			<input type="password" name="user_pass" class="form-control">
			<?php echo form_error('user_pass'); ?>
		</td>
	</tr>
	<tr>
		<th>驗證密碼 <span class="text-danger">*</span></th>
		<td>
			<input type="password" name="user_pass2" class="form-control">
			<?php echo form_error('user_pass2'); ?>
		</td>
	</tr>
</table>
<div class="text-center">
	<button type="submit" class="ui button blue huge">更新密碼</button>
</div>
<?php echo form_close()?>
</div>