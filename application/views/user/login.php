<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="ui segment col-md-8">
		<div class="ui icon message blue">
			<i class="fa fa-info-circle icon"></i>
			<div class="content">
				<div class="header">
					尚未建立冊帳號？
				</div>
				<p>請在此網站 <a href="<?php echo base_url('user/signup');?>" class="ui red button">建立帳號</a></p>
			</div>
		</div>
		<?php echo form_open('user/login',array('class'=>"form-horizontal")) ?>
			<div class="form-group">
				<label for="user_login" class="col-sm-2 control-label">帳號 <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="user_login" name="user_login">
				</div>
			</div>
			<div class="form-group">
				<label for="user_pass" class="col-sm-2 control-label">密碼 <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="user_pass" name="user_pass">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="col-sm-6">
						<button type="submit" class="ui button blue">登入</button>
						<a href="<?php echo base_url('user/lostpwd');?>" class="ui button orange">忘記密碼</a>
					</div>
					<div class="col-sm-6 text-right">
						<a href="<?php echo site_url();?>" class="ui button teal">返回首頁</a>
					</div>
				</div>
			</div>
			<input name="redirect" type="hidden" id="redirect" value="<?php echo $redirect?>">
		<?php echo form_close()?>
	</div>
	<div class="col-md-2"></div>
</div>