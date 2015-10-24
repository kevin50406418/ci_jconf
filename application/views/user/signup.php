<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="ui icon message blue">
		<i class="fa fa-info-circle icon"></i>
		<div class="content">
			<div class="header">
				已經擁有帳號?
			</div>
			<p>請先 <a href="<?php echo base_url('user/login');?>" class="ui red button">登入</a></p>
		</div>
	</div>
	<?php echo form_open(base_url('user/signup'),array("class"=>"form-horizontal","id"=>"register"))?>
		<div class="form-group">
			<label for="user_id" class="col-sm-2 control-label text-primary">帳號</label>
			<div class="col-sm-10">
				<input name="user_id" type="text" required="required" id="user_id" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?php echo set_value('user_id'); ?>">
				<span class="help-block">使用者名稱僅能包含小寫字母、數字、和連字號/底線。</span>
			</div>
		</div>
		<div class="form-group">
			<label for="user_pw" class="col-sm-2 control-label text-primary">密碼</label>
			<div class="col-sm-10">
				<input name="user_pw" type="password" required="required" id="user_pw" size="20" class="form-control" autocomplete="off">
				<span class="help-block"><div id="progress_bar" class="progress"></div></span>
				<span class="help-block" id="alert-pwd"></span>
				<span class="help-block">密碼必須是至少 6 字符。</span>
			</div>
		</div>
		<div class="form-group">
			<label for="user_pw2" class="col-sm-2 control-label text-primary">重覆輸入密碼</label>
			<div class="col-sm-10">
				<input name="user_pw2" type="password" required="required" id="user_pw2" size="20" class="form-control" autocomplete="off">
			</div>
		</div>
		<div class="form-group">
			<label for="user_email" class="col-sm-2 control-label text-primary">電子信箱</label>
			<div class="col-sm-10">
				<input name="user_email" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off" value="<?php echo set_value('user_email'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_title" class="col-sm-2 control-label text-primary">稱謂</label>
			<div class="col-sm-10">
				<select name="user_title" required id="user_title" class="form-control">
						<option value="1">Mr.</option>
						<option value="2">Miss</option>
						<option value="3">Dr.</option>
						<option value="4" selected="selected">Professor</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="user_firstname" class="col-sm-2 control-label text-primary">名字</label>
			<div class="col-sm-10">
				<input name="user_firstname" type="text" id="user_firstname" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?php echo set_value('user_firstname'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_lastname" class="col-sm-2 control-label text-primary">姓氏</label>
			<div class="col-sm-10">
				<input name="user_lastname" type="text" required="required" id="user_lastname" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?php echo set_value('user_lastname'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_gender" class="col-sm-2 control-label text-primary">性別</label>
			<div class="col-sm-10">
				<label><input name="user_gender" type="radio" required="required" id="user_gender_1" value="M" checked="checked" class="checkbox-inline">男</label>
				<label><input name="user_gender" type="radio" required="required" id="user_gender_2" value="F" class="checkbox-inline">女</label>
			</div>
		</div>
		<div class="form-group">
			<label for="user_org" class="col-sm-2 control-label text-primary">所屬機構</label>
			<div class="col-sm-10">
				<textarea name="user_org" rows="4" maxlength="40" required class="form-control" id="user_affiliation"><?php echo set_value('user_org'); ?></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label for="user_phoneO" class="col-sm-2 control-label text-primary">電話(公)</label>
			<div class="col-sm-10">
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon">(</span>
						<input name="user_phoneO_1" type="tel" required="required" id="user_phoneO_1" size="3" maxlength="5" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_1'); ?>">
						<span class="input-group-addon">)</span>
						<span class="input-group-addon">-</span>
						<input name="user_phoneO_2" type="tel" required="required" id="user_phoneO_2" size="15" maxlength="20" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_2'); ?>">
						<span class="input-group-addon">分機</span>
						<input name="user_phoneO_3" type="tel" id="user_phoneO_3" size="6" maxlength="10" class="form-control" autocomplete="off" value="<?php echo set_value('user_phoneO_3'); ?>">
					</div>					
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="user_cellphone" class="col-sm-2 control-label text-primary">手機</label>
			<div class="col-sm-10">
				<input name="user_cellphone" type="tel" required="required" id="user_cellphone" size="15" maxlength="15" class="form-control" autocomplete="off" value="<?php echo set_value('user_cellphone'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_fax" class="col-sm-2 control-label">傳真</label>
			<div class="col-sm-10">
				<input name="user_fax" type="text" id="user_fax" size="15" maxlength="15" class="form-control" autocomplete="off" value="<?php echo set_value('user_fax'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="user_postadd" class="col-sm-2 control-label text-primary">聯絡地址</label>
			<div class="col-sm-10">
				<div id="addr_6" class="row">
					<div class="form-group">
						<label class="col-sm-2 control-label text-primary">郵遞區號:</label>
						<div data-role="zipcode" class="col-sm-2" data-readonly="true" data-value="<?php echo set_value('user_postcode'); ?>"></div>
					</div>
					<div>
						<div data-role="county" class="col-sm-2"></div>
						<div data-role="district" class="col-sm-2"></div>
					</div>
				</div>
				<div>
					街道地址:<input name="user_postadd" type="text" required="required" id="user_postadd" size="20" maxlength="100" class="form-control col-sm-5" autocomplete="off" value="<?php echo set_value('user_postadd'); ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="user_country" class="col-sm-2 control-label text-primary">國別</label>
			<div class="col-sm-10">
				<?php echo form_dropdown('user_country', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
			</div>
		</div>
		<div class="form-group">
			<label for="user_lang" class="col-sm-2 control-label text-primary">語言</label>
			<div class="col-sm-10">
				<select name="user_lang" id="user_lang" class="form-control">
					<option value="zhtw" selected="selected">繁體中文(Traditional Chinese)</option>
					<option value="eng">英文(English)</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="user_research" class="col-sm-2 control-label text-primary">研究領域</label>
			<div class="col-sm-10">
				<textarea name="user_research" rows="5" required class="form-control" id="user_research"><?php echo set_value('user_research'); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" class="ui button green" id="submit" value="註冊" name="submit">
			</div>
		</div>
	<?php echo form_close()?>
</div>
