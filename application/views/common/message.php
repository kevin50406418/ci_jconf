<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui message <?php echo $class;?><?php if($icon != "-"){?> icon<?php }?>">
	<?php if($icon != "-"){?>
		<i class="fa fa-<?php echo $icon;?> icon"></i>
	<div class="content">
	<?php }?>
	<div class="header">
		<?php echo $header;?>
	</div>
	<?php echo $text;?>
	<?php if($refresh != -1){?>
	<meta http-equiv="refresh" content="2; <?php echo $refresh?>">
	<?php }?>
	<?php if($icon != "-"){?>
	</div>
	<?php }?>
</div>