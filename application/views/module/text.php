<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui raised segments">
	<?php if($module_showtitle){?>
	<div class="ui segment">
		<h3 class="ui header"><?php echo $module_title?></h3>
	</div>
	<?php }?>
	<div class="ui segment">
		<?php echo $module_content?>
	</div>
</div>
