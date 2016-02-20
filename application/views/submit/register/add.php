<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<a href="<?php echo get_url("submit",$conf_id,"register")?>" class="ui button teal pull-right">註冊報名列表</a>
		<h3 class="modal-title">研討會註冊</h3>
	</div>
	<div class="modal-body">
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(get_url("submit",$conf_id,"register","add"),array("class"=>"form-horizontal"));?>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">註冊人姓名</th>
				<td class="col-sm-10">
					<input name="user_name" type="text" class="form-control" id="user_name" value="<?php echo $user->user_last_name; ?><?php echo $user->user_first_name; ?>">
					<p class="help-block">一次限填一人，若多人報名或同一作者註冊多篇論文者，請分開填寫。</p>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">所屬機構</th>
				<td class="col-sm-10">
					<input name="user_org" type="text" class="form-control" id="user_org" value="<?php echo $user->user_org; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">聯絡電話</th>
				<td class="col-sm-10">
					<input name="user_phone" type="text" class="form-control" id="user_phone" value="<?php echo $user->user_cellphone; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">E-mail</th>
				<td class="col-sm-10">
					<input name="user_email" type="email" class="form-control" id="user_email" value="<?php echo $user->user_email; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">匯款人</th>
				<td class="col-sm-10">
					<input name="pay_name" type="text" class="form-control" id="pay_name" value="<?php echo set_value('pay_name'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">匯款日期</th>
				<td class="col-sm-10">
					<input name="pay_date" type="date" class="form-control" id="pay_number" value="<?php echo set_value('pay_date'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">匯款後5碼</th>
				<td class="col-sm-10">
					<input name="pay_account" type="text" size="5" maxlength="5" class="form-control" id="pay_account" value="<?php echo set_value('pay_account'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">收據抬頭</th>
				<td class="col-sm-10">
					<input name="bill_title" type="text" class="form-control" id="bill_title" value="<?php echo set_value('bill_title'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">統一編號</th>
				<td class="col-sm-10">
					<input name="uniform_number" type="text" size="8" maxlength="8" class="form-control" id="uniform_number" value="<?php echo set_value('uniform_number'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">餐券類型</th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="meal_type" type="radio" value="2" <?php echo set_radio("meal_type", "2"); ?>>素</label>
					<label class="checkbox-inline"><input name="meal_type" type="radio" value="1" <?php echo set_radio("meal_type", "1"); ?>>葷</label>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">研討會用餐</th>
				<td class="col-sm-10">
					<?php foreach ($register_meals as $key => $register_meal) {?>
					<label class="checkbox-inline text-bold">
						<input type="checkbox" name="meal_id[]" value="<?php echo $register_meal->meal_id;?>" <?php echo set_checkbox("meal_id[]", $register_meal->meal_id); ?>> <?php echo $register_meal->meal_name;?>
					</label>
					<?php }?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">繳費稿件</th>
				<td class="col-sm-10">
					<table class="table table-bordered">
						<?php $i=0;foreach ($papers as $key => $paper) {?>
						<?php if(in_array($paper->sub_status,array(4))){$i++;?>
							<tr>
								<td class="text-center">
									<input type="checkbox" name="paper_id[]" value="<?php echo $paper->sub_id?>" <?php echo set_checkbox("paper_id[]", $paper->sub_id); ?>>
								</td>
								<td>
									<?php echo $paper->sub_title?>
								</td>
								<td>
									<span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span>
								</td>
								<td class="text-center">
									<?php echo $this->submit->sub_status($paper->sub_status,true)?>
								</td>
							</tr>
						<?php }?>
						<?php }?>
					</table>
					<?php if($i == 0){?>
					<div class="ui icon message orange">
						<i class="fa fa-exclamation-triangle icon"></i>
						<div class="content">
							<div class="header">
								提示
							</div>
							<p>稿件狀態被設為 成功 才能對稿件註冊繳費</p>
						</div>
					</div>
					<?php }?>
				</td>
			</tr>
		</table>
		<div class="text-center">
			<button type="submit" class="ui button blue">送出</button>
		</div>
	<?php echo form_close()?>
	</div>
</div>
		