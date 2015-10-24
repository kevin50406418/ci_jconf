<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
$pg_id = $this->uri->segment(2);
?>
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
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $conf_config['conf_name']?></title>
<?php echo $this->assets->show_meta()?>
<?php echo link_tag(asset_url().'style/font-awesome.min.css');?>
<?php echo link_tag(template_url('semantic','bootstrap.min.css'));?>
<?php echo link_tag(template_url('semantic','semantic.min.css'));?>
<?php echo link_tag(template_url('semantic','style.css'));?>
</head>
<body>
<div class="ui fixed menu inverted">
	<div class="container">
		<a class="item"><i class="fa fa-bookmark fa-lg"></i> <?php echo $conf_config['conf_name']?></a>
		<?php foreach ($conf_content as $key => $content) {?>
			<?php if(in_array($content->page_id,$spage)){?>
			<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a>
			<?php }else{?>
			<?php $pg_id = $this->uri->segment(3);?>
			<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
			<?php }?>
		<?php }?>
	</div>
</div>