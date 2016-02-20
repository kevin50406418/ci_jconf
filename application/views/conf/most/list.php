<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<h3 class="modal-title">科技部成果發表</h3>
	</div>
	<div class="modal-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center" style="width: 10%">#</th>
					<th class="text-center" style="width: 50%">計畫名稱</th>
					<th class="text-center" style="width: 10%">發表方式</th>
					<th class="text-center" style="width: 10%">審核狀態</th>
					<th class="text-center" style="width: 20%">操作</th>
				</tr>
			</thead>
			<?php foreach ($mosts as $key => $most) {?>
			<tr>
				<td class="text-center"><?php echo $most->most_id?></td>
				<td>
					<div><?php echo $most->most_name?>(<?php echo $most->most_number?>)</div>
					<div><?php echo $most->most_name_eng?></div>
				</td>
				<td class="text-center"><?php echo $this->submit->most_method($most->most_method)?></td>
				<td class="text-center"><?php echo $this->submit->most_status($most->most_status,true)?></td>
				<td>
					<a href="<?php echo get_url("dashboard",$conf_id,"most","detail")?>?id=<?php echo $most->most_id?>" class="ui button teal">查看</a>
					<?php if( $most->most_status == 0 || $most->most_status == 1 ){?><a href="<?php echo get_url("dashboard",$conf_id,"most","edit")?>?id=<?php echo $most->most_id?>" class="ui button blue">編輯</a><?php }?>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>