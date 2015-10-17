<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment raised green">
	<div class="modal-header">
		<h4 class="modal-title">編輯公告模組</h4>
	</div>
	<div class="modal-body">
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>
		<?php echo form_open(get_url("dashboard",$conf_id,"modules","edit",$module->module_id),array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label class="col-sm-2 control-label">標題</label>
				<div class="col-sm-10">
					<input type="text" name="module_title" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">位置</label>
				<div class="col-sm-10">
					<select class="form-control" name="module_position">
						<option value="content">Content</option>
						<option value="sidebar-1">Sidebar-1</option>
						<option value="sidebar-2">Sidebar-2</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="conf_staus" class="col-sm-2 control-label">顯示/隱藏標題</label>
				<div class="col-sm-10">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-primary active">
							<input type="radio" name="module_showtitle" autocomplete="off" value="0"checked> 顯示
						</label>
						<label class="btn btn-danger">
							<input type="radio" name="module_showtitle" autocomplete="off" value="1"> 隱藏
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="conf_lang" class="col-sm-2 control-label">語言</label>
				<div class="col-sm-10">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-success active">
							<input type="radio" name="module_lang" autocomplete="off" value="zhtw" checked> 繁體中文(Traditional Chinese)
						</label>
						<label class="btn btn-warning">
							<input type="radio" name="module_lang" autocomplete="off" value="eng"> 英文(English)
						</label>
					</div>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" id="add" value="建立" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>