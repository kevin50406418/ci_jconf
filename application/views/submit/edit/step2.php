<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script type="text/javascript">
	$(function() {
		$(".repeat").each(function() {
			$(this).repeatable_fields({
				wrapper: ".author",
				container: "#container"
			});
		});
	});
</script>
<?php echo form_open(get_url("submit",$conf_id,"edit",$paper_id)."?step=3",array("class"=>"form-horizontal"))?>
<div class="ui blue segment">
	<h2>徵稿主題</h2>
	<?php if(is_array($topics)){?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="sub_topic">主題</label>
		<div class="col-sm-10">
			<select name="sub_topic" id="sub_topic" class="form-control">
				<?php foreach ($topics as $key => $topic) {?>
				<option value="<?php echo $topic->ID?>"<?php if($paper->sub_topic==$topic->ID){?> selected="selected" class="bg-info"<?php }?>><?php echo $topic->name?>(<?php echo $topic->name_eng?>)</option>
				<?php }?>
			</select>
		</div>
	</div>
	<?php }else{?>
	<div class="alert alert-danger">尚未建立研討會主題，請洽研討會會議管理人員</div>
	<?php }?>
	
</div>
<div class="ui blue segment repeat">
	<h2>作者資訊</h2>
	<div class="author">
		<div id="container">
			<div class="ui vertical segment template row">
				<?php include(dirname(dirname(__FILE__))."/author_template.php");?>
			</div>
			<div class="ui vertical segment row">
				<?php include("author.php");?>
			</div>
		</div>
	</div>
</div>
<div class="ui blue segment">
	<h2>篇名和摘要</h2>
	<div class="form-group">
		<label class="col-sm-2 control-label">題目</label>
		<div class="col-sm-10">
			<input name="sub_title" type="text" required class="form-control" id="sub_title" value="<?php echo $paper->sub_title?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">摘要</label>
		<div class="col-sm-10">
			<textarea name="sub_summary" required id="sub_summary" class="form-control"><?php echo $paper->sub_summary?></textarea>
		</div>
	</div>

</div>
<div class="ui blue segment">
	<h2>檢索和計畫補助單位</h2>
	<div class="form-group">
		<label class="col-sm-2 control-label">關鍵字</label>
		<div class="col-sm-10">
			<input name="sub_keywords" type="text" required class="form-control" id="sub_keywords" value="<?php echo $paper->sub_keyword?>">
			<p class="help-block">提供一個或更多描述投稿內容的專有名詞。以半形逗號「,」來將這些專有名詞分開(專有名詞1,專有名詞2,專有名詞3)。例如：資訊安全</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">語言</label>
		<div class="col-sm-10">
			<select name="sub_lang" id="sub_lang" class="form-control">
				<option value="zhtw"<?php if($paper->sub_lang=="zhtw"){?> selected="selected" class="bg-info"<?php }?>>繁體中文(Traditional Chinese)</option>
				<option value="eng"<?php if($paper->sub_lang=="eng"){?> selected="selected" class="bg-info"<?php }?>>英文(English)</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">計畫編號</label>
		<div class="col-sm-10">
			<input name="sub_sponsor" type="text" class="form-control" id="sub_sponsor" value="<?php echo $paper->sub_sponsor?>">
			<p class="help-block">提供本發表論文研究經費補助或贊助的計畫編號，例如：國科會計畫編號NSC XX-0123-456-789或亞洲大學計畫編號1XX-asia-XX</p>
		</div>
	</div>
	<div class="text-center">
		<input name="sub_1" type="submit" class="ui blue button" id="sub_1" value="下一步" >
        <a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
	</div>
</div>

<?php echo form_close()?>
