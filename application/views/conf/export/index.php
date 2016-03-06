<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div id="msg"></div>
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_paperlist" data-toggle="tab"> 投稿清單 </a> </li>
			<li> <a href="#tab_papers" data-toggle="tab"> 投稿匯出 </a> </li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_paperlist">
				<?php echo form_open(get_url("dashboard",$conf_id,"export_download"),array("target"=>"_blank"))?>
				<table class="table table-bordered">
					<tr>
						<th>投稿主題</th>
						<td>
							<button type="button" id="topic_all" class="btn btn-xs btn-primary">全選</button>
							<?php foreach ($topics as $key => $topic) {?>
							<div class="checkbox">
								<label>
									<input name="topic[]" class="topic" type="checkbox" value="<?php echo $topic->topic_id?>">
									<?php echo $topic->topic_name?> (<?php echo $topic->topic_name_eng?>)
								</label>
							</div>
							<?php }?>
						</td>
					</tr>
					<tr>
						<th>投稿狀態</th>
						<td>
							<button type="button" id="status_all" class="btn btn-xs btn-primary">全選</button>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="-3"> <?php echo lang('status_delete')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="-2"> <?php echo lang('status_reject')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="-1"> <?php echo lang('status_editing')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="1"> <?php echo lang('status_submitcomplete')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="2"> <?php echo lang('status_pending')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="3"> <?php echo lang('status_review')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="4"> <?php echo lang('status_accepte')?>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input name="status[]" class="status" type="checkbox" value="5"> <?php echo lang('status_complete')?>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>匯出格式</th>
						<td>
							<label class="radio-inline">
								<input type="radio" name="format" value="pdf" required> <i class="fa fa-file-pdf-o fa-lg"></i> PDF
							</label>
							<label class="radio-inline">
								<input type="radio" name="format" value="xls" required> <i class="fa fa-file-excel-o fa-lg"></i> Excel
							</label>
							<label class="radio-inline">
								<input type="radio" name="format" value="csv" required> <i class="fa fa-file-excel-o fa-lg"></i> CSV
							</label>
						</td>
					</tr>
					<tr>
						<th>匯出檔名</th>
						<td>
							<input type="text" class="form-control" name="filename">
							<span class="help-block">不用填寫副檔名</span>
						</td>
					</tr>
				</table>
				<?php echo form_hidden('type', 'paperlist');?>
				<div class="text-center">
					<button id="submit_paperlist" type="submit" class="ui button blue">匯出</button>
					<button id="btn_preview_paperlist" type="button" class="ui button green">預覽</button>
				</div>
				<?php echo form_close()?>
				<br>
				<div id="preview_paperlist"></div>
			</div><!-- .tab-pane -->
			<div class="tab-pane container-fluid" id="tab_papers">
				<?php echo form_open(get_url("dashboard",$conf_id,"export_download"),array("target"=>"_blank"))?>
				<table class="table table-bordered">
					<tr>
						<th class="col-md-2">匯出檔名</th>
						<td class="col-md-10">
							<div class="input-group">
								<input type="text" class="form-control" name="filename">
								<span class="input-group-addon">.zip</span>
							</div>
							<span class="help-block">不用填寫副檔名</span>
						</td>
					</tr>
				</table>
				<?php echo form_hidden('type', 'finishfiles');?>
				<div class="text-center">
					<button id="submit_papers" type="submit" class="ui button blue">匯出</button>
					<button id="btn_preview_papers" type="button" class="ui button green">預覽</button>
				</div>
				<?php echo form_close()?>
				<br>
				<div id="preview_papers"></div>
			</div>
		</div><!-- .tab-content -->
	</div>
</div>
</div>
<script>
$(function(){
	var topic_cnt = 1;
	var status_cnt = 1;
	$("#topic_all").click(function() {
		$(".topic").prop("checked", topic_cnt%2);
		if( topic_cnt%2 ){
			$("#topic_all").text("取消全選").removeClass('btn-primary').addClass('btn-danger');
		}else{
			$("#topic_all").text("全選").removeClass('btn-danger').addClass('btn-primary');
		}
		topic_cnt++;
	});
	$("#status_all").click(function() {
		$(".status").prop("checked", status_cnt%2);
		if( status_cnt%2 ){
			$("#status_all").text("取消全選").removeClass('btn-primary').addClass('btn-danger');
		}else{
			$("#status_all").text("全選").removeClass('btn-danger').addClass('btn-primary');
		}
		status_cnt++;
	});
	$("#btn_preview_paperlist").click(function(){
		$.post('<?php echo site_url("ajax/paperlist/".$this->conf_id);?>', $( "#tab_paperlist form" ).serialize(), function(data) {
			$("#preview_paperlist").html(data);
		});
	});
	$("#btn_preview_papers").click(function(){
		$.post('<?php echo site_url("ajax/finishpapers/".$this->conf_id);?>', $( "#tab_papers form" ).serialize(), function(data) {
			$("#preview_papers").html(data);
		});
	});
});
</script>