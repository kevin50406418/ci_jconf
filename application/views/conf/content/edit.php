<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<?php echo form_open(get_url("dashboard",$conf_id,"website","edit")."?id=".$content->page_id."&lang=".$content->page_lang,array("class"=>"form-horizontal"))?>
<div class="ui segment">
	<div class="modal-header">
		<h4 class="modal-title">編輯網頁 - <?php echo $content->page_title?>(<?php echo $content->page_id?>)</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">標題</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_title" name="page_title" value="<?php echo $content->page_title?>">
			</div>
		</div>
		<div class="form-group">
			<label for="econtent" class="col-sm-2 control-label">網頁內容</label>
			<div class="col-sm-10">
				<textarea name="page_content" rows="5" class="form-control ckeditor" id="page_content"><?php echo $content->page_content?></textarea>
			</div>
		</div>
	</div>
	<div class="text-center">
		<input type="submit" id="add" value="更新" class="ui button teal">
	</div>
</div>

<?php echo form_close()?>