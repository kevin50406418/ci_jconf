<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="alert"></div>
<div class="ui teal segment">
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"topic","add")?>" role="button" class="ui purple button">建立研討會主題</a>
	</p>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover datatable_conftopic">
		<thead>
			<tr>
				<th style="width:50%" class="text-center">主題名稱</th>
				<th style="width:10%" class="text-center" class="text-center">主編數</th>
				<th style="width:10%" class="text-center">主題簡稱</th>
				<th style="width:30%" class="text-center">功能</th>
			</tr>
		</thead>
		<?php if(!empty($topics)){?>
		<?php foreach ($topics as $key => $topic) {?>
		<tr>
			<td>
				<span title="<?php echo $topic->topic_info?>"><?php echo $topic->topic_name?> (<?php echo $topic->topic_name_eng?>)</span>
			</td>
			<td class="text-center">
				
			</td>
			<td>
				<?php echo $topic->topic_abbr?>
			</td>
			<td>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","add")?>?id=<?php echo $topic->topic_id?>" class="ui blue button">指派主編</a>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","level")?>?id=<?php echo $topic->topic_id?>" class="ui green button">席次分派</a>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","edit")?>?id=<?php echo $topic->topic_id?>" class="ui teal button">編輯</a>
				<a href="<?php echo get_url("dashboard",$conf_id,"topic","remove")?>?id=<?php echo $topic->topic_id?>" class="ui red button" onClick="return confirm('確定是否刪除主題「<!--{$topic['name']}-->(<!--{$topic['name_eng']}-->)」\n注意：刪除後將無法恢復');">刪除</a>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
	</div>
</div>
