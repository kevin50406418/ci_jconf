<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-6">
	<?php $this->module->get_module($conf_id,"content","zhtw")?>
</div>
<div class="col-md-3">
	<?php $this->module->get_module($conf_id,"sidebar-1","zhtw")?>
</div>
<div class="col-md-3">
	<?php $this->module->get_module($conf_id,"sidebar-2","zhtw")?>
</div>