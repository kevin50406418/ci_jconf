<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo form_open(get_url("reviewer",$conf_id,"detail",$paper->sub_id),array("class"=>"ui segment raised orange"))?>
	<div class="modal-header">
		<h4 class="modal-title">審查稿件</h4>
	</div>
	<div class="modal-body">
		<?php echo validation_errors('<div class="ui message red">', '</div>');?>
		<div class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">審查人</label>
				<div class="col-sm-10">
					<p class="form-control-static"><?php echo $review->user_login?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">審查狀態</label>
				<div class="col-sm-10">
					<select class="form-control" name="review_status">
						<option>請選擇</option>
						<option value="-2"<?php if( $review->review_status == -2){?> class="bg-info" selected<?php }?>>拒絕</option>
						<option value="2"<?php if( $review->review_status == 2){?> class="bg-info" selected<?php }?>>大會待決</option>
						<option value="4"<?php if( $review->review_status == 4){?> class="bg-info" selected<?php }?>>接受</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">審查建議</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="review_comment"><?php echo $review->review_comment?></textarea>
					<span class="help-block">不支援html語法</span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="ui button blue">送出審查建議</button>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close()?>
