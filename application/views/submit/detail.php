<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_info" data-toggle="tab"> 稿件資訊 </a> </li>
			<li> <a href="#tab_author" data-toggle="tab"> 作者資訊 </a> </li>
			<li> <a href="#tab_file" data-toggle="tab"> 稿件檔案 </a> </li>
			<?php if( $paper->sub_status >= 3  || $paper->sub_status == 1){?><li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li><?php }?>
			<?php if( $paper->sub_status == -1){?><a href="<?php echo get_url("submit",$conf_id,"edit",$paper->sub_id)?>" class="ui teal button pull-right">編輯稿件</a><?php }?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_info">
				<h3>稿件資訊</h3>
				<table class="table table-bordered">
					<tr>
						<th style="width: 15%">題目</th>
						<td><?php echo $paper->sub_title?></td>
					</tr>
					<tr>
						<th>摘要</th>
						<td><?php echo $paper->sub_summary?></td>
					</tr>
					<tr>
						<th>主題</th>
						<td><span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span></td>
					</tr>
					<tr>
						<th>稿件狀態</th>
						<td><?php echo $this->submit->sub_status($paper->sub_status,true)?></td>
					</tr>
					<tr>
						<th>最後更新時間</th>
						<td><?php echo date("Y-m-d H:i:s",$paper->sub_lastupdate)?></td>
					</tr>
					<tr>
						<th>送審時間</th>
						<td><?php echo date("Y-m-d H:i:s",$paper->sub_review)?></td>
					</tr>
					<tr>
						<th>語言</th>
						<td><?php echo $paper->sub_lang?></td>
					</tr>
					<tr>
						<th>關鍵字</th>
						<td><?php echo $paper->sub_keyword?></td>
					</tr>
					<tr>
						<th>計畫編號</th>
						<td><?php echo $paper->sub_sponsor?></td>
					</tr>
				</table>
			</div>
			<div class="tab-pane container-fluid" id="tab_author">
				<h3>作者資訊</h3>
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
			<div class="tab-pane container-fluid" id="tab_file">
				<?php if( $paper->sub_status >= 4){?>
				<h3>完稿檔案</h3>
				<table class="table table-bordered" id="finish_file">
					<thead>
						<tr>
							<th class="text-center col-md-2">檔案類型</th>
							<th class="text-center col-md-6">檔案名稱</th>
							<th class="text-center col-md-2">上傳時間</th>
							<th class="text-center col-md-2">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($finishfile)){?>
						<tr>
							<td class="text-center"><span class="ui blue basic label">完稿投稿資料</span></td>
							<td><?php echo $finishfile->file_name?></td>
							<td><?php echo date("Y-m-d H:i:s",$finishfile->file_time)?></td>
							<td class="text-center">
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finishfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finishfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							</td>
						</tr>
						<?php }?>
						<?php foreach ($finishother as $key => $finish) {?>
						<tr>
							<td class="text-center"><span class="ui teal basic label">完稿補充資料</span></td>
							<td><?php echo $finish->file_name?></td>
							<td><?php echo date("Y-m-d H:i:s",$finish->file_time)?></td>
							<td class="text-center">
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$finish->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<?php }?>
				<?php if( $paper->sub_status <= 4){?>
				<h3>稿件檔案</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center col-md-2">檔案類型</th>
							<th class="text-center col-md-6">檔案名稱</th>
							<th class="text-center col-md-2">上傳時間</th>
							<th class="text-center col-md-2">操作</th>
						</tr>
					</thead>
					<tr>
						<td class="text-center"><span class="ui blue basic label">投稿資料</span></td>
						<td>
							<?php if(!empty($otherfile)){?>
							<?php echo $otherfile->file_name?>
							<?php }else{?>
							<span class="ui label red">尚未上傳</span>
							<?php }?>
						</td>
						<td>
							<?php if(!empty($otherfile)){?>
							<?php echo date("Y-m-d H:i:s",$otherfile->file_time)?>
							<?php }?>
						</td>
						<td class="text-center">
							<?php if(!empty($otherfile)){?>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							<?php }?>
						</td>
					</tr>
					<?php if(!empty($otherfiles)){?>
					<?php foreach ($otherfiles as $key => $otherfile) {?>
					<tr>
						<td class="text-center"><span class="ui teal basic label">補充資料</span></td>
						<td><?php echo $otherfile->file_name?></td>
						<td><?php echo date("Y-m-d H:i:s",$otherfile->file_time)?></td>
						<td class="text-center">
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
						</td>
					</tr>
					<?php }?>
					<?php }?>
				</table>
				<?php }?>
			</div>

			<?php if( $paper->sub_status >= 3 || $paper->sub_status == 1){?>
			<div class="tab-pane container-fluid" id="tab_review">
				<h3>審查資料</h3>
				<?php if( in_array($paper->sub_status,array(-2,4,0,5)) ){?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center" style="width:10%">審查人</th>
							<th class="text-center" style="width:10%">審查狀態</th>
							<th class="text-center" style="width:10%">審查時間</th>
							<th class="text-center" style="width:70%">審查建議</th>
						</tr>
					</thead>
					<?php $review_array = array();?>
					<?php foreach ($reviewers as $key => $reviewer) {?>
					<?php if( !in_array($reviewer->user_login,$review_array) ){array_push($review_array,$reviewer->user_login);}?>
					<tr>
						<td class="text-center">
							審查人 <?php echo array_search($reviewer->user_login, $review_array)+1?>
						</td>						
						<td class="text-center">
							<?php echo $this->submit->sub_status($reviewer->review_status,true);?>
						</td>
						<td class="text-center">
							<?php echo date('Y/m/d H:i', $reviewer->review_time);?>
						</td>
						<td>
							<?php echo $reviewer->review_comment;?>
						</td>
						
					</tr>
					<?php }?>
				</table>
				<?php }else{?>
					<div class="ui icon message">
						<i class="fa fa-spinner fa-pulse icon"></i>
						<div class="content">
							<div class="header">
						 		目前正在審查中
							</div>
						</div>
					</div>
				<?php }?>
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
<script>
$(function() { 
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('paper_<?php echo $paper->sub_id?>', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('paper_<?php echo $paper->sub_id?>');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	}
});
</script>