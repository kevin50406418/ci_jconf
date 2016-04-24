<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<div class="row">
		<?php echo form_open(get_url("topic",$conf_id,"index"),array("method"=>"get","id"=>"act"))?>
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
	<div class="table-responsive">
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th class="col-md-1 text-center">#</th>
				<th class="col-md-5 text-center">題目</th>
				<th class="col-md-2 text-center">主題</th>
				<th class="col-md-1 text-center">稿件狀態</th>
				<th class="col-md-1 text-center">審查狀態</th>
				<th class="col-md-2 text-center">操作</th>
			</tr>
		</thead>
		<?php if(is_array($papers)){?>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<?php if(!in_array($paper->sub_id,$paper_author)){?>
				<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" title="<?php echo $paper->sub_summary?>"><?php echo $paper->sub_title?></a>
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
				<?php echo $this->submit->sub_status($paper->sub_status,true,true)?>
			</td>
			<td class="text-center">
			<?php if(in_array($paper->sub_id,$paper_author)){?>
				-
			<?php }else{?>
				<?php
					$had_count[$paper->sub_id] = isset($had_count[$paper->sub_id])?$had_count[$paper->sub_id]:0;
					$assign_count[$paper->sub_id] = isset($assign_count[$paper->sub_id])?$assign_count[$paper->sub_id]:0;
					if( $had_count[$paper->sub_id] == $assign_count[$paper->sub_id] && $assign_count[$paper->sub_id] != 0){
				?>
					<?php if($paper->sub_status == 3){?>
					<span class="ui green label basic"><i class="fa fa-check-circle-o"></i> 完成審查</span>
					<?php }else{?>
						<?php echo $had_count[$paper->sub_id]?>
						/
						<?php echo $assign_count[$paper->sub_id]?>
					<?php }?>
				<?php }else{?>
					<?php echo $had_count[$paper->sub_id]?>
					/
					<?php echo $assign_count[$paper->sub_id]?>
				<?php }?>
			<?php }?>
			</td>
			<td>
				<?php if(!in_array($paper->sub_id,$paper_author)){?>
					<?php if($had_count[$paper->sub_id] == $assign_count[$paper->sub_id] && $assign_count[$paper->sub_id] != 0){?>
						<?php if($paper->sub_status == 3 ){?>
							<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-info btn-sm">主編審查</a>
						<?php }elseif($paper->sub_status == 1){?>
							<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-danger btn-sm">分派審查</a>
						<?php }else{?>
							<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-deault btn-sm">查看稿件</a>
						<?php }?>
						<!-- 1 -->
					<?php }else{?>
						<?php if($paper->sub_status == 1 ){?>
						<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-danger btn-sm">分派審查</a>
						<?php }elseif($paper->sub_status == -3 ){?>
						<?php }else{?>
						<a href="<?php echo get_url("topic",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-primary btn-sm">查看稿件</a>
						<?php }?>
					<?php }?>
				<?php }else{?>
					<a href="<?php echo get_url("submit",$conf_id,"detail",$paper->sub_id)?>" class="btn btn-info btn-sm">查看稿件</a>
				<?php }?>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						操作 <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php if( $conf_config['topic_edit'] && !in_array($paper->sub_status,array(-3)) ){?>
						<li><a href="<?php echo get_url("topic",$conf_id,"edit",$paper->sub_id)?>"><i class="fa fa-pencil-square-o"></i> 編輯稿件</a></li>
						<?php }?>
						<li><a href="<?php echo get_url("topic",$conf_id,"email",$paper->sub_id)?>"><i class="fa fa-envelope-o"></i> 連絡作者</a></li>
					</ul>
				</div>
			</td>
		</tr>
		<?php }?>
	<?php }?>
	</table>
	</div>
</div>

<script>
$(function() {
	$("#topic_id").change(function() {$("form#act").submit();});
	$("#status").change(function() {$("form#act").submit();});
	$('.datatable').dataTable( {
		"order": [[ 0, "desc" ]],
		columnDefs: [
			{ orderable: false, "targets": -1 },
		],
		dom: 'Bfrtip',
		buttons: [
			{
                extend: 'excelHtml5',
                text: '匯出 excel 檔',
                className: 'ui button green'
            },
            {
                extend: 'csvHtml5',
                text: '匯出 csv 檔',
                className: 'ui button teal'
            }
        ],
		stateSave: true,
        "language": {
            "lengthMenu": "每頁顯示 _MENU_ 筆資料",
            "zeroRecords": "找不到論文",
            "info": "第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "目前尚無任何論文",
            "infoFiltered": "(filtered from _MAX_ total records)",
			"loadingRecords": "載入中...",
			"processing":     "處理中...",
			"search":         "論文資料搜尋：",
			"paginate": {
				"first":      "首頁",
				"last":       "最後一頁",
				"next":       "下一頁",
				"previous":   "上一頁"
			},
        }
    } );
});
</script>