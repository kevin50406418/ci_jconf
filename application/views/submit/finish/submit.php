<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment text-center">
	<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
	<button name="submit" value="finish" class="btn btn-success btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> 完稿送出</button>
	<?php echo form_close()?>
</div>
