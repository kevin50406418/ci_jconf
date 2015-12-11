<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment">
	<div class="modal-header">
		<h4 class="modal-title">重設 <?php echo $user_login;?>密碼</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(site_url("sysop/user/reset/".$user_login),array("class"=>"form-horizontal"))?>
		<div class="form-group">
			<label for="user_id" class="col-sm-2 control-label">新密碼 <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<div class="input-group">
					<input name="user_pass" type="text" class="form-control" autocomplete="off" value="<?php echo $passwd?>">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit" value="get" name="type">產生密碼</button>
					</span>
				</div>
			</div>
		</div>
		<button class="ui button blue" type="submit" value="update" name="type">更新</button>
		<?php echo form_close();?>
	</div>
</div>
</div>