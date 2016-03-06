<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo form_open(get_url("reviewer",$conf_id,"detail",$paper->sub_id),array("class"=>"ui segment raised orange"))?>
	<div class="modal-header">
		<h4 class="modal-title">審查稿件</h4>
	</div>
	<div class="modal-body">
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>
		<table class="table table-bordered">
			<tr>
				<th class="col-md-2">論文編號</th>
				<td class="col-md-10"><?php echo $paper->sub_id?></td>
			</tr>
			<tr>
				<th>論文名稱</th>
				<td><?php echo $paper->sub_title?></td>
			</tr>
			<tr>
				<th>審查人</th>
				<td><?php echo $review->user_login?></td>
			</tr>
			<tr>
				<th>審查狀態</th>
				<td><?php echo $this->reviewer->review_status($review->review_status)?></td>
			</tr>
		</table>
		<h4>請在下列各項審查項目上，勾選您的意見</h4>
		<div class="ui info message">
			<div class="header">
				評分說明
			</div>
			<ul class="list">
				<li>80 分以上(含80分)為 強烈建議接受</li>
				<li>70 - 79 分為 勉予接受</li>
				<li>60 - 69 分為 接受邊界</li>
				<li>59 分以下為 拒絕接受</li>
				<li>總分69 分以下請務必明確加註審查意見，以利作者修訂論文</li>
			</ul>
		</div>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="text-center col-sm-1">N0</th>
					<th class="text-center col-sm-6">審查項目</th>
					<th class="text-center col-sm-5">評分</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($review_forms as $key => $form) {?>
				<tr>
					<th class="text-center"><?php echo $key+1?></th>
					<td><?php echo $form->review_form_title?></td>
					<td class="text-center">
						<?php foreach ($form_elements[$form->review_form_id] as $key2 => $element) {?>
						<label class="radio-inline" for="<?php echo $form->review_form_name?>_<?php echo $key2?>">
							<input id="<?php echo $form->review_form_name?>_<?php echo $key2?>" class="score" type="radio" value="<?php echo $element["element_value"]?>" name="<?php echo $form->review_form_name?>"> <?php echo $element["element_name"]?>
						</label>
						<?php }?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<h4>論文及期刊推薦</h4>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="text-center col-sm-10">推薦項目</th>
					<th class="text-center col-sm-1">是</th>
					<th class="text-center col-sm-1">否</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($recommend_forms as $key => $recommend) {?>
				<tr>
					<td><?php echo $recommend->recommend_form_title?></td>
					<td class="text-center">
						<input type="radio" value="1" name="<?php echo $recommend->recommend_form_name?>">
					</td>
					<td class="text-center">
						<input type="radio" value="0" name="<?php echo $recommend->recommend_form_name?>">
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<h4>審查意見：(限輸入500字 ，若無建議可無需輸入)</h4>
		<div class="form-group">
			<textarea id="review_comment" class="form-control" name="review_comment" row="5"><?php echo $review->review_comment?></textarea>
			<span class="help-block">不支援html語法</span>
			<span id="msg_require" class="text-danger text-bold"></span>
		</div>
		<div class="text-center">
			<button type="submit" class="ui button blue">送出審查建議</button>
		</div>
	</div>
<?php echo form_close()?>
