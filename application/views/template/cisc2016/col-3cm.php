<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="am-u-md-3">
	<?php foreach ($col_sidebar_1 as $key => $col_s1) {include("conf/".$col_s1.".php");}?>
</div>
<div class="am-u-md-6">
	<?php foreach ($col_index as $key => $col_i) { include("conf/".$col_i.".php");}?>
</div>
<div class="am-u-md-3">
	<?php foreach ($col_sidebar_2 as $key => $col_s2) {include("conf/".$col_s2.".php");}?>
</div>