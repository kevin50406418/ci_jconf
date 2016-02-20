<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	</div>
	<br>
	<div class="text-right">
		<div class="ui buttons">
			<div class="ui button<?php if($this->user->get_nowlang() == "zhtw"){?> positive<?php }?>" id="chlang_zh">中文</div>
			<div class="or"></div>
			<div class="ui button<?php if($this->user->get_nowlang() == "en"){?> positive<?php }?>" id="chlang_en">English</div>
		</div>
	</div>
</div>
<div id="chlang"></div>
<footer class="footer text-center">
	<p><?php echo $this->config->item('site_name');?> © Jingxun Lai. All rights reserved.</p>
</footer>
<?php echo $this->assets->show_js(true);?>
<script>
$(function(){$("#chlang_zh").click(function(){$.get("<?php echo site_url("clang/zh")?>",function(result){$("#chlang").html(result);});});$("#chlang_en").click(function(){$.get("<?php echo site_url("clang/en")?>",function(result){$("#chlang").html(result);});});});
</script>
<!-- <?php echo $this->config->item('version');?> -->
</body>
</html>
