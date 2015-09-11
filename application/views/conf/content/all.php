<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
<?php echo form_open(get_url("dashboard",$conf_id,"website"),array("class"=>"form-horizontal"));?>
<p>
	<input type="submit" name="show_btn" value="更改" class="ui pink button">
	<a href="<?php echo get_url("dashboard",$conf_id,"website","add")?>" class="ui blue button">新增</a>
</p>
<div class="table-responsive repeat">
<table class="table table-bordered table-hover" id="page">
	<thead>
		<tr>
			<th class="text-center">顯示</th>
			<th class="text-center">標題(Title)</th>
			<th class="text-center">頁面(Page ID)</th>
			<th class="text-center">操作(Operating)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($contents['zhtw'] as $key => $content) {?>
		<tr>
			<td class="text-center">
				<input type="checkbox" name="show[<?php echo $content->page_id?>]" id="show[<?php echo $content->page_id?>]" value="1" <?php if($content->page_show==1){?> checked<?php }?>>
				<input type="hidden" name="page_id[]" value="<?php echo $content->page_id?>">
			</td>
			<td>
				<?php echo $content->page_title?>
				<?php if(!empty($contents['eng'][$content->page_id]->page_title)){?>
				(<?php echo $contents['eng'][$content->page_id]->page_title?>)
				<?php }?>
			</td>
			<td><?php echo $content->page_id?></td>
			<td class="text-center">
				<div class="ui buttons">
					<a href="<?php echo get_url("dashboard",$conf_id,"website","edit")?>?id=<?php echo $content->page_id?>" class="ui teal button">編輯</a>
					<a href="#" class="ui red button disabled">刪除</a>
					<span class="move ui orange button">移動</span>
				</div>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<p>
	<input type="submit" name="show_btn" value="更改" class="ui pink button">
	<a href="<?php echo get_url("dashboard",$conf_id,"website","add")?>" class="ui blue button">新增</a>
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
