<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment raised green">
	<div class="modal-header">
		<h4 class="modal-title">編輯文字模組</h4>
	</div>
	<div class="modal-body">
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>
		<?php echo form_open(get_url("dashboard",$conf_id,"modules","edit",$module->module_id),array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label class="col-sm-2 control-label">標題</label>
				<div class="col-sm-10">
					<input type="text" name="module_title" class="form-control" value="<?php echo $module->module_title?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">位置</label>
				<div class="col-sm-10">
					<select class="form-control" name="module_position">
						<option value="content"<?php if( $module->module_position == 0){?> selected<?php }?>>Content</option>
						<option value="sidebar-1"<?php if( $module->module_position == 0){?> selected<?php }?>>Sidebar-1</option>
						<option value="sidebar-2"<?php if( $module->module_position == 0){?> selected<?php }?>>Sidebar-2</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="conf_staus" class="col-sm-2 control-label">顯示/隱藏標題</label>
				<div class="col-sm-10">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-primary<?php if( $module->module_showtitle == 0){?> active<?php }?>">
							<input type="radio" name="module_showtitle" autocomplete="off" value="0"<?php if( $module->module_showtitle == 0){?> checked<?php }?>> 顯示
						</label>
						<label class="btn btn-danger<?php if( $module->module_showtitle == 1){?> active<?php }?>">
							<input type="radio" name="module_showtitle" autocomplete="off" value="1"<?php if( $module->module_showtitle == 1){?> checked<?php }?>> 隱藏
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="conf_lang" class="col-sm-2 control-label">語言</label>
				<div class="col-sm-10">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-success<?php if( $module->module_lang == "zhtw"){?> active<?php }?>">
							<input type="radio" name="module_lang" autocomplete="off" value="zhtw"<?php if( $module->module_lang == "zhtw"){?> checked<?php }?>> 繁體中文(Traditional Chinese)
						</label>
						<label class="btn btn-warning<?php if( $module->module_lang == "eng"){?> active<?php }?>">
							<input type="radio" name="module_lang" autocomplete="off" value="eng"<?php if( $module->module_lang == "eng"){?> checked<?php }?>> 英文(English)
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">內容</label>
				<div class="col-sm-10">
					<textarea name="module_content" rows="10" class="form-control tinymce"><?php echo $module->module_content?></textarea>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" value="更新" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>