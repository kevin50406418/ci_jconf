<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment orange">
<table class="table table-bordered">
	<tr>
		<th class="col-md-2 text-right">註冊狀態</th>
		<td>
			<?php echo $this->signup->signup_status($signup->signup_status)?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">姓名</th>
		<td>
			<?php echo $signup->user_name?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">性別</th>
		<td>
			<label class="checkbox-inline"><input disabled type="radio"<?php if( $signup->user_gender == 1 ){?> checked<?php }?>> 男</label>
			<label class="checkbox-inline"><input disabled type="radio"<?php if( $signup->user_gender == 0 ){?> checked<?php }?>> 女</label>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">飲食習慣</th>
		<td>
			<label class="checkbox-inline"><input disabled type="radio"<?php if( $signup->user_food == 1 ){?> checked<?php }?>> 葷</label>
			<label class="checkbox-inline"><input disabled type="radio"<?php if( $signup->user_food == 0 ){?> checked<?php }?>> 素</label>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">服務單位</th>
		<td>
			<?php echo $signup->user_org?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">身分職稱</th>
		<td>
			<?php echo $signup->user_title?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">聯絡電話</th>
		<td>
			<?php echo $signup->user_phone?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">E-Mail</th>
		<td>
			<?php echo $signup->user_email?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">收據抬頭</th>
		<td>
			<?php echo $signup->receipt_header?>
		</td>
	</tr>
</table>
<?php $signup_type = $signup->price_type."|".$signup->price_id."|".$signup->signup_type?>
<?php $iseb = $this->signup->is_early_bird($early_bird->start_value,$early_bird->end_value,$signup->signup_time)?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="col-md-6"></th>
			<th class="col-md-2">一般人士</th>
			<th class="col-md-2">教師</th>
			<th class="col-md-2">學生</th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($prices as $key => $price) {?>
		<tr>
			<th>
				<?php if( $iseb ){?>
				<div class="ui green horizontal label">早鳥</div>
				<?php }?>
				<?php echo $price->type_name?>
			</th>
			<td>
				<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|o" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_other?> <s><?php echo $price->other_price?></s>
				<?php }else{?>
					<?php echo $price->other_price?>
				<?php }?>
			</td>
			<td>
				<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|t" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_teacher?> <s><?php echo $price->teacher_price?></s>
				<?php }else{?>
					<?php echo $price->teacher_price?>
				<?php }?>
			</td>
			<td>
				<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|s" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_student?> <s><?php echo $price->student_price?></s>
				<?php }else{?>
					<?php echo $price->student_price?>
				<?php }?>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
<h2>論文註冊</h2>
<table class="table table-bordered">
	<tr>
		<th class="col-md-2 text-right">論文編號</th>
		<td>
			<?php echo $signup->paper_id?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">論文標題</th>
		<td>
			<?php echo $signup->paper_title?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">備註</th>
		<td>
			<?php echo $signup->user_note?>
		</td>
	</tr>
	<?php if( $signup->signup_status>0 ){?>
	<tr>
		<th class="col-md-2 text-right">繳費紀錄</th>
		<td>
			<a href="<?php echo site_url("upload/registration")?>/<?php echo $this->conf_id?>/<?php echo $signup->signup_filename?>"><?php echo $signup->signup_filename?></a>
		</td>
	</tr>
	<?php }?>
</table>
</div>