<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"website","add")?>" class="ui blue button">新增</a>
	</p>
	<?php echo form_open(get_url("dashboard",$conf_id,"website"));?>
	<div>
		<?php if(in_array("zhtw",$conf_lang)){?>
		<div class="table-responsive repeat">
			<table class="table table-bordered table-hover" id="page">
				<thead>
					<tr>
						<th class="text-center" style="width: 5%">移動(Move)</th>
						<th class="text-center" style="width: 10%">顯示(Show)</th>
						<th class="text-center" style="width: 35%">標題(Title)</th>
						<th class="text-center" style="width: 20%">頁面(Page ID)</th>
						<th class="text-center" style="width: 30%">操作(Operating)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($contents['zhtw'] as $key => $content) {?>
					<tr>
						<td class="text-center">
							<span class="move ui black button"><i class="fa fa-arrows-alt fa-lg"></i></span>
						</td>
						<td class="text-center">
							<?php if($content->page_hidden==0){?>
							<input type="hidden" name="zhtw[show][<?php echo $content->page_id?>]" value="1">
							<span class="ui label green">顯示</span>
							<?php }else{?>
							<input type="checkbox" name="zhtw[show][<?php echo $content->page_id?>]" value="1"<?php if($content->page_show==1){?> checked<?php }?>>
							<?php }?>
							<input type="hidden" name="zhtw[page_id][]" value="<?php echo $content->page_id?>">
						</td>
						<td>
							<?php echo $content->page_title?>
						</td>
						<td><?php echo $content->page_id?></td>
						<td class="text-center">
							<?php if($content->page_edit){?>
							<a href="<?php echo get_url("dashboard",$conf_id,"website","edit")?>?id=<?php echo $content->page_id?>&lang=<?php echo $content->page_lang?>" class="ui blue button"><i class="fa fa-pencil"></i> 編輯</a>
							<?php }?>
							<?php if($content->page_del){?>
							<a href="<?php echo get_url("dashboard",$conf_id,"website","del")?>?id=<?php echo $content->page_id?>" class="ui red button" onclick="return confirm('是否刪除?\n注意: 刪除會同時刪除不同語系之網頁')"><i class="fa fa-trash-o"></i> 刪除</a>
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<?php }?>
		<?php if(in_array("eng",$conf_lang)){?>
		<div class="table-responsive repeat">
			<table class="table table-bordered table-hover" id="page">
				<thead>
					<tr>
						<th class="text-center" style="width: 5%">移動(Move)</th>
						<th class="text-center" style="width: 10%">顯示(Show)</th>
						<th class="text-center" style="width: 35%">標題(Title)</th>
						<th class="text-center" style="width: 20%">頁面(Page ID)</th>
						<th class="text-center" style="width: 30%">操作(Operating)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($contents['eng'] as $key => $content) {?>
					<tr>
						<td class="text-center">
							<span class="move ui black button"><i class="fa fa-arrows-alt fa-lg"></i></span>
						</td>
						<td class="text-center">
							<?php if($content->page_hidden==0){?>
							<input type="hidden" name="eng[show][<?php echo $content->page_id?>]" value="1">
							<span class="ui label green">顯示</span>
							<?php }else{?>
							<input type="checkbox" name="eng[show][<?php echo $content->page_id?>]" value="1" <?php if($content->page_show==1){?> checked<?php }?>>
							<?php }?>
							<input type="hidden" name="eng[page_id][]" value="<?php echo $content->page_id?>">
						</td>
						<td>
							<?php echo $content->page_title?>
						</td>
						<td><?php echo $content->page_id?></td>
						<td class="text-center">
							<?php if($content->page_edit){?>
							<a href="<?php echo get_url("dashboard",$conf_id,"website","edit")?>?id=<?php echo $content->page_id?>&lang=<?php echo $content->page_lang?>" class="ui blue button"><i class="fa fa-pencil"></i> 編輯</a>
							<?php }?>
							<?php if($content->page_del){?>
							<a href="<?php echo get_url("dashboard",$conf_id,"website","del")?>?id=<?php echo $content->page_id?>" class="ui red button" onclick="return confirm('是否刪除?\n注意: 刪除會同時刪除不同語系之網頁')"><i class="fa fa-trash-o"></i> 刪除</a>
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<?php }?>
	</div>

	<p>
		<button class="ui pink button" type="submit" name="show_btn">更改</button>
	</p>
	<?php echo form_close()?>
</div>


<script>
$(function() {
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#page',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>
