<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php 
if(is_null($this->input->get("upload"))){
	echo validation_errors('<div class="ui message red">', '<a href="javascript:history.back();">返回上一頁</a></div>');
}else{
	echo $this->upload->display_errors('<div class="ui message red">', ' <a href="javascript:history.back();">返回上一頁</a></div>');
	if( $show_file && !empty($otherfile) ){?>
	<?php echo form_open(get_url("submit",$conf_id,"add")."?step=4",array("class"=>"form-horizontal"))?>
		<div class="ui blue segment">
			<h2>確認上傳文件</h2>
			<div class="form-group">
				<div class="col-sm-2 control-label">上傳檔案</div>
				<div class="col-sm-10">
					<p class="form-control-static"><i class="fa fa-file-pdf-o fa-2x"></i> <a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>"><?php echo $otherfile->file_name;?></a></p>
				</div>
			</div>
			<div class="text-center">
				<input name="sub_3" type="submit" class="ui blue button" id="sub_3" value="下一步" >
				<a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
			</div>
		</div>
	<?php echo form_close()?>
	<br>
	<?php }
}
?>
<?php echo form_open_multipart(get_url("submit",$conf_id,"add")."?step=3&upload",array("class"=>"form-horizontal"));?>
<div class="ui blue segment">
	<h2>上傳投稿文件</h2>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">投稿文件</label>
		<div class="col-sm-8">
			<input name="paper_file" type="file" required="required" id="paper_file" accept=".pdf">
			<p class="help-block">只限PDF上傳投稿資料</p>
		</div>
		<div class="col-sm-2">
			<input name="check" type="submit" class="ui teal button" id="check" value="上傳" >
		</div>
	</div>
</div>
<?php echo form_close()?>