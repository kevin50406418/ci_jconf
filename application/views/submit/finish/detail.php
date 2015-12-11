<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui teal segment row">
	<div class="page-header">
		<h1>稿件資訊</h1>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<th class="text-center col-md-1">題目</th>
				<td><?php echo $paper->sub_title?></td>
			</tr>
			<tr>
				<th class="text-center col-md-1">摘要</th>
				<td><?php echo $paper->sub_summary?></td>
			</tr>
			<tr>
				<th class="text-center col-md-1">主題</th>
				<td><?php echo $paper->topic_name?></td>
			</tr>
			<tr>
				<th class="text-center col-md-1">關鍵字</th>
				<td><?php echo $paper->sub_keyword?></td>
			</tr>
			<tr>
				<th class="text-center col-md-1">語言</th>
				<td><?php echo $paper->sub_lang?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-12">
		<div class="page-header">
			<h1>稿件檔案</h1>
		</div>
		<table class="table table-bordered">
			<tr>
				<th class="text-center col-md-1">投稿資料</th>
				<td>
					<?php if(!empty($otherfile)){?>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
					<?php }else{?>
					<span class="ui label red">尚未上傳</span>
					<?php }?>
				</td>
			</tr>
			<tr>
				<th class="text-center">補充資料</th>
				<td class="list-group">
				<?php if(!empty($otherfiles)){?>
				<?php foreach ($otherfiles as $key => $file) {?>
					<a class="list-group-item" href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$file->fid;?>" target="_blank"><?php echo $file->file_name?></a>
				<?php }?>
				<?php }?>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-md-12">
		<div class="page-header">
			<h1>作者資訊</h1>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center">排序</th>
					<th class="text-center">姓名</th>
					<th class="text-center">電子信箱</th>
					<th class="text-center">所屬機構</th>
					<th class="text-center">國別</th>
				</tr>
			</thead>
			<?php if(!empty($authors)){?>
			<?php foreach ($authors as $key => $author) {?>
			<tr>
				<td class="text-center"><?php echo $author->author_order?></td>
				<td>
					<?php echo $author->user_first_name?> <?php echo $author->user_last_name?>
					<?php if( $author->main_contract ){?><span class="ui label green">通訊作者</span><?php }?>
				</td>
				<td><?php echo $author->user_email?></td>
				<td><?php echo $author->user_org?></td>
				<td><?php echo $author->user_country?></td>
			</tr>
			<?php }?>
			<?php }?>
		</table>
	</div>	
</div>
<div class="ui segment blue">
	<h3>完稿檔案</h3>
	<?php echo form_open(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
	<table class="table table-bordered" id="finish_file">
		<thead>
			<tr>
				<th class="text-center col-md-1">刪除</th>
				<th class="text-center">檔案類型</th>
				<th class="text-center">檔案名稱</th>
				<th class="text-center col-md-1">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($finishfile)){?>
			<tr>
				<td class="text-center">
					<input type="checkbox" name="del_file[]" value="<?php echo $finishfile->fid?>">
				</td>
				<td class="text-center"><span class="ui blue basic label">完稿投稿資料</span></td>
				<td><?php echo $finishfile->file_name?></td>
				<td class="text-center">
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finishfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finishfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
				</td>
			</tr>
			<?php }?>
			<?php foreach ($finishother as $key => $finish) {?>
			<tr>
				<td class="text-center">
					<input type="checkbox" name="del_file[]" value="<?php echo $finish->fid?>">
				</td>
				<td class="text-center"><span class="ui teal basic label">完稿補充資料</span></td>
				<td><?php echo $finish->file_name?></td>
				<td class="text-center">
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<div class="text-center"><button class="ui button red">刪除檔案</button></div>
	<?php echo form_close()?>
</div>