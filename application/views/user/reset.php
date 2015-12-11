<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment pink">
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(site_url("user/reset/".$reset_token->user_login."/".$reset_token->reset_token),array("class"=>"form-horizontal"))?>
		<div class="form-group">
			<label for="user_id" class="col-sm-2 control-label">帳號</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $reset_token->user_login?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">新密碼 <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" name="user_pass">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">確認新密碼 <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" name="user_pass2">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" class="ui button teal" id="submit" value="更改" name="submit">
			</div>
		</div>
	<?php echo form_close()?>
</div>