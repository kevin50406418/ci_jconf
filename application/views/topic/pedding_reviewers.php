<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised yellow">
	<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id))?>
	<?php echo form_hidden('type', 'del');?>
	<div class="modal-header">
		<h4 class="modal-title">分派審查(確認中)</h4>
	</div>
	<div class="modal-body">
		<?php if($pedding_count%2==0){?>
		<div class="ui info message">
			<div class="header">
				本篇稿件目前審查人人數為 <?php echo $pedding_count?>人，分派審查人人數必須為奇數個
			</div>
		</div>
		<?php }?>
		<div class="ui info message">
			<div class="header">
				目前審查為確認中，若以確認後，請按"送出"，分派審查人才算完成，分派之審查人才可進行審查稿件。
			</div>
		</div>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th> </th>
					<th>帳號(姓名)</th>
					<th>所屬機構</th>
					<th>研究領域</th>
				</tr>
			</thead>
			<?php foreach ($pedding_reviewers as $key => $user) {?>
			<tr>
				<td class="text-center">
					<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
				</td>
				<td>
					<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
					<?php echo $user->user_login?>
					(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
				</td>
				<td>
					<?php echo $user->user_org?>
				</td>
				<td>
					<?php echo $user->user_research?>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
	<button type="submit" class="ui button red">刪除審查人</button>
	<?php echo form_close()?>
	<?php
		echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id),array("class"=>"text-center"));
		echo form_hidden('type', 'confirm');
		foreach ($pedding_reviewers as $key => $user) { echo form_hidden('user_login[]', $user->user_login);}
	?>
	<button type="submit" class="ui button blue"<?php if($pedding_count%2==0){?> disabled<?php }?>>確認審查人</button>
	<?php echo form_close()?>
</div>