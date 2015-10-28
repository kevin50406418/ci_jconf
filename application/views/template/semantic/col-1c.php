<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<?php foreach ($col_index as $key => $col_i) {
		include("conf/".$col_i.".php");
	}?>
</div>