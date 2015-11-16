<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="cell">
	<div class="text-right">
		<span class="add ui green button">新增</span>
		<span class="move ui teal button">移動</span>
		<span class="remove ui red button">刪除</span>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<div class="radio">
			<label>
				<input name="main_contact" type="radio" required id="main_contact" value="1" checked>通訊作者</label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">名字 <span class="text-danger">*</span></label>
	<div class="col-sm-10">
		<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="<?php echo $user->user_first_name?>">
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">姓氏 <span class="text-danger">*</span></label>
	<div class="col-sm-10">
		<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="<?php echo $user->user_last_name?>">
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">電子信箱 <span class="text-danger">*</span></label>
	<div class="col-sm-10">
		<input name="user_email[]" type="email" required class="form-control" id="user_email" value="<?php echo $user->user_email?>">
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">所屬機構 <span class="text-danger">*</span></label>
	<div class="col-sm-10">
		<textarea name="user_org[]" maxlength="40" required class="form-control" id="user_org"><?php echo $user->user_org?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">國別 <span class="text-danger">*</span></label>
	<div class="col-sm-10">
		<?php echo form_dropdown('user_country[]', $country_list, $user->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
	</div>
</div>
