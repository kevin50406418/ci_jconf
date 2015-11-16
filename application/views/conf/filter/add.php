<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
</script>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"filter")?>" class="pull-right ui button orange">所有投稿檢核清單</a>
		<h4 class="modal-title">建立投稿檢核清單</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"filter","add"),array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label for="content" class="col-sm-2 control-label">檢核清單內容 <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<textarea name="content" rows="5" class="form-control ckeditor" id="content"><?php echo set_value('content')?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="econtent" class="col-sm-2 control-label">檢核清單內容(英) <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<textarea name="econtent" rows="5" class="form-control ckeditor" id="econtent"><?php echo set_value('econtent')?></textarea>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" id="add" value="建立" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>