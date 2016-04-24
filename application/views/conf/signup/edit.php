<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment orange">
<?php echo form_open(get_url("dashboard",$this->conf_id,"signup","edit")."?id=".$signup->signup_id,array("id"=>"conf_signup"))?>
<table class="table table-bordered">
	<tr>
		<th class="col-md-2 text-right">姓名</th>
		<td>
			<input type="text" name="user_name" class="form-control" value="<?php echo set_value('user_name',$signup->user_name); ?>">
			<?php echo form_error('user_name'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">性別</th>
		<td>
			<label class="checkbox-inline"><input name="user_gender" value="1" type="radio"<?php if( $signup->user_gender == 1 ){?> checked<?php }?>> 男</label>
			<label class="checkbox-inline"><input name="user_gender" value="0" type="radio"<?php if( $signup->user_gender == 0 ){?> checked<?php }?>> 女</label>
			<?php echo form_error('user_gender'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">飲食習慣</th>
		<td>
			<label class="checkbox-inline"><input name="user_food" value="1" type="radio"<?php if( $signup->user_food == 1 ){?> checked<?php }?>> 葷</label>
			<label class="checkbox-inline"><input name="user_food" value="0" type="radio"<?php if( $signup->user_food == 0 ){?> checked<?php }?>> 素</label>
			<?php echo form_error('user_food'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">服務單位</th>
		<td>
			<input type="text" name="user_org" class="form-control" value="<?php echo set_value('user_org',$signup->user_org); ?>">
			<?php echo form_error('user_org'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">身分職稱</th>
		<td>
			<input type="text" name="user_title" class="form-control" value="<?php echo set_value('user_title',$signup->user_title); ?>">
			<?php echo form_error('user_title'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">聯絡電話</th>
		<td>
			<input type="text" name="user_phone" class="form-control" value="<?php echo set_value('user_phone',$signup->user_phone); ?>">
			<?php echo form_error('user_phone'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">E-Mail</th>
		<td>
			<input type="email" name="user_email" class="form-control" value="<?php echo set_value('user_email',$signup->user_email); ?>">
			<?php echo form_error('user_email'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">收據抬頭</th>
		<td>
			<input type="text" name="receipt_header" class="form-control" value="<?php echo set_value('receipt_header',$signup->receipt_header); ?>">
			<?php echo form_error('receipt_header'); ?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">註冊費用</th>
		<td>
			<input id="signup_price" type="text" name="signup_price" class="form-control" value="<?php echo set_value('signup_price',$signup->signup_price); ?>">
			<?php echo form_error('signup_price'); ?>
		</td>
	</tr>
</table>
<?php $signup_type = $signup->price_type."|".$signup->price_id."|".$signup->signup_type?>
<?php $iseb = $this->signup->is_early_bird($early_bird->start_value,$early_bird->end_value,$signup->signup_time)?>
<?php echo form_error('price_type'); ?>
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
				<label class="checkbox-inline" for="pt_o<?php echo $price->type_id?>">
				<input type="radio" value="<?php echo $price->type_id."|".$price->price_id."|o"?>" name="price_type" id="pt_o<?php echo $price->type_id?>"<?php if($price->type_id."|".$price->price_id."|o" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_other?> <s><?php echo $price->other_price?></s>
				<?php }else{?>
					<?php echo $price->other_price?>
				<?php }?>
				</label>
			</td>
			<td>
				<label class="checkbox-inline" for="pt_t<?php echo $price->type_id?>">
				<input type="radio" value="<?php echo $price->type_id."|".$price->price_id."|t"?>" name="price_type" id="pt_t<?php echo $price->type_id?>"<?php if($price->type_id."|".$price->price_id."|t" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_teacher?> <s><?php echo $price->teacher_price?></s>
				<?php }else{?>
					<?php echo $price->teacher_price?>
				<?php }?>
				</label>
			</td>
			<td>
				<label class="checkbox-inline" for="pt_s<?php echo $price->type_id?>">
				<input type="radio" value="<?php echo $price->type_id."|".$price->price_id."|s"?>" name="price_type" id="pt_s<?php echo $price->type_id?>"<?php if($price->type_id."|".$price->price_id."|s" == $signup_type){?> checked<?php }?>>
				<?php if( $iseb ){?>
					<?php echo $price->early_student?> <s><?php echo $price->student_price?></s>
				<?php }else{?>
					<?php echo $price->student_price?>
				<?php }?>
				</label>
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
			<input type="text" class="form-control" id="paper_id" name="paper_id" value="<?php echo set_value('paper_id',$signup->paper_id); ?>">
		</td>
	</tr>
	<tr>
		<th class="col-md-2 text-right">論文標題</th>
		<td>
			<input type="text" class="form-control" id="paper_title" name="paper_title" value="<?php echo set_value('paper_title',$signup->paper_title); ?>">
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
			<?php echo $signup->signup_filename?>
		</td>
	</tr>
	<?php }?>
</table>
<div class="text-center">
	<div class="ui message info"><div class="header">送出表單前，請先計算費用</div></div>
	<span class="ui red horizontal label massive">費用總計：<span id="total"><?php echo $signup->signup_price?></span></span>
	<button type="button" class="ui button green huge" id="calculate">計算費用</button>
	<button type="submit" class="ui button blue huge" id="update" disabled>更新註冊資訊</button>
</div>
<?php echo form_close()?>
</div>
<script>
$(document).ready(function(){
	$("#calculate").click(function(){
		$.post('<?php echo site_url("ajax/conf_calsignup/".$this->conf_id."/".$signup->signup_id);?>', $( "#conf_signup" ).serialize(), function(data) {
			$("#total").text(data);
			$("#signup_price").val(data);
			$("#update").removeAttr("disabled");
		});
	});
	$("#update").click(function(){
		if( $("#total").text() != $("#signup_price").val() ){
			return confirm("系統計算價格與填寫價格不同，確定是否送出?");
		}
	});
});
</script>