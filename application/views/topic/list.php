<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<div class="row">
		<div class="col-md-3 col-md-offset-4">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon1">稿件狀態</span>
				<select class="form-control">
					<option value="-4"><?php echo lang('status_all')?></option>
					<option value="-3"><?php echo lang('status_delete')?></option>
					<option value="-2"><?php echo lang('status_reject')?></option>
					<option value="-1"><?php echo lang('status_editing')?></option>
					<option value="1" selected="selected"><?php echo lang('status_submitcomplete')?></option>
					<option value="2"><?php echo lang('status_pending')?></option>
					<option value="3"><?php echo lang('status_review')?></option>
					<option value="4"><?php echo lang('status_accepte')?></option>
					<option value="5"><?php echo lang('status_complete')?></option>
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
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th style="width:5%" class="text-center">#</th>
				<th style="width:55%" class="text-center">題目</th>
				<th style="width:15%" class="text-center">主題</th>
				<th style="width:10%" class="text-center">稿件狀態</th>
				<th style="width:15%" class="text-center">操作</th>
			</tr>
		</thead>
		<?php if(is_array($papers)){?>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<?php if(!in_array($paper->sub_id,$paper_author)){?>
				<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->
				<a href="#" title="<?php echo $paper->sub_summary?>"><?php echo $paper->sub_title?></a>
				<?php }else{?>
					<?php echo $paper->sub_title?>
				<?php }?>
			</td>
			<td>
				<?php if($_lang=="zhtw"){?>
				<span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span>
				<?php }elseif($_lang=="en"){?>
				<?php echo $paper->topic_name_eng?>
				<?php }?>
			</td>
			<td class="text-center">
				<?php echo $this->Submit->sub_status($paper->sub_status,true)?>
			</td>
			<td class="text-center">
				<div class="small icon ui buttons basic">
				<?php if(in_array($paper->sub_id,$paper_author)){?>
					<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->
					<a href="#" class="ui blue button basic">查看</a>
					<?php if($paper->sub_status == 1){?>
					<form method="post" action="<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->">
						<button onclick="return confirm('是否拒絕稿件[#<!--{$list['sub_id']}--> <!--{$list['sub_title']}-->]\n注意：拒絕稿件後，將無法撤回操作');" class="ui red button basic" name="reject">拒絕稿件</button>
					</form>
					<?php }?>
				<?php }else{?>
					<!--{get_url($conf_id,"topic","detail",$list['sub_id'])}-->
					<a href="<?php echo get_url("submit",$conf_id,"detail",$paper->sub_id)?>" class="ui blue button basic">查看</a>
					<button class="ui red button basic disabled">拒絕稿件</button>
				<?php }?>
				</div>
				
			</td>
		</tr>
		<?php }?>
	<?php }?>
	</table>
</div>