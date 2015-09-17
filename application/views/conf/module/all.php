<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment raised green">
	<p>
	<div class="btn-group">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			新增模組 <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="<?php echo get_url("dashboard",$conf_id,"modules","add")?>?module=text">文字模組</a></li>
			<li><a href="<?php echo get_url("dashboard",$conf_id,"modules","add")?>?module=news">公告模組</a></li>
		</ul>
	</div>
	</p>
	<div class="tabbable-panel">
		<div class="tabbable-line">
			<ul class="nav nav-tabs nav-tabs-center">
				<li class="active"> <a href="#tab_zhtw" data-toggle="tab"> 繁體中文 </a> </li>
				<li><a href="#tab_eng" data-toggle="tab"> 英文 </a> </li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active container-fluid" id="tab_zhtw">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>標題</th>
								<th>位置</th>
								<th>類型</th>
								<th>語言</th>
								<th>操作</th>
							</tr>
						</thead>
						<?php foreach ($module_zhtw as $key => $module) {?>
						<tr>
							<td><?php echo $module->module_title?></td>
							<td><?php echo $module->module_position?></td>
							<td><?php echo $module->module_type?></td>
							<td><?php echo $module->module_lang?></td>
							<td>操作</td>
						</tr>
						<?php }?>
					</table>
				</div>
				<div class="tab-pane container-fluid" id="tab_eng">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>標題</th>
								<th>位置</th>
								<th>類型</th>
								<th>語言</th>
								<th>操作</th>
							</tr>
						</thead>
						<?php foreach ($module_eng as $key => $module) {?>
						<tr>
							<td><?php echo $module->module_title?></td>
							<td><?php echo $module->module_position?></td>
							<td><?php echo $module->module_type?></td>
							<td><?php echo $module->module_lang?></td>
							<td>操作</td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>