<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment red">
	<div class="page-header">
		<h2>忘記密碼</h2>
	</div>
	<?php echo form_open(base_url('user/lostpwd'),array("class"=>"form-horizontal"))?>
		<div class="form-group">
			<label for="user_login" class="col-sm-2 control-label">帳號</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="user_login" name="user_login">
			</div>
		</div>
		<div class="form-group">
			<label for="user_email" class="col-sm-2 control-label">電子信箱</label>
			<div class="col-sm-10">
				<input name="user_email" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="g-recaptcha" id="recaptcha" data-sitekey="6Lf-HgITAAAAAMXFSUusTegO_eHAGjP0Ux_viuaN"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="ui button orange">送出</button>
			</div>
		</div>
	<?php echo form_close()?>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>