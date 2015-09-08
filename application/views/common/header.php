<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
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
<title>亞大研討會系統</title>
<?php echo $this->assets->show_meta()?>
<!--<link rel="shortcut icon" href="favicon.ico" />-->
<?php echo $this->assets->show_css();?>
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php echo $this->assets->show_js();?>
<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
})
</script>
<script src="https://use.typekit.net/wnd2iaa.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>

<body>