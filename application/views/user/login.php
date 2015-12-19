<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="ui segment col-md-8">
		<div class="ui icon message blue">
			<i class="fa fa-info-circle icon"></i>
			<div class="content">
				<div class="header">
					<?php echo lang('regist_hint')?>
				</div>
				<p><?php echo sprintf(lang('register_here'),'<a href="'.base_url("user/signup").'" class="ui red button">'.lang('register_account').'</a>')?></p>
			</div>
		</div>
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>

		<?php echo form_open(site_url('user/login'),array('class'=>"form-horizontal")) ?>
			<div class="form-group">
				<label for="user_login" class="col-sm-2 control-label"><?php echo lang('account')?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo set_value('user_login'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="user_pass" class="col-sm-2 control-label"><?php echo lang('password')?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="user_pass" name="user_pass">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="col-sm-6">
						<button type="submit" class="ui button blue"><?php echo lang('login')?></button>
						<a href="<?php echo base_url('user/lostpwd');?>" class="ui button orange"><?php echo lang('lostpwd')?></a>
					</div>
					<div class="col-sm-6 text-right">
						<a href="<?php echo site_url();?>" class="ui button teal"><?php echo lang('back_home')?></a>
					</div>
				</div>
			</div>
			<input name="redirect" type="hidden" id="redirect" value="<?php echo $redirect?>">
		<?php echo form_close()?>
	</div>
	<div class="col-md-2"></div>
</div>