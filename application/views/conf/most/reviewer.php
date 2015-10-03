<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<h3 class="modal-title">審查資料</h3>
	</div>
	<div class="modal-body">
		<div class="ui message blue">
			<div class="header">
				是否接受本篇報名資料?
				<?php echo form_open(get_url("dashboard",$conf_id,"most","detail")."?id=".$most->most_id)?>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-success active">
							<input type="radio" name="options" autocomplete="off" value="1" checked> 接受
						</label>
						<label class="btn btn-danger">
							<input type="radio" name="options" autocomplete="off" value="0"> 拒絕
						</label>
					</div>
					<button type="submit" class="ui button primary">送出</button>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>
