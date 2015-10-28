<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui teal segment">
	<h2>上傳收據</h2>
	<?php echo form_open_multipart(get_url("submit",$conf_id,"register","edit")."?id=".$register->register_id,array("class"=>"form-horizontal"));?>
	<?php echo form_hidden('do', 'upload');?>
	<table class="table table-bordered">
		<tr>
			<th class="col-md-3 control-label">上傳收據</th>
			<td class="col-md-9">
				<?php if( empty($register->pay_bill) ){?>
				<p class="text-danger">收據檔案尚為上傳</p>
				<?php }else{?>
				<p>
					<a href="<?php echo get_url("submit",$conf_id,"register_files","view")?>?id=<?php echo $register->register_id?>" target="_blank">收據檔案</a>
					<a href="<?php echo get_url("submit",$conf_id,"register_files","download")?>?id=<?php echo $register->register_id?>" class="ui button blue" target="_blank">下載</a>
					<a href="<?php echo get_url("submit",$conf_id,"register_files","del")?>?id=<?php echo $register->register_id?>" class="ui button red">刪除檔案</a>
				</p>
				<?php }?>
				<input name="register_file" type="file" required="required" id="register_file" class="file file-loading" accept=".pdf,.png,.jpg">
				<p class="help-block">允許上傳的副檔名：pdf、png、jpg</p>
			</td>
		</tr>
	</table>
	<?php echo form_close()?>
</div>
<script>
$("#register_file").fileinput({
	language: "zh-TW",
    autoReplace: true,
    maxFileCount: 1,
    allowedPreviewTypes: ["image"],
    allowedFileExtensions: ["jpg", "png", "pdf"],
    removeIcon: '<i class="fa fa-trash"></i>',
    
    browseIcon: '<i class="fa fa-folder-open"></i>',
    cancelIcon: '<i class="fa fa-ban"></i>',
    uploadIcon: '<i class="fa fa-upload"></i>',
    previewFileIcon: '<i class="fa fa-file"></i>',

    previewFileIconSettings: {
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
    }
});
</script>