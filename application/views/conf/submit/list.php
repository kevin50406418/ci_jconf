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
		<?php if( is_array($papers) ) {?>
		<?php foreach ($papers as $i => $list) {?>
		<tr>
			<td class="text-center"><?php echo $list->sub_id?></td>
			<td><?php echo $list->sub_title?></td>
			<td><span title="<?php echo $list->topic_info?>"><?php echo $list->topic_name?></span></td>
			<td class="text-center" data-order="<?php echo $list->sub_status?>">
				<?php echo $this->Submit->sub_status($list->sub_status,true)?>
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
