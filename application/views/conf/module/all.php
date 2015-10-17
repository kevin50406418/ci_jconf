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
				<div class="tab-pane active container-fluid repeat" id="tab_zhtw">
					<?php echo form_open(get_url("dashboard",$conf_id,"modules"));?>
					<?php echo form_hidden('module_lang', 'zhtw');?>
					<table class="table table-bordered table-hover" id="module">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%">移動</th>
								<th>標題</th>
								<th>位置</th>
								<th>類型</th>
								<th>語言</th>
								<th>操作</th>
							</tr>
						</thead>
						<?php foreach ($module_zhtw as $key => $module) {?>
						<tr>
							<td class="text-center">
								<span class="move ui black button"><i class="fa fa-arrows-alt fa-lg"></i></span>
							</td>
							<td><?php echo $module->module_title?></td>
							<td><?php echo $module->module_position?></td>
							<td><?php echo $module->module_type?></td>
							<td><?php echo $module->module_lang?></td>
							<td>
								<a href="<?php echo get_url("dashboard",$conf_id,"modules","edit",$module->module_id)?>" class="ui button blue basic">編輯</a>
								<a href="<?php echo get_url("dashboard",$conf_id,"modules","del",$module->module_id)?>" class="ui button red basic" onclick="return confirm('是否刪除模組?')">刪除</a>
							</td>
						</tr>
						<?php }?>
					</table>
					<button class="ui button teal" type="submit">更新</button>
					<?php echo form_close();?>
				</div>
				<div class="tab-pane container-fluid repeat" id="tab_eng">
					<?php echo form_open(get_url("dashboard",$conf_id,"modules"));?>
					<?php echo form_hidden('module_lang', 'eng');?>
					<table class="table table-bordered table-hover" id="module">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%">移動</th>
								<th>標題</th>
								<th>位置</th>
								<th>類型</th>
								<th>語言</th>
								<th>操作</th>
							</tr>
						</thead>
						<?php foreach ($module_eng as $key => $module) {?>
						<tr>
							<td class="text-center">
								<span class="move ui black button"><i class="fa fa-arrows-alt fa-lg"></i></span>
							</td>
							<td><?php echo $module->module_title?></td>
							<td><?php echo $module->module_position?></td>
							<td><?php echo $module->module_type?></td>
							<td><?php echo $module->module_lang?></td>
							<td>
								<a href="#" class="ui button blue basic">編輯</a>
								<a href="#" class="ui button red basic" onclick="return confirm('是否刪除模組?')">刪除</a>
							</td>
						</tr>
						<?php }?>
					</table>
					<button class="ui button orange" type="submit">更新</button>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#module',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>