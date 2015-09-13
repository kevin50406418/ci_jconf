<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo form_open(get_url("dashboard",$conf_id,"user"),array("class"=>"ui segment raised orange"))?>
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
<?php echo form_close()?>