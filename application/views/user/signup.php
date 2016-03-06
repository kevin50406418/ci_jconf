<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><?php echo lang('signup')?></h3>
			</div>
			<?php echo form_open(site_url('user/signup'),array("id"=>"register"))?>
			<div class="modal-body">
				<div class="ui icon message blue">
					<i class="fa fa-info-circle icon"></i>
					<div class="content">
						<div class="header">
							<?php echo lang('login_hint')?>
						</div>
						<p><?php echo sprintf(lang('login_please'),'<a href="'.site_url("user/login").'" class="ui red button">'.lang('login').'</a>')?></p>
					</div>
				</div>
				<div class="text-center">
					<a href="#account" class="ui button blue">帳號資料</a>
					<a href="#contact" class="ui button orange">聯絡資訊</a>
					<button type="submit" class="ui button green" id="submit" name="submit"><?php echo lang('signup')?></button>
				</div>
				<?php echo validation_errors();?>
				<div class="page-header" id="account">
					<h3>帳號資料</h3>
				</div>
				<div class="form-group">
					<label for="user_id" class="control-label"><?php echo lang('account')?> <span class="text-danger">*</span></label>
					<input name="user_id" type="text" required="required" id="user_id" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?php echo set_value('user_id'); ?>">
					<span class="help-block"><?php echo lang('user_id_hint')?></span>
				</div>
				<div class="form-group">
					<label for="user_pw" class="control-label"><?php echo lang('password')?> <span class="text-danger">*</span></label>
					<input name="user_pw" type="password" required="required" id="user_pw" size="20" class="form-control" autocomplete="off">
					<span><div id="progress_bar" class="progress"></div></span>
					<span class="help-block" id="alert-pwd"></span>
					<span class="help-block"><?php echo lang('user_pw_length')?></span>
				</div>
				<div class="form-group">
					<label for="user_pw2" class="control-label"><?php echo lang('confirm_password')?> <span class="text-danger">*</span></label>
					<input name="user_pw2" type="password" required="required" id="user_pw2" size="20" class="form-control" autocomplete="off">
				</div>
				
				<div class="form-group">
					<label for="user_title" class="control-label"><?php echo lang('user_title')?> <span class="text-danger">*</span></label>
					<select name="user_title" required id="user_title" class="form-control">
						<option value="1">Mr.</option>
						<option value="2">Miss</option>
						<option value="3">Dr.</option>
						<option value="4" selected="selected">Professor</option>
					</select>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label for="user_lastname" class="control-label">
							<?php echo lang('user_lastname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_lastname" type="text" required="required" id="user_lastname" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?php echo set_value('user_lastname'); ?>">
					</div>
					<div class="col-xs-6">
						<label for="user_firstname" class="control-label">
							<?php echo lang('user_firstname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_firstname" type="text" id="user_firstname" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?php echo set_value('user_firstname'); ?>">
					</div>
				</div>
				<br>
				<div class="form-group">
					<label for="user_gender" class="control-label"><?php echo lang('user_gender')?> <span class="text-danger">*</span></label>
					<div class="radio">
						<label><input name="user_gender" type="radio" required="required" id="user_gender_1" value="M" checked="checked"><?php echo lang('user_gender_male')?></label>
					</div>
					<div class="radio">
						<label><input name="user_gender" type="radio" required="required" id="user_gender_2" value="F"><?php echo lang('user_gender_female')?></label>
					</div>
				</div>
				<div class="form-group">
					<label for="user_org" class="control-label"><?php echo lang('user_org')?> <span class="text-danger">*</span></label>
					<textarea name="user_org" rows="2" maxlength="40" required class="form-control" id="user_affiliation"><?php echo set_value('user_org'); ?></textarea>
				</div>
				<div class="form-group">
					<label for="user_lang" class="control-label"><?php echo lang('user_lang')?> <span class="text-danger">*</span></label>
					<select name="user_lang" id="user_lang" class="form-control">
						<option value="zhtw" selected="selected">繁體中文(Traditional Chinese)</option>
						<option value="eng">英文(English)</option>
					</select>
				</div>
				<div class="form-group">
					<label for="user_research" class="control-label"><?php echo lang('user_research')?> <span class="text-danger">*</span></label>
					<textarea name="user_research" rows="3" required class="form-control" id="user_research"><?php echo set_value('user_research'); ?></textarea>
				</div>
				<div class="page-header" id="contact">
					<h3>聯絡資訊</h3>
				</div>
				<div class="form-group">
					<label for="user_email" class="control-label"><?php echo lang('user_email')?> <span class="text-danger">*</span></label>
					<input name="user_email" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off" value="<?php echo set_value('user_email'); ?>">
				</div>
				
				<div class="form-group">
					<label for="user_postadd" class="control-label"><?php echo lang('user_postadd')?> <span class="text-danger">*</span></label>
					<div id="addr_6" class="row">
						<div class="form-group">
							<div data-role="zipcode" class="col-sm-2" data-readonly="true" data-value="<?php echo set_value('user_postcode'); ?>"></div>
							<div data-role="county" class="col-sm-2"></div>
							<div data-role="district" class="col-sm-2"></div>
						</div>
					</div>
					<div>
						<input name="user_postadd" type="text" required="required" id="user_postadd" size="20" maxlength="100" placeholder="<?php echo lang('user_poststreetadd')?>"  class="form-control col-sm-5" value="<?php echo set_value('user_postadd'); ?>">
					</div>
				</div>
				<br><br>
				<div class="form-group">
					<label for="user_phoneO" class="control-label"><?php echo lang('user_phoneO')?> <span class="text-danger">*</span></label>
					<div class="input-group">
						<span class="input-group-addon">(</span>
						<input name="user_phoneO_1" type="tel" required="required" id="user_phoneO_1" size="3" maxlength="5" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_1'); ?>">
						<span class="input-group-addon">)</span>
						<span class="input-group-addon">-</span>
						<input name="user_phoneO_2" type="tel" required="required" id="user_phoneO_2" size="15" maxlength="20" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_2'); ?>">
						<span class="input-group-addon"><?php echo lang('user_phoneO_3')?></span>
						<input name="user_phoneO_3" type="tel" id="user_phoneO_3" size="6" maxlength="10" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_3'); ?>">
					</div>					
				</div>
				<div class="form-group">
					<label for="user_cellphone" class="control-label"><?php echo lang('user_cellphone')?></label>
					<input name="user_cellphone" type="tel" id="user_cellphone" size="15" maxlength="15" class="form-control" value="<?php echo set_value('user_cellphone'); ?>">
				</div>
				<div class="form-group">
					<label for="user_fax" class="control-label"><?php echo lang('user_fax')?></label>
					<input name="user_fax" type="text" id="user_fax" size="15" maxlength="15" class="form-control" value="<?php echo set_value('user_fax'); ?>">
				</div>
				<div class="form-group">
					<label for="user_country" class="control-label"><?php echo lang('user_country')?> <span class="text-danger">*</span></label>
					<?php echo form_dropdown('user_country', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
				</div>
				
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="submit" class="ui button green fluid" id="submit" name="submit"><?php echo lang('signup')?></button>
			</div><!-- .modal-footer -->
			<?php echo form_close()?>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div>
