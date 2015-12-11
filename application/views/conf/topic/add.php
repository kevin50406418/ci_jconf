<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="pull-right ui button orange"><?php echo lang('topic_all')?></a>
		<h4 class="modal-title"><?php echo lang('topic_add')?></h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"topic","add"),array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label for="topic_name" class="col-sm-2 control-label"><?php echo lang('topic_name_zhtw')?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input name="topic_name" type="text" class="form-control" id="topic_name" value="<?php echo set_value('topic_name')?>">
				</div>
			</div>
			<div class="form-group">
				<label for="topic_ename" class="col-sm-2 control-label"><?php echo lang('topic_name_eng')?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<input name="topic_ename" type="text" class="form-control" id="topic_ename" value="<?php echo set_value('topic_ename')?>">
				</div>
			</div>
			<div class="form-group">
				<label for="topic_abbr" class="col-sm-2 control-label"><?php echo lang('topic_abbr')?> <span class="text-danger">*</span></label>
				<div class="col-sm-2">
					<input name="topic_abbr" type="text" class="form-control" id="topic_abbr" value="<?php echo set_value('topic_abbr')?>">
				</div>
				<div class="col-sm-8"></div>
			</div>
			<div class="form-group">
				<label for="topic_info" class="col-sm-2 control-label"><?php echo lang('topic_desc')?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<textarea name="topic_info" rows="5" class="form-control" id="topic_info"><?php echo set_value('topic_info')?></textarea>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" id="add" value="<?php echo lang('topic_create')?>" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>