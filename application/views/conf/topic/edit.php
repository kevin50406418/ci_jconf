<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="pull-right ui button orange">所有主題列表</a>
		<h4 class="modal-title">修改研討會主題</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"topic","edit")."?id=".$topic['topic_id'],array("class"=>"form-horizontal"))?>
			<div class="form-group">
				<label for="topic_name" class="col-sm-2 control-label">主題名稱(中)</label>
				<div class="col-sm-10">
					<input name="topic_name" type="text" class="form-control" id="topic_name" value="<?php echo $topic['topic_name']?>">
				</div>
			</div>
			<div class="form-group">
				<label for="topic_ename" class="col-sm-2 control-label">主題名稱(英)</label>
				<div class="col-sm-10">
					<input name="topic_ename" type="text" class="form-control" id="topic_ename" value="<?php echo $topic['topic_name_eng']?>">
				</div>
			</div>
			<div class="form-group">
				<label for="topic_abbr" class="col-sm-2 control-label">主題簡稱</label>
				<div class="col-sm-2">
					<input name="topic_abbr" type="text" class="form-control" id="topic_abbr" value="<?php echo $topic['topic_abbr']?>">
				</div>
				<div class="col-sm-8"></div>
			</div>
			<div class="form-group">
				<label for="topic_info" class="col-sm-2 control-label">主題說明</label>
				<div class="col-sm-10">
					<textarea name="topic_info" rows="5" class="form-control" id="topic_info"><?php echo $topic['topic_info']?></textarea>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" id="add" value="更改" class="ui button blue">
			</div>
		<?php echo form_close()?>
	</div>
</div>