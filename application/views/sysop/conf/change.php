<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li> <a href="<?php echo site_url("sysop/conf/edit/".$conf_id)?>"> 研討會資訊 </a> </li>
			<li> <a href="<?php echo site_url("sysop/conf/admin/".$conf_id)?>"> 研討管理員 </a> </li>
			<li class="active"> <a href="<?php echo site_url("sysop/conf/change/".$conf_id)?>"> 研討會ID更換 </a> </li>
			<!--<li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li>-->
		</ul>
		<?php echo form_open(site_url("sysop/conf/change/".$conf_id),array("class"=>"tab-content"))?>
		<div class="ui icon message negative">
			<i class="inbox icon"></i>
			<div class="content">
				<div class="header">
					研討會ID更換注意事項
				</div>
				<ul class="list">
					<li>一經更換後，研討會相關資料也一併更換到新的ID</li>
					<li>ID 請設置英數字</li>
				</ul>
			</div>
		</div>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th class="text-right col-md-2">舊研討會ID</th>
					<td><?php echo $conf_id?></td>
				</tr>
				<tr>
					<th class="text-right">新研討會ID</th>
					<td>
						<input type="text" name="new_id" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<div class="text-center">
			<button type="submit" class="ui button blue">更改研討會ID</button>
		</div>
		<?php echo form_close()?>
	</div>
	</div>
</div>
</div>