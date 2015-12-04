<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="alert"></div>
<?php //sp($this->input->post("topic_id"))?>
<div class="ui teal segment">
	<?php echo form_open(get_url("dashboard",$conf_id,"topic"));?>
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"topic","add")?>" role="button" class="ui purple button"><?php echo lang('topic_add')?></a>
		<button type="submit" class="ui blue button"><?php echo lang('topic_order')?></button>
	</p>
	<div class="table-responsive repeat">
	<table class="table table-striped table-bordered table-hover datatable_conftopic" id="topic_list">
		<thead>
			<tr>
				<th style="width:50%" class="text-center"><?php echo lang('topic_name')?></th>
				<th style="width:10%" class="text-center" class="text-center"><?php echo lang('editor_number')?></th>
				<th style="width:10%" class="text-center"><?php echo lang('topic_abbr')?></th>
				<th style="width:30%" class="text-center"><?php echo lang('topic_act')?></th>
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
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","assign")?>?id=<?php echo $topic->topic_id?>" class="ui blue button"><?php echo lang('topic_assign_editor')?></a>
				<!--<a href="<?php echo get_url("dashboard",$conf_id,"topic","level")?>?id=<?php echo $topic->topic_id?>" class="ui green button">席次分派</a>-->
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","edit")?>?id=<?php echo $topic->topic_id?>" class="ui teal button"><?php echo lang('topic_act_edit')?></a>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","remove")?>?id=<?php echo $topic->topic_id?>" class="ui red button" onClick="return confirm('<?php echo sprintf(lang('topic_del_confirm'),$topic->topic_name,$topic->topic_name_eng)?>');"><?php echo lang('topic_del')?></a>
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
