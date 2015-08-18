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
		<?php if( is_array($lists) ) {?>
		<?php foreach ($lists as $i => $list) {?>
		<tr>
			<td class="text-center"><?php echo $list->sub_id?></td>
			<td><?php echo $list->sub_title?></td>
			<td><span title="<?php echo $list->info?>"><?php echo $list->name?></span></td>
			<td class="text-center" data-order="<?php echo $list->sub_status?>">
				<?php echo $this->Submit->sub_status($list->sub_status,true)?>
			</td>
			<td data-order="0">
				<div class="small icon ui buttons">
					<a href="<?php echo get_url("submit",$conf_id,"detail",$list->sub_id)?>" class="tiny ui blue button">查看</a>
					<a href="<?php echo get_url("submit",$conf_id,"remove",$list->sub_id)?>" class="tiny ui red button">撤稿</a>
					<?php if($list->sub_status==-1){?>
					<a href="<?php echo get_url("submit",$conf_id,"edit",$list->sub_id)?>" class="tiny ui teal button">編輯</a>
                    <?php }elseif($list->sub_status==5){?>
					<i class="fa fa-calendar"></i> <?php echo date('Y/m/d H:i', $list->sub_time)?> 完稿
					<?php }?>
				</div>
			</td>
		</tr>
		<?php }?>
	    <?php }?>
	</table>
</div>
