<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
編號,題目,主題,投稿狀態,贊助計畫,關鍵字,投稿帳號
<?php foreach ($papers as $key => $paper) {?>
"<?php echo $paper->sub_id?>","<?php echo $paper->sub_title?>","<?php echo $paper->topic_name?>","<?php echo $paper->sub_status?>","<?php echo $paper->sub_sponsor?>","<?php echo $paper->sub_keyword?>","<?php echo $paper->sub_user?>"
<?php }?>

