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
					<button type="button" class="ui button brown" data-toggle="modal" data-target="#personal_agree">個資蒐集、處理、利用告知暨同意書</button>
				</div>
				<?php echo validation_errors();?>
				<div class="page-header" id="account">
					<h3>帳號資料</h3>
				</div>
				<div class="form-group">
					<label for="user_id" class="control-label"><?php echo lang('account')?> <span class="text-danger">*</span></label>
					<input name="user_id" type="text" required="required" id="user_id" class="form-control" value="<?php echo set_value('user_id'); ?>">
					<span class="help-block"><?php echo lang('user_id_hint')?></span>
				</div>
				<div class="form-group">
					<label for="user_pw" class="control-label"><?php echo lang('password')?> <span class="text-danger">*</span></label>
					<input name="user_pw" type="password" required="required" id="user_pw" class="form-control">
					<span><div id="progress_bar" class="progress"></div></span>
					<span class="help-block" id="alert-pwd"></span>
					<span class="help-block"><?php echo lang('user_pw_length')?></span>
				</div>
				<div class="form-group">
					<label for="user_pw2" class="control-label"><?php echo lang('confirm_password')?> <span class="text-danger">*</span></label>
					<input name="user_pw2" type="password" required="required" id="user_pw2" size="20" class="form-control">
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="user_lastname" class="control-label">
							<?php echo lang('user_lastname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_lastname" type="text" required="required" id="user_lastname" class="form-control" value="<?php echo set_value('user_lastname'); ?>">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_middlename" class="control-label">
							<?php echo lang('user_middlename')?>
						</label>
						<input name="user_middlename" type="text" id="user_middlename" class="form-control" value="<?php echo set_value('user_middlename'); ?>">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_firstname" class="control-label">
							<?php echo lang('user_firstname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_firstname" type="text" required="required" id="user_firstname" class="form-control" value="<?php echo set_value('user_firstname'); ?>">
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
					<textarea name="user_org" rows="3" required class="form-control" id="user_org"><?php echo set_value('user_org'); ?></textarea>

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
				<div class="row">
					<div class="form-group col-xs-8">
						<label for="user_phoneO" class="control-label">
							<?php echo lang('user_phoneO')?> <span class="text-danger">*</span>
						</label>
						<input name="user_phoneO" type="tel" required="required" id="user_phoneO" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO'); ?>">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_phoneext" class="control-label">
							<?php echo lang('user_phoneO_3')?>
						</label>
						<input name="user_phoneext" type="tel" id="user_phoneext" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneext'); ?>">
					</div>
				</div>
			
				<div class="form-group">
					<label for="user_cellphone" class="control-label"><?php echo lang('user_cellphone')?></label>
					<input name="user_cellphone" type="tel" id="user_cellphone" class="form-control" value="<?php echo set_value('user_cellphone'); ?>">
				</div>
				<div class="form-group">
					<label for="user_fax" class="control-label"><?php echo lang('user_fax')?></label>
					<input name="user_fax" type="text" id="user_fax" class="form-control" value="<?php echo set_value('user_fax'); ?>">
				</div>
				<div class="form-group">
					<label for="user_country" class="control-label"><?php echo lang('user_country')?> <span class="text-danger">*</span></label>
					<?php echo form_dropdown('user_country', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
				</div>
				
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="submit" class="ui button green fluid" id="submit" name="submit"><?php echo lang('signup')?>並同意個人資料蒐集、處理、利用告知暨同意書</button>
			</div><!-- .modal-footer -->
			<?php echo form_close()?>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div>
<div class="modal fade" id="personal_agree" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<?php echo $this->config->item('site_name');?> 個人資料蒐集、處理、利用告知暨同意書
				</h4>
			</div>
			<div class="modal-body">
				<p>本系統為落實個人資料之保護，茲依據個人資料保護法（以下稱個資法）第8條規定告知下列事項：</p>
				<ol>
					<li>蒐集目的：辦理各項研討會活動、保險及相關行政管理。</li>
					<li>個資類別：辨識個人者如姓名、職稱、聯絡方式、地址等。現行之受僱情形如公司名稱、部門、職稱等。</li>
					<li>利用期間：至蒐集目的消失為止。</li>
					<li>利用地區：本系統僅於中華民國領域內利用您的個人資料。</li>
					<li>利用對象及方式：於蒐集目的之必要範圍內，利用您的個人資料。</li>
					<li>當事人權利：您可向本系統聯絡人行使查詢或請求閱覽、製給複製本、補充或更正、停止蒐集處理利用或刪除您的個人資料之權利，電話：04-23323456轉6301。</li>
					<li>不同意之權益影響：若您不同意提供個人資料，本系統將無法為您提供特定目的之相關服務。</li>
				</ol>
				<p>本人已閱讀並了解上述之告知事項，並同意 <?php echo $this->config->item('site_name');?>在符合上述告知事項範圍內蒐集、處理及利用本人個人資料。</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">同意</button>
				<a href="<?php echo site_url()?>" class="btn btn-danger">不同意</a>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#personal_agree').modal('show');
})
</script>