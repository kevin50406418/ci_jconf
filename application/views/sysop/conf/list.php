<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment blue">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>研討會</th>
				<th>操作</th>
			</tr>
		</thead>
		<?php if(is_array($confs)){?>
		<?php foreach ($confs as $key => $conf) {?>
		<tr>
			<td><?php echo $conf->conf_name?>(<?php echo $conf->conf_id?>)</td>
			<td>
				<a href="<?php echo base_url("sysop/conf/edit/".$conf->conf_id)?>" class="ui button blue"><i class="fa fa-pencil-square-o"></i> 編輯</a>
				<?php if( $conf->conf_staus == 0){?>
				<a href="#" class="ui button red"><i class="fa fa-eye-slash"></i> 隱藏</a>
				<?php }else{?>
				<a href="#" class="ui button green"><i class="fa fa-eye"></i> 顯示</a>
				<?php }?>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
</div>
</div>