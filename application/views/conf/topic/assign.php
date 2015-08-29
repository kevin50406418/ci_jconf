<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"topic")?>" class="pull-right ui button orange">所有主題列表</a>
		<h4 class="modal-title">建立研討會主題</h4>
	</div>
	<div class="modal-body">
		<?php echo form_open(get_url("dashboard",$conf_id,"topic","assign")."?id=".$topic['topic_id'],array("class"=>"form-horizontal"))?>
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th> </th>
						<th>帳號(姓名)</th>
						<th>所屬機構</th>
						<th>研究領域</th>
					</tr>
				</thead>
				<?php foreach ($users as $key => $user) {?>
				<tr>
					<td class="text-center">
						<input type="checkbox" value="<?php echo $user->user_login?>">
					</td>
					<td>
						<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
						<?php echo $user->user_login?>
						(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
					</td>
					<td><?php echo $user->user_org?></td>
					<td><?php echo $user->user_research?></td>
				</tr>
				<?php }?>
			</table>
		<?php echo form_close()?>
	</div>
</div>
