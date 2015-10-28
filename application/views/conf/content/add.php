<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<?php echo form_open(get_url("dashboard",$conf_id,"website","add"),array("class"=>"form-horizontal"))?>
<div class="ui segment">
	<div class="modal-header">
		<h4 class="modal-title">新增網頁</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">網頁簡稱</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_id" name="page_id">
			</div>
		</div>
	</div>
	<?php if(in_array("zhtw",$conf_lang)){?>
	<div class="modal-header">
		<h4 class="modal-title">中文網頁</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">標題</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_title" name="page_title[zhtw]">
			</div>
		</div>
		<div class="form-group">
			<label for="econtent" class="col-sm-2 control-label">網頁內容</label>
			<div class="col-sm-10">
				<textarea name="page_content[zhtw]" rows="10" class="form-control tinymce" id="page_content"><div></div></textarea>
			</div>
		</div>
	</div>
	<?php }?>
	<?php if(in_array("eng",$conf_lang)){?>
	<div class="modal-header">
		<h4 class="modal-title">英文網頁</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">標題</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_title" name="page_title[en]">
			</div>
		</div>
		
		<div class="form-group">
			<label for="econtent" class="col-sm-2 control-label">網頁內容</label>
			<div class="col-sm-10">
				<textarea name="page_content[en]" rows="10" class="form-control tinymce" id="page_content"><div></div></textarea>
			</div>
		</div>
	</div>
	<?php }?>
	<div class="text-center">
		<input type="submit" id="add" value="新增網頁" class="ui button blue">
	</div>
</div>

<?php echo form_close()?>