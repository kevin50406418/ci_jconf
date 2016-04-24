<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment orange">
<h2>更改註冊狀態</h2>
<?php echo form_open(get_url("dashboard",$this->conf_id,"signup","status")."?id=".$signup->signup_id)?>
<table class="table table-bordered">
	<tr>
		<th class="text-right col-md-2">原註冊狀態</th>
		<td>
			<?php echo $this->signup->signup_status($signup->signup_status)?>
		</td>
		<th class="text-right col-md-2">更改註冊狀態</th>
		<td>
			<div class="radio">
				<label>
					<input type="radio" name="signup_status" value="0"<?php if($signup->signup_status==0){?> checked<?php }?>>
					繳費記錄上傳中
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="signup_status" value="1"<?php if($signup->signup_status==1){?> checked<?php }?>>
					繳費記錄已上傳
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="signup_status" value="2"<?php if($signup->signup_status==2){?> checked<?php }?>>
					註冊失敗
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="signup_status" value="3"<?php if($signup->signup_status==3){?> checked<?php }?>>
					註冊成功
				</label>
			</div>
		</td>
	</tr>
</table>
<div class="text-center">
	<button type="submit" class="ui button blue huge">更改繳費狀態</button>
</div>
<?php echo form_close()?>
</div>