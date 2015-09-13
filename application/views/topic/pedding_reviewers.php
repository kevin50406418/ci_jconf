<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised yellow">
	<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id))?>
	<?php echo form_hidden('type', 'del');?>
	<div class="modal-header">
		<h4 class="modal-title">分派審查(確認中)</h4>
	</div>
	<div class="modal-body">
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
	<?php echo form_open(get_url("dashboard",$conf_id,"topic",$paper->sub_id),array("class"=>"text-center"))?>
	<?php echo form_hidden('type', 'confirm');?>
	<button type="submit" class="ui button blue">確認審查人</button>
	<?php echo form_close()?>
</div>