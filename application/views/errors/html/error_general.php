<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="x-frame-options" content="deny">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Error</title>
<link href="<?php echo config_item('base_url');?>assets/style/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo config_item('base_url');?>assets/style/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo config_item('base_url');?>assets/style/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body class="container">
	<div class="jumbotron">
		<h1><i class="fa fa-exclamation-triangle"></i> <?php echo $heading; ?></h1>
		<div class="container">
			<?php echo $message; ?>
  		</div>
	</div>
</body>
</html>