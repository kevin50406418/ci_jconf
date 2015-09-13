<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id),array("class"=>"ui segment raised orange"))?>
	<?php echo form_hidden('type', 'add');?>
	<div class="modal-header">
		<h4 class="modal-title">分派審查</h4>
	</div>
	<div class="modal-body">
		<?php if($pedding_count>=5){?>
		<div class="ui info message">
			<div class="header">
				本篇稿件目前審查人人數為 5人，無法再分派審查人
			</div>
		</div>
		<?php }?>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th> </th>
					<th>帳號(姓名)</th>
					<th>所屬機構</th>
					<th>研究領域</th>
				</tr>
			</thead>
			<?php foreach ($reviewers as $key => $user) {?>
			<?php if( !in_array($user->user_login,$not_reviewers) ){?>
			<tr>
				<td class="text-center">
					<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]"<?php if($pedding_count>=5){?> disabled<?php }?>>
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
			<?php }?>
		</table>
	</div>
	<div class="text-center">
		<button type="submit" class="ui button blue<?php if($pedding_count>=5){?> disabled<?php }?>">新增審查人</button>
	</div>
<?php echo form_close()?>
