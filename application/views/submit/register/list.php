<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<a href="<?php echo get_url("submit",$conf_id,"register","add")?>" class="ui button blue pull-right">填寫註冊資料</a>
		<h3 class="modal-title">研討會註冊</h3>
	</div>
	<div class="modal-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center" style="width: 7%">#</th>
					<th class="text-center" style="width: 20%">匯款人</th>
					<th class="text-center" style="width: 23%">匯款帳號</th>
					<!--<th class="text-center" style="width: 20%">註冊稿件</th>-->
					<th class="text-center" style="width: 10%">註冊狀態</th>
					<th class="text-center" style="width: 20%">操作</th>
				</tr>
			</thead>
			<?php foreach ($registers as $key => $register) {?>
			<tr>
				<td class="text-center"><?php echo $register->register_id?></td>
				<td><?php echo $register->user_name?></td>
				<td><?php echo $register->pay_name?>(<?php echo $register->pay_account?>)</td>
				<!--<td><?php ?></td>-->
				<td class="text-center"><?php echo $this->Submit->register_status($register->register_status,true);?></td>
				<td>
					<?php if($register->register_status <1){?><a href="<?php echo get_url("submit",$conf_id,"register","edit")?>?id=<?php echo $register->register_id?>" class="ui button basic blue">編輯</a><?php }?>
					<a href="<?php echo get_url("submit",$conf_id,"register","view")?>?id=<?php echo $register->register_id?>" class="ui button basic teal">查看</a>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>