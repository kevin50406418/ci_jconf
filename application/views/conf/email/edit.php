<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<div class="page-header">
		<h2>編輯電子郵件樣版</h2>
	</div>
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(get_url("dashboard",$conf_id,"email","edit")."?key=".$template->email_key,array("class"=>"form-horizontal"))?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">說明</h3>
		</div>
			<div class="panel-body">
				<?php echo $template->email_desc?>
			</div>
	</div>
	<table class="table table-bordered">
		<tr>
			<th>中文信件主旨 <span class="text-danger">*</span></th>
			<td>
				<input type="text" name="subject_zhtw" class="form-control" value="<?php echo set_value("subject_zhtw",$template->email_subject_zhtw)?>">
			</td>
		</tr>
		<tr>
			<th>中文信件內容 <span class="text-danger">*</span></th>
			<td>
				<textarea name="body_zhtw" class="form-control tinymce" rows="10"><?php echo set_value("body_zhtw",$template->email_body_zhtw)?></textarea>
			</td>
		</tr>
		<tr>
			<th>英文信件主旨 <span class="text-danger">*</span></th>
			<td>
				<input type="text" name="subject_eng" class="form-control" value="<?php echo set_value("subject_eng",$template->email_subject_eng)?>">
			</td>
		</tr>
		<tr>
			<th>英文信件內容 <span class="text-danger">*</span></th>
			<td>
				<textarea name="body_eng" class="form-control tinymce" rows="10"><?php echo set_value("body_eng",$template->email_body_eng)?></textarea>
			</td>
		</tr>
	</table>
	<div class="text-center">
		<button class="ui button teal huge">更新</button>
	</div>
	<?php echo form_close();?>
</div>