<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function () {
	$('.chosen-select').chosen({no_results_text: "找不到國家"});
	$('#addr_6').twzipcode({
		'zipcodeSel': '<?php echo $user->user_postcode?>',
		'css': ['form-control', 'form-control', 'form-control'],
		zipcodeName: 'user_postcode',
		countyName: 'user_addcounty',
		districtName: 'user_area'
	});
});
</script>
