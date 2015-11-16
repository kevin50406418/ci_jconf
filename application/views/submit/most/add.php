<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<a href="<?php echo get_url("submit",$conf_id,"most")?>" class="ui button teal pull-right">報名列表</a>
		<h3 class="modal-title">科技部成果發表</h3>
	</div>
	<div class="modal-body">
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open_multipart(get_url("submit",$conf_id,"most","add"),array("class"=>"form-horizontal"));?>
		<h2>計畫資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表方式 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="most_method" type="radio" value="P">海報發表</label>
					<label class="checkbox-inline"><input name="most_method" type="radio" value="O">口頭發表</label>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫編號 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_number" type="text" class="form-control" id="most_number" value="<?php echo set_value('most_number'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫中文名稱 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_name" type="text" class="form-control" id="most_name" value="<?php echo set_value('most_name'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫英文名稱 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_name_eng" type="text" class="form-control" id="most_name_eng" value="<?php echo set_value('most_name_eng'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫主持人 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_host" type="text" class="form-control" id="most_host" value="<?php echo set_value('most_host'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校) <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_uni" type="text" class="form-control" id="most_uni" value="<?php echo set_value('most_uni'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所) <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most_dept" type="text" class="form-control" id="most_dept" value="<?php echo set_value('most_dept'); ?>">
				</td>
			</tr>
		</table>
		<h2>發表者資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表者姓名 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_name" type="text" class="form-control" id="report_name" value="<?php echo set_value('report_name'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校) <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_uni" type="text" class="form-control" id="report_uni" value="<?php echo set_value('report_uni'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所) <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_dept" type="text" class="form-control" id="report_dept" value="<?php echo set_value('report_dept'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">職稱 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_title" type="text" class="form-control" id="report_title" value="<?php echo set_value('report_title'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">Email <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_email" type="email" class="form-control" id="report_email" value="<?php echo set_value('report_email'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">電話 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="report_phone" type="text" class="form-control" id="report_phone" value="<?php echo set_value('report_phone'); ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">用餐習慣 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="report_meal" type="radio" value="2">素</label>
					<label class="checkbox-inline"><input name="report_meal" type="radio" value="1">葷</label>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">餐券 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<?php foreach ($hold_day as $key => $day) {?>
					<label class="checkbox-inline"><input name="report_mealtype" type="radio" value="<?php echo $day?>"> <?php echo $day?></label>
					<?php }?>
					<label class="checkbox-inline"><input name="report_mealtype" type="radio" value="S">自理</label>
					<label class="checkbox-inline"><input name="report_mealtype" type="radio" value="P">成果發表當天(隨議程而定)</label>
				</td>
			</tr>
		</table>
		
		<h2>電子檔資料</h2>
		<table class="table table-bordered" id="file">
			<tr>
				<th class="col-sm-2 control-label">授權同意書 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most[auth]" type="file" class="form-control" id="most_auth">
					<div class="text-primary">
						依科技部工程司規定，進行成果發表的計畫主持人需填寫「授權同意書」，以示同意大會將此海報上傳至E-TOP平台及將相關資料繳回科技部工程司。
					</div>
					<div class="text-danger">上傳僅限pdf,doc,docx</div>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">成果資料表 <span class="text-danger">*</span></th>
				<td class="col-sm-10">
					<input name="most[result]" type="file" class="form-control" id="most_result">
					<div class="text-danger">上傳僅限pdf,doc,docx</div>
				</td>
			</tr>
			<tr id="row"></tr>
		</table>
		<div class="text-center">
			<button type="submit" class="ui teal button">送出</button>
		</div>
	<?php echo form_close()?>
	</div>
</div>
<table id="hidden_table" style="display: none">
<tr id="hidden_row"></tr>
<tr id="poster">
	<th class="col-sm-2 control-label">成果海報電子檔 <span class="text-danger">*</span></th>
	<td class="col-sm-10">
		<input name="most[poster]" type="file" class="form-control" id="most_poster">
		<p class="text-danger">口頭報告者不須上傳</p>
		<div class="text-danger">上傳僅限pdf,doc,docx</div>
	</td>
</tr>
</table>
<script>
$(document).ready(function(){
	$('input[name=most_method]').change(function(){
		if( $(this).val() == "P" ){
			$("#row").after( $( "#poster" ));
		}else if( $(this).val() == "O" ){
			$("#hidden_row").after( $( "#poster" )).hide();
		}
	});
});
</script>
