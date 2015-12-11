<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo form_open(site_url('sysop/login'),array('class'=>"form-signin")) ?>
	<h2 class="form-signin-heading">系統管理</h2>
	<label for="user_login" class="sr-only">帳號</label>
	<input type="text" id="user_login" class="form-control" value="<?php echo $this->session->user_login?>" disabled>
	<label for="user_pass" class="sr-only">密碼</label>
	<input type="password" id="user_pass" name="user_pass" class="form-control" placeholder="密碼" required autofocus>
	<button class="ui button teal fluid" type="submit">登入</button>
<?php echo form_close()?>