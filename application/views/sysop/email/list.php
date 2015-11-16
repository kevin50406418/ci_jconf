<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment blue">
	
		
	<div role="tabpanel">
		<div class="ui inverted segment">
			<ul class="nav nav-pills pull-right" role="tablist">
				<li role="presentation" class="active"><a href="#zhtw" aria-controls="home" role="tab" data-toggle="tab">中文</a></li>
				<li role="presentation"><a href="#eng" aria-controls="profile" role="tab" data-toggle="tab">英文</a></li>
			</ul>
			<a class="ui inverted blue button" href="<?php echo base_url("sysop/email/add")?>">新增電子郵件樣版</a>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="zhtw">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="col-md-2">信件主旨</th>
							<th class="col-md-9">說明</th>
							<th class="col-md-1">操作</th>
						</tr>
					</thead>
					<?php foreach ($template_zhtw as $key => $zhtw) {?>
						<tr>
							<td><?php echo $zhtw->default_subject?></td>
							<td><?php echo $zhtw->email_desc?></td>
							<td>
								<a href="<?php echo base_url("sysop/email/edit")?>?id=<?php echo $zhtw->email_key?>">編輯</a>
							</td>
						</tr>
					<?php }?>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane" id="eng">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>信件主旨</th>
							<th>說明</th>
							<th>操作</th>
						</tr>
					</thead>
					<?php foreach ($template_eng as $key => $eng) {?>
						<tr>
							<td><?php echo $eng->default_subject?></td>
							<td><?php echo $eng->email_desc?></td>
							<td><?php echo $eng->email_key?></td>
						</tr>
					<?php }?>
				</table>
			</div>
		</div>
	</div>
	
</div>
</div>