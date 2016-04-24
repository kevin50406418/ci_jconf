<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui blue segment">
<?php echo form_open(get_url("dashboard",$conf_id,"submit","email",$paper->sub_id))?>
<table class="table table-bordered">
	<tr>
		<th>主旨</th>
		<td>
			<input name="subject" type="text" class="form-control">
		</td>
	</tr>
	<tr>
		<th>TO:</th>
		<td>
			<?php if(!empty($authors)){?>
			<?php foreach ($authors as $key => $author) {?>
				<?php if( $author->main_contract ){?>
				<span class="ui blue label"><?php echo $author->user_email?>(<?php echo $author->user_first_name?> <?php echo $author->user_last_name?>)</span>
				<?php }?>
			<?php }?>
			<?php }?>	
		</td>
	</tr>
	<tr>
		<th>內容</th>
		<td>
			<textarea name="message" class="form-control ckeditor"></textarea>
		</td>
	</tr>
</table>
<div class="text-center">
	<button type="submit" class="ui button blue">發送信件</button>
</div>
<?php echo form_close()?>
</div>