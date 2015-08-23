<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui message <?php echo $class;?>">
	<?php echo $text;?>
	<?php if($refresh != -1){?>
	<meta http-equiv="refresh" content="2; <?php echo $refresh?>">
	<?php }?>
</div>