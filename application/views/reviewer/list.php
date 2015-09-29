<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
<div class="table-responsive">
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th style="width:5%" class="text-center">#</th>
				<th style="width:50%" class="text-center">題目</th>
				<th style="width:15%" class="text-center">主題</th>
				<th style="width:10%" class="text-center">審查狀態</th>
				<th style="width:10%" class="text-center">完成時間</th>
				<th style="width:10%" class="text-center">操作</th>
			</tr>
		</thead>
		<?php if(is_array($papers)){?>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<?php if(!in_array($paper->sub_id,$paper_author)){?>
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
				<?php echo $this->Submit->sub_status($paper->review_status,true)?>
			</td>
			<td class="text-center">
				<?php if($paper->review_status != 3){?>
					<?php echo date("Y-m-d",$paper->review_time);?>
				<?php }else{?>
					-
				<?php }?>
			</td>
			<td class="text-center">
				<a href="<?php echo get_url("reviewer",$conf_id,"detail",$paper->sub_id)?>" class="ui blue button basic">進行審查</a>
			</td>
		</tr>
		<?php }?>
	<?php }?>
	</table>
</div>
</div>