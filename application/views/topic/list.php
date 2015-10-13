<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<div class="row">
		<div class="col-md-3 col-md-offset-4">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon1">稿件狀態</span>
				<select class="form-control">
					<option value="-4">全部</option>
					<option value="-3">刪除</option>
					<option value="-2">拒絕</option>
					<option value="-1">編輯中</option>
					<option value="1" selected="selected">投稿完成</option>
					<option value="2">大會待決</option>
					<option value="3">審查中</option>
					<option value="4">接受</option>
					<option value="5">完稿</option>
				</select>
			</div>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon1">主題</span>
				<?php if(is_array($topics)){?>
				<select class="form-control">
					<option value="-4">全部</option>
					<?php foreach ($topics as $key => $topic) {?>
					<option value="<?php echo $topic->topic_id?>"><?php echo $topic->topic_name?> (<?php echo $topic->topic_name_eng?>)</option>
					<?php }?>
				</select>
				<?php }else{?>
					<div class="form-control alert-danger">尚未授權主題主編，請洽研討會會議管理員。</div>
				<?php }?>
			</div>
		</div>
	</div><br>
	<?php sp($papers)?>
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th style="width:7%" class="text-center">#</th>
				<th style="width:55%" class="text-center">題目</th>
				<th style="width:13%" class="text-center">主題</th>
				<th style="width:10%" class="text-center">稿件狀態</th>
				<th style="width:15%" class="text-center">操作</th>
			</tr>
		</thead>
		<?php if(is_array($papers)){?>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<!--{if !in_array($list['sub_id'], $paper_id)}-->
				<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->
				<a href="#" title="<?php echo $paper->sub_summary?>"><?php echo $paper->sub_title?></a>
				<!--{else}-->
				<!--{$list['sub_title']}-->
				<!--{/if}-->
			</td>
			<td><span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span></td>
			<td class="text-center">
				<?php echo $this->Submit->sub_status($paper->sub_status,true)?>
			</td>
			<td class="text-center">
				<div class="small icon ui buttons basic">
				<!--{if !in_array($list['sub_id'], $paper_id)}-->
					<a href="<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->" class="ui blue button basic">查看</a>
					<!--{if $list.sub_status == 1}-->
					<form method="post" action="<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->">
						<button onclick="return confirm('是否拒絕稿件[#<!--{$list['sub_id']}--> <!--{$list['sub_title']}-->]\n注意：拒絕稿件後，將無法撤回操作');" class="ui red button basic" name="reject">拒絕稿件</button>
					</form>
					<!--{/if}-->
				<!--{else}-->
					<a href="<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->" class="ui blue button basic disabled">查看</a>
					<button class="ui red button basic disabled">拒絕稿件</button>
				<!--{/if}-->
				</div>
				
			</td>
		</tr>
		<?php }?>
	<?php }?>
	</table>
</div>