<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment">
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"filter","add")?>" class="ui button blue">新增投稿檢核清單</a>
	</p>
	<div role="tabpanel">
		<ul class="nav nav-pills pull-right" role="tablist" style="margin-bottom:10px;">
			<li role="presentation" class="active"><a href="#zhtw" aria-controls="home" role="tab" data-toggle="tab">中文</a></li>
			<li role="presentation"><a href="#eng" aria-controls="profile" role="tab" data-toggle="tab">英文</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="zhtw">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:80%">投稿檢核</th>
							<th style="width:20%">操作</th>
						</tr>
					</thead>
					<tr>
						<td>
							<div class="ui red horizontal label">系統</div>
							本稿件從未出版過，同時也未曾在其他研討會中發表過 (或者提供相關的解釋與說明給主編)。
						</td>
						<td>
							<a href="#" class="ui button blue disabled">編輯</a>
							<a href="#" class="ui button red disabled">刪除</a>
						</td>
					</tr>
					<tr>
						<td>
							<div class="ui red horizontal label">系統</div>
							本投稿在未上傳投稿資料前，輸入的資料，將不列入本次研討會資料。
						</td>
						<td>
							<a href="#" class="ui button blue disabled">編輯</a>
							<a href="#" class="ui button red disabled">刪除</a>
						</td>
					</tr>
					<?php if(!empty($filters)){?>
					<?php foreach ($filters as $key => $filter) {?>
					<tr>
						<td>
							<?php echo $filter->filter_content?>
						</td>
						<td>
							<a href="<?php echo get_url("dashboard",$conf_id,"filter","edit")?>?id=<?php echo $filter->filter_id?>#content" class="ui button blue">編輯</a>
							<a href="#" class="ui button red">刪除</a>
						</td>
					</tr>
					<?php }?>
					<?php }?>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane" id="eng">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:80%">投稿檢核</th>
							<th style="width:20%">操作</th>
						</tr>
					</thead>
					<tr>
						<td>
							<div class="ui red horizontal label">系統</div>
							本稿件從未出版過，同時也未曾在其他研討會中發表過 (或者提供相關的解釋與說明給主編)。
						</td>
						<td>
							<a href="#" class="ui button blue disabled">編輯</a>
							<a href="#" class="ui button red disabled">刪除</a>
						</td>
					</tr>
					<tr>
						<td>
							<div class="ui red horizontal label">系統</div>
							本投稿在未上傳投稿資料前，輸入的資料，將不列入本次研討會資料。
						</td>
						<td>
							<a href="#" class="ui button blue disabled">編輯</a>
							<a href="#" class="ui button red disabled">刪除</a>
						</td>
					</tr>
					<?php if(!empty($filters)){?>
					<?php foreach ($filters as $key => $filter) {?>
					<tr>
						<td>
							<?php echo $filter->filter_content_eng?>
						</td>
						<td>
							<a href="<?php echo get_url("dashboard",$conf_id,"filter","edit")?>?id=<?php echo $filter->filter_id?>#econtent" class="ui button blue">編輯</a>
							<a href="#" class="ui button red">刪除</a>
						</td>
					</tr>
					<?php }?>
					<?php }?>
				</table>
			</div>
		</div>
	</div>
</div>