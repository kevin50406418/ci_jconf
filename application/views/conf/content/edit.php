<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo validation_errors('<div class="ui message red">', '</div>');?>
<?php echo form_open(get_url("dashboard",$conf_id,"website","edit")."?id=".$content->page_id."&lang=".$content->page_lang,array("class"=>"form-horizontal"))?>
<div class="ui segment">
	<div class="modal-header">
			<div class="ui buttons pull-right">
				<a class="ui button blue" href="<?php echo get_url("dashboard",$conf_id,"website")?>"><i class="fa fa-chevron-circle-left fa-lg"></i> 返回</a>
				<?php if(in_array("zhtw",$conf_lang)){?><a class="ui button orange<?php if($content->page_lang != "zhtw"){?> basic<?php }?>" href="<?php echo get_url("dashboard",$conf_id,"website","edit")."?id=".$content->page_id."&lang=zhtw"?>">中文</a><?php }?>
				<?php if(in_array("en",$conf_lang)){?><a class="ui button orange<?php if($content->page_lang != "en"){?> basic<?php }?>" href="<?php echo get_url("dashboard",$conf_id,"website","edit")."?id=".$content->page_id."&lang=en"?>">English</a><?php }?>
				<a class="ui button teal" href="<?php echo get_url("about",$conf_config['conf_id'],$content->page_id);?>">查看網頁</a>
			</div>
		<h4 class="modal-title">編輯網頁 - <?php echo $content->page_title?>(<?php echo $content->page_id?>)</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">標題</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="page_title" name="page_title" value="<?php echo $content->page_title?>">
			</div>
		</div>
		<?php
			$spage_key_index = array_search("index", $spage); unset($spage[$spage_key_index]);
		?>
		<?php if( $content->page_edit && !in_array($content->page_id,$spage) ){?>
		<div class="form-group">
			<label for="econtent" class="col-sm-2 control-label">網頁內容</label>
			<div class="col-sm-10">
				<textarea name="page_content" rows="50" class="form-control ckeditor" id="page_content"><?php echo $content->page_content?></textarea>
			</div>
		</div>
		<?php }?>
	</div>
	<div class="text-center">
		<input type="submit" id="add" value="更新" class="ui button teal">
	</div>
</div>

<?php echo form_close()?>
<script>
CKEDITOR.replace( 'page_content', {
	filebrowserBrowseUrl: '<?php echo site_url($this->conf_id."/file/")?>',
	filebrowserImageBrowseUrl: '<?php echo site_url($this->conf_id."/file/image")?>'
});
</script>