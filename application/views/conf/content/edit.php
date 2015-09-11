<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<?php echo form_open(get_url("dashboard",$conf_id,"website","edit")."?id=".$page_id,array("class"=>"form-horizontal"))?>
<?php foreach ($content as $key => $cont) {?>
<div class="ui segment">
	<div class="modal-header">
		<h4 class="modal-title">編輯網頁 </h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">檢核清單內容</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_title" name="page_title[<?php echo $cont->page_lang?>]" value="<?php echo $cont->page_title?>">
			</div>
		</div>
		<div class="form-group">
			<label for="econtent" class="col-sm-2 control-label">檢核清單內容(英)</label>
			<div class="col-sm-10">
				<textarea name="page_content[<?php echo $cont->page_lang?>]" rows="5" class="form-control ckeditor" id="page_content"><?php echo $cont->page_content?></textarea>
			</div>
		</div>
	</div>
</div>
<?php }?>
<div class="text-center">
	<input type="submit" id="add" value="更新" class="ui button teal">
</div>
<?php echo form_close()?>