<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment orange">
<h2>上傳繳費紀錄</h2>
<?php echo form_open_multipart(get_url("dashboard",$this->conf_id,"signup","upload")."?id=".$signup->signup_id);?>
	<div class="col-md-8">
		<input type="file" name="file" accept=".jpg,.png,.bmp,.pdf">
	</div>
	<div class="col-md-4">
		<button type="submit" class="ui button blue">上傳檔案</button>
	</div>
	<div class="text-info">※上傳格式限定為圖片檔(jpg、png、bmp)及 PDF 檔</div>
<?php echo form_close()?>
</div>