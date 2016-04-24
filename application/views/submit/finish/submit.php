<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment">
	<?php echo validation_errors();?>
	<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
		<?php if( is_array($agrees) ){?>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center col-md-10">項目</th>
					<th class="text-center col-md-2">選項</th>
				</tr>
			</thead>
			<?php foreach ($agrees as $key => $agree) {?>
			<tr>
				<td>
					<?php echo $agree->agree_content?> <span class="text-danger">*</span>
				</td>
				<td class="text-center">
					<label class="radio-inline" for="agree_true<?php echo $key?>">
						<input id="agree_true<?php echo $key?>" type="radio" name="<?php echo $agree->agree_token?>" value="1">
						<?php echo $agree->agree_true?>
					</label>
					<label class="radio-inline" for="agree_false<?php echo $key?>">
						<input id="agree_false<?php echo $key?>" type="radio" name="<?php echo $agree->agree_token?>" value="0">
						<?php echo $agree->agree_false?>
					</label>
				</td>
			</tr>
			<?php }?>
		</table>
	<?php }?>
	<div class="text-center">
		<button name="submit" value="finish" class="btn btn-success btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> 完稿送出</button>
	</div>
	<?php echo form_close()?>
</div>
