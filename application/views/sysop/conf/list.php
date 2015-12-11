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
			<td>
				<?php if( in_array($conf->conf_id,$test_conf)){?>
				<span class="ui label gray">測試</span>
				<?php }?>

				<?php if( $conf->conf_staus == 1 ){?>
				<span class="ui basic label pink">隱藏</span>
				<?php }?>
				<?php echo $conf->conf_name?>(<?php echo $conf->conf_id?>)
			</td>
			<td>
				<a href="<?php echo site_url("sysop/conf/edit/".$conf->conf_id)?>" class="ui button blue"><i class="fa fa-pencil-square-o"></i> 編輯</a>
				<?php echo form_open(site_url("sysop/conf/status/".$conf->conf_id),array("class"=>"pull-left"))?>
				<?php if( $conf->conf_staus == 0){?>
				<button type="submit" name="conf_staus" value="1" class="ui button red"><i class="fa fa-eye-slash"></i> 隱藏</button>
				<?php }else{?>
				<button type="submit" name="conf_staus" value="0" class="ui button green"><i class="fa fa-eye"></i> 顯示</button>
				<?php }?>
				<?php echo form_close()?>
				<a href="<?php echo site_url("sysop/conf/admin/".$conf->conf_id)?>" class="ui button teal">研討會管理員</a>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
</div>
</div>