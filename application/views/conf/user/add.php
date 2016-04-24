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
					<label for="user_id" class="control-label"><?php echo lang('account')?> <span class="text-danger">*</span></label>
					<input name="user_id[]" type="text" required="required" id="user_id" class="form-control">
					<span class="help-block"><?php echo lang('user_id_hint')?></span>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="user_lastname" class="control-label">
							<?php echo lang('user_lastname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_lastname[]" type="text" required="required" id="user_lastname" class="form-control">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_middlename" class="control-label">
							<?php echo lang('user_middlename')?>
						</label>
						<input name="user_middlename[]" type="text" id="user_middlename" class="form-control">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_firstname" class="control-label">
							<?php echo lang('user_firstname')?> <span class="text-danger">*</span>
						</label>
						<input name="user_firstname[]" type="text" required="required" id="user_firstname" class="form-control">
					</div>
				</div>
				<br>
				<div class="form-group">
					<label for="user_gender" class="control-label"><?php echo lang('user_gender')?> <span class="text-danger">*</span></label>
					<div class="radio">
						<label><input name="user_gender[]" type="radio" required="required" id="user_gender_1" value="M" checked="checked"><?php echo lang('user_gender_male')?></label>
						<label><input name="user_gender[]" type="radio" required="required" id="user_gender_2" value="F"><?php echo lang('user_gender_female')?></label>
					</div>
				</div>
				<div class="form-group">
					<label for="user_org" class="control-label"><?php echo lang('user_org')?> <span class="text-danger">*</span></label>
					<input name="user_org[]" type="text" id="user_org" class="form-control">

				</div>
				<div class="form-group">
					<label for="user_title" class="control-label"><?php echo lang('user_title')?> <span class="text-danger">*</span></label>
					<select name="user_title[]" required id="user_title" class="form-control">
						<option value="1">Mr.</option>
						<option value="2">Miss</option>
						<option value="3">Dr.</option>
						<option value="4" selected="selected">Professor</option>
					</select>
				</div>
				<div class="form-group">
					<label for="user_research" class="control-label"><?php echo lang('user_research')?> <span class="text-danger">*</span></label>
					<textarea name="user_research[]" rows="3" required class="form-control" id="user_research"></textarea>
				</div>
				<div class="form-group">
					<label for="user_email" class="control-label"><?php echo lang('user_email')?> <span class="text-danger">*</span></label>
					<input name="user_email[]" type="email" required="required" id="user_email" size="30" maxlength="50" class="form-control" autocomplete="off">
				</div>
				<div class="form-group">
					<label for="user_postadd" class="control-label"><?php echo lang('user_postadd')?> <span class="text-danger">*</span></label>
					<div class="row addr_{{row-count-placeholder}}">
						<div class="form-group">
							<div data-role="zipcode" data-name="user_postcode[]" data-readonly="true" class="col-sm-3"></div>
							<div data-role="county" data-name="user_addcounty[]" class="col-sm-2"></div>
							<div data-role="district" data-name="user_area[]" class="col-sm-2"></div>
						</div>
					</div>
					<div>
						<input name="user_postadd[]" type="text" required="required" id="user_postadd" size="20" maxlength="100" placeholder="<?php echo lang('user_poststreetadd')?>"  class="form-control col-sm-5">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						<label for="user_phoneO" class="control-label">
							<?php echo lang('user_phoneO')?> <span class="text-danger">*</span>
						</label>
						<input name="user_phoneO[]" type="tel" required="required" id="user_phoneO" class="form-control" autocomplete="off">
					</div>
					<div class="form-group col-xs-4">
						<label for="user_phoneext[]" class="control-label">
							<?php echo lang('user_phoneO_3')?>
						</label>
						<input name="user_phoneext[]" type="tel" id="user_phoneext" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="user_country" class="control-label"><?php echo lang('user_country')?> <span class="text-danger">*</span></label>
					<?php echo form_dropdown('user_country[]', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
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