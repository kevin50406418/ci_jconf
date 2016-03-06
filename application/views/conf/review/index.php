<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_review" data-toggle="tab"> <i class="fa fa-commenting fa-lg"></i> 審查表單 </a> </li>
			<li> <a href="#tab_addreview" data-toggle="tab"> <i class="fa fa-commenting fa-lg"></i> 新增審查表單 </a> </li>
			<li> <a href="#tab_recommend" data-toggle="tab"> <i class="fa fa-star fa-lg"></i> 推薦表單 </a> </li>
			<li> <a href="#tab_addrecommend" data-toggle="tab"> <i class="fa fa-star fa-lg"></i> 新增推薦表單 </a> </li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_review">
				<h2><i class="fa fa-commenting fa-lg"></i> 審查表單</h2>
				<div class="repeat">
					<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
					<?php echo form_open(get_url("dashboard",$conf_id,"review"),array("class"=>"form-horizontal"))?>
					<?php echo form_hidden('do', 'sortform');?>
					<table class="table table-bordered" id="review_form">
						<thead>
							<tr>
								<th class="text-center col-sm-5">審查項目</th>
								<th class="text-center col-sm-4">評分項目</th>
								<th class="text-center col-sm-3">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($review_forms as $key => $form) {?>
							<tr>
								<td>
									<?php echo $form->review_form_title?>
									<input type="hidden" name="review_form_id[]" value="<?php echo $form->review_form_id?>">
								</td>
								<td>
									<ul class="list-inline">
									<?php foreach ($form_elements[$form->review_form_id] as $key2 => $element) {?>
										<li>
										<input disabled class="score" type="radio"> <?php echo $element["element_name"]?>(<?php echo $element["element_value"]?>)
										</li>
									<?php }?>
									</ul>
								</td>
								<td>
									<a href="<?php echo get_url("dashboard",$conf_id,"review","edit_form")?>?id=<?php echo $form->review_form_id?>" class="ui button blue mini">編輯</a>
									<a href="<?php echo get_url("dashboard",$conf_id,"review","del_form")?>?id=<?php echo $form->review_form_id?>" class="ui button red mini">刪除</a>
									<span class="move ui black button mini"><i class="fa fa-arrows-alt"></i></span>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<div class="text-center">
						<button class="ui button blue" type="submit">更新順序</button>
					</div>
					<?php echo form_close()?>
				</div><!-- .repeat -->
			</div><!-- #tab_review -->
			<div class="tab-pane container-fluid" id="tab_addreview">
				<h2><i class="fa fa-commenting fa-lg"></i> 新增審查表單</h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"review"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'addform');?>
				<div class="repeat_reviewer">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td width="10%" colspan="4"><span class="add btn btn-success">新增審查表單</span></td>
						</tr>
					</thead>
					<tbody class="container">
						<tr class="template row">
							<td width="10%"><span class="move btn btn-info">移動</span></td>
							<td width="80%">
								<dl>
									<dt>審查項目</dt>
									<dd><input type="text" name="review_form_title[{{row-count-placeholder}}]" class="form-control"></dd>
								</dl>
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<td width="10%" colspan="4"><span class="add btn btn-success">新增元素</span></td>
										</tr>
									</thead>
									<tbody class="container">
									<tr class="template row">
										<td width="10%"><span class="move btn btn-info">移動</span></td>
								
										<td width="80%">
											<dl>
												<dt>元素</dt>
												<dd><input type="text" name="element_name[{{row-count-placeholder}}][]" class="form-control"></dd>
											</dl>

											<dl>
												<dt>分數</dt>
												<dd><input type="text" name="element_value[{{row-count-placeholder}}][]" class="form-control"></dd>
											</dl>
										</td>
										<td width="10%"><span class="remove btn btn-danger">刪除</span></td>
									</tr>
									</tbody>
								</table>
							</td>
							<td width="10%"><span class="remove btn btn-danger">刪除</span></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="form-group">
					<input type="submit" name="submit_1" value="更新表單" class="ui button blue">
				</div>
				<?php echo form_close()?>
			</div><!-- #tab_addreview -->
			<div class="tab-pane container-fluid" id="tab_recommend">
				<h2><i class="fa fa-star fa-lg"></i> 推薦表單</h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"review"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'updaterecommend');?>
				<div class="repeat_reviewer">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>推薦項目</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($recommend_forms as $key => $recommend) {?>
						<tr>
							<td width="80%">
								<input type="text" name="recommend_form_title[]" class="form-control" value="<?php echo $recommend->recommend_form_title?>">
								<input type="hidden" name="recommend_form_name[]" value="<?php echo $recommend->recommend_form_name?>">
							</td>
							<td width="20%">
								<span class="move ui black button mini">
									<i class="fa fa-arrows-alt"></i>
								</span>
								<span class="ui button red mini">刪除</span>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				</div>
				<div class="form-group">
					<input type="submit" name="submit_1" value="更新表單" class="ui button blue">
				</div>
				<?php echo form_close()?>
			</div><!-- #tab_recommend -->
			<div class="tab-pane container-fluid" id="tab_addrecommend">
				<h2><i class="fa fa-star fa-lg"></i> 新增推薦表單</h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"review"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'addrecommend');?>
				<div class="repeat_reviewer">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td width="10%" colspan="4">
								<span class="add btn btn-success">新增審查表單</span>
							</td>
						</tr>
						<tr>
							<td>推薦項目</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr class="template">
							<td width="80%">
								<input type="text" name="recommend_form_title[]" class="form-control">
							</td>
							<td width="20%">
								<span class="move ui black button mini">
									<i class="fa fa-arrows-alt"></i>
								</span>
								<span class="remove ui button red mini">刪除</span>
							</td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="form-group">
					<input type="submit" name="submit_1" value="更新表單" class="ui button blue">
				</div>
				<?php echo form_close()?>
			</div><!-- #tab_addrecommend -->
		</div><!-- .tab-content -->
	</div>
</div>
</div>

<script>
$(function() { 
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('<?php echo $conf_config['conf_id'];?>_confreview', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('<?php echo $conf_config['conf_id'];?>_confreview');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	};
	$('.repeat_reviewer').each(function() {
		$(this).repeatable_fields({
			wrapper: 'table',
			container: 'tbody',
		});
	});
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#review_form',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>