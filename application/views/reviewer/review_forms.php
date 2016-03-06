<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment">
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
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th class="text-center col-sm-1">N0</th>
				<th class="text-center col-sm-5">審查項目</th>
				<th class="text-center col-sm-5">評分</th>
				<th class="text-center col-sm-1">分數</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($review_responses as $key => $form) {?>
			<tr>
				<th class="text-center"><?php echo $key+1?></th>
				<td><?php echo $form->review_form_title?></td>
				<td class="text-center">
					<?php foreach ($form_elements[$form->review_form_id] as $key2 => $element) {?>
					<label class="radio-inline">
						<input class="score" type="radio" value="<?php echo $element["element_value"]?>" disabled<?php if( $form->element_value == $element["element_value"] ){?> checked<?php }?>> <?php echo $element["element_name"]?>
					</label>
					<?php }?>
				</td>
				<td class="text-center">
					<?php echo $form->element_value?>
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
			<?php foreach ($review_recommends as $key => $recommend) {?>
			<tr>
				<td><?php echo $recommend->recommend_form_title?></td>
				<td class="text-center">
					<input type="radio" disabled<?php if( $recommend->response_value == 1 ){?> checked<?php }?>>
				</td>
				<td class="text-center">
					<input type="radio" disabled<?php if( $recommend->response_value == 0 ){?> checked<?php }?>>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<h4>審查意見：(限輸入500字 ，若無建議可無需輸入)</h4>
	<div class="form-group">
		<textarea class="form-control" disabled><?php echo $review->review_comment?></textarea>
	</div>
</div>
