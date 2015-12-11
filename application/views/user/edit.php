<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(site_url("user/index"),array("class"=>"form-horizontal"))?>
		<div class="form-group">
			<label for="user_id" class="col-sm-2 control-label"><?php echo lang('account')?></label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $user->user_login?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="user_email" class="col-sm-2 control-label"><?php echo lang('user_email')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input name="user_email" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off" value="<?php echo $user->user_email?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_title" class="col-sm-2 control-label"><?php echo lang('user_title')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<select name="user_title" required id="user_title" class="form-control">
					<option value="1"<?php if($user->user_title==1){?> selected="selected"<?php }?>>Mr.</option>
					<option value="2"<?php if($user->user_title==2){?> selected="selected"<?php }?>>Miss</option>
					<option value="3"<?php if($user->user_title==3){?> selected="selected"<?php }?>>Dr.</option>
					<option value="4"<?php if($user->user_title==4){?> selected="selected"<?php }?>>Professor</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="user_firstname" class="col-sm-2 control-label"><?php echo lang('user_firstname')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input name="user_firstname" type="text" id="user_firstname" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?php echo $user->user_first_name?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_lastname" class="col-sm-2 control-label"><?php echo lang('user_lastname')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input name="user_lastname" type="text" required="required" id="user_lastname" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?php echo $user->user_last_name?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_gender" class="col-sm-2 control-label"><?php echo lang('user_gender')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary<?php if($user->user_gender=="M"){?> active<?php }?>">
						<input type="radio" name="user_gender" id="user_gender_1" autocomplete="off" value="M"<?php if($user->user_gender=="M"){?> checked<?php }?>> <?php echo lang('user_gender_male')?>
					</label>
					<label class="btn btn-danger<?php if($user->user_gender=="F"){?> active<?php }?>">
						<input type="radio" name="user_gender" id="user_gender_2" autocomplete="off" value="F"<?php if($user->user_gender=="F"){?> checked<?php }?>> <?php echo lang('user_gender_female')?>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="user_org" class="col-sm-2 control-label"><?php echo lang('user_org'); ?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<textarea name="user_org" rows="4" maxlength="40" required class="form-control" id="user_org"><?php echo $user->user_org?></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label for="user_phoneO" class="col-sm-2 control-label"><?php echo lang('user_phoneO')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon">(</span>
						<input name="user_phoneO_1" type="tel" required="required" id="user_phoneO_1" size="3" maxlength="5" class="form-control" autocomplete="off" value="<?php echo $user->user_phone_o[0]?>">
						<span class="input-group-addon">)</span>
						<span class="input-group-addon">-</span>
						<input name="user_phoneO_2" type="tel" required="required" id="user_phoneO_2" size="15" maxlength="20" class="form-control" autocomplete="off" value="<?php echo $user->user_phone_o[1]?>">
						<span class="input-group-addon"><?php echo lang('user_phoneO_3')?></span>
						<input name="user_phoneO_3" type="tel" id="user_phoneO_3" size="6" maxlength="10" class="form-control" autocomplete="off" value="<?php echo $user->user_phone_o[2]?>">
					</div>					
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="user_cellphone" class="col-sm-2 control-label"><?php echo lang('user_cellphone')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input name="user_cellphone" type="tel" required="required" id="user_cellphone" size="15" maxlength="15" class="form-control" autocomplete="off" value="<?php echo $user->user_cellphone?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_fax" class="col-sm-2 control-label"><?php echo lang('user_fax')?></label>
			<div class="col-sm-10">
				<input name="user_fax" type="text" id="user_fax" size="15" maxlength="15" class="form-control" autocomplete="off" value="<?php echo $user->user_fax?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_postadd" class="col-sm-2 control-label"><?php echo lang('user_postadd')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<div id="addr_6" class="row">
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo lang('user_postcode')?>: <span class="text-danger">*</span></label>
						<div data-role="zipcode" class="col-sm-2" data-readonly="true"></div>
					</div>
					<div>
						<div data-role="county" class="col-sm-2"></div>
						<div data-role="district" class="col-sm-2"></div>
					</div>
				</div>
				<div>
					<?php echo lang('user_poststreetadd')?>:<input name="user_postadd" type="text" required="required" id="user_postadd" size="20" maxlength="100" class="form-control col-sm-5" autocomplete="off" value="<?php echo $user->user_postaddr[2]?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="user_country" class="col-sm-2 control-label"><?php echo lang('user_country')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<?php echo form_dropdown('user_country', $country_list, $user->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
			</div>
		</div>
		<div class="form-group">
			<label for="user_lang" class="col-sm-2 control-label"><?php echo lang('user_lang')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<select name="user_lang" id="user_lang" class="form-control">
					<option value="zhtw"<?php if($user->user_lang=="zhtw"){?> selected="selected"<?php }?>>繁體中文(Traditional Chinese)</option>
					<option value="eng"<?php if($user->user_lang=="eng"){?> selected="selected"<?php }?>>英文(English)</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="user_research" class="col-sm-2 control-label"><?php echo lang('user_research')?> <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<textarea name="user_research" rows="5" required class="form-control" id="user_research"><?php echo $user->user_research; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" class="ui button teal" id="submit" value="<?php echo lang('update_profile')?>" name="submit">
			</div>
		</div>
	<?php echo form_close();?>
</div>
