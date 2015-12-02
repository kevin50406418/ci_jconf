<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_info" data-toggle="tab"> 稿件資訊 </a> </li>
			<li> <a href="#tab_author" data-toggle="tab"> 作者資訊 </a> </li>
			<li> <a href="#tab_file" data-toggle="tab"> 稿件檔案 </a> </li>
			<?php if( $paper->sub_status >= 3 || $paper->sub_status == -2 || $paper->sub_status == 0){?><li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li><?php }?>
			<?php if( $paper->sub_status < 3 && $paper->sub_status >= -1){?>
			<?php echo form_open(get_url("topic",$conf_id,"operating",$paper->sub_id),array("class"=>"pull-right","id"=>"paper_act"))?>
				操作：
				<div class="btn-group" role="group">
					<button id="remove" type="submit" name="do" value="remove" class="btn btn-default">接受撤搞</button>
					<button id="reject" type="submit" name="do" value="reject" class="btn btn-danger">直接拒絕</button>
				</div>
			<?php echo form_close()?>
			<script>
				$(function() { 
					$("#remove").click(function(){
						return confirm("確定是否接受徹搞\n注意：操作後無法恢復");
					});
					$("#reject").click(function(){
						return confirm("確定是否直接拒絕\n注意：操作後無法恢復");
					});
				});
			</script>
			<?php }?>
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
						<td>
							<span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span>
						</td>
					</tr>
					<tr>
						<th>稿件狀態</th>
						<td class="row">
							<?php echo $this->Submit->sub_status($paper->sub_status,true,true)?>
						</td>
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
							<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
							<?php }else{?>
							<span class="ui label red">尚未上傳</span>
							<?php }?>
						</td>
						<td>
							<?php if(!empty($otherfile)){?>
								<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							<?php }?>
						</td>
					</tr>
					<?php if(!empty($otherfiles)){?>
					<?php foreach ($otherfiles as $key => $otherfile) {?>
					<tr>
						<td><?php echo $otherfile->fid;?></td>
						<td>補充資料</td>
						<td>
							<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
						</td>
						<td>
							<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
							<a href="<?php echo get_url("topic",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
						</td>
					</tr>
					<?php }?>
					<?php }?>
				</table>
			</div>
			<?php if( $paper->sub_status >= 3 || $paper->sub_status == -2 || $paper->sub_status == 0){?>
			<div class="tab-pane container-fluid" id="tab_review">
				<h3>審查資料</h3>
				<?php $cnt = 0;?>
				<div class="table-responsive">
				<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id))?>
				<?php echo form_hidden('do', 'notice');?>
				<table class="table">
					<thead>
						<tr>
							<th style="width:5%"> </th>
							<th style="width:10%">審查人</th>
							<th style="width:10%">審查狀態</th>
							<th style="width:10%">審查期限</th>
							<th style="width:10%">審查時間</th>
							<th style="width:55%">審查建議</th>
						</tr>
					</thead>
					<?php foreach ($reviewers as $key => $reviewer) {?>
					<tr<?php if( $reviewer->topic_review == 1 ){?> class="active"<?php }?>>
						<td class="text-center">
							<input type="checkbox" value="<?php echo $reviewer->user_login?>" name="user_login[]"<?php if( in_array($reviewer->review_status, array(-2,2,0,4)) || $reviewer->review_confirm == -1 ){ $cnt++;?> disabled<?php }?>>
						</td>
						<td><?php echo $reviewer->user_login?></td>
						<td>
							<?php if( $reviewer->review_confirm == -1  ){?>
							<span class="ui grey label">確認中</span>
							<?php }else{?>
							<?php echo $this->Submit->sub_status($reviewer->review_status,true)?>
							<?php }?>
						</td>
						<td class="text-center">
							<?php echo date("Y-m-d H:i",$reviewer->review_timeout)?>
						</td>
						<td class="text-center">
							<?php
								if( in_array($reviewer->review_status, array(-2,2,0,4)) ){
									echo date('Y/m/d H:i', $reviewer->review_time);	
								}
							?>
						</td>
						<td>
							<?php echo $reviewer->review_comment?>
						</td>
					</tr>
					
					<?php }?>
				</table>
				<?php if($cnt != count($reviewers)){?>
				<button class="ui button orange" name="type" value="remind">提醒審查</button>
				<?php }?>
				<?php echo form_close()?>	
				</div>			
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
<script>
$(function() { 	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('topic_<?php echo $paper->sub_id?>', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('topic_<?php echo $paper->sub_id?>');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	}
});
</script>
<?php if( $paper->sub_status == 3 ){?>
<div class="ui segment raised">
	<div class="modal-header">
		<h3 class="modal-title">主編審查</h3>
	</div>
	<div class="modal-body">
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>
		<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id))?>
		<?php echo form_hidden('do', 'topic');?>
		<div class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">審查狀態 <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<select class="form-control" name="status">
						<option>請選擇</option>
						<option value="-2">拒絕</option>
						<option value="0">修改後審查</option>
						<option value="2">大會待決</option>
						<option value="4">接受</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="ui button blue">送出</button>
				</div>
			</div>
		</div>
		<?php echo form_close()?>
	</div>
</div>
<?php }?>