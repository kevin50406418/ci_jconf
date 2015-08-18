<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui teal segment row">
	<h2>系統檢核</h2>
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<th colspan="2" class="text-center">稿件資訊</th>
			</tr>
			<tr>
				<th>題目</th>
				<td><?php echo $paper->sub_title?></td>
			</tr>
			<tr>
				<th>摘要</th>
				<td><?php echo $paper->sub_summary?></td>
			</tr>
			<tr>
				<th>主題</th>
				<td><?php echo $paper->name?></td>
			</tr>
			<tr>
				<th>關鍵字</th>
				<td><?php echo $paper->sub_keyword?></td>
			</tr>
			<tr>
				<th>語言</th>
				<td><?php echo $paper->sub_lang?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<th colspan="2" class="text-center">稿件檔案</th>
			</tr>
			
			<tr>
				<th>投稿資料</th>
				<td>
					<?php if(!empty($otherfile)){?>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
					<?php }else{?>
					<span class="ui label red">尚未上傳</span>
					<?php }?>
				</td>
			</tr>
			
			<?php if(!empty($otherfiles)){?>
			<?php foreach ($otherfiles as $key => $file) {?>
			<tr>
				<th>補充資料</th>
				<td>
					<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$file->fid;?>" target="_blank"><?php echo $file->file_name?></a>
				</td>
			</tr>
			<?php }?>
			<?php }?>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="5" class="text-center">作者資訊</th>
				</tr>
			</thead>
			<tr>
				<th>排序</th>
				<th>姓名</th>
				<th>電子信箱</th>
				<th>所屬機構</th>
				<th>國別</th>
			</tr>
			<?php if(!empty($authors)){?>
			<?php foreach ($authors as $key => $author) {?>
			<tr>
				<td><?php echo $author->author_order?></td>
				<td>
					<?php echo $author->user_first_name?> <?php echo $author->user_last_name?>
					<?php if( $author->main_contract ){?><span class="ui label green">主要</span><?php }?>
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
