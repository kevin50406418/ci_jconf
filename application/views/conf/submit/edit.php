<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_info" data-toggle="tab"> 稿件資訊 </a> </li>
			<li> <a href="#tab_author" data-toggle="tab"> 作者資訊 </a> </li>
			<li> <a href="#tab_file" data-toggle="tab"> 稿件檔案 </a> </li>
			<?php if( in_array($paper->sub_status,array(-2,4,5)) ){?><li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li><?php }?>
			<a href="<?php echo get_url("dashboard",$conf_id,"submit")?>" class="ui button teal pull-right">稿件列表</a>
			<a href="<?php echo get_url("dashboard",$conf_id,"submit","detail",$paper->sub_id)?>" class="ui button blue pull-right">查看</a>
		</ul>
		<div class="tab-content">
			<?php echo validation_errors('<div class="ui message red">', '</div>');?>
			<div class="tab-pane active container-fluid" id="tab_info">
				<h3>稿件資訊</h3>
				<?php echo form_open(get_url("dashboard",$conf_id,"submit","edit",$paper->sub_id));?>
				<?php echo form_hidden('update', 'info');?>
				<table class="table table-bordered">
					<tr>
						<th>題目</th>
						<td>
							<input name="sub_title" type="text" required class="form-control" id="sub_title" value="<?php echo $paper->sub_title?>">
						</td>
					</tr>
					<tr>
						<th>摘要</th>
						<td>
							<textarea name="sub_summary" required id="sub_summary" class="form-control"><?php echo $paper->sub_summary?></textarea>
						</td>
					</tr>
					<tr>
						<th>主題</th>
						<td>
							<select name="sub_topic" id="sub_topic" class="form-control"<?php if( !in_array($paper->sub_status,array(-1,1)) ){?> disabled<?php }?>>
								<?php foreach ($topics as $key => $topic) {?>
								<option value="<?php echo $topic->topic_id?>"<?php if($paper->topic_id == $topic->topic_id){?> selected<?php }?>><?php echo $topic->topic_name?>(<?php echo $topic->topic_name_eng?>)</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>稿件狀態</th>
						<td><?php echo $this->Submit->sub_status($paper->sub_status,true)?></td>
					</tr>
					<tr>
						<th>語言</th>
						<td>
							<select name="sub_lang" id="sub_lang" class="form-control">
								<option value="zhtw"<?php if($paper->sub_lang=="zhtw"){?> selected="selected" class="bg-info"<?php }?>>繁體中文(Traditional Chinese)</option>
								<option value="eng"<?php if($paper->sub_lang=="eng"){?> selected="selected" class="bg-info"<?php }?>>英文(English)</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>關鍵字</th>
						<td>
							<input name="sub_keywords" type="text" required class="form-control" id="sub_keywords" value="<?php echo $paper->sub_keyword?>">
							<p class="help-block">提供一個或更多描述投稿內容的專有名詞。以半形逗號「,」來將這些專有名詞分開(專有名詞1,專有名詞2,專有名詞3)。例如：資訊安全</p>
						</td>
					</tr>
					<tr>
						<th>計畫編號</th>
						<td>
							<input name="sub_sponsor" type="text" class="form-control" id="sub_sponsor" value="<?php echo $paper->sub_sponsor?>">
							<p class="help-block">提供本發表論文研究經費補助或贊助的計畫編號，例如：國科會計畫編號NSC XX-0123-456-789或亞洲大學計畫編號1XX-asia-XX</p>
						</td>
					</tr>
				</table>
				<div class="text-center">
					<button type="submit" class="ui button orange">更新</button>
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_author">
				<h3>作者資訊</h3>
				<div class="table-responsive repeat">
				<?php echo form_open(get_url("dashboard",$conf_id,"submit","edit",$paper->sub_id))?>
				<?php echo form_hidden('update', 'author');?>
				<table class="table table-bordered author">
					<thead>
						<tr>
							<td colspan="6"><span class="add ui green button"><i class="fa fa-plus"></i></span></td>
						</tr>
						<tr>
							<th>主要</th>
							<th>姓名</th>
							<th>電子信箱</th>
							<th>所屬機構</th>
							<th>國別</th>
							<th>操作</th>
						</tr>
					</thead>

					<tbody>
						<tr class="template trow">
							<td class="text-center">
								<label>
								<input name="main_contact" type="radio" required id="main_contact" value="{{row-count-placeholder}}">
								</label>
							</td>
							<td>
								<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="">
								<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="">
							</td>
							<td>
								<input name="user_email[]" type="email" required class="form-control" id="user_email" value="">
							</td>
							<td>
								<textarea name="user_org[]" maxlength="40" required class="form-control" id="user_org"></textarea>
							</td>
							<td><?php echo form_dropdown('user_country[]', $country_list, "TW", 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?></td>
							<td class="text-center">
								<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
								<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
							</td>
						</tr>
						<?php if(!empty($authors)){?>
						<?php foreach ($authors as $key => $author) {?>
						<tr class="trow">
							<td class="text-center">
								<label>
								<input name="main_contact" type="radio" required id="main_contact" value="<?php echo $key?>"<?php if($author->main_contract == 1){?> checked<?php }?>>
								</label>
							</td>
							<td>
								<input name="user_fname[]" type="text" required class="form-control" id="user_fname" value="<?php echo $author->user_first_name?>">
								<input name="user_lname[]" type="text" required class="form-control" id="user_lname" value="<?php echo $author->user_last_name?>">
							</td>
							<td>
								<input name="user_email[]" type="email" required class="form-control" id="user_email" value="<?php echo $author->user_email?>">
							</td>
							<td>
								<textarea name="user_org[]" maxlength="40" required class="form-control" id="user_org"><?php echo $author->user_org?></textarea>
							</td>
							<td><?php echo form_dropdown('user_country[]', $country_list, $author->user_country, 'class="form-control chosen-select" data-placeholder="請選擇國家..."');?></td>
							<td class="text-center">
								<span class="move ui teal button"><i class="fa fa-arrows"></i></span>
								<span class="remove ui red button"><i class="fa fa-trash-o"></i></span>
							</td>
						</tr>
						<?php }?>
						<?php }?>
					</tbody>
				</table>
				</div>
				<div class="text-center">
					<button type="submit" class="ui button orange">更新</button>
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_file">
				<div class="ui raised segment">
					<h3>稿件檔案</h3>
					<?php echo form_open(get_url("dashboard",$conf_id,"submit","edit",$paper->sub_id))?>
					<?php echo form_hidden('update', 'delfile');?>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">刪除</th>
								<th class="col-sm-1">#</th>
								<th class="col-sm-1">檔案類型</th>
								<th class="col-sm-5">檔案名稱</th>
								<th class="col-sm-4">操作</th>
							</tr>
						</thead>
						<tr>
							<td class="text-center">
								<?php if(!empty($otherfile)){?><input type="checkbox" name="del_file[]" value="<?php echo $otherfile->fid?>"><?php }?>
							</td>
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
						<?php foreach ($otherfiles as $key => $otfile) {?>
						<tr>
							<td class="text-center">
								<input type="checkbox" name="del_file[]" value="<?php echo $otfile->fid?>">
							</td>
							<td><?php echo $otfile->fid;?></td>
							<td>補充資料</td>
							<td>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otfile->fid;?>" target="_blank"><?php echo $otfile->file_name?></a>
							</td>
							<td>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otfile->fid;?>" class="btn btn-xs btn-primary" target="_blank">查看</a>
								<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otfile->fid."&do=download";?>" class="btn btn-xs btn-warning" target="_blank">下載</a>
							</td>
						</tr>
						<?php }?>
						<?php }?>
					</table>
					<div>
						<input type="submit" value="刪除所選檔案" onClick="return confirm('確定是否刪除?\n注意：刪除後檔案將無法復原');" name="del" class="ui orange button">
					</div>
					<?php echo form_close()?>
				</div>
				<div class="ui raised segment black">
					<h2>上傳投稿文件</h2>
					<table class="table table-bordered form-horizontal">
						<tr>
							<th class="col-sm-2 control-label">投稿文件</th>
							<td class="col-sm-10">
								<?php echo form_open_multipart(get_url("dashboard",$conf_id,"submit","edit",$paper->sub_id),array("class"=>"form-horizontal"));?>
									<?php echo form_hidden('update', 'file');?>
									<div class="col-sm-8">
										<p>
											<?php if(!empty($otherfile)){?>
											<a href="<?php echo get_url("submit",$conf_id,"files")."/".$paper_id."?fid=".$otherfile->fid;?>" target="_blank"><?php echo $otherfile->file_name?></a>
											<?php }else{?>
											<span class="ui label red">尚未上傳</span>
											<?php }?>
										</p>
										<input name="paper_file" type="file" required="required" id="paper_file" accept=".pdf">
										<p class="help-block">只限PDF上傳投稿資料</p>
									</div>
									<div class="col-sm-2">
										<input name="check2" type="submit" class="ui teal button" id="check2" value="上傳" >
									</div>
								<?php echo form_close()?>
							</td>
						</tr>
					</table>
					<hr>
					<h2>上傳其他投稿文件</h2>
					<?php echo form_open_multipart(get_url("dashboard",$conf_id,"submit","edit",$paper->sub_id),array("class"=>"form-horizontal"))?>
					<?php echo form_hidden('update', 'otherfile');?>
						<table class="table table-bordered">
							<tr>
								<th class="col-sm-2 control-label">投稿資料</th>
								<td class="col-sm-10">
									<div class="col-sm-8">
										<input name="paper_file[]" type="file" multiple id="paper_file" accept=".pdf">
										<p class="help-block">只限PDF上傳投稿資料(一次可多個上傳檔案)</p>
									</div>
									<div class="col-sm-2">
										<input name="check2" type="submit" class="ui teal button" id="check2" value="上傳" >
									</div>
								</td>
							</tr>
						</table>
					<?php echo form_close()?>
			</div>
			</div>
			<?php if( $paper->sub_status >= 3 || $paper->sub_status == -2){?>
			<div class="tab-pane container-fluid" id="tab_review">
				<h3>審查資料</h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width:10%">審查人</th>
							<th style="width:10%">審查狀態</th>
							<th style="width:15%">審查時間</th>
							<th style="width:65%">審查建議</th>
						</tr>
					</thead>
					<?php foreach ($reviewers as $key => $reviewer) {?>
					<tr>
						
						<td><?php echo $reviewer->user_login?></td>
						<td>
							<?php echo $this->Submit->sub_status($reviewer->review_status,true)?>
						</td>
						<td>
							<?php
								if( in_array($reviewer->review_status, array(-2,2,4)) ){
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
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
<script>
$(function() { 
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('dashboard_<?php echo $paper->sub_id?>', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('dashboard_<?php echo $paper->sub_id?>');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	}
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: ".author",
			container: "tbody",
			row: ".trow",
			cell: "td",
			row_count_placeholder: "{{row-count-placeholder}}",
		});
	});
});
</script>

