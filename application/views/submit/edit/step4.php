<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
if(!is_null($this->input->get("upload"))){
	if(!empty($this->upload->display_errors())){
		echo $this->upload->display_errors('<div class="ui message red">', ' <a href="javascript:history.back();">返回上一頁</a></div>');
	}
}
?>

<div class="ui blue segment">
	<?php echo form_open_multipart(get_url("submit",$conf_id,"edit",$paper_id)."?step=4&upload",array("class"=>"form-horizontal"));?>
	<div class="ui message info">若未要上傳補充資料，請選擇下一步</div>
	<h2>上傳補充資料</h2>
	<div id="alert"></div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">投稿資料</label>
		<div class="col-sm-8">
			<input name="paper_file[]" type="file" multiple id="paper_file" accept=".pdf">
			<p class="help-block">只限PDF上傳投稿資料(一次可多個上傳檔案)</p>
		</div>
		<div class="col-sm-2">
			<input name="check2" type="submit" class="ui teal button" id="check2" value="上傳" >
		</div>
	</div>
	<?php echo form_close()?>
	<div class="text-center">
		<?php echo form_open(get_url("submit",$conf_id,"add")."?step=5")?>
			<input name="sub_4" type="submit" class="ui blue button" id="sub_4" value="下一步" >
			<a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
		<?php echo form_close()?>
	</div>
</div>

<div class="ui blue segment">
	<h2>確認補充文件</h2>
	<?php if(is_array($otherfiles)){?>
	<?php echo form_open(get_url("submit",$conf_id,"edit",$paper_id)."?step=4&delfile")?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>刪除</th>
					<th>上傳檔案</th>
				</tr>
			</thead>
			<?php foreach ($otherfiles as $key => $otherfile) {?>
			<tr>
				<td>
					<input type="checkbox" name="del_file[]" value="<?php echo $otherfile->fid?>">
				</td>
				<td>
					<i class="fa fa-file-pdf-o fa-2x"></i>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name;?></a>
				</td>
			</tr>
			<?php }?>
		</table>
		<input type="submit" value="刪除所選檔案" onClick="return confirm('確定是否刪除?\n注意：刪除後檔案將無法復原');" name="del" class="ui orange button">
	<?php echo form_close()?>
	<?php }else{?>
		<div class="ui message info">目前無補充任何文件</div>
	<?php }?>
</div>