<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<h2>編輯使用者</h2>
	<?php echo form_open(get_url("dashboard",$conf_id,"user","edit",$user->user_login))?>
	<?php echo validation_errors();?>
	<div class="tabbable-panel">
		<div class="tabbable-line">
			<ul class="nav nav-tabs nav-tabs-center">
				<li class="active"> <a href="#tab_account" data-toggle="tab"> 帳號資料 </a> </li>
				<li> <a href="#tab_contact" data-toggle="tab"> 聯絡資訊 </a> </li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active container-fluid" id="tab_account">
					<div>
						<h3>帳號資料</h3>
					</div>
					<div class="form-group">
						<label for="user_id" class="control-label"><?php echo lang('account')?></label>
						<p class="form-control-static"><?php echo $user->user_login?></p>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<label for="user_lastname" class="control-label">
								<?php echo lang('user_lastname')?> <span class="text-danger">*</span>
							</label>
							<input name="user_lastname" type="text" required="required" id="user_lastname" class="form-control" value="<?php echo $user->user_last_name?>">
						</div>
						<div class="form-group col-xs-4">
							<label for="user_middlename" class="control-label">
								<?php echo lang('user_middlename')?>
							</label>
							<input name="user_middlename" type="text" id="user_middlename" class="form-control" value="<?php echo $user->user_middle_name?>">
						</div>
						<div class="form-group col-xs-4">
							<label for="user_firstname" class="control-label">
								<?php echo lang('user_firstname')?> <span class="text-danger">*</span>
							</label>
							<input name="user_firstname" type="text" required="required" id="user_firstname" class="form-control" value="<?php echo $user->user_first_name?>">
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="user_gender" class="control-label"><?php echo lang('user_gender')?> <span class="text-danger">*</span></label>
						<br>
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-primary<?php if($user->user_gender=="M"){?> active<?php }?>">
								<input type="radio" name="user_gender" id="user_gender_1" autocomplete="off" value="M"<?php if($user->user_gender=="M"){?> checked<?php }?>> <?php echo lang('user_gender_male')?>
							</label>
							<label class="btn btn-danger<?php if($user->user_gender=="F"){?> active<?php }?>">
								<input type="radio" name="user_gender" id="user_gender_2" autocomplete="off" value="F"<?php if($user->user_gender=="F"){?> checked<?php }?>> <?php echo lang('user_gender_female')?>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="user_org" class="control-label"><?php echo lang('user_org')?> <span class="text-danger">*</span></label>
						<input name="user_org" type="text"  id="user_org" class="form-control" value="<?php echo $user->user_org; ?>">

					</div>
					<div class="form-group">
						<label for="user_title" class="control-label"><?php echo lang('user_title')?> <span class="text-danger">*</span></label>
						<select name="user_title" required id="user_title" class="form-control">
							<option value="1"<?php if($user->user_title==1){?> selected="selected"<?php }?>>Mr.</option>
							<option value="2"<?php if($user->user_title==2){?> selected="selected"<?php }?>>Miss</option>
							<option value="3"<?php if($user->user_title==3){?> selected="selected"<?php }?>>Dr.</option>
							<option value="4"<?php if($user->user_title==4){?> selected="selected"<?php }?>>Professor</option>
						</select>
					</div>
					<div class="form-group">
						<label for="user_research" class="control-label"><?php echo lang('user_research')?> <span class="text-danger">*</span></label>
						<textarea name="user_research" rows="3" required class="form-control" id="user_research"><?php echo $user->user_research; ?></textarea>
					</div>
				</div>
				<div class="tab-pane container-fluid" id="tab_contact">
					<div>
						<h3>聯絡資訊</h3>
					</div>
					<div class="form-group">
						<label for="user_email" class="control-label"><?php echo lang('user_email')?> <span class="text-danger">*</span></label>
						<input name="user_email" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off" value="<?php echo $user->user_email?>">
					</div>
					<div class="form-group">
						<label for="user_postadd" class="control-label"><?php echo lang('user_postadd')?> <span class="text-danger">*</span></label>
						<div id="addr_6" class="row">
							<div class="form-group">
								<div data-role="zipcode" class="col-sm-2" data-readonly="true"></div>
								<div data-role="county" class="col-sm-2"></div>
								<div data-role="district" class="col-sm-2"></div>
							</div>
						</div>
						<div>
							<input name="user_postadd" type="text" required="required" id="user_postadd" size="20" maxlength="100" placeholder="<?php echo lang('user_poststreetadd')?>"  class="form-control col-sm-5" value="<?php echo $user->user_postaddr[2]?>">
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="form-group col-xs-8">
							<label for="user_phoneO" class="control-label">
								<?php echo lang('user_phoneO')?> <span class="text-danger">*</span>
							</label>
							<input name="user_phoneO" type="tel" required="required" id="user_phoneO" class="form-control" autocomplete="off" value="<?php echo $user->user_phone_o[0]?>">
						</div>
						<div class="form-group col-xs-4">
							<label for="user_phoneext" class="control-label">
								<?php echo lang('user_phoneO_3')?>
							</label>
							<input name="user_phoneext" type="tel" id="user_phoneext" class="form-control" autocomplete="off" value="<?php echo $user->user_phone_o[1]?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_cellphone" class="control-label"><?php echo lang('user_cellphone')?></label>
						<input name="user_cellphone" type="tel" id="user_cellphone" class="form-control" value="<?php echo $user->user_cellphone?>">
					</div>
					<div class="form-group">
						<label for="user_fax" class="control-label"><?php echo lang('user_fax')?></label>
						<input name="user_fax" type="text" id="user_fax" class="form-control" value="<?php echo $user->user_fax?>">
					</div>
					<div class="form-group">
						<label for="user_country" class="control-label"><?php echo lang('user_country')?> <span class="text-danger">*</span></label>
						<?php echo form_dropdown('user_country', $country_list, $user->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<button type="submit" class="ui button teal fluid" id="submit" name="submit"><?php echo lang('update_profile')?></button>
	</div><!-- .modal-footer -->
	<?php echo form_close()?>
</div>

