<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
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
		<?php if( is_array($lists) ) {?>
		<?php foreach ($lists as $i => $list) {?>
		<tr>
			<td class="text-center"><?php echo $list->sub_id?></td>
			<td><?php echo $list->sub_title?></td>
			<td><span title="<?php echo $list->topic_info?>"><?php echo $list->topic_name?></span></td>
			<td class="text-center" data-order="<?php echo $list->sub_status?>">
				<?php echo $this->submit->sub_status($list->sub_status,true)?>
			</td>
			<td data-order="0">
				<a href="<?php echo get_url("submit",$conf_id,"detail",$list->sub_id)?>" class="ui blue button">查看</a>
				<?php if( $list->sub_status==-1 || $list->sub_status== 0){?>
				<a href="<?php echo get_url("submit",$conf_id,"edit",$list->sub_id)?>?step=2" class="ui teal button">編輯</a>
                <?php }elseif($list->sub_status==4){?>
				<a href="<?php echo get_url("submit",$conf_id,"finish",$list->sub_id)?>" class="ui green compact labeled icon button"><i class="fa fa-upload icon"></i> 完稿上傳</a>
                <?php }elseif($list->sub_status==5){?>
				<span class="ui olive compact labeled icon button"><i class="fa fa-calendar icon"></i> <?php echo date('Y/m/d H:i', $list->sub_time)?> 完稿</span>
				<?php }?>
			</td>
		</tr>
		<?php }?>
	    <?php }?>
	</table>
</div>
<script>
$(function() {
	$('.datatable').dataTable( {
		"order": [[ 0, "desc" ]],
		columnDefs: [
			
			{ orderable: false, "targets": -1 },
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