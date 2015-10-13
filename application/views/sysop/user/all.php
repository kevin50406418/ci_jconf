<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment">
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>帳號(姓名)</th>
			<th>所屬機構</th>
			<th>操作</th>
		</tr>
	</thead>
	<?php foreach ($users as $key => $user) {?>
	<tr>
		<td>
			<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
			<?php echo $user->user_login?>
			(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
			<div class="pull-right">
			<?php if($user->user_sysop == 1){?>
				<span class="ui red label">系統管理員</span>
			<?php }?>
			<?php if($user->user_staus == 1){?>
				<span class="ui black label">停用</span>
			<?php }else if($user->user_staus == 2){?>
				<span class="ui grey label">驗證中</span>
			<?php }?>
			</div>
		</td>
		<td>
			<?php echo $user->user_org?>
		</td>
		<td>
			<a href="<?php echo base_url("sysop/user/edit/".$user->user_login)?>" class="ui button blue tiny"><i class="fa fa-pencil-square-o"></i> 編輯</a>
			<a href="<?php echo base_url("sysop/user/view/".$user->user_login)?>" class="ui button teal tiny">查看</a>
			<?php if($user->user_staus == 1){?><a href="#" class="ui button green tiny">啟用</a><?php }?>
			<a href="#" class="ui button orange tiny">重設密碼</a>
		</td>
	</tr>
	<?php }?>
</table>
</div>
</div>