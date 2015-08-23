<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>alert("<?php echo $text;?>");</script>
<?php if($refresh!=-1){?>
<meta http-equiv="refresh" content="0; url=<?php echo $refresh?>" />
<?php }?>