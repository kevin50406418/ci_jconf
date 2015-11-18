<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="row">
		<?php echo form_open(get_url("dashboard",$conf_id,"submit"),array("method"=>"get","id"=>"act"))?>
		<div class="col-md-3 col-md-offset-4">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon1">稿件狀態</span>
				<select class="form-control" id="status" name="status">
					<option value=""<?php if( is_null($status) ){?> selected<?php }?>><?php echo lang('status_all')?></option>
					<option value="-3"<?php if( $status == -3 ){?> selected<?php }?>><?php echo lang('status_delete')?></option>
					<option value="-2"<?php if( $status == -2 ){?> selected<?php }?>><?php echo lang('status_reject')?></option>
					<option value="-1"<?php if( $status == -1 ){?> selected<?php }?>><?php echo lang('status_editing')?></option>
					<option value="1"<?php if( $status == 1 ){?> selected<?php }?>><?php echo lang('status_submitcomplete')?></option>
					<option value="2"<?php if( $status == 2 ){?> selected<?php }?>><?php echo lang('status_pending')?></option>
					<option value="3"<?php if( $status == 3 ){?> selected<?php }?>><?php echo lang('status_review')?></option>
					<option value="4"<?php if( $status == 4 ){?> selected<?php }?>><?php echo lang('status_accepte')?></option>
					<option value="5"<?php if( $status == 5 ){?> selected<?php }?>><?php echo lang('status_complete')?></option>
				</select>
			</div>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon2">主題</span>
				<?php if(is_array($topics)){?>
				<select class="form-control" id="topic_id" name="topic_id">
					<option value=""<?php if( is_null($topic_id) ){?> selected<?php }?>>全部</option>
					<?php foreach ($topics as $key => $topic) {?>
					<option value="<?php echo $topic->topic_id?>"<?php if( $topic_id == $topic->topic_id ){?> selected<?php }?>><?php echo $topic->topic_name?> (<?php echo $topic->topic_name_eng?>)</option>
					<?php }?>
				</select>
				<?php }else{?>
					<div class="form-control alert-danger">尚未授權主題主編，請洽研討會會議管理員。</div>
				<?php }?>
			</div>
		</div>
		<?php echo form_close()?>
	</div>
	<br>
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th style="width:7%" class="text-center">#</th>
				<th style="width:50%" class="text-center">題目</th>
				<th style="width:13%" class="text-center">主題</th>
				<th style="width:10%" class="text-center">稿件狀態</th>
				<th style="width:20%" class="text-center disabled">操作</th>
			</tr>
		</thead>
		<?php if( is_array($papers) ) {?>
		<?php foreach ($papers as $i => $list) {?>
		<tr>
			<td class="text-center"><?php echo $list->sub_id?></td>
			<td><?php echo $list->sub_title?></td>
			<td><span title="<?php echo $list->topic_info?>"><?php echo $list->topic_name?></span></td>
			<td class="text-center" data-order="<?php echo $list->sub_status?>">
				<?php echo $this->Submit->sub_status($list->sub_status,true,true)?>
			</td>
			<td data-order="0">
				<div class="small icon ui buttons">
					<a href="<?php echo get_url("dashboard",$conf_id,"submit","detail",$list->sub_id)?>" class="tiny ui blue button basic">查看</a>
					<a href="<?php echo get_url("dashboard",$conf_id,"submit","edit",$list->sub_id)?>" class="tiny ui teal button basic">編輯</a>
				</div>
			</td>
		</tr>
		<?php }?>
	    <?php }?>
	</table>
</div>

<script>
$(function() {
	$("#topic_id").change(function() {$("form#act").submit();});
	$("#status").change(function() {$("form#act").submit();});
});
</script>