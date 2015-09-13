<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
<div class="ui inverted segment">
	<div class="ui buttons">
		<button class="ui inverted teal button" name="type" value="add_admin">設為研討會管理員</button>
		<button class="ui inverted pink button" name="type" value="del_admin">取消研討會管理員</button>
	</div>

	<div class="ui buttons">
		<button class="ui inverted orange button" name="type" value="add_review">設為審查人</button>
		<button class="ui inverted purple button" name="type" value="del_review">取消審查人</button>
	</div>
</div>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th> </th>
			<th>帳號(姓名)</th>
			<th>所屬機構</th>
			<th>操作</th>
		</tr>
	</thead>
	<?php foreach ($users as $key => $user) {?>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
		</td>
		<td>
			<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
			<?php echo $user->user_login?>
			(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
			<div class="pull-right">
			<?php if($user->user_staus == 2){?>
				<span class="ui grey label">驗證中</span>
			<?php }?>
			</div>
		</td>
		<td>
			<?php echo $user->user_org?>
		</td>
		<td>
			<a href="#" class="ui button blue tiny"><i class="fa fa-pencil-square-o"></i> 編輯</a>
			<a href="#" class="ui button teal tiny">查看</a>
			<a href="#" class="ui button orange tiny">重設密碼</a>
		</td>
	</tr>
	<?php }?>
</table>

</div>
