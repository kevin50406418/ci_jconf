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
					<th class="text-center" style="width: 10%">#</th>
					<th class="text-center" style="width: 20%">匯款人</th>
					<th class="text-center" style="width: 20%">匯款帳號</th>
					<th class="text-center" style="width: 20%">註冊稿件</th>
					<th class="text-center" style="width: 10%">註冊狀態</th>
					<th class="text-center" style="width: 20%">操作</th>
				</tr>
			</thead>
			
		</table>
	</div>
</div>