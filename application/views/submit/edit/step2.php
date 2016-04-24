<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function() {
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: ".author",
			container: "#container",
			row: ".trow",
			cell: "td",
			row_count_placeholder: "{{row-count-placeholder}}",
		});
	});
});
</script>
<?php echo form_open(get_url("submit",$conf_id,"edit",$paper_id)."?step=2",array("class"=>"form-horizontal"))?>
<div class="ui blue segment">
	<h2>徵稿主題</h2>
	<?php if(is_array($topics)){?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="sub_topic">主題 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<select name="sub_topic" id="sub_topic" class="form-control">
				<?php foreach ($topics as $key => $topic) {?>
				<option value="<?php echo $topic->topic_id?>"<?php if($paper->sub_topic==$topic->topic_id){?> selected="selected" class="bg-info"<?php }?>><?php echo $topic->topic_name?>(<?php echo $topic->topic_name_eng?>)</option>
				<?php }?>
			</select>
		</div>
	</div>
	<?php }else{?>
	<div class="alert alert-danger">尚未建立研討會主題，請洽研討會會議管理人員</div>
	<?php }?>
	
</div>
<div class="ui blue segment">
	<h2>作者資訊</h2>
	<div class="repeat">
		<div class="author">
		<div id="container">
			<span class="add ui green button"><i class="fa fa-plus"></i> 新增作者</span>
			<div class="ui vertical segment template trow">
				<div class="form-group pull-right">
					<span class="move ui teal button"><i class="fa fa-arrows"></i> 排序位置</span>
					<span class="remove ui red button"><i class="fa fa-trash-o"></i> 刪除作者資訊</span>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><input name="main_contact[]" type="checkbox" id="main_contact" value="{{row-count-placeholder}}"> 通訊作者</label>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">名字 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">中間名 </label>
					<div class="col-sm-10">
						<input name="user_mname[]" type="text" class="form-control" id="user_mname" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">姓氏 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">電子信箱 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_email[]" type="email" required class="form-control" id="user_email" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">所屬機構 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<textarea name="user_org[]" required class="form-control" id="user_org"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">國別 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<?php echo form_dropdown('user_country[]', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
					</div>
				</div>
			</div>
			<?php if(!empty($authors)){?>
			<?php foreach ($authors as $key => $author) {?>
			<div class="ui vertical segment trow">
				<div class="form-group pull-right">
					<span class="move ui teal button"><i class="fa fa-arrows"></i> 排序位置</span>
					<span class="remove ui red button"><i class="fa fa-trash-o"></i> 刪除作者資訊</span>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><input name="main_contact[]" type="checkbox" id="main_contact" value="<?php echo $key?>"<?php if($author->main_contract == 1){?> checked<?php }?>> 通訊作者</label>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">名字 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="<?php echo $author->user_first_name?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">中間名 </label>
					<div class="col-sm-10">
						<input name="user_mname[]" type="text" class="form-control" id="user_mname" value="<?php echo $author->user_middle_name?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">姓氏 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="<?php echo $author->user_last_name?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">電子信箱 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input name="user_email[]" type="email" required class="form-control" id="user_email" value="<?php echo $author->user_email?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">所屬機構 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<textarea name="user_org[]" required class="form-control" id="user_org"><?php echo $author->user_org?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">國別 <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<?php echo form_dropdown('user_country[]', $country_list, $author->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?>
					</div>
				</div>
			</div>
			<?php }?>
			<?php }?>
		</div>
		</div>
	</div>
</div>
<div class="ui blue segment">
	<h2>篇名和摘要</h2>
	<div class="form-group">
		<label class="col-sm-2 control-label">題目 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input name="sub_title" type="text" required class="form-control" id="sub_title" value="<?php echo $paper->sub_title?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">摘要 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<textarea name="sub_summary" required id="sub_summary" class="form-control" rows="5"><?php echo $paper->sub_summary?></textarea>
		</div>
	</div>
</div>
<?php if( is_array($agrees) ){?>
<div class="ui blue segment">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center col-md-10">項目</th>
				<th class="text-center col-md-2">選項</th>
			</tr>
		</thead>
		<?php foreach ($agrees as $key => $agree) {?>
		<tr>
			<td>
				<?php echo $agree->agree_content?> <span class="text-danger">*</span>
			</td>
			<td class="text-center">
				<label class="radio-inline" for="agree_true<?php echo $key?>">
					<input id="agree_true<?php echo $key?>" type="radio" name="<?php echo $agree->agree_token?>" value="1"<?php if( element($agree->agree_token, $agree_value ) == 1){?> checked<?php }?>>
					<?php echo $agree->agree_true?>
				</label>
				<label class="radio-inline" for="agree_false<?php echo $key?>">
					<input id="agree_false<?php echo $key?>" type="radio" name="<?php echo $agree->agree_token?>" value="0"<?php if( element($agree->agree_token, $agree_value ) == 0){?> checked<?php }?>>
					<?php echo $agree->agree_false?>
				</label>
			</td>
		</tr>
		<?php }?>
	</table>
</div>
<?php }?>
<div class="ui blue segment">
	<h2>檢索和計畫補助單位</h2>
	<div class="form-group">
		<label class="col-sm-2 control-label">關鍵字 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input name="sub_keywords" type="text" required class="form-control" id="sub_keywords" value="<?php echo $paper->sub_keyword?>">
			<p class="help-block">提供一個或更多描述投稿內容的專有名詞。以半形逗號「,」來將這些專有名詞分開(專有名詞1,專有名詞2,專有名詞3)。例如：資訊安全</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">語言 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<select name="sub_lang" id="sub_lang" class="form-control">
				<option value="zhtw"<?php if($paper->sub_lang=="zhtw"){?> selected="selected" class="bg-info"<?php }?>>繁體中文(Traditional Chinese)</option>
				<option value="eng"<?php if($paper->sub_lang=="eng"){?> selected="selected" class="bg-info"<?php }?>>英文(English)</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">計畫編號 <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input name="sub_sponsor" type="text" class="form-control" id="sub_sponsor" value="<?php echo $paper->sub_sponsor?>">
			<p class="help-block">提供本發表論文研究經費補助或贊助的計畫編號，例如：國科會計畫編號NSC XX-0123-456-789</p>
		</div>
	</div>
	<div class="text-center">
		<button name="act" type="submit" class="ui button teal" value="update">更新資訊</button>
		<button name="act" type="submit" class="ui button blue" value="next">更新後下一步</button>
        <a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
	</div>
</div>

<?php echo form_close()?>
