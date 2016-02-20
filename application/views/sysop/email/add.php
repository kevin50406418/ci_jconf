<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<div class="page-header">
		<h2>新增電子郵件樣版</h2>
	</div>
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(site_url("sysop/email/add"),array("class"=>"form-horizontal"))?>
	<table class="table table-bordered">
		<tr>
			<th class="col-md-2">電子郵件識別碼 <span class="text-danger">*</span></th>
			<td class="col-md-10">
				<input type="text" name="email_key" class="form-control" value="<?php echo set_value("email_key")?>">
			</td>
		</tr>
		<tr>
			<th>中文說明 <span class="text-danger">*</span></th>
			<td>
				<textarea name="email_desc[zhtw]" class="form-control tinymce"><?php echo set_value("email_desc[zhtw]")?></textarea>
			</td>
		</tr>
		<tr>
			<th>英文說明 <span class="text-danger">*</span></th>
			<td>
				<textarea name="email_desc[eng]" class="form-control tinymce"><?php echo set_value("email_desc[eng]")?></textarea>
			</td>
		</tr>
		<tr>
			<th>中文信件主旨 <span class="text-danger">*</span></th>
			<td>
				<input type="text" name="default_subject[zhtw]" class="form-control" value="<?php echo set_value("default_subject[zhtw]")?>">
			</td>
		</tr>
		<tr>
			<th>中文信件內容 <span class="text-danger">*</span></th>
			<td>
				<textarea name="default_body[zhtw]" class="form-control tinymce" rows="10"><?php echo set_value("default_body[zhtw]")?></textarea>
			</td>
		</tr>
		<tr>
			<th>英文信件主旨 <span class="text-danger">*</span></th>
			<td>
				<input type="text" name="default_subject[eng]" class="form-control" value="<?php echo set_value("default_subject[eng]")?>">
			</td>
		</tr>
		<tr>
			<th>英文信件內容 <span class="text-danger">*</span></th>
			<td>
				<textarea name="default_body[eng]" class="form-control tinymce" rows="10"><?php echo set_value("default_body[eng]")?></textarea>
			</td>
		</tr>
	</table>
	<div class="text-center">
		<button class="ui button blue huge">新增</button>
	</div>
	<?php echo form_close();?>
</div>
</div>