<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_info" data-toggle="tab"> 稿件資訊 </a> </li>
			<li> <a href="#tab_author" data-toggle="tab"> 作者資訊 </a> </li>
			<li> <a href="#tab_file" data-toggle="tab"> 稿件檔案 </a> </li>
			<?php if( $paper->sub_status > 3){?><li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li><?php }?>
			<?php if( $paper->sub_status == -1){?><a href="<?php echo get_url("submit",$conf_id,"edit",$paper->sub_id)?>" class="ui teal button pull-right">編輯稿件</a><?php }?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_info">
				<h3>稿件資訊</h3>
				<table class="table table-bordered">
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
						<td><span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span></td>
					</tr>
					<tr>
						<th>稿件狀態</th>
						<td><?php echo $this->Submit->sub_status($paper->sub_status,true)?></td>
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
			<div class="tab-pane container-fluid" id="tab_file">
				<h3>稿件檔案</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="width:10%">#</th>
							<th style="width:10%">檔案類型</th>
							<th style="width:60%">檔案名稱</th>
							<th style="width:20%">操作</th>
						</tr>
					</thead>
					<tr>
						<td><?php if(!empty($otherfile)){echo $otherfile->fid;}?></td>
						<td>投稿資料</td>
						<td>
							<?php if(!empty($otherfile)){?>
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
							<?php }else{?>
							<span class="ui label red">尚未上傳</span>
							<?php }?>
						</td>
						<td>
							<?php if(!empty($otherfile)){?>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							<?php }?>
						</td>
					</tr>
					<?php if(!empty($otherfiles)){?>
					<?php foreach ($otherfiles as $key => $otherfile) {?>
					<tr>
						<td><?php echo $otherfile->fid;?></td>
						<td>補充資料</td>
						<td>
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
						</td>
						<td>
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
							<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
						</td>
					</tr>
					<?php }?>
					<?php }?>
				</table>
			</div>
			<!--{if $paper.sub_status >= 3}-->
			<div class="tab-pane container-fluid" id="tab_review">
				<h3>審查資料</h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width:10%">審查人</th>
							<th style="width:10%">審查狀態</th>
							<th style="width:10%">審查時間</th>
							<th style="width:70%">審查建議</th>
						</tr>
					</thead>
					<!--{foreach from=$paper_review key=i item=review}-->
					<tr>
						<td>審查人 <!--{$i+1}--></td>
						<td><!--{sub_status($review.review_status,true)}--></td>
						<td>
							
						</td>
						<td>
							
						</td>
					</tr>
					<!--{/foreach}-->
				</table>
			</div>
			<!--{/if}-->
		</div>
	</div>
</div>
</div>