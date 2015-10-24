<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(empty($to)){?>
<meta http-equiv="refresh" content="<?php echo $refresh?>" />
<?php }else{?>
<meta http-equiv="refresh" content="<?php echo $refresh?>; url=<?php echo $to?>" />
<?php }?>