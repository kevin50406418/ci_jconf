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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo template_url('semantic','semantic.min.js')?>" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>
$(function(){
	$('.dropdown').dropdown();
});
</script>
</head>
<body>
<div class="ui menu inverted fixed">
	<a class="item"><?php echo $conf_config['conf_name']?></a>
	<?php foreach ($conf_content as $key => $content) {?>
		<?php if($key < 9){?>
			<?php if(in_array($content->page_id,$spage)){?>
			<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a>
			<?php }else{?>
			<?php $pg_id = $this->uri->segment(3);?>
			<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
			<?php }?>
		<?php }?>
	<?php }?>
	<?php if(count($conf_content)>8){?>
	<div class="ui dropdown item">
		其他資訊 <i class="dropdown icon"></i>
		<div class="menu">
			<?php foreach ($conf_content as $key => $content) {?>
				<?php if($key > 8){?>
					<?php if(in_array($content->page_id,$spage)){?>
					<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url($content->page_id,$conf_config['conf_id']);?>"><?php echo $content->page_title?></a>
					<?php }else{?>
					<?php $pg_id = $this->uri->segment(3);?>
					<a class="item <?php echo active_confnav($pg_id,$content->page_id,"active")?>" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>"><?php echo $content->page_title?></a>
					<?php }?>
				<?php }?>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="right menu">
		<?php if( is_login() ){?>
		<div class="item">您好，<?php echo get_current_user_login()?></div>
        <?php }else{?>
        <div class="item">
        	<a href="<?php echo base_url("user/login")?>" class="ui teal button">登入</a>
        </div>
        <?php }?>
    </div>
</div>
<div class="container-fluid" id="content">
<div class="row">