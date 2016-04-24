<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<h3>完稿上傳</h3>
<!-- 1. 簽完 copyright form 的掃瞄檔 2,完稿 論文, 3. 論文摘要檔 -->
<table class="table table-bordered">
	<tr>
		<th class="col-md-2">copyright form</th>
		<td class="col-md-10">
			<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
			<div class="col-md-9">
				<input name="finish_copyright" type="file" required="required" id="finish_copyright" accept=".pdf">
			</div>
			<div class="col-md-3">
				<button class="ui button green huge" type="submit">上傳檔案</button>
			</div>
			<!-- <p class="help-block">只限PDF上傳投稿資料</p> -->
			<?php echo form_close()?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2">完稿論文</th>
		<td class="col-md-10">
			<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
			<div class="col-md-9">
				<input name="finish_file" type="file" required="required" id="finish_file" accept=".pdf">
			</div>
			<div class="col-md-3">
				<button class="ui button green huge" type="submit">上傳完稿論文</button>
			</div>
			<p class="help-block col-md-12">完稿論文只限PDF上傳</p>
			<?php echo form_close()?>
		</td>
	</tr>
	<tr>
		<th class="col-md-2">論文摘要檔</th>
		<td class="col-md-10">
			<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
			<div class="col-md-9">
				<input name="finish_abstract" type="file" required="required" id="finish_abstract" accept=".pdf">
			</div>
			<div class="col-md-3">
				<button class="ui button green huge" type="submit">上傳論文摘要檔</button>
			</div>
			<p class="help-block col-md-12">論文摘要檔只限PDF上傳</p>
			<?php echo form_close()?>
		</td>
	</tr>
</table>
</div>
<script>
$(function(){
	$("#finish_copyright").fileinput({
		language: "zh-TW",
	    autoReplace: true,
	    allowedPreviewTypes: [],
	    allowedFileExtensions: ["pdf"],
	    removeIcon: '<i class="fa fa-trash"></i>',
	    
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    cancelIcon: '<i class="fa fa-ban"></i>',
	    uploadIcon: '<i class="fa fa-upload"></i>',
	    previewFileIcon: '<i class="fa fa-file"></i>',

	    previewFileIconSettings: {
	        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
	    }
	});
	$("#finish_file").fileinput({
		language: "zh-TW",
	    autoReplace: true,
	    maxFileCount: 1,
	    allowedPreviewTypes: [],
	    allowedFileExtensions: ["pdf"],
	    removeIcon: '<i class="fa fa-trash"></i>',
	    
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    cancelIcon: '<i class="fa fa-ban"></i>',
	    uploadIcon: '<i class="fa fa-upload"></i>',
	    previewFileIcon: '<i class="fa fa-file"></i>',

	    previewFileIconSettings: {
	        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
	    }
	});
	$("#finish_abstract").fileinput({
		language: "zh-TW",
	    autoReplace: true,
	    maxFileCount: 1,
	    allowedPreviewTypes: [],
	    allowedFileExtensions: ["pdf"],
	    removeIcon: '<i class="fa fa-trash"></i>',
	    
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    cancelIcon: '<i class="fa fa-ban"></i>',
	    uploadIcon: '<i class="fa fa-upload"></i>',
	    previewFileIcon: '<i class="fa fa-file"></i>',

	    previewFileIconSettings: {
	        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
	    }
	});
	$("#files input[type='checkbox']").change(function (e) {
		if ($(this).is(":checked")) { //If the checkbox is checked
			$(this).closest('tr').addClass("danger"); 
		} else {
			$(this).closest('tr').removeClass("danger");
		}
	});
});
</script>