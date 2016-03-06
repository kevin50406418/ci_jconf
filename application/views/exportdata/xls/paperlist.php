<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8" />
<title>Excel</title>
</head>
<body>
<table border="1" class="table table-bordered table-hover">
	<tr>
		<th>編號</th>
		<th>題目</th>
		<th>主題</th>
		<th>投稿狀態</th>
		<th>贊助計畫</th>
		<th>關鍵字</th>
		<th>投稿帳號</th>
	</tr>
	<?php foreach ($papers as $key => $paper) {?>
	<tr>
		<td><?php echo $paper->sub_id?></td>
		<td><?php echo $paper->sub_title?></td>
		<td><?php echo $paper->topic_name?></td>
		<td><?php echo $this->submit->sub_status($paper->sub_status,false,true)?></td>
		<td><?php echo $paper->sub_sponsor?></td>
		<td><?php echo $paper->sub_keyword?></td>
		<td><?php echo $paper->sub_user?></td>
	</tr>
	<?php }?>
</table>
</body>
</html>