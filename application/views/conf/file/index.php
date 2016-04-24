<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<?php echo $this->upload->display_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open_multipart(get_url("dashboard",$conf_id,"file"));?>
	<?php echo form_hidden("act","upload")?>
	<p><input name="file[]" type="file" multiple="true" id="files" accept=".<?php echo $accept_ext;?>"></p>
	<div class="text-center">
		<button type="submit" class="ui button blue huge">上傳</button>
	</div>
	<?php echo form_close()?>
</div>
<div class="ui segment blue">
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>檔名</th>
			<th>更新時間</th>
			<th>檔案大小</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($files as $key => $file) {?>
	<?php $file['name'] = get_basename(rtrim($file['server_path'], '/'));?>
	<tr>
		<td>
			<i class="fa fa-lg fa-<?php echo get_fileicon(get_mime_by_extension($file['server_path']))?>"></i>
			<?php echo $file['name'];?>
		</td>
		<td>
			<?php echo date("Y-m-d H:i:s",$file['date'])?>
		</td>
		<td>
			<?php echo byte_format($file['size'])?>
		</td>
		<td>
			<?php echo form_open(get_url("dashboard",$conf_id,"file"))?>
			<a target="_blank" href="<?php echo site_url("upload/files/".$this->conf_id."/".$file['name'])?>" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> 查看</a>
			<?php echo form_hidden("act","remove")?>
			<?php echo form_hidden("file",base64_encode($file['name']))?>
			<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> 刪除</button>
			<?php echo form_close()?>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
</div>
<script>
$("#files").fileinput({
	language: "zh-TW",
    autoReplace: true,
    allowedPreviewTypes: [],
    allowedFileExtensions: ["<?php echo $allowedPreviewTypes;?>"],
    removeIcon: '<i class="fa fa-trash"></i>',
    browseIcon: '<i class="fa fa-folder-open"></i>',
    cancelIcon: '<i class="fa fa-ban"></i>',
    uploadIcon: '<i class="fa fa-upload"></i>',
    previewFileIcon: '<i class="fa fa-file"></i>',
});
</script>

