<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8" />
<title>Excel</title>
</head>
<body>
<table border="1" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="text-center">序號</th>
			<th class="text-center">姓名</th>
			<th class="text-center">性別</th>
			<th class="text-center">飲食習慣</th>
			<th class="text-center">服務單位</th>
			<th class="text-center">身分職稱</th>
			<th class="text-center">聯絡電話</th>
			<th class="text-center">收據抬頭</th>
			<th class="text-center">註冊信箱</th>
			<th class="text-center">論文編號</th>
			<th class="text-center">論文標題</th>
			<th class="text-center">備註</th>

			<th class="text-center">註冊類型</th>
			<th class="text-center">註冊身分</th>
			<th class="text-center">註冊費用</th>
			<th class="text-center">註冊狀態</th>
			
			<th class="text-center">填寫時間</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($signups as $key => $signup) {?>
		<tr>
			<td class="text-center">
				<?php echo $signup->signup_id?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_name?>
			</td>
			<td class="text-center">
				<?php if( $signup->user_food == 0 ){?>女<?php }else{?>男<?php }?>
			</td>
			<td class="text-center">
				<?php if( $signup->user_food == 0 ){?>素<?php }else{?>葷<?php }?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_org?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_title?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_phone?>
			</td>
			<td class="text-center">
				<?php echo $signup->receipt_header?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_email?>
			</td>
			<td class="text-center">
				<?php echo $signup->paper_id?>
			</td>
			<td class="text-center">
				<?php echo $signup->paper_title?>
			</td>
			<td class="text-center">
				<?php echo $signup->user_note?>
			</td>
			<td class="text-center">
				<?php echo $this->signup->signup_type($signup->signup_type,true)?>
			</td>
			<td class="text-center">
				<?php echo $signup->type_name?>
			</td>
			<td class="text-center">
				<?php echo $signup->signup_price?>
			</td>
			<td class="text-center">
				<?php echo $this->signup->signup_status($signup->signup_status,true)?>
			</td>
			<td class="text-center">
				<?php echo date("Y-m-d H:i:s",$signup->signup_time)?>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
</body>
</html>