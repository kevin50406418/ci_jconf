<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	</div>
</div>
<div class="clear"></div>
<footer class="ui inverted vertical footer segment">
	<div class="container-fluid">
		<h3 class="ui inverted header"><?php echo $conf_config['conf_name']?></h3>
		<div class="ui stackable inverted divided grid">
	        <div class="four wide column">
				<p>主辦單位：<?php echo $conf_config['conf_host']?></p>
				<p>E-Mail：<?php echo $conf_config['conf_email']?></p>
				<p>聯絡電話：<?php echo $conf_config['conf_phone']?></p>
				<p>地址：<?php echo $conf_config['conf_address']?></p>
				<p><i class="fa fa-map-marker fa-lg"></i> 大會地點：<?php echo $conf_config['conf_place']?></p>
	        </div>
	    </div>
	</div>
</footer>
</body>
</html>