<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<table  class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>編號</th>
			<th>題目</th>
			<th>主題</th>
			<th>投稿狀態</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<a data-toggle="collapse" href="#collapse<?php echo $paper->sub_id?>"><?php echo $paper->sub_title?></a>
				<div class="collapse" id="collapse<?php echo $paper->sub_id?>">
					<table class="table table-bordered">
						<?php foreach($files[$paper->sub_id] as $key => $file){?>
						<tr>
							<td><?php echo $file->file_name?></td>
							<td>
								<?php if( $file->file_type == "FF" ){?>
								完稿投稿資料
								<?php }else{?>
								完稿補充資料
								<?php }?>
							</td>
						</tr>
						<?php }?>
					</table>
				</div>
			</td>
			<td><?php echo $paper->topic_name?></td>
			<td><?php echo $this->submit->sub_status($paper->sub_status,false,true)?></td>
		</tr>
		<?php }?>
	</tbody>
</table>