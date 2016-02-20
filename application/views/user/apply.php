<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<h1>申請研討會</h1>
	<div class="ui message info">
		<div class="ui header">申請注意事項</div>
		<ol>
			<li>本申請須經過系統管理人員審核後開啟</li>
			<li>申請核可後，系統會自動將您設為該研討會管理人員</li>
		</ol>
	</div>
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(site_url("user/apply"),array("class"=>"form-horizontal"))?>
	<table class="table table-bordered">
		<tr>
			<th class="col-sm-2 control-label">申請帳號</th>
			<td><?php echo $this->user_login?></td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">研討會ID <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_id" required value="<?php echo set_value('conf_id'); ?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">研討會名稱 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_name" required value="<?php echo set_value('conf_name'); ?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">主要聯絡人 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_master" required value="<?php echo set_value('conf_master',$user->user_first_name.$user->user_last_name)?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">聯絡信箱 <span class="text-danger">*</span></th>
			<td>
				<input type="email" class="form-control" name="conf_email" required value="<?php echo set_value('conf_email',$user->user_email)?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">聯絡電話 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_phone" required value="<?php echo set_value('conf_phone')?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">通訊地址 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_address" required value="<?php echo set_value('conf_address')?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">承辦單位 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_host" required value="<?php echo set_value('conf_host')?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">大會地點 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_place" required value="<?php echo set_value('conf_place')?>">
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">關鍵字 <span class="text-danger">*</span></th>
			<td>
				<input type="text" class="form-control" name="conf_keywords" required value="<?php echo set_value('conf_keywords')?>">
				<span class="help-block">用於研討會索引</span>
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">開設後狀態 <span class="text-danger">*</span></th>
			<td>
				<label><input type="radio" name="conf_staus" value="0" required> 隱藏</label>
				<label><input type="radio" name="conf_staus" value="1" required> 開啟</label>
				<span class="help-block">開設研討會後狀態</span>
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">管理員設置 <span class="text-danger">*</span></th>
			<td>
				<div class="radio"><label><input type="radio" name="conf_admin" value="0" required> 自動開啟研討會帳號</label></div>
				<div class="radio"><label><input type="radio" name="conf_admin" value="1" required> 請將我設置為研討會管理員</label></div>
				<span class="help-block">
					<li>開啟研討會後，便會自動以研討會ID為帳號開設使用者帳號，系統將會產生隨機密碼發送給研討會申請者</li>
					<li>請將我設置為研討會管理員：不開設研討會專用帳號</li>
				</span>
			</td>
		</tr>
		<tr>
			<th class="col-sm-2 control-label">其他任何信息</th>
			<td>
				<textarea row="5" class="form-control" name="apply_message"><?php echo set_value('apply_message')?></textarea>
			</td>
		</tr>
	</table>
	<div class="text-center">
		<button type="submit" class="ui button blue">送出申請</button>
	</div>
	<?php echo form_close();?>
</div>