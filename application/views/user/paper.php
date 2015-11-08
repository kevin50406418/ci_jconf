<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>研討會</th>
				<th>[主題]題目</th>
				<th>稿件狀態</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($papers as $key => $paper) {?>
			<tr>
				<td><?php echo $paper->sub_id?></td>
				<td><?php echo $paper->conf_name?></td>
				<td>
					<span class="ui blue basic label" title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span>
					<?php echo $paper->sub_title?>
				</td>
				<td>
					<?php echo $this->Submit->sub_status($paper->sub_status,true)?>
				</td>
			</tr>
		<?php }?>
		</tbody>
	</table>
</div>