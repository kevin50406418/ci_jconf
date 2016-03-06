<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<dvi class="pull-right">
					<a href="<?php echo site_url();?>" class="ui button teal"><?php echo lang('back_home')?></a>
					<a href="<?php echo base_url('user/signup');?>" class="ui button green"><?php echo lang('signup')?></a>
					<a href="<?php echo base_url('user/lostpwd');?>" class="ui button orange"><?php echo lang('lostpwd')?></a>
				</dvi>
				<h3 class="modal-title"><?php echo lang('login')?></h3>
			</div>
			<?php echo form_open(site_url('user/login'))?>
			<div class="modal-body">
				<div class="ui icon message blue">
					<i class="fa fa-info-circle icon"></i>
					<div class="content">
						<div class="header">
							<?php echo lang('regist_hint')?>
						</div>
						<p><?php echo sprintf(lang('register_here'),'<a href="'.base_url("user/signup").'" class="ui red button">'.lang('register_account').'</a>')?></p>
					</div>
				</div>
				<?php echo validation_errors();?>
				<input name="redirect" type="hidden" id="redirect" value="<?php echo $redirect?>">
				<div class="form-group">
					<label for="user_login" class="control-label"><?php echo lang('account')?> / <?php echo lang('user_email')?> <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo set_value('user_login'); ?>">
				</div>
				<div class="form-group">
					<label for="user_pass" class="control-label"><?php echo lang('password')?> <span class="text-danger">*</span></label>
					<input type="password" class="form-control" id="user_pass" name="user_pass">
				</div>
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="submit" class="ui button blue fluid"><?php echo lang('login')?></button>
			</div><!-- .modal-footer -->
			<?php echo form_close()?>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div>

