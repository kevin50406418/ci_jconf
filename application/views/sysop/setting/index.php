<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment">
	<div class="modal-header">
		<h4 class="modal-title">系統設定</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(site_url("sysop/setting"),array("class"=>"form-horizontal"))?>
		<div class="form-group">
			<label for="user_id" class="col-sm-2 control-label">網站名稱</label>
			<div class="col-sm-10">
				<input name="site_name" type="text" class="form-control" autocomplete="off" value="<?php echo $this->config->item('site_name');?>">
			</div>
		</div>
		<button class="ui button blue" type="submit">更新</button>
		<?php echo form_close();?>
	</div>
</div>
</div>