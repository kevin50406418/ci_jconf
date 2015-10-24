<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="alert"></div>
<?php //sp($this->input->post("topic_id"))?>
<div class="ui teal segment">
	<?php echo form_open(get_url("dashboard",$conf_id,"topic"));?>
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"topic","add")?>" role="button" class="ui purple button">建立研討會主題</a>
		<button type="submit" class="ui blue button">更改順序</button>
	</p>
	<div class="table-responsive repeat">
	<table class="table table-striped table-bordered table-hover datatable_conftopic" id="topic_list">
		<thead>
			<tr>
				<th style="width:50%" class="text-center">主題名稱</th>
				<th style="width:10%" class="text-center" class="text-center">主編數</th>
				<th style="width:10%" class="text-center">主題簡稱</th>
				<th style="width:30%" class="text-center">功能</th>
			</tr>
		</thead>
		<?php if(!empty($topics)){?>
		<tbody>
		<?php foreach ($topics as $key => $topic) {?>
		<tr>
			<td>
				<input type="hidden" name="topic_id[]" value="<?php echo $topic->topic_id?>">
				<span title="<?php echo $topic->topic_info?>"><?php echo $topic->topic_name?> (<?php echo $topic->topic_name_eng?>)</span>
			</td>
			<td class="text-center">
				<?php if( array_key_exists($topic->topic_id, $count_editor) ){
					echo $count_editor[$topic->topic_id];
				}else{
					echo 0;
				}?>
			</td>
			<td>
				<?php echo $topic->topic_abbr?>
			</td>
			<td>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","assign")?>?id=<?php echo $topic->topic_id?>" class="ui blue button">指派主編</a>
				<!--<a href="<?php echo get_url("dashboard",$conf_id,"topic","level")?>?id=<?php echo $topic->topic_id?>" class="ui green button">席次分派</a>-->
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","edit")?>?id=<?php echo $topic->topic_id?>" class="ui teal button">編輯</a>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","remove")?>?id=<?php echo $topic->topic_id?>" class="ui red button" onClick="return confirm('確定是否刪除主題「<?php echo $topic->topic_name?>(<?php echo $topic->topic_name_eng?>)」\n注意：刪除後將無法恢復');">刪除</a>
				<span class="move ui black button"><i class="fa fa-arrows-alt fa-lg"></i></span>
			</td>
		</tr>
		<?php }?>
		</tbody>
		<?php }?>
	</table>
	</div>
	<?php echo form_close()?>
</div>
<script>
$(function() {
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#topic_list',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>
