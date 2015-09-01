<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"news")?>" class="pull-right ui button orange">所有公告</a>
		<h4 class="modal-title">建立公告</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"news","add"),array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label for="news_title" class="col-sm-2 control-label">公告標題</label>
				<div class="col-sm-10">
					<input type="text" name="news_title" id="news_title" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="news_content" class="col-sm-2 control-label">公告內容</label>
				<div class="col-sm-10">
					<textarea name="news_content" rows="5" class="form-control ckeditor" id="news_content"></textarea>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="news_title_eng" class="col-sm-2 control-label">公告標題(英)</label>
				<div class="col-sm-10">
					<input type="text" name="news_title_eng" id="news_title_eng" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="news_content_eng" class="col-sm-2 control-label">公告內容(英)</label>
				<div class="col-sm-10">
					<textarea name="news_content_eng" rows="5" class="form-control ckeditor" id="news_content_eng"></textarea>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" id="add" value="建立" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>