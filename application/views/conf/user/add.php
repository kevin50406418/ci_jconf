<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<div class="ui segment">
	<div class="ui info message">
		<div class="header">
			系統會於建立帳號後，隨機產生密碼並發送 email 給使用者。
		</div>
	</div>
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(get_url("dashboard",$conf_id,"user","add"))?>
	<div class="repeat">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td colspan="3"><span class="add btn btn-success">新增欄位</span></td>
			</tr>
		</thead>
		<tbody class="container">
		<tr class="template row">
			<td class="col-md-11">
				<div class="form-group">
					<label for="user_id" class="col-sm-2 control-label">帳號 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_id[]" type="text" required="required" id="user_id" size="20" maxlength="30" class="form-control" autocomplete="off">
						<span class="help-block">使用者名稱僅能包含小寫字母、數字、和連字號/底線。</span>
					</div>
				</div>
				<div class="form-group">
					<label for="user_email" class="col-sm-2 control-label">電子信箱 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_email[]" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="user_title" class="col-sm-2 control-label">稱謂 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select name="user_title[]" required id="user_title" class="form-control">
								<option value="1">Mr.</option>
								<option value="2">Miss</option>
								<option value="3">Dr.</option>
								<option value="4" selected="selected">Professor</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="user_firstname" class="col-sm-2 control-label">名字 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_firstname[]" type="text" id="user_firstname" size="20" maxlength="30" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="user_lastname" class="col-sm-2 control-label">姓氏 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_lastname[]" type="text" required="required" id="user_lastname" size="20" maxlength="20" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="user_gender" class="col-sm-2 control-label">性別 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select name="user_gender[]" class="form-control">
							<option value="M">男</option>
							<option value="F">女</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="user_org" class="col-sm-2 control-label">所屬機構 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<textarea name="user_org[]" rows="4" maxlength="40" required class="form-control" id="user_affiliation"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="user_phoneO" class="col-sm-2 control-label">電話(公) <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">(</span>
								<input name="user_phoneO_1[]" type="tel" required="required" id="user_phoneO_1" size="3" maxlength="5" class="form-control" autocomplete="off">
								<span class="input-group-addon">)</span>
								<span class="input-group-addon">-</span>
								<input name="user_phoneO_2[]" type="tel" required="required" id="user_phoneO_2" size="15" maxlength="20" class="form-control" autocomplete="off">
								<span class="input-group-addon">分機</span>
								<input name="user_phoneO_3[]" type="tel" id="user_phoneO_3" size="6" maxlength="10" class="form-control" autocomplete="off">
							</div>					
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="user_postadd" class="col-sm-2 control-label">聯絡地址 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<div class="row form-inline addr_{{row-count-placeholder}}">
							<div data-role="zipcode" data-name="user_postcode[]" data-readonly="true" class="col-sm-3"></div>
							<div data-role="county" data-name="user_addcounty[]" class="col-sm-2"></div>
							<div data-role="district" data-name="user_area[]" class="col-sm-2"></div>
						</div>
						<div class="help-block">
							<input name="user_postadd[]" type="text" required="required" id="user_postadd" size="20" maxlength="100" class="form-control col-sm-5" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="user_country" class="col-sm-2 control-label">國別 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<?php echo form_dropdown('user_country[]', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
					</div>
				</div>
				<div class="form-group">
					<label for="user_research" class="col-sm-2 control-label">研究領域 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<textarea name="user_research[]" rows="5" required class="form-control" id="user_research"></textarea>
					</div>
				</div>
			</td>
			<td class="col-md-1">
				<span class="remove btn btn-danger">刪除欄位</span>
			</td>
		</tr>
		</tbody>
	</table>
	</div> <!-- .repeat -->
	<button type="submit" class="ui button blue">新增使用者</button>
	<?php echo form_close()?>
</div>
<script type="text/javascript">
$(function () {
	$('.repeat').each(function() {
		$(this).repeatable_fields({
			wrapper: 'table',
			container: 'tbody',
		});
	});
});
</script>