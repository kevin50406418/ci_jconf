<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<h3>完稿檔案</h3>
	<?php echo form_open(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
	<table class="table table-bordered" id="files">
		<thead>
			<tr>
				<th class="text-center col-md-1">刪除</th>
				<th class="text-center col-md-2">檔案類型</th>
				<th class="text-center col-md-8">檔案名稱</th>
				<th class="text-center col-md-1">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($finishes as $key => $finish) {?>
			<tr>
				<td class="text-center">
					<input type="checkbox" name="del_file[]" value="<?php echo $finish->fid?>">
				</td>
				<td class="text-center">
					<?php echo file_type($finish->file_type)?>
				</td>
				<td>
					<?php echo $finish->file_name?>
				</td>
				<td class="text-center">
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<div class="text-center">
		<button class="ui button red">刪除檔案</button>
	</div>
	<?php echo form_close()?>
</div>